<?php   
include "../db_connect.php";
include "../commen_php.php";
/*$created_date=date("Y/m/d"); */
$created_date=$_SESSION["created_date"]; 
$unique_ids=$_SESSION["unique_ids"]; 
$langtype=$_SESSION["langtype"];

if($langtype==1){
  $districtname= "district_tname";
  $institution_name= "institution_name_tamil";
}elseif($langtype==2){
  $districtname= "district_name";
  $institution_name= "institution_name_english";
}else{
  $districtname= "district_tname";
  $institution_name= "institution_name_tamil";
} 

$district=$db->query("SELECT district_code, $districtname as district_name  FROM district order by district_name");  
$district1=$district->fetchAll(PDO::FETCH_ASSOC);  

$university = $db->query("SELECT uni_id, uni_name FROM university ORDER BY uni_name ASC;");
$universityname=$university->fetchAll(PDO::FETCH_ASSOC);

$district=$db->query("SELECT district_code, $districtname as district_name  FROM district  order by district_name");  
$district1=$district->fetchAll(PDO::FETCH_ASSOC); 
foreach ($district1 as $districtkey => $districtvalue) {   
  $district_codes1[$districtvalue['district_code']]=$districtvalue['district_name'];  
  $district_codes2[$districtvalue['district_code']]=$districtvalue['district_name'];  
}   

$type_of_institution=$db->query("SELECT institution_id,$institution_name as institution_name  from type_of_institution");  
$institution1=$type_of_institution->fetchAll(PDO::FETCH_ASSOC); 

if(isset($_POST['ids'])){ 
  $idss= stripQuotes(killChars(trim($_POST['ids'])));   
  $college = $db->query("SELECT * from college where clg_id='$idss'"); 
  $college_echo=$college->fetch(PDO::FETCH_ASSOC); 
    $jurs_district=$college_echo['jurisdiction_dict'];    
  $jurs_district1= view_page_districs($jurs_district); 
}else{
  header("Location:all_college.php"); 
} 

?> 

<!DOCTYPE html>
<html>
<?php include "../head.php"; ?>  
<style type="text/css">
  .boxshadow2 {
    padding: 22px;
    box-shadow: 0 0 28px rgb(0 0 0 / 22%);
  }
  .required_icon{
    color: red;
  }
