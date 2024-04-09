<?php  
	include "../db_connect.php";
	include "../commen_php.php";
	if($_SESSION['unique_ids']==''){    
		header('Location:'.$Base_url21.'login_page.php');  
	}
	$sampedata=1;
	$ip=$_SERVER['REMOTE_ADDR'];  
	if(isset($_SESSION["langtype"])){
  		$langtypee=$_SESSION["langtype"] ? $_SESSION['langtype'] : '1';
	}else{
  		$langtypee=1;
	}
	$unique_ids=$_SESSION["unique_ids"]; 
	//print_r($_SESSION["unique_ids"]);exit; 
	$created_date=$_SESSION["created_date"];  
	if($langtypee=='1'){ 
		$desig_name= "desig_name_tamil"; 
		$job_typee= "job_type_tamil";
		$districtname= "district_tname"; 
	} elseif($langtypee=='2'){ 
		$desig_name= "desig_name_english";
		$districtname= "district_name";
		$job_typee= "job_type_english";
	}else{
		$desig_name= "desig_name_tamil"; 
		$job_typee= "job_type_tamil";
		$districtname= "district_tname"; 
	} 
	if(isset($_POST['ids'])){  
		$idss=$_POST['ids'];
 		$po_officer=$db->query("SELECT *  FROM po_officer where po_id='$idss'");  
		$po_officer1=$po_officer ->fetch(PDO::FETCH_ASSOC); 
		$po_id2=$po_officer1['po_id'];
		$eti_in_which_year=explode(" ",$po_officer1['eti_in_which_year'])[0];
	}
	if($po_id2 !=''){
		$poid_data=$po_id2;
	}else{
 		$poid_data='00';
	} 
	if(isset($_POST['po_name'])){ 
		$po_ids = stripQuotes(killChars($_POST['po_ids']));  
		$po_name_status = stripQuotes(killChars($_POST['po_name_status']));  
		$po_name = stripQuotes(killChars($_POST['po_name']));  
		$po_name_tamil = stripQuotes(killChars($_POST['po_name_tamil']));  
		$po_mobile = stripQuotes(killChars($_POST['po_mobile']));  
		$po_ofcr_email = strtolower(stripQuotes(killChars($_POST['po_ofcr_email'])));  
		$gender = stripQuotes(killChars($_POST['gender']));  
		$aadhaar = stripQuotes(killChars($_POST['aadhaar']));  
		$virtualid = stripQuotes(killChars($_POST['virtualid']));  
		$edu_qulif = stripQuotes(killChars($_POST['edu_qulif']));  
		$present_position = stripQuotes(killChars($_POST['present_position']));  
		$job_type = stripQuotes(killChars($_POST['job_type']));  
		$nss_po_joining_date = $_POST['nss_po_joining_date'];//date   
		$eti_trained_year = $_POST['eti_trained_year'];  
		$trained_eti = stripQuotes(killChars($_POST['trained_eti']));  
		$po_dob = $_POST['po_dob'];  
		$tot_year_exp_po = stripQuotes(killChars($_POST['tot_year_exp_po']));  
		$blood_group = stripQuotes(killChars($_POST['blood_group']));  
		$po_emerg_ser_willing = stripQuotes(killChars($_POST['po_emerg_ser_willing']));  
		$po_blood_dona = stripQuotes(killChars($_POST['po_blood_dona']));  
		$address = stripQuotes(killChars($_POST['address']));  
		$po_ids = stripQuotes(killChars($_POST['po_ids']));  
		$po_district = stripQuotes(killChars($_POST['po_district']));  
		$aadhaarno_r_virtual = stripQuotes(killChars($_POST['aadhaarno_r_virtual'])); 
		$virtualid = stripQuotes(killChars($_POST['virtualid']));  
		$pincode = stripQuotes(killChars($_POST['pincode']));  
		$po_district = stripQuotes(killChars($_POST['po_district']));  
		$po_officer2 = ($db->query("SELECT * FROM login_details where email='$po_ofcr_email'")->rowCount()); 
	 	try {    
			if($po_officer2=='0'){
				$query1 = $db->query("INSERT INTO po_officer(col_id, po_name, po_name_tamil, gender, dob, po_mailid, po_mobileno, po_address, edu_qualification, present_position, job_type, doj_nss_po, tot_exp_nss_po, trained_eti, eti_in_which_year, blood_group, po_emerg_ser_willing, po_blood_dona, created_by, created_time, created_ip,aadhaar_no,aadhaar_or_virtual,virtual_id,pincode,po_district,name_salutation)VALUES ('$unique_ids','$po_name','$po_name_tamil','$gender','$po_dob','$po_ofcr_email','$po_mobile','$address','$edu_qulif','$present_position','$job_type','$nss_po_joining_date','$tot_year_exp_po','$trained_eti','$eti_trained_year','$blood_group','$po_emerg_ser_willing','$po_blood_dona','$po_ofcr_email','now()','$ip','$aadhaar','$aadhaarno_r_virtual','$virtualid','$pincode','$po_district','$po_name_status');");  
				$po_officer=$db->query("SELECT po_id as ids FROM po_officer ORDER BY po_id DESC LIMIT 1");   
				$po_reference_id=$po_officer->fetch(PDO::FETCH_ASSOC)['ids'];  
				$genrate_psw=password_genrate();   
				mail_sent(2,$coord_email,$genrate_psw,'','');  
				$password = password_hash($genrate_psw,PASSWORD_DEFAULT);  
				$login_details = $db->query("INSERT INTO login_details(email, level_code,user_reference_id,updated_time,updated_by,password,confirm_psw,approve_status)VALUES ('$po_ofcr_email','25','$po_reference_id','now()','$po_ofcr_email','$password','$genrate_psw',1);"); 
				$data='insert';   
			}else{
				$data='already';   
			}
		}catch (PDOException $e) {  
	      $error1=$e->getMessage();  
	    }
		if($error1){
			$data_er[]=$error1; 
		  }else{
			$data_er=$data; 
		  } 
		  die(json_encode($data_er));  
	}  
	$designation = $db->query("SELECT desig_id,$desig_name as desig_name from designation"); 
	$designation1=$designation->fetchAll(PDO::FETCH_ASSOC); 
	$job_type2 = $db->query("SELECT job_id,$job_typee as job_name from job_type"); 
	$job_type1=$job_type2->fetchAll(PDO::FETCH_ASSOC); 
	//Blood group Dropdown fetch data from db  
	$bloodgroup=$db->query("SELECT bloodgroup_id, blood_name  FROM blood_group");  
	$bloodgroup1=$bloodgroup->fetchAll(PDO::FETCH_ASSOC);
	foreach ($bloodgroup1 as $bloodgroupkey => $bloodgroupvalue) { 
		$bloodgroup_codes[$bloodgroupvalue['bloodgroup_id']]=$bloodgroupvalue['blood_name'];    
	} 
	$gender=$db->query("SELECT gender_id,gender_name  FROM gender");  
	$gender1=$gender ->fetchAll(PDO::FETCH_ASSOC); 
	foreach ($gender1 as $genderkey => $gendervalue) { 
		$gender_id[$gendervalue['gender_id']]=$gendervalue['gender_name']; 
	} 
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
	<?php include "../header.php"; ?> 
	<?php //include "../left_menu.php"; ?>
	<div class="mobile-menu-overlay"></div>
	<div class="main-container">
		<div class="pd-ltr-20">
			<!-- Form grid Start --> 
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page" href="">Add Programme Officer</li>
  </ol>
