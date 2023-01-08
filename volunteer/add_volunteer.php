<?php
 include "../db_connect.php";
include "../commen_php.php";
if($_SESSION['unique_ids']==''){    
    header('Location:'.$Base_url21.'login_page.php');  
}
$created_date=$_SESSION["created_date"];
$ip=$_SERVER['REMOTE_ADDR'];
$labels=$_SESSION["lbl_data"];
if($_SESSION['unique_ids']=='' || $_SESSION['sub_level']==''){    
		header('Location:'.$Base_url21.'login_page.php');  
}

//$unique_ids=$_SESSION["unique_ids"];

$langtypee=$_SESSION["langtype"] ? $_SESSION['langtype'] : '1';
if($langtypee=='1'){
  $districtname= "district_tname";
  $uni_name= "uni_name_tamil";
  $clg_name= "clg_name_tamil";
  $vol_talents="talents_tamil";
}elseif($langtypee=='2'){
  $districtname= "district_name";
  $uni_name= "uni_name";
  $clg_name= "clg_name_english";
  $vol_talents-"talents";
}else{
  $districtname= "district_tname";
  $uni_name= "uni_name_tamil";
  $clg_name= "clg_name_tamil";
  $vol_talents="talents_tamil";
}

//For edit and update

if(isset($_POST['ids'])){
  $idss= stripQuotes(killChars(trim($_POST['ids'])));
 $volunteer_echo = $db->query("SELECT * FROM volunteer where vol_unique_id='$idss'");
 $volunteer_echo1=$volunteer_echo->fetch(PDO::FETCH_ASSOC);
}


