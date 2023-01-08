<?php   
  include "../db_connect.php";
  include "../commen_php.php";
  $ip=$_SERVER['REMOTE_ADDR']; 
  /*$created_date=date("Y/m/d"); */
  $created_date=$_SESSION["created_date"]; 
  $unique_ids=$_SESSION["unique_ids"]; //print_r($unique_ids);exit;
  //$langtype=$_SESSION["langtype"] ? $_SESSION['langtype'] : '1';
  if($_SESSION['unique_ids']==''){    
    header('Location:'.$Base_url21.'login_page.php');  
}
if($_SESSION['unique_ids']==''){    
    header('Location:'.$Base_url21.'login_page.php');  
}

  if(isset($_SESSION["langtype"])){
    $langtype=$_SESSION["langtype"] ? $_SESSION['langtype'] : '1';
  }else{
    $langtype=1;
  }
  if($langtype==1){
    $districtname= "district_tname";
    $institution_name= "institution_name_tamil";
  } elseif($langtype==2){
    $districtname= "district_name";
    $institution_name= "institution_name_english";
  }else{
    $districtname= "district_tname";
    $institution_name= "institution_name_tamil";
  }    
  if(isset($_POST['uni_name'])){  //print_r($_POST);exit;
    $uni_code= stripQuotes(killChars(trim($_POST['uni_code']))); 
    $uni_name= stripQuotes(killChars(trim($_POST['uni_name']))); 
    $uni_name_tamil= stripQuotes(killChars(trim($_POST['uni_name_tamil']))); 
    $uni_mobile_r_landline= stripQuotes(killChars($_POST['uni_mobile_r_landline']));
    $uni_mobile= stripQuotes(killChars(trim($_POST['uni_mobile'])));
    $uni_emailid= stripQuotes(killChars(trim($_POST['uni_emailid'])));
    $uni_std= stripQuotes(killChars(trim($_POST['uni_std'])));
    $uni_landline= stripQuotes(killChars(trim($_POST['uni_landline'])));
    $registrar_name= stripQuotes(killChars(trim($_POST['registrar_name'])));
    $registrar_emailid= stripQuotes(killChars(trim($_POST['registrar_emailid'])));
    $registrar_mobile= stripQuotes(killChars(trim($_POST['registrar_mobile'])));
    $Vice_Clor_name= stripQuotes(killChars(trim($_POST['Vice_Clor_name'])));
    $Vice_Clor_emailid= stripQuotes(killChars(trim($_POST['Vice_Clor_emailid']))); 
    $Vice_Clor_mobileno= stripQuotes(killChars(trim($_POST['Vice_Clor_mobileno'])));
    $pincode= stripQuotes(killChars(trim($_POST['pincode'])));
    $district= stripQuotes(killChars(trim($_POST['district'])));
    $uni_status= stripQuotes(killChars(trim($_POST['uni_status'])));
    $jurisdiction_dict=json_encode($_POST['jurisdiction_dict']);
    $no_of_colleges= stripQuotes(killChars(trim($_POST['no_of_colleges'])));
    $uni_address= stripQuotes(killChars(trim($_POST['uni_address'])));
    $uni_id_rowCount = ($db->query("SELECT * FROM university where uni_id='$unique_ids'")->rowCount()); 
    try {
      if($uni_id_rowCount=='1'){   
        $query1 = $db->query("UPDATE university SET uni_code='$uni_code', uni_name='$uni_name', uni_name_tamil='$uni_name_tamil', uni_jurs_district='$jurisdiction_dict', uni_email='$uni_emailid', uni_mobile='$uni_mobile', uni_landline='$uni_landline', uni_std='$uni_std', uni_district='$district',uni_pincode='$pincode', registrar_name='$registrar_name', registrar_mail='$registrar_emailid', registrar_mobile='$registrar_mobile', vice_chancellor_name='$Vice_Clor_name', vice_chancellor_mail='$Vice_Clor_emailid', vice_chancellor_mobile='$Vice_Clor_mobileno', uni_type='$uni_status', no_of_clg='$no_of_colleges', uni_address='$uni_address',update_by='$unique_ids', update_time='now()',update_ip='$ip',uni_mobile_r_landline='$uni_mobile_r_landline' WHERE uni_id='$unique_ids';");  
        $data='update'; 
      }   
    }catch (PDOException $e) {  
      $error=$e->getMessage(); 
    } 
    if($error){
      $data_er[]=$error; 
    }else{
      $data_er=$data; 
    }   
    die(json_encode($data_er)); 
  } 
  $district=$db->query("SELECT district_code, $districtname as district_name  FROM district  order by district_name");  
  $district1=$district->fetchAll(PDO::FETCH_ASSOC); 
  foreach ($district1 as $districtkey => $districtvalue) { 
    $district_codes[$districtvalue['district_code']]=$districtvalue['district_name'];  
    $district_codes1[$districtvalue['district_code']]=$districtvalue['district_name'];  
  }    
  $contact=$db->query("SELECT contact_id, contact_name FROM m_contact");
  $contact1=$contact->fetchAll(PDO::FETCH_ASSOC);
  foreach ($contact1 as $contactkey => $contactvalue) {
    $contact_codes[$contactvalue['contact_id']]=$contactvalue['contact_name'];
  }
  $type_of_institution=$db->query("SELECT institution_id,$institution_name as institution_name  from type_of_institution");  
  $institution1=$type_of_institution->fetchAll(PDO::FETCH_ASSOC);  
  $type_of_institution = $db->query("SELECT * from type_of_institution"); 
  $institution=$type_of_institution->fetchAll(PDO::FETCH_ASSOC); 
  $university = $db->query("SELECT * from university where uni_id='$unique_ids'"); 
  $university_echo=$university->fetch(PDO::FETCH_ASSOC); 
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
    <?php //include "aside_menu.php"; ?>  
    <?php include "../left_menu.php"; ?>  
    <div class="mobile-menu-overlay"></div> 
      <div class="main-container">
        <div class="pd-ltr-20"> 
        <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page" href="">Update University</li>
  </ol>
