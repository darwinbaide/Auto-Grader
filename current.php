   <?php


$test="def counter(myNum):
i = 1

while i < myNum:
  print(i)
  i += 1
  
  +
  
  +
  
  \n";

Graders1($test);
function Graders1($test){
$newphrase = str_replace("+", "(*)", $test);
echo $newphrase;
}


?>