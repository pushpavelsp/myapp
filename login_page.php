<?php    
include "db_connect.php";  
$created_date=date('d-m-Y');  
$ip=$_SERVER['REMOTE_ADDR']; 
if(isset($_POST['Email'])){ 
	$Email=strtolower($_POST['Email']); 
	$password=$_POST['password'];  
$countpassword1 = ($db->query("SELECT * FROM login_details where email='$Email'"));   
		$session_name=$countpassword1->fetch(PDO::FETCH_ASSOC);
		$passwordd=$session_name['password'];   
		$password2=password_verify($password,$passwordd);  

		if($password2 ==1){  
			
				$_SESSION["unique_ids"]=$session_name['user_reference_id'];    
				$_SESSION["email"]=$session_name['email'];    
				$_SESSION["level_code"]=$session_name['level_code']; 
				$_SESSION["approve_status"]=$session_name['approve_status']; 
				$_SESSION["sub_level"]=$session_name['sub_level_code']; 
		if($session_name['level_code'] ==1)	
			{	 
				if($session_name['approve_status']==1 && $session_name['user_reference_id']=='11'){
				 $datas['page']='settings_layout/add_lable.php';
				}else{
				  $datas['page']='login_page.php'; 
				}  
			}elseif($session_name['level_code'] ==5)	
			{	 	
				if($session_name['approve_status']==1 && $session_name['user_reference_id']=='11'){
				 $datas['page']='nss/dashboard.php';
				}else{
				  $datas['page']='login_page.php'; 
				}  
			}elseif($session_name['level_code'] ==10)	
			{	 
				if($session_name['approve_status']==1){
				 $datas['page']='university/university_details.php';
				}else{
				  $datas['page']='login_page.php'; 
				}  
			}elseif($session_name['level_code'] ==15)	
			{    
				if($session_name['approve_status']=='1' && $session_name['user_reference_id'] !=''){
				  $datas['page']='coordinator/coordinator_details.php';
				}else{
				  $datas['page']='login_page.php'; 
				}  
			}elseif($session_name['level_code'] ==20)	
			{   
				if($session_name['approve_status']=='1' && $session_name['user_reference_id']=='11' && $session_name['sub_level_code']=='1'){
				 $datas['page']='college/add_college.php'; 
				}elseif($session_name['approve_status']=='1' && $session_name['user_reference_id'] !=''){
				 $datas['page']='college/update_college.php';
				}else{
				  $datas['page']='login_page.php'; 
				}   
			}elseif($session_name['level_code'] ==25)	
			{ 
				if($session_name['approve_status']==1 && $session_name['user_reference_id'] !=''){
				 $datas['page']='po_officer/update_po.php';
				}else{
				  $datas['page']='login_page.php'; 
				}  
			}elseif($session_name['level_code'] ==30)	
			{ 
				if($session_name['approve_status']=='1' && $session_name['user_reference_id']=='11' && $session_name['sub_level_code']=='1'){
				 $datas['page']='volunteer/add_volunteer.php'; 
				}elseif($session_name['approve_status']==1 && $session_name['user_reference_id'] !=''){
				 $datas['page']='volunteer/profile_volunteer.php';
				}else{
				  $datas['page']='login_page.php'; 
				}
			}else{
				$datas['page']='login_page.php'; 
			}
			
			 $access_status=1;
			 $audit = $db->query("INSERT INTO audit_trail(username,ip_address,access_datetime,access_status,reason) VALUES ('$Email','$ip',now(),$access_status,'success')");   
			 $datas['status']='success'; 
	}else{
		 $datas['status']='notsuccess'; 
	} 

	die(json_encode($datas));   
}

/*if(isset($_POST['login_mail_check'])){ 
	$Email=$_POST['login_mail_check'];  
	$count = ($db->query("SELECT * FROM login_details where email='$Email'")->rowCount());   
	if($count !=1){ 
		$statusdata='invalidimail';  
		 $access_status=0;
		 //print_r();exit; 
		 $audit = $db->query("INSERT INTO audit_trail(username,ip_address,access_datetime,access_status,reason) VALUES ('$Email','$ip',now(),$access_status,'invalid mail id')");  
	}  
	die(trim($statusdata));   
}*/

/*if(isset($_POST['mailid'])){ 
	$mailid=$_POST['mailid'];  
	$password=$_POST['password']; 
$select = $db->query("SELECT * FROM login_details where email='$mailid'");
$selectdata=$select->fetch(PDO::FETCH_ASSOC)['password'];//print_r($selectdata);exit; 
$password2=password_verify($password,$selectdata); 
	if($password2==1){
		$data='success';
	}else{
		$access_status=0;
		$audit = $db->query("INSERT INTO audit_trail(username,ip_address,access_datetime,access_status,reason) VALUES ('$mailid','$ip',now(),$access_status,'invalid mail password')");   
	}
	 die($data);  
	} */

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
/*.align-items-center{
    margin-top: -3% !important;
}*/	    
</style> 
<style>
 
 
  
