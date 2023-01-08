<?php  
include "../db_connect.php";
include "../commen_php.php"; 
if($_SESSION['unique_ids']==''){    
    header('Location:'.$Base_url21.'login_page.php');  
}
$ip=$_SERVER['REMOTE_ADDR'];  
if(isset($_SESSION["langtype"])) {
$langtypee=$_SESSION["langtype"] ? $_SESSION['langtype'] : '1';
} 
else {
$langtypee=1;
} 

$unique_ids=$_SESSION["unique_ids"];  
$login_maill=$_SESSION["email"];  
$created_date=$_SESSION["created_date"];  

if($unique_ids==''){    
header('Location:'.$Base_url21.'login_page.php');  
}

if($langtypee=='1') { 
$districtname= "district_tname";
$desig_name= "desig_name_tamil"; 
$job_typee= "job_type_tamil"; 
}
elseif($langtypee=='2'){ 
$districtname= "district_name";
$desig_name= "desig_name_english";
$job_typee= "job_type_english";
}
else {
$districtname= "district_tname";
$desig_name= "desig_name_tamil"; 
$job_typee= "job_type_tamil";
}
$coordinator=$db->query("SELECT *  FROM coordinator where uni_id='$unique_ids' and active_status='1'");  
$coordinator1=$coordinator ->fetch(PDO::FETCH_ASSOC);
$coordinator_active_status=$coordinator1['active_status'];

 
//print_r($coordinator_data_count);exit;
$gender=$db->query("SELECT gender_id,gender_name  FROM gender");  
$gender1=$gender ->fetchAll(PDO::FETCH_ASSOC); 
foreach ($gender1 as $genderkey => $gendervalue) { 
$gender_id[$gendervalue['gender_id']]=$gendervalue['gender_name']; 
}   
 

