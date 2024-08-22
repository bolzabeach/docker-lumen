<?php

	$Authorization = md5(date("Ymd")); 

//	CREATE using CURL command line

/*
	curl -X PUT http://localhost/attribute/
	     -H 'Content-Type: application/json'
	     -H 'Accept: application/json'
	     -H 'X-Token: <?php echo $Authorization; ?>'
	     -d '{"attribute": "Ingegnere", "profile_id": 1}'
*/


//	CREATE using PHP Curl

	$PostFields = [
		"attribute"=>"Ingegnere",
		"profile_id"=>1
	];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "http://localhost/attribute/");
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