</nav>
			<div class="container pd-20 card-box mb-30">

				<!-- <div class="clearfix">
					<div class="pull-left">
						<h4 class="text-blue h4" id="po_label"></h4> 
					</div> 
				</div> -->
				<div class="row">
          			<div class="col-md-10 col-sm-12">
						<h4 class="text-blue h4" id="po_label"></h4>
          			</div> 
          			<!-- <div class="col-md-2 col-sm-12">
           				<button class="btn btn-primary back_button" onclick="history.back(-1)"><i class="icon-copy ion-arrow-left-a">&nbsp; Back</i></button>
          			</div>  -->
        		</div> 
				<form id="po_form_id"> 			
					<div class="row"> 
						<div class="col-md-2 col-sm-12">
							<div class="form-group"> 
								<label><?php echo $labels['salutation'];?> <span class="required_symbol">*</span></label><br>
								<select name="po_name_status" id="po_name_status" class="form-control disabled">  
									<?php 
										if($po_officer1['name_salutation'] !=''){
										$salutation=$po_officer1['name_salutation'];
							 		?>
									<option value="<?php echo $salutation;?>"><?php echo $salutation;?></option> 
									<?php }else{ ?>
									<option hidden="true">Select</option> 
									<?php } ?>	 
									<option value="Dr">Dr</option>  
									<option value="Sree">Sree</option>  
									<option value="Sree Mathi">Sree Mathi</option>  
									<option value="Selvi">Selvi</option> 
								</select>
								<span id="lblpo_name_status" class="required_error_msg"></span>
							</div>
						</div> 
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['po_name'];?><span class="required_symbol"><?php echo $labels['in_english'];?> *</span></label>
								<input type="text" class="form-control disabled" name="po_name" id="po_name" onkeypress="return allowOnlyLetters(event ,'po_name');" value="<?php echo $po_officer1['po_name'];?>">
								<input type="text" class="form-control" name="po_ids" id="po_ids"  value="<?php echo $po_officer1['po_id'];?>" hidden> 
							</div>
						</div> 
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['po_name_tamil'];?><span class="required_symbol"><?php echo $labels['in_tamil'];?> *</span></label>
								<input type="text" class="form-control disabled" name="po_name_tamil" id="po_name_tamil"  value="<?php echo $po_officer1['po_name_tamil'];?>">
								<span id="lblpo_name_tamil" class="required_error_msg"></span>
							</div>
						</div>  
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['dob'];?><span class="required_symbol">*</span></label>
								<input type="text" class="form-control disabled date-picker" name="po_dob" id="po_dob" onchange="ageCalculator()" min="<?php mindate('60'); ?>" max="<?php maxdate('25'); ?>" value="<?php echo $po_officer1['dob'];?>"> 
								<span id="lblpo_dob" class="required_error_msg"></span>
							</div>
						</div>   
					</div> 	
					<div class="row"> 
						<div class="col-md-2 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['gender'];?> <span class="required_symbol">*</span></label><br>
								<select name="gender" placeholder="Select Gender" id="gender" class="form-control disabled"> 
									<option value="" hidden="true" selected><?php echo $labels['choose'];?></option>  
									<?php  
										foreach ($gender_id as $geneder_idkey => $geneder_idvalue) { 
										if($po_officer1['gender']==$geneder_idkey){ ?> 
											<option value="<?php echo $geneder_idkey;?>" selected><?php echo $geneder_idvalue;?></option>
										<?php	}else{
										?> 
										<option value="<?php echo $geneder_idkey;?>"><?php echo $geneder_idvalue;?></option>
									<?php  }} ?>
								</select>
								<span id="lblgender" class="required_error_msg"></span>
							</div>
						</div>
						<div class="col-md-2 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['mobileno'];?><span class="required_symbol">*</span></label>
								<input type="text" class="form-control disabled"  name="po_mobile" id="po_mobile" maxlength="10" onkeypress="return isNumber(event);" onchange="check_countdata(this.value,'po_officer','po_mobileno','po_mobile');" onkeyup="firstnumvalid(this.value,'po_mobile');" value="<?php echo $po_officer1['po_mobileno'];?>"> 
								<span id="lblpo_mobile" class="required_error_msg"></span> 
							</div>
						</div>
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['po_coord_email'];?><span class="required_symbol">*</span></label>
								<input type="text"  class="form-control disabled emailcls mailcls" name="po_ofcr_email" id="po_ofcr_email" onchange="check_countdata(this.value,'login_details','email','po_ofcr_email');mailvalid('po_ofcr_email');"  value="<?php echo $po_officer1['po_mailid'];?>"> 
								<span id="lblpo_ofcr_email" class="required_error_msg"></span>
							</div>
						</div>
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['aadhaarno_r_virtual'];?> </label><br>
								<select name="aadhaarno_r_virtual" id="aadhaarno_r_virtual" class="form-control disabled" onchange="select_proof(this.value);"> 
									<?php 
										if($po_officer1['aadhaar_or_virtual']==1){ ?>
										<option value="1">Aadhaar Number</option>
										<?php }elseif($po_officer1['aadhaar_or_virtual']==2){ ?>
										<option value="2">Virtual ID</option> 
										<?php }else{ ?>
										<option hidden="true" value="">Select</option> 
										<?php }?>		 
										<option value="1">Aadhaar Number</option>  
										<option value="2">Virtual ID</option>  
								</select>
								<span id="lblaadhaarno_r_virtual" class="required_error_msg"></span>
							</div>
						</div>  
						<div class="col-md-2 col-sm-12">
							<div class="form-group aadhaarno"> 
								<label><?php echo $labels['aadhaarno'];?></label>
								<input type="text" class="form-control disabled" name="aadhaar" id="aadhaar" onchange="check_countdata(this.value,'po_officer','aadhaar','aadhaar');aadharverify(this.value,'lblaadhaar','aadhaar');" onkeypress="return isNumber(event);" maxlength="12" value="<?php echo $po_officer1['aadhaar_no'];?>">
								<span id="lblaadhaar" class="required_error_msg"></span>
							</div>
							<div class="form-group virtualid"> 
								<label><?php echo $labels['virtualid'];?></label>
								<input type="text" class="form-control disabled" name="virtualid" id="virtualid" onchange="check_countdata(this.value,'po_officer','virtualid','virtualid');" onkeypress="return isNumber(event);" maxlength="16" value="<?php echo $po_officer1['virtual_id'];?>">
								<span id="lblvirtualid" class="required_error_msg"></span>
							</div>
						</div>
					</div>  
					<div class="row">
						<div class="col-md-8 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['address'];?><span class="required_symbol">*</span></label>
								<input type="text" class="form-control disabled" name="address" id="address"  value="<?php echo $po_officer1['po_address'];?>">
							</div>
						</div>
						<div class="col-md-2 col-sm-12">
              				<div class="form-group">
                				<label><?php echo $labels['pincode'];?><span class="required_symbol">*</span></label> 
                				<input type="text" class="form-control disabled" name="pincode" maxlength="6" onkeypress="return isNumber(event,'tot_num_unit');" onkeyup="pincodevalid(this.value,'pincode');" onchange="pincodlength(this.value,'pincode','lblpincode');" id="pincode" value="<?php echo $po_officer1['pincode']?>">
                				<span id="lblpincode" style="color: red;font-size: small;"></span>
              				</div>
           	 			</div>
						<div class="col-md-2 col-sm-12">
              				<div class="form-group">
                				<label ><?php echo $labels['district'];?><span class="required_symbol">*</span></label>  
                				<select class="form-control disabled" name="po_district" id="po_district"> 
                					<option hidden="true">--Select--</option>
                   					<?php   
                  					foreach ($district_codes as $district_codeskey => $district_codesvalue){ 
                    				if($po_officer1['po_district']==$district_codeskey){  ?> 
                      				<option value="<?php echo $district_codeskey;?>" selected><?php echo $district_codesvalue;?></option>
                    				<?php }else{  ?> 
                      				<option value="<?php echo $district_codeskey;?>"><?php echo $district_codesvalue;?></option>
                    				<?php   } }  ?> 
                				</select>
              				</div>  
            			</div>
					</div>
					<div class="row"> 
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['edu_qulifi'];?><span class="required_symbol">*</span></label>
								<input type="text" class="form-control disabled" name="edu_qulif" id="edu_qulif" onkeypress="return allowOnlyLetters(event,'edu_qulif');" value="<?php echo $po_officer1['edu_qualification'];?>">
							</div>
						</div> 
						<div class="col-md-2 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['present_position'];?> <span class="required_symbol">*</span></label><br>
								<select name="present_position" placeholder="Select Designation" id="present_position" class="form-control disabled">
									<option hidden="true" selected><?php echo $labels['choose'];?></option>
									<?php   
									foreach ($designation1 as $designationkey => $designationvalue) { 
										if($po_officer1['present_position']==$designationvalue['desig_id']){  ?>  
											<option value="<?php echo $designationvalue['desig_id'];?>" selected><?php echo $designationvalue['desig_name'];?></option>
										<?php }else{
											?>  
											<option value="<?php echo $designationvalue['desig_id'];?>"><?php echo $designationvalue['desig_name'];?></option>
											<?php  
										}
									} ?> 	 
								</select> 
							</div>
						</div>  
						<div class="col-md-2 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['job_type'];?> <span class="required_symbol">*</span></label><br>
								<select name="job_type" placeholder="Select" id="job_type" class="form-control disabled">
									<option value="" hidden="true" selected><?php echo $labels['choose'];?></option>
									<?php   
          							foreach ($job_type1 as $job_typekey => $job_typevalue) { 
           	 						if($po_officer1['job_type']==$job_typevalue['job_id']){  ?>  
									<option value="<?php echo $job_typevalue['job_id'];?>" selected><?php echo $job_typevalue['job_name'];?></option>
            						<?php }else{ ?>  
            						<option value="<?php echo $job_typevalue['job_id'];?>"><?php echo $job_typevalue['job_name'];?></option>
          							<?php   }  } ?>	   
								</select>
								<span id="lbljob_type" class="required_error_msg"></span> 
							</div>
						</div> 
						<div class="col-md-2 col-sm-12">
              			<div class="form-group">
                			<label ><?php echo $labels['blood_group'];?><span class="required_symbol">*</span></label>  
                			<select class="form-control disabled" name="blood_group" id="blood_group"> 
                				<option hidden="true">--Select--</option>
								<?php   
								foreach ($bloodgroup_codes as $bloodgroupkey => $bloodgroupvalue) { 
								if($po_officer1['blood_group']==$bloodgroupkey){ ?> 
								<option value="<?php echo $bloodgroupkey;?>" selected><?php echo $bloodgroupvalue;?></option> 
								<?php }else{ ?> 
								<option value="<?php echo $bloodgroupkey;?>"><?php echo $bloodgroupvalue;?></option>
								<?php  } } ?> 
                			</select>
              			</div>  
            			</div>
						<div class="col-md-2 col-sm-12">
						<div class="form-group">
							<label><?php echo $labels['blood_don'];?><span class="required_symbol">*</span></label><br> 
							<div class="form-check form-check-inline ">
								<input class="form-check-input disabled" type="radio" name="po_blood_dona" id="po_blood_dona" value="1" <?php if (trim($po_officer1['po_blood_dona']) == '1'){ echo  'checked="checked"'; } ?>>
								<label class="form-check-label" for="inlineRadio1" ><?php echo $labels['yes'];?></label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input disabled" type="radio" name="po_blood_dona" id="po_blood_dona" value="0" <?php if (trim($po_officer1['po_blood_dona']) == '0'){ echo  'checked="checked"'; } ?>>
								<label class="form-check-label" for="inlineRadio2"><?php echo $labels['no'];?></label>
							</div>
						</div>
						<span id="lblpo_blood_dona" class="required_error_msg"></span>
					</div>  		
					</div> 
					
					<div class="row">
						<div class="col-md-2 col-sm-12">
							<div class="form-group ">
								<label><?php echo $labels['trained_eti'];?><span class="required_symbol">*</span></label><br> 
								<div class="form-check form-check-inline ">
									<input class="form-check-input disabled" type="radio" name="trained_eti" id="trained_eti" value="Y" <?php echo (trim($po_officer1['trained_eti']) == "Y" ? 'checked="checked"': ''); ?> onclick="trainedeti('Y')">
									<label class="form-check-label" for="inlineRadio1" ><?php echo $labels['yes'];?></label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input disabled" type="radio" name="trained_eti" id="trained_eti" value="N" <?php echo (trim($po_officer1['trained_eti'])=="N" ? 'checked="checked"': ''); ?> onclick="trainedeti('N')">
									<label class="form-check-label" for="inlineRadio2"><?php echo $labels['no'];?></label>
								</div>
							</div> 
						</div>
						<div class="col-md-3 col-sm-12 eti_trained_year">
							<div class="form-group">
								<label><?php echo $labels['eti_trained_year'];?><span class="required_symbol">*</span></label>
								<input type="text" class="form-control disabled date-picker" name="eti_trained_year" id="eti_trained_year" value="<?php echo $eti_in_which_year;?>"> 
								<span id="lbleti_trained_year" class="required_error_msg"></span>
							</div>
						</div>
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['nss_po_joining_date'];?><span class="required_symbol">*</span></label>
								<input type="text" class="form-control disabled date-picker" name="nss_po_joining_date" id="nss_po_joining_date" value="<?php echo $po_officer1['doj_nss_po'];?>" onchange="dob_calculator(this.value,'nss_po_joining_date','tot_year_exp_po')" onchange="ageCalculator()" min="<?php mindate('35'); ?>" max="<?php maxdate('today'); ?>" > 
								<span id="lblnss_po_joining_date" class="required_error_msg"></span>
							</div>
						</div>
						<div class="col-md-2 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['tot_year_exp_po'];?><span class="required_symbol">*</span></label> 
								<input type="text" class="form-control disabled" name="tot_year_exp_po" id="tot_year_exp_po" onkeypress="return isNumber(event);"  value="<?php echo $po_officer1['tot_exp_nss_po'];?>" >
								<span id="lbltot_year_exp_po" class="required_error_msg"></span>
							</div>
						</div>
						<div class="col-md-2 col-sm-12"> 
						<div class="form-group">
							<label><?php echo $labels['emerg_ser_willing'];?><span class="required_symbol">*</span></label><br>
							<div class="form-check form-check-inline">
								<input class="form-check-input disabled" type="radio" name="po_emerg_ser_willing" id="po_emerg_ser_willing" value="1" <?php if ($po_officer1['po_emerg_ser_willing'] == '1'){ echo  'checked="checked"'; } ?>>
								<label class="form-check-label" for="inlineRadio2"><?php echo $labels['yes'];?></label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input disabled" type="radio" name="po_emerg_ser_willing" id="po_emerg_ser_willing" value="0" <?php if ($po_officer1['po_emerg_ser_willing'] == '0'){ echo  'checked="checked"'; } ?>>
								<label class="form-check-label" for="inlineRadio2"><?php echo $labels['no'];?></label>
							</div>
						</div>
						<span id="lblpo_emerg_ser_willing" class="required_error_msg"></span>
					</div>
					</div>
					<div class="row">
					
				</div>  
				<div class="row"> 
					<div class="col-sm-12">  
						<?php if($po_id2 ==''){ ?>
						<button type="submit" class="btn btn-primary form_submitbtn_style"><?php echo $labels['submit']?></button>  
						<?php } ?>  
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
		var poid_data=<?php echo json_encode($poid_data);?>;  
		$(".disabled").prop("disabled",true);
		if(poid_data =='00'){  
			$(".disabled").prop("disabled",false);
			document.getElementById("tot_year_exp_po").disabled = true;
			document.getElementById("po_label").innerHTML = "Add Programme Officer";
			$('.back_button').hide();
		}else{
			$(".disabled").prop("disabled",true);
			document.getElementById("po_label").innerHTML = "View Programme Officer Details";
		}
		$("#po_name").focusout(function(){    
			translate('po_name','po_name_tamil'); 
		});  
		$("#po_form_id").validate({
			rules: {
				po_name_status:{required: true,	}, 
				po_name: {required: true,	}, 
				po_name_tamil:{required: true,	}, 
				po_mobile: {required:true,maxlength:15,minlength:10	}, 
				gender: {	required: true, }, 
				po_dob:{required: true,},
				po_ofcr_email: {required: true,email: true	}, 
				//aadhaarno_r_virtual:{required: true,},
				//aadhaar:{required: true,},
				//virtualid:{required: true,},
				edu_qulif: {required: true, },
				present_position: {	required: true, },
				job_type: {	required: true, },
				nss_po_joining_date:{	required: true,},
				address:{required: true,maxlength:250	},
				po_district:{required: true,	},
				pincode:{required: true,maxlength:6	},
				tot_year_exp_po: {required: true},
				blood_group: {required: true, },
				trained_eti: {required: true, },
				//eti_trained_year:{required: true, },
				po_emerg_ser_willing: {	required: true,},
				po_blood_dona:{	required: true, }   
			},
			messages: { 
				po_name_status:"Please Select Salutation",
				po_name: "Please enter Program Officer Name", 
				po_name_tamil:"Please enter Program Officer Name Tamil",
				po_mobile:"Please enter Mobile Number", 
				gender:"Please enter gender",
				po_dob:"Please enter DOB",
				po_ofcr_email: "Please enter Email ID",  
				// aadhaarno_r_virtual:"Please select aadhaar or virtualid",
				// aadhaar:"Please enter aadhaar No.",
				// virtualid:"Please enter virtual id",
				edu_qulif:"Please enter Education Qulification",
				present_position:"Please enter Designation",
				job_type:"Please enter Job type",
				nss_po_joining_date:"Please enter NSS Joining Date",
				address:"Please enter Address",
				po_district :"Please enter District",
				pincode:"Please enter Pincode",
				// tot_year_exp_po :"Please enter Year of experience",
				blood_group:"Please enter Blood Group",
				trained_eti :"Please select Trained ETI ",
				//eti_trained_year:"Please enter ETI Trained Year",
				po_emerg_ser_willing:"Please Select Willing to serve in emergency ",
				po_blood_dona:"Please Select Willing to donate Blood",	
			}, 
		}); 
		$("#po_form_id").on("submit",function(e) {  
		var aadhaar2=$("#aadhaar").val();   
		var virtualid2=$("#virtualid").val();  
		if(aadhaar2 !='' || virtualid2 !=''){
			var chek_vald = $("#po_form_id").valid();  
			if(chek_vald == true){  
				var formData = new FormData(this);     
				$.ajax({ 
					type:"POST", 
					data:formData, 
					success:function(data){  
						var result = JSON.parse(data);    
						if(result=="insert"){  
							toastr.success('Data Successfully Inserted'); 
							setTimeout(function() {window.location.reload();}, 1000); 
						}else if(result['0'] !=''){    
							Swal.fire(''+result+''); 
						}else if(result =='already'){    
							toastr.error('data alredy Inserted'); 
						}else{
							toastr.error('Not Insert'); 
						}   
					}, 
					cache: false,
					contentType: false,
					processData: false 
				});     
			} 
			}else{
				toastr.error('Select Aadhaar Or Virtualid'); 
			}
			e.preventDefault(); 
		});
		$('.virtualid').hide();
		$('.aadhaarno').show(); 
		select_proof(<?php echo json_encode($po_officer1['aadhaar_or_virtual'])?>);  
		function select_proof(input){  
			if(input==1){
				$('.virtualid').hide();  
				$('.aadhaarno').show(); 
			}else if(input==2){
				$('.virtualid').show();  
				$('.aadhaarno').hide();
			}	
		}	
		$('.eti_trained_year').show();
		function trainedeti(input){  
	  		if(input=='N'){
	  			$('.eti_trained_year').hide();
	  		}else{
	  			$('.eti_trained_year').show();
	  		}
		}
     $(document).ready(function () {
            $("#eti_trained_year").datepicker({
                onSelect: function (selectedDate) {
                    alert(selectedDate);
                }
            });
        }); 	  
	</script> 
</body>
</html>



