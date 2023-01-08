<?php   
  include "../db_connect.php";
  include "../commen_php.php";
  $ip=$_SERVER['REMOTE_ADDR'];  
  if($_SESSION['unique_ids']==''){    
    header('Location:'.$Base_url21.'login_page.php');  
}
  $created_date=$_SESSION["created_date"]; 
  $unique_ids=$_SESSION["unique_ids"]; 
  $langtype=$_SESSION["langtype"];
    if($langtype==1){
      $districtname= "district_tname";
    }elseif($langtype==2){
      $districtname= "district_name";
    }else{
      $districtname= "district_tname";
    }    

  if(isset($_POST['ofc_contact_no'])){  //print_r($_POST);exit;
    $ofc_mailid= stripQuotes(killChars(trim($_POST['ofc_mailid']))); 
    $ofc_contact_no= stripQuotes(killChars(trim($_POST['ofc_contact_no']))); 
    $no_of_unit= stripQuotes(killChars(trim($_POST['no_of_unit']))); 
    $funded_unit= stripQuotes(killChars(trim($_POST['funded_unit']))); 
    $sf_unit= stripQuotes(killChars(trim($_POST['sf_unit']))); 
    $no_of_adtd_vlg= stripQuotes(killChars(trim($_POST['no_of_adtd_vlg'] ? $_POST['no_of_adtd_vlg'] : '0'))); 
    $no_of_pos= stripQuotes(killChars(trim($_POST['no_of_pos']))); 
    $no_of_volunteers= stripQuotes(killChars(trim($_POST['no_of_volunteers'])));  
    $uni_id_rowCount = ($db->query("SELECT * FROM university_nss_details where uni_id='$unique_ids'")->rowCount()); 
    try {
      if($uni_id_rowCount=='1'){     
        $query1 = $db->query("UPDATE university_nss_details
        SET uni_nss_mailid='$ofc_mailid', uni_nss_contact='$ofc_contact_no', funded_unit='$funded_unit', sf_unit='$sf_unit', no_of_adop_vlg='$no_of_adtd_vlg', no_of_pos='$no_of_pos', no_of_volunteers='$no_of_volunteers', update_time='now()', updated_by='$unique_ids',update_ip='$ip' WHERE uni_id='$unique_ids';"); 
        $dataas='update'; 
      }else{ 
        $query1 = $db->query("INSERT INTO university_nss_details(uni_id, uni_nss_mailid, uni_nss_contact, funded_unit, sf_unit, no_of_adop_vlg, no_of_pos, no_of_volunteers, created_by, created_time, created_ip)
        VALUES ('$unique_ids','$ofc_mailid','$ofc_contact_no','$funded_unit','$sf_unit','$no_of_adtd_vlg','$no_of_pos','$no_of_volunteers','$unique_ids','now()','$ip');");  
        $dataas='insert'; 
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


  $university_nss_details = $db->query("SELECT * from university_nss_details where uni_id='$unique_ids'"); 
  $university_nss_echo=$university_nss_details->fetch(PDO::FETCH_ASSOC); 

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
          <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page" href="">Update University NSS</li>
  </ol>
</nav>
            <div class="container pd-20 card-box mb-30">
              <div class="clearfix">
                <div class="pull-left">
                  <h4 class="text-blue h4"><?php echo $labels['lbl_university_nss_details'];?>
                    <span class="required_symbol">  <?php echo $labels['mandatory_field'];?>  </span>
                  </h4>
                </div> 
              </div>  
              <form id="uni_nss_form">  
                <div class="row">   
                 <!--  <div class="col-md-3 col-sm-12">
                  <div class="form-group">
                    <label>
                      <?php //echo $labels['ofc_nss_mailid'];?>
                      <span class="required_symbol"> *</span>
                    </label>
                    <input type="text" class="form-control emailcls mailcls disabled"  id="ofc_mailid" name="ofc_mailid" onchange="check_countdata(this.value,'login_details','email','ofc_mailid','mailpassword');mailvalid('ofc_mailid');" value="<?php //echo $university_nss_echo['uni_nss_mailid'];?>">
                    <span id="lblofc_mailid" class="required_error_msg"></span>
                  </div>
                  </div> --> 
                  <div class="col-md-4 col-sm-12">
                  <div class="form-group">
                    <label>
                      <?php echo $labels['ofc_nss_contnum'];?>
                      <span class="required_symbol"> *</span>
                    </label>
                    <input type="text" class="form-control " name="ofc_contact_no" maxlength="10" onkeypress="return isNumber(event);" id="ofc_contact_no" onchange="check_countdata(this.value,'university','ofc_contact_no','ofc_contact_no');" value="<?php echo $university_nss_echo['uni_nss_contact'];?>" onkeyup="firstnumvalid(this.value,'ofc_contact_no');" maxlength="10" onkeypress="return isNumber(event);"> 
                    <span id="lblofc_contact_no" class="required_error_msg"></span>
                  </div> 
                  </div>  
                  <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                      <label>
                        <?php echo $labels['no_of_pos'];?>
                        <span class="required_symbol">*</span>
                      </label>
                      <input type="text" class="form-control "  id="no_of_pos" name="no_of_pos" value="<?php echo $university_nss_echo['no_of_pos'];?>"  maxlength="3" onkeypress="return isNumber(event);">
                      <span id="lblno_of_pos" class="required_error_msg"></span>
                    </div>
                  </div> 
                  <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                      <label>
                        <?php echo $labels['no_of_volunteers'];?>
                        <span class="required_symbol">*</span>
                      </label>
                      <input type="text" class="form-control "  id="no_of_volunteers" name="no_of_volunteers" value="<?php echo $university_nss_echo['no_of_volunteers'];?>"  maxlength="3" onkeypress="return isNumber(event);">
                      <span id="lblno_of_volunteers" class="required_error_msg"></span>
                    </div>
                  </div>   
                </div>  
                <div class="row"> 
                  <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                      <label>
                        <?php echo $labels['funded_unit'];?>
                        <span class="required_symbol"> *</span>
                      </label>
                      <input type="text" class="form-control "  id="funded_unit" name="funded_unit" value="<?php echo $university_nss_echo['funded_unit'];?>" maxlength="3" onkeypress="return isNumber(event);">
                      <span id="lblfunded_unit" class="required_error_msg"></span>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                      <label>
                        <?php echo $labels['sf_unit'];?>
                        <span class="required_symbol">*</span>
                      </label>
                      <input type="text" class="form-control "  id="sf_unit" name="sf_unit" value="<?php echo $university_nss_echo['sf_unit'];?>"  maxlength="3" onkeypress="return isNumber(event);">
                      <span id="lblsf_unit" class="required_error_msg"></span>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                      <label><?php echo $labels['no_adopted_vil'];?><span class="required_symbol">*</span></label>
                      <input type="text" class="form-control"  id="no_of_adtd_vlg" name="no_of_adtd_vlg" value="<?php echo $university_nss_echo['no_of_adop_vlg'];?>"  onkeypress="return isNumber(event);" maxlength="3" onkeypress="return isNumber(event);">
                      <span id="lblno_of_adtd_vlg" class="required_error_msg"></span>
                    </div>
                  </div>    
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
          $("#uni_nss_form").validate({
          rules: {          
            ofc_mailid: 
            {
              required: true,
              email: true,
            },  
            ofc_contact_no: 
            {
              required: true,
              maxlength: 10,
              minlength:10,
            },  
            no_of_unit: 
            { 
              required: true,
              maxlength: 3
            },  
            funded_unit: 
            { 
              required: true,
              maxlength: 3
            },  
            sf_unit: 
            { 
              required: true,
              maxlength: 3
            }, 
           /* no_of_adtd_vlg: 
            { 
              required: true,
              maxlength: 3
            },*/ 
            no_of_pos: 
            { 
              required: true,
              maxlength: 3
            }, 
            no_of_volunteers: 
            { 
              required: true,
              maxlength: 3
            },     
          },
          messages: { 
            ofc_mailid: "Please enter valid Email ID", 
            ofc_contact_no: "Please enter valid mobile no.", 
            no_of_unit: "Please enter NO.Of Unit",    
            funded_unit: "Please enter Funded Unit",    
            sf_unit: "Please enter Self Finance Unit",    
            no_of_adtd_vlg: "Please enter No. Of Adopted Villages", 
            no_of_pos: "Please enter No Of program Officer",    
            no_of_volunteers: "Please enter No.Of Volunteer",    
          },
        });
        $("#uni_nss_form").on("submit",function(e) {  

          var chek_vald = $("#uni_nss_form").valid(); 
          if(chek_vald == true){  
             e.preventDefault();   
          var formData = new FormData(this);    console.log(formData);  
          $.ajax({ 
            type:"POST", 
            data:formData, 
            success:function(data){  
              var result = JSON.parse(data.replace(/^\s+|\s+$/gm,''));   
              if(result=="insert"){   
                toastr.success('Data Inserted Successfully');  
                setTimeout(function() {window.location.reload();}, 1000);  
              }else if(result=="update"){   
                toastr.success('Data Successfully Updated');  
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
      }); 
    </script>
  </body>
</html>