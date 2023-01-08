<?php
include "../db_connect.php";
include "../commen_php.php";
$created_date=date("Y/m/d");  

if(isset($_SESSION["langtype"])){
  $langtypee=$_SESSION["langtype"] ? $_SESSION['langtype'] : '1';
}else{
  $langtypee=1;
}
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
$ids1=$_POST['ids1']; 
//print_r("SELECT * FROM volunteer where vol_id='$ids1'");exit;
$volunteer_echo = $db->query("SELECT * FROM volunteer where vol_id='$ids1'");
$vol_echo1=$volunteer_echo->fetch(PDO::FETCH_ASSOC); 

$volunteer_dob=explode(" ",$vol_echo1['vol_dob']);
$doj_nss = $vol_echo1['vol_doj_nss'];
$new_doj_nss = date("d-m-Y", strtotime($doj_nss));
 


/*University Dropdown fetch data from db */

$university=$db->query("SELECT uni_code,$uni_name as uni_name  FROM university");
$university1=$university ->fetchAll(PDO::FETCH_ASSOC);
foreach ($university1 as $universitykey => $universityvalue) {
  $university_codes[$universityvalue['uni_code']]=$universityvalue['uni_name'];
}

/*College Dropdown fetch data from db */

$college=$db->query("SELECT clg_id,$clg_name as clg_name  FROM college");
$college1=$college ->fetchAll(PDO::FETCH_ASSOC);
foreach ($college1 as $collegekey => $collegevalue) {
 $college_codes[$collegevalue['clg_id']]=$collegevalue['clg_name'];
}

/*Gender Dropdown fetch data from db */