</style>
<body> 
  <?php include "../header.php"; ?>  
  <?php include "../left_menu.php"; ?>  
  <div class="mobile-menu-overlay"></div> 
  <div class="main-container">
    <div class="pd-ltr-20"> 
      <div class="pd-20 card-box mb-30"> 
        <div class="row">
          <br> 
        </div>
        <form id="university_form_id">  
          <div class="boxshadow2">
            <!-- <div class="clearfix">
              <div class="pull-left">
                <h4 class="text-blue h4"><?php echo $labels['clg_details'];?></h4> 
              </div> 
            </div> -->
            <div class="row">
          <div class="col-md-10 col-sm-12">
          <h4 class="text-blue h4"><?php echo $labels['clg_details'];?></h4>
          </div> 
          <div class="col-md-2 col-sm-12">
          <a href="all_college.php">  <button class="btn btn-primary"><i class="icon-copy ion-arrow-left-a">&nbsp; Back</i></button> </a>
          </div> 
        </div>
            <div class="row">
              <div class="col-md-3 col-sm-12">
                <div class="form-group">
                  <label><?php echo $labels['uni_name'];?></label>
                  <select class="form-control col-12 disabled" name="university_id" id="university_id">  
                    <?php
                    foreach ($universityname as $universitynamekey => $universitynamevalue) { 
                      if($universitynamevalue['uni_id']==$college_echo['university_id']){ ?>
                        <option  value="<?php echo $universitynamevalue['uni_id'];?>" selected><?php echo $universitynamevalue['uni_name'];?></option>  
                      <?php  }
                    }
                    ?> 
                  </select>
                </div>
              </div>
              <div class="col-md-3 col-sm-12">
                <div class="form-group">
                  <label><?php echo $labels['college_code'];?></label>
                  <input type="text" class="form-control disabled"  name="clg_code" id="clg_code" onkeypress="return isNumber(event,'clg_code');"  maxlength="4" onchange="check_countdata(this.value,'college','clg_code','clg_code');" required value="<?php echo $college_echo['clg_code']?>">
                  <span id="lblclg_code" style="color: red;font-size: small;"></span>

                </div>
              </div>
              <div class="col-md-3 col-sm-12">
                <div class="form-group">
                  <label><?php echo $labels['clg_name_english'];?></label>
                  <input type="text" class="form-control disabled" name="clg_name_english" id="clg_name_english" onkeypress="return allowOnlyLetters(event,'clg_name');" value="<?php echo $college_echo['clg_name_english']?>">
                  <span id="lblclg_name_english" style="color: red;font-size: small;"></span>

                </div> 
              </div>
              <div class="col-md-3 col-sm-12">
                <div class="form-group">
                  <label><?php echo $labels['clg_name_tamil'];?></label>
                  <input type="text" class="form-control disabled" name="clg_name_tamil" id="clg_name_tamil" onkeypress="return allowOnlyLetters(event,'clg_name_tamil');" value="<?php echo $college_echo['clg_name_tamil']?>">
                  <span id="lblclg_name_tamil" style="color: red;font-size: small;"></span>
                </div>
              </div>
            </div>
            <div class="row"> 
              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label><?php echo $labels['clg_email_id'];?></label>

                  <input type="text" class="form-control emailcls disabled" name="clg_email" id="clg_email" onkeypress="return clear_error();" onchange="check_countdata(this.value,'login_details','email','clg_email'); mailvalid('clg_email');" value="<?php echo $college_echo['clg_email']?>" >
                  <span id="lblclg_email" style="color:red; font-size: small;"></span>
                </div>
              </div> 
              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label><?php echo $labels['clg_contact_num'];?></label> 
                  <input type="text" class="form-control disabled" name="clg_contact" maxlength="10" onkeypress="return isNumber(event,'clg_contact');" id="clg_contact" onchange="check_countdata(this.value,'college','clg_contact','clg_contact');" onkeyup="firstnumvalid(this.value,'clg_contact');" value="<?php echo $college_echo['clg_mobileno']?>">
                  <span id="lblclg_contact" style="color: red;font-size: small;"></span>
                </div>
              </div>

              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label><?php echo $labels['clg_type'];?></label>
                  <select class="form-control col-12 disabled" name="clg_type" id="clg_type">  
                    <?php   
                    if($college_echo['clg_type'] ==''){  ?>    
                      <option value="">Select</option>
                    <?php   } 
                    foreach ($institution1 as $institution1key => $institution1value) { 
                      if($college_echo['clg_type']==$institution1value['institution_id']){  ?>  
                        <option value="<?php echo $institution1value['institution_id'];?>" selected><?php echo $institution1value['institution_name'];?></option>
                      <?php }else{
                        ?>   
                        <option value="<?php echo $institution1value['institution_id'];?>"><?php echo $institution1value['institution_name'];?></option>
                        <?php  
                      }
                    } ?>    
                  </select> 
                </div> 
              </div>  
            </div> 
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <div class="form-group">
                  <label ><?php echo $labels['jurisdiction_dict'];?><span class="required_icon">*</span></label> 
                   <input type="text" class="form-control disabled" name="jurisdiction_dict" id="jurisdiction_dict" value="<?php echo $jurs_district1;?>"> 
                </div>  
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <div class="form-group">
                  <label><?php echo $labels['college_address'];?></label>

                  <input type="text" class="form-control disabled" name="clg_address" id="clg_address"  value="<?php echo $college_echo['clg_address']?>">
                </div>
              </div>  
            </div>
            <div class="row"> 
              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label ><?php echo $labels['district'];?></label>  
                  <select class="form-control col-12 disabled" name="col_district" id="col_district"> 
                   <?php   
                   foreach ($district_codes2 as $district_codeskey => $district_codesvalue){ 
                    if($college_echo['col_district']==$district_codeskey){  ?> 
                      <option value="<?php echo $district_codeskey;?>" selected><?php echo $district_codesvalue;?></option>
                    <?php }else{  ?> 
                      <option value="<?php echo $district_codeskey;?>"><?php echo $district_codesvalue;?></option>
                      <?php   
                    }
                  }  ?> 
                </select>
              </div>  
            </div>
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['pincode'];?></label> 
                <input type="text" class="form-control disabled" name="pincode" maxlength="6" onkeypress="return isNumber(event,'tot_num_unit');" onkeyup="pincodevalid(this.value,'pincode');" onchange="pincodlength(this.value,'pincode','lblpincode');" id="pincode" value="<?php echo $college_echo['pincode']?>">
                <span id="lblpincode" style="color: red;font-size: small;"></span>
              </div>
            </div>
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['tot_num_unit'];?></label> 
                <input type="text" class="form-control disabled" name="tot_num_unit" maxlength="3" onkeypress="return isNumber(event,'tot_num_unit');" id="tot_num_unit" value="<?php echo $college_echo['tot_num_unit']?>">
                <span id="lbltot_num_unit" style="color: red;font-size: small;"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['principle_name'];?></label>
                <input type="text" class="form-control disabled" name="principle_name" id="principle_name" onkeypress="return allowOnlyLetters(event,'principle_name');" value="<?php echo $college_echo['principle_name']?>">
                <span id="lblprinciple_name" style="color: red;font-size: small;"></span>
              </div>
            </div>
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['principle_contact'];?></label> 
                <input type="text" class="form-control disabled" name="principle_contact" maxlength="10" onkeypress="return isNumber(event,'principle_contact');" id="principle_contact" onchange="check_countdata(this.value,'college','principle_contact','principle_contact');" onkeyup="firstnumvalid(this.value,'principle_contact');" value="<?php echo $college_echo['principle_contact']?>">
                <span id="lblprinciple_contact" style="color: red;font-size: small;"></span>
              </div>
            </div>
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['principle_emailid'];?></label>

                <input type="text" class="form-control emailcls disabled" name="principle_emailid" id="principle_emailid" onkeypress="return clear_error();" onchange="check_countdata(this.value,'login_details','email','principle_emailid'); mailvalid('principle_emailid');" value="<?php echo $college_echo['principle_emailid']?>">
                <span id="lblprinciple_emailid" style="color:red; font-size: small;"></span>
              </div>
            </div> 
          </div>
        </div>
