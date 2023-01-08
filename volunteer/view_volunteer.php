<?php  
 include "../db_connect.php";
include "../commen_php.php";
$created_date=$_SESSION["created_date"]; 
$labels=$_SESSION["lbl_data"];
//$ip=$_SERVER['REMOTE_ADDR'];

$unique_ids=$_SESSION["unique_ids"]; 
//print_r($unique_ids);exit;
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
//For edit and update Button

if(isset($_POST['ids'])){ 
  $idss= stripQuotes(killChars(trim($_POST['ids'])));  
 $volunteer_echo = $db->query("SELECT * FROM volunteer where vol_unique_id='$idss'");  
 $vol_echo1=$volunteer_echo->fetch(PDO::FETCH_ASSOC); 
} 
 $vol_talents2=explode(",",$vol_echo1['vol_talents']);

$volunteer_dob=explode(" ",$vol_echo1['vol_dob']); 


//date as changed from yyyy/mm/dd to dd/mm/yyyy

$dob=$volunteer_dob[0];
$new_dob = date("d-m-Y", strtotime($dob));  

//print_($volunteer_dob[0]);exit;
$doj_nss = $vol_echo1['vol_doj_nss'];  
$new_doj_nss = date("d-m-Y", strtotime($doj_nss));  

$adm_year =$vol_echo1['vol_adm_year'];
$new_adm_year = date("d-m-Y", strtotime($doj_nss));


//get only year from date & add 2 year

$batch_start_year= date('Y', strtotime($doj_nss));
$batch_end_year=$batch_start_year+2;
$batch=$batch_start_year."-".$batch_end_year;




// /*University Dropdown fetch data from db */

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

// /*Gender Dropdown fetch data from db */

$gender=$db->query("SELECT gender_id,gender_name  FROM gender");  
$gender1=$gender ->fetchAll(PDO::FETCH_ASSOC); 
foreach ($gender1 as $genderkey => $gendervalue) { 
    $gender_codes[$gendervalue['gender_id']]=$gendervalue['gender_name'];  
}   

// /* District  Dropdown fetch data from db */ 

$district=$db->query("SELECT district_code, $districtname as district_name  FROM district ORDER BY district_name ASC");  
$district1=$district->fetchAll(PDO::FETCH_ASSOC); 
 foreach ($district1 as $districtkey => $districtvalue) { 
   $district_codes[$districtvalue['district_code']]=$districtvalue['district_name'];  
 
 }     
// /*Blood group Dropdown fetch data from db  */

$bloodgroup=$db->query("SELECT bloodgroup_id, blood_name  FROM blood_group");  
$bloodgroup1=$bloodgroup->fetchAll(PDO::FETCH_ASSOC);
foreach ($bloodgroup1 as $bloodgroupkey => $bloodgroupvalue) { 
    $bloodgroup_codes[$bloodgroupvalue['bloodgroup_id']]=$bloodgroupvalue['blood_name'];  
} 
// /* community  Dropdown fetch data from db */

$community=$db->query("SELECT community_id, community_name  FROM m_community");  
$community1=$community->fetchAll(PDO::FETCH_ASSOC);
foreach ($community1 as $communitykey => $communityvalue) { 
    $community_codes[$communityvalue['community_id']]=$communityvalue['community_name'];  
} 

// /*Talents  Dropdown fetch data from db */

$talents=$db->query("SELECT talents_id, talents,talents_tamil  FROM m_talents");  
$talents1=$talents->fetchAll(PDO::FETCH_ASSOC);
$talents_echo1=json_decode($talents1['talents'],true); 
     $talents_echoid=implode(" ,",$talents_echo1);

foreach ($talents1 as $talentskey => $talentsvalue) { 
    $talents_codes[$talentsvalue['talents_id']]=$talentsvalue['talents'];  
} 
// /*Degree Course  Dropdown fetch data from db */

    $degree_course=$db->query("SELECT degree_id,degree_name,degree_type  FROM m_degree");  
    $degree_course1=$degree_course->fetchAll(PDO::FETCH_ASSOC); 
 foreach ($degree_course1 as $degree_coursekey => $degree_coursevalue) { 
    // $degree_name[$degree_coursevalue['degree_id']]=$degree_coursevalue['degree_name'];  
    // $degree_type22[$degree_coursevalue['degree_type']][$degree_coursevalue['degree_id']]=$degree_coursevalue['degree_name'];  
     $degree_codes[$degree_coursevalue['degree_id']]=$degree_coursevalue['degree_name'];  
 } 


// /*Program Officer Name Dropdown fetch data from db */

