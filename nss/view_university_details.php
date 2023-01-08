<?php   
include "../db_connect.php";
include "../commen_php.php";
$ip=$_SERVER['REMOTE_ADDR'];
/*$created_date=date("Y/m/d"); */
$created_date=$_SESSION["created_date"]; 
$unique_ids=$_SESSION["unique_ids"]; 


if(isset($_POST['ids'])){  
  $idss= stripQuotes(killChars(trim($_POST['ids'])));  
  $approve1= stripQuotes(killChars(trim($_POST['approve'])));  
  $university = $db->query("SELECT * FROM university where uni_id='$idss'");
  $university_echo=$university->fetch(PDO::FETCH_ASSOC);  
     $uni_jurs_district=$university_echo['uni_jurs_district'];    
  $university_district= view_page_districs($uni_jurs_district); 
}else{
  header("Location:all_university.php"); 
}  
//print_r($university_echo);exit;

if(isset($_SESSION["langtype"])){
  $langtype=$_SESSION["langtype"] ? $_SESSION['langtype'] : '1';
}else{
  $langtype=1;
} 

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



$district=$db->query("SELECT district_code, $districtname as district_name  FROM district  order by district_name");  
$district1=$district->fetchAll(PDO::FETCH_ASSOC); 
foreach ($district1 as $districtkey => $districtvalue) { 
  $district_codes[$districtvalue['district_code']]=$districtvalue['district_name'];  
  $district_codes1[$districtvalue['district_code']]=$districtvalue['district_name'];  
}    
$type_of_institution=$db->query("SELECT institution_id,$institution_name as institution_name  from type_of_institution");  
$institution1=$type_of_institution->fetchAll(PDO::FETCH_ASSOC);  

