<?php   
include "../db_connect.php";
include "../commen_php.php";
if($_SESSION['unique_ids']==''){    
  header('Location:'.$Base_url21.'login_page.php');  
}
$ip=$_SERVER['REMOTE_ADDR']; 
/*$created_date=date("Y/m/d"); */
$created_date=$_SESSION["created_date"]; 
$unique_ids=$_SESSION["unique_ids"]; 
$langtype=$_SESSION["langtype"];
if($langtype==1){
  $districtname= "district_tname";
  $poname= "po_name_tamil";
  $unit_type= "unit_type_tamil";
}elseif($langtype==2){
  $districtname= "district_name";
  $poname= "po_name";
  $unit_type= "unit_type";
}else{
  $districtname= "district_tname";
  $poname= "po_name_tamil";
  $unit_type= "unit_type_tamil";
}    
        
   
if(isset($_POST['progrm_ofc'])){  //print_r($_POST);exit;
  /*$ofc_mailid= stripQuotes(killChars(trim($_POST['ofc_mailid']))); 
  $ofc_contact_no= stripQuotes(killChars(trim($_POST['ofc_contact_no']))); */ 
  $progrm_ofc=$_POST['progrm_ofc'];  
  foreach ($progrm_ofc as $progrm_ofckey => $progrm_ofcvalue) {  
     $progrm_ofc3=$_POST['progrm_ofc'][$progrm_ofckey];
      $unit_type3=$_POST['unit_type'][$progrm_ofckey];  
      $no_of_volunteer_boys3=$_POST['no_of_volunteer_boys'][$progrm_ofckey];   
      $no_of_volunteer_girls3=$_POST['no_of_volunteer_girls'][$progrm_ofckey];  
      $unitids3=$_POST['unitid'][$progrm_ofckey]; 

$progrm_ofc= stripQuotes(killChars(trim($progrm_ofc3)));
$unit_type= stripQuotes(killChars(trim($unit_type3)));
$no_of_volunteer_boys= stripQuotes(killChars(trim($no_of_volunteer_boys3)));
$no_of_volunteer_girls= stripQuotes(killChars(trim($no_of_volunteer_girls3)));
$unitids= stripQuotes(killChars(trim($unitids3)));


    if($progrm_ofcvalue !='' && $unit_type !=''){
      if($unitids !=''){   
       // print_r();print_r('<br>'); 
        $query1 = $db->query("UPDATE college_nss_details SET clg_nss_mailid='$ofc_mailid',unit_type='$unit_type',clg_nss_contact='$ofc_contact_no',po_id='$progrm_ofc',no_of_boys='$no_of_volunteer_boys',no_of_girls='$no_of_volunteer_girls',created_by='$unique_ids',created_time='now()',created_ip='$ip' WHERE clg_id='$unique_ids' and unit_id='$unitids';");
      }else{ 
        // print_r();print_r('<br>'); 
        $query1 = $db->query("INSERT INTO college_nss_details(clg_id,clg_nss_mailid, clg_nss_contact, po_id, unit_type, no_of_boys, no_of_girls, created_by, created_time, created_ip)VALUES ('$unique_ids','$ofc_mailid','$ofc_contact_no','$progrm_ofc','$unit_type','$no_of_volunteer_boys','$no_of_volunteer_girls','$unique_ids','now()','$ip');"); 
      } 
    }  
  } 
  if($query1){
      $dataa='save';
  }
  //print_r($querysdsd);exit;
  die($dataa);
} 
$po_data=$db->query("SELECT po_id,$poname as poname  from po_officer");  
$po_data1=$po_data->fetchAll(PDO::FETCH_ASSOC); 
 
$unit_type=$db->query("SELECT unit_type_id,$unit_type as unit_type  from unit_type");  
$unit_type1=$unit_type->fetchAll(PDO::FETCH_ASSOC);  

$college = $db->query("SELECT * from college where clg_id='$unique_ids'"); 
$college_echo=$college->fetch(PDO::FETCH_ASSOC)['tot_num_unit'];


$college_nss_details = $db->query("SELECT * from college_nss_details where clg_id='$unique_ids'"); 
$nss_details_echo=$college_nss_details->fetchAll(PDO::FETCH_ASSOC);  
//print_r($nss_details_echo[0]);exit;

if(isset($_POST['dltids'])){
  $dltids= stripQuotes(killChars(trim($_POST['dltids']))); 
 
$dlt_qur = $db->query("DELETE FROM college_nss_details WHERE unit_id='$dltids';"); 
  if($dlt_qur){
      $data='dlt';
  }
  die($data);
}

 
?> 

