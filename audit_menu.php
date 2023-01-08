<?php 
include "db_connect.php"; 
$session_email=$_SESSION["email"];  
$session_level=$_SESSION["login_level"];       
$approve_status=$_SESSION["approve_status"];  
//print_r($session_level);print_r($approve_status);exit;     
?>  
<style type="text/css"> 
</style> 
<div class="left-side-bar">
    <div class="brand-logo">
      <a>College login</a> 
     <!--  <a href="index.html">
        <img src="../vendors/images/images-nss.png" alt="" class="dark-logo">
        <img src="../vendors/images/images-nss.png" alt="" class="light-logo">
      </a>
      <div class="close-sidebar" data-toggle="left-sidebar-close">
        <i class="ion-close-round"></i>
      </div> -->
    </div>
    <div class="menu-block customscroll">
      <div class="sidebar-menu icon-style-2 icon-list-style-5">
        <ul id="accordion-menu"> 
          <li class="dropdown">
            <a href="javascript:;" class="dropdown-toggle">
              <span class="micon dw dw-house-1"></span><span class="mtext">College</span>
            </a>
            <ul class="submenu"> 
                <li><a href="college/update_college.php">Update College</a></li>  
                <li><a href="college/add_po_officer.php">Add Program officer</a></li>  
                <li><a href="college/college_nss_details.php">College NSS Details</a></li>  
                <li><a href="college/po_ofcr_details.php">Program officer Details</a></li> 
                <li><a href="college/add_college.php">Add College</a></li> 

              <li><a href="nss/university_approvel.php">University Approval</a></li>
              <li><a href="nss/all_university.php">All University</a></li>
              <li><a href="nss/all_college.php">All College</a></li>
              <li><a href="nss/all_coordinator.php">Coordinator Details</a></li> 

              <li class="dropdown">
            <a href="university/university_nss_details.php" class="dropdown-toggle">
              <span class="micon dw dw-house-1"></span><span class="mtext">NSS Details</span>
            </a> 
          </li>
            <li class="dropdown">
            <a href="university/coordinator_details.php" class="dropdown-toggle">
              <span class="micon dw dw-house-1"></span><span class="mtext">Add Coordinator</span>
            </a> 
          </li> 
            <li class="dropdown">
            <a href="university/university_details.php" class="dropdown-toggle">
              <span class="micon dw dw-house-1"></span><span class="mtext">University Details</span>
            </a> 
          </li>
          <li class="dropdown">
            <a href="university/College_approve_details.php" class="dropdown-toggle">
              <span class="micon dw dw-house-1"></span><span class="mtext">College Approval</span>
            </a> 
          </li>
            <li class="dropdown">
            <a href="university/all_college_details.php" class="dropdown-toggle">
              <span class="micon dw dw-house-1"></span><span class="mtext">All College Details</span>
            </a> 
          </li>
            </ul>
          </li> 
        </ul>
      </div>
    </div>
  </div>