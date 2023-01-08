<?php  
include "../db_connect.php";
include "../commen_php.php";  
$created_date=date("Y/m/d"); 
$po_officer = $db->query("select a.po_id,a.po_name,a.po_mailid,a.po_mobileno,a.created_time,b.clg_name_english from po_officer as a left join college as b on a.col_id=b.clg_id");
$po_officer1=$po_officer->fetchAll(PDO::FETCH_ASSOC); 
 $s=0; 
foreach($po_officer1 as $key => $po_officer_val){  
 $s++;    
 $po_id2=base64_encode($po_officer_val['po_id']);
 $tot_datas[]=array($s,$po_officer_val['po_name'],$po_officer_val['clg_name_english'],$po_officer_val['po_mailid'],$po_officer_val['po_mobileno'],$po_officer_val['created_time'],$po_id2);
}  
?>
<!DOCTYPE html>
<html>
<?php include "../head.php"; ?>  
<body>  
  <?php include "../header.php"; ?>  

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
            </div> 
          </div>
            <br>
              <table id="university" class="display" width="100%"></table>
        </div> 
        <?php include "../footer.php"; ?> 
    </div>
  </div> 
    <?php include "../commen_style.php"; ?> 
 
 <?php include "../common_js.php";?>  
<script type="text/javascript">     
 var dataSet = (<?php echo (json_encode($tot_datas))?>);   console.log(dataSet);
$(document).ready(function () {  
    $('#university').DataTable({
       scrollCollapse: true,
    autoWidth: false,
    responsive: true, 
        data: dataSet,
        columns: [
            { title: 'S.No.'},   
            { title: 'Name'},
            { title: 'College Name'},
            { title: 'Email ID'},
            { title: 'Mobile Number'}, 
            { title: 'View PO Details', 
            'render': function (data, type, full, meta){   
                return '<form  action="<?php echo Base_url;?>nss/view_po_officer.php" method="POST"><input hidden type="text" name="ids" value="'+full[6]+'"><button type="submit" class="btn btn-primary"><i class="dw dw-eye"></i>View</button></form>';
            }
             },
            
        ],
    });
});
</script>  
</body>
</html>