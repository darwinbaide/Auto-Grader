<?php


//echo " I am in the new edit ised with filezilla";
$tosend = array(
       'version' => 'doGrade',
       'testname' => 'colon2',
       'studentname' => 'ksl26'
        ); 
	$searchCH= curl_init(); 
	curl_setopt($searchCH, CURLOPT_URL, "https://web.njit.edu/~djb58/cs490/execphp.php");
	curl_setopt($searchCH, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($searchCH, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
	curl_setopt($searchCH, CURLOPT_POST, true); 
	
	curl_setopt($searchCH, CURLOPT_POSTFIELDS, $tosend); 
	$output =curl_exec($searchCH); 
	curl_close($searchCH);
	echo $output;
	echo "\n";
	//echo "\n 		-*-*-*- went to remote -*-*-*- \n";
 
 
 
 
 
?>