<?php
session_start();

//To prevent php from showing warnings
ini_set('display_errors', "0");

//Returns IP based on IP Tag types that are present
function visitor_ip() { 
      
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
        return $_SERVER['HTTP_CLIENT_IP']; 
    } 
    else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
        return $_SERVER['HTTP_X_FORWARDED_FOR']; 
    }
	else if (!empty($_SERVER['HTTP_X_REAL_IP'])) { 
        return $_SERVER['HTTP_X_REAL_IP']; 
    } 
    else { 
        return $_SERVER['REMOTE_ADDR']; 
    } 
}

//File to write Visitor logs
$file = 'connection-log.txt';

//Data To Write
$date = date_default_timezone_set('Asia/Kolkata');
$time_stamp = (microtime(true))*1000;
$vip = visitor_ip();
$rid = $_GET["rid"];
$bua = base64_encode($_SERVER['HTTP_USER_AGENT']);
$stage = 1;

//Building JSON for collected data
$data = array(
	'rid' => $rid,
	'timestamp' => $time_stamp,
	'stage' => $stage,
	'internalip' => $vip,
	'externalip' => $_SERVER['REMOTE_ADDR'],
	'user_agent_string' => $bua,
);

//Storing in session variable for next stages if they arive
$_SESSION["session_data"] = $data;

//JSONifying the data for writing it to file
$json_data = json_encode($data);
$newline = "\n";

// Write the contents to the file, 
// using the FILE_APPEND flag to append the content to the end of the file
// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
file_put_contents($file, $json_data, FILE_APPEND | LOCK_EX);
file_put_contents($file, $newline, FILE_APPEND | LOCK_EX);
header("Location: index.html");
?>