if(isset($_POST['vol_name'])){ 
  $university_id= stripQuotes(killChars(trim($_POST['university_id'])));
  $college_id= stripQuotes(killChars(trim($_POST['college_id'])));
  $vol_unique_id= stripQuotes(killChars(trim($_POST['vol_unique_id'])));
  $vol_name= stripQuotes(killChars(trim($_POST['vol_name'])));
  $vol_name_tamil= stripQuotes(killChars(trim($_POST['vol_name_tamil'])));
  $vol_gender= stripQuotes(killChars(trim($_POST['vol_gender'])));
  $vol_dob=$_POST['vol_dob'];
  $vol_father_name= stripQuotes(killChars(trim($_POST['vol_father_name'])));
  $vol_mobile= stripQuotes(killChars(trim($_POST['vol_mobile'])));
  $vol_email= strtolower(stripQuotes(killChars(trim($_POST['vol_email']))));
  $aadhaar_r_virtual= stripQuotes(killChars(trim($_POST['aadhaar_r_virtual'])));
  $vol_aadhaar= stripQuotes(killChars(trim($_POST['vol_aadhaar'])));
  $vol_virtual= stripQuotes(killChars(trim($_POST['vol_virtual'])));
  $vol_community= stripQuotes(killChars(trim($_POST['vol_community'])));
  $vol_address= stripQuotes(killChars(trim($_POST['vol_address'])));
  $vol_district= stripQuotes(killChars(trim($_POST['vol_district'])));
  $vol_pincode= stripQuotes(killChars(trim($_POST['vol_pincode'])));
  $vol_degree_id =stripQuotes(killChars(trim($_POST['vol_degree_course'])));
  $vol_adm_year= $_POST['vol_adm_year'];
  //$vol_unit_id=stripQuotes(killChars(trim($_POST['vol_unit_id'])));
  $vol_po_name=stripQuotes(killChars(trim($_POST['vol_po_name'])));
  $vol_doj_nss= $_POST['vol_doj_nss'];
  $vol_blood_group= stripQuotes(killChars(trim($_POST['vol_blood_group'])));
  $vol_blood_dona= stripQuotes(killChars(trim($_POST['vol_blood_dona'])));
  $vol_emerg_ser_willing= stripQuotes(killChars(trim($_POST['vol_emerg_ser_willing'])));
  $vol_talents= stripQuotes(killChars(trim(json_encode($_POST['vol_talents']))));
  $vol_list_talents= stripQuotes(killChars(trim($_POST['vol_list_talents'])));
  $vol_photo= stripQuotes(killChars(trim($_POST['vol_photo'])));


/*Change Name First Letter in Uppercase*/

$vol_name1=ucfirst($vol_name);
$vol_father_name1=ucfirst($vol_father_name);

 $serial_id=$db->query("SELECT max(vol_id) as ids FROM volunteer");
 $volunteer_count=$serial_id->fetchAll(PDO::FETCH_ASSOC)[0]['ids'] + 1;

//photo Path & storage
   $ext="jpg";
   //$volunteer_count2='vol_'.$volunteer_count.'';
    $volunteer_count2='100'.$volunteer_count.'';
   $photo_storage="../Uploads/volunteer/$volunteer_count2.".$ext."";
   $volunteercount = ($db->query("SELECT * FROM volunteer where vol_unique_id='$volunteer_count'")->rowCount());


  try {
    if($volunteercount=='0'){   
    	//print_r();exit;
       $query1 = $db->query("INSERT INTO volunteer(vol_unique_id, uni_id, clg_id, vol_name, vol_name_tamil, vol_gender, vol_dob, vol_father_name, vol_email, vol_mobile,vol_aadhaar_or_virtual, vol_aadhaar,vol_virtual, vol_community, vol_address, vol_district, vol_pincode, vol_degree_id, vol_adm_year, vol_po_name, vol_doj_nss, vol_blood_group, vol_blood_dona, vol_emerg_ser_willing, vol_talents, vol_list_talents, vol_approve_status, vol_photo, created_by, created_time, created_ip)VALUES ('$volunteer_count2','$university_id','$college_id','$vol_name1','$vol_name_tamil','$vol_gender','$vol_dob','$vol_father_name1','$vol_email','$vol_mobile','$aadhaar_r_virtual','$vol_aadhaar','$vol_virtual','$vol_community','$vol_address','$vol_district','$vol_pincode','$vol_degree_id','$vol_adm_year','$vol_po_name','$vol_doj_nss','$vol_blood_group','$vol_blood_dona','$vol_emerg_ser_willing','$vol_talents','$vol_list_talents','0','$photo_storage','$vol_email','now()','$ip')"); 

          mkdir("../Uploads/volunteer",0777,true);
          $temp_storage="../Uploads/volunteer";
          if($_FILES['vol_photo']['tmp_name']){
            move_uploaded_file($_FILES['vol_photo']['tmp_name'],$temp_storage."/$volunteer_count2.".$ext."");
          }

          $vol_count=$db->query("SELECT vol_unique_id as ids FROM volunteer ORDER BY vol_id DESC LIMIT 1");
  			$vol_count2=$vol_count->fetch(PDO::FETCH_ASSOC)['ids'];  

			$genrate_psw=password_genrate();   
			mail_sent(2,$vol_email,$genrate_psw,'','');  
			$password = password_hash($genrate_psw,PASSWORD_DEFAULT); 
			$login_details = $db->query("INSERT INTO login_details(email, level_code,user_reference_id,updated_time,updated_by,password,confirm_psw,approve_status)VALUES ('$vol_email','30','$vol_count2','now()','$vol_email','$password','$genrate_psw',1);"); 

        $datainsert='insert'; 
  }
}catch (PDOException $e) {  
  $error1=$e->getMessage();  
}

  if($error1){
    $data_er[]=$error1;
  }else{
    $data_er=$datainsert;
  }
//print_r($data_er);exit;

 die(json_encode($data_er));

}

/*University Dropdown fetch data from db */

$university=$db->query("SELECT uni_id,$uni_name as uni_name  FROM university where uni_active_status='1' ORDER BY uni_name");
$university1=$university ->fetchAll(PDO::FETCH_ASSOC);
foreach ($university1 as $universitykey => $universityvalue) {
	$university_codes[$universityvalue['uni_id']]=$universityvalue['uni_name'];
}

/*College Dropdown fetch data from db */

$college=$db->query("SELECT university_id,clg_id,$clg_name as clg_name  FROM college");
$college1=$college ->fetchAll(PDO::FETCH_ASSOC);
foreach ($college1 as $collegekey => $collegevalue) { 
	$college_codes[$collegevalue['university_id']][$collegevalue['clg_id']]=$collegevalue['clg_name'];
}
//print_r($college_codes);exit;
/*Gender Dropdown fetch data from db */

