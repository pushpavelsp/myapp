<?php    
include "db_connect.php";   
$created_date=date('d-m-Y'); 
if($_SESSION['unique_ids']==''){    
    header('Location:'.$Base_url21.'login_page.php');  
}
$unique_ids=$_SESSION["unique_ids"];
$email_id=$_SESSION["email"]; 
$login_level=$_SESSION["level_code"];  
$ip=$_SERVER['REMOTE_ADDR'];

 
if(isset($_POST['mailid'])){ 
	$mailid=$_POST['mailid'];  
	$oldpsw=$_POST['oldpsw']; 
$select = $db->query("SELECT * FROM login_details where email='$mailid'");
$selectdata=$select->fetch(PDO::FETCH_ASSOC)['password'];//print_r($selectdata);exit; 
$password2=password_verify($oldpsw,$selectdata); 
	if($password2==1){
		$data='success';
	}
	 die($data);  
}  
if(isset($_POST['Emailcheck'])){ 
	$Email=$_POST['Emailcheck'];  
	$count = ($db->query("SELECT * FROM login_details where email='$Email'")->rowCount());   
	if($count !=1){ 
		$statusdata='invalidimail';  
	}  
	die(trim($statusdata));   
}

if(isset($_POST['mailid2'])){ 
	$mailid2=$_POST['mailid2'];  
	$psw=$_POST['psw']; 
	$password2 = password_hash($psw,PASSWORD_DEFAULT);  
$update_qury = $db->query("UPDATE login_details SET confirm_psw='$psw',password='$password2' where email='$mailid2'"); 
	if($update_qury==1){
		$data='success';
	}
	 die($data);  
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
							<h2 class="text-center text-primary">Change	Password</h2>
						</div> 
						<form id="loginformid">  
						<div class="row">
						  <div class="col-sm-11 logininput_size">
						    <div class="form-group	focus">
						     <input type="text" class="form-control form-control-lg" name="Email" id="Email" placeholder="Email" onchange="mailcheck(this.value);">
						     <div class="input-group-append custom logininput_icon">
									<span class="input-group-text"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
								</div>
								<span id="lblEmail" style="color: red;font-size: small;"></span> 
						    </div>
						  </div> 
						 </div>   
						 <div class="row">
						  <div class="col-sm-11 logininput_size">
						    <div class="form-group	focus">
						     <input type="text" class="form-control form-control-lg" placeholder="Old Password" name="oldpassword" id="oldpassword" maxlength="8">
						    </div>
						  </div> 
						 </div>   
						 <div class="row">
						  <div class="col-sm-11 logininput_size">
						    <div class="form-group">
						     <input type="text" class="form-control form-control-lg" placeholder="New Password" name="new_password" id="new_password" maxlength="8">
							 
						    </div> 
						  </div> 
						 </div> 
							 
							<div class="row align-items-center"> 
								<div class="col-12">
									<div class="input-group mb-0"> 
									 <button type="button" class="btn btn-primary btn-lg btn-block savebtn"	onclick="save_data();" style="color: white">Login</button>
									<button type="button" class="btn btn-primary btn-lg btn-block verifybtn" onclick="credential_verify();" style="color: white">Verify</button> 
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
	<script src="vendors/scripts/layout-settings.js"></script>
	 <script type="text/javascript">  
$("#loginformid").validate({     
          rules: {   
            Email: 
            {
              required: true,
              email: true,
            },  
            oldpassword: 
            {
              required: true,  
            },
            new_password: 
            {
              required: true,  
            },  
          },
          messages: {
               uni_code: "Enter enter email",  
               oldpassword: "Please enter Old password",   
               confirm_password: "Please enter New cassword",   
          },
            
      });
   	 
  

 
$('#new_password').hide();  
$('.savebtn').hide();  
//$('#otpinput,#password,#confirm_password,#Resentotp').hide();
 function mailcheck(mailid) {  
	var mailid2=mailid;  
	if(mailid2 !=''){
		 $.ajax({ 
	        type:"POST",	
	        data:{Emailcheck:mailid2}, 
	        success:function(data){    
	         if(data=='invalidimail'){   
	            toastr.error('Enter valid mailid'); 
	            $('#Email').val('');
	          } 
	        } 
	   });
	}else{
		toastr.error('Enter valid mailid'); 
	}  
} 

function credential_verify() {  
	var Emailid=$('#Email').val();
	var oldpassword=$('#oldpassword').val();
	if(Emailid !='' && oldpassword !=''){ 
		 $.ajax({ 
	        type:"POST",	
	        data:{mailid:Emailid,oldpsw:oldpassword}, 
	        success:function(data){    
	         if(data=='success'){ 
	         	$('.verifybtn').hide(); 	  
	         	$('.savebtn').show(); 
	         	$('#new_password').show(); 	 
	          }else{
	          	  toastr.error('Enter valid Password'); 
	          	  $('#oldpassword').val('');
	          } 
	        } 
	   });
	}else{
		toastr.error('Enter Mail and Old Password'); 
	}

} 
 
function save_data(){ 
	var Emailid=$('#Email').val();
	var new_password=$('#new_password').val();
	if(new_password !=''){  
		 $.ajax({ 
	        type:"POST",	
	        data:{mailid2:Emailid,psw:new_password}, 
	        success:function(data){   
	          if(data =='success'){   
            	 Swal.fire(
					  'Good job!',
					  'Password Updated Successfully',
					  'success'
					)  
				setTimeout(function() {window.location.href ='<?php echo Base_url?>login_page.php';}, 2000); 	
	          } 
	        } 
	   	}); 
	}else{  
		toastr.error('Please Enter Password');  
	} 
} 
 
	 </script>

	  
</body>

</html>