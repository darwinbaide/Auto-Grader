<?php


//include 'question.php';
//include 'current.php';
error_reporting(E_ALL);
ini_set('display_errors',1);
global $totalgrade;

function Graders($trap1,$trap2){
file_put_contents("report.txt","");
$totalgrade = 0;
$points1=0; $points2=0; $points3=0; $points4=0; $points5=0;// declare te variables and set to zero
$res = responses($trap1,$trap2);// this grabs me the student report based on exam name and studnet ID
$respo = json_decode($res, true);// same report but i made it into json to read better
//echo $res;
//----------------does the actual grading*************************************************************************************************************
$points1=Lemons('1',$respo);
file_put_contents("report.txt",("\n(9-9-9-9)\n"),FILE_APPEND);
$points2=Lemons('2',$respo);
file_put_contents("report.txt",("\n(9-9-9-9)\n"),FILE_APPEND);
$points3=Lemons('3',$respo); 
if($respo[0]['question4answer']!=null){file_put_contents("report.txt",("\n(9-9-9-9)\n"),FILE_APPEND);$points4=Lemons('4',$respo); }
if($respo[0]['question5answer']!=null){file_put_contents("report.txt",("\n(9-9-9-9)\n"),FILE_APPEND);$points5=Lemons('5',$respo); }
//----------------does the actual grading*************************************************************************************************************
$broom = file_get_contents('report.txt');// grab that report file to send to database
echo $broom;
  // Get cURL resource
  $curl2 = curl_init();
  $arraytosend = array(
       'version' => 'report',
       'testname' => $trap1,
	'studentname' => $trap2,
	'test' => $broom,
	'points1' => $points1,
	'points2' => $points2,
	'points3' => $points3,
	'points4' => $points4,
	'points5' => $points5
  ); 
  curl_setopt_array($curl2, array(
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL =>'https://web.njit.edu/~ksl26/cs490/BETA/release.php',
     CURLOPT_USERAGENT => 1,
     CURLOPT_POST => 1,
     CURLOPT_POSTFIELDS => $arraytosend
));// this curl is meant to simply send the final grade report back to the database to populate that field
$resp2 = curl_exec($curl2);
echo $resp2;
}// end of GRAders