$type_of_institution = $db->query("SELECT * from type_of_institution"); 
$institution=$type_of_institution->fetchAll(PDO::FETCH_ASSOC); 

 
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
        <!-- <div class="clearfix">
          <div class="pull-left">
            <h4 class="text-blue h4"><?php echo $labels['lbl_university_details'];?></h4>
             <p class="mb-30">All bootstrap element classies</p>
          </div> 
        </div>  -->
        <div class="row">
          <div class="col-md-10 col-sm-12">
          <h4 class="text-blue h4"><?php echo $labels['lbl_university_details'];?></h4>
          </div> 
          <div class="col-md-2 col-sm-12">
           <a href="all_university_details.php"> <button class="btn btn-primary"><i class="icon-copy ion-arrow-left-a">&nbsp; Back</i></button></a>
          </div> 
        </div> 
        <form id="university_form_id">
          <div class="row">
            <br> 
          </div>
          <div class="boxshadow2">
            <div class="row">   
              <div class="col-md-3 col-sm-12"> 
                <div class="form-group">
                  <label><?php echo $labels['uni_name'];?><span class="required_icon">*</span></label>
                  <input type="text" class="form-control disabled" name="uni_name" id="uni_name" value="<?php echo $university_echo['uni_name'];?>" onkeypress="return allowOnlyLetters(event,'uni_name');">
                  <span id="lbluni_name" class="required_error_msg"></span>
                </div>
              </div>
              <div class="col-md-3 col-sm-12">
                <div class="form-group">
                  <label><?php echo $labels['uni_name'];?><span class="required_icon">*</span></label>
                  <input type="text" class="form-control disabled" name="uni_name_tamil" id="uni_name_tamil" value="<?php echo $university_echo['uni_name_tamil'];?>">
                </div>
              </div> 
              <div class="col-md-3 col-sm-12">
                <div class="form-group">
                  <label><?php echo $labels['uni_code'];?><span class="required_icon">*</span></label>
                  <input type="text" class="form-control disabled"  name="uni_code" onchange="check_countdata(this.value,'university','uni_code','uni_code');"  onkeypress="return isNumber(event);" id="uni_code" maxlength="4" value="<?php echo $university_echo['uni_code'];?>">
                  <span id="lbluni_code" class="required_error_msg"></span>
                </div>
              </div> 
              <div class="col-md-3 col-sm-12">
                <div class="form-group">
                  <label><?php echo $labels['uni_emailid'];?><span class="required_icon">*</span></label>
                  <input type="text" class="form-control emailcls mailcls disabled"  id="uni_emailid" name="uni_emailid" onchange="check_countdata(this.value,'login_details','email','uni_emailid','mailpassword');mailvalid('uni_emailid');" value="<?php echo $university_echo['uni_email'];?>">
                  <span id="lbluni_emailid" class="required_error_msg"></span>
                </div>
              </div>    
            </div>  
            <div class="row"> 
              <div class="col-md-3 col-sm-12">
                <div class="form-group">
                  <label><?php echo $labels['uni_mobileno'];?><span class="required_icon">*</span></label>
                  <input type="text" class="form-control disabled" name="uni_mobile" maxlength="10" onkeypress="return isNumber(event);" id="uni_mobile" onchange="check_countdata(this.value,'university','uni_mobile','uni_mobile');" value="<?php echo $university_echo['uni_mobile'];?>" onkeyup="firstnumvalid(this.value,'uni_mobile');" maxlength="10"> 
                  <span id="lbluni_mobile" class="required_error_msg"></span>
                </div>
              </div> 
              <div class="col-md-3 col-sm-12">
                <div class="form-group">
                  <label><?php echo $labels['stdcode'];?><span class="required_icon">*</span></label>
                  <input type="text" class="form-control disabled" name="uni_std" onkeypress="return isNumber(event);" maxlength="5" value="<?php echo $university_echo['uni_std'];?>" onkeyup="stdvalid(this.value,'uni_std');">
                </div>
              </div>
              <div class="col-md-3 col-sm-12">
                <div class="form-group">
                  <label><?php echo $labels['landline'];?><span class="required_icon">*</span></label> 
                  <input type="text" class="form-control disabled"  name="uni_landline" onkeypress="return isNumber(event);" maxlength="8" id="landline_number" value="<?php echo $university_echo['uni_landline'];?>">
                </div>
              </div>
              <div class="col-md-3 col-sm-12">
                <div class="form-group"> 
                  <label ><?php echo $labels['district'];?><span class="required_icon">*</span></label> 
                  <select class="form-control col-12 disabled" name="district" id="district"> 
                    <?php  
                    $district_echo=json_decode($university_echo['uni_district'],true); 
                    foreach ($district_codes as $districtkey => $districtvalue){
                      if($university_echo['uni_district']==$districtkey){  ?> 
                        <option value="<?php echo $districtkey;?>" selected><?php echo $districtvalue;?></option>
                      <?php   }else{  
                        ?> 
                        <option value="<?php echo $districtkey;?>"><?php echo $districtvalue;?></option>
                        <?php  
                      } 
                    }?>
                  </select>
                </div>
              </div>
            </div>

            <div class="row"> 
              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label><?php echo $labels['pincode'];?><span class="required_icon">*</span></label> 
                  <input type="text" class="form-control disabled"  name="pincode" onkeypress="return isNumber(event);" onkeyup="pincodevalid(this.value,'pincode');" maxlength="6" id="pincode" value="<?php echo $university_echo['uni_pincode'];?>">
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label><?php echo $labels['uni_status'];?><span class="required_icon">*</span></label>
                  <select class="form-control col-12 disabled" name="uni_status" id="uni_status"> 
                    <?php   
                    foreach ($institution1 as $institution1key => $institution1value) { 
                      if($university_echo['uni_type']==$institution1value['institution_id']){  ?>  
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
               
              <div class="col-md-4 col-sm-12"> 
                <div class="form-group">
                  <label><?php echo $labels['no_of_colleges'];?><span class="required_icon">*</span></label>
                  <input type="text" class="form-control disabled" name="no_of_colleges" id="no_of_colleges" value="<?php echo $university_echo['no_of_clg'];?>" onkeypress="return isNumber(event);">
                  <span id="lblno_of_colleges" class="required_error_msg"></span>
                </div>
              </div>
            </div> 

          <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                  <label ><?php echo $labels['jurisdiction_dict'];?><span class="required_icon">*</span></label> 
                  <input type="text" class="form-control disabled" value="<?php echo $university_district;?>">
                </div>  
              </div> 
          </div> 

          </div>
          <div class="row">
            <br> 
          </div>
          <div class="boxshadow2">
            <div class="row">
              <div class="col-md-4 col-sm-12"> 
                <div class="form-group">
                  <label><?php echo $labels['registrar_name'];?><span class="required_icon">*</span></label>
                  <input type="text" class="form-control disabled" name="registrar_name" id="registrar_name" value="<?php echo $university_echo['registrar_name'];?>" onkeypress="return allowOnlyLetters(event,'registrar_name');">
                  <span id="lblregistrar_name" class="required_error_msg"></span>
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label><?php echo $labels['registrar_emailid'];?><span class="required_icon">*</span></label>
                  <input type="text" class="form-control emailcls mailcls disabled"  id="registrar_emailid" name="registrar_emailid" onchange="check_countdata(this.value,'login_details','email','registrar_emailid','mailpassword');mailvalid('registrar_emailid');" value="<?php echo $university_echo['registrar_mail'];?>">
                  <span id="lblregistrar_emailid" class="required_error_msg"></span>
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label><?php echo $labels['registrar_mobileno'];?><span class="required_icon">*</span></label>
                  <input type="text" class="form-control disabled" name="registrar_mobile" maxlength="10" onkeypress="return isNumber(event);" id="registrar_mobile" onchange="check_countdata(this.value,'university','registrar_mobile','registrar_mobile');" value="<?php echo $university_echo['registrar_mobile'];?>" onkeyup="firstnumvalid(this.value,'registrar_mobile');" maxlength="10"> 
                  <span id="lbluni_mobile" class="required_error_msg"></span>
                </div>
              </div>
            </div> 
            <div class="row">
              <div class="col-md-4 col-sm-12"> 
                <div class="form-group">
                  <label><?php echo $labels['Vice_Clor_name'];?><span class="required_icon">*</span></label>
                  <input type="text" class="form-control disabled" name="Vice_Clor_name" id="Vice_Clor_name" value="<?php echo $university_echo['vice_chancellor_name'];?>" onkeypress="return allowOnlyLetters(event,'Vice_Clor_name');">
                  <span id="lblVice_Clor_name" class="required_error_msg"></span>
                </div>
              </div>
              <div class="col-md-4 col-sm-12"> 
                <div class="form-group">
                  <label><?php echo $labels['Vice_Clor_emailid'];?><span class="required_icon">*</span></label>
                  <input type="text" class="form-control emailcls mailcls disabled"  id="Vice_Clor_emailid" name="Vice_Clor_emailid" onchange="check_countdata(this.value,'login_details','email','Vice_Clor_emailid','mailpassword');mailvalid('Vice_Clor_emailid');" value="<?php echo $university_echo['vice_chancellor_mail'];?>">
                  <span id="lblVice_Clor_emailid" class="required_error_msg"></span>
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label><?php echo $labels['Vice_Clor_mobileno'];?><span class="required_icon">*</span></label> 
                  <input type="text" class="form-control disabled" name="Vice_Clor_mobileno" maxlength="10" onkeypress="return isNumber(event);" id="Vice_Clor_mobileno" onchange="check_countdata(this.value,'university','Vice_Clor_mobileno','Vice_Clor_mobileno');" value="<?php echo $university_echo['vice_chancellor_mobile'];?>" onkeyup="firstnumvalid(this.value,'Vice_Clor_mobileno');" maxlength="10">  
                  <span id="lblVice_Clor_mobileno" class="required_error_msg"></span>
                </div>
              </div>
            </div>
          </div> 

          <div class="row">
            <br> 
          </div>
          <div class="boxshadow2">
            <div class="row"> 
              <div class="col-md-12 col-sm-12"> 
                <div class="pull-left">
                   <?php 
                if($university_echo['uni_active_status']=='1'){
                  $checked='checked';
                  $color='#2C6700';
                  $status_text='disapprove';
                }elseif($university_echo['uni_active_status'] =='0'){
                  $checked='';
                  $color='Orange';
                  $status_text='approve/disapprove';
                }elseif($university_echo['uni_active_status'] =='2'){
                  $checked='';
                  $color='red';
                  $status_text='approve';
                } 
                ?>
                  <h5 class="h4" style="color: green;">Do you want to <?php echo $status_text;?> this university?</h5>  
                </div> 
                &nbsp &nbsp &nbsp <label class="switch"><input type="checkbox" <?php echo $checked?> class="stauscls"><span class="slider round" style="background-color:<?php echo $color?>"></span></label>
              </div>  
            </div>  
            <div class="row remarks">
              <div class="col-md-8 col-sm-12">
                <div class="form-group">
                  <label>Reason For Disapproval:<span style="color:red;"> *</span></label> 
                  <input type="text" class="form-control remarkdata" value="<?php echo $university_echo['remark'];?>">
                </div>
                </div> 
                <div class="col-md-2 col-sm-12 disapprovebtn" style="margin-top: 2%;">  
                  <div class="form-group"> 
                    <span class="remarkdata_reqr_msg" style="color:red;"></span>
                    <button class="btn btn-secondary" onclick="remarksave($('.remarkdata').val())" type="button">Save</button>
                  </div>
                </div> 
              </div>  
          </div>  
        </form> 
      </div>
    </div>
  </div>
  <?php include "../footer.php"; ?>
  <?php include "../common_js.php";?>  
  <script type="text/javascript">   


var updateid=<?php echo json_encode($university_echo['uni_id'])?>;  
var loginmaill=<?php echo json_encode($university_echo['uni_email'])?>; 
var uni_active_status=<?php echo json_encode($university_echo['uni_active_status'])?>; 
var unique_ids1=<?php echo json_encode($unique_ids)?>;   
$(".remarks").hide(); 

$(document).on('change', '.stauscls', function() {  
Swal.fire({
  title: 'Do you want to save the changes?',
  showDenyButton: true,
  showCancelButton: true,
  confirmButtonText: 'Approve',
  denyButtonText: 'Disapprove',
}).then((result) => { 
  if (result.isConfirmed) { //alert(updateid);
    login_approve_status('1',loginmaill,updateid,10);
    status_switch('1','university','uni_active_status','uni_id',updateid,loginmaill,'');  
} else if (result.isDenied) {
   $(".remarks").show();  
  if(uni_active_status=='0'){ 
     $(".remarks").show(); 
    var remarkdata2=$('.remarkdata').val();
    if(remarkdata2 !=''){
      remarksave($('.remarkdata').val()); 
    }
    
  } 
}
})
}); 

 
if(uni_active_status==2){ 
  $(".remarks").show(); 
  $('.remarkdata').attr('readonly', true);
  $(".disapprovebtn").hide(); 
}else{
  $(".remarks").hide(); 
}
$('.remarkdata_reqr_msg').hide();
function remarksave(remark){
  if(remark !=''){ //alert(remark);
     var remarkdata=remark;
      login_approve_status('2',loginmaill,updateid,10);
      status_switch('2','university','uni_active_status','uni_id',updateid,loginmaill,remarkdata); 
  }else{ 
    $('.remarkdata_reqr_msg').show();
     $('.remarkdata_reqr_msg').html('Enter Remarks');
  } 
}

</script>
</body>
</html>