/*$po=$db->query("SELECT po_id, po_name FROM program_officer");  
$po1=$po->fetchAll(PDO::FETCH_ASSOC);
foreach ($po1 as $pokey => $povalue) { 
    $po_codes[$povalue['po_id']]=$povalue['po_name'];  
}  */
 //print_r($vol_echo1['vol_aadhaar_or_virtual']);exit;

// if($vol_echo1['vol_aadhaar_or_virtual']=='1'){
//                        echo $vol_echo1['vol_aadhaar'];
//                     }else{
//                         echo $vol_echo1['vol_virtual'];
//                     }exit;
?>

<!DOCTYPE html>
<html>
 <?php include "../head.php"; ?> 
 <style>
    hr {
  margin-top: 1rem;
  margin-bottom: 1rem;
  border: 3;
  border-top: 1px solid rgba(0, 0, 0, 0.1);
  color: black;
}

.vl {
  border-left: 2px solid black;
  height: 500px;
  position: absolute;
  left: 50%;
  margin-left: -3px;
  top: 0;
}
.aline_left
{
  margin-left: 40px;
}.aline_right
{
  margin-left: -5px;
}
 </style> 

<body> 
     <?php 
    include "../header.php"; 
        include "../left_menu.php";  
    ?>
    <div class="mobile-menu-overlay"></div> 
     <div class="main-container">
        <div class="invoice-wrap">
          <div class="invoice-box border ">
            <div class="invoice-header border border-dark">
              <form action="pdf_view.php" method="POST">  
<!-- grid open-->
              <div class="row">
                <div class="col-md-3 col-auto">   
                    <div class="profile-photo"> 
                       <img src="<?php echo Base_url;?>vendors/images/tn_logo.png" alt="" class="light-logo" style="width: 73%;margin-left: 17%;margin-top: 25px;">  
                    </div>
                </div>
<!-- Header NSS/College Name/ University name -->
                <div class="col-md-6">
                    <div class="form-group text-center"><br>
                        <h3 style="color:#1c1085"><?php echo $labels['NSS'];?></h3><br>
                        <h4 class="text-Black h4"><?php echo $university_codes[$vol_echo1['uni_id']];?>
                            
                        </h4>
                        <h4 class="text-Black h4"><?php echo $college_codes[$vol_echo1['clg_id']];?>
                            
                        </h4>
                     </div> 
                </div>
                <div class="col-md-3 "> 
                    <div class="profile-photo "> 
                        <img src="<?php echo Base_url;?>vendors/images/nss-logo1.png" alt="" class="light-logo" style="width: 73%;margin-left: 17%;margin-top: 25px;">  
                    </div> 
                </div>
            </div>

<!-- Horizontal  Line-->
     <hr style="height:2px; width:100%; border-width:0; color:black; background-color:black">
            
<!-- NSS Form / Personal Information /Vol Photo-->
            <div class="row">
                <div class="col-md-3 col-sm-12"> 
                     <!-- <div class="form-group text-center">
                    <br><br><br>
                    <br><br>
                    <h5 class="text-Black"><?php echo $labels['personal_info'];?></h5><br>
                </div> -->
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group text-center">
                        <h5 style="color:#1c1085"><?php echo $labels['vol_form'];?></h5><br>
                         <h5 class="text-Black ">Batch (<?php echo $batch?>)</h5>
                         <hr style="height:2px; width:100%; border-width:0; color:black; background-color:black">
                          <h5 class="text-Black" style="text-decoration: underline;"><?php echo $labels['personal_info'];?></h5>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12">
                <div class="form-group ">
                   <img src="<?php echo $vol_echo1['vol_photo'];?>" alt="" class="img-thumbnil" style="width: 50%;margin-left: 27%;"> 

                </div>
            </div>
        </div>
    
 <div class="row">
<!--  volunteer name(English) -->
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_left label-bold">
                                <label class="font-weight-bold"><?php echo $labels['vol_name'];?></label>
                            </div>
                        </div>

                         <div class="col-md-3 col-sm-12">
                            <div class="form-group ">
                               <span ><?php echo $vol_echo1['vol_name'];?></span>

                            </div>
                        </div>
<!--  volunteer name(Tamil)-->
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_right">
                                <label class="font-weight-bold"><?php echo $labels['vol_name'];?></label>
                            </div>
                        </div>
                         <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_right">
                               <span ><?php echo $vol_echo1['vol_name_tamil'];?></span>

                            </div>
                        </div>               
                    </div>
                    <div class="row">
