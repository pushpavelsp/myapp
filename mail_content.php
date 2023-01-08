<?php
include "db_connect.php"; 
$mail_content =$db->query("SELECT * FROM mail_content");
$content=$mail_content->fetchAll(PDO::FETCH_ASSOC); 
foreach ($content as $contentkey => $contentvalue) {
	$subject[$contentvalue['reason']]=$contentvalue['subject']; 
	$message[$contentvalue['reason']]=$contentvalue['message']; 
}	//print_r($subject[4]);  exit;


?>