<!DOCTYPE html>
<html>
<?php include "../head.php"; ?>  
<style type="text/css">
  .boxshadow2 {
    padding: 22px;
  box-shadow: 0 0 28px rgb(0 0 0 / 22%);
}
.required_icon{
    color: red;
}
</style>
<body> 
<?php include "../header.php"; ?> 
  <?php include "../left_menu.php"; ?> 
  <div class="mobile-menu-overlay"></div> 
  <div class="main-container">
  <div class="pd-ltr-20"> 
  <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page" href="">College NSS Details</li>
  </ol>
</nav>
    <div class="container pd-20 card-box mb-30">
    <div class="clearfix">
          <div class="pull-left">
            <h4 class="text-blue h4"><?php echo $labels['lbl_college_nss_details'];?></h4>
            <!-- <p class="mb-30">All bootstrap element classies</p> -->
          </div> 
        </div>  
  <form id="clg_nss_form">  
     <!--  <div class="row">   
     <div class="col-md-6 col-sm-12">
      <div class="form-group">
        <label><?php //echo $labels['ofc_nss_mailid'];?><span class="required_icon">*</span></label>
        <input type="text" class="form-control emailcls mailcls"  id="ofc_mailid" name="ofc_mailid" onchange="check_countdata(this.value,'college_nss_details','clg_nss_mailid','ofc_mailid','mailpassword');mailvalid('ofc_mailid');" value="<?php //echo $nss_details_echo[0]['clg_nss_mailid'];?>">
        <span id="lblofc_mailid" class="required_error_msg"></span>
      </div>
    </div> 
    <div class="col-md-6 col-sm-12">
      <div class="form-group">
        <label><?php //echo $labels['ofc_contact_no'];?><span class="required_icon">*</span></label>
        <input type="text" class="form-control" name="ofc_contact_no" maxlength="10" onkeypress="return isNumber(event);" id="ofc_contact_no" onchange="check_countdata(this.value,'university','ofc_contact_no','ofc_contact_no');" value="<?php //echo $nss_details_echo[0]['clg_nss_contact'];?>" onkeyup="firstnumvalid(this.value,'ofc_contact_no');" maxlength="10" onkeypress="return isNumber(event);"> 
        <span id="lblofc_contact_no" class="required_error_msg"></span>
      </div> 
    </div>     
  </div>   -->  
    
   <div class="view_append_data">  
  </div> 
  
   <div class="view_append">  
  </div> 
  
  <div class="row"> 
    <div class="col-sm-12">  
       <button type="submit" class="btn btn-primary form_submitbtn_style">Save</button>  
    </div> 
  </div>   
</form> 
    </div>
  </div>
  </div>
   <?php include "../footer.php"; ?>
  <?php include "../common_js.php";?>  
  <script type="text/javascript">
var clgid='<?php echo $unique_ids?>';  
var college_tot_unit=<?php echo json_encode($college_echo)?>; 
 //console.log(college_tot_unit);
