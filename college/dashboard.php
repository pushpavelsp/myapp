<?php   
include "../db_connect.php";
include "../commen_php.php";
$NEW=2;
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

$university = $db->query("SELECT * FROM public.university"); 
$university_echo=$university->fetch(PDO::FETCH_ASSOC); 
 
/*
$university = $db->query("SELECT u.uni_email,u.uni_mobile,u.uni_district,u.uni_address,u.uni_code,u.uni_name,u.uni_name_tamil,u.uni_logo,u.uni_head_name,u.uni_email,u.uni_mobile,u.uni_std,u.uni_landline,u.uni_district,u.uni_address,u.uni_pincode,u.uni_head_desig,d.designation_name,distric.$districtname FROM university u left join designation d on u.uni_head_desig=d.designation_id left join district distric on u.uni_district=distric.district_code where uni_id='$unique_ids'"); 
$university_echo=$university->fetch(PDO::FETCH_ASSOC); 
 

if(isset($_POST['uni_name'])){ 
  if($_POST['uni_name'] && $_POST['uni_name_tamil'] && $_POST['uni_mobile'] && $_POST['uni_head_name']){
    $uni_name= stripQuotes(killChars(trim($_POST['uni_name']))); 
  $uni_name_tamil= stripQuotes(killChars(trim($_POST['uni_name_tamil']))); 
  $uni_code= stripQuotes(killChars(trim($_POST['uni_code']))); 
  $uni_district= stripQuotes(killChars(trim($_POST['uni_district']))); 
  $uni_pincode= stripQuotes(killChars(trim($_POST['uni_pincode']))); 
  $uni_email= stripQuotes(killChars(trim($_POST['uni_email']))); 
  $uni_mobile= stripQuotes(killChars(trim($_POST['uni_mobile']))); 
  $uni_std= stripQuotes(killChars(trim($_POST['uni_std']))); 
  $uni_landline= stripQuotes(killChars(trim($_POST['uni_landline']))); 
  $uni_logo= stripQuotes(killChars(trim($_POST['uni_logo']))); 
  $uni_head_name= stripQuotes(killChars(trim($_POST['uni_head_name']))); 
  $uni_head_desig= stripQuotes(killChars(trim($_POST['uni_head_desig']))); 
  $uni_address= stripQuotes(killChars(trim($_POST['uni_address']))); 

  $uni_id_rowCount = ($db->query("SELECT * FROM university where uni_id='$unique_ids'")->rowCount());  
   $ext="jpg"; 
   $logo_storage="../Uploads/university/$uni_code.".$ext.""; 
 
  try {
    if($uni_id_rowCount=='1'){ 
   // print_r();exit; 
    $query1 = $db->query("UPDATE university SET uni_name='$uni_name', uni_address='$uni_address', uni_pincode='$uni_pincode', uni_district='$uni_district', uni_email='$uni_email', uni_mobile='$uni_mobile', uni_landline='$uni_landline', uni_std='$uni_std', uni_head_name='$uni_head_name', uni_head_desig='$uni_head_desig', uni_logo='$logo_storage', update_by='$unique_ids', update_date='$created_date', uni_name_tamil='$uni_name_tamil' WHERE uni_id='$unique_ids';"); 
   $data='update';
    mkdir("../Uploads/university",0777,true); 
      $temp_storage="../Uploads/university";   
      if($_FILES['uni_logo']['tmp_name']){    
        move_uploaded_file($_FILES['uni_logo']['tmp_name'],$temp_storage."/$uni_code.".$ext."");  
      }
  }   

    $error = ($db->errorInfo())[2]; 
}catch (Exception $e) {
    //$datafdg=$e; 
} 
  if($error){
    $data_er[]=$error; 
  }else{
    $data_er=$data; 
  } 
  // print_r($data_er);exit;  
 die(json_encode($data_er));
  } 
} 

 

$district=$db->query("SELECT district_code, $districtname as district_name  FROM district  order by district_name");  
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
*/
//print_r($designation_id[$university_echo['uni_head_desig']]);exit;

