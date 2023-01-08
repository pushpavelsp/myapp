<?php

/******************** Error Report Off   ********************/
//ini_set("display_errors", "0");
error_reporting(1);
require 'PHPMailer-master/PHPMailerAutoload.php';
header('Content-type: text/html; charset=utf-8');
//define('SMTPUSER', 'manu_neethi'); // sec. smtp username
//define('SMTPPWD', 'uuve2eBa'); // sec. password
define('SMTPUSER', 'nssonline.dce'); // sec. smtp username
define('SMTPPWD', 'Nsstn_1907'); // sec. password
//define('SMTPUSER', 'nssonline.dce'); // sec. smtp username
//define('SMTPPWD', 'Nsstn_1907'); // sec. password
//define('SMTPSERVER', 'tn.gov.in'); // sec. smtp server
define('SMTPSERVER', 'mail.tn.gov.in'); // sec. smtp server New Maill Server 07/04/2017 Onwards.

//echo "Here ..";
$from = 'nss@tn.gov.in'; 
$cra_file = '';
$district_file = ''; 
$cc;
 
	function smtpmailer($to, $from, $from_name, $subject, $body,$bcc ) { 
	if(sendMail($from_name,$from,$subject, $body,$to,$bcc))
	{
		return true; 
	}
	else
		return false;  
}

function sendMail($from_name,$from,$subject, $body,$to,$bcc) {
	global $error;
        //echo "Testing "; 	
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true; 
	$mail->SMTPDebug = 0; 
	$mail->Host = SMTPSERVER;
	$mail->Username = SMTPUSER;  
	$mail->Password = SMTPPWD;
	$mail->SMTPSecure = 'ssl'; 
	$mail->SMTPOptions = array
	(
		'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => false
					  )
	);
        $mail->Port = 465; 
	$to1 = 'nss@tn.gov.in';

	$mail->addBCC($bcc);
	$mail->SetFrom($from, $from_name);
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AddAddress($to);
	$mail->AddAddress($to1);


	$mail->IsHTML(true);
	 
	if(!$mail->Send()) 
	{
		$error = 'Mail error: '.$mail->ErrorInfo;
		$mail->ErrorInfo;
		$_SESSION['mail_flag']=0;
		return false;
	} 
	else 
	{
		$mail->ClearAddresses();  // each AddAddress add to list
		$mail->ClearCCs();
		$mail->ClearBCCs();
		$error = 'Message sent! ';
		$_SESSION['mail_flag']=1;
		//exit;
		return true;
	}
	

	
}
?>