if(isset($_POST['coord_id'])){ 
$coord_name = stripQuotes(killChars($_POST['coord_name']));
$coord_id = stripQuotes(killChars($_POST['coord_id'] ? $_POST['coord_id'] : '0'));
$coord_name_tamil = stripQuotes(killChars($_POST['coord_name_tamil']));
$coord_mobile = stripQuotes(killChars($_POST['coord_mobile']));
$coord_email = strtolower(stripQuotes(killChars($_POST['coord_email'])));
$coord_gender = stripQuotes(killChars($_POST['coord_gender']));
$aadhaarno_r_virtual = stripQuotes(killChars($_POST['aadhaarno_r_virtual']));
$coord_aadhaar = stripQuotes(killChars($_POST['coord_aadhaar']));  
$coord_virtualid = stripQuotes(killChars($_POST['coord_virtualid']));  
$coord_edu_qulif = stripQuotes(killChars($_POST['coord_edu_qulif']));  
$present_position = stripQuotes(killChars($_POST['present_position']));  
$job_type = stripQuotes(killChars($_POST['job_type']));  
$nss_coord_joining_date =$_POST['nss_coord_joining_date'];  
$eti_trained_year = $_POST['eti_trained_year'];  
$coord_trained_eti = stripQuotes(killChars($_POST['coord_trained_eti']));  
$coord_dob = $_POST['coord_dob'];  
$coord_age = stripQuotes(killChars($_POST['coord_age']));  
$tot_year_exp_coord = stripQuotes(killChars($_POST['tot_year_exp_coord']));  
$tot_year_exp_po_ofcr = stripQuotes(killChars($_POST['tot_year_exp_po_ofcr']));  
$address = stripQuotes(killChars($_POST['address']));  
$coord_district = stripQuotes(killChars($_POST['coord_district']));   
$coord_pincode = stripQuotes(killChars($_POST['coord_pincode']));
 

$coordinator_data_count=$db->query("SELECT *  FROM coordinator where coord_id='$coord_id' and active_status='1'")->rowCount();
 
try {  
	if($coordinator_data_count=='0'){	
		//print_r();exit; 
		$query1 = $db->query("INSERT INTO coordinator(uni_id, coord_name, coord_name_tamil, gender, dob, coord_mailid, coord_mobileno, coord_address, edu_qualification, present_position, job_type, doj_nss_coordinator, tot_exp_nss_coordinator, tot_no_exp_po_officer, trained_eti, created_by, created_time, created_ip,  aadhaarno_r_virtual, coord_aadhaar, coord_virtualid, coord_district, coord_pincode,eti_in_which_year)VALUES ('$unique_ids','$coord_name','$coord_name_tamil','$coord_gender','$coord_dob','$coord_email','$coord_mobile','$address','$coord_edu_qulif','$present_position','$job_type','$nss_coord_joining_date','$tot_year_exp_coord','$tot_year_exp_po_ofcr','$coord_trained_eti','$coord_email','now()','$ip','$aadhaarno_r_virtual','$coord_aadhaar','$coord_virtualid','$coord_district','$coord_pincode','$eti_trained_year');");   
		$coordinator=$db->query(" SELECT * FROM coordinator ORDER BY coord_id DESC LIMIT 1");   
		$coordinator2=$coordinator->fetch(PDO::FETCH_ASSOC)['coord_id']; 
		$genrate_psw=password_genrate();   
		mail_sent(4,$coord_email,$genrate_psw,'','');  
		$password = password_hash($genrate_psw,PASSWORD_DEFAULT); 
		$login_details = $db->query("INSERT INTO login_details(email, level_code,user_reference_id,updated_time,updated_by,password,confirm_psw,approve_status)VALUES ('$coord_email','15','$coordinator2','now()','$coord_email','$password','$genrate_psw',1);"); 
		$dataas='insert';  
		 
	}elseif($coordinator_data_count==1){  
		
		$query1 = $db->query("UPDATE coordinator SET coord_name='$coord_name', coord_name_tamil='$coord_name_tamil',gender='$coord_gender',dob='$coord_dob',coord_mailid='$coord_email',coord_mobileno='$coord_mobile',coord_address='$address',coord_aadhaar='$coord_aadhaar',edu_qualification='$coord_edu_qulif',present_position='$present_position',job_type='$job_type',doj_nss_coordinator='$nss_coord_joining_date',tot_exp_nss_coordinator='$tot_year_exp_coord',trained_eti='$coord_trained_eti',created_by='$unique_ids',update_time='now()',update_by='$coord_email',coord_pincode='$coord_pincode',eti_in_which_year='$eti_trained_year',aadhaarno_r_virtual='$aadhaarno_r_virtual',coord_virtualid='$coord_virtualid',coord_district='$coord_district',tot_no_exp_po_officer='$tot_year_exp_po_ofcr' WHERE uni_id='$unique_ids';"); 
		$dataas='update';  
		}else{
			$dataas='notinsert';
		}
	 	   
}
catch (PDOException $e) {  
$error1=$e->getMessage();  
} 
if($error1){
$data_error[]=$error1; 
} 
else{
$data_error=$dataas; 
}  
die(json_encode($data_error));
}  
$district=$db->query("SELECT district_code, $districtname as district_name  FROM district  order by district_name");  
$district1=$district->fetchAll(PDO::FETCH_ASSOC); 
foreach ($district1 as $districtkey => $districtvalue) { 
$district_codes[$districtvalue['district_code']]=$districtvalue['district_name'];    
} 
$aad_vir=$db->query("SELECT aad_vir_id, aadhaar_virtual FROM m_id_aadhaar_virtual");
$aad_vir1=$aad_vir->fetchAll(PDO::FETCH_ASSOC);
foreach ($aad_vir1 as $aad_virkey => $aad_virvalue) {
$aad_vir_codes[$aad_virvalue['aad_vir_id']]=$aad_virvalue['aadhaar_virtual'];
}
$designation = $db->query("SELECT desig_id,$desig_name as desig_name from designation"); 
$designation1=$designation->fetchAll(PDO::FETCH_ASSOC); 
$job_type2 = $db->query("SELECT job_id,$job_typee as job_name from job_type"); 
$job_type1=$job_type2->fetchAll(PDO::FETCH_ASSOC); 
?>

