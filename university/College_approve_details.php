<?php  
include "../db_connect.php";
include "../commen_php.php"; 
$created_date=date("Y/m/d"); 
$unique_ids=$_SESSION["unique_ids"];
 
$college_data = $db->query("select * from college a where university_id='$unique_ids' and active_status='0'");
$college_data1=$college_data->fetchAll(PDO::FETCH_ASSOC);  
 $s=0; 
foreach($college_data1 as $key => $college_val){  
 $s++;    
  $tot_datas[]=array($s,$college_val['clg_name_english'],$college_val['clg_email'],$college_val['clg_contact'],$college_val['created_time'],$college_val['active_status'],$college_val['clg_id']); 
} 
//print_r($tot_datas);exit;
?>
<!DOCTYPE html>
<html>
<?php include "../head.php"; ?>  
<body>  
   <?php include "../header.php"; ?> 

   <?php include "../left_menu.php";?> 

  <div class="mobile-menu-overlay"></div>

  <div class="main-container">
    <div class="pd-ltr-20">
       
        <!-- Form grid Start -->
        <div class="pd-20 card-box mb-30">
          <div class="clearfix">
            <div class="pull-left">
              <h4 class="text-blue h4"><?php echo $labels['lbl_col_approval_details'];?></h4> 
            </div> 
          </div>
            <br>
              <table id="university" class="display" width="100%"></table>
        </div>
        <!-- Form grid End -->
        
        <?php include "../footer.php"; ?> 
    </div>
  </div>  
  
 <?php include "../common_js.php";?> 
<script type="text/javascript">     
 var dataSet = (<?php echo (json_encode($tot_datas))?>);    
$(document).ready(function () {  
    $('#university').DataTable({
        data: dataSet,
        columns: [
            { title: 'S.No.'},   
            { title: 'Name'},
            { title: 'Email ID'},
            { title: 'Mobile Number'},  
            { title: 'Registered Date'}, 
            { title: 'Status' ,
              'render': function (data, type, full, meta){   
             var checkbox_val=full[5];
             var checkbox_color; 
             
            if(checkbox_val==1)
              { 
                //Green Color
                var  checkbox_color=" #2C6700"; 
                var checkbox_val="Approved"; 
             }else if(checkbox_val ==0)
             { 
               var  checkbox_color="Orange";   
               var checkbox_val="Pending";
             }else{ 
               var  checkbox_color="red";  
               var checkbox_val="Disapproved";
              }   
              return '<label style="color:'+checkbox_color+'"><b>'+checkbox_val+'</b></label>';  
            }

                   
            },   
            { title: 'View & Approve',
            'render': function (data, type, full, meta){   
                return '<form  action="<?php echo Base_url;?>university/view_clg_approve_details.php" method="POST"><input hidden type="text" name="ids" value="'+full[6]+'"><button type="submit" class="btn btn-primary"><i class="dw dw-eye"></i>View</button></form>';
            }
             },
            
        ],
    });
});
 
  
    </script>
  
</body>
</html>