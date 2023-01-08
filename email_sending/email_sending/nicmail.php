<?php

/******************** Error Report Off   ********************/
//ini_set("display_errors", "0");
error_reporting(1);
require 'PHPMailer-master/PHPMailerAutoload.php';
header('Content-type: text/html; charset=utf-8');
//define('SMTPUSER', 'manu_neethi'); // sec. smtp username
//define('SMTPPWD', 'uuve2eBa'); // sec. password
define('SMTPUSER', 'nssonline.dce'); // sec. smtp username
define('SMTPPWD', 'efouW3sh'); // sec. password
//define('SMTPSERVER', 'tn.gov.in'); // sec. smtp server
define('SMTPSERVER', 'mail.tn.gov.in'); // sec. smtp server New Maill Server 07/04/2017 Onwards.

//echo "Here ..";
$from = 'nssonline.dce@tn.gov.in';

$cra_file = '';
$district_file = '';

$cc;


//echo "Here...";
//exit;

//function smtpmailer($to, $from, $from_name, $subject, $body,$headers ) { 
	function smtpmailer($to, $from, $from_name, $subject, $body,$bcc ) {
        //echo "STarted";
//	$to="nic.srama@gmail.com";
	//$to="s.gomathi@nic.in";
	//$to="s.gomathi2010@gmail.com";
        //echo "here ..."; //exit;
		//$cc_arr ='';

	if(sendMail($from_name,$from,$subject, $body,$to,$bcc))
	{
		return true;
		//echo "yes";
		//exit;
	}
	else
		return false;

        //echo "here 2";
	
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
	//$mail->SMTPSecure = 'ssl';
       //$mail->SMTPDebug = 2; 
       //echo "before"; 
	$mail->SMTPOptions = array
	(
		'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => false
					  )
	);
        $mail->Port = 465;
	// $mail->Port = 25;
	//echo "after";
        #$mail->Port = 587;
	$to1 = 'awards@tn.gov.in';

	$mail->addBCC($bcc);
	$mail->SetFrom($from, $from_name);
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AddAddress($to);
	$mail->AddAddress($to1);


	$mail->IsHTML(true);
	

	
	//Commented for testing purpose 18-01-2018
	//$mail->AddAddress('com-ra@nic.in');
	/*	
	if (count($cc) > 0) {
		for ($z=0;$z<count($cc);$z++) {
			$mail->AddCC($cc[$z]);	
		}
	}
	*/
	//Commented for testing purpose 18-01-2018
	/*if ($level == '1') {
		$mail->AddCC('jcla.computer@gmail.com');
		//$mail->AddCC('tpalani_2000@yahoo.com');	
		$mail->AddCC('s.s.moorthi@nic.in');		
	}*/
	/*
	if ($level == '1') {
		$mail->AddAttachment('cra.xls','cra.xls','base64','mime/type');
	} else if ($level == '2') {
		$mail->AddAttachment('district.xls','district.xls','base64','mime/type');
	} else if ($level == '3') {
		$mail->AddAttachment('rdo.xls','rdo.xls','base64','mime/type');
	} else if ($level == '4') {
		$mail->AddAttachment('taluk.xls','taluk.xls','base64','mime/type');
	}
	
	*/
        //echo "Here ...xxx";
        //exit; 
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
