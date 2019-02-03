<?php

error_reporting(E_ALL);
ini_set('display_errors',1);
	if($_POST['version'] == 'login'){
 
 
		$fields = array($_POST['j_username'],$_POST['j_password']);
		$ch= curl_init(); 
	
		curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~ksl26/cs490/BETA/release.php");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
		curl_setopt($ch, CURLOPT_POST, true); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST); 
		$output =curl_exec($ch); 
		curl_close($ch);
		echo $output;
	}elseif ($_POST['version'] == 'search') {
		$fields2 = array($_POST['version'],$_POST['Difficulty'],$_POST['Category']);
		$searchCH= curl_init(); 
		curl_setopt($searchCH, CURLOPT_URL, "https://web.njit.edu/~ksl26/cs490/BETA/release.php");
		curl_setopt($searchCH, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($searchCH, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
		curl_setopt($searchCH, CURLOPT_POST, true); 
		curl_setopt($searchCH, CURLOPT_POSTFIELDS, $_POST); 
		$output =curl_exec($searchCH); 
		curl_close($searchCH);
		echo $output;
	}
  
  elseif ($_POST['version'] == 'add') {
	
		//$fields3 = array($_POST['version'],$_POST['Question'],$_POST['p1'],$_POST['version'],$_POST['Question'],$_POST['p1']);

		//r1,p2,r2,p3,r3,questionCat,questionDiff
		$addCH= curl_init(); 
		curl_setopt($addCH, CURLOPT_URL, "https://web.njit.edu/~ksl26/cs490/BETA/release.php");
		//curl_setopt($addCH, CURLOPT_URL, "https://web.njit.edu/~ksl26/cs490/darwin.php");
		curl_setopt($addCH, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($addCH, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
		curl_setopt($addCH, CURLOPT_POST, true); 
		curl_setopt($addCH, CURLOPT_POSTFIELDS, $_POST); 
		$output =curl_exec($addCH); 
		curl_close($addCH);
		echo $output;
	
	}
	elseif ($_POST['version'] == 'makeExam') {
	
		$makeExamCH= curl_init(); 
		curl_setopt($makeExamCH, CURLOPT_URL, "https://web.njit.edu/~ksl26/cs490/BETA/release.php");
		curl_setopt($makeExamCH, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($makeExamCH, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
		curl_setopt($makeExamCH, CURLOPT_POST, true); 
		curl_setopt($makeExamCH, CURLOPT_POSTFIELDS, $_POST); 
		$output =curl_exec($makeExamCH); 
		curl_close($makeExamCH);
		echo $output;
	}
	elseif ($_POST['version'] == 'getExam') {
	
		$getExamCH= curl_init(); 
		curl_setopt($getExamCH, CURLOPT_URL, "https://web.njit.edu/~ksl26/cs490/BETA/release.php");
		curl_setopt($getExamCH, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($getExamCH, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
		curl_setopt($getExamCH, CURLOPT_POST, true); 
		curl_setopt($getExamCH, CURLOPT_POSTFIELDS, $_POST); 
		$output =curl_exec($getExamCH); 
		curl_close($getExamCH);
		echo $output;
	
		//echo var_dump($_POST);
	}
	elseif ($_POST['version'] == 'searchExam') {
	
		$searchExamCH= curl_init(); 
		curl_setopt($searchExamCH, CURLOPT_URL, "https://web.njit.edu/~ksl26/cs490/BETA/release.php");
		curl_setopt($searchExamCH, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($searchExamCH, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
		curl_setopt($searchExamCH, CURLOPT_POST, true); 
		curl_setopt($searchExamCH, CURLOPT_POSTFIELDS, $_POST); 
		$output =curl_exec($searchExamCH); 
		curl_close($searchExamCH);
		echo $output;
		//echo var_dump($_POST);
	}
	elseif ($_POST['version'] == 'submitExam') {
	
	
		$submitExamCH= curl_init(); 
		curl_setopt($submitExamCH, CURLOPT_URL, "https://web.njit.edu/~ksl26/cs490/BETA/release.php");
		curl_setopt($submitExamCH, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($submitExamCH, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
		curl_setopt($submitExamCH, CURLOPT_POST, true); 
		curl_setopt($submitExamCH, CURLOPT_POSTFIELDS, $_POST); 
		$output =curl_exec($submitExamCH); 
		curl_close($submitExamCH);
		echo $output;
		
		
		//echo var_dump($_POST);
		
	}
	elseif ($_POST['version'] == 'studentExam') {
	
	
		$studentExamCH= curl_init(); 
		curl_setopt($studentExamCH, CURLOPT_URL, "https://web.njit.edu/~ksl26/cs490/BETA/release.php");
		curl_setopt($studentExamCH, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($studentExamCH, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
		curl_setopt($studentExamCH, CURLOPT_POST, true); 
		curl_setopt($studentExamCH, CURLOPT_POSTFIELDS, $_POST); 
		$output =curl_exec($studentExamCH); 
		curl_close($studentExamCH);
		echo $output;
	
		Graders($_POST['testname'],$_POST['studentname']);
		//echo var_dump($_POST);
	}

	elseif ($_POST['version'] == 'releaseGrades') {
	
	
		$releaseGradesCH= curl_init(); 
		curl_setopt($releaseGradesCH, CURLOPT_URL, "https://web.njit.edu/~ksl26/cs490/BETA/release.php");
		curl_setopt($releaseGradesCH, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($releaseGradesCH, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
		curl_setopt($releaseGradesCH, CURLOPT_POST, true); 
		curl_setopt($releaseGradesCH, CURLOPT_POSTFIELDS, $_POST); 
		$output =curl_exec($releaseGradesCH); 
		curl_close($releaseGradesCH);
		echo $output;
		
		//echo var_dump($_POST);
	}

	elseif ($_POST['version'] == 'viewGrades') {
	
	
		$releaseGradesCH= curl_init(); 
		curl_setopt($releaseGradesCH, CURLOPT_URL, "https://web.njit.edu/~ksl26/cs490/BETA/release.php");
		curl_setopt($releaseGradesCH, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($releaseGradesCH, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
		curl_setopt($releaseGradesCH, CURLOPT_POST, true); 
		curl_setopt($releaseGradesCH, CURLOPT_POSTFIELDS, $_POST); 
		$output =curl_exec($releaseGradesCH); 
		curl_close($releaseGradesCH);
		echo $output;
		
		//echo var_dump($_POST);
	}




//Graders($_POST['testname'],$_POST['studentname']);
function Graders($trap1,$trap2){
$totalgrade = 0;

//$handle2 = fopen("report.txt", "w");// this will hold the grade report while im adding to it
$res = responses($trap1,$trap2);// this grabs me the student report based on exam name and studnet ID
$respo = json_decode($res, true);// same report but i made it into json to read better

//----------------does the actual grading*************************************************************************************************************
$globes=Lemons('1',$respo,$handle2); $totalgrade=$globes;// this globes is just to carry the total grades 
$globes=Lemons('2',$respo,$handle2); $totalgrade=$globes;//forward since global variables arent working and i wanna sleep
$globes=Lemons('3',$respo,$handle2); $totalgrade=$globes;// i should probably fix this for the final product*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_ ugh
if($respo[0]['question4answer']!=null){$globes=Lemons('4',$respo,$handle2); $totalgrade=$globes;}
if($respo[0]['question5answer']!=null){$globes=Lemons('5',$respo,$handle2); $totalgrade=$globes;}
//----------------does the actual grading*************************************************************************************************************
//fwrite($handle2, "\nTotal Grade: ".$totalgrade."\n");// this is to display the total grade at end of report
//fclose($handle2);// the grade report file closes
$broom = file_get_contents('report.txt');// grab that report file to send to database
//echo $broom;// testing purposes show that report

  // Get cURL resource
  $curl2 = curl_init();
  $arraytosend = array(
       'version' => 'report',
       'testname' => 'exam alpha',
	'studentname' => 'ksl26',
	'test' => $broom
  );
  curl_setopt_array($curl2, array(
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL =>'https://web.njit.edu/~ksl26/cs490/BETA/release.php',
     CURLOPT_USERAGENT => 1,
     CURLOPT_POST => 1,
     CURLOPT_POSTFIELDS => $arraytosend
));// this curl is meant to simply send the final grade report back to the database to populate that field
$resp2 = curl_exec($curl2);
//echo "<br/>-------<br/>";
//echo $resp2;

}// end of GRAders

function Lemons($numeri,$respo,$handle2){// this is main function to grade a question with all three testcases
//echo "\n**************************question".$numeri."*************************************\n";
$grr = questions($respo[0]['question'.$numeri.'number']);
$quest = json_decode($grr, true);// container for the info i got back
fwrite($handle2, "\nQuestion ".$numeri." \n <br/>");
global $totalgrade;// global variable but ddoesnt work yet
//++++++++++++++++++++++++++++++++++++++++++++++
$should = substr($quest[0]['Test_Case_1'],0,strpos($quest[0]['Test_Case_1'],'('));// this line is the substring of just function name
if (strpos($respo[0]['question'.$numeri.'answer'], $should) !== false) {
	fwrite($handle2, ("Function Name:". " correct: +1 \n <br/>")); $totalgrade = $totalgrade+1;
} else{fwrite($handle2, ("\n <br/> Function Name:". " incorrect: -1 \n <br/>"));}
//+++++++++++++++++++++++++++++++++++++++++++++this code checks if they named it correctly

$putty = run($respo[0]['question'.$numeri.'answer'],$quest[0]['Test_Case_1']);// runs the code with first test case
$putty = trim(preg_replace('/\s+/', ' ', $putty));// trims the output
if ($putty == $quest[0]['Test_Case_Result_1']){// this is to check the output and compare to what it should be
	fwrite($handle2, ($quest[0]['Test_Case_1']. " correct: +3 \n <br/>"));
	$totalgrade = $totalgrade+3;
} else{fwrite($handle2, ($quest[0]['Test_Case_1']. " incorrect: -3 \n <br/>"));}

$putty = run($respo[0]['question'.$numeri.'answer'],$quest[0]['Test_Case_2']);// does same as above but for second test case
$putty = trim(preg_replace('/\s+/', ' ', $putty));
if ($putty == $quest[0]['Test_Case_Result_2']){
	fwrite($handle2, ($quest[0]['Test_Case_2']. " correct: +3 \n <br/>"));
	$totalgrade = $totalgrade+3;
} else{fwrite($handle2, ($quest[0]['Test_Case_2']. " incorrect: -3 \n <br/>"));}

$putty = run($respo[0]['question'.$numeri.'answer'],$quest[0]['Test_Case_3']);// does same as above but for third testcase
$putty = trim(preg_replace('/\s+/', ' ', $putty));

if ($putty == $quest[0]['Test_Case_Result_3']){
	fwrite($handle2, ($quest[0]['Test_Case_3']. " correct: +3 \n <br/>"));
		$totalgrade = $totalgrade+3;
} else{
	fwrite($handle2, ($quest[0]['Test_Case_3']. " incorrect: -3 \n <br/>"));
}
//echo "\n************************question".$numeri."***************************************\n";
return $totalgrade;
}//this is a function to run all three test case of a given question number from an exam


function run ($codes,$ending){// this runs the code base on a testcase
$handle = fopen("prol.py", "w");
$term= '#!/usr/bin/env python 
';
fwrite($handle, $term);//************ ***** ****** ***** ****** **** **** ****
fclose($handle);// this is meant to overwrite the file
$handle1 = fopen("prol.py", "a");
fwrite($handle1, ($codes));// write studnet response to file
fwrite($handle1, '
');	
$cap= ('print('.$ending.')');// this adds the testcase
fwrite($handle1, $cap);// should put a method run at the end
fclose($handle1);// the python code
$out = shell_exec('/usr/bin/python /afs/cad.njit.edu/u/d/j/djb58/public_html/cs490/prol.py');// this actually runs the file
return($out);	// then returns the output 
}// this is a function to handle running the code , itll save and then run python code that is given to it

function questions($yam){
     // Get cURL resource
     $curl = curl_init();
     $arraytosend = array(
         'version' => 'requestNumber',
         'number' => $yam
     );
     curl_setopt_array($curl, array(
         CURLOPT_RETURNTRANSFER => 1,
         CURLOPT_URL =>'https://web.njit.edu/~ksl26/cs490/BETA/release.php',
	    
        CURLOPT_USERAGENT => 1,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => $arraytosend
   ));
     $resp = curl_exec($curl);
     return $resp;
     // Close request to clear up some resources
     curl_close($curl);
}// this is a function to simply run the curl and get the question answers to compare to

function responses($trap11,$trap12){
     // Get cURL resource
     $curl2 = curl_init();
     $arraytosend = array(
          'version' => 'requestExam',
          'testname' => $trap11,
		'studentname' => $trap12
     );
     curl_setopt_array($curl2, array(
         CURLOPT_RETURNTRANSFER => 1,
         CURLOPT_URL =>'https://web.njit.edu/~ksl26/cs490/BETA/release.php',
        CURLOPT_USERAGENT => 1,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => $arraytosend
   ));
   $resp2 = curl_exec($curl2);
   return $resp2;
}//this is a function to run the curl to get the students responses of test to grade

?>