$gender=$db->query("SELECT gender_id,gender_name  FROM gender");
$gender1=$gender ->fetchAll(PDO::FETCH_ASSOC);
foreach ($gender1 as $genderkey => $gendervalue) {
	$gender_id[$gendervalue['gender_id']]=$gendervalue['gender_name'];
}

/* District  Dropdown fetch data from db */


$district=$db->query("SELECT district_code, $districtname as district_name  FROM district ORDER BY district_name ASC");
$district1=$district->fetchAll(PDO::FETCH_ASSOC);
 foreach ($district1 as $districtkey => $districtvalue) {
   $district_codes[$districtvalue['district_code']]=$districtvalue['district_name'];

 }
/*Blood group Dropdown fetch data from db  */

$bloodgroup=$db->query("SELECT bloodgroup_id, blood_name  FROM blood_group");
$bloodgroup1=$bloodgroup->fetchAll(PDO::FETCH_ASSOC);
foreach ($bloodgroup1 as $bloodgroupkey => $bloodgroupvalue) {
	$bloodgroup_codes[$bloodgroupvalue['bloodgroup_id']]=$bloodgroupvalue['blood_name'];
}
/* community  Dropdown fetch data from db */

$community=$db->query("SELECT community_id, community_name  FROM m_community");
$community1=$community->fetchAll(PDO::FETCH_ASSOC);
foreach ($community1 as $communitykey => $communityvalue) {
	$community_codes[$communityvalue['community_id']]=$communityvalue['community_name'];
}

/*Talents  Dropdown fetch data from db */

$talents=$db->query("SELECT talents_id, talents,talents_tamil  FROM m_talents");
$talents1=$talents->fetchAll(PDO::FETCH_ASSOC);
foreach ($talents1 as $talentskey => $talentsvalue) {
	$talents_codes[$talentsvalue['talents_id']]=$talentsvalue['talents'];
}
/*Degree Course  Dropdown fetch data from db */

	$degree_course=$db->query("SELECT degree_id,degree_name,degree_type  FROM m_degree");
	$degree_course1=$degree_course->fetchAll(PDO::FETCH_ASSOC);
 foreach ($degree_course1 as $degree_coursekey => $degree_coursevalue) {
	$degree_name[$degree_coursevalue['degree_id']]=$degree_coursevalue['degree_name'];
	$degree_type22[$degree_coursevalue['degree_type']][$degree_coursevalue['degree_id']]=$degree_coursevalue['degree_name'];
 }
/*po Dropdown fetch data from db */

$po=$db->query("SELECT po_id, po_name,col_id FROM po_officer");
$po1=$po->fetchAll(PDO::FETCH_ASSOC); 
foreach ($po1 as $pokey => $povalue) { 
	$po_codes[$povalue['col_id']][$povalue['po_id']]=$povalue['po_name'];
}
//print_r($po_codes);exit;

/*Aadhaar or virtual id Dropdown fetch data from db */

$aad_vir=$db->query("SELECT aad_vir_id, aadhaar_virtual FROM m_id_aadhaar_virtual");
$aad_vir1=$aad_vir->fetchAll(PDO::FETCH_ASSOC);
foreach ($aad_vir1 as $aad_virkey => $aad_virvalue) {
	$aad_vir_codes[$aad_virvalue['aad_vir_id']]=$aad_virvalue['aadhaar_virtual'];
}


?>

<?php
/* Date of Birth calander range(Max & Min) */
    function dob_mindate() {
        $date=date_create("today");
        date_sub($date,date_interval_create_from_date_string("22 years"));
        echo date_format($date,"Y-m-d");
    }
    function dob_maxdate() {
        $date=date_create("today");
        date_sub($date,date_interval_create_from_date_string("16 years"));
        echo date_format($date,"Y-m-d");
    }
/* volunteer Admittion Year calander range(Max & Min) */

    function adm_year_mindate() {
        $date=date_create("today");
        date_sub($date,date_interval_create_from_date_string("5 years"));
        echo date_format($date,"d-m-y");
    }
    function adm_year_maxdate() {
		    $date=date_create("today");
		    date_sub($date,date_interval_create_from_date_string("0 years"));
		    echo date_format($date,"Y-m-d");
    }
