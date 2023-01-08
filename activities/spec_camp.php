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
	
	if(isset($_POST['spcamp_from'])){ 
		$vol_id = '2'; 
		$uni_id = '2';  
		$clg_id = '2';  
		$po_id = '2';  
		$spcamp_from = $_POST['spcamp_from'];
		$spcamp_to = $_POST['spcamp_to'];   
		$spcamp_place = stripQuotes(killChars($_POST['spcamp_place']));   
		$spcamp_activity = stripQuotes(killChars($_POST['spcamp_activity']));   
		$spcamp_exp = stripQuotes(killChars($_POST['spcamp_exp']));   
		$spcamp_suggest = stripQuotes(killChars($_POST['spcamp_suggest']));   
		try {      
			$insert_query = $db->query("INSERT INTO spec_camp(vol_id,uni_id,clg_id,po_id, spcamp_from, spcamp_to, spcamp_place, spcamp_activity, spcamp_exp, spcamp_suggest)VALUES ('$vol_id','$uni_id','$clg_id','$po_id', '$spcamp_from','$spcamp_to', '$spcamp_place', '$spcamp_activity', '$spcamp_exp', '$spcamp_suggest');");  
			$datainsert = 'insert';
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
    			<li class="breadcrumb-item active" aria-current="page" href="">Special Camp</li>
  			</ol>
		</nav>
			<!-- Form grid Start -->
			<div class="container pd-20 card-box mb-30">
				<div class="clearfix">
					<div class="pull-left">
						<h4 class="text-blue h4">Add Special Camp Details:</h4>
					</div> 
				</div>
				<form id="spcamp-form">
					<div class="row">
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
                                <label>From Date<span class="required_symbol">*</span></label> 
								<input type="date" class="form-control" name="spcamp_from" id="spcamp_from">	
							</div>
						</div>
                        <div class="col-md-3 col-sm-12">
							<div class="form-group">
                                <label>To Date<span class="required_symbol">*</span></label> 
								<input type="date" class="form-control" name="spcamp_to" id="spcamp_to">	
							</div>
						</div>
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
                                <label>Place of Camp<span class="required_symbol">*</span></label> 
                                <input type="text" class="form-control" name="spcamp_place" id="spcamp_place" onkeypress="return allowOnlyLetters(event ,'');">
								<span id="lbl" class="required_error_msg"></span> 

                            </div>
						</div>
						
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label>Experience<span class="required_symbol">*</span></label><br> 
								<div class="form-check form-check-inline ">
									<input class="form-check-input" type="radio" name="spcamp_exp" id="spcamp_exp" value="1" ?>
									<label class="form-check-label">Bad  &#128545;</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="spcamp_exp" id="spcamp_exp" value="2">
									<label class="form-check-label">Okay &#128528;</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="spcamp_exp" id="spcamp_exp" value="3">
									<label class="form-check-label">Good &#128512;</label>
								</div>
							</div>
						</div>
						
                    </div>
                    <div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
                            <label>Activities Undertaken<span class="required_symbol">*</span></label> 
							<textarea type="text" class="form-control" name="spcamp_activity" id="spcamp_activity" rows="4" cols="50"></textarea>
								<span id="lbl" class="required_error_msg"></span> 
							</div>
						</div>
                        <div class="col-md-6 col-sm-12">
							<div class="form-group">
                            <label>Difficulties faced & Suggesstions<span class="required_symbol">*</span></label> 
							<textarea type="text" class="form-control" name="spcamp_suggest" id="spcamp_suggest" rows="4" cols="50"></textarea>
							<span id="lbl" class="required_error_msg"></span>
							</div>
						</div>
					</div>
					<div class="row"> 
						<div class="col-sm-12">  
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
	$("#spcamp-form").on("submit",function(e) {  
		e.preventDefault();   
		var chek_vald = $("#spcamp-form").valid(); 
		if(chek_vald == true){   
			var formData = new FormData(this);     
			$.ajax({ 
				type:"POST", 
				data:formData, 
				success:function(data){  
					// alert(data);
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