.CaptchaWrap { position: relative; }
.CaptchaTxtField { 
  border-radius: 5px; 
  border: 1px solid #ccc;  
  box-sizing: border-box;
}
 
#CaptchaImageCode { 
  text-align:center;
  margin-top: 15px;
  padding: 0px 0;
  width: 280px;
  overflow: hidden;
}

.capcode { 
  font-size: 35px; 
  display: block; 
  -moz-user-select: none;
  -webkit-user-select: none;
  user-select: none; 
  cursor: default;
  letter-spacing: 1px;
  color: #ccc;
  font-family: 'Roboto Slab', serif;
  font-weight: 100;
  font-style: italic;
}

.ReloadBtn { 
  background:url('<?php echo Base_url;?>vendors/images/refresh3.webp') left top no-repeat;   
  background-size : 100%;
  width: 32px; 
  height: 32px;
  border: 0px; outline none;
  position: absolute; 
  bottom: 30px;
  left : 293px;
  outline: none;
  cursor: pointer; /**/
} 

.error { 
  color: red; 
  font-size: 12px;  
}
.success {
  color: green;
  font-size: 18px;
  margin-bottom: 15px; 
}

</style> 
<body>
	<?php include "header.php"; ?>  
	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<!-- <div class="col-md-6">
					<img src="../vendors/images/forgot-password.png" alt="">
				</div> -->
				<div class="col-md-12">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
							<h2 class="text-center text-primary">Login</h2>
						</div> 
						<form id="loginformid">  
						<div class="row">
						  <div class="col-sm-11 logininput_size">
						    <div class="form-group">
						     <input type="text" class="form-control form-control-lg clrinput" name="Email" id="Email" placeholder="Email" onchange="login_mailcheck('Email');">
						     <div class="input-group-append custom logininput_icon">
									<span class="input-group-text"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
								</div>
								<span id="lblEmail" style="color: red;">Enter Email ID</span> 
						    </div>
						  </div> 
						 </div>  
						 <div class="row">
						  <div class="col-sm-11 logininput_size">
						    <div class="form-group">
						     <input type="password" class="form-control form-control-lg clrinput" placeholder="**********" name="password" id="password" maxlength="8">
								<div class="input-group-append custom logininput_icon">
									<span class="input-group-text"><i class="icon-copy fa fa-user-circle" aria-hidden="true"></i></span>
								</div>  
								<span id="lblpassword" style="color: red;">Enter Password</span> 
						    </div>
						  </div> 
						 </div> 
						 <div class="row">
						 	<div class="col-sm-11 logininput_size">
						    <div class="form-group">
						    	<input type="text" id="UserCaptchaCode" class="CaptchaTxtField form-control form-control-lg clrinput" placeholder='Enter Captcha - Case Sensitive'>
						    	 
	<input type="text" id="imagedata" class="form-control form-control-lg" hidden="">
    <span id="WrongCaptchaError" class="error"></span>
    <div class='CaptchaWrap'>
      <div id="CaptchaImageCode" class="CaptchaTxtField">
        <canvas id="CapCode" class="capcode" width="150" height="30"></canvas>
      </div> 
      <input type="button" class="ReloadBtn" onclick='CreateCaptcha();'> 
    </div>
   
						    </div>
						    </div>
						 	  
						 </div>
							<div class="row pb-30">
								<div class="col-6">
									<!-- <div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="customCheck1">
										<label class="custom-control-label" for="customCheck1">Remember</label>
									</div> -->
								</div>
								<div class="col-6">
									<div class="forgot-password"><a href="forgot_password.php">Forgot Password ?</a></div>
								</div>
							</div>
							<div class="row align-items-center"> 
								<div class="col-12">
									<div class="input-group mb-0"> 
										<button type="button" class="btn btn-primary btn-lg btn-block Loginbtn" onclick="save_fun();" style="color: white">Login</button>
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
	<!-- js --> 
	 <script type="text/javascript">  

var Base_urlas='<?php echo Base_url;?>';   
 