/* Date of Joining in NSS calander range(Max & Min)*/

    function doj_nss_mindate() {
        $date=date_create("today");
        date_sub($date,date_interval_create_from_date_string("3 years"));
        echo date_format($date,"d-m-y");
    }

   function doj_nss_maxdate() {
      $date=date_create("today");
      date_sub($date,date_interval_create_from_date_string("0 years"));
      echo date_format($date,"d-m-y");
  }
?>

<!DOCTYPE html>
<html>
 <?php include "../head.php"; ?>
<body>
	 <?php
		include "../left_menu.php";
		include "../header.php";
	?>
	<div class="mobile-menu-overlay"></div>
	<div class="main-container">
		<div class="pd-ltr-20">
			 <?php	 include "../path_menu.php";?>
			 <!-- <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page" href="">Add Volunteer</li>
  </ol>
</nav> -->
			<!-- Form grid Start -->
			<div class="container pd-20 card-box mb-30">
				<div class="clearfix">
					<div class="pull-left">
						<h4 class="text-blue h4"><?php echo $labels['lbl_add_vol'];?><span class="required_symbol">  <?php echo $labels['mandatory_field'];?>  </span></h4>
					</div>
				</div>

				<form id="volunteer_form_id" >
					<div class="row">
						<!--  University name -->
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['uni_name'];?><span class="required_symbol">*</span></label>
								<select class="custom-select col-12" name="university_id" id="university_id" onchange="select_clg(this.value);">
										<option selected="" hidden="true" value="null"><?php echo $labels['choose'];?></option>
									<?php
									foreach ($university_codes as $universitykey => $universityvalue) { ?>
										<option value="<?php echo $universitykey;?>"><?php echo $universityvalue;?></option>
									<?php  } ?>
								</select>
							</div>
						</div>
						<!--  College name -->
						<div class="col-md-4 col-sm-12">
							 <div class="form-group">
								<label><?php echo $labels['clg_name'];?><span class="required_symbol">*</span></label>
								<select class="custom-select col-12" name="college_id" id="college_id" onchange="select_po(this.value);">
										<option selected="" hidden="true" value="null"><?php echo $labels['choose'];?></option>
									 
								</select>
							</div>
						</div>
						<!--Program Officer Name-->
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['po_name'];?><span class="required_symbol">*</span></label>
								<select class="custom-select col-12" name="vol_po_name" id="vol_po_name">
										 <option value="">Select</option>
								</select>
								<span id="lblvol_po_name" class="required_error_msg"></span>
							</div>
						</div>
					</div>
<!--  volunteer name(English) -->
					<div class="row">
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['vol_name'];?><span class="required_symbol">* <?php echo $labels['in_english'];?></span></label>
								<input type="text" class="form-control" name="vol_name" id="vol_name" onkeypress="return allowOnlyLetters(event ,'vol_name');">
								<span id="lblvol_name" class="required_error_msg"></span>

							</div>
						</div>
						<!--  volunteer name(Tamil)-->
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['vol_name'];?><span class="required_symbol">* <?php echo $labels['in_tamil'];?></span></label>
								<input type="text" class="form-control" name="vol_name_tamil" id="vol_name_tamil">
								<span id="lblvol_name_tamil" class="required_error_msg"></span>
							</div>
						</div>
						<!--  Father name -->
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['father_name'];?><span class="required_symbol">*</span></label>
								<input type="text" class="form-control" name="vol_father_name" id="vol_father_name" onkeypress="return allowOnlyLetters(event,'vol_father_name');">
								<span id="lblvol_father" class="required_error_msg"></span>
							</div>
						</div>
						<!--  Gender -->
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['gender'];?> <span class="required_symbol">*</span></label><br>
								<select name="vol_gender" placeholder="Select Gender" id="vol  _gender" class="form-control">
									<option selected="" hidden="true" value="null"><?php echo $labels['choose'];?></option>
									<option hidden="true">Choose...</option>
									<?php
									foreach ($gender_id as $geneder_idkey => $geneder_idvalue) { ?>
										<option value="<?php echo $geneder_idkey;?>"><?php echo $geneder_idvalue;?></option>
									<?php  } ?>
								</select>
								<span id="lblgender" class="required_error_msg"></span>
							</div>
						</div>
					</div>

					<div class="row">