<!DOCTYPE html>
<html>
<?php include "../head.php"; ?> 
<body> 
<?php 
include "../header.php";  
include "../left_menu.php";
?>
<div class="mobile-menu-overlay"></div>
<div class="main-container">
	<div class="pd-ltr-20">
	<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page" href="">Add Coordinator</li>
  </ol>
</nav>
		<!-- Form grid Start -->
		<div class="container pd-20 card-box mb-30">
			<div class="clearfix">
				<div class="pull-left">
					<h4 class="text-blue h4"><?php echo $labels['lbl_add_coord'];?>
					<span class="required_symbol">  <?php echo $labels['mandatory_field'];?>  </span></h4> 
				</div> 
			</div>
			<form id="coordinator_form_id"> 			
				<div class="row"> 
					<input type="text" class="form-control" name="coord_id" id="coord_id"  value="<?php echo $coordinator1['coord_id'];?>" hidden>
					<div class="col-md-3 col-sm-12">
						<div class="form-group">
							<label><?php echo $labels['coord_name'];?> in English<span class="required_symbol"> *</span></label>
							<input type="text" class="form-control" name="coord_name" id="coord_name" onkeypress="return allowOnlyLetters(event ,'coord_name');" value="<?php echo $coordinator1['coord_name'];?>"> 
							<span id="lblcoord_name" class="required_error_msg"></span> 
						</div>
					</div> 
					<div class="col-md-3 col-sm-12">
						<div class="form-group">
							<label><?php echo $labels['coord_name_tamil'];?> in Tamil<span class="required_symbol"> *</span></label>
							<input type="text" class="form-control" name="coord_name_tamil" id="coord_name_tamil"  value="<?php echo $coordinator1['coord_name_tamil'];?>">
							<span id="lblcoord_name_tamil" class="required_error_msg"></span>
						</div>
					</div>
					<div class="col-md-3 col-sm-12">
						<div class="form-group">
							<label><?php echo $labels['dob'];?><span class="required_symbol">*</span></label>
							<input type="text" class="form-control date-picker" name="coord_dob" id="coord_dob"  value="<?php echo $coordinator1['dob'];?>"> 
							<span id="lblcoord_dob" class="required_error_msg"></span>
						</div>
					</div>
					<div class="col-md-3 col-sm-12">
						<div class="form-group">
							<label><?php echo $labels['gender'];?> <span class="required_symbol">*</span></label><br>
							<select name="coord_gender" placeholder="Select Gender" id="coord_gender" class="form-control">  
								<option value="" hidden="true">Select</option> 
								<?php  
									foreach ($gender_id as $geneder_idkey => $geneder_idvalue) { 
									if($coordinator1['gender']==$geneder_idkey){ 
								?> 
								<option value="<?php echo $geneder_idkey;?>" selected><?php echo $geneder_idvalue;?></option>
								<?php	
									} else {
								?>   
								<option value="<?php echo $geneder_idkey;?>"><?php echo $geneder_idvalue;?></option>
								<?php  
									} 
									}?>
							</select>
							<span id="lbluni_name" class="required_error_msg"></span>
						</div>
					</div>
				</div> 	
				<div class="row"> 
					<div class="col-md-3 col-sm-12">
						<div class="form-group">
							<label><?php echo $labels['mobileno'];?><span class="required_symbol">*</span></label>
							<input type="text" class="form-control"  name="coord_mobile" id="coord_mobile" maxlength="10" onkeypress="return isNumber(event);" onchange="check_countdata(this.value,'coordinator','coord_mobileno','coord_mobile');" onkeyup="firstnumvalid(this.value,'coord_mobile');" value="<?php echo $coordinator1['coord_mobileno'];?>"> 
							<span id="lblcoord_mobile" class="required_error_msg"></span> 
						</div>
					</div> 
					<div class="col-md-3 col-sm-12">
						<div class="form-group">
							<label><?php echo $labels['coord_email'];?><span class="required_symbol">*</span></label>
							<input type="text"  class="form-control emailcls mailcls" name="coord_email" id="coord_email" onchange="check_countdata(this.value,'login_details','email','coord_email');mailvalid('coord_email');" value="<?php echo $coordinator1['coord_mailid'];?>"> 
							<span id="lblcoord_email" class="required_error_msg"></span>
						</div>
					</div> 
					<div class="col-md-3 col-sm-12">
						<div class="form-group">
							<label><?php echo $labels['aadhaarno_r_virtual'];?> </label><br>
							<select name="aadhaarno_r_virtual" id="aadhaarno_r_virtual" class="form-control" onchange="select_proof(this.value);"> 
						 		<option hidden="true"  value=""><?php echo $labels['choose'];?></option>
	  							<?php  foreach ($aad_vir_codes as $aad_virkey => $aad_virvalue) { 
	  								if($coordinator1['aadhaarno_r_virtual']==$aad_virkey){ 
								?>
	  							<option value="<?php echo $aad_virkey;?>" selected><?php echo $aad_virvalue;?></option>
	  	 						<?php	
									}else{
	  							?>
								<option value="<?php echo $aad_virkey;?>"><?php echo $aad_virvalue;?></option>
 								<?php  
								}	}
								?>
								</select>
							<span id="lblaadhaarno_r_virtual" class="required_error_msg"></span>
						</div>
					</div>
					<div class="col-md-3 col-sm-12">
						<div class="form-group aadhaarno"> 
							<label><?php echo $labels['aadhaarno'];?></label>
							<input type="text" class="form-control" name="coord_aadhaar" id="coord_aadhaar" onchange="check_countdata(this.value,'coordinator','coord_aadhaar','coord_aadhaar');aadharverify(this.value,'lblcoord_aadhaar','coord_aadhaar');" onkeypress="return isNumber(event);" maxlength="12"  value="<?php echo $coordinator1['coord_aadhaar'];?>">
							<span id="lblcoord_aadhaar" class="required_error_msg"></span>
						</div>
						<div class="form-group virtualid"> 
							<label><?php echo $labels['virtualid'];?></label>
							<input type="text" class="form-control" name="coord_virtualid" id="coord_virtualid" onchange="check_countdata(this.value,'coordinator','coord_virtualid','coord_virtualid');" onkeypress="return isNumber(event);" maxlength="16"  value="<?php echo $coordinator1['coord_virtualid'];?>">
							<span id="lblvirtualid" class="required_error_msg"></span>
						</div> 
					</div>
				</div>  
				<div class="row">
					<div class="col-md-7 col-sm-12">
						<div class="form-group">
							<label><?php echo $labels['residential_address'];?><span class="required_symbol">*</span></label>
							<input type="text" class="form-control" name="address" id="address"  value="<?php echo $coordinator1['coord_address'];?>" onkeypress="return address_spec_char(event);">
						</div>
					</div>
					<div class="col-md-3 col-sm-12">
  						<div class="form-group">
    						<label ><?php echo $labels['district'];?><span class="required_symbol">*</span></label>  
    						<select class="custom-select col-12" name="coord_district" id="coord_district">
     							<option value="" hidden="true">Choose...</option>
    							<option hidden="true"  value="null"><?php echo $labels['choose'];?></option> 
				  				<?php   
      								foreach ($district_codes as $district_codeskey => $district_codesvalue){ 
        							if($coordinator1['coord_district']==$district_codeskey){  
								?> 
          						<option value="<?php echo $district_codeskey;?>" selected>
								<?php echo $district_codesvalue;?></option>
        						<?php }else{  ?> 
          						<option value="<?php echo $district_codeskey;?>">
									<?php echo $district_codesvalue;?>
								</option>
        						<?php   } }  ?>  
    						</select>
  						</div> 
						  </div> 
						<div class="col-md-2 col-sm-12">
  							<div class="form-group">
    							<label><?php echo $labels['pincode'];?><span class="required_symbol">*</span></label> 
    							<input type="text" class="form-control" name="coord_pincode" maxlength="6" onkeypress="return isNumber(event,'tot_num_unit');" onkeyup="pincodevalid(this.value,'coord_pincode');" onchange="pincodlength(this.value,'coord_pincode','lblpincode');" id="coord_pincode"  value="<?php echo $coordinator1['coord_pincode']?>">
    							<span id="lblpincode"  class="required_error_msg"></span>
  							</div>
						</div>
					
				</div>
				<div class="row">
					<div class="col-md-3 col-sm-12">
						<div class="form-group">
							<label><?php echo $labels['edu_qulifi'];?><span class="required_symbol">*</span></label>
							<input type="text" class="form-control" name="coord_edu_qulif" id="coord_edu_qulif" onkeypress="return allowOnlyLetters(event,'coord_edu_qulif');" value="<?php echo $coordinator1['edu_qualification'];?>">
							<span id="lbluni_name" class="required_error_msg"></span>
						</div>
					</div>  
					<div class="col-md-3 col-sm-12">
						<div class="form-group">
							<label><?php echo $labels['present_position'];?> <span class="required_symbol">*</span></label><br>
							<select name="present_position" placeholder="Select Gender" id="present_position" class="form-control">
								<option value="" hidden="true">Select</option>
								<?php   
									foreach ($designation1 as $designationkey => $designationvalue) { 
									if($coordinator1['present_position']==$designationvalue['desig_id']){  
								?>  
								<option value="<?php echo $designationvalue['desig_id'];?>" selected>
									<?php echo $designationvalue['desig_name'];?>
								</option>
								<?php }else{ ?>  
								<option value="<?php echo $designationvalue['desig_id'];?>">
									<?php echo $designationvalue['desig_name'];?>
								</option>
								<?php  }} ?> 	 
							</select>
							<span id="lbluni_name" class="required_error_msg"></span>
						</div>
					</div> 
					<div class="col-md-3 col-sm-12">
						<div class="form-group">
							<label><?php echo $labels['job_type'];?> <span class="required_symbol">*</span></label><br>
							<select name="job_type" placeholder="Select Gender" id="job_type" class="form-control">
								<option value="" hidden="true">Select</option>
								<?php   
									foreach ($job_type1 as $job_typekey => $job_typevalue) { 
									if($coordinator1['job_type']==$job_typevalue['job_id']){  
								?>  
								<option value="<?php echo $job_typevalue['job_id'];?>" selected>
									<?php echo $job_typevalue['job_name'];?>
								</option>
								<?php }else{ ?>  
									<option value="<?php echo $job_typevalue['job_id'];?>">
										<?php echo $job_typevalue['job_name'];?>
									</option>
								<?php  }} ?>		  
							</select>
							<span id="lbljob_type" class="required_error_msg"></span> 
						</div>
					</div> 
					<div class="col-md-3 col-sm-12">
						<div class="form-group">
							<label><?php echo $labels['tot_year_exp_po_ofcr'];?><span class="required_symbol">*</span></label> 
							<input type="text" class="form-control" name="tot_year_exp_po_ofcr" id="tot_year_exp_po_ofcr" maxlength="2" onkeypress="return isNumber(event);"  value="<?php echo $coordinator1['tot_no_exp_po_officer'];?>">
							<span id="lbltot_year_exp_po_ofcr" class="required_error_msg"></span>
						</div>
					</div> 
				</div>
				<div class="row"> 
					<div class="col-md-2 col-sm-12">
						<div class="form-group">
							<label><?php echo $labels['trained_eti'];?><span class="required_symbol">*</span></label><br>
							<div class="form-check form-check-inline ">
								<input class="form-check-input" type="radio" name="coord_trained_eti" id="coord_trained_eti" value="1" onclick="trained_eti(1)"  
								<?php if(trim($coordinator1['trained_eti'])=='1'){ echo 'checked="checked"'; } ?>>
								<label class="form-check-label" for="inlineRadio1" >
									<?php echo $labels['yes'];?>
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="coord_trained_eti" id="coord_trained_eti" value="0" onclick="trained_eti('0')"  
								<?php if(trim($coordinator1['trained_eti'])=='0')
								{ 
									echo 'checked="checked"'; 
								} ?>>
								<label class="form-check-label" for="inlineRadio2"><?php echo $labels['no'];?></label>
							</div> 	 						
						</div> 
						<span id="lbluni_name" class="required_error_msg"></span> 
					</div> 
					<div class="col-md-3 col-sm-12 trained_etino coord_trained_etino">
						<div class="form-group">
							<label>
								<?php echo $labels['eti_trained_year'];?><span class="required_symbol">*</span>
							</label>
							<input type="text" class="form-control date-picker" name="eti_trained_year" id="eti_trained_year"  value="<?php echo $coordinator1['eti_in_which_year'];?>"> 
							<span id="lbleti_trained_year" class="required_error_msg"></span>
						</div>
					</div>
					<div class="col-md-3 col-sm-12">
						<div class="form-group">
							<label><?php echo $labels['nss_coord_joining_date'];?><span class="required_symbol">*</span></label>
							<input type="text" class="form-control date-picker" name="nss_coord_joining_date" id="nss_coord_joining_date" onchange="dob_calculator(this.value,'nss_coord_joining_date','tot_year_exp_coord')" onchange="ageCalculator()" min="<?php mindate('35'); ?>" max="<?php maxdate('today'); ?>"  value="<?php echo $coordinator1['doj_nss_coordinator'];?>"> 
							<span id="lblnss_coord_joining_date" class="required_error_msg"></span>
						</div>
					</div>
					<div class="col-md-4 col-sm-12">
						<div class="form-group">
							<label><?php echo $labels['tot_year_exp_coord'];?><span class="required_symbol">*</span></label> 
							<input type="text" class="form-control disabled" name="tot_year_exp_coord" id="tot_year_exp_coord" maxlength="2" onkeypress="return isNumber(event);" value="<?php echo $coordinator1['tot_exp_nss_coordinator'];?>">
							<span id="lbltot_year_exp_coord" class="required_error_msg"></span>
						</div>
					</div> 
							
				</div>  				 
				<div class="row"> 
					<div class="col-sm-12">     
						<button type="submit" class="btn btn-primary form_submitbtn_style">Submit</button> 
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
$("#coord_name").focusout(function(){    
translate('coord_name','coord_name_tamil'); 
}); 
$("#coordinator_form_id").validate({
rules: {
	coord_name: {
		required: true, 
	}, 
	coord_name_tamil: {
		required: true, 
	},
	coord_dob: {
		required: true, 
	}, 
	coord_gender: {
		required: true, 
	},
	coord_mobile: {
		required: true, 
		maxlength: 15,
		minlength:10
	}, 
	coord_email: {
		required: true,
		email: true
	},  
	aadhaarno_r_virtual: {
		required: true, 
	},
	address: {
		required: true, 
	},
	coord_district: {
		required: true, 
	},
	
	coord_pincode: {
		required: true, 
	},
	coord_edu_qulif: {
		required: true, 
	},
	present_position: {
		required: true, 
	},
	eti_trained_year: {
		required: true, 
	},
	job_type: {
		required: true, 
	},
	nss_coord_joining_date: {
		required: true, 
	},
	coord_trained_eti: {
		required: true, 
	},
	tot_year_exp_po_ofcr: {
		required: true, 
	},
	
},
messages: { 
	coord_name: "Please Enter Coordinator Name in English",
	coord_name_tamil: "Please Enter Coordinator Name in Tamil",
	coord_dob: "Please Select a Date",
	coord_gender: "Please Select Gender",
	coord_mobile: "Please Enter Mobile No.", 
	coord_email: "Please Enter Email ID", 
	aadhaarno_r_virtual: "Please Select Anyone ",
	address: "Please Enter Address",
	coord_district: "Please Select District",
	coord_pincode: "Please Enter Pincode", 
	coord_edu_qulif: "Please Enter Educational Qualification", 
	eti_trained_year: "Please Select a Date",
	coord_aadhaar: "Please enter Aadhaar Number",
	present_position: "Please Select Designation",
	job_type: "Please Select Job Type ",
	nss_coord_joining_date: "Please Select a Date",
	tot_year_exp_po_ofcr: "Please Enter Year of Experience",
}, 
}); 
$("#coordinator_form_id").on("submit",function(e) {   
var chek_vald = $("#coordinator_form_id").valid(); 
if(chek_vald == true){  
	var virtualid1=$('#coord_virtualid').val();  
	var aadhaarno1=$('#coord_aadhaar').val(); 
	if(virtualid1 !='' || aadhaarno1 !=''){
	var formData = new FormData(this);     
	$.ajax({ 
			type:"POST", 
			data:formData, 
			success:function(data){ 
				var result = JSON.parse(data.replace(/^\s+|\s+$/gm,''));  
				if(result=='insert'){  
					toastr.success('Data Successfully Inserted'); 
					 setTimeout(function() {window.location.href="dashboard.php";}, 1000);  
				}else if(result=='update'){   
					toastr.success('Data updated Successfully Updated'); 
					 setTimeout(function() {window.location.href="dashboard.php";}, 1000);  
				}else if(result=='mail_already'){   
					toastr.warning('Mail Id already insert');  
				}else if(result=='notinsert'){   
					toastr.error('Data not Insert');  
				}else if(result[0] !=''){    
					Swal.fire(''+result+''); 
				}   
			}, 
			cache: false,
			contentType: false,
			processData: false 
	});  
	}else{
		toastr.warning('Enter Aadhaar or virtual Id');  
	}   
	e.preventDefault(); 
} 
});  
$('.virtualid').hide();
$('.aadhaarno').show(); 

