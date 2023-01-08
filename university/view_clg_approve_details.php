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
$contact=$db->query("SELECT contact_id, contact_name FROM m_contact");
$contact1=$contact->fetchAll(PDO::FETCH_ASSOC);
foreach ($contact1 as $contactkey => $contactvalue) {
  $contact_codes[$contactvalue['contact_id']]=$contactvalue['contact_name'];
}

$type_of_institution=$db->query("SELECT institution_id,$institution_name as institution_name  from type_of_institution");  
$institution1=$type_of_institution->fetchAll(PDO::FETCH_ASSOC); 

 

if(isset($_POST['ids'])){ 
  $idss= stripQuotes(killChars(trim($_POST['ids'])));   
$college = $db->query("SELECT * from college where clg_id='$idss'"); 
$college_echo=$college->fetch(PDO::FETCH_ASSOC);  //print_r($college_echo);exit;
$jurisdiction_dict=$college_echo['jurisdiction_dict'];    
$university_district= view_page_districs($jurisdiction_dict); 
}else{
header("Location:all_college_details.php"); 
} 
 //print_r($college_echo['clg_id']);exit;
  
?> 

<!DOCTYPE html>
<html>
<?php include "../head.php"; ?>  
<style type="text/css">
  .boxshadow2 {
    padding: 22px;
  box-shadow: 0 0 28px rgb(0 0 0 / 22%);
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
        <div class="row">
          <div class="col-md-10 col-sm-12">
            <h4 class="text-blue h4"><?php echo $labels['clg_details'];?></h4> 
          </div> 
          <div class="col-md-2 col-sm-12">
          <a href="all_college_details.php">  <button class="btn btn-primary"><i class="icon-copy ion-arrow-left-a">&nbsp; Back</i></button></a>
          </div> 
        </div> 
      <div class="row">
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['uni_name'];?><span class="required_symbol"> *</span></label>
                <select class="form-control disabled" name="university_id" id="university_id">  
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
                <label><?php echo $labels['college_code'];?><span class="required_symbol">*</span></label>
                <input type="text" class="form-control disabled"  name="clg_code" id="clg_code" onkeypress="return isNumber(event,'clg_code');"  maxlength="4" onchange="check_countdata(this.value,'college','clg_code','clg_code');" required value="<?php echo $college_echo['clg_code']?>">
                <span id="lblclg_code" style="color: red;font-size: small;"></span>

              </div>
            </div>
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['clg_name'];?><span class="required_symbol">* <?php echo $labels['in_english'];?></span></label>
                <input type="text" class="form-control disabled" name="clg_name_english" id="clg_name_english" onkeypress="return allowOnlyLetters(event,'clg_name');" value="<?php echo $college_echo['clg_name_english']?>">
                <span id="lblclg_name_english" style="color: red;font-size: small;"></span>

              </div> 
            </div>
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['clg_name'];?><span class="required_symbol">* <?php echo $labels['in_tamil'];?></span></label>
                <input type="text" class="form-control disabled" name="clg_name_tamil" id="clg_name_tamil" onkeypress="return allowOnlyLetters(event,'clg_name_tamil');" value="<?php echo $college_echo['clg_name_tamil']?>">
                <span id="lblclg_name_tamil" style="color: red;font-size: small;"></span>
              </div>
            </div>
          </div>
          <div class="row"> 
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['clg_email_id'];?><span class="required_symbol">*</span></label>

                <input type="text" class="form-control emailcls disabled" name="clg_email" id="clg_email" onkeypress="return clear_error();" onchange="check_countdata(this.value,'login_details','email','clg_email'); mailvalid('clg_email');" value="<?php echo $college_echo['clg_email']?>" >
                <span id="lblclg_email" style="color:red; font-size: small;"></span>
              </div>
            </div> 
           <div class="col-md-3 col-sm-12">
      <div class="form-group ">
        <label><?php echo $labels['mobile_r_landline'];?><span class="required_symbol">*</span> </label>
        <select class="form-control disabled" name="clg_mobile_r_landline" id="clg_mobile_r_landline"  onchange="select_proof(this.value);"> 
          <option hidden="true"  value="null"><?php echo $labels['choose'];?></option> 
            <?php
          foreach ($contact_codes as $contactkey => $contactvalue) { 
            if($college_echo['clg_mobile_r_landline']==$contactkey){  ?>
              <option value="<?php echo $contactkey;?>" selected><?php echo $contactvalue;?></option>
          <?php   }else{ ?> 
            <option value="<?php echo $contactkey;?>"><?php echo $contactvalue;?></option>
          <?php  }
        } ?>
      </select>
        <span id="lblmobile_r_landline" class="required_error_msg"></span>
      </div>
    </div>   

    <div class="col-md-2 col-sm-12 landline">
      <div class="form-group ">
        <label><?php echo $labels['stdcode'];?><span class="required_symbol"> *</span></label>
        <input type="text" class="form-control disabled" name="clg_std" onkeypress="return isNumber(event);" maxlength="5" value="<?php echo $college_echo['clg_std'];?>" onkeyup="stdvalid(this.value,'clg_std');" onchange="select_proof(this.value);">
      </div>
    </div>
    <div class="col-md-4 col-sm-12 landline">
      <div class="form-group ">
        <label><?php echo $labels['landline'];?><span class="required_symbol"> *</span></label> 
        <input type="text" class="form-control disabled"  name="clg_landline" onkeypress="return isNumber(event);" maxlength="8" id="clg_landline" value="<?php echo $college_echo['clg_landline'];?>" onchange="select_proof(this.value);">
      </div>
    </div>
  <div class="col-md-6 col-sm-12 mobileno">
      <div class="form-group ">
        <label><?php echo $labels['mobileno'];?><span class="required_symbol"> *</span></label>
        <input type="text" class="form-control disabled" name="clg_mobile" maxlength="10" onkeypress="return isNumber(event);" id="clg_mobile" onchange="check_countdata(this.value,'college','clg_mobile','clg_mobile');" value="<?php echo $college_echo['clg_mobile'];?>" onkeyup="firstnumvalid(this.value,'clg_mobile');" maxlength="10"  onchange="select_proof(this.value);"> 
        <span id="lbluni_mobile" class="required_error_msg"></span>
      </div>
    </div> 
  
          </div> 
             <div class="row">
            <div class="col-md-9 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['college_address'];?><span class="required_symbol">*</span></label>

                <input type="text" class="form-control disabled" name="clg_address" id="clg_address"  value="<?php echo $college_echo['clg_address']?>">
              </div>
            </div> 
           <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label ><?php echo $labels['district'];?><span class="required_symbol">*</span></label>  
                <select class="form-control disabled" name="col_district" id="col_district"> 
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
          </div>
         <div class="row"> 
             <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['pincode'];?><span class="required_symbol">*</span></label> 
                <input type="text" class="form-control disabled" name="pincode" maxlength="6" onkeypress="return isNumber(event,'tot_num_unit');" onkeyup="pincodevalid(this.value,'pincode');" onchange="pincodlength(this.value,'pincode','lblpincode');" id="pincode" value="<?php echo $college_echo['pincode']?>">
                <span id="lblpincode" style="color: red;font-size: small;"></span>
              </div>
            </div>
 
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['clg_type'];?><span class="required_symbol">*</span></label>
                <select class="form-control disabled" name="clg_type" id="clg_type">  
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
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['tot_num_unit'];?><span class="required_symbol">*</span></label> 
                <input type="text" class="form-control disabled" name="tot_num_unit" maxlength="3" onkeypress="return isNumber(event,'tot_num_unit');" id="tot_num_unit" value="<?php echo $college_echo['tot_num_unit']?>">
                <span id="lbltot_num_unit" style="color: red;font-size: small;"></span>
              </div>
            </div>
          </div>
           <div class="row">
               <div class="col-md-12 col-sm-12"> 
              <div class="form-group"> 
                <label ><?php echo $labels['clg_juri_dist'];?><span class="required_symbol">*</span></label> 
                <input type="text" class="form-control disabled" name="jurisdiction_dict" id="jurisdiction_dict" value="<?php echo $university_district?>"> 
              </div>  
            </div>
           </div>
           <div class="row">
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['principle_name'];?><span class="required_symbol">*</span></label>
                <input type="text" class="form-control disabled" name="principle_name" id="principle_name" onkeypress="return allowOnlyLetters(event,'principle_name');" value="<?php echo $college_echo['principle_name']?>">
                <span id="lblprinciple_name" style="color: red;font-size: small;"></span>
              </div>
            </div>
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['principle_contact'];?><span class="required_symbol">*</span></label> 
                <input type="text" class="form-control disabled" name="principle_contact" maxlength="10" onkeypress="return isNumber(event,'principle_contact');" id="principle_contact" onchange="check_countdata(this.value,'college','principle_contact','principle_contact');" onkeyup="firstnumvalid(this.value,'principle_contact');" value="<?php echo $college_echo['principle_contact']?>">
                <span id="lblprinciple_contact" style="color: red;font-size: small;"></span>
              </div>
            </div>
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['principle_emailid'];?><span class="required_symbol">*</span></label>

                <input type="text" class="form-control emailcls disabled" name="principle_emailid" id="principle_emailid" onkeypress="return clear_error();" onchange="check_countdata(this.value,'login_details','email','principle_emailid'); mailvalid('principle_emailid');" value="<?php echo $college_echo['principle_emailid']?>">
                <span id="lblprinciple_emailid" style="color:red; font-size: small;"></span>
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
          <?php  
  if($college_echo['active_status']=='1'){
            $checked='checked';
            $color='#2C6700';
             $status_text='disapprove';
          }elseif($college_echo['active_status']=='0'){
            $checked='';
            $color='Orange';
            $status_text='approve/disapprove';
          }elseif($college_echo['active_status']=='2'){
            $checked='';
            $color='red';
            $status_text='approve';
          } 
          ?>
          <div class="pull-left">
            <h5 class="h4" style="color: green;">Do you want to <?php echo $status_text;?> this College?</h5>  
          </div>
          &nbsp &nbsp &nbsp <label class="switch"><input type="checkbox" <?php echo $checked?> class="stauscls"><span class="slider round" style="background-color:<?php echo $color?>"></span></label>
         </div> 
  </div>  
   <div class="row remarks">
              <div class="col-md-8 col-sm-12">
                <div class="form-group">
                  <label>Reason For Disapproval<span style="color:red;">*</span></label> 
                  <input type="text" class="form-control remarkdata" value="<?php echo $college_echo['remark'];?>">
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
  
 //mobileno landline hide and show   
 $('.mobileno').hide();
$('.landline ').show(); 
select_proof(<?php echo json_encode($college_echo['clg_mobile_r_landline'])?>); 

function select_proof(input){  
    if(input==1){
        $('.mobileno').hide();  
        $('.landline').show(); 
    }else if(input==2){
        $('.mobileno').show();  
        $('.landline').hide();
    }    
     
} 

var updateid=<?php echo json_encode($college_echo['clg_id'])?>;  
var loginmaill=<?php echo json_encode($college_echo['clg_email'])?>;  
var cls_active_status=<?php echo json_encode($college_echo['active_status'])?>;
$(".remarks").hide(); 

$('.remarkdata_reqr_msg').hide();
  
$(document).on('change', '.stauscls', function() { 
    //alert(updateid);
 Swal.fire({
  title: 'Do you want to save the changes?',
  showDenyButton: true,
  showCancelButton: true,
  confirmButtonText: 'Approve',
  denyButtonText: 'Disapprove',
}).then((result) => { 
  if (result.isConfirmed) {
    login_approve_status('1',loginmaill,updateid,20);
    status_switch('1','college','active_status','clg_id',updateid,loginmaill,'');    
    Swal.fire('Approved!', '', 'success')  
  } else if (result.isDenied) {
     $(".remarks").show();  
  if(cls_active_status=='0'){ 
     $(".remarks").show(); 
    var remarkdata2=$('.remarkdata').val();
    if(remarkdata2 !=''){
      remarksave($('.remarkdata').val()); 
    } 
  } 
  }
})
});


if(cls_active_status==2){  
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
      status_switch('2','college','active_status','clg_id',updateid,loginmaill,remarkdata); 
  }else{ 
    $('.remarkdata_reqr_msg').show();
     $('.remarkdata_reqr_msg').html('Enter Remarks');
  } 
}
</script> 
</body>
</html>