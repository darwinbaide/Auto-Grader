<?php


//include 'question.php';
//include 'current.php';
error_reporting(E_ALL);
ini_set('display_errors',1);
global $totalgrade;
Graders('testing fix 4','ksl26');



function Graders($trap1,$trap2){
file_put_contents("report.txt","");
$totalgrade = 0;
$points1=0; $points2=0; $points3=0; $points4=0; $points5=0;// declare te variables and set to zero
$res = responses($trap1,$trap2);// this grabs me the student report based on exam name and studnet ID
$respo = json_decode($res, true);// same report but i made it into json to read better
$constra= $respo;
echo $res;
//----------------does the actual grading*************************************************************************************************************
$points1=Lemons('1',$respo,$constra);
file_put_contents("report.txt",("\n(9-9-9-9)\n"),FILE_APPEND);
$points2=Lemons('2',$respo,$constra);
file_put_contents("report.txt",("\n(9-9-9-9)\n"),FILE_APPEND);
$points3=Lemons('3',$respo,$constra); 
if($respo[0]['question4answer']!=null){file_put_contents("report.txt",("\n(9-9-9-9)\n"),FILE_APPEND);$points4=Lemons('4',$respo,$constra); }
if($respo[0]['question5answer']!=null){file_put_contents("report.txt",("\n(9-9-9-9)\n"),FILE_APPEND);$points5=Lemons('5',$respo,$constra); }
//----------------does the actual grading*************************************************************************************************************
$broom = file_get_contents('report.txt');// grab that report file to send to database
//echo $broom;
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


function Lemons($numeri,$respo,$constra){// this is main function to grade a question with all three testcase
    $totalgrade=0;
    $grr = questions($respo[0]['question'.$numeri.'number']);
    $quest = json_decode($grr, true);// container for the info i got back

    echo " \n -------------------------------------------------";
    echo $quest[0][0];
    echo "---------------------------------------------------\n";




    file_put_contents("report.txt",("\n----- Question ".$numeri."----- \n <br/>"),FILE_APPEND);
    $NewCode= $respo[0]['question'.$numeri.'answer'];// this is the code used in running
    $questiontotal= $respo[0]['question'.$numeri.'points'];// this is the ponint vlaue that the professor assigned to the question
    //echo "total questi points: ".$questiontotal;
    $divider=2;
    //++++++++++++++++++++++++++++++++++++++++++++++++++++// to know how many testcases there are to know how to divide 
    if($quest[0]['Test_Case_Result_3']!="" ){$divider = $divider+1;}
    if($quest[0]['Test_Case_Result_4']!="" ){$divider = $divider+1;}
    if($quest[0]['Test_Case_Result_5']!="" ){$divider = $divider+1;}
    if($quest[0]['Test_Case_Result_6']!="" ){$divider = $divider+1;}
    //echo "\ndivider: ".($divider);// how many testcases ther
    $eachi = ($questiontotal/$divider); // how much each testcase is worth
    //++++++++++++++++++++++++++++++++++++++++++++++
    $should = substr($quest[0]['Test_Case_1'],0,strpos($quest[0]['Test_Case_1'],'('));// this line is the substring of just function name
    if (strpos($respo[0]['question'.$numeri.'answer'], $should) !== false) {
     file_put_contents("report.txt",("Function Name: correct \n <br/>"),FILE_APPEND);
     $totalgrade = $totalgrade+($questiontotal*.2);
    } else{file_put_contents("report.txt",("Function Name: incorrect: -".(number_format($questiontotal * .2, 2)). "\n <br/>"),FILE_APPEND);
    // this is in the wrong function name and will change that line to have the correct
    $len = strlen($respo[0]['question'.$numeri.'answer']);
    $betty= substr($respo[0]['question'.$numeri.'answer'],strpos($respo[0]['question'.$numeri.'answer'],'('), $len);//holds rest of function besdies name
    $NewCode = "def ".$should.$betty;
    }// this is the end of the else and it will save the new correct function name
    //+++++++++++++++++++++++++++++++++++++++++++++this code checks if they named it correctly
    
    
    // runs the testcases function
    $hold9=testcases('Test_Case_1',$quest,$NewCode,$totalgrade,'Test_Case_Result_1',$eachi); $totalgrade=$hold9;// this runs testcase 1 every time 
    $hold9=testcases('Test_Case_2',$quest,$NewCode,$totalgrade,'Test_Case_Result_2',$eachi); $totalgrade=$hold9;// this runs testcase 2 every time
    if($quest[0]['Test_Case_Result_3']!="" ){$hold9=testcases('Test_Case_3',$quest,$NewCode,$totalgrade,'Test_Case_Result_3',$eachi); $totalgrade=$hold9;}
    if($quest[0]['Test_Case_Result_4']!="" ){$hold9=testcases('Test_Case_4',$quest,$NewCode,$totalgrade,'Test_Case_Result_4',$eachi); $totalgrade=$hold9;}
    if($quest[0]['Test_Case_Result_5']!="" ){$hold9=testcases('Test_Case_5',$quest,$NewCode,$totalgrade,'Test_Case_Result_5',$eachi); $totalgrade=$hold9;}
    if($quest[0]['Test_Case_Result_6']!="" ){$hold9=testcases('Test_Case_6',$quest,$NewCode,$totalgrade,'Test_Case_Result_6',$eachi); $totalgrade=$hold9;}
$constraints =  $constra[0]['constraint'.$numeri];
$constraints = explode(",", $constraints);// this is fucking up
$creturn ="True";
$cfor= $constraints[0];
$cwhile= $constraints[1];
$crecursion= $constraints[2];
$cif= $constraints[3];
$cifelse= $constraints[4];
$divider2=1;
$cpoints= (number_format($questiontotal * .3, 2));
if($cfor=="True"){$divider2++;} if($cfor=="while"){$divider2++;} 
if($crecursion=="True"){$divider2++;}  if($cif=="True"){$divider2++;} if($cifelse=="True"){$divider2++;} 
$cpoints= $cpoints/$divider2;


if($creturn=="True"){
if (strpos($NewCode, 'return') !== false) {
		file_put_contents("report.txt",("Constraints:Return: Correct \n <br/>"),FILE_APPEND);}
else{file_put_contents("report.txt",("Constraints:Return: Incorrect -".$cpoints."\n <br/>"),FILE_APPEND);$totalgrade= $totalgrade-$cpoints; } }

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
	if ((strpos($NewCode, 'if') !== false)&&(strpos($NewCode, 'else') !== false)) {//doesnt include an else nd an if
		file_put_contents("report.txt",("Constraints:If-Else: Correct \n <br/>"),FILE_APPEND);}
	else{file_put_contents("report.txt",("Constraints:If-Else: Incorrect -".$cpoints."\n <br/>"),FILE_APPEND);$totalgrade= $totalgrade-$cpoints; } 
}
	
if($totalgrade<0){$totalgrade=0;}// if the whole thing doesnt run and you dont have constraints , you would go negative, so reset to zero
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
} else{file_put_contents("report.txt",($questi[0][$name]. " incorrect: -".$eachi." \n <br/>"),FILE_APPEND);}}
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


?>