<!--  Date Of Birth -->
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['dob'];?><span class="required_symbol">*</span></label>
								<input type="text" class="form-control date-picker" name="vol_dob" id="vol_dob" min="<?php dob_mindate(); ?>" max="<?php dob_maxdate(); ?>" onchange="dob_calculator(this.value,'lblvol_dob','vol_age')">
								<span id="lblvol_dob" class="required_error_msg"></span>
							</div>
						</div>
<!--  Age -->
						<div class="col-md-2 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['age'];?></label>
								<input type="text" class="form-control" name="vol_age" id="vol_age"  value="" disabled>
								<span id="lblvol_age" class="required_error_msg"></span>

							</div>
						</div>


<!-- Community -->
						<div class="col-md-2 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['community'];?><span class="required_symbol">*</span></label>
									<select class="custom-select col-12"   name="vol_community" id="vol_community">
                    <option selected="" hidden="true" value="null"><?php echo $labels['choose'];?></option>
                    <option hidden="true">Choose...</option>
										<?php
										foreach ($community_codes as $communitykey => $communityvalue) { ?>
										<option value="<?php echo $communitykey;?>"><?php echo $communityvalue;?></option>
										<?php  } ?>
									</select>
								<span id="lblvol_community" class="required_error_msg"></span>
							</div>
						</div>
<!-- degree type -->
<div class="col-md-2 col-sm-12">
								<div class="form-group">
								<label><?php echo $labels['degree_type'];?><span class="required_symbol">*</span></label>
									<select class="custom-select col-12" name="vol_degree_type" id="vol_degree_type" onchange="getDegreeCourse(this.value,'vol_degree_course');">
										<option hidden="true" value="null"><?php echo $labels['choose'];?></option>

										<?php
					               $stmt = $db->prepare("SELECT DISTINCT degree_type FROM m_degree;");
					                $stmt->execute();
					                $result = $stmt->fetchAll();
					                foreach($result as $key=>$value)
					                {
					                  $selected = '';
					                  echo '<option value="'.$value['degree_type'].'"  '.$selected.'>'.$value['degree_type'].'</option>';
					                }?>
 									</select>
									<span id="lblvol_degree_type" class="required_error_msg"></span>
								</div>
							</div>
<!-- degree course -->
							<div class="col-md-3 col-sm-12">
								<div class="form-group">
								<label><?php echo $labels['degree_course'];?><span class="required_symbol">*</span></label>

									<select class="custom-select col-12" name="vol_degree_course" id="vol_degree_course">


								</select>
            						 <span id="lblvol_degree_course" class="required_error_msg"></span>
								</div>
							</div>
					</div>
					<div class="row">
<!--  Email Id -->
						<div class="col-md-3 col-sm-12">
						 <div class="form-group">
							<label><?php echo $labels['email_id'];?><span class="required_symbol">*</span></label>
							<input type="text"  class="form-control emailcls mailcls" name="vol_email" id="vol_email" onchange="check_countdata(this.value,'login_details','email','vol_email'); mailvalid('vol_email');">
							<span id="lblvol_email" class="required_error_msg"></span>
						 </div>
						</div>
<!--  Mobile Number -->
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['mobileno'];?><span class="required_symbol">*</span></label>
								<input type="text" class="form-control"  name="vol_mobile" id="vol_mobile" maxlength="10" onkeypress="return isNumber(event);" onchange="check_countdata(this.value,'volunteer','vol_mobile','vol_mobile');" onkeyup="firstnumvalid(this.value,'vol_mobile');">
						 		<span id="lblvol_mobile" class="required_error_msg"></span>
							</div>
						</div>
<!--select Aadhar /virtual Id -->
           <div class="col-md-3 col-sm-12">
              <div class="form-group ">
              	<label><?php echo $labels['aadhaarno_r_virtual'];?> </label>
                  

                <select class="custom-select col-12" name="aadhaar_r_virtual" id="aadhaar_r_virtual" onchange="select_proof(this.value);">
                	 <option hidden="true" value="" >Select</option>
					<option hidden="true"  value="null"><?php echo $labels['choose'];?></option>
				  <?php  foreach ($aad_vir_codes as $aad_virkey => $aad_virvalue) { ?>
						<option value="<?php echo $aad_virkey;?>"><?php echo $aad_virvalue;?></option>
	         	<?php  } ?>
	   			</select>

                  <span id="lblaadhaar_r_virtual" class="required_error_msg"></span>
              </div>
            </div>
