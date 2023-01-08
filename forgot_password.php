<?php    
include "db_connect.php";   
require "mail_sent.php";       
$created_date=date('d-m-Y');  
$ip=$_SERVER['REMOTE_ADDR'];

// if(isset($_POST['Email'])){ 
// 	$Email_insert=$_POST['Email'];  
// 	$password=$_POST['password'];
// 	$password2 = password_hash($password,PASSWORD_DEFAULT); 
// 	$confirm_password=$_POST['confirm_password']; 
// 	 //print("UPDATE login_details SET confirm_psw='$confirm_password',password='$password2' where email='$Email_insert'");exit;
// 	$update = $db->query("UPDATE login_details SET confirm_psw='$confirm_password',password='$password2' where email='$Email_insert'");
// 	if($update){
// 		$data='success';
// 	}
// 	 die($data);  
// } 


if(isset($_POST['Emailcheck'])){ 
	$Email=$_POST['Emailcheck'];    
	$count = ($db->query("SELECT * FROM login_details where email='$Email'")->rowCount());   
	if($count !=1){ 
		$statusdata='invalidimail';  
	}elseif($count==1){ 
		//$statusdata='success';   
$otplimit = ($db->query("SELECT * FROM login_details where email='$Email'"));   
$otp_sent_limit=$otplimit->fetch(PDO::FETCH_ASSOC);  
$otp_sent_limit1=$otp_sent_limit['otp_sent_limit']; 
$otp_exceededtime=strtotime($otp_sent_limit['otp_exceededtime']);  
$current_time = strtotime(date("D M d, Y G:i")); 
$fiveMinutes = 60 * 5;
$lastotp_time=(intval($otp_exceededtime)+intval($fiveMinutes));  
$otpnum=genrateotp1();    
	if($otp_sent_limit1 <=5){  
		$set_limit=$otp_sent_limit1+1; 
		if($otp_sent_limit1 !=5){  
			mail_sent(4,$Email,'',$otpnum,''); 
			//$statusdata=$otpnum; 
			$statusdata='success';
			$update = $db->query("UPDATE login_details SET otp='$otpnum', otp_status='1',otp_sent_limit='$set_limit',otp_exceededtime='now()' WHERE email='$Email';");
		}else{  
			if($lastotp_time <$current_time){ 
			$set_limit=0; 
			$update = $db->query("UPDATE login_details SET otp_status='1',otp_sent_limit='$set_limit' WHERE email='$Email';"); 
			mail_sent(4,$Email,'',$otpnum,''); 
			$statusdata='success';
			}else{
				$statusdata='limit_comlite';  
			} 
			
		} 
	}else{
		$set_limit=0;
		$statusdata='limit_comlite'; 
		$update = $db->query("UPDATE login_details SET otp_status='1', otp_sent_limit='$set_limit' WHERE email='$Email';");  
	} 
	 
		$statusdata1=$statusdata; 
	}   
	//print_r($statusdata1);exit;
	die(trim($statusdata1));   
}
 
if(isset($_POST['otp'])){ 
	$otp3=$_POST['otp']; 
	$mailid=$_POST['mailid'];   
	$count = ($db->query("SELECT * FROM login_details where email='$mailid' and otp='$otp3'")->rowCount());  
	 if($count ==1){  
	 	$genrate_psw=password_genrate1();    
	 	$password2 = password_hash($genrate_psw,PASSWORD_DEFAULT); 
	//print_r();exit; 	
	$update = $db->query("UPDATE login_details SET otp_status='2', confirm_psw='$genrate_psw',password='$password2',updated_time='now()',updated_by='$mailid' where email='$mailid'");
	mail_sent(3,$mailid,$genrate_psw,'',''); 
		$verifydata='success';  
	}else{
		$verifydata='not';  
	} 
	die($verifydata);   
} 
 
function genrateotp1(){ 
  $rand_num = mt_rand(100000,999999);  
  return $rand_num;
}

function password_genrate1(){ 
  $bytes = openssl_random_pseudo_bytes(3);
  $pass = bin2hex($bytes);
  return $pass;
}
?> 
<!DOCTYPE html>
<html>
<?php include "head.php"; ?>  
<style type="text/css">
.logininput_icon{
	margin-top: -9px;
    margin-right: 20px;
}	
.logininput_size{
	margin-left: 17px;
}	
.footer-wrap {
    margin-top: 1% !important;
}	
 .forgot-password a:hover{background-color: blue;color:white;}	    
</style> 
 
