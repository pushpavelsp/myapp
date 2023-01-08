<?php
include "../db_connect.php";
include "../commen_php.php";
$created_date=date("Y/m/d");
$unique_ids=$_SESSION["unique_ids"];  

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
$pending_count = ($db->query("select * from volunteer where vol_approve_status='0'")->rowCount());
$approve_count = ($db->query("select * from volunteer where vol_approve_status='1'")->rowCount());
$disapprove_count = ($db->query("select * from volunteer where vol_approve_status='2'")->rowCount());

if(isset($_POST["checked_id"])){
  $checked_id=$_POST["checked_id"];
  foreach ($checked_id as $checkedkey => $checkedvalue) {
    
     $UPDATE = $db->query("UPDATE volunteer SET vol_approve_status='1' where vol_id='$checkedvalue'");
  }
  if($UPDATE){
    $dataa='insert';
  }
  die($dataa);
}

//show all detail
$status2=base64_decode($_GET['status']);
if($status2 =='3' ){

  $volunteer_data = $db->query("select v.vol_id, v.$vol_name as vol_name,v.vol_email,v.vol_mobile,deg.degree_name,v.vol_approve_status from volunteer v left join m_degree deg on deg.degree_id=v.vol_degree_id order by v.vol_unique_id asc");
}elseif($status2 ==''){

// //show pending detail 
   $volunteer_data = $db->query("select v.vol_id, v.$vol_name as vol_name,v.vol_email,v.vol_mobile,deg.degree_name,v.vol_approve_status from volunteer v left join m_degree deg on deg.degree_id=v.vol_degree_id where v.vol_approve_status='0'");
 } elseif($status2 !=''){

 //show by selected status detail

  $vol_status=($status2);
  $volunteer_data = $db->query("select v.vol_id,v.vol_name,v.vol_email,v.vol_mobile,deg.degree_name,v.vol_approve_status from volunteer v left join m_degree deg on deg.degree_id=v.vol_degree_id where v.vol_approve_status='$vol_status' order by v.vol_unique_id asc");
 }

$volunteer_data1=$volunteer_data->fetchAll(PDO::FETCH_ASSOC);

 //print_r();exit;
// $volunteer_data = $db->query("select v.vol_id, v.$vol_name as vol_name,v.vol_email,v.vol_mobile,deg.degree_name,v.vol_approve_status from volunteer v left join m_degree deg on deg.degree_id=v.vol_degree_id where v.vol_approve_status='0'");
// $volunteer_data1=$volunteer_data->fetchAll(PDO::FETCH_ASSOC);
 $s=0;
foreach($volunteer_data1 as $key => $volunteer_val){
 $s++;
  $tot_datas[]=array($volunteer_val['vol_id'],$s,$volunteer_val['vol_name'],$volunteer_val['vol_email'],$volunteer_val['vol_mobile'],$volunteer_val['degree_name'],$volunteer_val['vol_approve_status']);
}
/*Volunteer Approve status Dropdown fetch data from db  */
  $status=$db->query("SELECT status_id,status FROM m_approve_status");
