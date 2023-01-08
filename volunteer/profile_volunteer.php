<?php
include "../db_connect.php";
include "../commen_php.php";
$created_date=date("Y/m/d");
if($_SESSION['unique_ids']==''){    
  header('Location:'.$Base_url21.'login_page.php');  
}
$volunteer_ids=$_SESSION["unique_ids"]; 

if($volunteer_ids==''){    
    header('Location:'.$Base_url21.'login_page.php');  
  }

$ip=$_SERVER['REMOTE_ADDR'];

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

$volunteer_echo = $db->query("SELECT * FROM volunteer where vol_unique_id='$volunteer_ids'");
$vol_echo1=$volunteer_echo->fetch(PDO::FETCH_ASSOC); 

$volunteer_dob=explode(" ",$vol_echo1['vol_dob']);
$doj_nss = $vol_echo1['vol_doj_nss'];
$new_doj_nss = date("d-m-Y", strtotime($doj_nss));

if(isset($_POST['vol_name'])){ 
    if($_POST['vol_name'] && $_POST['vol_name_tamil'] && $_POST['vol_mobile']){
   $university_id= stripQuotes(killChars(trim($_POST['university_id'])));
  $college_id= stripQuotes(killChars(trim($_POST['college_id'])));
  $vol_unique_id= stripQuotes(killChars(trim($_POST['vol_unique_id'])));
  $vol_name= stripQuotes(killChars(trim($_POST['vol_name'])));
  $vol_name_tamil= stripQuotes(killChars(trim($_POST['vol_name_tamil'])));
  $vol_gender= stripQuotes(killChars(trim($_POST['vol_gender'])));
  $vol_dob= $_POST['vol_dob'];
  $vol_father_name= stripQuotes(killChars(trim($_POST['vol_father_name'])));
  $vol_mobile= stripQuotes(killChars(trim($_POST['vol_mobile'])));
  $vol_email= stripQuotes(killChars(trim($_POST['vol_email'])));
  $aadhaar_r_virtual= stripQuotes(killChars(trim($_POST['aadhaar_r_virtual'])));
  $vol_aadhaar= stripQuotes(killChars(trim($_POST['vol_aadhaar'])));
  $vol_virtual= stripQuotes(killChars(trim($_POST['vol_virtual'])));
  $vol_community= stripQuotes(killChars(trim($_POST['vol_community'])));
  $vol_address= stripQuotes(killChars(trim($_POST['vol_address'])));
  $vol_district= stripQuotes(killChars(trim($_POST['vol_district'])));
  $vol_pincode= stripQuotes(killChars(trim($_POST['vol_pincode'])));
  $vol_degree_id =stripQuotes(killChars(trim($_POST['vol_degree_course'])));
  $vol_adm_year= $_POST['vol_adm_year'];
  $vol_po_name=stripQuotes(killChars(trim($_POST['vol_po_name'])));
  $vol_doj_nss= $_POST['vol_doj_nss'];
  $vol_blood_group= stripQuotes(killChars(trim($_POST['vol_blood_group'])));
  $vol_blood_dona= stripQuotes(killChars(trim($_POST['vol_blood_dona'])));
  $vol_emerg_ser_willing= stripQuotes(killChars(trim($_POST['vol_emerg_ser_willing'])));
  $vol_talents= json_encode($_POST['vol_talents']);
  $vol_list_talents= stripQuotes(killChars(trim($_POST['vol_list_talents'])));
  $vol_photo= stripQuotes(killChars(trim($_POST['vol_photo'])));
 
  $vol_id_rowcount = ($db->query("SELECT * FROM volunteer where vol_unique_id='$volunteer_ids'")->rowCount());
 
   $ext="jpg";
   //$photo_storage="../Uploads/volunteer/$volunteer_count2.".$ext."";
   $photo_storage="../Uploads/volunteer/$volunteer_ids.".$ext."";
$vol_name1=ucfirst($vol_name);
$vol_father_name1=ucfirst($vol_father_name);

  try {
     if($vol_id_rowcount=='1'){
 //print_r($_POST);exit;
       $query1 = $db->query("UPDATE volunteer SET  vol_name='$vol_name1', vol_name_tamil='$vol_name_tamil', vol_gender='$vol_gender', vol_dob='$vol_dob',vol_father_name='$vol_father_name1',  vol_mobile='$vol_mobile',vol_aadhaar_or_virtual='$aadhaar_r_virtual',  vol_aadhaar='$vol_aadhaar',vol_virtual='$vol_virtual', vol_community='$vol_community', vol_address='$vol_address', vol_district='$vol_district', vol_pincode='$vol_pincode', vol_degree_id='$vol_degree_id', vol_adm_year='$vol_adm_year',vol_doj_nss='$vol_doj_nss', vol_blood_group='$vol_blood_group', vol_blood_dona='$vol_blood_dona', vol_emerg_ser_willing='$vol_emerg_ser_willing', vol_talents='$vol_talents', vol_list_talents='$vol_list_talents',vol_photo='$photo_storage', update_by='$volunteer_ids', update_time='now()',update_ip='$ip' WHERE vol_unique_id='$volunteer_ids';"); 
        $data_1='update';


   mkdir("../Uploads/volunteer",0777,true);
          $temp_storage="../Uploads/volunteer";
          if($_FILES['vol_photo']['tmp_name']){
            move_uploaded_file($_FILES['vol_photo']['tmp_name'],$temp_storage."/$volunteer_ids.".$ext."");
          }
}
 //$error = ($db->errorInfo())[2];
}catch (PDOException $e) {  
  $error=$e->getMessage();  
}
  if($error){
    $data_er[]=$error;
  }else{
    $data_er=$data_1;
  }
 // print_r($data_er);exit;
 die(json_encode($data_er));

  }
}



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
        echo date_format($date,"dd-mm-yyyy");
    }
    function adm_year_maxdate() {
        $date=date_create("today");
        date_sub($date,date_interval_create_from_date_string("0 years"));
        echo date_format($date,"dd-mm-yyyy");
    }