<!-- Aadhaar Number-->
						<div class="col-md-3 col-sm-12">
							<div class="form-group aadhaarno">
								<label><?php echo $labels['aadhaarno'];?></label>
								<input type="text" class="form-control" name="vol_aadhaar" id="vol_aadhaar" onchange="check_countdata(this.value,'volunteer','vol_aadhaar','vol_aadhaar');aadharverify(this.value,'lblvol_aadhaar','vol_aadhaar');" onkeypress="return isNumber(event);" maxlength="12" >
								<span id="lblvol_aadhaar" class="required_error_msg"></span>
							</div>
<!--Aadhar validation-->


<!-- Virtual ID-->
                            <div class="form-group virtualid">
								<label><?php echo $labels['virtualid'];?></label>
									<input type="text" class="form-control" name="vol_virtual" id="vol_virtual" onchange="check_countdata(this.value,'volunteer','virtualid','vol_virtual');" onkeypress="return isNumber(event);" maxlength="16">
								<span id="lblvol_virtual" class="required_error_msg"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<!-- Address -->
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['address'];?><span class="required_symbol">*</span></label>
								<input type="text" class="form-control" name="vol_address" id="vol_address" maxlength="250"  onkeypress="return address_spec_char(event);">
								<span id="lblvol_address" class="required_error_msg"></span>
							</div>
						</div>
						<!--  District -->
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['district'];?><span class="required_symbol">*</span></label>
								<select class="custom-select col-12" name="vol_district" id="vol_district">
									<option hidden="true"  value="null"><?php echo $labels['choose'];?></option>
									<?php  foreach ($district_codes as $districtkey => $districtvalue) { ?>
									<option value="<?php echo $districtkey;?>"><?php echo $districtvalue;?></option>
									<?php  } ?>
								</select>
								<span id="lblvol_district" class="required_error_msg"></span>
							</div>
						</div>
							<!--  Pincode-->
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['pincode'];?><span class="required_symbol">*</span></label>
								<input type="text" class="form-control"  name="vol_pincode" id="vol_pincode" maxlength="6" onkeypress="return isNumber(event);" onkeyup=" pincodevalid(this.value,'vol_pincode');" onchange="pincodlength(this.value,'vol_pincode','lblvol_pincode');">
								<span id="lblvol_pincode" class="required_error_msg"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<!-- Year of Admission -->
						<div class="col-md-3 col-sm-12">
							<div class="form-group" >
								<label><?php echo $labels['adm_year'];?><span class="required_symbol">*</span></label>
								<input type="text" class="form-control date-picker" name="vol_adm_year" id="vol_adm_year" min="<?php adm_year_mindate(); ?>" max="<?php adm_year_maxdate(); ?>">
								<span id="lblvol_adm_year" class="required_error_msg"></span>
							</div>
						</div>
						<!-- Date of Join in Nss -->
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['doj_in_nss'];?><span class="required_symbol">*</span></label>
								<input type="text" class="form-control date-picker" name="vol_doj_nss" id="vol_doj_nss" min="<?php doj_nss_mindate(); ?>" max="<?php doj_nss_maxdate(); ?>" >
								<span id="lblvol_doj_nss" class="required_error_msg"></span>
							</div>
						</div>
						<!--  Blood Group -->
						<div class="col-md-2 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['blood_group'];?><span class="required_symbol">*</span></label>
								<select class="custom-select col-12" name="vol_blood_group" id="vol_blood_group">
										<option selected="" hidden="true" value="null"><?php echo $labels['choose'];?></option>
										<option value="" hidden="true">Choose...</option>
									<?php
									foreach ($bloodgroup_codes as $bloodgroupkey => $bloodgroupvalue) { ?>
										<option value="<?php echo $bloodgroupkey;?>"><?php echo $bloodgroupvalue;?></option>
									<?php  } ?>
								</select>
								<span id="lblvol_blood_group" class="required_error_msg"></span>
							</div>
						</div>
						<!--  Blood Donation -->
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['blood_don'];?><span class="required_symbol">*</span></label><br>
								<div class="form-check form-check-inline ">
									<input class="form-check-input" type="radio" name="vol_blood_dona" id="vol_blood_dona" value="Y">
									<label class="form-check-label" for="inlineRadio1" ><?php echo $labels['yes'];?></label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="vol_blood_dona" id="vol_blood_dona" value="N">
									<label class="form-check-label" for="inlineRadio2"><?php echo $labels['no'];?></label>
								</div>
							</div>
							<span id="lblvol_blood_dona" class="required_error_msg"></span>
						</div>
						<!--  Willing to work in emergency -->
						
					</div>

				  <div class="row">
				  <div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label><?php echo $labels['emerg_ser_willing'];?><span class="required_symbol">*</span></label><br>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="vol_emerg_ser_willing" id="vol_emerg_ser_willing" value="Y">
									<label class="form-check-label" for="inlineRadio2"><?php echo $labels['yes'];?></label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="vol_emerg_ser_willing" id="vol_emerg_ser_willing" value="N">
									<label class="form-check-label" for="inlineRadio2"><?php echo $labels['no'];?></label>
								</div>
							</div>
						</div>
						<span id="lblvol_emerg_ser_willing" class="required_error_msg"></span>
			<!--Volunteer Photo-->
		     <div class="col-md-4 col-sm-12">
          <div class="form-group">
            <label><?php echo $labels['vol_photo'];?><span style="color: green;font-size: small;">     jpg,jpeg,png(250kb)</span></label>
            <input type="file" class="form-control-file form-control height-auto " name="vol_photo"  id="vol_photo"  onchange="return fileValidation('vol_photo','err_msg');">
            <span id="err_msg" class="required_error_msg"></span>
          </div>
        </div>
