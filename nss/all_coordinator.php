<?php  
include "../db_connect.php";
include "../commen_php.php"; 
$created_date=date("Y/m/d");
if($_SESSION['unique_ids']==''){    
  header('Location:'.$Base_url21.'login_page.php');  
}
//print_r("select c.coord_name, u.uni_name ,c.coord_mailid,c.coord_mobileno,c.update_time,c.coord_id from coordinator c left join university u on u.uni_id=c.uni_id");exit;
$coordinator = $db->query("select c.coord_name, u.uni_name ,c.coord_mailid,c.coord_mobileno,c.created_time,c.coord_id from coordinator c left join university u on u.uni_id=c.uni_id");

$coordinator1=$coordinator->fetchAll(PDO::FETCH_ASSOC); 
$s=0; 
foreach($coordinator1 as $key => $coordinator_val){  
// print("abcd"); exit;
  $s++;    
  $created_time1=explode(" ",$coordinator_val['created_time']); 
  $tot_datas[]=array($s,$coordinator_val['coord_name'],$coordinator_val['uni_name'],$coordinator_val['coord_mailid'],$created_time1[0],$coordinator_val['coord_mobileno'],$coordinator_val['coord_id']);
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
    <div class="pd-ltr-20">
    <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page" href="">Coordinator Details</li>
  </ol>
</nav>
      <!-- Form grid Start -->
      <div class="container pd-20 card-box mb-30">
        <div class="clearfix">
          <div class="pull-left">
            <h4 class="text-blue h4">View All Coordinator Details:</h4>
            <!-- <p class="mb-30">All bootstrap element classies</p> -->
          </div> 
        </div>
        <br>
        <table id="university" class="display" width="100%"></table>
      </div>
      <!-- Form grid End -->
      <?php include "../footer.php"; ?> 
    </div>
  </div> 
  <?php include "../commen_style.php"; ?> 
  
  <?php include "../common_js.php";?> 

  <script type="text/javascript">     
var dataSet = (<?php echo (json_encode($tot_datas))?>);   //console.log(dataSet);
$(document).ready(function () {  
  $('#university').DataTable({
     scrollCollapse: true,
    autoWidth: false,
    responsive: true, 
    data: dataSet,
    columns: [
    { title: 'S.No.'},   
    { title: 'Coordinator Name'},
    { title: 'University Name'},
    { title: 'Email ID'},
    { title: 'Registered Date'},  
    // { title: 'Mobile Number'}, 
    { title: 'View Coordinator Details',
    'render': function (data, type, full, meta){   
      return '<form  action="<?php echo Base_url;?>nss/view_coordinator_details.php" method="POST"><input hidden type="text" name="ids" value="'+full[6]+'"><button type="submit" class="btn btn-primary"><i class="dw dw-eye"></i>View</button></form>';
    }
  },
  ],
});
});

</script>
</body>
</html>