<!-- <div class="row">
<br> 
</div>
<div class="boxshadow2">
<div class="row"> 
<div class="col-md-12 col-sm-12"> 
<div class="pull-left">
<h5 class="h4" style="color: green;">Do you want to approve/disapprove this College?</h5>  
</div>
<?php 
if($college_echo['active_status']==1){
$checked='checked';
$color='#2196F3';
}else{
$checked='';
$color='red';
}
?>
&nbsp &nbsp &nbsp <label class="switch"><input type="checkbox" <?php echo $checked?> class="stauscls"><span class="slider round" style="background-color:<?php echo $color?>"></span></label>
</div> 
</div>  
</div>  --> 
</form> 
</div>
</div>
</div>
<?php include "../footer.php"; ?>
<?php include "../common_js.php";?>  
<script type="text/javascript">

  $(document).on('change', '.stauscls', function() {
    let updateid=<?php echo json_encode($college_echo['clg_id'])?>;  
    let loginmaill=<?php echo json_encode($college_echo['clg_email'])?>; 
//alert(loginmaill);
Swal.fire({
  title: 'Do you want to save the changes?',
  showDenyButton: true,
  showCancelButton: true,
  confirmButtonText: 'Activate',
  denyButtonText: 'Deactivate',
}).then((result) => { 
  if (result.isConfirmed) {
    status_switch('1','college','active_status','clg_id',updateid,loginmaill);  
    login_approve_status('1','login_details','approve_status','email',loginmaill);  
    Swal.fire('Activated!', '', 'success') 
  } else if (result.isDenied) {
    Swal.fire('Deactivated', '', 'info')
    status_switch('0','college','active_status','clg_id',updateid,loginmaill);  
    login_approve_status('0','login_details','approve_status','email',loginmaill);  
  }
})
});
</script> 
</body>
</html>