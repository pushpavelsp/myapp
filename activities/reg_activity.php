<?php 
	include "../db_connect.php";   
	include "../commen_php.php";
	$created_date=date("Y/m/d"); 
	// if($_SESSION['unique_ids']==''){    
	// 	header('Location:'.$Base_url21.'login_page.php');  
	// }
	// $unique_ids=$_SESSION["unique_ids"];   
	// if($_SESSION['unique_ids']=='' || $_SESSION['sub_level']==''){    
	// 	header('Location:'.$Base_url21.'login_page.php');  
	// }  
	// $ip=$_SERVER['REMOTE_ADDR']; 
	
	if(isset($_POST['regact_date'])){ 
		$vol_id = '2'; 
		$uni_id = '2';  
		$clg_id = '2';  
		$po_id = '2';  
		$regact_date = stripQuotes(killChars($_POST['regact_date']));
		$regact_place = stripQuotes(killChars($_POST['regact_place']));   
		$regact_details = stripQuotes(killChars($_POST['regact_details']));   
		$regact_from = stripQuotes(killChars($_POST['regact_from']));   
		$regact_to = stripQuotes(killChars($_POST['regact_to']));   
		$regact_hrs = stripQuotes(killChars($_POST['regact_hrs']));   
		// $regact_vol_sign = stripQuotes(killChars($_POST['regact_vol_sign']));   
		// $regact_leader_sign = stripQuotes(killChars($_POST['regact_leader_sign']));   
		$regact_remarks = stripQuotes(killChars($_POST['regact_remarks']));   

		$filename = $_FILES["regact_vol_sign"]["name"];
		$regact_vol_sign = "vol_files/".$filename;
		$filename = $_FILES["regact_leader_sign"]["name"];
		$regact_leader_sign = "leader_files/".$filename;
		try {      
			$insert_query = $db->query("INSERT INTO regular_activity(vol_id,uni_id,clg_id,po_id, regact_date, regact_place, regact_details, regact_from, regact_to, regact_hrs, regact_vol_sign, regact_leader_sign, regact_remarks)VALUES ('$vol_id','$uni_id','$clg_id','$po_id', '$regact_date','$regact_place', '$regact_details', '$regact_from', '$regact_to', '$regact_hrs', '$regact_vol_sign', '$regact_leader_sign', '$regact_remarks');");
			if (!is_dir('vol_files')) {
				mkdir('vol_files');
			  }
			
			if (move_uploaded_file($_FILES["regact_vol_sign"]["tmp_name"], "vol_files/".$filename))  {
				$result = true;
			}
			else{
				$result = false;
			}
			$datainsert='insert'; 
			if (!is_dir('leader_files')) {
				mkdir('leader_files');
			  }
			
			if (move_uploaded_file($_FILES["regact_leader_sign"]["tmp_name"], "leader_files/".$filename))  {
				$result = true;
			}
			else{
				$result = false;
			}
			$datainsert='insert';   
		}catch (PDOException $e) {  
	      $error=$e->getMessage();  
	    } 
		if($error){
			$data_er[]=$error; 
		}else{
			$data_er=$datainsert; 
		}  
		die(json_encode($data_er)); 
	}	
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="nssicon" href="vendors/images/logo-icon.png">
</head>
<?php include "../head.php"; ?> 
<body>
	<?php include "../header.php"; ?> 
	<?php include "../left_menu.php"; ?> 
	<div class=""></div>
	<div class="main-container">
		<div class="pd-ltr-20">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
    			<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    			<li class="breadcrumb-item active" aria-current="page" href="">Regular Activity</li>
  			</ol>
		</nav>
			<!-- Form grid Start -->
			<div class="container pd-20 card-box mb-30">
				<div class="clearfix">
					<div class="pull-left">
						<h4 class="text-blue h4">Add Regular Activity Details:</h4>
					</div> 
				</div>
				<form id="regact-form">
					<div class="row">
						<div class="col-md-2 col-sm-12">
							<div class="form-group">
                                <label>Date of Working<span class="required_symbol">*</span></label> 
								<input type="text" class="form-control date-picker" name="regact_date" id="regact_date">	
							</div>
						</div>
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
                                <label>Place of Working<span class="required_symbol">*</span></label> 
                                <input type="text" class="form-control" name="regact_place" id="regact_place" onkeypress="return allowOnlyLetters(event ,'regact_place');">
								<span id="lblregact_place" class="required_error_msg"></span> 
                            </div>
						</div>
						<div class="col-md-2 col-sm-12">
							<div class="form-group">
                            	<label>Hours of Working From:<span class="required_symbol">*</span></label>
								<input type="text" class="form-control time-picker" name="regact_from" id="regact_from" placeholder="time" >
							</div>
						</div>
						<div class="col-md-2 col-sm-12">
							<div class="form-group">
                            	<label>Hours of Working To:<span class="required_symbol">*</span></label> 
								<input class="form-control time-picker" placeholder="time" type="text" name="regact_to" id="regact_to">
							</div>
						</div>
						<div class="col-md-2 col-sm-12">
							<div class="form-group">
                                <label>Total Working Hours<span class="required_symbol">*</span></label> 
                				<input type="text" class="form-control" name="regact_hrs" id="regact_hrs" onkeypress="return isNumber(event);">
								<span id="lblregact_hrs" class="required_error_msg"></span> 
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
                            <label>Details of Work<span class="required_symbol">*</span></label> 
                            <textarea type="text" class="form-control" name="regact_details" id="regact_details"></textarea>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
                            <label>Remarks<span class="required_symbol">*</span></label> 
                            <textarea rows="3" type="text" class="form-control" name="regact_remarks" id="regact_remarks"></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
                                <label>Signature of Volunteer<span style="color: green;font-size: small;"> jpg,jpeg,png(250kb)</span><span class="required_symbol">*</span></label> 
                                <input type="file" class="form-control" name="regact_vol_sign" id="regact_vol_sign" onchange="return fileValidation('regact_vol_sign','err_msg');">
								<span id="err_msg" class="required_error_msg"></span>
                            </div>
						</div>
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
                            <label>Signature of Group Leader<span style="color: green;font-size: small;"> jpg,jpeg,png(250kb)</span><span class="required_symbol">*</span></label> 
                            <input type="file" class="form-control" name="regact_leader_sign" id="regact_leader_sign" onchange="return fileValidation('regact_leader_sign','error_msg');">
							<span id="error_msg" class="required_error_msg"></span>
							</div>
						</div>
						<div class="col-md-4 col-sm-12">
							<button type="submit" class="btn btn-primary form_submitbtn_style">Save</button>
						</div>
					</div>
				</form> 
			</div>
			<!-- Form grid End -->
		</div>
		<?php include "../footer.php"; ?> 
	</div>
