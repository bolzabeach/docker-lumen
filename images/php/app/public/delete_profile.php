<?php

	$ProfileToDelete = 4;
	$Authorization = md5(date("Ymd")); 

//	DELETE using CURL command line

/*
	curl -X DELETE http://localhost/attribute/delete/<?php echo $ProfileToDelete; ?>/
	     -H 'Content-Type: application/json'
	     -H 'Accept: application/json'
	     -H 'X-Token: <?php echo $Authorization; ?>'
*/


//	DELETE using PHP Curl

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "http://localhost/profile/".$ProfileToDelete."/");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "X-Token: ".$Authorization
    ));

    $response = curl_exec($ch);
    curl_close($ch);;

    print_r($response);
