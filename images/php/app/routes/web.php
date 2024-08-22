<?php

/** @var \Laravel\Lumen\Routing\Router $router */

    use Illuminate\Http\Request;

//  ------------------------------------------------------------------------------------
//  GET api controller page
//  ------------------------------------------------------------------------------------
//    $router->get('/', function () use ($router) {
//        return $router->app->version();
//    });

    $router->get('/', function () use ($router) {

    //  Carico i profiles
        $Query = "
            SELECT
            profiles.*
            FROM profiles
        ";
        $profiles = app('db')->connection('mysql')->select($Query);

    //  Carico gli attributes
        $Query = "
            SELECT
            profile_attributes.*
            FROM profile_attributes
        ";
        $attributes = app('db')->connection('mysql')->select($Query);

    //  Carico il log
        $logobj = [];
        $log = @file_get_contents($_SERVER["DOCUMENT_ROOT"]."/../storage/logs/access.log");
        $loglines = explode("\n",$log);
        foreach($loglines as $logline){
            if(strlen("".$logline)>0){
                $logitems = explode("\t",$logline);
                $logobj[] = (object)['date'=>$logitems[0],'method'=>$logitems[1],'uri'=>$logitems[2]];
            }
        }

        return view('api_controller', ['logs' => $logobj, 'profiles' => $profiles, "attributes" => $attributes]);

    });

//  ------------------------------------------------------------------------------------
//  GET all profiles
//  ------------------------------------------------------------------------------------
    $router->get('/profile/', ['middleware' => 'Log', function () use ($router) {

        $Query = "
            SELECT
            profiles.*,
            (SELECT CONCAT('[',
                GROUP_CONCAT(
                    JSON_OBJECT(
                      'id', profile_attributes.id,
                      'name', profile_attributes.attribute
                    )
                ),']')
                FROM profile_attributes 
                WHERE profile_attributes.profile_id=profiles.id 
                ORDER BY profile_attributes.id
            ) AS attributes
            FROM profiles
        ";
        $results = app('db')->connection('mysql')->select($Query);

    //  Converto la stringa json degli attributi in oggetto
        foreach($results as $result){
            $result->attributes = json_decode($result->attributes);
        }

        return response()->json($results);

    }]);

//  ------------------------------------------------------------------------------------
//  GET single profile
//  ------------------------------------------------------------------------------------
    $router->get('/profile/{id}/', ['middleware' => 'Log', function ($id) use ($router) {

        if(isset($id) && is_numeric($id)){

            $Query = "
                SELECT
                profiles.*,
                (SELECT CONCAT('[',
                    GROUP_CONCAT(
                        JSON_OBJECT(
                          'id', profile_attributes.id,
                          'name', profile_attributes.attribute
                        )
                    ),']')
                    FROM profile_attributes 
                    WHERE profile_attributes.profile_id=profiles.id 
                    ORDER BY profile_attributes.id
                ) AS attributes
                FROM profiles
                WHERE profiles.id=".SqlClean($id)."
            ";

            $results = app('db')->connection('mysql')->select($Query);

        //  Converto la stringa json degli attributi in oggetto
            foreach($results as $result){
                $result->attributes = json_decode($result->attributes);
            }

            return response()->json($results);

        } else {

            return response()->json([ "error"=>"Numeric Id expected" ]);

        }

    }]);


//  ------------------------------------------------------------------------------------
//  DELETE single profile
//  ------------------------------------------------------------------------------------
    $router->delete('/profile/{id}/', ['middleware' => 'Log', function (Request $request,$id) use ($router) {

    //  Check if token is valid
        if(null!==$request->headers->get('x-token') && $request->headers->get('x-token')==md5(date("Ymd"))){

        //  Check if id is numeric
            if(isset($id) && is_numeric($id)){

            //  Update
                $Query = "
                    DELETE FROM profile 
                    WHERE id=".SqlClean($id);

                $results = app('db')->connection('mysql')->select($Query);
                
            //  Return succesful
                return response()->json([ "message"=>"Deleted" ]);

            } else {

            //  Return error
                return response()->json([ "error"=>"Numeric Id expected" ]);

            }

        } else {

        //  Return error
            return response()->json([ "error"=>"Invalid token" ]);

        }

    }]);


