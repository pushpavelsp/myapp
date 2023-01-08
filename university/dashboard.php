<?php   
include "../db_connect.php";
include "../commen_php.php";
$created_date=date("Y/m/d"); 
$unique_ids=$_SESSION["unique_ids"]; 
$langtype=$_SESSION["langtype"];
if($langtype==1){
  $districtname= "district_tname";
  $uni_name= "uni_name_tamil";
}elseif($langtype==2){
  $districtname= "district_name";
  $uni_name= "uni_name";
}else{
  $districtname= "district_tname";
  $uni_name= "uni_name_tamil";
}    

$university = $db->query("SELECT * FROM university"); 
$university_echo=$university->fetch(PDO::FETCH_ASSOC); 

$coord = $db->query("SELECT * FROM coordinator where uni_id='$unique_ids'"); 
$coord_echo=$coord->fetch(PDO::FETCH_ASSOC); 


 // $coord = ($db->query("select coord.coord_name from coordinator coord left join university u on u.uni_id=coord.uni_id where u.uni_id='$unique_ids'"));
 //  $coord_echo= $coord->fetch(PDO::FETCH_ASSOC); 

$no_of_clg = ($db->query("select no_of_clg from university where uni_id='$unique_ids'")->rowCount());

$no_of_reg_clg = ($db->query("select * from college where university_id='$unique_ids'")->rowCount());

$no_of_unreg_clg = $university_echo['no_of_clg']-$no_of_reg_clg;

$approved_clg_count = ($db->query("select c.active_status from university u left join college c on u.uni_id=c.university_id where active_status='1' and c.university_id='$unique_ids'")->rowCount());

$disapproved_clg_count = ($db->query("select c.active_status from university u left join college c on u.uni_id=c.university_id where active_status='2' and c.university_id='$unique_ids'")->rowCount());

$pending_clg_count = ($db->query("select c.active_status from university u left join college c on u.uni_id=c.university_id where active_status='0' and c.university_id='$unique_ids'")->rowCount());

