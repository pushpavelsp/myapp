<?php  
  include "../db_connect.php";
  include "../commen_php.php"; 
  if($_SESSION['unique_ids']==''){    
    header('Location:'.$Base_url21.'login_page.php');  
  }
  $created_date=date("Y/m/d");
  $totalsatus=datatable_status_count('uni_active_status','university','','');
  $totalsatus1=explode('~', $totalsatus);
  $status_codes=datatable_status_select_option();  
  $datatable_page_title=datatable_page_title();
  // print_r(bse64$status_codes);exit;
  $get_status=base64_decode($_GET['status'],true);
  //To select pending details, even if there is no data
  $click_status1=base64_decode($_GET['click_status'],true);
  if($get_status =='0' || $get_status ==''){ 
    if($click_status1==1){
         $university_where ="where uni_active_status='0'"; 
     }else{
        $active_0_count = $db->query("select * from university where uni_active_status='0'")->rowcount();  
    if($active_0_count !='0'){ 
       $university_where ="where uni_active_status='0'"; 
    }  
     } 
   
  }elseif($get_status =='1') { 
    $university_where ="where uni_active_status='1'"; 
  }elseif($get_status =='2') { 
    $university_where ="where uni_active_status='2'";  
  }elseif($get_status =='3') {
    $university_where ="";   
  }
 // print_r("select * from university $university_where ORDER BY uni_name");exit;
  $university = $db->query("select * from university $university_where ORDER BY uni_name"); 
  $university1=$university->fetchAll(PDO::FETCH_ASSOC); 
  $s=0; 
  foreach($university1 as $key => $university_val) {  
    $s++;    
    $tot_datas[]=array($s,$university_val['uni_name'],$university_val['uni_code'],$university_val['uni_email'],$university_val['uni_mobile'],$university_val['uni_active_status'],$university_val['uni_id']); 
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
    <li class="breadcrumb-item active" aria-current="page" href="">University Details</li>
  </ol>
</nav>
      <!-- Form grid Start -->
      <div class="container pd-20 card-box mb-30">
        <div class="clearfix">
          <div class="row"> 
            <div class="col-md-3 col-sm-12"> 
              <h4 class="text-blue h4" id="approval_label"><?php echo $datatable_page_title?> Universities:</h4> 
            </div>
            <div class="col-md-5 col-sm-12"> 
              <label>Pending</label>
              <span class="badge badge-pill badge-warning"><?php if($totalsatus1[0]){ echo $totalsatus1[0]; }else{ echo '0'; } ;?></span>
              <label>Approved</label>
              <span class="badge badge-pill badge-success"><?php if($totalsatus1[1]){ echo $totalsatus1[1]; }else{ echo '0'; } ;?></span>  
              <label>Disapproved</label>
              <span class="badge badge-pill badge-danger"><?php if($totalsatus1[2]){ echo $totalsatus1[2]; }else{ echo '0'; } ;?></span>
            </div>
            <div class="col-md-1 col-sm-12"> 
              <b class="text-blue" style="margin-left: -48px;">Filter Status:</b>
            </div>
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <select class="custom-select col-12 font-weight-bold" name="uni_status" id="uni_status" >   
                  <?php
                   $statusaa=base64_decode($_GET['status'],true);
                  foreach ($status_codes as $statuskey => $statusvalue) {
                    if($statuskey==$statusaa){  ?>
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
  <?php include "../common_js.php";?>   
  <script type="text/javascript">
var active_0_count1='<?php echo json_encode($active_0_count)?>'; //alert(active_0_count1);
if(active_0_count1==0){
  var active_0_count12=<?php echo json_encode(base64_encode(3));?>;
     window.location.href="all_university_details.php?status="+active_0_count12+"";   
}

$("#uni_status").on("change",function(e) { 
  var chek_vald = $("#uni_status").val(); //alert(chek_vald); 
   var clickstsus=<?php echo json_encode(base64_encode(1));?>; 
  window.location.href="all_university_details.php?status="+chek_vald+"&click_status="+clickstsus+"";   
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
        { title: 'Name'},
        { title: 'University Code'},
        { title: 'Email ID'},
        // { title: 'Mobile Number'},   
        // { title: 'Registered Date'},
        { title: 'Status' ,
        'render': function (data, type, full, meta){   
          var checkbox_val=full[5];
          var checkbox_color; 

          if(checkbox_val=='1'){ 
            var  checkbox_color=" #00c853"; 
            var checkbox_val="Approved"; 
            }else if(checkbox_val =='0'){ 
              var  checkbox_color="orange";   
              var checkbox_val="Pending";
            }else if(checkbox_val =='2'){ 
              var  checkbox_color="red";  
              var checkbox_val="Disapproved";
            }   
            return '<label style="color:'+checkbox_color+'"><b>'+checkbox_val+'</b></label>';  
            } 
            },   
            { title: 'View & Approve',
            'render': function (data, type, full, meta){   
              return '<form  action="<?php echo Base_url;?>nss/view_university_details.php" method="POST"><input hidden type="text" name="ids" value="'+full[6]+'"><input type="text" name="approve" value="1" hidden><button type="submit" class="btn btn-primary"><i class="dw dw-eye"></i>View</button></form>';
            }
            },

            ],
            });
                });

    $(document).on('change', '.stauscls', function() {
      let updateid=$(this).data('id');  //alert(stausid);
      let loginmaill=$(this).data('loginmail');  //alert(loginmaill);
      Swal.fire({
        title: 'Do you want to save the changes?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Approve',
        denyButtonText: 'Disapprove',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          status_switch('1','university','uni_active_status','uni_id',updateid,loginmaill);  
          login_approve_status('1','login_details','approve_status','email',loginmaill);  
          Swal.fire('Approved', '', 'success') 
        } else if (result.isDenied) {
          Swal.fire('Disapproved', '', 'info')
          status_switch('2','university','uni_active_status','uni_id',updateid,loginmaill);  
          login_approve_status('2','login_details','approve_status','email',loginmaill);  
        }
      })
      });
    </script>
  </body>
</html>