//print_r($university_echo);exit; 
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
          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
            <div class="pd-20 card-box height-100-p">
              <div class="profile-photo"> 
                <img src="http://localhost/NSS/vendors/images/nss-logo1.png" alt="" class="avatar-photo">
                
              </div>
              <h5 class="text-center h5 mb-0"><?php echo $university_echo[$uni_name];?></h5>
             <!--  <p class="text-center text-muted font-14">Lorem ipsum dolor sit amet</p> -->
              <div class="profile-info">
                <h5 class="mb-20 h5 text-blue">Contact Information</h5>
                <ul>
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
              <div class="profile-tab height-100-p">
                <div class="tab height-100-p">
                  <ul class="nav nav-tabs customtab" role="tablist">
                    <li class="nav-item active">
                      <a class="nav-link" data-toggle="tab" href="#dashboard" role="tab">Dashboard</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#timeline" role="tab">Timeline</a>
                    </li> 
                  </ul>
                  <div class="tab-content">
                    <!-- Timeline Tab start -->
                  <div class="tab-pane show active" id="tasks" role="tabpanel">
                      <div class="">
                        <div class="">
                          <div class="">
                            <form class="tab-wizard wizard-circle wizard">
                                <br> <br>
                                <center><h2> &nbsp; BRIEF SUMMARY </h2></center><br>
<!--Total Number College-->                                
                                <center>
                                  <div class="col-lg-6 col-md-6">
                                      <div class="pd-100 card-box border">
                                      <br>
                                      <h4><span style="color: #ff4081;font-size: 35px;width: 120px">25</span></h4><br>
                                      <h4 style="color: #ff4081">Total Number of colleges</h4><br>
                                        
                                     
                                   </div>
                                    </div>  
                                   </center>
                              



<!-- 
                                  <div class="col-lg-4 col-md-6">
                                    <div class="l-design-widht">
                                      <div class="card card--inverted" style="display:flex; flex-direction:row;">
                                        <h5>Total Number of colleges: &nbsp; &nbsp; </h5>
                                        <input type="text" value="100" style="width:120px; border: 2px solid #013569">
                                      </div>
                                    </div>
                                  </div> -->
<!-- Registered ,unregistered college -->                               
                                <br> <br>
                                <div class="">
                                  <div class=" col-sm-12 mb-30 row">    
                                    <div class="col-lg-6 col-md-6">
                                      <div class="pd-100 card-box">
                                      <br>
                                      <h5>Total Number of Registered Colleges: </h5><br>
                                      <div class="progress mb-20">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">50</div>
                                        </div>
                                        <br>
                                      </div>
                                    </div>  
                                    <div class="col-lg-6 col-md-6">
                                      <div class="pd-100 card-box">
                                      <br>  
                                      <h5>Total Number of Unregistered Colleges:</h5><br>
                                      <div class="progress mb-20">
                                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25</div>
                                      </div>
                                      <br>
                                      </div> 
                                    </div>
                                  </div>
                                  <div class="xs-pd-20-10 pd-ltr-20">
<!-- Approve,Pendind,Disapprove-->
                                    <div class="row clearfix progress-box" style="justify-content:center;">
                                      <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
                                        <div class="card-box pd-30 height-100-p border">
                                          <div class="progress-box text-center">
                                            <input type="text" class="knob dial2" value="70" data-width="120" data-height="120" data-linecap="round" data-thickness="0.12" data-bgColor="#fff" data-fgColor="#43a047" data-angleOffset="180" readonly>
                                            <h5 class="padding-top-10 h5" style="color: #43a047">Approved Colleges</h5>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
                                        <div class="card-box pd-30 height-100-p border">
                                          <div class="progress-box text-center">
                                            <input type="text" class="knob dial3" value="90" data-width="120" data-height="120" data-linecap="round" data-thickness="0.12" data-bgColor="#fff" data-fgColor="#f56767" data-angleOffset="180" readonly>
                                            <h5 class=" padding-top-10 h5" style="color: #f56767">Disapproved Colleges</h5>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
                                        <div class="card-box pd-30 height-100-p border">
                                          <div class="progress-box text-center">
                                            <input type="text" class="knob dial4" value="65" data-width="120" data-height="120" data-linecap="round" data-thickness="0.12" data-bgColor="#fff" data-fgColor="#fbc02d" data-angleOffset="180" readonly>
                                            <h5 class="padding-top-10 h5" style="color:#fbc02d">Pending Colleges</h5>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