var aadhaarno_r_virtual1=<?php echo json_encode($coordinator1['aadhaarno_r_virtual'])?>; //alert(aadhaarno_r_virtual1);
select_proof(aadhaarno_r_virtual1);  
function select_proof(input){  
	if(input==1){
		$('.virtualid').hide();  
		$('.aadhaarno').show(); 
	}else if(input==2){
		$('.virtualid').show();  
		$('.aadhaarno').hide();
	}		 
}

var updateid=<?php echo json_encode($unique_ids)?>;  
var loginmaill=<?php echo json_encode($login_maill)?>; 					
var coordinator_active_status1=<?php echo json_encode($coordinator_active_status)?>;  
if(coordinator_active_status1 =='1'){
Swal.fire({
		title: 'Do you want to add or update coordinator Details?',
		showDenyButton: true,
		showCancelButton: true,
		confirmButtonText: 'Add',
		denyButtonText: `Update`,
		}).then((result) => {  
		if (result.isConfirmed) {
			Swal.fire('Add Coordinator Details Here', '', 'info')   
			status_switch('2','coordinator','active_status','uni_id',updateid,loginmaill,'','noupdate','3');     
		} else if (result.isDenied) {
			Swal.fire('Update here!', '', 'success')
		}
		});	
}		 	
	</script> 
</body>
</html>