var nss_details1=<?php echo json_encode($nss_details_echo)?>;
var po_data_echo1=<?php echo json_encode($po_data1)?>; 
var unit_type_echo1=<?php echo json_encode($unit_type1)?>;   
 //console.log(nss_details_echo);console.log('<br>');
 if(nss_details1 !=''){ 

var view_append_data='';
   for (var totkey in nss_details1) { 
      var po_id_echo=nss_details1[totkey]['po_id'];
      var unit_type_echo=nss_details1[totkey]['unit_type'];
      var no_of_boys_echo=nss_details1[totkey]['no_of_boys'];
      var no_of_girls_echo=nss_details1[totkey]['no_of_girls'];
      var unit_id_echo=nss_details1[totkey]['unit_id'];
      
var poselect22='';   
     poselect22 +='<option value="">Select</option>';
for (var key_echo1 in po_data_echo1) { 
  if(po_id_echo==po_data_echo1[key_echo1]['po_id']){
     poselect22 +='<option value="'+po_data_echo1[key_echo1]['po_id']+'" selected>'+po_data_echo1[key_echo1]['poname']+'</option>';
  }else{
     poselect22 +='<option value="'+po_data_echo1[key_echo1]['po_id']+'">'+po_data_echo1[key_echo1]['poname']+'</option>';
  } 
}   

var selunit_type22=''; //console.log(unit_type2);
 selunit_type22 +='<option value="">Select</option>';
for (var unitkey2 in unit_type_echo1) {   
   if(unit_type_echo==unit_type_echo1[unitkey2]['unit_type_id']){ 
     selunit_type22 +='<option value="'+unit_type_echo1[unitkey2]['unit_type_id']+'" selected>'+unit_type_echo1[unitkey2]['unit_type']+'</option>';
  }else{
     selunit_type22 +='<option value="'+unit_type_echo1[unitkey2]['unit_type_id']+'">'+unit_type_echo1[unitkey2]['unit_type']+'</option>';
  }
}
      view_append_data +='<div class="row removebtn22'+totkey+'"><div class="col-md-3 col-sm-12"><input name="unitid[]" value="'+unit_id_echo+'" hidden><div class="form-group"><label><?php echo $labels['sel_progrm_ofc'];?><span class="required_icon">*</span></label><select class="custom-select col-12" name="progrm_ofc[]" id="progrm_ofc">'+poselect22+'</select></div></div><div class="col-md-2 col-sm-12"><div class="form-group"><label><?php echo $labels['select_unit'];?><span class="required_icon">*</span></label><select class="custom-select col-12" name="unit_type[]" id="unit_type">'+selunit_type22+'</select></div></div><div class="col-md-3 col-sm-12"><div class="form-group"><label><?php echo $labels['no_of_volunteer_boys'];?><span class="required_icon">*</span></label><input type="text" class="form-control" name="no_of_volunteer_boys[]" maxlength="4" onkeypress="return isNumber(event)" id="no_of_volunteer_boys" value="'+no_of_boys_echo+'"><span id="lblno_of_volunteer_boys" class="required_error_msg"></span></div></div><div class="col-md-3 col-sm-12"><div class="form-group"><label><?php echo $labels['no_of_volunteer_girls'];?><span class="required_icon">*</span></label><input type="text" class="form-control" name="no_of_volunteer_girls[]" maxlength="4" onkeypress="return isNumber(event)" id="no_of_volunteer_girls" value="'+no_of_girls_echo+'"><span id="lblno_of_volunteer_girls" class="required_error_msg"></span></div></div><div class="col-md-1 col-sm-12" style="margin-top:2%"><button type="button" class="btn btn-primary removebtn22"  data-val22="'+totkey+'" data-dlt="'+unit_id_echo+'"><i class="icon-copy fi-trash" aria-hidden="true"></i></button></div></div>';
   }
  $(".view_append_data").html(view_append_data);   
 }

$(document).on('click','.removebtn22',function(){ 
  var dltdata=$(this).data('dlt');/* 
  var romoveitem22=$(this).data('val22');
  $(".removebtn22"+romoveitem22+"").remove();*/
Swal.fire({
  title: 'Do you want to Delete This unit?',
  showDenyButton: true,
  showCancelButton: true,
  confirmButtonText: 'Delete',
  denyButtonText: 'No',
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
     Swal.fire('Conform!', '', 'success')   
       $.ajax({ 
        type:'POST',  
        data:{dltids:dltdata},
        success:function(data){   //alert(data); 
          if(data=='dlt'){ 
            setTimeout(function() {window.location.reload();}, 1000);  
          }
        } 
      }); 
  } else if (result.isDenied) {
    Swal.fire('No', '', 'info') 
  }
}) 
});

var po_data1=<?php echo json_encode($po_data1)?>;
    var poselect='';
     poselect +='<option value="">Select</option>';
for (var key in po_data1) { 
   poselect +='<option value="'+po_data1[key]['po_id']+'">'+po_data1[key]['poname']+'</option>';
}
 //console.log(poselect);  
var unit_type1=<?php echo json_encode($unit_type1)?>;
    var selunit_type='';
    selunit_type +='<option value="">Select</option>';
for (var key2 in unit_type1) {  
   selunit_type +='<option value="'+unit_type1[key2]['unit_type_id']+'">'+unit_type1[key2]['unit_type']+'</option>';
}

