<?php

	$AttributeToUpdate = 1;
	$Authorization = md5(date("Ymd")); 

//	UPDATE using CURL command line

/*
	curl -X PATCH http://localhost/attribute/<?php echo $AttributeToUpdate; ?>
	     -H 'Content-Type: application/json'
	     -H 'Accept: application/json'
	     -H 'X-Token: <?php echo $Authorization; ?>'
	     -d '{"attribute": "Operaio"}'
*/


//	UPDATE using PHP Curl

	$PostFields = [
		"attribute"=>"Operaio"
	];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "http://localhost/attribute/".$AttributeToUpdate);
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
