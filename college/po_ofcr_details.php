<?php  
include "../db_connect.php";
include "../commen_php.php";  
$created_date=date("Y/m/d");
if($_SESSION['unique_ids']==''){    
  header('Location:'.$Base_url21.'login_page.php');  
}
$unique_ids=$_SESSION["unique_ids"];
 //print_r($_SESSION["unique_ids"]);exit;
$po_officer = $db->query("select * from po_officer where col_id='$unique_ids'");
$po_officer1=$po_officer->fetchAll(PDO::FETCH_ASSOC); 
 $s=0; 
foreach($po_officer1 as $key => $po_officer_val){  
 $s++;    
 $tot_datas[]=array($s,$po_officer_val['po_name'],$po_officer_val['po_mailid'],$po_officer_val['po_mobileno'],$po_officer_val['created_time'],$po_officer_val['po_id']);
} 
  // $university_val['uni_code'],
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
    <li class="breadcrumb-item active" aria-current="page" href="">View P.O.</li>
  </ol>
</nav>
        <!-- Form grid Start -->
        <div class="container pd-20 card-box mb-30">
          <div class="clearfix">
            <div class="pull-left">
              <h4 class="text-blue h4"><?php echo $labels['po_ofcr_details'];?></h4>

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

<label class="switch">
  <input type="checkbox" checked>
  <span class="slider round"></span>
</label>  
 <?php include "../common_js.php";?>  
<script type="text/javascript">     
 var dataSet = (<?php echo (json_encode($tot_datas))?>);   console.log(dataSet);
$(document).ready(function () {  
    $('#university').DataTable({
       scrollCollapse: true,
    autoWidth: false,
    responsive: true,
    // columnDefs: [{
    //   targets: "datatable-nosort",
    //   orderable: false,
    // }],
    // "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    // "language": {
    //   "info": "_START_-_END_ of _TOTAL_ entries",
    //   searchPlaceholder: "Search",
    //   paginate: {
    //     next: '<i class="ion-chevron-right"></i>',
    //     previous: '<i class="ion-chevron-left"></i>'  
    //   }
    // },
    // dom: 'Bfrtp',
    // buttons: [
    // 'copy', 'csv', 'pdf', 'print'
    // ],
        data: dataSet,
        columns: [
            { title: 'S.No.'},   
            { title: 'Name'},
            { title: 'Email ID'},
            { title: 'Mobile Number'}, 
            { title: 'View PO Details',
            'render': function (data, type, full, meta){   
                return '<form  action="<?php echo Base_url;?>college/add_po_officer.php" method="POST"><input hidden type="text" name="ids" value="'+full[5]+'"><button type="submit" class="btn btn-primary"><i class="dw dw-eye"></i>View</button></form>';
            }
             },
            
        ],
    });
});
</script>  
</body>
</html>