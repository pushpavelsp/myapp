<?php  
include "../db_connect.php";
include "../commen_php.php";
$ip=$_SERVER['REMOTE_ADDR']; 
if(isset($_SESSION["langtype"])){
	$langtypee=$_SESSION["langtype"] ? $_SESSION['langtype'] : '1';
}else{
	$langtypee=1;
}

$unique_ids=$_SESSION["unique_ids"];  
//$created_date=$_SESSION["created_date"];  
if($langtypee=='1'){ 
	$desig_name= "desig_name_tamil"; 
	$job_typee= "job_type_tamil"; 
	$districtname= "district_tname";
}elseif($langtypee=='2'){ 
	$desig_name= "desig_name_english";
	$job_typee= "job_type_english";
	$districtname= "district_name";
}else{
	$desig_name= "desig_name_tamil"; 
	$job_typee= "job_type_tamil"; 
	$districtname= "district_tname";
} 
if(isset($_SESSION["langtype"])){
  $langtypee=$_SESSION["langtype"] ? $_SESSION['langtype'] : '1';
}else{
  $langtypee=1;
}

 

if(isset($_POST['ids'])){  
	$idss= stripQuotes(killChars(trim($_POST['ids'])));  
	$coordinator = $db->query("SELECT * FROM coordinator where coord_id='$idss'");
	$coordinator1=$coordinator->fetch(PDO::FETCH_ASSOC);  
}else{
	header("Location:all_coordinator.php"); 
}    
//print_r($coordinator1);exit; 


$gender=$db->query("SELECT gender_id,gender_name  FROM gender");  
$gender1=$gender ->fetchAll(PDO::FETCH_ASSOC); 
foreach ($gender1 as $genderkey => $gendervalue) { 
	$gender_id[$gendervalue['gender_id']]=$gendervalue['gender_name']; 
} 



$designation = $db->query("SELECT desig_id,$desig_name as desig_name from designation"); 
$designation1=$designation->fetchAll(PDO::FETCH_ASSOC); 

$job_type2 = $db->query("SELECT job_id,$job_typee as job_name from job_type"); 
$job_type1=$job_type2->fetchAll(PDO::FETCH_ASSOC); 

$district=$db->query("SELECT district_code, $districtname as district_name  FROM district  order by district_name");  
$district1=$district->fetchAll(PDO::FETCH_ASSOC); 
foreach ($district1 as $districtkey => $districtvalue) { 
  $district_codes[$districtvalue['district_code']]=$districtvalue['district_name'];    
} 

?>

