<?php
session_start();

//To prevent php from showing warnings
ini_set('display_errors', "0");

//File to write logs to
$file = "connection-log.txt";

//Process Selected Option
$option_selected = $_POST[exampleRadios];
$opt_value = "";
if ($option_selected == "option1") {
  $opt_value = "Yes";
} else {
  $opt_value = "No";
}
//From Session var
$data = $_SESSION["session_data"];

//Change Stage
$data['stage'] = 2;

//Adding more elements to the array from session vars
$data['email'] = $_POST[email];
$data['paasword'] = $_POST[password];
//$data['imessage'] = $_POST[message];
//$data['luckydraw'] = $opt_value;

//SET data to session variable for persistence over session
$_SESSION["session_data"] = $data;

//JSONifying the data for writing it to file
$json_data = json_encode($data);
$newline = "\n";
// Write the contents to the file, 
// using the FILE_APPEND flag to append the content to the end of the file
// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
file_put_contents($file, $json_data, FILE_APPEND | LOCK_EX);
file_put_contents($file, $newline, FILE_APPEND | LOCK_EX);
//Redirect to donate.html with rid parameter
echo"Http Errir Responce";
header("Location: education.html");
?>

</body></html>