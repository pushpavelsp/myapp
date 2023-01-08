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

    $district2=$db->query("SELECT district_code, $districtname as district_name  FROM district  order by district_name");  
	$district22=$district2->fetchAll(PDO::FETCH_ASSOC); 
	foreach ($district22 as $district22key => $district22value) {   
		$district_codes2[$district22value['district_code']]=$district22value['district_name'];  
	}   

	if(isset($_POST['approve_spcamp_from'])){
		$approve_spcamp_from = stripQuotes(killChars($_POST['approve_spcamp_from']));
		$approve_spcamp_to = stripQuotes(killChars($_POST['approve_spcamp_to']));   
		$approve_spcamp_place = stripQuotes(killChars($_POST['approve_spcamp_place']));   
		$approve_spcamp_district = stripQuotes(killChars($_POST['approve_spcamp_district']));  
		try {      
			$insert_query = $db->query("INSERT INTO approve_spec_camp(approve_spcamp_from, approve_spcamp_to, approve_spcamp_place, approve_spcamp_district) VALUES ('$approve_spcamp_from','$approve_spcamp_to', '$approve_spcamp_place', '$approve_spcamp_district');");
          
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
    			<li class="breadcrumb-item active" aria-current="page" href="">Approve Special Camp</li>
  			</ol>
		</nav>
			<!-- Form grid Start -->
			<div class="container pd-20 card-box mb-30">
				<div class="clearfix">
					<div class="pull-left">
						<h4 class="text-blue h4">Add Special Camp Details for Approval:</h4>
					</div> 
				</div>
				<form id="regact-form">
					<div class="row">
                    <div class="col-md-3 col-sm-12">
							<div class="form-group">
                                <label>From Date<span class="required_symbol">*</span></label> 
								<input type="date" class="form-control" name="approve_spcamp_from" id="approve_spcamp_from">	
							</div>
						</div>
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
                                <label>To Date<span class="required_symbol">*</span></label> 
								<input type="date" class="form-control" name="approve_spcamp_to" id="approve_spcamp_to">	
							</div>
						</div>
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
                                <label>Place of Camp<span class="required_symbol">*</span></label> 
                                <input type="text" class="form-control" name="approve_spcamp_place" id="approve_spcamp_place" onkeypress="return allowOnlyLetters(event ,'');">
								<span id="lbl" class="required_error_msg"></span>
                            </div>
						</div>
                        <div class="col-md-3 col-sm-12">
              				<div class="form-group">
                				<label ><?php echo $labels['district'];?><span class="required_symbol">*</span></label>  
                				<select class="custom-select col-12" name="approve_spcamp_district" id="approve_spcamp_district">
                 					<option value="" hidden="true">Choose...</option>
                   					<?php   
                 	 				foreach ($district_codes2 as $district_codeskey => $district_codesvalue){ 
                    				if($college_echo['col_district']==$district_codeskey){  ?> 
                      				<option value="<?php echo $district_codeskey;?>" selected><?php echo $district_codesvalue;?></option>
                    				<?php }else{  ?> 
                      				<option value="<?php echo $district_codeskey;?>"><?php echo $district_codesvalue;?></option>
                    				<?php   } }  ?> 
                				</select>
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