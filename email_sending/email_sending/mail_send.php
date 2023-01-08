<?php 
    $mail_flag ='';
    $default = ini_get('max_execution_time');
    ini_set('max_execution_time', 0);
    date_default_timezone_set('Asia/Kolkata');
    //include_once('connection.php');

    
 //$dsn = "pgsql:host=192.168.200.210;port=5432;dbname=tn_awards;user=postgres;password=postgres";
 //$dsn = "pgsql:host=14.139.180.171;port=5432;dbname=awards;user=postgres;password=postgres";
 //$dsn = "pgsql:host=localhost;port=5432;dbname=awards;user=postgres;password=postgres";
 //try
 //{
  // create a PostgreSQL database connection
 // $mypdo = new PDO($dsn);
  //$db=$mypdo;
  // display a message if connected to the PostgreSQL successfully
 // if($mypdo)
 // {
    //print_r($mypdo);
  // echo "Connected to the xx <strong></strong> current database successfully!"; exit;
 // }
 //}catch (PDOException $e)
 //{
  // report error message
  //echo $e->getMessage();
 //}


require 'nicmail.php';

    //$qry = "select email, pwd from citizen where (ctime::timestamp::date) order by ctime";
   // $qry="select email, pwd,ctime from citizen where (ctime::timestamp::date)=current_date order by ctime";
 // echo $qry; exit;
   /// $stmt= $mypdo->query($qry);		
//$result = $stmt->fetchAll();


    $cnt=0;
  // echo "<pre>";print_r($result); exit;
   // foreach($result as $key => $value){
        $email = $value['email'];
    //    $pwd = $value['pwd'];
       $email = 's.gomathi2010@gmail.com';
        $pwd = 'test';
        $subject = 'NSS- Tamil Nadu - New User Registration - Login details';
        //$email = 's.gomathi@nic.in';
        //$email = 'sathishv9897@gmail.com';
        //$email = 'krish@tn.gov.in';
        $name = 'NSS Tamil Nadu';
        $to      = $email;
        $pwd = 'test';

     
    
        $body = "Your Login is - <b><font color='blue'> ".$email." </font></b> <br> Password is - <b><font color='blue'>".$pwd."</font></b>";


				$message="<html><head>
					<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
					<title>Register Detail</title></head><body>
					<table width='600' border='0' align='center' cellpadding='0' cellspacing='0'>
					<tr>
					<td align='left' valign='top'><img src='https://awards.tn.gov.in/img/mail_header.jpg' width='600' height='90' style='display:block;'></td>
					</tr>
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
					<div style='width:100%; display:table-row;'><div style='width:100%; text-align:left; display:table-cell;'><b>Contact Us : </b>Namakkal Kavignar Maaligai, Secretariat, Chennai - 600 009.</div></div><br>
					<div align='center' style='width:100%; display:table;'>
					
					<div style='display:table-row; width:100%'><div style='width:50%; display:table-cell;text-align:left;'><b>Email:</b> <a href='mailto:awards@tn.gov.in' style='color:#ffffff; text-decoration:none;'>awards@tn.gov.in</a></div>
					<div style='width:50%; display:table-cell;text-align:right'><b>Website: </b> <a href='http://awards.tn.gov.in/index.php' target='_blank' style='color:#ffffff; text-decoration:none;'>awards.tn.gov.in</a></div> <br><br>
					</div></div>
					</td>
					</tr>
					</table></td>
					</tr>
					</table>
					</body>
					</html>";
   // echo $message; exit;
            $bcc = 'sathishv9897@gmail.com';


        //  $message ="test message";
       

       $email_sent = smtpmailer($to, $from, $name, $subject, $body,$bcc);
        

 
//exit;
    







    //print_r(smtpmailer($to, $from, $name, $subj, $msg));
   // $email_sent = smtpmailer($to, $from, $name, $subject, $message);

    if ($email_sent) 
    { 
    //echo $msg="<span class='textstyle1'>Registered successfully";
    echo $msg="<span class='textstyle1'><h2>Mail sent successfully</h2>";
    echo "<br>";
    echo "<br>";
    //echo $msg1="<span class='textstyle2'>Your Username and Password have been sent to : <span class='textstyle'>". $email."</span>";

    echo "<br>";
    echo "<br>";

    $link_address = 'login.php';
    //echo "<a href='".$link_address."'><span class='red'>Click here to Login</span></a>";



    $mail_flag =1;
      $cnt=$cnt+1;
    }
    else
    {
    $mail_flag =0;
    echo "Mail not sent....";
    }

    ini_set('max_execution_time', $default);
    //echo "***";
    //print_r ($_SESSION['mail_flag']);		//-------------------------------

	 //  }
	   //echo $cnt;
    ?>