function Lemons($numeri,$respo){// this is main function to grade a question with all three testcase
$totalgrade=0;
$grr = questions($respo[0]['question'.$numeri.'number']);
$quest = json_decode($grr, true);// container for the info i got back
//echo $grr;
file_put_contents("report.txt",("\n----- Question ".$numeri."----- \n <br/>"),FILE_APPEND);
$NewCode= $respo[0]['question'.$numeri.'answer'];// this is the code used in running
$questiontotal= $respo[0]['question'.$numeri.'points'];// this is the ponint vlaue that the professor assigned to the question
//echo "total questi points: ".$questiontotal;
$divider=2;
$functi= "false";
//++++++++++++++++++++++++++++++++++++++++++++++++++++// to know how many testcases there are to know how to divide 
if($quest[0]['Test_Case_Result_3']!="" ){$divider = $divider+1;}
if($quest[0]['Test_Case_Result_4']!="" ){$divider = $divider+1;}
if($quest[0]['Test_Case_Result_5']!="" ){$divider = $divider+1;}
if($quest[0]['Test_Case_Result_6']!="" ){$divider = $divider+1;}
//echo "\ndivider: ".($divider);// how many testcases ther
$eachi = ($questiontotal/$divider); // how much each testcase is worth
//++++++++++++++++++++++++++++++++++++++++++++++
$should = substr($quest[0]['Test_Case_1'],0,strpos($quest[0]['Test_Case_1'],'('));// this line is the substring of just function name
$noAdd= $should;
$should = $should."(";
//echo "***************************************".$should."************\n";
if (strpos($respo[0]['question'.$numeri.'answer'], $should) !== false) {
 file_put_contents("report.txt",("Function Name: correct \n <br/>"),FILE_APPEND);
 //$totalgrade = $totalgrade+($questiontotal*.2);
} else{file_put_contents("report.txt",("Function Name: incorrect: -".(number_format($questiontotal * .2, 2)). "\n <br/>"),FILE_APPEND);
	$functi = "true";
// this is in the wrong function name and will change that line to have the correct
$len = strlen($respo[0]['question'.$numeri.'answer']);
$betty= substr($respo[0]['question'.$numeri.'answer'],strpos($respo[0]['question'.$numeri.'answer'],'('), $len);//holds rest of function besdies name
$NewCode = "def ".$noAdd.$betty;
}// this is the end of the else and it will save the new correct function name
//+++++++++++++++++++++++++++++++++++++++++++++this code checks if they named it correctly





$colonB = false;
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$firstLine=substr($NewCode,0, strpos($NewCode,"\n"));// first line
//echo $firstLine."-\n";

if(strpos($firstLine,':') == false ){
	//echo "missing colon\n";
	$beginN =substr($NewCode,0, strpos($NewCode,")")+1);// the line up until the closing paranthesis
	$begin = $beginN.": ";// adds the colon
	$len1 = strlen($respo[0]['question'.$numeri.'answer']);// length of the code
	$rest2= substr($NewCode,strpos($NewCode,"\n"), $len1);//holds rest of function besdies name
	$NewCode= $begin.$rest2;// this adds the new line i fixed back to the rest of the code
	$colonB = True;
	//echo $NewCode;
}// if first line doesnt contain a :
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~






// runs the testcases function
$totalgrade=testcases('Test_Case_1',$quest,$NewCode,$totalgrade,'Test_Case_Result_1',$eachi);// this runs testcase 1 every time 
$totalgrade=testcases('Test_Case_2',$quest,$NewCode,$totalgrade,'Test_Case_Result_2',$eachi);// this runs testcase 2 every time
if($quest[0]['Test_Case_Result_3']!="" ){$totalgrade=testcases('Test_Case_3',$quest,$NewCode,$totalgrade,'Test_Case_Result_3',$eachi); }
if($quest[0]['Test_Case_Result_4']!="" ){$totalgrade=testcases('Test_Case_4',$quest,$NewCode,$totalgrade,'Test_Case_Result_4',$eachi); }
if($quest[0]['Test_Case_Result_5']!="" ){$totalgrade=testcases('Test_Case_5',$quest,$NewCode,$totalgrade,'Test_Case_Result_5',$eachi); }
if($quest[0]['Test_Case_Result_6']!="" ){$totalgrade=testcases('Test_Case_6',$quest,$NewCode,$totalgrade,'Test_Case_Result_6',$eachi); }
//-----------------------------------------------------------------------------------------------------------------------------------------------
$constraints =  $quest[0]["constraints"];
$constraints = explode(",", $constraints);// this is fucking up

$creturn ="True";
$cfor= $constraints[0];
$cwhile= $constraints[1];
$crecursion= $constraints[2];
$cif= $constraints[3];
$cifelse= $constraints[4];
$divider2=2;
$cpoints= (number_format($questiontotal * .4, 2));
if($cfor=="True"){$divider2++;} if($cfor=="while"){$divider2++;} 
if($crecursion=="True"){$divider2++;}  if($cif=="True"){$divider2++;} if($cifelse=="True"){$divider2++;} 
$cpoints= $cpoints/$divider2;
// above this is grabbing data and setting check to true or false

if($creturn=="True"){
	if (strpos($NewCode, 'return') !== false) {
			file_put_contents("report.txt",("Constraints:Return: Correct \n <br/>"),FILE_APPEND);}
	else{file_put_contents("report.txt",("Constraints:Return: Incorrect -".$cpoints."\n <br/>"),FILE_APPEND);$totalgrade= $totalgrade-$cpoints; }
 }
if($colonB == True){file_put_contents("report.txt",("COLON Usage: Incorrect -".$cpoints."\n <br/>"),FILE_APPEND);$totalgrade= $totalgrade-$cpoints;}

 if($cfor=="True"){
	if (strpos($NewCode, 'for') !== false) {
			file_put_contents("report.txt",("Constraints:For: Correct \n <br/>"),FILE_APPEND);}
	else{file_put_contents("report.txt",("Constraints:For: Incorrect -".$cpoints."\n <br/>"),FILE_APPEND);$totalgrade= $totalgrade-$cpoints; } 
	}
	
	if($cwhile=="True"){
		if (strpos($NewCode, 'while') !== false) {
			file_put_contents("report.txt",("Constraints:While: Correct \n <br/>"),FILE_APPEND);}
		else{file_put_contents("report.txt",("Constraints:While: Incorrect -".$cpoints."\n <br/>"),FILE_APPEND);$totalgrade= $totalgrade-$cpoints; } 
	}
		
	if($crecursion=="True"){
		if (substr_count($NewCode, $should) > 1){// should be two//tells you how many times the function name shows up
			file_put_contents("report.txt",("Constraints:Recursion: Correct \n <br/>"),FILE_APPEND);}
		else{file_put_contents("report.txt",("Constraints:Recursion: Incorrect -".$cpoints."\n <br/>"),FILE_APPEND);$totalgrade= $totalgrade-$cpoints; } 
	}
		
	if($cif=="True"){
		if (strpos($NewCode, 'if') !== false) {
			file_put_contents("report.txt",("Constraints:If: Correct \n <br/>"),FILE_APPEND);}
		else{file_put_contents("report.txt",("Constraints:If: Incorrect -".$cpoints."\n <br/>"),FILE_APPEND);$totalgrade= $totalgrade-$cpoints; } 
	}
	
	if($cifelse=="True"){
		if ((strpos($NewCode, 'if') !== false)&&   ((strpos($NewCode, 'else') !== false)||(strpos($NewCode, 'elif') !== false))) {//doesnt include an else nd an if
			file_put_contents("report.txt",("Constraints:If-Else: Correct \n <br/>"),FILE_APPEND);}
		else{file_put_contents("report.txt",("Constraints:If-Else: Incorrect -".$cpoints."\n <br/>"),FILE_APPEND);$totalgrade= $totalgrade-$cpoints; } 
	}



if($functi== "true"){$totalgrade= $totalgrade-(number_format($questiontotal * .2, 2));  }
	
if($totalgrade<0){$totalgrade=0;}// if the whole thing doesnt run and you dont have constraints , you would go negative, so reset to zero
//$ninety = (number_format($questiontotal * .99, 2))
//if ($totalgrade >= $ninety){ $totalgrade = $questiontotal;}
//echo $totalgrade;
return $totalgrade;
}//this is a function to run all three test case of a given question number from an exam


