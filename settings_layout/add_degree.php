 <?php  
include "../db_connect.php";
 include "../commen_php.php";
$created_date=$_SESSION["created_date"]; 
$labels=$_SESSION["lbl_data"];

$degree = $db->query("select * from degree"); 
$degree1=$degree->fetchAll(PDO::FETCH_ASSOC);  
$s=0; 
foreach($degree1 as $degreekey => $degree_val){  
  $s++;    
  $tot_datas[]=array($s,$degree_val['degree_type'],$degree_val['degree_name'],$degree_val['degree_id']); 
}   
  
 

 if(isset($_POST['lblids'])){   
  $degree_id= stripQuotes(killChars($_POST['lblids'])); 
  $degree_echo =$db->query("SELECT degree_type,degree_name FROM degree where degree_id='$degree_id'"); 
  $degree_echo1=$degree_echo->fetch(PDO::FETCH_ASSOC); 
  die(json_encode($degree_echo1)); 
} 


if(isset($_POST['degree_type'])){  
  $degree_type= stripQuotes(killChars($_POST['degree_type']));
  $degree_name= stripQuotes(killChars($_POST['degree_name'])); 
  $degree_id= stripQuotes(killChars($_POST['degree_id']));  
  $degree_id_count =($db->query("SELECT * FROM degree where degree_name='$degree_name'")->rowCount()); 

$serial_id=$db->query("SELECT max(id) as ids FROM degree");  
$degree_count=$serial_id->fetchAll(PDO::FETCH_ASSOC)[0]['ids'] + 1;
$degree_count2='degree_'.$degree_count.''; 

try {
    if($degree_id_count=='1'){    
        $query2 = $db->query("UPDATE degree SET degree_type='$degree_type', degree_name='$degree_name', updated_date='$created_date', updated_by='$session_id' WHERE degree_id='$degree_id';");  
        $data2='update'; 
      }else{  
        $query3 = $db->query("INSERT INTO degree(degree_id,degree_type, degree_name,active_status,created_date, created_by)VALUES ('$degree_count2','$degree_type','$degree_name','1','$created_date','$session_id')");
        $data2='insert'; 
      }  
        $error = ($db->errorInfo())[2]; 
} catch (Exception $e) {
    $dataa=$e;
} 
  if(!$error){
    $dataa=$data2;
  }else{
    $dataa='notinsert';
  }  
  die($dataa."~".$error); 
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
            <div class="pull-left">
              <h4 class="text-blue h4">Add Degree</h4>
              <!-- <p class="mb-30">All bootstrap element classies</p> -->
            </div> 
          </div>
           <form id="add_degree">
            <div class="row">
              <div class="col-md-5 col-sm-12">
                <div class="form-group">
                  <label>Degree Type</label> 
                  <select class="custom-select col-12"   name="degree_type" id="degree_type">
                      <option selected="" hidden="true" value="null"><?php echo $labels['choose'];?></option>
                      <option value="Medical" >Medical</option>
                      <option value="Engineering" >Engineering</option>
                      <option value="Arts & Science">Arts & Science </option>
                      <option value="HSC">HSC</option>
                  </select>
                 <!--  <input type="text" class="form-control" name="degree_type" id="degree_type" value="<?php echo $degree_echo1['degree_type'];?>"> -->
                </div>
              </div>
              <div class="col-md-5 col-sm-12">  
                <div class="form-group">
                  <label>Degree Name</label>
                  <input type="text" class="form-control" name="degree_name" id="degree_name" value="<?php echo $degree_echo1['degree_name'];?>">

                   <input type="text" hidden class="form-control" id="degree_id" name="degree_id" >
                </div>
              </div>
              
              <div class="col-md-2 col-sm-12">
                 <div class="form-group">  
                    <button type="button" class="btn btn-primary form_submitbtn_style" id="Editbtn" style="float: right;margin-top: 43%;display: none;">Edit</button>  
                 <button type="button" class="btn btn-primary add_degreebtn form_submitbtn_style" style="margin-top: 43%;">Save</button>  
              </div>  
              </div>  
            </div> 
          </form> 
        </div>
        <!-- Form grid End -->
         <div class="pd-20 card-box mb-30"> 
              <table id="add_degree_table" class="display" width="100%"></table>
        </div> 
        <?php include "../footer.php"; ?> 
    </div>
  </div>
<?php include "../common_js.php";?>
<script type="text/javascript">  
$(".add_degreebtn").on("click",function(e) {  
 var chek_vald = $("#add_degree").valid(); 
         if(chek_vald == true){ 
    var formData = $("#add_degree").serialize();    
    $.ajax({ 
        type:"POST", 
        data:formData, 
        success:function(data){    
          var result = data.replace(/^\s+|\s+$/gm,'');  
          if(result=='insert~'){  
              alert('Data Successfully Insert');
              setTimeout(function() {window.location.reload();}, 1000);  
          }else if(result=='update~'){  
           alert('Data Update Successfully');
           setTimeout(function() {window.location.reload();}, 1000);  
          } else{  
           alert(result);
          }  
        } 
      });  
  }
});  
$("#add_degree").validate({
          rules: {
             degree_type: 
            {
              required: true, 
            }, 
            degree_name: 
            {
              required: true, 
            }, 
            
            
          },
          messages: {
               degree_type: "Please enter Degree Type",
               degree_name: "Please enter Degree Name ",
               
          }, 
}); 
 var dataSet = (<?php echo (json_encode($tot_datas))?>);  console.log(dataSet); 
$(document).ready(function () {  
    $('#add_degree_table').DataTable({
        data: dataSet,
        columns: [
            { title: 'S.No'},   
            { title: 'Degree Type'},
            { title: 'Degree Name '},
            { title: 'Edit',
            'render': function (data, type, full, meta){   
                return '<button type="button" class="btn btn-primary idscls" data-val="'+full[3]+'"><i class="dw dw-eye"></i>View</button>';
            }
             },
            
        ],
    });
}); 
$(document).on('click','.idscls', function(){ 
     $(".disabled").attr('disabled','disabled'); 
    $('#Editbtn').show();  
    $('.add_degreebtn').hide();  
    var idsval=($(this).data('val'));  //alert(idsval);
    $.ajax({ 
        type:"POST", 
        data:{lblids:idsval}, 
        success:function(data){      
          var result = data.replace(/^\s+|\s+$/gm,'');
          if(result !=''){  
            var result1=JSON.parse(result); 
            $('#degree_type').val(result1['degree_type']);
            $('#degree_name').val(result1['degree_name']);
          } 
        } 
      }); 
});  
$(document).on('click','#Editbtn', function(){ 
   $(".disabled").removeAttr('disabled');  
   $('#degree_lbl_name').attr('readonly', true);  
    $('#Editbtn').hide();  
    $('.add_degreebtn').show();
    $('.add_degreebtn').text('Update');  
});
</script> 
</body>
</html>