</div> 
<?php include "../common_js.php";?>    
<script type="text/javascript">   
	$("#regact-form").validate({
rules: {
	regact_date: {
		required: true, 
	}, 
	regact_place: {
		required: true, 
	},
	regact_details: {
		required: true, 
	}, 
	regact_from: {
		required: true, 
	},
	regact_to: {
		required: true, 
	},
	regact_hrs: {
		required: true, 
	},
	regact_vol_sign: {
		required: true, 
	},
	regact_leader_sign: {
		required: true, 
	},
	regact_remarks: {
		required: true, 
	},
	
},
messages: { 
	regact_date: "Please Select a Date",
	regact_place: "Please Enter a Place",
	regact_details: "Please Enter Activity Details",
	regact_from: "Please Enter a From Time",
	regact_to: "Please Enter a To Time",
	regact_hrs: "Please Enter Total Number of Hours",
	regact_vol_sign: "Please Upload Volunteer's Digital Sign",
	regact_leader_sign: "Please Upload Group Leader's Digital Sign",
	regact_remarks: "Please Enter Remarks",


}, 
}); 



	$("#regact-form").on("submit",function(e) {  
		e.preventDefault();   

		var chek_vald = $("#regact-form").valid(); 
		if(chek_vald == true){   
			var formData = new FormData(this);     
			$.ajax({ 
				type:"POST", 
				data:formData, 
				success:function(data){  //alert(data);
					var result = JSON.parse(data.replace(/^\s+|\s+$/gm,'')); 
					if(result=='insert'){  
						toastr.success('Data Successfully Inserted');  
						setTimeout(function() {window.location.reload();}, 1000);  
					}else if(result[0] !=''){    
						Swal.fire(''+result+''); 
					} 
				}, 
				cache: false,
				contentType: false,
				processData: false 
			});    
		} 
	}); 
</script> 
</body>
</html>