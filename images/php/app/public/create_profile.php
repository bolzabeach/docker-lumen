<?php

	$Authorization = md5(date("Ymd")); 

//	CREATE using CURL command line

/*
	curl -X PUT http://localhost/profile/
	     -H 'Content-Type: application/json'
	     -H 'Accept: application/json'
	     -H 'X-Token: <?php echo $Authorization; ?>'
	     -d '{"name": "Paolo", "lastname": "Rossi", "phone": "+413311002167"}'
*/


//	CREATE using PHP Curl

	$PostFields = [
		"name"=>"Paolo",
		"lastname"=>"Rossi",
		"phone"=>"+413311002167"
	];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "http://localhost/profile/");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($PostFields));

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "X-Token: ".$Authorization
    ));

    $response = curl_exec($ch);
    curl_close($ch);;

    print_r($response);