<!DOCTYPE html>
<html>
<?php include "../head.php"; ?> 
<body> 
	<?php 
	include "../header.php";  
	include "../left_menu.php"; ?>
	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20">
			<!-- Form grid Start -->
			<div class="pd-20 card-box mb-30">
				<!-- <div class="clearfix">
					<div class="pull-left">
						<h4 class="text-blue h4"><?php echo $labels['lbl_add_coord'];?></h4> 
					</div> 
				</div> -->
				<div class="row">
          <div class="col-md-10 col-sm-12">
          <h4 class="text-blue h4">View Coordinator Details</h4>
          </div> 
          <div class="col-md-2 col-sm-12">
            <a href=""><button class="btn btn-primary"><i class="icon-copy ion-arrow-left-a">&nbsp; Back</i></button></a>
          </div> 
        </div>
				<form id="coordinator_form_id"> 			
					<div class="row"> 
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['coord_name'];?><span class="required_symbol"><?php echo $labels['in_english'];?> *</span></label>
								<input type="text" class="form-control disabled" name="coord_name" id="coord_name" onkeypress="return allowOnlyLetters(event ,'coord_name');" value="<?php echo $coordinator1['coord_name'];?>">
								<span id="lblcoord_name" class="required_error_msg"></span> 
							</div>
						</div> 
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['coord_name_tamil'];?><span class="required_symbol"><?php echo $labels['in_tamil'];?> *</span></label>
								<input type="text" class="form-control disabled" name="coord_name_tamil" id="coord_name_tamil"  value="<?php echo $coordinator1['coord_name_tamil'];?>">
								<span id="lblcoord_name_tamil" class="required_error_msg"></span>
							</div>
						</div>
					
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['dob'];?><span class="required_symbol">*</span></label>
								<input type="text" class="form-control disabled" name="coord_dob" id="coord_dob" value="<?php echo $coordinator1['dob'];?>"> 
								<span id="lblcoord_dob" class="required_error_msg"></span>
							</div>
						</div>
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['gender'];?> <span class="required_symbol">*</span></label><br>
								<select name="coord_gender" placeholder="Select Gender" id="coord_gender" class="form-control disabled">   
									<?php  
									foreach ($gender_id as $geneder_idkey => $geneder_idvalue) { 
										if($coordinator1['gender']==$geneder_idkey){ ?> 
											<option value="<?php echo $geneder_idkey;?>" selected><?php echo $geneder_idvalue;?></option>
										<?php	}
										?> 
										<option value="<?php echo $geneder_idkey;?>"><?php echo $geneder_idvalue;?></option>
									<?php  } ?>
								</select>
								<span id="lbluni_name" class="required_error_msg"></span>

							</div>
						</div>
						
					</div> 	
					<div class="row"> 
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['mobileno'];?><span class="required_symbol">*</span></label>
								<input type="text" class="form-control disabled"  name="coord_mobile" id="coord_mobile" maxlength="10" onkeypress="return isNumber(event);" onchange="check_countdata(this.value,'coordinator','coord_mobile','coord_mobile');" onkeyup="firstnumvalid(this.value,'coord_mobile');" value="<?php echo $coordinator1['coord_mobileno'];?>"> 
								<span id="lblcoord_mobile" class="required_error_msg"></span> 
							</div>
						</div> 
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['coord_email'];?><span class="required_symbol">*</span></label>
								<input type="text"  class="form-control emailcls mailcls disabled" name="coord_email" id="coord_email" onchange="check_countdata(this.value,'login_details','email','coord_email');mailvalid('coord_email');"  value="<?php echo $coordinator1['coord_mailid'];?>"> 
								<span id="lblcoord_email" class="required_error_msg"></span>
							</div>
						</div> 
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['aadhaarno_r_virtual'];?> </label><br>
								<select name="aadhaarno_r_virtual" id="aadhaarno_r_virtual" class="form-control disabled" onchange="select_proof(this.value);"> 
							<?php 
							if($coordinator1['aadhaarno_r_virtual']==1){ ?>
								<option value="1">Aadhaar Number</option>
							<?php }elseif($coordinator1['aadhaarno_r_virtual']==2){ ?>
								<option value="2">Virtual ID</option> 
							<?php }else{ ?>
								<option hidden="true" value="">Select</option> 
							<?php }
							?>		 
								<option value="1">Aadhaar Number</option>  
								<option value="2">Virtual ID</option>  
								 
								</select>
								<span id="lblaadhaarno_r_virtual" class="required_error_msg"></span>

							</div>
						</div>  
						<div class="col-md-3 col-sm-12"> 
							<div class="form-group aadhaarno"> 
								<label><?php echo $labels['aadhaarno'];?></label>
								<input type="text" class="form-control disabled" name="aadhaar" id="aadhaar" onchange="check_countdata(this.value,'coordinator','aadhaar','aadhaar');aadharverify(this.value,'lblaadhaar','aadhaar');" onkeypress="return isNumber(event);" maxlength="12" value="<?php echo $coordinator1['coord_aadhaar'];?>">
								<span id="lblaadhaar" class="required_error_msg"></span>
							</div> 	
							<div class="form-group virtualid"> 
								<label><?php echo $labels['virtualid'];?></label>
								<input type="text" class="form-control disabled" name="virtualid" id="virtualid" onchange="check_countdata(this.value,'coordinator','virtualid','virtualid');" onkeypress="return isNumber(event);" maxlength="16" value="<?php echo $coordinator1['coord_virtualid'];?>">
								<span id="lblvirtualid" class="required_error_msg"></span>
							</div> 		
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['address'];?><span class="required_symbol">*</span></label>
								<input type="text" class="form-control disabled" name="address" id="address"  value="<?php echo $coordinator1['coord_address'];?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label ><?php echo $labels['district'];?><span class="required_symbol">*</span></label>  
                <select class="form-control disabled" name="coord_district" id="coord_district"> 
                	<option value="">Select District</option>
                   <?php   
                  foreach ($district_codes as $district_codeskey => $district_codesvalue){ 
                    if($coordinator1['coord_district']==$district_codeskey){  ?> 
                      <option value="<?php echo $district_codeskey;?>" selected><?php echo $district_codesvalue;?></option>
                    <?php }else{  ?> 
                      <option value="<?php echo $district_codeskey;?>"><?php echo $district_codesvalue;?></option>
                    <?php   
                  }
                  }  ?> 
                </select>
              </div>  
            </div>
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['pincode'];?><span class="required_symbol">*</span></label> 
                <input type="text" class="form-control disabled" name="coord_pincode" maxlength="6" onkeypress="return isNumber(event,'tot_num_unit');" onkeyup="pincodevalid(this.value,'coord_pincode');" onchange="pincodlength(this.value,'coord_pincode','lblpincode');" id="coord_pincode" value="<?php echo $coordinator1['coord_pincode']?>">
                <span id="lblpincode" style="color: red;font-size: small;"></span>
              </div>
            </div>
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['edu_qulifi'];?><span class="required_symbol">*</span></label>
								<input type="text" class="form-control disabled" name="coord_edu_qulif" id="coord_edu_qulif" onkeypress="return allowOnlyLetters(event,'coord_edu_qulif');" value="<?php echo $coordinator1['edu_qualification'];?>">

								<span id="lbluni_name" class="required_error_msg"></span>
							</div>
						</div>
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['present_position'];?> <span class="required_symbol">*</span></label><br>
								<select name="present_position" placeholder="Select Gender" id="present_position" class="form-control disabled">
									<?php   
									foreach ($designation1 as $designationkey => $designationvalue) { 
										if($coordinator1['present_position']==$designationvalue['desig_id']){  ?>  
											<option value="<?php echo $designationvalue['desig_id'];?>" selected><?php echo $designationvalue['desig_name'];?></option>
										<?php }else{
											?>  
											<option value="<?php echo $designationvalue['desig_id'];?>"><?php echo $designationvalue['desig_name'];?></option>
											<?php  
										}
									} ?> 	 
								</select>
								<span id="lbluni_name" class="required_error_msg"></span>

							</div>
						</div> 
					</div>  
					<div class="row">  
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['job_type'];?> <span class="required_symbol">*</span></label><br>
								<select name="job_type" placeholder="Select Gender" id="job_type" class="form-control disabled">
								<?php   
          foreach ($job_type1 as $job_typekey => $job_typevalue) { 
            if($university_echo['job_type']==$job_typevalue['job_id']){  ?>  
<option value="<?php echo $job_typevalue['job_id'];?>" selected><?php echo $job_typevalue['job_name'];?></option>
            <?php }else{
            ?>  
            <option value="<?php echo $job_typevalue['job_id'];?>"><?php echo $job_typevalue['job_name'];?></option>
          <?php  
      }
    } ?>	  
								</select>
								<span id="lbljob_type" class="required_error_msg"></span> 
							</div>
						</div> 
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['nss_coord_joining_date'];?><span class="required_symbol">*</span></label>
								<input type="text" class="form-control disabled" name="nss_coord_joining_date" id="nss_coord_joining_date" value="<?php echo $coordinator1['doj_nss_coordinator'];?>"> 
								<span id="lblnss_coord_joining_date" class="required_error_msg"></span>
							</div>
						</div> 
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['tot_year_exp_coord'];?><span class="required_symbol">*</span></label> 
								<input type="text" class="form-control disabled" name="tot_year_exp_coord" id="tot_year_exp_coord" maxlength="2" onkeypress="return isNumber(event);"  value="<?php echo $coordinator1['tot_exp_nss_coordinator'];?>">
								<span id="lbltot_year_exp_coord" class="required_error_msg"></span>
							</div>
						</div> 
					</div> 
					<div class="row"> 
						   
						
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['tot_year_exp_po_ofcr'];?><span class="required_symbol">*</span></label> 
								<input type="text" class="form-control disabled" name="tot_year_exp_po_ofcr" id="tot_year_exp_po_ofcr" maxlength="2" onkeypress="return isNumber(event);" value="<?php echo $coordinator1['tot_no_exp_po_officer'];?>">
								<span id="lbltot_year_exp_po_ofcr" class="required_error_msg"></span>
							</div>
						</div>

						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['trained_eti'];?><span class="required_symbol">*</span></label><br>
								<div class="form-check form-check-inline ">
									<input class="form-check-input disabled" type="radio" name="coord_trained_eti" id="coord_trained_eti" value="1" <?php if(trim($coordinator1['trained_eti'])=='1'){ echo 'checked="checked"'; } ?>>
									<label class="form-check-label" for="inlineRadio1" ><?php echo $labels['yes'];?></label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input disabled" type="radio" name="coord_trained_eti" id="coord_trained_eti" value="0" <?php if(trim($coordinator1['trained_eti'])=='0'){ 
									echo 'checked="checked"'; } ?>>
									<label class="form-check-label" for="inlineRadio2"><?php echo $labels['no'];?></label>
								</div> 	 						
							</div>
							<span id="lbluni_name" class="required_error_msg"></span> 
						</div>  
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['eti_trained_year'];?><span class="required_symbol">*</span></label>
								<input type="text" class="form-control disabled" name="eti_trained_year" id="eti_trained_year" value="<?php echo $coordinator1['eti_in_which_year'];?>"> 
								<span id="lbleti_trained_year" class="required_error_msg"></span>
							</div>
						</div>   
					</div>  				 
					
					   
				</form>  
				</div>
				<!-- Form grid End -->
			</div>
		</div>

		<?php include "../footer.php"; ?>  
		<?php include "../common_js.php";?> 
		<script type="text/javascript">  
	select_proof(<?php echo json_encode($coordinator1['aadhaarno_r_virtual'])?>);  
function select_proof(input){  
	if(input==1){
		$('.virtualid').hide();  
		$('.aadhaarno').show(); 
	}else if(input==2){
		$('.virtualid').show();  
		$('.aadhaarno').hide();
	}	
	 
}	
		</script> 
	</body>
	</html>