<body>
	<?php include "header.php"; ?>  
	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		 <?php	 include "../path_menu.php";?>
		<div class="container">
			<div class="row align-items-center">
				<!-- <div class="col-md-6">
					<img src="../vendors/images/forgot-password.png" alt="">
				</div> -->
				<div class="col-md-12">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
							<h2 class="text-center text-primary">Forgot	Password</h2>
						</div> 
						<form id="loginformid">  
						<div class="row">
						  <div class="col-sm-11 logininput_size">
						    <div class="form-group	focus">
						     <input type="text" class="form-control form-control-lg" name="Email" id="Email" placeholder="Email">
						     <div class="input-group-append custom logininput_icon">
									<span class="input-group-text"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
								</div>
								<span id="lblEmail" style="color: red;font-size: small;"></span> 
						    </div>
						  </div> 
						 </div>  
						 <div class="row" id="otpinput">
						  <div class="col-sm-11 logininput_size">
						    <div class="form-group	focus">
						     <input type="text" class="form-control form-control-lg" placeholder="Enter OTP" name="otp" id="otp" maxlength="6" placeholder="Enter OTP" onkeypress="return isNumber1(event,'otp');">
						    </div>
						  </div> 
						   
						 </div>  
						<!--  <div class="row">
						  <div class="col-sm-11 logininput_size">
						    <div class="form-group	focus">
						     <input type="text" class="form-control form-control-lg" placeholder="Password" name="password" id="password" maxlength="8">
						    </div>
						  </div> 
						 </div>   
						 <div class="row">
						  <div class="col-sm-11 logininput_size">
						    <div class="form-group">
						     <input type="text" class="form-control form-control-lg" placeholder="Confirm Password" name="confirm_password" id="confirm_password" maxlength="8">
							 
						    </div> 
						  </div> 
						 </div> --> 
							<div class="row pb-30" id="Resentotp">
								<div class="col-6">
									<!-- <div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="customCheck1">
										<label class="custom-control-label" for="customCheck1">Remember</label>
									</div> -->
								</div> 								
								<div class="col-6">
									<div class="forgot-password" onclick="forgot_mailcheck($('#Email').val());"><a style=""><u>Resend OTP</u></a></div>
								</div>
							</div>
							<div class="row align-items-center"> 
								<div class="col-12">
									<div class="input-group mb-0"> 
									<!--  <button type="button" class="btn btn-primary btn-lg btn-block savebtn"	onclick="save_data();" style="color: white">Login</button> -->
										<button type="button" class="btn btn-primary btn-lg btn-block" id="otpverify_btn" style="color: white" onclick="otpverify('otp');">Verify</button>
										<button type="button" class="btn btn-primary btn-lg btn-block otpbtn1" style="color: white" onclick="forgot_mailcheck($('#Email').val());">Send OTP</button> 
									</div> 
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include "footer.php"; ?> 	 
	 <script type="text/javascript">    
function otpverify(ids) {         
		var opt_number =$('#otp').val();  
		var Emailid2=$('#Email').val();
		if(opt_number !=''){
				 $.ajax({ 
	        type:"POST", 
	        data:{otp:opt_number,mailid:Emailid2}, 
	        success:function(data){   //alert(data);
	          if(data =='not'){  
	             toastr.error('Enter valid OTP');   
	             $('#'+ids+'').val('');
	          }else if(data =='success'){ 
	          	 $('#'+ids+'').prop('disabled', true);   
					Swal.fire(
					  'Good job!',
					  'Password has been sent to your registered Email Id',
					  'success'
					)  
				setTimeout(function() {window.location.href ='<?php echo Base_url?>login_page.php';}, 2500); 	
	          } 
	        } 
	      });
		}else{
			 toastr.error('Enter OTP');  
		}    
} 	 	 
  
 
   
$('.otpbtn1').show();
$('#otpverify_btn,#otp').hide();  
 function forgot_mailcheck(mailid) {  
 	$('#otp').val('');
	var mailid2=mailid;  
	if(mailid2 !=''){  
		 $.ajax({ 
	        type:"POST",	
	        data:{Emailcheck:mailid2}, 
	        success:function(data){    
	         if(data=='invalidimail'){   
	            toastr.error('Enter valid mail Id'); 
	            $('#Email').val('');
	          }else if(data=='limit_comlite'){   
	            toastr.error('You have exceeded OTP limitation please try after 5 minutes');  
	          }else if(data=='success'){   //=='success' 
	          	//alert(data);
	           	toastr.success('OTP sent to your registered Email-Id.');  
	          	 $('#otp').show();
	          	 $('#otpverify_btn').show();
	          	 $('#otpinput,#Resentotp').show();
	          	 $('.otpbtn1').hide();  
	          } 
	        } 
	   });
	}else{
		toastr.error('Enter Valid E-Mail ID'); 
	}  
} 

function isNumber1(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
    return false;
    }
    return true;
  } 

$("#loginformid").validate({
          rules: {   
            Email: 
            {
              required: true,
              email: true,
            },   
          },
          messages: {
               uni_code: "Enter Email Id",  
          },
            
});  
/*function save_data(){ 
	var confirm_password=$('#confirm_password').val();
	var	password=$('#password').val(); 
	if(confirm_password==password){ 
		var formdata =$("#loginformid").serialize();
		 $.ajax({ 
	        type:"POST",	
	        data:formdata, 
	        success:function(data){   
	          if(data =='success'){  
	          	  toastr.success('Password Updated Successfully');  
            	 setTimeout(function() {window.location.reload();}, 1000); 
	          } 
	        } 
	   	}); 
	}else{  
		toastr.error('Enter valid Password'); 
		$('#confirm_password').val('');
	} 
}*/
 
	 </script>

	  
</body>

</html>