//first time append  
var totkey_1=typeof(totkey); 
var firstone=1;  
var first_time_limt_ap=(parseInt(totkey)+parseInt(firstone)); 
if(college_tot_unit > first_time_limt_ap || totkey_1=='undefined'){  
$(".view_append").html('<div class="row"><div class="col-md-3 col-sm-12"><input name="unitid[]" hidden><div class="form-group"><label><?php echo $labels['sel_progrm_ofc'];?><span class="required_icon">*</span></label><select class="custom-select col-12" name="progrm_ofc[]" id="progrm_ofc">'+poselect+'</select></div></div><div class="col-md-2 col-sm-12"><div class="form-group"><label><?php echo $labels['select_unit'];?><span class="required_icon">*</span></label><select class="custom-select col-12" name="unit_type[]" id="unit_type">'+selunit_type+'</select></div></div><div class="col-md-3 col-sm-12"><div class="form-group"><label><?php echo $labels['no_of_volunteer_boys'];?><span class="required_icon">*</span></label><input type="text" class="form-control" name="no_of_volunteer_boys[]" maxlength="4" onkeypress="return isNumber(event)" id="no_of_volunteer_boys" value="<?php echo $university_nss_echo['uni_nss_contact'];?>"><span id="lblno_of_volunteer_boys" class="required_error_msg"></span></div></div><div class="col-md-3 col-sm-12"><div class="form-group"><label><?php echo $labels['no_of_volunteer_girls'];?><span class="required_icon">*</span></label><input type="text" class="form-control" name="no_of_volunteer_girls[]" maxlength="4" onkeypress="return isNumber(event)" id="no_of_volunteer_girls"><span id="lblno_of_volunteer_girls" class="required_error_msg"></span></div></div><div class="col-sm-1"><button type="button" class="btn btn-primary appendcls" style="margin-top: 33px;"><i class="icon-copy fi-plus"></i></button></div></div>');
}
var c=1
$(".appendcls").on('click',function(){
 c++;     
 if (typeof totkey !='undefined' && totkey !=''){
  var totkey12=parseInt(totkey)+parseInt(c); 
  var totkey1=totkey12+1; 
 }else{
  var totkey1=c;  
 }
  //console.log(totkey1); 
  var totkey2=totkey1; 

  if(college_tot_unit >= totkey2){
       $(".view_append").append('<div class="row removediv'+totkey1+'"><input name="unitid[]" hidden><div class="col-md-3 col-sm-12"><div class="form-group"><label><?php echo $labels['sel_progrm_ofc'];?><span class="required_icon">*</span></label><select class="custom-select col-12" name="progrm_ofc[]" id="progrm_ofc">'+poselect+'</select></div></div><div class="col-md-2 col-sm-12"><div class="form-group"><label><?php echo $labels['select_unit'];?><span class="required_icon">*</span></label><select class="custom-select col-12" name="unit_type[]" id="unit_type">'+selunit_type+'</select></div></div><div class="col-md-3 col-sm-12"><div class="form-group"><label><?php echo $labels['no_of_volunteer_boys'];?><span class="required_icon">*</span></label><input type="text" class="form-control" name="no_of_volunteer_boys[]" maxlength="4" onkeypress="return isNumber(event)" id="no_of_volunteer_boys" value="<?php echo $university_nss_echo['uni_nss_contact'];?>"><span id="lblno_of_volunteer_boys" class="required_error_msg"></span></div></div><div class="col-md-3 col-sm-12"><div class="form-group"><label><?php echo $labels['no_of_volunteer_girls'];?><span class="required_icon">*</span></label><input type="text" class="form-control" name="no_of_volunteer_girls[]" maxlength="4" onkeypress="return isNumber(event)" id="no_of_volunteer_girls"><span id="lblno_of_volunteer_girls" class="required_error_msg"></span></div></div><div class="col-md-1 col-sm-12" style="margin-top:2%"><button type="button" class="btn btn-primary removebtn"  data-val="'+totkey1+'"><i class="icon-copy fi-trash" aria-hidden="true"></i></button></div></div>'); 
  } 
});
   
$(document).on('click','.removebtn',function(){ 
  var romoveitem=$(this).data('val');
  $(".removediv"+romoveitem+"").remove();  
});

$("#clg_nss_form").on("submit",function(e) {  
/* var chek_vald = $("#clg_nss_form").valid(); 
         if(chek_vald == true){  */
    var formData = new FormData(this);     
    $.ajax({ 
        type:"POST", 
        data:formData, 
        success:function(data){  
          var result =(data.replace(/^\s+|\s+$/gm,''));  
          //alert(result); 
         if(result=="save"){   
            toastr.success('Data Save Successfully');  
            setTimeout(function() {window.location.reload();}, 1000);  
          }else{   
           toastr.error('Data Not Saved');    
          } 
        }, 
          cache: false,
          contentType: false,
          processData: false 
      });    
   // } 
   e.preventDefault();
    }); 
  </script>
</body>
</html>