/* Date of Joining in NSS calander range(Max & Min)*/

    function doj_nss_mindate() {
        $date=date_create("today");
        date_sub($date,date_interval_create_from_date_string("3 years"));
        echo date_format($date,"Y-m-d");
    }

   function doj_nss_maxdate() {
      $date=date_create("today");
      date_sub($date,date_interval_create_from_date_string("0 years"));
      echo date_format($date,"Y-m-d");
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
      <div class="row">
<!-- Left Div-->
          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
            <div class="pd-20 card-box height-100-p">
             <div class="profile-photo">

              <?php
              if($vol_echo1['vol_photo']=='')
              { if($vol_gender=='1'){?>
                <img src="../vendors/images/user_male.png" alt="" class="avatar-photo">
             <?php  }elseif($vol_gender=='2')
             {  ?>
              <img src="../vendors/images/user_female.png" alt="" class="avatar-photo">
               <?php  }elseif($vol_gender=='3')
             { ?>
              <img src="../vendors/images/user_other.png" alt="" class="avatar-photo">
            <?php }
          }else{ ?>
              <img src="<?php echo $vol_echo1['vol_photo'];?>" alt="" class="avatar-photo">
             <?php }   ?>

               <h5 class="text-center h5 mb-0 "><?php if($langtypee=='1'){ echo $vol_echo1['vol_name_tamil'];}else{ echo $vol_echo1['vol_name'];}?></h5>
              </div>
               <br>
                <br>

<!-- Volunteer Info-->
         <div class="profile-info">
            <h5 class="mb-20 h5 text-center"><?php
                          foreach ($university_codes as $universitykey => $universityvalue) {
                              if($vol_echo1['uni_id']==$universitykey){  ?>
                                 <?php echo $universityvalue;?>
                          <?php   }

                              } ?></h5>
                <h5 class="mb-20 h5  text-center"><?php
                            foreach ($college_codes as $collegekey => $collegevalue) {
                                if($vol_echo1['clg_id']==$collegekey){  ?>
                                   <?php echo $collegevalue;?>
                            <?php   }

                                } ?></h5>
                <h5 class="mb-20 h5 text-blue text-center">Volunteer Information</h5>


                <ul>

                  <li>
                    <span>Volunteer ID:</span>
                    <?php echo $vol_echo1['vol_unique_id'];?>
                  </li>
                  <li>
                    <span>Email Address:</span>
                    <?php echo $vol_echo1['vol_email'];?>
                  </li>
                  <li>
                    <span>Phone Number:</span>
                    <?php echo $vol_echo1['vol_mobile'];?>
                  </li>
                 <!--  <li>
                    <span>Degree</span>
                    <?php echo $vol_echo1['degree_name'];?>
                  </li> -->
               <!--    <li>
                    <span>DOJ in NSS:</span>
                   <?php echo $new_doj_nss;?>
                  </li>  -->
                </ul>
              </div>
<!-- Process Bar-->
            <div class="pd-20 card-box">
              <h5 class="h5 mb-20">NSS Work Progress</h5>
              <div class="progress mb-20">
                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: 50%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">50%</div>
              </div>
              <div class="progress mb-20">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
              </div>
              <div class="progress">
                <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" role="progressbar" style="width: 75%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">75%</div>
              </div>
            </div>
            </div>
          </div>
<!-- Right Div-->
          <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
            <div class="card-box height-100-p overflow-hidden">
              <div class="profile-tab height-100-p">
                <div class="tab height-100-p">
                  <ul class="nav nav-tabs customtab" role="tablist">
                    <li class="nav-item active">
                      <a class="nav-link" data-toggle="tab" href="#timeline" role="tab">Dashboard</a>
                    </li>

                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#vol_update_profile" role="tab">Update Profile</a>
                    </li> 
                  </ul>
                  <div class="tab-content">
                    <!-- Timeline Tab start -->
                    <div class="tab-pane fade show active" id="timeline" role="tabpanel">
                      <div class="pd-20">
                        <div class="profile-timeline">
                          <div class="timeline-month">
                            <h5>August, 2020</h5>
                          </div>
                          <div class="profile-timeline-list">
                            <ul>
                              <li>
                                <div class="date">12 Aug</div>
                                <div class="task-name"><i class="ion-android-alarm-clock"></i> Task Added</div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                <div class="task-time">09:30 am</div>
                              </li>
                              <li>
                                <div class="date">10 Aug</div>
                                <div class="task-name"><i class="ion-ios-chatboxes"></i> Task Added</div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                <div class="task-time">09:30 am</div>
                              </li>
                              <li>
                                <div class="date">10 Aug</div>
                                <div class="task-name"><i class="ion-ios-clock"></i> Event Added</div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                <div class="task-time">09:30 am</div>
                              </li>
                              <li>
                                <div class="date">10 Aug</div>
                                <div class="task-name"><i class="ion-ios-clock"></i> Event Added</div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                <div class="task-time">09:30 am</div>
                              </li>
                            </ul>
                          </div>
                          <div class="timeline-month">
                            <h5>July, 2020</h5>
                          </div>
                          <div class="profile-timeline-list">
                            <ul>
                              <li>
                                <div class="date">12 July</div>
                                <div class="task-name"><i class="ion-android-alarm-clock"></i> Task Added</div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                <div class="task-time">09:30 am</div>
                              </li>
                              <li>
                                <div class="date">10 July</div>
                                <div class="task-name"><i class="ion-ios-chatboxes"></i> Task Added</div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                <div class="task-time">09:30 am</div>
                              </li>
                            </ul>
                          </div>
                          <div class="timeline-month">
                            <h5>June, 2020</h5>
                          </div>
                          <div class="profile-timeline-list">
                            <ul>
                              <li>
                                <div class="date">12 June</div>
                                <div class="task-name"><i class="ion-android-alarm-clock"></i> Task Added</div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                <div class="task-time">09:30 am</div>
                              </li>
                              <li>
                                <div class="date">10 June</div>
                                <div class="task-name"><i class="ion-ios-chatboxes"></i> Task Added</div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                <div class="task-time">09:30 am</div>
                              </li>
                              <li>
                                <div class="date">10 June</div>
                                <div class="task-name"><i class="ion-ios-clock"></i> Event Added</div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                <div class="task-time">09:30 am</div>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
            <!-- Timeline Tab End -->
   <?php include "update_volunteer.php"?>


                  </div>
                </div>
              </div>
            </div>
          </div>
<!--Row End -->
        </div>


  </div>
   <?php include "../footer.php"; ?>
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

      $("#volunteer_update_form_id").validate({
          rules: {
        university_id:{ required: true, },
       // college_id: {required: true, },
        vol_name: { required: true, },
        vol_name_tamil: {required: true, },
        vol_gender: {required: true, },
        vol_dob: {required: true, },
        vol_age: {required: true, },
        vol_father_name: {  required: true, },
        vol_email: {required: true, email: true },
        vol_mobile: {required: true,maxlength: 10,minlength:10  },
        vol_aadhaar: {required: true, maxlength: 12,minlength:12},
        vol_virtual: {required: true, maxlength: 16,minlength:16},
        vol_community:{required: true,},
        vol_address:{required: true, },
        vol_district: {required: true, },
        vol_pincode: {required: true, maxlength: 6, minlength:6 },
        //vol_degree_type: {required: true  },
        vol_degree_course: {required: true},
        vol_adm_year:{required: true,},
        //vol_unit_id:{required: true,},
        vol_po_name:{required: true,},
        vol_doj_nss:{required: true},
        vol_blood_group:{required: true,},
        vol_blood_don:{required: true,},
        vol_emerg_ser_willing:{ required: true, },
        //vol_talents:{required: true,},
        //vol_list_talents:{required: true,},
       // vol_photo:{required: true,},
      },
      messages: {
        vol_name:" Enter Name",
        vol_name_tamil:" Enter Name in Tamil",
        vol_gender:" select your gender",
        vol_dob:"Choose your DOB",
        vol_father_name:" Enter your Father Name",
        vol_email:" Enter Email ID",
        vol_mobile:" Enter Mobile Number",
        //vol_aadhaar:"Enter Aadhar No.",
//vol_virtual:"Enter Virtual ID",
        vol_community:"Select Your Community",
        vol_address:" Enter Address",
        vol_district:" select District",
        vol_pincode:" Enter Pincode",
        vol_degree_course:" Select Degree Course",
        vol_adm_year:" Enter Year of Admition",
        //vol_unit_id:"Please enter Unit Number",
        vol_po_name:" select Program Officer Name",
        vol_doj_nss:" Enter NSS Joined Date",
        vol_blood_group:" select Blood Group",
        vol_blood_dona:" select Blood Donation",
        vol_emerg_ser_willing:" select emergency service willing ",
        //vol_talents:" select Your Talents",
        //vol_list_talents:" Enter List of Talents ",
        //vol_photo:" select your photo",
          },

      });
$("#volunteer_update_form_id").on("submit",function(e) {
var chek_vald = $("#volunteer_update_form_id").valid();
         if(chek_vald == true){
    var formData = new FormData(this);
    $.ajax({
        type:"POST",
        data:formData,
        success:function(data){
          var result = JSON.parse(data.replace(/^\s+|\s+$/gm,''));
          //alert(result);
         if(result=="update"){
           toastr.success('Data Successfully Updated');
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

// $(document).ready(function(){
// $('#vol_doj_nss').datepicker({
//   dateFormat: "yy-mm-dd",
//   changeMonth: true,
//   changeYear: true,
//   minDate: '2022-01-10', 
//   maxDate: new Date('2022-12-02')

//  });
// });
 

  </script>
</body>
</html>
