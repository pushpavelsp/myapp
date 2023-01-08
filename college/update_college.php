<?php
  include "../db_connect.php";   
  include "../commen_php.php";  
  if($_SESSION['unique_ids']==''){    
    header('Location:'.$Base_url21.'login_page.php');  
}
  $created_date=date("Y/m/d"); 
  $unique_ids=$_SESSION["unique_ids"];  
  $ip=$_SERVER['REMOTE_ADDR'];
  if(isset($_SESSION["langtype"])){
    $langtype=$_SESSION["langtype"] ? $_SESSION['langtype'] : '1';
  }
  else{
    $langtype=1;
  }
  //print_r(54646);exit;
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
  if(isset($_POST['clg_code'])){  //print_r($_POST);exit;
    $university_id = stripQuotes(killChars($_POST['university_id']));   
    $clg_contact = stripQuotes(killChars($_POST['clg_contact']));   
    $clg_type = stripQuotes(killChars($_POST['clg_type']));   
    $jurisdiction_dict = json_encode($_POST['jurisdiction_dict']);   
    $clg_address = stripQuotes(killChars($_POST['clg_address']));  
    $principle_name = stripQuotes(killChars($_POST['principle_name']));  
    $principle_contact = stripQuotes(killChars($_POST['principle_contact']));  
    $principle_emailid = stripQuotes(killChars($_POST['principle_emailid']));  
    $tot_num_unit = stripQuotes(killChars($_POST['tot_num_unit']));  
    $col_district = stripQuotes(killChars($_POST['col_district']));  
    $pincode = stripQuotes(killChars($_POST['pincode']));  
    $clg_mobile_r_landline = stripQuotes(killChars($_POST['clg_mobile_r_landline']));
    $clg_std = stripQuotes(killChars($_POST['clg_std'])); 
    $clg_landline = stripQuotes(killChars($_POST['clg_landline']));
    $clg_mobileno = stripQuotes(killChars($_POST['clg_mobile']));   
    try {  
      $serial_id=$db->query("SELECT * FROM college where clg_id='$unique_ids'")->rowCount();  
      if($serial_id=='1'){  
        //print_r();exit;
       $insert_query = $db->query("UPDATE college SET  clg_type='$clg_type', jurisdiction_dict='$jurisdiction_dict', clg_address='$clg_address', principle_name='$principle_name', principle_contact='$principle_contact', principle_emailid='$principle_emailid', update_by='$unique_ids', update_time='now()', update_ip='$ip', tot_num_unit='$tot_num_unit', col_district='$col_district', pincode='$pincode',clg_mobile_r_landline='$clg_mobile_r_landline', clg_std='$clg_std', clg_landline='$clg_landline', clg_mobileno='$clg_mobileno' WHERE university_id='$university_id' and clg_id='$unique_ids'"); 
        $datainsert='update';
      }   
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
  $district=$db->query("SELECT district_code, $districtname as district_name  FROM district  order by district_name");  
  $district1=$district->fetchAll(PDO::FETCH_ASSOC); 
  foreach ($district1 as $districtkey => $districtvalue) {   
    $district_codes1[$districtvalue['district_code']]=$districtvalue['district_name'];  
    $district_codes2[$districtvalue['district_code']]=$districtvalue['district_name'];  
  }   
  // Landline or mobile number Dropdown fetch data from db 
  $contact=$db->query("SELECT contact_id, contact_name FROM m_contact");
  $contact1=$contact->fetchAll(PDO::FETCH_ASSOC);
  foreach ($contact1 as $contactkey => $contactvalue) {
    $contact_codes[$contactvalue['contact_id']]=$contactvalue['contact_name'];
  }
  $type_of_institution=$db->query("SELECT institution_id,$institution_name as institution_name  from type_of_institution");  
  $institution1=$type_of_institution->fetchAll(PDO::FETCH_ASSOC); 
  $college = $db->query("SELECT * from college where clg_id='$unique_ids'"); 
  $college_echo=$college->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="nssicon" href="vendors/images/logo-icon.png">
</head>
<?php include "../head.php"; ?> 
<body>
  <?php include "../header.php"; ?>  
  <div class=""></div>
  <div class="main-container">
    <div class="pd-ltr-20">
      <!-- Form grid Start --> 
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page" href="">Update College</li>
  </ol>
</nav>     
      <div class="container pd-20 card-box mb-30">
        <div class="clearfix">
          <div class="pull-left">
            <h4 class="text-blue h4"><?php echo $labels['update_clg_details'];?>
              <span class="required_symbol">  <?php echo $labels['mandatory_field'];?>  </span>
            </h4>
          </div> 
        </div>
        <form id="college-form">
          <div class="row">
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['uni_name'];?><span class="required_symbol">*</span></label>
                <select class="form-control" name="university_id" id="university_id">  
                  <option hidden="true">Select</option>  
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
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['college_code'];?><span class="required_symbol">*</span></label>
                <input type="text" class="form-control"  name="clg_code" id="clg_code" onkeypress="return isNumber(event,'clg_code');"  maxlength="4" onchange="check_countdata(this.value,'college','clg_code','clg_code');"  value="<?php echo $college_echo['clg_code']?>">
                <span id="lblclg_code" style="color: red;font-size: small;"></span>
              </div>
            </div>
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['clg_name'];?><span class="required_symbol">* <?php echo $labels['in_english'];?></span></label>
                <input type="text" class="form-control" name="clg_name_english" id="clg_name_english" onkeypress="return allowOnlyLetters(event,'clg_name');" value="<?php echo $college_echo['clg_name_english']?>">
                <span id="lblclg_name_english" style="color: red;font-size: small;"></span>
              </div> 
            </div> 
          </div>
          <div class="row"> 
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['clg_name'];?><span class="required_symbol">* <?php echo $labels['in_tamil'];?></span></label>
                <input type="text" class="form-control" name="clg_name_tamil" id="clg_name_tamil" onkeypress="return allowOnlyLetters(event,'clg_name_tamil');" value="<?php echo $college_echo['clg_name_tamil']?>">
                <span id="lblclg_name_tamil" style="color: red;font-size: small;"></span>
              </div>
            </div> 
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['clg_email_id'];?><span class="required_symbol">*</span></label>
                <input type="text" class="form-control emailcls" name="clg_email" id="clg_email" onkeypress="return clear_error();" onchange="check_countdata(this.value,'login_details','email','clg_email'); mailvalid('clg_email');" value="<?php echo $college_echo['clg_email']?>" >
                <span id="lblclg_email" style="color:red; font-size: small;"></span>
              </div>
            </div> 
             <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['clg_type'];?><span class="required_symbol">*</span></label>
                <select class="form-control" name="clg_type" id="clg_type">  
                  <?php   
                   if($college_echo['clg_type'] ==''){  ?>    
                  <option value="" hidden="true">Select</option>
                  <?php   } 
                  foreach ($institution1 as $institution1key => $institution1value) { 
                    if($college_echo['clg_type']==$institution1value['institution_id']){  ?>  
                      <option value="<?php echo $institution1value['institution_id'];?>" selected><?php echo $institution1value['institution_name'];?></option>
                    <?php }else{
                      ?>   
                      <option value="<?php echo $institution1value['institution_id'];?>"><?php echo $institution1value['institution_name'];?></option>
                      <?php  } } ?>    
                </select> 
              </div> 
            </div>
          </div>  
          <div class="row">
            <div class="col-md-4 col-sm-12">
                      <div class="form-group">
                        <label><?php echo $labels['tot_num_unit'];?><span class="required_symbol">*</span></label> 
                        <input type="text" class="form-control" name="tot_num_unit" maxlength="3" onkeypress="return isNumber(event,'tot_num_unit');" id="tot_num_unit" value="<?php echo $college_echo['tot_num_unit']?>">
                        <span id="lbltot_num_unit"  class="required_error_msg"></span>
                      </div>
                  </div> 
            <div class="col-md-3 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['mobile_r_landline'];?><span class="required_symbol">*</span> </label>
                <select class="form-control" name="clg_mobile_r_landline" id="clg_mobile_r_landline"  onchange="select_proof(this.value);"> 
                  <option hidden="true"  value="null"><?php echo $labels['choose'];?></option> 
                  <?php
                    foreach ($contact_codes as $contactkey => $contactvalue) { 
                    if($college_echo['clg_mobile_r_landline']==$contactkey){  ?>
                    <option value="<?php echo $contactkey;?>" selected><?php echo $contactvalue;?></option>
                    <?php   }else{ ?> 
                    <option value="<?php echo $contactkey;?>"><?php echo $contactvalue;?></option>
                  <?php  }} ?>
                </select>
                <span id="lblmobile_r_landline" class="required_error_msg"></span>
              </div>
            </div>   
            <div class="col-md-2 col-sm-12 landline">
              <div class="form-group ">
                <label><?php echo $labels['stdcode'];?><span class="required_symbol"> *</span></label>
                <input type="text" class="form-control" name="clg_std" onkeypress="return isNumber(event);" maxlength="5" value="<?php echo $college_echo['clg_std'];?>" onkeyup="stdvalid(this.value,'clg_std');" onchange="select_proof(this.value);">
              </div>
            </div>
            <div class="col-md-3 col-sm-12 landline">
              <div class="form-group ">
                <label><?php echo $labels['landline'];?><span class="required_symbol"> *</span></label> 
                <input type="text" class="form-control"  name="clg_landline" onkeypress="return isNumber(event);" maxlength="8" id="clg_landline" value="<?php echo $college_echo['clg_landline'];?>" onchange="select_proof(this.value);">
              </div>
            </div>
            <div class="col-md-5 col-sm-12 mobileno">
              <div class="form-group ">
                <label><?php echo $labels['mobileno'];?><span class="required_symbol"> *</span></label>
                <input type="text" class="form-control" name="clg_mobile" maxlength="10" onkeypress="return isNumber(event);" id="clg_mobile" onchange="check_countdata(this.value,'college','clg_mobile','clg_mobile');" value="<?php echo $college_echo['clg_mobileno'];?>" onkeyup="firstnumvalid(this.value,'clg_mobile');" maxlength="10"  onchange="select_proof(this.value);"> 
                <span id="lbluni_mobile" class="required_error_msg"></span>
              </div>
            </div> 
          </div>
          <div class="row">
            <div class="col-md-7 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['college_address'];?><span class="required_symbol">*</span></label>
                <input type="text" class="form-control" name="clg_address" id="clg_address"  value="<?php echo $college_echo['clg_address']?>"  onkeypress="return address_spec_char(event);">
              </div>
            </div> 
            <div class="col-md-2 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['pincode'];?><span class="required_symbol">*</span></label> 
                <input type="text" class="form-control" name="pincode" maxlength="6" onkeypress="return isNumber(event,'pincode');" onkeyup="pincodevalid(this.value,'pincode');" onchange="pincodlength(this.value,'pincode','lblpincode');" id="pincode" value="<?php echo $college_echo['pincode']?>">
                <span id="lblpincode" style="color: red;font-size: small;"></span>
              </div>
            </div> 
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label ><?php echo $labels['district'];?><span class="required_symbol">*</span></label>  
                <select class="form-control" name="col_district" id="col_district"> 
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
          </div>   
          <div class="row">
          <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label ><?php echo $labels['clg_juri_dist'];?><span class="required_symbol">*</span></label> 
                <select class="selectpicker form-control " name="jurisdiction_dict[]" id="jurisdiction_dict" data-size="5" data-style="btn-outline-success" data-selected-text-format="count" multiple>  
                  <?php  
                  $district_echo=json_decode($college_echo['jurisdiction_dict'],true); 
                  foreach ($district_codes1 as $districtkey => $districtvalue){  
                    if(in_array($districtkey, $district_echo)){ ?> 
                      <option value="<?php echo $districtkey;?>" class="multiselect_selected" selected><?php echo $districtvalue;?></option>
                    <?php }else{  ?> 
                      <option value="<?php echo $districtkey;?>"><?php echo $districtvalue;?></option>
                    <?php  } 
                  } ?>
                </select>
              </div>  
            </div>
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['principle_name'];?><span class="required_symbol">*</span></label>
                <input type="text" class="form-control" name="principle_name" id="principle_name" onkeypress="return allowOnlyLetters(event,'principle_name');" value="<?php echo $college_echo['principle_name']?>">
                <span id="lblprinciple_name" style="color: red;font-size: small;"></span>
              </div>
            </div>
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['principle_contact'];?><span class="required_symbol">*</span></label> 
                <input type="text" class="form-control" name="principle_contact" maxlength="10" onkeypress="return isNumber(event,'principle_contact');" id="principle_contact" onchange="check_countdata(this.value,'college','principle_contact','principle_contact');" onkeyup="firstnumvalid(this.value,'principle_contact');" value="<?php echo $college_echo['principle_contact']?>">
                <span id="lblprinciple_contact" style="color: red;font-size: small;"></span>
              </div>
            </div>
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label><?php echo $labels['principle_emailid'];?><span class="required_symbol">*</span></label>
                <input type="text" class="form-control emailcls" name="principle_emailid" id="principle_emailid" onkeypress="return clear_error();" onchange="check_countdata(this.value,'login_details','email','principle_emailid'); mailvalid('principle_emailid');" value="<?php echo $college_echo['principle_emailid']?>">
                <span id="lblprinciple_emailid" style="color:red; font-size: small;"></span>
              </div>
            </div> 
          </div>
          <div class="row"> 
            <div class="col-sm-12">   
                <!-- <button type="button" class="btn btn-primary form_submitbtn_style Edithide" onclick="edithide('<?php echo $unique_ids?>');">Edit</button> -->
                <button type="submit" class="btn btn-primary form_submitbtn_style">Update</button>   
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
  $("#clg_name_english").focusout(function(){    
    translate('clg_name_english','clg_name_tamil'); 
  }); 
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
  $("#clg_email,#clg_name_tamil,#clg_name_english,#clg_code,#university_id").attr("readonly",true); 
  $("#college-form").validate({
  rules: {
    //university_id:{ required: true,  }, 
    //clg_code:{ required: true,maxlength: 4, minlength:4  }, 
    //clg_name_english:{ required: true, }, 
    //clg_email:{ required: true, email: true,},  
    clg_mobile_r_landline :{ required: true, }, 
    clg_std :{ required: true, }, 
    clg_landline :{ required: true, }, 
    clg_mobile:{ required: true, }, 
    clg_contact:{ required: true, maxlength: 15, },  
    clg_type :{ required: true,  }, 
    jurisdiction_dict :{ required: true,  }, 
    clg_address:{ required: true,maxlength: 250,minlength:10 },
    col_district :{ required: true,  }, 
    pincode :{ required: true, maxlength:6 }, 
    tot_num_unit:{ required: true,maxlength:3  },
    principle_name:{ required: true, }, 
    principle_contact:{ required: true, maxlength: 15,}, 
    principle_emailid:{ required: true, email: true, },
  },
  messages: {
      //university_id: "Please Enter University Name",
      //clg_code: "Please Enter College Code",
      //clg_name_english: "Please Enter College Name In English", 
      //clg_email: "Please Enter College Email ID",
      clg_mobile_r_landline : "Please Select the field",
      clg_std : "Please Enter STD Code",
      clg_landline : "Please Enter Landline No.",
      clg_mobile: "Please Enter Mobile No.",
      clg_contact: "Please Enter College Conatct",
      clg_type:"Please Enter College Type",
      jurisdiction_dict:"Please Enter College Jurisdiction District",
      clg_address: "Please Enter College Address", 
      col_district:"Please Enter District",
      pincode:" Please Enter Pincode",
      tot_num_unit:"Please Enter No. of NSS unit",
      principle_name:"Please Enter Principle Name", 
      principle_contact:"Please Enter Principle Contact", 
      principle_emailid:"Please Enter Principle Emailid", 
    },   
  });
  $("#college-form").on("submit",function(e) {  
    var chek_vald = $("#college-form").valid(); 
    if(chek_vald == true){   
      var formData = new FormData(this);     
      $.ajax({ 
        type:"POST", 
        data:formData, 
        success:function(data){   
          var result = JSON.parse(data.replace(/^\s+|\s+$/gm,'')); 
          if(result=='insert'){  
            toastr.success('Data Successfully Inserted');  
            setTimeout(function() {window.location.reload();}, 1000);  
          }else if(result=='update'){  
            toastr.success('Data Updated Successfully');  
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
    e.preventDefault();   
  }); 
</script> 
</body>
</html>