</nav>
          <div class="container pd-20 card-box mb-30">
            <div class="clearfix">
              <div class="pull-left">
                <h4 class="text-blue h4">Update University Details
                  <span class="required_symbol">  <?php echo $labels['mandatory_field'];?>  </span>
                </h4>
              </div> 
            </div>  
            <form id="university_form_id">
              <div class="row"> <br> 
              </div>
              <div class="boxshadow2">
                <div class="row"> 
                <div class="col-md-2 col-sm-12">
                    <div class="form-group">
                      <label><?php echo $labels['uni_code'];?><span class="required_symbol"> *</span></label>
                      <input type="text" class="form-control"  name="uni_code" id="uni_code" value="<?php echo $university_echo['uni_code'];?>" readonly>
                    </div>
                  </div>  
                  <div class="col-md-3 col-sm-12"> 
                    <div class="form-group">
                      <label>
                        <?php echo $labels['uni_name_english'];?>
                        <span class="required_symbol"> *</span>
                      </label>
                      <input type="text" class="form-control" name="uni_name" id="uni_name" value="<?php echo $university_echo['uni_name'];?>" onkeypress="return allowOnlyLetters(event,'uni_name');" readonly>
                      <span id="lbluni_name" class="required_error_msg"></span>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                      <label><?php echo $labels['uni_name_tamil'];?><span class="required_symbol"> *</span></label>
                      <input type="text" class="form-control" name="uni_name_tamil" id="uni_name_tamil" value="<?php echo $university_echo['uni_name_tamil'];?>" readonly>
                    </div>
                  </div> 
                   <div class="col-md-3 col-sm-12"> 
                    <div class="form-group">
                      <label><?php echo $labels['uni_emailid'];?><span class="required_symbol"> *</span></label>
                      <input type="text" class="form-control emailcls mailcls"  id="uni_emailid" name="uni_emailid" onchange="check_countdata(this.value,'login_details','email','uni_emailid','mailpassword');mailvalid('uni_emailid');" value="<?php echo $university_echo['uni_email'];?>" readonly>
                      <span id="lbluni_emailid" class="required_error_msg"></span>
                    </div>
                  </div>       
                </div>  
                <div class="row">
                   

  <div class="col-md-2 col-sm-12">