<!--Po-->                             
                                  <center>
                                  <div class="col-lg-6 col-md-6">
                                      <div class="pd-100 card-box border">
                                      <br>
                                       <h4><span style="color: #8e24aa;font-size: 35px;width: 120px">25</span></h4>
                                        <br>
                                      <h4 style="color: #8e24aa">Total Number of Programme Officers </h4><br>
                                     <!--  <input type="text" value="10" style="width:120px">  -->
                                       
                                      
                                   </div>
                                    </div>  
                                   </center><br>
<!--Funded ,Non funded -->
                                    <div class="row clearfix progress-box" style="justify-content:center;">
                                       <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
                                        <div class="card-box pd-30 height-100-p border" >
                                          <div class="progress-box text-center">
                                            
                                            <input type="text" class="knob dial4" value="65" data-width="120" data-height="120" data-linecap="round" data-thickness="0.12" data-bgColor="#fff" data-fgColor="#3f51b5" data-angleOffset="180" readonly>
                                            <h5 class="padding-top-10 h5" style="color: #3f51b5">Total Number of Funded Units</h5>
                                            <!-- <h5 class="text-light-purple padding-top-10 h5">Pending Colleges</h5> -->
                                          </div>
                                        </div>
                                      </div>
                                       <div class="col-lg-3 col-md-6 col-sm-12 mb-30 border">
                                        <div class="card-box pd-30 height-100-p" >
                                          <div class="progress-box text-center">
                                            
                                            <input type="text" class="knob dial3" value="90" data-width="120" data-height="120" data-linecap="round" data-thickness="0.12" data-bgColor="#fff" data-fgColor="#aeea00" data-angleOffset="180" readonly>
                                            <h5 class="padding-top-10 h5" style="color: #aeea00">Total Number of Non-Funded Units</h5>
                                          </div>
                                        </div>
                                      </div>
                                     
                                    </div>



                                    <center>
<!-- Total no. of volunteer-->
                               <center>
                                  <div class="col-lg-6 col-md-6">
                                      <div class="pd-100 card-box border">
                                      <br>
                                        <h4><b><span style="color: #26c6da;font-size: 35px;width: 120px;">25</span></b></h4>
                                        <br>
                                      <h4 style="color: #26c6da">Total Number of Volunteers </h4><br>
                                     <!--  <input type="text" value="10" style="width:120px">  -->
                                       
                                     
                                   </div>
                                    </div>  
                                   </center><br>


