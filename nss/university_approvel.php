<?php  
include "../db_connect.php";
include "../commen_php.php"; 
$created_date=date("Y/m/d");

$university = $db->query("select * from university where uni_active_status='0' or uni_active_status='2'");
$university1=$university->fetchAll(PDO::FETCH_ASSOC); 
$s=0; 
foreach($university1 as $key => $university_val){  
  $s++;    
  $tot_datas[]=array($s,$university_val['uni_name'],$university_val['uni_email'],$university_val['uni_mobile'],$university_val['update_time'],$university_val['uni_active_status'],$university_val['uni_id']); 
} 
//print_r(($university1));exit; 
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
      <!-- Form grid Start -->
      <div class="pd-20 card-box mb-30">
        <div class="clearfix">
          <div class="pull-left">
            <h4 class="text-blue h4">Approve Universities:</h4>
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