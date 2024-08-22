<?php

	$ProfileToUpdate = 1;
	$Authorization = md5(date("Ymd")); 

//	UPDATE using CURL command line

/*
	curl -X PATCH http://localhost/profile/<?php echo $ProfileToUpdate; ?>
	     -H 'Content-Type: application/json'
	     -H 'Accept: application/json'
	     -H 'X-Token: <?php echo $Authorization; ?>'
	     -d '{"name": "Paolo", "lastname": "Rossi", "phone": "+413311002167"}'
*/


//	UPDATE using PHP Curl

	$PostFields = [
		"name"=>"Paolo",
		"lastname"=>"Rossi",
		"phone"=>"+413311002167"
	];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "http://localhost/profile/".$ProfileToUpdate);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($PostFields));

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "X-Token: ".$Authorization
    ));

    $response = curl_exec($ch);
    curl_close($ch);;

    print_r($response);