$('#lblEmail').hide();
$('#lblpassword').hide(); 
 function save_fun(){  
	var Email_val = $("#Email").val(); 
	var password_val = $("#password").val(); 
	var Captcha_val = $("#UserCaptchaCode").val();
	var imagedata=$('#imagedata').val(); 
	if(Email_val !=''){  
	if(password_val !=''){  
	if(Captcha_val !='' && imagedata==Captcha_val){   
	  $.ajax({ 
	        type:"POST", 
	        data:{Email:Email_val,password:password_val}, 
	        success:function(data){    
	        	var dataas=JSON.parse(data);	//console.log(data); 
	          if(dataas['status']=='success'){  
	          	window.location.href=''+dataas['page']+'';
	          }else if(dataas['status']=='notsuccess'){  
	             toastr.error('Enter valid credentials');    
	              //setTimeout(function() {window.location.reload();}, 1000); 
	              CreateCaptcha();
		    	$(".clrinput").val('');
	          } 
	        } 
	      });
	}else{  
		 CreateCaptcha()
		 toastr.error('Enter Valid Captcha');  
	}
	}else{
		$('#lblpassword').show();
	}
	}else{  
		 $('#lblEmail').show(); 
	} 
}  
 

function login_mailcheck(mailids) {  
  var a=$('#'+mailids+'').val();
      var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
      if (reg.test(a) == false ) 
        {   
          toastr.error('Enter Valid Email ID'); 
          $('#'+mailids+'').val('');
          $('#'+mailids+'').val('').focus(); 
           return false;
        }   
        return true;
} 

/*function login_mailcheck(mailid) {  
	var mailid2=mailid;  
	if(mailid2 !=''){
		 $.ajax({ 
	        type:"POST",	
	        data:{login_mail_check:mailid2}, 
	        success:function(data){    
	         if(data=='invalidimail'){   
	            toastr.error('Enter  Valid Email ID'); 
	            $('#Email').val('');
	          } 
	        } 
	   });
	}else{
		toastr.error('Enter Valid Email ID'); 
	}  
}*/

/*
function check_login_password() {  
	var Emailid=$('#Email').val();
	var password1=$('#password').val();
	if(Emailid !='' && password1 !=''){ 
		 $.ajax({ 
	        type:"POST",	
	        data:{mailid:Emailid,password:password1}, 
	        success:function(data){    
	         if(data !='success'){  
	         	 toastr.error('Enter Valid Password'); 
	         	 $('#password').val(''); 	 
	          }  
	        } 
	   });
	}else{
		toastr.error('First Enter Email ID and Password');
		$('#password').val(''); 
	}

} */
	  
/*$("#Capthamatch").hide(); 
function captchavalue(){
	var UserCaptchaCodead=$('#UserCaptchaCode').val();
var imagedata=$('#imagedata').val();  
if(UserCaptchaCodead==imagedata){   
	$("#Capthamatch").hide();   
}else{   
	toastr.error('Enter Valid Captcha');  
	$("#Capthamatch").show();  
} 
}*/
 

var cd;

$(function(){
  CreateCaptcha();
});

// Create Captcha
function CreateCaptcha() { 
  var alpha = new Array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                    
  var i;
  for (i = 0; i < 6; i++) {
    var a = alpha[Math.floor(Math.random() * alpha.length)];
    var b = alpha[Math.floor(Math.random() * alpha.length)];
    var c = alpha[Math.floor(Math.random() * alpha.length)];
    var d = alpha[Math.floor(Math.random() * alpha.length)];
    var e = alpha[Math.floor(Math.random() * alpha.length)];
    var f = alpha[Math.floor(Math.random() * alpha.length)];
  }
  cd = a + '' + b + '' + c + '' + d + '' + e + '' + f;
  $('#CaptchaImageCode').empty().append('<canvas id="CapCode" class="capcode" width="300" height="80"></canvas>')   
  var imagedatas2=cd.trim();   
   $('#imagedata').val(imagedatas2); 
  var c = document.getElementById("CapCode"), 
      ctx=c.getContext("2d"),
      x = c.width / 2,
      img = new Image();

  img.src = ""+Base_urlas+"vendors/images/captcha-img.jpg";
  img.onload = function () {
      var pattern = ctx.createPattern(img, "repeat");
      ctx.fillStyle = pattern;
      ctx.fillRect(0, 0, c.width, c.height);
      ctx.font="46px Roboto Slab";
      ctx.fillStyle = '#ccc';
      ctx.textAlign = 'center';
      ctx.setTransform (1, -0.12, 0, 1, 0, 15);
      ctx.fillText(cd,x,55);
  };
  
  
}

// Validate Captcha
function ValidateCaptcha() {
  var string1 = removeSpaces(cd);
  var string2 = removeSpaces($('#UserCaptchaCode').val());
  if (string1 == string2) {
    return true;  
  }
  else {
    return false;  
  }
} 
// Remove Spaces
function removeSpaces(string) {
  return string.split(' ').join('');
}
 
</script>
	 
</body>

</html>