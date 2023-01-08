<?php   
include "../db_connect.php";
include "../commen_php.php";
$created_date=date("Y/m/d"); 


if(isset($_POST['ids'])){  
  $idss= stripQuotes(killChars(trim($_POST['ids'])));  
  $clg_echo = $db->query("SELECT * FROM college where clg_uniq_id='$idss'");
  $clg_echo1=$clg_echo->fetch(PDO::FETCH_ASSOC); 
//print_r($clg_echo1['clg_head_desig']);exit; 
}else{
  header("Location:view_university.php"); 
}  


$districtname= "district_name";
$district=$db->query("SELECT district_code, $districtname as district_name  FROM district");  
$district1=$district->fetchAll(PDO::FETCH_ASSOC); 
foreach ($district1 as $districtkey => $districtvalue) { 
  $district_codes[$districtvalue['district_code']]=$districtvalue['district_name'];  
  $district_codes1[$districtvalue['district_code']]=$districtvalue['district_name'];  
}   

$designation=$db->query("SELECT designation_id, designation_name  FROM designation");  
$designation=$designation->fetchAll(PDO::FETCH_ASSOC); 
foreach ($designation as $designationkey => $designationvalue) { 
  $designation_id[$designationvalue['designation_id']]=$designationvalue['designation_name'];  
  $designation_id1[$designationvalue['designation_id']]=$designationvalue['designation_name'];  
}  
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

      <!-- Form grid Start -->
      <div class="pd-20 card-box mb-30">
        <div class="clearfix">
          <div class="pull-left">
            <h4 class="text-blue h4">College Details</h4>
          </div> 
        </div>
        <form id="university_form_id">
          <div class="row">
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['uni_code'];?></label>
                <input type="text" class="form-control disabled readonly"  name="clg_code" onchange="check_countdata(this.value,'university','clg_uniq_id','clg_code');"  onkeypress="return isNumber(event);" id="clg_uniq_id" maxlength="4" value="<?php echo $clg_echo1['clg_code'];?>">
                <span id="lblclg_code" class="required_error_msg"></span>
              </div>
            </div>	
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['clg_name_english'];?><span style="color: red;font-size: small;">(in English)</span></label>
                <input type="text" class="form-control disabled readonly" name="clg_name_english" id="clg_name_english" value="<?php echo $clg_echo1['clg_name_english'];?>" onkeypress="return allowOnlyLetters(event,'clg_name_english');">
                <span id="lbluni_name" class="required_error_msg"></span>
              </div>
            </div>
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['uni_name'];?><span style="color: red;font-size: small;"> (in Tamil)</span></label>
                <input type="text" class="form-control disabled readonly" name="clg_name_tamil" id="clg_name_tamil" value="<?php echo $clg_echo1['clg_name_tamil'];?>">
              </div>
            </div> 
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['uni_logo'];?></label>
                <!--  <input type="file" class="form-control-file form-control height-auto disabled readonly" name="uni_logo"  id="uni_logo" value="<?php echo $clg_echo1['uni_logo'];?>"  onchange="return fileValidation('uni_logo','err_msg');">  -->
                <div class="viewbutton"> 
                  <a type="button" class="btn btn-primary" href="<?php echo $clg_echo1['clg_logo'];?>" target="_blank"><i class="dw dw-eye"></i>View</a>
                </div> 
                <span id="err_msg" class="required_error_msg"></span>
              </div>
            </div>    
          </div>

          <div class="row">   
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['uni_head_name'];?><span style="color: red;font-size: small;"> (in English)</span></label>
                <input type="text" class="form-control disabled readonly" name="clg_headname_english"  id="clg_headname_english" value="<?php echo $clg_echo1['clg_headname_english'];?>" onkeypress="return allowOnlyLetters(event,'clg_headname_english');">
                <span id="lbluni_head_name" class="required_error_msg"></span>
              </div>
            </div>
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['uni_head_name'];?><span style="color: red;font-size: small;"> (in Tamil)</span></label>
                <input type="text" class="form-control disabled readonly" name="clg_headname_tamil"  id="clg_headname_tamil" value="<?php echo $clg_echo1['clg_headname_tamil'];?>" onkeypress="return allowOnlyLetters(event,'clg_headname_tamil');">
                <span id="lbluni_head_nametamil" class="required_error_msg"></span>
              </div>
            </div>  
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['uni_head_desg'];?></label>
                <select class="custom-select col-12 disabled readonly" name="clg_head_desig" id="clg_head_desig">  
                  <?php  foreach ($designation_id1 as $designation_id1key => $designation_id1value) {
                    if($clg_echo1['clg_head_desig']==$designation_id1key){ ?>
                      <option value="<?php echo $designation_id1key;?>"><?php echo $designation_id1value;?></option>
                    <?php  }else{ ?> 
                      <option value="<?php echo $designation_id1key;?>"><?php echo $designation_id1value;?></option>
                    <?php }
                  } ?>

                </select> 
              </div>
            </div>  
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['emailid'];?>*</label>
                <input type="text" class="form-control emailcls mailcls disabled readonly"  id="clg_email" name="clg_email" onchange="check_countdata(this.value,'login_details','email','clg_email','mailpassword');" value="<?php echo $clg_echo1['clg_email'];?>">
                <span id="lbluni_email" class="required_error_msg"></span>
              </div>
            </div>
          </div> 
          <div class="row">  
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['mobileno'];?></label>
                <input type="text" class="form-control disabled readonly" name="clg_mobile" maxlength="10" onkeypress="return isNumber(event);" id="clg_mobile" onchange="check_countdata(this.value,'university','clg_mobile','clg_mobile');" value="<?php echo $clg_echo1['clg_mobile'];?>" onkeyup="firstnumvalid(this.value,'clg_mobile');" maxlength="10"> 
                <span id="lbluni_mobile" class="required_error_msg"></span>
              </div>
            </div>
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['stdcode'];?></label>
                <input type="text" class="form-control disabled readonly" name="clg_stdcode" onkeypress="return isNumber(event);" maxlength="5" value="<?php echo $clg_echo1['clg_stdcode'];?>">
              </div>
            </div>
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['landline'];?></label> 
                <input type="text" class="form-control disabled readonly"  name="clg_landline" onkeypress="return isNumber(event);" maxlength="8" id="landline_number" value="<?php echo $clg_echo1['clg_landline'];?>">
              </div>
            </div>
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label ><?php echo $labels['district'];?></label> 
                <select class="custom-select col-12 disabled readonly" name="clg_district" id="clg_district">   
                  <?php  foreach ($district_codes as $districtkey => $districtvalue) {   
                    if($clg_echo1['clg_district']==$districtkey){ ?>
                      <option value="<?php echo $districtkey;?>"><?php echo $districtvalue;?></option>
                    <?php  }else{ ?> 
                      <option value="<?php echo $districtkey;?>"><?php echo $districtvalue;?></option>
                    <?php  } 
                  } ?>

                </select> 
              </div>
            </div>   
          </div>

          <div class="row">    
            <div class="col-md-8 col-sm-12">
              <label><?php echo $labels['address'];?></label> 
              <input type="text" class="form-control disabled readonly" name="clg_address" value="<?php echo $clg_echo1['clg_address'];?>" maxlength="250">
            </div>
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['pincode'];?></label>
                <input type="text" class="form-control disabled readonly" name="clg_pincode" id="clg_pincode" maxlength="6" onkeypress="return isNumber(event);"  value="<?php echo $clg_echo1['clg_pincode'];?>">
              </div>
            </div>
          </div> 
        </form> 
      </div>
      <!-- Form grid End -->

      <?php include "../footer.php"; ?> 
    </div>
  </div>
  <?php include "../common_js.php";?>

</body>
</html>