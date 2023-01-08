<?php
include "../db_connect.php";
include "../commen_php.php";
$created_date=date("Y/m/d");
$labels=$_SESSION["lbl_data"];
//$unique_ids=$_SESSION["unique_ids"];
//show all detail
$statusaa=base64_decode($_GET['status'],true);
if($statusaa =='3' ){

  $query_data = $db->query("select v.vol_unique_id,v.vol_name,v.vol_email,v.vol_mobile,deg.degree_name,v.vol_approve_status from volunteer v left join m_degree deg on deg.degree_id=v.vol_degree_id order by v.vol_unique_id asc");
}elseif($statusaa==''){

// //show pending detail
  $vol_status=($_GET['status']);
   $query_data = $db->query("select v.vol_unique_id,v.vol_name,v.vol_email,v.vol_mobile,deg.degree_name,v.vol_approve_status from volunteer v left join m_degree deg on deg.degree_id=v.vol_degree_id where v.vol_approve_status='0' order by v.vol_unique_id asc");
 } elseif($statusaa !=''){

 //show by selected status detail

  $vol_status=($statusaa);
  $query_data = $db->query("select v.vol_unique_id,v.vol_name,v.vol_email,v.vol_mobile,deg.degree_name,v.vol_approve_status from volunteer v left join m_degree deg on deg.degree_id=v.vol_degree_id where v.vol_approve_status='$vol_status' order by v.vol_unique_id asc");
 }

$fetch_query=$query_data->fetchAll(PDO::FETCH_ASSOC);

 $s=0;
foreach($fetch_query as $key => $val){
 $s++;
  $tot_datas[]=array($s,$val['vol_unique_id'],$val['vol_name'],$val['vol_email'],$val['vol_mobile'],$val['degree_name'],$val['vol_approve_status']);
}

/*Volunteer Approve status Dropdown fetch data from db  */
  $status=$db->query("SELECT status_id,status FROM m_approve_status");
$status1=$status ->fetchAll(PDO::FETCH_ASSOC);
foreach ($status1 as $statuskey => $statusvalue) {
  $status_codes[$statusvalue['status_id']]=$statusvalue['status'];
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

        <!-- Form grid Start -->
        <div class="pd-20 card-box mb-30">
          <div class="clearfix">
            <div class="row">
              <div class="col-md-6 col-sm-12">

              <h4 class="text-blue h4">Approve Volunteers</h4>

              </div>
           <!--  </div>  -->
            <!--Pending & Approved Radio button -->
           <div class="col-md-3 col-sm-12">
  <label class="font-weight-bold text-blue" style="float: right;">Volunteer Status:<?php echo $labels['vol_status'];?> </label>
</div>
            <!-- <div class="pull-right"> -->
               <div class="col-md-3 col-sm-12">
              <div class="form-group">
                  <select class="custom-select col-12 font-weight-bold" name="vol_status" id="vol_status" >
                  <?php 
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
              <table id="volunteer_table" class="display" width="100%"></table>
        </div>
        <!-- Form grid End -->


    </div>
  </div>
  <?php include "../footer.php"; ?>
    <?php include "../commen_style.php"; ?>


 <?php include "../common_js.php";?>
 <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script type="text/javascript">

//Status Drop down value get
$("#vol_status").on("change",function(e) {
 var chek_vald = $("#vol_status").val(); //alert(chek_vald);
      window.location.href="approve_volunteer.php?status="+chek_vald+"";
});

//Data Table
 var dataSet = (<?php echo (json_encode($tot_datas))?>);  /// console.log(dataSet);

$(document).ready(function () {
    $('#volunteer_table').DataTable({
        data: dataSet,
        columns: [
            { title: 'S.No'},
            { title: 'Name'},
            { title: 'Email'},
            { title: 'Mobile'},
            { title: 'Course'},
            { title: 'Status',
            'render': function (data, type, full, meta){
             let  checkbox_val=full[6] =="1" ? "checked" : "";
             let check_1=full[6];
             var checkbox_color;
            if(check_1==1)
              {
                //Green Color
                var  checkbox_color=" #2C6700";
             }else if(check_1 ==0)
             {
               var  checkbox_color="Orange";
             }else{
               var  checkbox_color="red";
              }
                return '<label class="switch"><input type="checkbox" class="stauscls" data-id="'+full[1]+'" '+checkbox_val+' data-loginmail="'+full[2]+'" '+checkbox_val+'><span class="slider round" style="background-color:'+checkbox_color+'"></span></label>';
            }
             },
            { title: 'View',
            'render': function (data, type, full, meta){
                return '<form  action="<?php echo Base_url;?>volunteer/view_volunteer.php" method="POST"><input hidden type="text" name="ids" value="'+full[1]+'"><button type="submit" class="btn btn-primary"><i class="dw dw-eye"></i>View</button></form>';
            }

             },
             { title: 'Print',
            'render': function (data, type, full, meta){
                return '<form  action="<?php echo Base_url;?>volunteer/pdf_view.php" method="POST"><input hidden type="text" name="ids" value="'+full[1]+'"><button type="submit" class="btn btn-primary"><i class="fa fa-download"></i></button></form>';
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
  confirmButtonColor: "#005A04",
  cancelButtonColor:"#003399",
  confirmButtonText: 'Approve',
  denyButtonText: 'Disapprove',
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
    status_switch('1','volunteer','vol_approve_status','vol_unique_id',updateid);
    login_approve_status('1','login_details','approve_status','email',loginmaill);
    Swal.fire('Approved!', '', 'success')
  } else if (result.isDenied) {
    Swal.fire('Disapprove', '', 'info')
    status_switch('2','volunteer','vol_approve_status','vol_unique_id',updateid);
    login_approve_status('2','login_details','approve_status','email',loginmaill);
  }
})
});


</script>
</body>
</html>
