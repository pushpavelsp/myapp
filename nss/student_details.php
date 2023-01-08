<?php
include "../db_connect.php";
include "../commen_php.php";
$created_date=date("Y/m/d"); 


if(isset($_SESSION["langtype"])){
  $langtype=$_SESSION["langtype"] ? $_SESSION['langtype'] : '1';
}else{
  $langtype=1;
}

if($langtype==1){
  $vol_name= "vol_name_tamil";
  $uni_name= "uni_name_tamil";
  $clg_name= "clg_name_tamil";
}elseif($langtype==2){
  $vol_name= "vol_name";
  $uni_name= "uni_name";
  $clg_name= "clg_name_english";
}else{
  $vol_name= "vol_name_tamil";
  $uni_name= "uni_name_tamil";
  $clg_name= "clg_name_tamil";
}
 //print_r("select a.$vol_name as vol_name,b.$clg_name as clg_name,c.$uni_name as uni_name,a.vol_mobile,a.vol_id,a.vol_email from volunteer as a left join college as b on a.clg_id=b.clg_id left join university as c on a.uni_id=c.uni_id");exit; 
$volunteer_data = $db->query("select a.$vol_name as vol_name,b.$clg_name as clg_name,c.$uni_name as uni_name,a.vol_mobile,a.vol_id,a.vol_email from volunteer as a left join college as b on a.clg_id=b.clg_id left join university as c on a.uni_id=c.uni_id");
$volunteer_data1=$volunteer_data->fetchAll(PDO::FETCH_ASSOC); 
 $s=0;
foreach($volunteer_data1 as $key => $volunteer_val){
 $s++;
  $tot_datas[]=array($s,$volunteer_val['vol_id'],$volunteer_val['vol_name'],$volunteer_val['clg_name'],$volunteer_val['uni_name'],$volunteer_val['vol_mobile'],$volunteer_val['vol_email']);
}
/*Volunteer Approve status Dropdown fetch data from db  */
 $totalsatus=datatable_status_count('vol_approve_status','volunteer','',''); 
 $totalsatus1=explode('~', $totalsatus);

// $status_codes=datatable_status_select_option();  
// $datatable_page_title=datatable_page_title();
// //print_r($tot_datas);exit;
?>
<!DOCTYPE html>
<html>
<?php include "../head.php"; ?>
<body>
   <?php include "../header.php"; ?>

   <?php include "../left_menu.php"; ?>

  <div class="mobile-menu-overlay"></div>

  <div class="main-container">
    <div class="pd-ltr-20">
       <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page" href="">View Volunteer Details</li>
        </ol>
      </nav>
        <!-- Form grid Start -->
        <div class="container pd-20 card-box mb-30">
          <div class="clearfix">
             <div class="row">
                <div class="col-md-4 col-sm-12">
                  <h4 class="text-blue h4"><?php echo $datatable_page_title?> Volunteers:</h4>
                </div>

              
         <div class="col-md-5 col-sm-12"> 
              <label>Pending</label>
                  <span class="badge badge-pill badge-warning"><?php if($totalsatus1[0]){ echo $totalsatus1[0]; }else{ echo '0'; } ;?></span>
                <label>Approved</label>
                  <span class="badge badge-pill badge-success"><?php if($totalsatus1[1]){ echo $totalsatus1[1]; }else{ echo '0'; } ;?></span>  
                  <label>Disapproved</label>
                  <span class="badge badge-pill badge-danger"><?php if($totalsatus1[2]){ echo $totalsatus1[2]; }else{ echo '0'; } ;?></span>

        </div>
             
                <!-- <div class="pull-right"> -->
                   <div class="col-md-3 col-sm-12"> 
                </div>
              </div>

          </div>
         
              <table id="university" class="display" width="100%"></table>
               
        </div>
        <!-- Form grid End -->

        <?php include "../footer.php"; ?>
    </div>
  </div>
    <?php include "../commen_style.php"; ?>
 <?php include "../common_js.php";?>
<script type="text/javascript"> 
 var dataSet = (<?php echo (json_encode($tot_datas))?>);//console.log(dataSet);
$(document).ready(function () {
    $('#university').DataTable({
       scrollCollapse: true,
    autoWidth: false,
    responsive: true, 
        data: dataSet,
        columns: [ 
            { title: 'S.No.'},
            { title: 'Volunteer Id'},
            { title: 'Name'},
            { title: 'College Name'},
            { title: 'university Name'},
            { title: 'Course'},
            { title: 'Email'},
            { title: 'View Details',
            'render': function (data, type, full, meta){
                return '<form  action="<?php echo Base_url;?>nss/view_volunteer_details.php" method="POST"><input hidden type="text" name="ids1" value="'+full[1]+'"><button type="submit" class="btn btn-primary"><i class="dw dw-eye"></i>View</button></form>';
              }
          }, 
        ],
    });
});

 
 
 
    </script>

</body>
</html>
