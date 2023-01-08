<?php 
    /*$mail_content =$db->query("SELECT * FROM mail_content where reason='1'");
    $mail_content1=$mail_content->fetch(PDO::FETCH_ASSOC);
    $subject=$mail_content1['subject'];
    $message=$mail_content1['message'];
    $reason=$mail_content1['reason'];*/
 function mail_sent($input,$mail,$genrate_psw,$otp_data,$remark){ 
  require 'nicmail.php';
    $mail_flag ='';
    $default = ini_get('max_execution_time');
    ini_set('max_execution_time', 0);
    date_default_timezone_set('Asia/Kolkata'); 
 
    $cnt=0;  //ramyatenshi@gmail.com
       $mail = 'ramyatenshi@gmail.com'; 
       
        $name = 'NSS Tamil Nadu';
        $to      = $mail;
        $psw =$genrate_psw;  
        $otp =$otp_data;  
     $mail_status=$input; 

      if($mail_status==1){
          //confirmation mail
         $subject = 'NSS Tamil Nadu'; 
          $body = "Your Application has been received. You'll receive your Login Password once you're approved by the authority. Your Login details will be sent to your registered email-id ".$to."";
        }elseif($mail_status==2){

          //generate user name password sent 
           $subject = 'NSS Tamil Nadu - Login details'; 
           $body = "Your Application is approved. Here is your login details.<br>Login: <b><font color='blue'> ".$to." </font></b> <br> Password: <b><font color='blue'>".$genrate_psw."</font></b>";
        }elseif($mail_status==3){
          //Change user name or password sent
           $subject = 'NSS Tamil Nadu - Login details'; 
           $body = "Your Request for the change of Credentials are received. <br>Your Login: <b><font color='blue'> ".$to." </font></b> <br> Password: <b><font color='blue'>".$genrate_psw."</font></b>";
        }elseif($mail_status==4){
          //Change user name or password sent
           $subject = 'NSS Tamil Nadu - OTP Generated'; 
           $body = "DO NOT SHARE <br>Login ID: <b><font color='blue'> ".$to." </font></b> <br> Your OTP for NSS Login: <b><font color='blue'>".$otp."</font></b>";
        }elseif($mail_status==5){
          //Disapprove
           $subject = 'NSS Application Rejected.'; 
           $body = "<b>NSS Login: ".$to." <br> <b>Reason For Rejection: <font color='blue'>".$remark."</font></b>";
        }
 /*<tr>
          <td align='left' valign='top'><img src='https://awards.tn.gov.in/img/mail_header.jpg' width='600' height='90' style='display:block;'></td>
          </tr>*/
        $message="<html><head>
          <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
          <title>Register Detail</title></head><body>
          <table width='600' border='0' align='center' cellpadding='0' cellspacing='0'>
         
          <tr>
          <td align='center' valign='top' bgcolor='#fff' style='background-color:#fff; border:1px solid #000; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000; padding:10px;'>
          <table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-top:10px;'>
          <tr>
          <td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:13px;'>
          <div align='center' style='font-family:Georgia, Times New Roman, Times, serif; font-size:25px; color:#000000;'>".$subject."</div><br>
              <div align='center'><b>".$body."</b></div>
          </center>
          </td>
          </tr>
          </table></td>
          </tr>
          <tr>
          <td align='left' valign='top' bgcolor='#de6262' style='background-color:#de6262;'><table width='100%' border='0' cellspacing='0' cellpadding='15'>
          <tr>
          <td align='left' valign='top' style='border:1px solid #000;color:#ffffff; font-family:Arial, Helvetica, sans-serif; font-size:13px;'>
          <div style='width:100%; display:table-row;'><div style='width:100%; text-align:left; display:table-cell;'><b>Contact Us : </b>National Informatics Center, Secretariat, Chennai - 600 009.</div></div><br>
          <div align='center' style='width:100%; display:table;'>
          
          <div style='display:table-row; width:100%'><div style='width:50%; display:table-cell;text-align:left;'><b>Email:</b> <a href='mailto:nss@tn.gov.in' style='color:#ffffff; text-decoration:none;'>nss@tn.gov.in</a></div>
          <div style='width:50%; display:table-cell;text-align:right'><b>Website: </b> <a href='http://nss.tn.gov.in/index.php' target='_blank' style='color:#ffffff; text-decoration:none;'>nss.tn.gov.in</a></div> <br><br>
          </div></div>
          </td>
          </tr>
          </table></td>
          </tr>
          </table>
          </body>
          </html>"; 
           // $bcc = 'sathishv9897@gmail.com';
  
       $email_sent = smtpmailer($to, $from, $name, $subject, $message,$bcc);
         
    if ($email_sent) 
    { 
    //echo $msg="<span class='textstyle1'>Registered successfully";
    //echo $msg="<span class='textstyle1'><h2>Mail sent successfully</h2>";
    /*echo "<br>";
    echo "<br>";*/
    //echo $msg1="<span class='textstyle2'>Your Username and Password have been sent to : <span class='textstyle'>". $email."</span>";
 
 
    }
    else
    {
    $mail_flag =0;
    echo "Mail not sent....";
    }

    ini_set('max_execution_time', $default);
  } 
    ?>