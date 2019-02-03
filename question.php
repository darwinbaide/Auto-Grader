<?php

//Graders('beta','ksl26');
echo "\npotato\n";
function Graders($trap1,$trap2){
echo "\n in the grader \n";
$totalgrade = 0;

file_put_contents("report.txt","Exam: ".$trap1."\n <br/> mn");// this will hold the grade report while im adding to it
$res = responses($trap1,$trap2);// this grabs me the student report based on exam name and studnet ID
//echo $res;
$respo = json_decode($res, true);// same report but i made it into json to read better
//----------------does the actual grading*************************************************************************************************************
$globes=Lemons('1',$respo); $totalgrade=$globes;// this globes is just to carry the total grades 
$globes=Lemons('2',$respo); $totalgrade=$globes;//forward since global variables arent working and i wanna sleep
$globes=Lemons('3',$respo); $totalgrade=$globes;// i should probably fix this for the final product*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_ ugh
if($respo[0]['question4answer']!=null){$globes=Lemons('4',$respo); $totalgrade=$globes;}
if($respo[0]['question5answer']!=null){$globes=Lemons('5',$respo); $totalgrade=$globes;}
//----------------does the actual grading*************************************************************************************************************
 
file_put_contents("report.txt"," \nTotal Grade: ".$totalgrade."\n",FILE_APPEND);// this is to display the total grade at end of report
$broom = file_get_contents('report.txt');// grab that report file to send to database
echo $broom;// testing purposes show that report

  // Get cURL resource
  $curl2 = curl_init();
  $arraytosend = array(
       'version' => 'report',
       'testname' => $trap1,
	'studentname' => $trap2,
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
echo $resp2;
}// end of GRAders





function Lemons($numeri,$respo){// this is main function to grade a question with all three testcase
$grr = questions($respo[0]['question'.$numeri.'number']);
$quest = json_decode($grr, true);// container for the info i got back
file_put_contents("report.txt",("\nQuestion ".$numeri." \n <br/>"),FILE_APPEND);
global $totalgrade;// global variable but ddoesnt work yet

//++++++++++++++++++++++++++++++++++++++++++++++
$should = substr($quest[0]['Test_Case_1'],0,strpos($quest[0]['Test_Case_1'],'('));// this line is the substring of just function name
if (strpos($respo[0]['question'.$numeri.'answer'], $should) !== false) {
	//fwrite($handle2, ("Function Name:". " correct: +1 \n <br/>")); $totalgrade = $totalgrade+1;
 file_put_contents("report.txt",("Function Name: correct: +1 \n <br/>"),FILE_APPEND);
 $totalgrade = $totalgrade+1;
} else{file_put_contents("report.txt",("Function Name: incorrect: -1 \n <br/>"),FILE_APPEND);
// this is in the wrong function name and will change that line to have the correct


$len = strlen($respo[0]['question'.$numeri.'answer']);
$betty= substr($respo[0]['question'.$numeri.'answer'],strpos($respo[0]['question'.$numeri.'answer'],'('), $len);//holds rest of function besdies name
$NewName = "def ".$should.$betty;
}// this is the end of the else and it will save the new correct function name
//+++++++++++++++++++++++++++++++++++++++++++++this code checks if they named it correctly






$putty = run($respo[0]['question'.$numeri.'answer'],$quest[0]['Test_Case_1']);// runs the code with first test case
//echo $putty;
$putty = trim(preg_replace('/\s+/', ' ', $putty));// trims the output


if ($putty == $quest[0]['Test_Case_Result_1']){// this is to check the output and compare to what it should be
    file_put_contents("report.txt",($quest[0]['Test_Case_1']. " correct: +3 \n <br/>"),FILE_APPEND);
       $totalgrade = $totalgrade+3;
   } else{file_put_contents("report.txt",($quest[0]['Test_Case_1']. " incorrect: -3 \n <br/>"),FILE_APPEND);}
   
   $putty = run($respo[0]['question'.$numeri.'answer'],$quest[0]['Test_Case_2']);// does same as above but for second test case
   $putty = trim(preg_replace('/\s+/', ' ', $putty));
   if ($putty == $quest[0]['Test_Case_Result_2']){
   file_put_contents("report.txt",($quest[0]['Test_Case_2']. " correct: +3 \n <br/>"),FILE_APPEND);
   
       $totalgrade = $totalgrade+3;
   } else{file_put_contents("report.txt",($quest[0]['Test_Case_2']. " incorrect: -3 \n <br/>"),FILE_APPEND);}
   
   
   
   if($quest[0]['Test_Case_Result_3']!="" ){
   $putty = run($respo[0]['question'.$numeri.'answer'],$quest[0]['Test_Case_3']);// does same as above but for third testcase
   $putty = trim(preg_replace('/\s+/', ' ', $putty));
   
   if ($putty == $quest[0]['Test_Case_Result_3']){
    file_put_contents("report.txt",($quest[0]['Test_Case_3']. " correct: +3 \n <br/>"),FILE_APPEND);
           $totalgrade = $totalgrade+3;
   } else{
    file_put_contents("report.txt",($quest[0]['Test_Case_3']. " incorrect: -3 \n <br/>"),FILE_APPEND);
   }
   }
   
   
   
   if($quest[0]['Test_Case_Result_4']!="" ){
   $putty = run($respo[0]['question'.$numeri.'answer'],$quest[0]['Test_Case_4']);// does same as above but for second test case
   $putty = trim(preg_replace('/\s+/', ' ', $putty));
   if ($putty == $quest[0]['Test_Case_Result_4']){
   file_put_contents("report.txt",($quest[0]['Test_Case_4']. " correct: +3 \n <br/>"),FILE_APPEND);
   
       $totalgrade = $totalgrade+3;
   } else{file_put_contents("report.txt",($quest[0]['Test_Case_4']. " incorrect: -3 \n <br/>"),FILE_APPEND);}
   }
   
   if($quest[0]['Test_Case_Result_5']!="" ){
   $putty = run($respo[0]['question'.$numeri.'answer'],$quest[0]['Test_Case_5']);// does same as above but for second test case
   $putty = trim(preg_replace('/\s+/', ' ', $putty));
   if ($putty == $quest[0]['Test_Case_Result_5']){
   file_put_contents("report.txt",($quest[0]['Test_Case_5']. " correct: +3 \n <br/>"),FILE_APPEND);
   
       $totalgrade = $totalgrade+3;
   } else{file_put_contents("report.txt",($quest[0]['Test_Case_5']. " incorrect: -3 \n <br/>"),FILE_APPEND);}
   }
   
   if($quest[0]['Test_Case_Result_6']!="" ){
   $putty = run($respo[0]['question'.$numeri.'answer'],$quest[0]['Test_Case_6']);// does same as above but for second test case
   $putty = trim(preg_replace('/\s+/', ' ', $putty));
   if ($putty == $quest[0]['Test_Case_Result_6']){
   file_put_contents("report.txt",($quest[0]['Test_Case_6']. " correct: +3 \n <br/>"),FILE_APPEND);
   
       $totalgrade = $totalgrade+3;
   } else{file_put_contents("report.txt",($quest[0]['Test_Case_6']. " incorrect: -3 \n <br/>"),FILE_APPEND);}
   
   }
   
return $totalgrade;
}//this is a function to run all three test case of a given question number from an exam




//'Test_Case_Result_6'

function testcases($name,$questi,$codi,$totalgrade){	
if($quest[0][$name] !="" ){
$putty = run($codi,$questi[0][$name]);// does same as above but for fifth test case
$putty = trim(preg_replace('/\s+/', ' ', $putty));
if ($putty == $quest[0][$name]){
file_put_contents("report.txt",($questi[0][$name]. " correct: +3 \n <br/>"),FILE_APPEND);
$totalgrade = $totalgrade+3;
} else{file_put_contents("report.txt",($questi[0][$name]. " incorrect: -3 \n <br/>"),FILE_APPEND);}
}
return totalgrade;	
	
	
}

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