<!--  Gender -->   
                     <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_left">
                                <label class="font-weight-bold"><?php echo $labels['gender'];?></label>
                            </div>
                        </div>
                         <div class="col-md-3 col-sm-12">
                            <div class="form-group ">
                               <span ><?php echo $gender_codes[$vol_echo1['vol_gender']];?></span>

                            </div>
                        </div>
<!--  Date Of Birth -->
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_right">
                                <label class="font-weight-bold"><?php echo $labels['dob'];?></label>
                            </div>
                        </div>
                         <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_right">
                                 <!--date as changed from yyyy/mm/dd to dd/mm/yyyy-->
                              <span ><?php echo $new_dob;?></span>

                            </div>
                        </div>               
                    </div>
                    <div class="row">
<!--  Father name -->
                     <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_left">
                                <label class="font-weight-bold"><?php echo $labels['father_name'];?></label>
                            </div>
                        </div>
                         <div class="col-md-3 col-sm-12">
                            <div class="form-group ">
                               <span ><?php echo $vol_echo1['vol_father_name'];?></span>

                            </div>
                        </div>
<!--  Email Id -->
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_right">
                                <label class="font-weight-bold"><?php echo $labels['email_id'];?></label>
                            </div>
                        </div>
                         <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_right">
                               <span ><?php echo $vol_echo1['vol_email'];?></span>

                            </div>
                        </div>               
                    </div>
                    <div class="row">
<!--  Mobile Number -->
                     <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_left">
                                <label class="font-weight-bold"><?php echo $labels['mobileno'];?></label>
                            </div>
                        </div>
                         <div class="col-md-3 col-sm-12">
                            <div class="form-group ">
                               <span ><?php echo $vol_echo1['vol_mobile'];?></span>

                            </div>
                        </div>
 
<!-- Aadhaar Number-->
                         <div class="col-md-3 col-sm-12 aadhaarno">
                            <div class="form-group aline_right ">
                                <label class="font-weight-bold"><?php echo $labels['aadhaarno'];?></label>
                            </div>
                        </div>
                         <div class="col-md-3 col-sm-12 aadhaarno">
                            <div class="form-group aline_right">
                               <span ><?php echo $vol_echo1['vol_aadhaar'];?></span>

                            </div>
                        </div>  
                        
<!-- Virtual ID-->    <div class="col-md-3 col-sm-12 virtualid">
                            <div class="form-group aline_right">
                                <label class="font-weight-bold"><?php echo $labels['virtualid'];?></label>
                            </div>
                        </div>
                         <div class="col-md-3 col-sm-12 virtualid">
                            <div class="form-group aline_right">
                               <span ><?php echo $vol_echo1['vol_virtual'];?></span>

                            </div>
                        </div>                      
                     

                    </div>
                     <div class="row">
<!-- Community -->
                     <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_left">
                                <label class="font-weight-bold"><?php echo $labels['community'];?></label>
                            </div>
                        </div>
                         <div class="col-md-3 col-sm-12">
                            <div class="form-group ">
                               <span><?php echo $community_codes[$vol_echo1['vol_community']];?>
                                </span>

                            </div>
                        </div>
<!-- Address -->
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_right">
                                <label class="font-weight-bold"><?php echo $labels['address'];?></label>
                            </div>
                        </div>
                         <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_right">
                               <span ><?php echo $vol_echo1['vol_address'];?></span>

                            </div>
                        </div>               
                    </div>
                    <div class="row">
<!--  District -->
                     <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_left">
                                <label class="font-weight-bold"><?php echo $labels['district'];?></label>
                            </div>
                        </div>
                         <div class="col-md-3 col-sm-12">
                            <div class="form-group ">
                               <span><?php echo $district_codes[$vol_echo1['vol_district']];?>
                                </span>

                            </div>
                        </div>
<!--  Pincode-->
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_right">
                                <label class="font-weight-bold"><?php echo $labels['pincode'];?></label>
                            </div>
                        </div>
                         <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_right">
                               <span ><?php echo $vol_echo1['vol_pincode'];?></span>

                            </div>
                        </div>               
                    </div>


<!-- Horizontal  Line-->
     <hr style="height:2px; width:100%; border-width:0; color:black; background-color:black">

   <div class="row">  
    <div class="col-md-12 col-sm-12">
             <div class="form-group ">
 <h5 class="text-Black text-center" style="text-decoration: underline;"><?php echo $labels['nss_details'];?></h5><br>
                     <div class="row">
<!-- degree course -->
                     <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_left">
                                <label class="font-weight-bold"><?php echo $labels['degree_course'];?></label>
                            </div>
                        </div>
                         <div class="col-md-3 col-sm-12">
                            <div class="form-group ">
                               <span><?php echo $degree_codes[$vol_echo1['vol_degree_id']];?>
                               </span>

                            </div>
                        </div>