$status1=$status ->fetchAll(PDO::FETCH_ASSOC);
foreach ($status1 as $statuskey => $statusvalue) {
  $status_codes[$statusvalue['status_id']]=$statusvalue['status'];
}
//print_r($tot_datas);exit;
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
                <div class="col-md-4 col-sm-12">
                  <h4 class="text-blue h4">Approving Volunteer Details</h4>
                </div>

              
         <div class="col-md-5 col-sm-12">
            <label>Pending</label>
            <span class="badge badge-pill badge-warning"><?php echo $pending_count?></span>
            <label>Approved</label>
            <span class="badge badge-pill badge-success"><?php echo $approve_count?></span>
            <label>Disapproved</label>
            <span class="badge badge-pill badge-danger"><?php echo $disapprove_count?></span>
        </div>
             
                <!-- <div class="pull-right"> -->
                   <div class="col-md-3 col-sm-12">
                  <div class="form-group">
                     <b class="text-blue">Filter Status:</b>
                      <select class="custom-select col-12 font-weight-bold" name="vol_status" id="vol_status" >
                      <?php
                       $statusaa=base64_decode($_GET['status'],true);
                      foreach ($status_codes as $statuskey => $statusvalue) {
                      if($statuskey==$statusaa){  ?>
                        <option selected="" value="<?php echo base64_encode($statuskey);?>"><?php echo $statusvalue;?></option>

                      <?php }else{ ?>
                        <option class="font-weight-bold" value="<?php echo base64_encode($statuskey);?>"><?php echo $statusvalue;?></option>
                      <?php  } } ?>
                    </select>
                  </div>
                </div>
              </div>

          </div>
         
              <table id="university" class="display" width="100%"></table>
              <div class="row">
            <div class="col-sm-12">
              <button type="button" class="btn btn-primary Savebtn">Approve All</button>
            </div>
          </div>
        </div>
        <!-- Form grid End -->

        <?php include "../footer.php"; ?>
    </div>
  </div>
    <?php include "../commen_style.php"; ?>
 <?php include "../common_js.php";?>
<script type="text/javascript">
//Status Drop down value get
$("#vol_status").on("change",function(e) {
 var chek_vald = $("#vol_status").val(); //alert(chek_vald);
      window.location.href="approve_volunteer.php?status="+chek_vald+"";
});
 var dataSet = (<?php echo (json_encode($tot_datas))?>);console.log(dataSet);
$(document).ready(function () {
    $('#university').DataTable({
        data: dataSet,
        columns: [
            { title: '<input type="checkbox" name="ids" class="checkboxall">',
            'render': function (data, type, full, meta){
                return '<input type="checkbox" class="checkboxval" value="'+full[0]+'">';
            }
             },
            { title: 'S.No.'},
            { title: 'Name'},
            { title: 'Email ID'},
            { title: 'Mobile No.'},
            { title: 'Course'},
            { title: 'Status',
            'render': function (data, type, full, meta){
           var checkbox_val=full[6];
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
           }else if(checkbox_val ==2){
             var  checkbox_color="red";
             var checkbox_val="Disapproved";
            }
            return '<label style="color:'+checkbox_color+'"><b>'+checkbox_val+'</b></label>';
          }


          },
            { title: 'View',
            'render': function (data, type, full, meta){
                return '<form  action="<?php echo Base_url;?>po_officer/view_volunteer.php" method="POST"><input hidden type="text" name="ids1" value="'+full[0]+'"><button type="submit" class="btn btn-primary"><i class="dw dw-eye"></i>View</button></form>';
              }
          },
          { title: 'Print',
         'render': function (data, type, full, meta){
             return '<form  action="<?php echo Base_url;?>po_officer/volunteer_pdf_view.php" method="POST"><input hidden type="text" name="ids" value="'+full[0]+'"><button type="submit" class="btn btn-primary"><i class="fa fa-download"></i></button></form>';
         }

          },
        ],
    });
});

 $(document).on('click','.checkboxall',function(){
  if ($('input.checkboxall').is(':checked')) {
     $('.checkboxval').attr( 'checked', true );
  }else{
     $('.checkboxval').attr( 'checked', false );
  }
 });

var quotations = [];
 $(document).on('click','.Savebtn',function(){
    $( ".checkboxval" ).each(function(index) {
      if ($(this).is(':checked')) {
          var dsfd=$(this).val();
          quotations.push(dsfd);
      }
    });
     Swal.fire({
      title: 'Do you want to save the changes?',
      showDenyButton: true,
      showCancelButton: true,
      confirmButtonText: 'Approve',
      denyButtonText: 'Disapprove',
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire('Approved!', '', 'success')
         $.ajax({
        type:'POST',
        data:{checked_id:quotations},
        success:function(data){
          if(data=='insert'){
            setTimeout(function() {window.location.reload();}, 1000);
          }
          }
        });
      } else if (result.isDenied) {
        Swal.fire('Disapproved', '', 'info')
      }
    })
 });

 // console.log(quotations);


    </script>

</body>
</html>