function testcases($name,$questi,$codi,$totalgrade,$grr3,$eachi){	// function to run the testcase for a given question 		
if($questi[0][$name] !="" ){
$putty = run($codi,$questi[0][$name]);// does same as above but for fifth test case
$putty = trim(preg_replace('/\s+/', ' ', $putty));
//return $putty;
if ($putty == $questi[0][$grr3]){
file_put_contents("report.txt",($questi[0][$name]. " correct: +".$eachi."\n <br/>"),FILE_APPEND);
$totalgrade = $totalgrade+$eachi;
} else{file_put_contents("report.txt",($questi[0][$name]. " incorrect: -".$eachi."-output: ".$putty."-expected:".$questi[0][$grr3]." \n <br/>"),FILE_APPEND);}}

return $totalgrade;	
}// enf of function testcase

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

//***************************************************************************************************************************
//***************************************************************************************************************************
//***************************************************************************************************************************
//***************************************************************************************************************************
//***************************************************************************************************************************
//***************************************************************************************************************************
//***************************************************************************************************************************
//***************************************************************************************************************************
//***************************************************************************************************************************
//***************************************************************************************************************************
//***************************************************************************************************************************
//***************************************************************************************************************************
//***************************************************************************************************************************
//***************************************************************************************************************************
//***************************************************************************************************************************
//***************************************************************************************************************************
//***************************************************************************************************************************
//***************************************************************************************************************************
//***************************************************************************************************************************
//***************************************************************************************************************************





	if($_POST['version'] == 'login'){
		//var_dump($_POST);
 	    	//echo " \n in the login \n";
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
	}elseif ($_POST['version'] == 'add') {
	
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
 
 
 
		//Graders($_POST['testname'],$_POST['studentname']);
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
	
	
	elseif ($_POST['version'] == 'manualGrades') {
	
	
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
	
	elseif ($_POST['version'] == 'updateMG') {
	
	
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
	
	elseif ($_POST['version'] == 'doGrade'){

 		//echo " \n this went to my graders curl\n";
  		$hay1= $_POST['testname'];
		  $hay2= $_POST['studentname'];
  	   	echo Graders($hay1,$hay2);
		
	}




?>