//  ------------------------------------------------------------------------------------
//  UPDATE single profile
//  ------------------------------------------------------------------------------------
    $router->patch('/profile/{id}/', ['middleware' => 'Log', function (Request $request,$id) use ($router) {

    //  Check if token is valid
        if(null!==$request->headers->get('x-token') && $request->headers->get('x-token')==md5(date("Ymd"))){

        //  Check if id is numeric
            if(isset($id) && is_numeric($id)){

            //  Get Name
                if(null!==$request->request->get('name') && strlen("".$request->request->get('name'))>0){
                    $Name = $request->request->get('name');
                } else {
                    return response()->json([ "error"=>"Name can not be empty string" ]);
                }

            //  Get Lastname
                if(null!==$request->request->get('lastname') && strlen("".$request->request->get('lastname'))>0){
                    $Lastname = $request->request->get('lastname');
                } else {
                    return response()->json([ "error"=>"Lastname can not be empty string" ]);
                }

            //  Get Phone
                if(null!==$request->request->get('phone') && strlen("".$request->request->get('phone'))>0){
                    $Phone = $request->request->get('phone');
                    $Phone = RemoveInternationalPrefix(str_ireplace(" ","",$Phone));
                    
                //  Phone is valid?
                    if(!is_numeric($Phone)){
                        return response()->json([ "error"=>"Invalid phone number" ]);
                    }
                } else {
                    return response()->json([ "error"=>"Phone can not be empty string" ]);
                }

            //  Update
                $Query = "
                    UPDATE profiles 
                    SET 
                    name='".SqlClean($Name)."', 
                    lastname='".SqlClean($Lastname)."', 
                    phone='".SqlClean($Phone)."',
                    ts_modification='".SqlClean(date("Y-m-d H:i:s"))."' 
                    WHERE id=".SqlClean($id);

                $results = app('db')->connection('mysql')->select($Query);
                
            //  Return succesful
                return response()->json([ "message"=>"Updated" ]);

            } else {

            //  Return error
                return response()->json([ "error"=>"Numeric Id expected" ]);

            }

        } else {

        //  Return error
            return response()->json([ "error"=>"Invalid token" ]);

        }

    }]);


//  ------------------------------------------------------------------------------------
//  CREATE single profile
//  ------------------------------------------------------------------------------------
    $router->put('/profile/', ['middleware' => 'Log', function (Request $request) use ($router) {

    //  Check if token is valid
        if(null!==$request->headers->get('x-token') && $request->headers->get('x-token')==md5(date("Ymd"))){

        //  Get Name
            if(null!==$request->request->get('name') && strlen("".$request->request->get('name'))>0){
                $Name = $request->request->get('name');
            } else {
                return response()->json([ "error"=>"Name can not be empty string" ]);
            }

        //  Get Lastname
            if(null!==$request->request->get('lastname') && strlen("".$request->request->get('lastname'))>0){
                $Lastname = $request->request->get('lastname');
            } else {
                return response()->json([ "error"=>"Lastname can not be empty string" ]);
            }

        //  Get Phone
            if(null!==$request->request->get('phone') && strlen("".$request->request->get('phone'))>0){
                $Phone = $request->request->get('phone');
                $Phone = RemoveInternationalPrefix(str_ireplace(" ","",$Phone));
                
            //  Phone is valid?
                if(!is_numeric($Phone)){
                    return response()->json([ "error"=>"Invalid phone number" ]);
                }
            } else {
                return response()->json([ "error"=>"Phone can not be empty string" ]);
            }

        //  Data to insert
            $Data = [
                "name"=>$Name,
                "lastname"=>$Lastname,
                "phone"=>$Phone
            ];

            $results = app('db')->connection('mysql')->table('profiles')->insertGetId($Data);
            
        //  Return succesful
            return response()->json([ "message"=>"Created", "newid"=>$results ]);

        } else {

        //  Return error
            return response()->json([ "error"=>"Invalid token" ]);

        }

    }]);


//  ------------------------------------------------------------------------------------
//  DELETE single attribute
//  ------------------------------------------------------------------------------------
    $router->delete('/attribute/{id}/', ['middleware' => 'Log', function (Request $request,$id) use ($router) {

    //  Check if token is valid
        if(null!==$request->headers->get('x-token') && $request->headers->get('x-token')==md5(date("Ymd"))){

        //  Check if id is numeric
            if(isset($id) && is_numeric($id)){

            //  Update
                $Query = "
                    DELETE FROM profile_attributes 
                    WHERE id=".SqlClean($id);

                $results = app('db')->connection('mysql')->select($Query);
                
            //  Return succesful
                return response()->json([ "message"=>"Deleted" ]);

            } else {

            //  Return error
                return response()->json([ "error"=>"Numeric Id expected" ]);

            }

        } else {

        //  Return error
            return response()->json([ "error"=>"Invalid token" ]);

        }

    }]);