<!--Talents -->
		<div class="col-md-5 col-sm-12">
			<div class="form-group">
				<label><?php echo $labels['talents'];?></label>
					<select class="selectpicker form-control" data-size="5" multiple data-max-options="4" name="vol_talents[]" id="vol_talents" value="select">
					<option hidden="true" value="null"><?php echo $labels['choose'];?></option>
						<?php
						foreach ($talents_codes as $talentskey => $talentsvalue) { ?>
							<option value="<?php echo $talentskey;?>"><?php echo $talentsvalue;?></option>
						<?php  } ?>
					</select>
			</div>
			<!-- <span id="lblvol_talents" class="required_error_msg"></span> -->
		</div>

   		 </div>
   		 <div class="row">
<!--List out Talents -->
					<div class="col-md-12 col-sm-12">
						<div class="form-group">
							<label><?php echo $labels['list_talents'];?><span style="color: green;font-size: small;">     (Minimun 2-3 Line description)</span></label>
							<textarea class="form-control" name="vol_list_talents" id="vol_list_talents" maxlength="500"></textarea>
							<span id="lblvol_list_talents" class="required_error_msg"></span>
						</div>
					</div>
   		 </div>
<!--Submit Button -->
					<div class="row">
						<div class="col-sm-12">
				            <button type="submit" class="btn btn-primary form_submitbtn_style"><?php echo $labels['submit'];?></button>

						</div>
					</div>
				</form>
			</div>
			<!-- Form grid End -->
		</div>
	</div>
		<?php include "../footer.php"; ?>

	<?php include "../common_js.php";?>
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!--English to Tamil Name Translation-->
	<script type="text/javascript">
			$("#vol_name").focusout(function(){
			translate('vol_name','vol_name_tamil');
		});


//Paticular Degree_course Get Function

function getDegreeCourse(input,ids){
	$('#'+ids+'').empty();
	var degree_type=<?PHP echo json_encode($degree_type22)?>;
	// clgdata +='<option value="" hidden="true">--Select--</option>';

	var degree_type2=degree_type[input];
	$('#'+ids+'').append('<option hidden="true">--Select--</option>');

	for(var key2 in degree_type2){
		$('#'+ids+'').append('<option value="'+key2+'">'+degree_type2[key2]+'</option>');
	}
}
 //aadhar virtual id hide and show
 $('.virtualid').hide();