$gender=$db->query("SELECT gender_id,gender_name  FROM gender");
$gender1=$gender ->fetchAll(PDO::FETCH_ASSOC);
foreach ($gender1 as $genderkey => $gendervalue) {
  $gender_codes[$gendervalue['gender_id']]=$gendervalue['gender_name'];
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

/*Program Officer Name Dropdown fetch data from db */

$poname=$db->query("SELECT po_id, po_name FROM po_officer");
$po1=$poname->fetchAll(PDO::FETCH_ASSOC);
foreach ($po1 as $pokey => $povalue) {
  $po_codes[$povalue['po_id']]=$povalue['po_name'];
}
/*Aadhaar or virtual id Dropdown fetch data from db */

$aad_vir=$db->query("SELECT aad_vir_id, aadhaar_virtual FROM m_id_aadhaar_virtual");
$aad_vir1=$aad_vir->fetchAll(PDO::FETCH_ASSOC);
foreach ($aad_vir1 as $aad_virkey => $aad_virvalue) {
  $aad_vir_codes[$aad_virvalue['aad_vir_id']]=$aad_virvalue['aadhaar_virtual'];
}
//print_r($aad_vir_codes);exit;
 


?>
 

<!DOCTYPE html>
<html>
<?php include "../head.php"; ?>
<body>
   <?php include "../header.php"; ?>
   <?php include "../left_menu.php"; ?>

  <div class="mobile-menu-overlay"></div>
  <div class="main-container">
 <div class="pd-ltr-20">
       <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="approve_volunteer.php">All Student Details</a></li>
        <li class="breadcrumb-item active" aria-current="page" href="">View Volunteer Details</li>
        </ol>
      </nav> 
        <div class="container pd-20 card-box mb-30">
           <div class="container pd-0">
    <form id="volunteer_update_form_id">
          <div class="row">
<!--  volunteer name(English) -->
            <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['vol_name'];?><span style="color: green"> (Initial)</span><span class="required_symbol">* </span></label>
                <input type="text" class="form-control disabled" name="vol_name" id="vol_name" onkeypress="return allowOnlyLetters(event ,'vol_name');" value="<?php echo $vol_echo1['vol_name'];?>">
                <span id="lblvol_name" class="required_error_msg"></span>

              </div>
            </div>
<!--  volunteer name(Tamil)-->
            <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['vol_name'];?><span style="color: green"> (Initial)</span><span class="required_symbol">* </span></label>
                <input type="text" class="form-control disabled" name="vol_name_tamil" id="vol_name_tamil" value="<?php echo $vol_echo1['vol_name_tamil'];?>">
                <span id="lblvol_name_tamil" class="required_error_msg"></span>
              </div>
            </div>
<!--  Gender -->
            <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['gender'];?> <span class="required_symbol">*</span></label><br>
                <select name="vol_gender" placeholder="Select Gender" id="vol_gender" class="form-control disabled">
                  <option value="">Select</option>
                  <?php
                          foreach ($gender_codes as $genderkey => $gendervalue) { 
                              if($vol_echo1['vol_gender']==$genderkey){  ?>
                                  <option value="<?php echo $genderkey;?>" selected><?php echo $gendervalue;?></option>
                         <?php   }else{ ?> 
                    <option value="<?php echo $genderkey;?>"><?php echo $gendervalue;?></option>
                  <?php  }
                               
                              } ?>
              
                </select>
                <span id="lblgender" class="required_error_msg"></span>
              </div>
          </div>
          </div>
          <div class="row"> 
<!--  Date Of Birth -->
            <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['dob'];?><span class="required_symbol">*</span></label>
                <input type="text" class="form-control disabled date-picker" name="vol_dob" id="vol_dob" onchange="dob_calculator(this.value,'lblvol_dob','vol_age')" value="<?php echo $volunteer_dob[0];?>">
                <span id="lblvol_dob" class="required_error_msg"></span>
              </div>
            </div>
<!--  Father name -->
            <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['father_name'];?><span class="required_symbol">*</span></label>
                <input type="text" class="form-control disabled" name="vol_father_name" id="vol_father_name" onkeypress="return allowOnlyLetters(event,'vol_father_name');" value="<?php echo $vol_echo1['vol_father_name'];?>">
                <span id="lblvol_father" class="required_error_msg"></span>
              </div>
            </div>

<!--  Email Id -->
            <div class="col-md-4 col-sm-12">
             <div class="form-group ">
              <label><?php echo $labels['email_id'];?><span class="required_symbol">*</span></label>
              <input type="text"  class="form-control disabled emailcls mailcls" name="vol_email" id="vol_email" onchange="check_countdata(this.value,'volunteer','vol_email','vol_email'); mailvalid('vol_email');" value="<?php echo $vol_echo1['vol_email'];?>" disabled> 
              <span id="lblvol_email" class="required_error_msg"></span>
             </div>
            </div>
          </div>
          <div class="row">
<!--  Mobile Number -->
            <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['mobileno'];?><span class="required_symbol">*</span></label>
                <input type="text" class="form-control disabled"  name="vol_mobile" id="vol_mobile" maxlength="10" onkeypress="return isNumber(event);" onchange="check_countdata(this.value,'volunteer','vol_mobile','vol_mobile');" onkeyup="firstnumvalid(this.value,'vol_mobile');" value="<?php echo $vol_echo1['vol_mobile'];?>">
                <span id="lblvol_mobile" class="required_error_msg"></span>
              </div>
            </div>
<!--select Aadhar /virtual Id -->
           <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['aadhaarno_r_virtual'];?></label>
                  <select class="custom-select col-12 disabled" name="aadhaar_r_virtual" id="aadhaar_r_virtual" onchange="select_proof(this.value);">
                   <option value="" >Select</option> 
                   <option hidden="true"  value="null"><?php echo $labels['choose'];?></option> 
                    <?php
                  foreach ($aad_vir_codes as $aad_virkey => $aad_virvalue) { 
                    if($vol_echo1['vol_aadhaar_or_virtual']==$aad_virkey){  ?>
                      <option value="<?php echo $aad_virkey;?>" selected><?php echo $aad_virvalue;?></option>
                  <?php   }else{ ?> 
                    <option value="<?php echo $aad_virkey;?>"><?php echo $aad_virvalue;?></option>
                  <?php  }
                } ?>
          </select>
                <span id="lblaadhaar_r_virtual" class="required_error_msg"></span>
              </div>
            </div>           
<!-- Aadhaar Number-->
            <div class="col-md-4 col-sm-12">
                <div class="form-group aadhaarno"> 
                <label><?php echo $labels['aadhaarno'];?></label>
                <input type="text" class="form-control disabled" name="vol_aadhaar" id="vol_aadhaar" onchange="check_countdata(this.value,'volunteer','vol_aadhaar','vol_aadhaar');aadharverify(this.value,'lblvol_aadhaar','vol_aadhaar');" onkeypress="return isNumber(event);" maxlength="12" value="<?php echo $vol_echo1['vol_aadhaar'];?>">
                <span id="lblvol_aadhaar" class="required_error_msg"></span>
              </div> 
<!-- Virtual ID-->
                <div class="form-group virtualid"> 
                <label><?php echo $labels['virtualid'];?></label>
                  <input type="text" class="form-control disabled" name="vol_virtual" id="vol_virtual" onchange="check_countdata(this.value,'volunteer','virtualid','vol_virtual');" onkeypress="return isNumber(event);" maxlength="16" value="<?php echo $vol_echo1['vol_virtual'];?>">
                <span id="lblvol_virtual" class="required_error_msg"></span>
              </div>
          </div>
        </div>
          <div class="row">

<!-- Community -->
            <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['community'];?><span class="required_symbol">*</span></label>
                  <select class="form-control disabled" name="vol_community" id="vol_community">
                    <option value="">Select</option>
               <?php
                  foreach ($community_codes as $communitykey => $communityvalue) { 
                    if($vol_echo1['vol_community']==$communitykey){  ?>
                      <option value="<?php echo $communitykey;?>" selected><?php echo $communityvalue;?></option>
                  <?php   }else{ ?> 
                    <option value="<?php echo $communitykey;?>"><?php echo $communityvalue;?></option>
                  <?php  }
                } ?>
                </select>
                <span id="lblvol_community" class="required_error_msg"></span>
              </div>
            </div>
<!-- degree course -->


              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                <label><?php echo $labels['degree_course'];?><span class="required_symbol">*</span></label>
                  <select class="form-control disabled" name="vol_degree_course" id="vol_degree_course">
                    <option value="">Select</option>
                 <?php
                  foreach ($degree_name as $degree_coursekey => $degree_coursevalue) { 
                    if($vol_echo1['vol_degree_id']==$degree_coursekey){  ?>
                      <option value="<?php echo $degree_coursekey;?>" selected><?php echo $degree_coursevalue;?></option>
                  <?php   }else{ ?> 
                    <option value="<?php echo $degree_coursekey;?>"><?php echo $degree_coursevalue;?></option>
                  <?php  }
                } ?>

                </select>
                  <span id="lblvol_degree_course" class="required_error_msg"></span>
                </div>
              </div>
<!-- Year of Admission -->            
            <div class="col-md-4 col-sm-12">
              <div class="form-group" >
                <label><?php echo $labels['adm_year'];?><span class="required_symbol">*</span></label> 
                <input type="text" class="form-control disabled date-picker" name="vol_adm_year" id="vol_adm_year" value="<?php echo $vol_echo1['vol_adm_year'];?>">
                <span id="lblvol_adm_year" class="required_error_msg"></span>
              </div>
            </div>
          </div>
          <div class="row">
<!-- Address -->
              <div class="col-md-8 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['address'];?><span class="required_symbol">*</span></label> 
                <input type="text" class="form-control disabled" name="vol_address" id="vol_address" maxlength="250" value="<?php echo $vol_echo1['vol_address'];?>"  onkeypress="return address_spec_char(event);">
                <span id="lblvol_address" class="required_error_msg"></span>
              </div>
            </div>
<!--  District -->
            <div class="col-md-4 col-sm-12">
                <div class="form-group ">
                <label><?php echo $labels['district'];?><span class="required_symbol">*</span></label>
                <select class="form-control disabled" name="vol_district" id="vol_district">
                  <option value="">Select</option>
                 <?php
          foreach ($district_codes as $districtkey => $districtvalue){ 
                    if($vol_echo1['vol_district']==$districtkey){  ?> 
                      <option value="<?php echo $districtkey;?>" selected><?php echo $districtvalue;?></option>
                    <?php }else{  ?> 
                      <option value="<?php echo $districtkey;?>"><?php echo $districtvalue;?></option>
                    <?php   
                  }
                  }  ?>


                
                </select>
                <span id="lblvol_district" class="required_error_msg"></span>
                </div>
              </div>


          </div>
          <div class="row">
<!--  Pincode-->
              <div class="col-md-4 col-sm-12">
                <div class="form-group ">
                  <label><?php echo $labels['pincode'];?><span class="required_symbol">*</span></label>
                  <input type="text" class="form-control disabled"  name="vol_pincode" id="vol_pincode" maxlength="6" onkeypress="return isNumber(event); pincodevalid(this.value,'vol_pincode');" onchange="pincode_validation(event,'vol_pincode');" value="<?php echo $vol_echo1['vol_pincode'];?>">
                   <span id="lblvol_pincode" class="required_error_msg"></span>
                </div>
              </div>  
<!--Program Officer Name-->
            <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['po_name'];?><span class="required_symbol">*</span></label>
                  
                <input type="text" class="form-control disabled"  name="vol_po_name" id="vol_po_name" maxlength="6" value=" <?php echo $po_codes[$vol_echo1['vol_po_name']];?> ">
               
              
                <span id="lblvol_po_name" class="required_error_msg"></span>
              </div>
            </div>
<!-- Date of Join in Nss -->
            <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['yr_join_nss'];?><span class="required_symbol">*</span></label> 
                <input type="text" class="form-control disabled date-picker" name="vol_doj_nss" id="vol_doj_nss" value="<?php echo $vol_echo1['vol_doj_nss'];?>" >
                <span id="lblvol_doj_nss" class="required_error_msg"></span>
              </div>
            </div>
          </div>
          <div class="row">
<!--  Blood Group --> 
            <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['blood_group'];?><span class="required_symbol">*</span></label>
                <select class="form-control disabled" name="vol_blood_group" id="vol_blood_group">
                <option value="">Select</option>   
                   <?php
                  foreach ($bloodgroup_codes as $bloodgroupkey => $bloodgroupvalue) { 
                    if($vol_echo1['vol_blood_group']==$bloodgroupkey){  ?>
                      <option value="<?php echo $bloodgroupkey;?>" selected><?php echo $bloodgroupvalue;?></option>
                  <?php   }else{ ?> 
                    <option value="<?php echo $bloodgroupkey;?>"><?php echo $bloodgroupvalue;?></option>
                  <?php  }
                } ?>
                </select>    
                <span id="lblvol_blood_group" class="required_error_msg"></span> 
              </div>
            </div> 
<!--  Blood Donation -->
            <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['blood_don'];?><span class="required_symbol">*</span></label><br> 
                <div class="form-check form-check-inline ">
                  <input class="form-check-input " type="radio" name="vol_blood_dona" id="vol_blood_dona" value="Y" <?php echo ($vol_echo1['vol_blood_dona'] == "Y" ? 'checked="checked"': ''); ?>>
                  <label class="form-check-label" for="inlineRadio1" ><?php echo $labels['yes'];?></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input " type="radio" name="vol_blood_dona" id="vol_blood_dona" value="N" <?php echo ($vol_echo1['vol_blood_dona'] == "N" ? 'checked="checked"': ''); ?>>
                  <label class="form-check-label" for="inlineRadio2"><?php echo $labels['no'];?></label>
                </div>
              </div>
              <span id="lblvol_blood_dona" class="required_error_msg"></span>
            </div>  
<!--  Willing to work in emergency -->
            <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['emerg_ser_willing'];?><span class="required_symbol">*</span></label><br>
                <div class="form-check form-check-inline">
                  <input class="form-check-input " type="radio" name="vol_emerg_ser_willing" id="vol_emerg_ser_willing" value="Y" <?php echo ($vol_echo1['vol_blood_dona'] == "Y" ? 'checked="checked"': ''); ?>>
                  <label class="form-check-label" for="inlineRadio2"><?php echo $labels['yes'];?></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input " type="radio" name="vol_emerg_ser_willing" id="vol_emerg_ser_willing" value="N" <?php echo ($vol_echo1['vol_blood_dona'] == "N" ? 'checked="checked"': ''); ?>>
                  <label class="form-check-label" for="inlineRadio2"><?php echo $labels['no'];?></label>
                </div>
              </div>
            </div>
            <span id="lblvol_emerg_ser_willing" class="required_error_msg"></span>
       
          </div>
       <div class="row">
 <!--Volunteer Photo-->  
         <div class="col-md-6 col-sm-12">
          <div class="form-group">
            <label><?php echo $labels['vol_photo'];?><span style="color: green;font-size: small;">     jpg,jpeg,png(250kb)</span></label>
            <input type="file" class="form-control-file disabled form-control height-auto " name="vol_photo"  id="vol_photo"  onchange="return fileValidation('vol_photo','err_msg');" value="<?php echo $vol_echo1['vol_photo'];?>">  
            <span id="err_msg" class="required_error_msg"></span>
          </div>
        </div>      
<!--Talents -->             
    <div class="col-md-6 col-sm-12">
      <div class="form-group">
        <label><?php echo $labels['talents'];?></label>
          <select class="selectpicker form-control disabled" data-size="5" multiple data-max-options="4" name="vol_talents[]" id="vol_talents"> 
          <option value="">Select</option>
             <?php
             $vol_talents1=json_decode($vol_echo1['vol_talents'],true);
                  foreach ($talents_codes as $talentskey => $talentsvalue) {  
                    if (in_array($talentskey, $vol_talents1)){  ?>
                      <option value="<?php echo $talentskey;?>" selected><?php echo $talentsvalue;?></option>
                  <?php   }else{ ?> 
                    <option value="<?php echo $talentskey;?>"><?php echo $talentsvalue;?></option>
                  <?php  }
                } ?>

          </select>    
      </div>
      <!-- <span id="lblvol_talents" class="required_error_msg"></span>-->
    </div>
 
       </div>
   
  <div class="row">
<!--List out Talents -->              
          <div class="col-md-12 col-sm-12">
            <div class="form-group ">
              <label><?php echo $labels['list_talents'];?><span style="color: green;font-size: small;">     (Minimun 2-3 Line description)</span></label> 
              <textarea class="form-control disabled" name="vol_list_talents" id="vol_list_talents" maxlength="500" ><?php echo $vol_echo1['vol_list_talents'];?></textarea>
              <span id="lblvol_list_talents" class="required_error_msg"></span>
            </div>
          </div>
       </div>
<!--Submit Button -->     
        
        </form> 
      </div>
        </div> 
        <?php include "../footer.php"; ?>
    </div>
        </div> 
  </div> 
  <?php include "../common_js.php";?> 
  <script type="text/javascript">
    $("#vol_name").focusout(function(){
      translate('vol_name','vol_name_tamil');
    });

     $("#vol_email").prop('disabled', true);
     $("#vol_po_name").prop('disabled', true);

  //aadhar virtual id hide and show
$('.virtualid').hide();
$('.aadhaarno').show();
select_proof(<?php echo json_encode($vol_echo1['vol_aadhaar_or_virtual'])?>); 
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