//  ------------------------------------------------------------------------------------
//  UPDATE single attribute
//  ------------------------------------------------------------------------------------
    $router->patch('/attribute/{id}/', ['middleware' => 'Log', function (Request $request,$id) use ($router) {

    //  Check if token is valid
        if(null!==$request->headers->get('x-token') && $request->headers->get('x-token')==md5(date("Ymd"))){

        //  Check if id is numeric
            if(isset($id) && is_numeric($id)){

            //  Get Attribute
                if(null!==$request->request->get('attribute') && strlen("".$request->request->get('attribute'))>0){
                    $Attribute = $request->request->get('attribute');
                } else {
                    return response()->json([ "error"=>"Attribute can not be empty string" ]);
                }

            //  Update
                $Query = "
                    UPDATE profile_attributes 
                    SET 
                    attribute='".SqlClean($Attribute)."',
                    ts_modification='".SqlClean(date("Y-m-d H:i:s"))."' 
                    WHERE id=".SqlClean($id);

                $results = app('db')->connection('mysql')->select($Query);
                
            //  Return succesful
                return response()->json([ "message"=>"Updated" ]);

            } else {

            //  Return error
                return response()->json([ "error"=>"Numeric Id expected" ]);

            }

        } else {

        //  Return error
            return response()->json([ "error"=>"Invalid token" ]);

        }

    }]);


//  ------------------------------------------------------------------------------------
//  CREATE single attribute
//  ------------------------------------------------------------------------------------
    $router->put('/attribute/', ['middleware' => 'Log', function (Request $request) use ($router) {

    //  Check if token is valid
        if(null!==$request->headers->get('x-token') && $request->headers->get('x-token')==md5(date("Ymd"))){

        //  Get Attribute
            if(null!==$request->request->get('attribute') && strlen("".$request->request->get('attribute'))>0){
                $Attribute = $request->request->get('attribute');
            } else {
                return response()->json([ "error"=>"Attribute can not be empty string" ]);
            }

        //  Get Profile_id
            if(null!==$request->request->get('profile_id') && is_numeric($request->request->get('profile_id'))>0){
                $ProfileId = $request->request->get('profile_id');
            } else {
                return response()->json([ "error"=>"ProfileId should be numeric" ]);
            }

        //  Data to insert
            $Data = [
                "profile_id"=>$ProfileId,
                "attribute"=>$Attribute
            ];

            $results = app('db')->connection('mysql')->table('profile_attributes')->insertGetId($Data);
            
        //  Return succesful
            return response()->json([ "message"=>"Created", "newid"=>$results ]);

        } else {

        //  Return error
            return response()->json([ "error"=>"Invalid token" ]);

        }

    }]);


//  ------------------------------------------------------------------------------------
//  FUNCTIONS
//  ------------------------------------------------------------------------------------

    function SqlClean($String){
        return str_ireplace("'","''",$String."");
    }

    function RemoveInternationalPrefix($Phone){

        return preg_replace('/^(\+?|00)(?:998|996|995|994|993|992|977|976|975|974|973|972|971|970|968|967|966|965|964|963|962|961|960|886|880|856|855|853|852|850|692|691|690|689|688|687|686|685|683|682|681|680|679|678|677|676|675|674|673|672|670|599|598|597|595|593|592|591|590|509|508|507|506|505|504|503|502|501|500|423|421|420|389|387|386|385|383|382|381|380|379|378|377|376|375|374|373|372|371|370|359|358|357|356|355|354|353|352|351|350|299|298|297|291|290|269|268|267|266|265|264|263|262|261|260|258|257|256|255|254|253|252|251|250|249|248|246|245|244|243|242|241|240|239|238|237|236|235|234|233|232|231|230|229|228|227|226|225|224|223|222|221|220|218|216|213|212|211|98|95|94|93|92|91|90|86|84|82|81|66|65|64|63|62|61|60|58|57|56|55|54|53|52|51|49|48|47|46|45|44\D?1624|44\D?1534|44\D?1481|44|43|41|40|39|36|34|33|32|31|30|27|20|7|1\D?939|1\D?876|1\D?869|1\D?868|1\D?849|1\D?829|1\D?809|1\D?787|1\D?784|1\D?767|1\D?758|1\D?721|1\D?684|1\D?671|1\D?670|1\D?664|1\D?649|1\D?473|1\D?441|1\D?345|1\D?340|1\D?284|1\D?268|1\D?264|1\D?246|1\D?242|1)\D?/', '', $Phone);

    }