$('.aadhaarno').show(); 
function select_proof(input){
    if(input==1){
        $('.virtualid').hide();
        $('.aadhaarno').show();
    }else if(input==2){
        $('.virtualid').show();
        $('.aadhaarno').hide();
    }

}
var college_codes=<?php echo json_encode($college_codes)?>; 
function select_clg(ids){   
	var clgdata='';
	$('#college_id').html('');
	$('#vol_po_name').html('');
	var college_codes1=college_codes[ids];  
	clgdata +='<option value="" hidden="true">--Select--</option>';
	for(var clg_key in college_codes1){ //console.log(college_codes1[clg_key]);
			clgdata +='<option value="'+clg_key+'">'+college_codes1[clg_key]+'</option>';
	}
	$('#college_id').append(clgdata);
}

var po_codes=<?php echo json_encode($po_codes)?>;  
function select_po(ids){  	//alert(ids);	
	var po_data='';
	$('#vol_po_name').html('');
	var po_codes1=po_codes[ids];  
	po_data +='<option value="" hidden="true">--Select--</option>';
	 for(var clg_po in po_codes1){  console.log(po_codes1[clg_po]);
	 		po_data +='<option value="'+clg_po+'">'+po_codes1[clg_po]+'</option>';
	 }
	 $('#vol_po_name').append(po_data);
}

		$("#volunteer_form_id").validate({
			rules: {
				university_id:{	required: true, },
				college_id: {required: true, },
				vol_name: {	required: true, },
				vol_name_tamil: {required: true, },
				vol_gender: {required: true, },
				vol_dob: {required: true, },
				vol_age: {required: true, },
				vol_father_name: {	required: true, },
				vol_email: {required: true,	email: true },
				vol_mobile: {required: true,maxlength: 10,minlength:10	},
				vol_aadhaar: {maxlength: 12,minlength:12},
				vol_virtual: {maxlength: 16,minlength:16},
				vol_community:{required: true,},
				vol_address:{required: true, },
				vol_district: {required: true, },
				vol_pincode: {required: true, maxlength: 6, minlength:6 },
				vol_degree_type: {required: true	},
				vol_degree_course: {required: true},
				vol_adm_year:{required: true,}, 
				vol_po_name:{required: true,},
				vol_doj_nss:{required: true},
				vol_blood_group:{required: true,},
				vol_blood_don:{required: true,},
				vol_emerg_ser_willing:{	required: true,	},
				vol_talents:{required: true,}, 
			},
			messages: {
				university_id:"Please Select University  Name",
				college_id:"Please Select college Name",
				vol_name:"Please enter Name",
				vol_name_tamil:"Please enter Name in Tamil",
				vol_gender:" select your gender",
				vol_dob:"Choose your Date of Birth",
				vol_father_name:"Please enter your Father Name",
				vol_email:"Please enter Email ID",
				vol_mobile:"Please enter Mobile Number", 
				vol_community:"Select Your Community",
				vol_address:"Please enter Address",
				vol_district:"Please select District",
				vol_pincode:"Please enter Pincode",
				vol_degree_type:"Please select Degree Type",
				vol_degree_course:"Please Select Degree Course",
				vol_adm_year:"Please enter Year of Admition", 
				vol_po_name:"Please select Program Officer Name",
				vol_doj_nss:"Please enter NSS Joined Date",
				vol_blood_group:"Please select Blood Group",
				vol_blood_dona:"Please select Blood Donation",
				vol_emerg_ser_willing:"Please select emergency service willing ",
				 
			},
		}); 


$("#volunteer_form_id").on("submit",function(e) {
//Age Readonly can't access any where

 var chek_vald = $("#volunteer_form_id").valid();
         if(chek_vald == true){
    var formData = new FormData(this);

    $.ajax({
        type:"POST",
        data:formData,
        success:function(data){
          var result = JSON.parse(data.replace(/^\s+|\s+$/gm,''));
          if(result=='insert'){
            toastr.success('Data Successfully Inserted');
          setTimeout(function() {window.location.reload();}, 1250);
          }else if(result[0] !=''){
             Swal.fire(''+result+'');
          }
        },
          cache: false,
          contentType: false,
          processData: false
      });
    e.preventDefault();
  }
    });

	</script>
</body>
</html>