$no_of_po = ($db->query("select  po.po_id,po.col_id from university u 
  left join college c on c.university_id=u.uni_id
  left join po_officer po on po.col_id=c.clg_id where c.university_id='$unique_ids'")->rowCount());

$no_of_volunteer = ($db->query("select v.vol_id from university u left join volunteer v on v.uni_id=u.uni_id where v.uni_id='$unique_ids'")->rowCount());

$no_of_funded_unit = ($db->query("select u_nss.funded_unit from university u left join university_nss_details u_nss on u_nss.uni_id=u.uni_id where u.uni_id='$unique_ids'")->rowCount());


$no_of_nonfunded_unit = ($db->query("select u_nss.sf_unit from university u left join university_nss_details u_nss on u_nss.uni_id=u.uni_id where u.uni_id='$unique_ids'")->rowCount());

$no_of_vol_boys = ($db->query("select v.vol_id from university u left join volunteer v on v.uni_id=u.uni_id where v.vol_gender='1' and v.uni_id='$unique_ids'")->rowCount());

$no_of_vol_girls = ($db->query("select v.vol_id from university u left join volunteer v on v.uni_id=u.uni_id where v.vol_gender='2' and v.uni_id='$unique_ids'")->rowCount());

$no_of_vol_sc = ($db->query("select v.vol_id from university u left join volunteer v on v.uni_id=u.uni_id left join m_community m_com  on m_com.community_id=v.vol_community where v.vol_community='1' and v.uni_id='$unique_ids'")->rowCount());

$no_of_vol_st = ($db->query("select v.vol_id from university u left join volunteer v on v.uni_id=u.uni_id left join m_community m_com  on m_com.community_id=v.vol_community where v.vol_community='2' and v.uni_id='$unique_ids'")->rowCount());

$no_of_vol_oc = ($db->query("select v.vol_id from university u left join volunteer v on v.uni_id=u.uni_id left join m_community m_com  on m_com.community_id=v.vol_community where v.vol_community='3' and v.uni_id='$unique_ids'")->rowCount());

$no_of_vol_sc_st=$no_of_vol_sc +$no_of_vol_st;


?> 

<!DOCTYPE html>
<html>
<?php include "../head.php"; ?>  
  <style type="text/css">
  .counter{
    color: #666;
    font-family: 'Poppins', sans-serif;
    text-align: center;
    width: 200px;
    height: 200px;
    padding: 0 20px 20px 0;
    margin: 0 auto;
    position: relative;
    z-index: 1;
}
.counter:before,
.counter:after{
    content: "";
    background: linear-gradient(#F3AC2F, #ED6422);
    position: absolute;
    top: 10px;
    left: 10px;
    right: 0;
    bottom: 0;
    z-index: -1;
}
.counter:after{
    background: transparent;
    border: 2px dashed rgba(255,255,255,0.5);
    top: 20px;
    left: 20px;
    right: 10px;
    bottom: 10px;
}
.counter .counter-content{
    background-color: #fff;
    height: 100%;
    padding: 23px 15px;
    box-shadow: 5px 5px 5px rgba(0,0,0,0.25);
    position: relative;
}
.counter .counter-content:before,
.counter .counter-content:after{
    content: '';
    background: linear-gradient(to top right, #ad3a05 50%, transparent 52%);
    height: 10px;
    width: 10px;
    position: absolute;
    right: -10px;
    top: 0;
}
.counter .counter-content:after{
    transform: rotate(180deg);
    top: auto;
    bottom: -10px;
    right: auto;
    left: 0;
}
.counter .counter-icon{
    font-size: 35px;
    line-height: 35px;
    margin: 0 0 15px;
}
.counter h3{
    color: #F36526;
    font-size: 18px;
    font-weight: 600;
    letter-spacing: 1px;
    line-height: 20px;
    text-transform: uppercase;
    margin: 0 0 7px;
}
.counter .counter-value{
    font-size: 30px;
    font-weight: 600;
    display: block;
}
.counter.purple:before{ background: linear-gradient(#C4588C, #BE2A8D); }
.counter.purple .counter-content:before,
.counter.purple .counter-content:after{
    background: linear-gradient(to top right, #7c1058 50%, transparent 52%);
}
.counter.purple h3{ color: #BE2A8D; }
.counter.blue:before{ background: linear-gradient(#7ACBC5, #2D9C91); }
.counter.blue .counter-content:before,
.counter.blue .counter-content:after{
    background: linear-gradient(to top right, #0a5b53 50%, transparent 52%);
}
.counter.blue h3{ color: #2D9C91; }
.counter.green:before{ background: linear-gradient(#558b2f, #558b2f); }
.counter.green .counter-content:before,
.counter.green .counter-content:after{
    background: linear-gradient(to top right, #558b2f 50%, transparent 52%);
}
.counter.green h3{ color: #558b2f; } 

.counter.red:before{ background: linear-gradient(#ff3d00, #ff3d00); }
.counter.red .counter-content:before,
.counter.red .counter-content:after{
    background: linear-gradient(to top right, #ff3d00 50%, transparent 52%);
}
.counter.red h3{ color: #ff3d00; } 
.counter.yellow:before{ background: linear-gradient(#ffd600, #ffd600); }
.counter.yellow .counter-content:before,
.counter.yellow .counter-content:after{
    background: linear-gradient(to top right, #ffd600 50%, transparent 52%);
}
.counter.yellow h3{ color: #ffd600; }

.counter.darkblue:before{ background: linear-gradient(#3b5998, #3b5998); }
.counter.darkblue .counter-content:before,
.counter.darkblue .counter-content:after{
    background: linear-gradient(to top right, #3b5998 50%, transparent 52%);
}
.counter.darkblue h3{ color: #3b5998; }

.counter.olivegreen:before{ background: linear-gradient(#cddc35, #cddc35); }
.counter.olivegreen .counter-content:before,
.counter.olivegreen .counter-content:after{
    background: linear-gradient(to top right, #cddc35 50%, transparent 52%);
}
.counter.olivegreen h3{ color: #cddc35; }

.counter.skyblue:before{ background: linear-gradient(#26c6da, #26c6da); }
.counter.skyblue .counter-content:before,
.counter.skyblue .counter-content:after{
    background: linear-gradient(to top right, #26c6da 50%, transparent 52%);
}
.counter.skyblue h3{ color: #26c6da; }


@media screen and (max-width:990px){
    .counter { margin-bottom: 40px; }
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
          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30" >
            <div class="pd-20 card-box height-100-p" style="background-color:#eceff1">
              <div class="profile-photo"> 
                <img src="http://localhost/NSS/vendors/images/nss-logo1.png" alt="" class="avatar-photo">
                
              </div>
              <h5 class="text-center h5 mb-0"><?php echo $university_echo[$uni_name];?></h5>
            
              <div class="profile-info">
                <h5 class="mb-20 h5 text-blue">Contact Information</h5>
                <ul>
                  <li>
                    <b>University Coordinator Name : </b><?php echo $coord_echo['coord_name'];?>
                  </li>
                  <li>
                    <b>Email Address : </b><?php echo $university_echo['uni_email'];?>
                  </li>
                  <li>
                    <b>Phone Number : </b><?php echo $university_echo['uni_mobile'];?>
                  </li> 
                  <li>
                    <b>Address : </b><?php echo $university_echo['uni_address'];?>
                  </li>   
                   
                </ul>
              </div>
                     
            </div>
          </div>
          <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
            <div class="card-box height-100-p overflow-hidden">
              <div class="profile-tab height-100-p" style="background-color:#eceff1">
                <div class="tab height-100-p" >
                  <ul class="nav nav-tabs customtab" role="tablist" style="background-color:#eceff1">
                    <li class="nav-item active">
                      <a class="nav-link" data-toggle="tab" href="#dashboard" role="tab">Dashboard</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#uni_pdf_report" role="tab">Report</a>
                    </li> 
                  </ul>
                  <div class="tab-content">
                    <!-- Timeline Tab start -->
                  <div class="tab-pane show active" id="dashboard" role="tabpanel">
                    <form class="tab-wizard wizard-circle wizard" >
                      <center><h2> &nbsp; BRIEF SUMMARY </h2></center><br>
                      <div class="container">
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="counter">
                                    <div class="counter-content">
                                        <div class="counter-icon">
                                        <!-- <i class="fa fa-globe"></i> -->
                                       <!--  <i class="icon-copy dw dw-apartment"></i> -->
                                      <!--  <i class="icon-copy dw dw-building"></i> -->
                                      <i class="icon-copy fa fa-building" aria-hidden="true" style="color:#ff6f00"></i>
                                    </div>
                                    <h3>Number of Colleges</h3>
                                    <span class="counter-value"><?php echo $university_echo['no_of_clg'];?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 col-sm-6"></div>
                            <div class="col-md-3 col-sm-6">
                                <div class="counter purple">
                                    <div class="counter-content"> 
                                        <div class="counter-icon">
                                            <!-- <i class="fa fa-rocket"></i> -->
                                            <i class="icon-copy dw dw-building" style="color:#BE2A8D"></i> 
                                        </div>
                                        <h3>No.of Registered Colleges</h3>
                                        <span class="counter-value"><?php echo $no_of_reg_clg ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 col-sm-6"></div>
                            <div class="col-md-3 col-sm-6">
                                <div class="counter blue">
                                    <div class="counter-content">
                                        <div class="counter-icon">
                                            <!-- <i class="fa fa-rocket"></i> -->
                                            <i class="icon-copy dw dw-building" style="color:#2D9C91"></i> 
                                        </div>
                                        <h3>No.of Non-Registered Colleges</h3>
                                        <span class="counter-value"><?php echo $no_of_unreg_clg ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                         <div class="row">  

                            <div class="col-md-3 col-sm-6">
                                <div class="counter green">
                                    <div class="counter-content">
                                        <div class="counter-icon">
                                       <!--  <i class="fa fa-globe"></i> -->
                                       <!-- <i class="icon-copy fa fa-check" aria-hidden="true"></i> -->
                                      <!--  <i class="icon-copy fa fa-check-circle" aria-hidden="true"></i> -->
                                      <i class="icon-copy fa fa-thumbs-up" aria-hidden="true" style="color:#558b2f"></i>
                                    </div>
                                    <h3>Approved Colleges</h3>
                                    <span class="counter-value"><?php echo $approved_clg_count ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 col-sm-6"></div>
                            <div class="col-md-3 col-sm-6">
                                <div class="counter red">
                                    <div class="counter-content">
                                        <div class="counter-icon">
                                           <!--  <i class="fa fa-rocket"></i> -->
                                          <!--  <i class="icon-copy fa fa-times" aria-hidden="true"></i> -->
                                         <!--  <i class="icon-copy fa fa-times-circle" aria-hidden="true"></i> -->
                                         <i class="icon-copy fa fa-thumbs-down " aria-hidden="true" style="color:#ff3d00"></i>
                                        </div>
                                        <h3>Disapproved Colleges</h3>
                                        <span class="counter-value"><?php echo $disapproved_clg_count ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 col-sm-6"></div>
                            <div class="col-md-3 col-sm-6">
                                <div class="counter yellow">
                                    <div class="counter-content">
                                        <div class="counter-icon">
                                           <!--  <i class="fa fa-rocket"></i> -->
                                           <i class="icon-copy fa fa-history" aria-hidden="true" style="color:#ffd600"></i>
                                        </div>
                                        <h3>Pending Colleges</h3>
                                        <span class="counter-value"><?php echo $pending_clg_count ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

 <br>
                         <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="counter darkblue">
                                    <div class="counter-content">
                                        <div class="counter-icon">
                                       <!--  <i class="fa fa-globe"></i> -->
                                       <i class="icon-copy fa fa-group" aria-hidden="true" style="color:#3b5998"></i>
                                    </div>
                                    <h3>Number of Volunteers</h3>
                                    <span class="counter-value"><?php echo $no_of_volunteer ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 col-sm-6"></div>
                            <div class="col-md-3 col-sm-6">
                                <div class="counter olivegreen">
                                    <div class="counter-content">
                                        <div class="counter-icon">
                                           <!--  <i class="fa fa-rocket"></i> -->
                                           <i class="icon-copy fi-torso" style="color:#cddc35"></i>
                                        </div>
                                        <h3>No.of Boys</h3>  
                                        <span class="counter-value"><?php echo $no_of_vol_boys ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 col-sm-6"></div>
                            <div class="col-md-3 col-sm-6">
                                <div class="counter skyblue">
                                    <div class="counter-content">
                                        <div class="counter-icon">
                                            <!-- <i class="fa fa-rocket"></i> -->
                                            <i class="icon-copy fi-torso-female" style="color:#26c6da"></i>
                                        </div>
                                        <h3>No.of Girls</h3>
                                        <span class="counter-value"><?php echo $no_of_vol_girls ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                    </div>
                
   <?php include "university_report.php"?>                 
                
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
           
        </div>  
    </div>
  </div>
 

   <?php include "../footer.php"; ?>
  <?php include "../common_js.php";?>  



<script type="text/javascript">




 
  
    </script>
</body>
</html>