<!-- Year of Admission -->                      
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_right">
                                <label class="font-weight-bold"><?php echo $labels['adm_year'];?></label>
                            </div>
                        </div>
                         <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_right">
                               <!--date as changed from yyyy/mm/dd to dd/mm/yyyy-->
                               <span ><?php echo $new_adm_year;?></span>

                            </div>
                        </div>               
                    </div>
                     <div class="row">
<!--Program Officer Name-->
                     <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_left">
                                <label class="font-weight-bold"><?php echo $labels['po_name'];?></label>
                            </div>
                        </div>
                         <div class="col-md-3 col-sm-12">
                            <div class="form-group ">
                               <span><?php echo $po_codes[$vol_echo1['vol_po_name']];?>
                               </span>

                            </div>
                        </div>
<!-- Date of Join in Nss -->
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_right">
                                <label class="font-weight-bold"><?php echo $labels['yr_join_nss'];?></label>
                            </div>
                        </div>
                         <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_right">
                                 <!--date as changed from yyyy/mm/dd to dd/mm/yyyy-->
                               <span ><?php echo $new_doj_nss;?></span>
                              

                            </div>
                        </div>               
                    </div>
                     <div class="row">
<!--  Blood Group -->   
                     <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_left">
                                <label class="font-weight-bold"><?php echo $labels['blood_group'];?></label>
                            </div>
                        </div>
                         <div class="col-md-3 col-sm-12">
                            <div class="form-group ">
                               <span><?php echo $bloodgroup_codes[$vol_echo1['vol_blood_group']];?>
                                </span>

                            </div>
                        </div>
<!--  Blood Donation -->
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_right">
                                <label class="font-weight-bold"><?php echo $labels['blood_don'];?></label>
                            </div>
                        </div>
                         <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_right">
                               <span ><?php 
                               if($vol_echo1['vol_blood_dona'] == "Y"){
                               echo ("YES");

                               }else{

                               echo ("No");
                               } ?></span>

                            </div>
                        </div>               
                    </div>
                    <div class="row">
<!--  Willing to work in emergency -->
                     <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_left">
                                <label class="font-weight-bold"><?php echo $labels['emerg_ser_willing'];?></label>
                            </div>
                        </div>
                         <div class="col-md-3 col-sm-12">
                            <div class="form-group ">
                               <span ><?php 
                               if($vol_echo1['vol_emerg_ser_willing'] == "Y"){
                               echo ("YES");

                               }else{

                               echo ("No");
                               } ?></span>

                            </div>
                        </div>
<!--Talents -->                         
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_right">
                                <label class="font-weight-bold"><?php echo $labels['talents'];?></label>
                            </div>
                        </div>
                         <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_right">
                               <span > <?php
$vol_talentsas=json_decode($vol_echo1['vol_talents'],true); 
foreach ($vol_talentsas as $vol_talentsaskey => $vol_talentsasvalue) {
if($vol_talentsaskey !='null'){
//echo implode(",", $talents_codes[$vol_talentsaskey]);
echo $talents_codes[$vol_talentsaskey];
}

} 
?> </span>

                            </div>
                        </div>               
                    </div>
               
               <div class="row">
<!--List out Talents -->                            
                     <div class="col-md-3 col-sm-12">
                            <div class="form-group aline_left ">
                                <label class="font-weight-bold"><?php echo $labels['list_talents'];?></label>
                            </div>
                        </div>
                         <div class="col-md-5 col-sm-12">
                            <div class="form-group ">
                               <span ><?php echo $vol_echo1['vol_list_talents'];?></span>

                            </div>
                        </div>
                    </div>
<div class="row"> 
          <div class="col-sm-12"> 
       <button type="submit"  class="btn btn-primary form_submitbtn_style btn-sm "><i class="icon-copy fa fa-download" aria-hidden="true"></i> <?php echo $labels['print'];?></button> 
          </div> 
        </div>  
  
     </div>               
<!--grid close -->
    </div>
    </div>
</form>
  </div>
</div>

<?php include "../footer.php"; ?> 
<?php include "../common_js.php";?>
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    //aadhar virtual id hide and show   
 var vol_aad_r_vir=<?php echo ($vol_echo1['vol_aadhaar_or_virtual'])?>;//alert(vol_aadhaar_sdd);
 
    if(vol_aad_r_vir==1){
        $('.virtualid').hide();  
        $('.aadhaarno').show(); 
    }else if(vol_aad_r_vir==2){
        $('.virtualid').show();  
        $('.aadhaarno').hide();
    }  
</script>
</body>
</html>