<!--no.of Boys,Girls,SC/ST-->
                                    <div class="row clearfix progress-box" style="justify-content:center;">
                                      <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
                                        <div class="card-box pd-30 height-100-p border">
                                          <div class="progress-box text-center">
                                            <input type="text" class="knob dial2" value="70" data-width="120" data-height="120" data-linecap="round" data-thickness="0.12" data-bgColor="#fff" data-fgColor="#1de9b6" data-angleOffset="180" readonly>
                                            <h5 class="padding-top-10 h5" style="color: #1de9b6">Total Number of Boys</h5>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
                                        <div class="card-box pd-30 height-100-p border">
                                          <div class="progress-box text-center">
                                            <input type="text" class="knob dial3" value="90" data-width="120" data-height="120" data-linecap="round" data-thickness="0.12" data-bgColor="#fff" data-fgColor="#ff6f00" data-angleOffset="180" readonly>
                                            <h5 class="padding-top-10 h5" style="color: #ff6f00">Total Number of Girls</h5>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
                                        <div class="card-box pd-30 height-100-p border">
                                          <div class="progress-box text-center">
                                            <input type="text" class="knob dial4" value="65" data-width="120" data-height="120" data-linecap="round" data-thickness="0.12" data-bgColor="#fff" data-fgColor="#795548" data-angleOffset="180" readonly>
                                            <h5 class="text-brown padding-top-10 h5" style="color: #795548">Total Number of SC/ST</h5>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                  </div>  
                                </div>
                            </form>
                          </div>
                          <!-- add task popup start -->
                          <div class="modal fade customscroll" id="task-add" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLongTitle">Tasks Add</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Close Modal">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body pd-0">
                                  <div class="task-list-form">
                                    <ul>
                                      <li>
                                        <form>
                                          <div class="form-group row">
                                            <label class="col-md-4">Task Type</label>
                                            <div class="col-md-8">
                                              <input type="text" class="form-control">
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <label class="col-md-4">Task Message</label>
                                            <div class="col-md-8">
                                              <textarea class="form-control"></textarea>
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <label class="col-md-4">Assigned to</label>
                                            <div class="col-md-8">
                                              <select class="selectpicker form-control" data-style="btn-outline-primary" title="Not Chosen" multiple="" data-selected-text-format="count" data-count-selected-text= "{0} people selected">
                                                <option>Ferdinand M.</option>
                                                <option>Don H. Rabon</option>
                                                <option>Ann P. Harris</option>
                                                <option>Katie D. Verdin</option>
                                                <option>Christopher S. Fulghum</option>
                                                <option>Matthew C. Porter</option>
                                              </select>
                                            </div>
                                          </div>
                                          <div class="form-group row mb-0">
                                            <label class="col-md-4">Due Date</label>
                                            <div class="col-md-8">
                                              <input type="text" class="form-control date-picker">
                                            </div>
                                          </div>
                                        </form>
                                      </li>
                                      <li>
                                        <a href="javascript:;" class="remove-task"  data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Remove Task"><i class="ion-minus-circled"></i></a>
                                        <form>
                                          <div class="form-group row">
                                            <label class="col-md-4">Task Type</label>
                                            <div class="col-md-8">
                                              <input type="text" class="form-control">
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <label class="col-md-4">Task Message</label>
                                            <div class="col-md-8">
                                              <textarea class="form-control"></textarea>
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <label class="col-md-4">Assigned to</label>
                                            <div class="col-md-8">
                                              <select class="selectpicker form-control" data-style="btn-outline-primary" title="Not Chosen" multiple="" data-selected-text-format="count" data-count-selected-text= "{0} people selected">
                                                <option>Ferdinand M.</option>
                                                <option>Don H. Rabon</option>
                                                <option>Ann P. Harris</option>
                                                <option>Katie D. Verdin</option>
                                                <option>Christopher S. Fulghum</option>
                                                <option>Matthew C. Porter</option>
                                              </select>
                                            </div>
                                          </div>
                                          <div class="form-group row mb-0">
                                            <label class="col-md-4">Due Date</label>
                                            <div class="col-md-8">
                                              <input type="text" class="form-control date-picker">
                                            </div>
                                          </div>
                                        </form>
                                      </li>
                                    </ul>
                                  </div>
                                  <div class="add-more-task">
                                    <a href="#" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Add Task"><i class="ion-plus-circled"></i> Add More Task</a>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-primary">Add</button>
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- add task popup End -->
                        </div>
                      </div>
                    </div>

                    <div class="tab-pane fade show" id="timeline" role="tabpanel">
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
   <?php //include "task.php"?>                 
                
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
           
        </div>  
    </div>
  </div>
 

    <script src="../vendors/scripts/core.js"></script>
  <script src="../vendors/scripts/script.min.js"></script>
  <script src="../vendors/scripts/process.js"></script>
  <script src="../vendors/scripts/layout-settings.js"></script>
  <script src="../src/plugins/jQuery-Knob-master/jquery.knob.min.js"></script>
  <script src="../src/plugins/highcharts-6.0.7/code/highcharts.js"></script>
  <script src="../src/plugins/highcharts-6.0.7/code/highcharts-more.js"></script>
  <script src="../src/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js"></script>
  <script src="../src/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
  <script src="../vendors/scripts/dashboard2.js"></script>
   <?php include "../footer.php"; ?>
  <?php include "../common_js.php";?>  
</body>
</html>