<div class="form-group">
  <label><?php echo $labels['uni_status'];?> <span class="required_symbol">*</span></label><br>
  <select name="uni_status" id="uni_status" class="form-control"> 
    <option value=""><?php echo $labels['choose'];?></option>  
    <?php   
      foreach ($institution1 as $institution1key => $institution1value) { 
      if($university_echo['uni_type']==$institution1value['institution_id']){  ?>  
      <option value="<?php echo $institution1value['institution_id'];?>" selected><?php echo $institution1value['institution_name'];?></option>
      <?php }else{ ?>  
      <option value="<?php echo $institution1value['institution_id'];?>"><?php echo $institution1value['institution_name'];?></option>
      <?php }} 
    ?> 
  </select> 
</div>
</div> 
 


                  <div class="col-md-3 col-sm-12">
                    <div class="form-group ">
                      <label><?php echo $labels['mobile_r_landline'];?><span class="required_symbol">*</span> </label>
                      <select class="form-control" name="uni_mobile_r_landline" id="uni_mobile_r_landline"  onchange="select_proof(this.value);"> 
                        <option hidden="true"  value=""><?php echo $labels['choose'];?></option> 
                        <?php
                          foreach ($contact_codes as $contactkey => $contactvalue) { 
                          if($university_echo['uni_mobile_r_landline']==$contactkey){  ?>
                          <option value="<?php echo $contactkey;?>" selected><?php echo $contactvalue;?></option>
                          <?php   }else{ ?> 
                          <option value="<?php echo $contactkey;?>"><?php echo $contactvalue;?></option>
                          <?php  } } 
                        ?>
                      </select>
                      <span id="lblmobile_r_landline" class="required_error_msg"></span>
                    </div>
                  </div>   
                  <div class="col-md-2 col-sm-12 landline">
                    <div class="form-group ">
                      <label><?php echo $labels['stdcode'];?><span class="required_symbol"> *</span></label>
                      <input type="text" class="form-control" name="uni_std" id="uni_std" onkeypress="return isNumber(event);" maxlength="5" value="<?php echo $university_echo['uni_std'];?>" onkeyup="stdvalid(this.value,'uni_std');">
                      <span id="lbluni_std" class="required_error_msg"></span>
                    </div>
                  </div>
                  <div class="col-md-2 col-sm-12 landline">
                    <div class="form-group ">
                      <label><?php echo $labels['landline'];?><span class="required_symbol"> *</span></label> 
                      <input type="text" class="form-control"  name="uni_landline" onkeypress="return isNumber(event);" maxlength="8" id="uni_landline" value="<?php echo $university_echo['uni_landline'];?>" onchange="select_proof(this.value);">
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-12 mobileno">
                    <div class="form-group ">
                      <label><?php echo $labels['uni_mobileno'];?><span class="required_symbol"> *</span></label>
                      <input type="text" class="form-control" name="uni_mobile" maxlength="10" onkeypress="return isNumber(event);" id="uni_mobile" onchange="check_countdata(this.value,'university','uni_mobile','uni_mobile');" value="<?php echo $university_echo['uni_mobile'];?>" onkeyup="firstnumvalid(this.value,'uni_mobile');"  onchange="select_proof(this.value);"> 
                      <span id="lbluni_mobile" class="required_error_msg"></span>
                    </div>
                  </div> 
                  <div class="col-md-3 col-sm-12"> 
                    <div class="form-group">
                      <label><?php echo $labels['no_of_colleges'];?><span class="required_symbol"> *</span></label>
                      <input type="text" class="form-control" name="no_of_colleges" id="no_of_colleges" value="<?php echo $university_echo['no_of_clg'];?>" onkeypress="return isNumber(event);">
                      <span id="lblno_of_colleges" class="required_error_msg"></span>
                    </div>
                  </div>   
                </div>
                <div class="row">
                  <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                      <label><?php echo $labels['university_address'];?><span class="required_symbol"> *</span></label> 
                      <input type="text" class="form-control" name="uni_address" id="uni_address" value="<?php echo $university_echo['uni_address'];?>" onkeypress="return address_spec_char(event);">
                        <span id="lbl_address" class="required_error_msg"></span>
                    </div>
                  </div>
                  <div class="col-md-2 col-sm-12">
                    <div class="form-group">
                      <label><?php echo $labels['pincode'];?><span class="required_symbol"> *</span></label> 
                      <input type="text" class="form-control"  name="pincode" onkeypress="return isNumber(event);" onkeyup="pincodevalid(this.value,'pincode');" maxlength="6" id="pincode" value="<?php echo $university_echo['uni_pincode'];?>">
                      <span id="lblpincode" class="required_error_msg"></span>
                    </div>
                  </div>
                  <div class="col-md-3 col-sm-12">
                    <div class="form-group"> 
                      <label ><?php echo $labels['district'];?><span class="required_symbol"> *</span></label> 
                      <select class="form-control" name="district" id="district"> 
                        <option hidden="true"  value=""><?php echo $labels['choose'];?></option> 
                        <?php  
                          $district_echo=json_decode($university_echo['uni_district'],true); 
                          foreach ($district_codes as $districtkey => $districtvalue){
                          if($university_echo['uni_district']==$districtkey){  ?> 
                          <option value="<?php echo $districtkey;?>" selected><?php echo $districtvalue;?></option>
                          <?php   }else{  ?> 
                          <option value="<?php echo $districtkey;?>"><?php echo $districtvalue;?></option>
                          <?php    } }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3 col-sm-12">
                    <div class="form-group">
                      <label ><?php echo $labels['jurisdiction_dict'];?><span class="required_symbol"> *</span></label> 
                      <select class="selectpicker form-control" name="jurisdiction_dict[]" id="jurisdiction_dict" data-size="5" data-style="btn-outline-success" data-selected-text-format="count" multiple>
                        <option hidden="true"  value=""><?php echo $labels['choose'];?></option> 
                        <?php  
                          $district_echo=json_decode($university_echo['uni_jurs_district'],true); 
                          foreach ($district_codes1 as $districtkey => $districtvalue){  
          	              if(in_array($districtkey, $district_echo)){ ?> 
          		            <option value="<?php echo $districtkey;?>" class="multiselect_selected" selected><?php echo $districtvalue;?></option>
                          <?php }else{  ?> 
                          <option value="<?php echo $districtkey;?>"><?php echo $districtvalue;?></option>
                          <?php  } } 
                        ?>
                      </select>
                    </div>  
                  </div>
                </div> 
                <div class="row">   
                </div>   
              </div>
                
              <div class="row">
                <br> 
              </div>
              <div class="boxshadow2">
                <div class="row">
                  <div class="col-md-4 col-sm-12"> 
                    <div class="form-group">
                      <label><?php echo $labels['registrar_name'];?><span class="required_symbol"> *</span></label>
                      <input type="text" class="form-control" name="registrar_name" id="registrar_name" value="<?php echo $university_echo['registrar_name'];?>" onkeypress="return allowOnlyLetters(event,'registrar_name');">
                      <span id="lblregistrar_name" class="required_error_msg"></span>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                      <label><?php echo $labels['registrar_emailid'];?><span class="required_symbol"> *</span></label>
                      <input type="text" class="form-control emailcls mailcls"  id="registrar_emailid" name="registrar_emailid" onchange="check_countdata(this.value,'login_details','email','registrar_emailid','mailpassword');mailvalid('registrar_emailid');" value="<?php echo $university_echo['registrar_mail'];?>">
                      <span id="lblregistrar_emailid" class="required_error_msg"></span>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                      <label><?php echo $labels['registrar_mobileno'];?><span class="required_symbol"> *</span></label>
                      <input type="text" class="form-control" name="registrar_mobile" maxlength="10" onkeypress="return isNumber(event);" id="registrar_mobile" onchange="check_countdata(this.value,'university','registrar_mobile','registrar_mobile');" value="<?php echo $university_echo['registrar_mobile'];?>" onkeyup="firstnumvalid(this.value,'registrar_mobile');" maxlength="10"> 
                      <span id="lbluni_mobile" class="required_error_msg"></span>
                    </div>
                  </div>
                </div> 
                <div class="row">
                  <div class="col-md-4 col-sm-12"> 
                    <div class="form-group">
                      <label><?php echo $labels['Vice_Clor_name'];?><span class="required_symbol"> *</span></label>
                      <input type="text" class="form-control" name="Vice_Clor_name" id="Vice_Clor_name" value="<?php echo $university_echo['vice_chancellor_name'];?>" onkeypress="return allowOnlyLetters(event,'Vice_Clor_name');">
                      <span id="lblVice_Clor_name" class="required_error_msg"></span>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-12"> 
                    <div class="form-group">
                      <label><?php echo $labels['Vice_Clor_emailid'];?><span class="required_symbol"> *</span></label>
                      <input type="text" class="form-control emailcls mailcls"  id="Vice_Clor_emailid" name="Vice_Clor_emailid" onchange="check_countdata(this.value,'login_details','email','Vice_Clor_emailid','mailpassword');mailvalid('Vice_Clor_emailid');" value="<?php echo $university_echo['vice_chancellor_mail'];?>">
                      <span id="lblVice_Clor_emailid" class="required_error_msg"></span>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                      <label><?php echo $labels['Vice_Clor_mobileno'];?><span class="required_symbol"> *</span></label> 
                      <input type="text" class="form-control" name="Vice_Clor_mobileno" maxlength="10" onkeypress="return isNumber(event);" id="Vice_Clor_mobileno" onchange="check_countdata(this.value,'university','Vice_Clor_mobileno','Vice_Clor_mobileno');" value="<?php echo $university_echo['vice_chancellor_mobile'];?>" onkeyup="firstnumvalid(this.value,'Vice_Clor_mobileno');" maxlength="10">  
                      <span id="lblVice_Clor_mobileno" class="required_error_msg"></span>
                    </div>
                  </div>
                </div>
              </div> 
              <div class="row"> 
                <br>
              </div>
              <div class="row"> 
                <div class="col-sm-12">    
                  <button type="submit" class="btn btn-primary form_submitbtn_style">Update</button>  
                </div> 
              </div>   
            </form> 
          </div>
        </div>
      </div>
      <?php include "../footer.php"; ?>
      <?php include "../common_js.php";?>   
      <script type="text/javascript">  
        $("#uni_name").focusout(function(){    
          translate('uni_name','uni_name_tamil'); 
        }); 
        $("#uni_head_name").focusout(function(){    
          translate('uni_head_name','uni_head_nametamil'); 
        });  
        //mobileno landline hide and show   
        $('.mobileno').hide();
        $('.landline ').show();  
        select_proof(<?php echo json_encode($university_echo['uni_mobile_r_landline'])?>); 
        function select_proof(input){  
          if(input==1){
            $('.mobileno').hide();  
            $('.landline').show(); 
          }else if(input==2){
            $('.mobileno').show();  
            $('.landline').hide();
          }    
        }  
        $("#uni_name,#uni_name_tamil,#uni_code,#uni_emailid").prop('readonly', true);
        $("#university_form_id").validate({
          rules: {
             uni_code: 
            {
              // required: true,
              // maxlength: 4,
              // minlength:4 
            },
            uni_name: 
            {
              required: true, 
              maxlength: 100,
              minlength:10 
            }, 
            pincode: 
            {
              required: true, 
              maxlength: 6,
              minlength:6 
            }, 
            uni_name_tamil: 
            {
              // required: true, 
              maxlength: 300,
              minlength:10 
            },       
            uni_email: 
            {
              required: true,
              email: true,
            },     
            uni_mobile_r_landline: 
            {
              required: true, 
            },  
            district: 
            {
              required: true, 
            }, 
            uni_status: 
            {
              required: true, 
            }, 
            uni_mobile: 
            { 
              maxlength: 10,
              minlength:10
            }, 
            jurisdiction_dict: 
            {
              required: true, 
            }, 
            uni_std: 
            {
              maxlength: 5,
            },  
            uni_landline: 
            {
              maxlength: 8,
            },  
            uni_address: 
            {
              required: true,
            }, 
            registrar_name: 
            {
              required: true,
            },  
            registrar_emailid: 
            {
              required: true,
              email: true,
            },  
            registrar_mobile: 
            {
              required: true,
              maxlength: 10,
              minlength:10,
            },  
            Vice_Clor_name: 
            {
              required: true,
            },  
            Vice_Clor_emailid: 
            {
              required: true,
              email: true,
            },  
            Vice_Clor_mobileno: 
            {
              required: true,
              maxlength: 10,
              minlength:10,
            },  
            no_of_colleges: 
            { 
              required: true,
              maxlength: 4,
              minlength:1 
            },     
          },
          messages: {
            // uni_code: "Enter valid University Code",
            
            jurisdiction_dict: "Please Select University Jurisdiction",
            uni_name: "Please Enter University Name in English",
            uni_address: "Please Enter Address",
            district: "Please Select District",
            uni_name_tamil: "Please enter University Name in Tamil", 
            uni_email: "Please enter valid Email ID", 
            uni_std: "STD Code maximum 4 Digit", 
            uni_landline: "STD Code maximum 8 Digit", 
            registrar_name: "Please enter Registrar's Name",
            registrar_emailid: "Please enter Registrar's Email ID",
            registrar_mobile: "Please enter Registrar's Mobile No.",
            Vice_Clor_name: "Please enter Vice Chancellor's Name",
            Vice_Clor_emailid: "Please enter Vice Chancellor's Email ID",
            Vice_Clor_mobileno: "Please enter Vice Chancellor's Mobile No.",
            jurisdiction_dict: "Please Select District",   
            no_of_colleges: "Please Enter Number Of College",   
            pincode: "Please Enter Pincode",   
            uni_mobile_r_landline: "Please Select Anyone",   
            uni_status: "Please Select status",   
          },
        });
        $("#university_form_id").on("submit",function(e) {  
          var uni_mobile1= $("#uni_mobile").val();   
          var uni_landline1=$("#landline_number").val();    
          if(uni_mobile1 !='' ||  uni_landline1 !=''){ 
            var chek_vald = $("#university_form_id").valid(); 
            if(chek_vald == true){  
              var formData = new FormData(this);     
              $.ajax({ 
                type:"POST", 
                data:formData, 
                success:function(data){  
                  var result = JSON.parse(data.replace(/^\s+|\s+$/gm,''));  
                  //console.log(result);
                  if(result=="update"){   
                    toastr.success('Data Successfully Updated');   
                    setTimeout(function() {window.location.href="dashboard.php";}, 1500); 
                  }else if(result[0] !=''){    
                    Swal.fire(''+result+''); 
                  } 
                }, 
                cache: false,
                contentType: false,
                processData: false 
              });    
            }
          }
          else{  
            toastr.warning('Enter Mobile No or landline'); 
          }
          e.preventDefault();
        });  

      
      </script>
  </body>
</html>