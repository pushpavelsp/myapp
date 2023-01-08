<?php  
include "../db_connect.php";
include "../commen_php.php"; 
$created_date=date("Y/m/d"); 
$unique_ids=$_SESSION["unique_ids"]; 
if($_SESSION['unique_ids']==''){    
  header('Location:'.$Base_url21.'login_page.php');  
}

$totalsatus=datatable_status_count('active_status','college','','');
$totalsatus1=explode('~', $totalsatus); 
$status_codes=datatable_status_select_option();  
$datatable_page_title=datatable_page_title(); 

$get_status=base64_decode($_GET['status'],true);
$click_status1=base64_decode($_GET['click_status'],true);

if($get_status =='0' || $get_status ==''){
if($click_status1==1){
   $college_where ="where active_status='0'"; 
}else{
  $active_0_count = $db->query("select * from college where active_status='0'")->rowcount(); 
  if($active_0_count !='0'){ 
     $college_where ="where active_status='0'"; 
  }
}  
    
}elseif($get_status =='1') { 
  $college_where ="where active_status='1'"; 
}elseif($get_status =='2') { 
  $college_where ="where active_status='2'";  
}elseif($get_status =='3') { 
  $college_where ="";   
}
 
$college_data = $db->query("select a.clg_name_english,a.clg_email,b.uni_name,a.clg_id,a.active_status,a.created_time from college a left join university b on b.uni_id = a.university_id $college_where"); 
$college_data1=$college_data->fetchAll(PDO::FETCH_ASSOC); 
$s=0; 
foreach($college_data1 as $key => $college_val){  
  $s++;    
  $created_time=explode(" ",$college_val['created_time']);
  $tot_datas[]=array($s,$college_val['clg_name_english'],$college_val['uni_name'],$college_val['clg_email'],$created_time[0],$college_val['active_status'],$college_val['clg_id']); 
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
        <li class="breadcrumb-item active" aria-current="page" href="">View College Details</li>
        </ol>
      </nav>
        <!-- Form grid Start -->
        <div class="container pd-20 card-box mb-30">
          <div class="clearfix">
            <div class="row"> 
              <div class="col-md-4 col-sm-12"> 
                <h4 class="text-blue h4">View <?php echo $datatable_page_title?> College Lists:</h4> 
              </div>
              <div class="col-md-5 col-sm-12"> 
                <label>Pending</label>
                  <span class="badge badge-pill badge-warning"><?php if($totalsatus1[0]){ echo $totalsatus1[0]; }else{ echo '0'; } ;?></span>
                <label>Approved</label>
                  <span class="badge badge-pill badge-success"><?php if($totalsatus1[1]){ echo $totalsatus1[1]; }else{ echo '0'; } ;?></span>  
                  <label>Disapproved</label>
                  <span class="badge badge-pill badge-danger"><?php if($totalsatus1[2]){ echo $totalsatus1[2]; }else{ echo '0'; } ;?></span>
              </div>
              <div class="col-md-2 col-sm-12">
                <b class="text-blue">Filter Status:</b>
              </div>
            </div>
            <div class="row">
              <div class="col-md-9 col-sm-12"> 
                <!-- <button class="btn btn-primary" onclick="history.back(-1)"><i class="icon-copy ion-arrow-left-a">&nbsp; Back</i></button> -->
              </div>
              <div class="col-md-3 col-sm-12">
                <div class="form-group">
                  <select class="custom-select col-12 font-weight-bold" name="clg_status" id="clg_status" >   
                   <?php
                    foreach ($status_codes as $statuskey => $statusvalue) {
                    if($statuskey==$get_status){  ?>
                      <option selected="" value="<?php echo base64_encode($statuskey);?>"><?php echo $statusvalue;?></option>
                    <?php }else{ ?> 
                      <option class="font-weight-bold" value="<?php echo base64_encode($statuskey);?>"><?php echo $statusvalue;?></option>
                    <?php  } 
                   } ?>
                  </select>  
                </div>
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
var active_0_count1='<?php echo json_encode($active_0_count)?>'; //alert(active_0_count1);
if(active_0_count1==0){
var active_0_count12=<?php echo json_encode(base64_encode(3));?>;
   window.location.href="all_college.php?status="+active_0_count12+"";   
}
     
$("#clg_status").on("change",function(e) { 
var clickstsus=<?php echo json_encode(base64_encode(1));?>;
var chek_vald = $("#clg_status").val(); //alert(chek_vald);  
window.location.href="all_college.php?status="+chek_vald+"&click_status="+clickstsus+"";   
});
      
var dataSet = (<?php echo (json_encode($tot_datas))?>);   
$(document).ready(function () {  
  $('#university').DataTable({
    scrollCollapse: true,
    autoWidth: false,
    responsive: true, 
    data: dataSet,
    columns: [
      { title: 'S.No.'},   
      { title: 'College Name'},
      { title: 'University Name'},  
      { title: 'Email ID'},
      // { title: 'Mobile Number'},
      { title: 'Registered Date'},
      { title: 'Status' ,
      'render': function (data, type, full, meta){   
        var checkbox_val=full[5];
        var checkbox_color; 
        if(checkbox_val==1)
        { 
          //Green Color
          var  checkbox_color=" #00c853"; 
          var checkbox_val="Approved"; 
        }else if(checkbox_val ==0)
        { 
          var  checkbox_color="orange";   
          var checkbox_val="Pending";
        }else{ 
          var  checkbox_color="red";  
          var checkbox_val="Disapproved";
        }   
        return '<label style="color:'+checkbox_color+'"><b>'+checkbox_val+'</b></label>';  
      }
      },    
      { title: 'View College Details',
      'render': function (data, type, full, meta){   
        return '<form  action="<?php echo Base_url;?>nss/view_clg_details.php" method="POST"><input hidden type="text" name="ids" value="'+full[6]+'"><button type="submit" class="btn btn-primary"><i class="dw dw-eye"></i>View</button></form>';
      }
      },
    ],
  });
});
    </script>
  </body>
</html>