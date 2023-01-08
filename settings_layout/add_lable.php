<?php  
include "../db_connect.php";
 include "../commen_php.php";
$created_date=date("Y/m/d");
$labels=$_SESSION["lbl_data"];
  
$label = $db->query("select * from m_labels");
$label1=$label->fetchAll(PDO::FETCH_ASSOC);
$s=0;
foreach($label1 as $labelkey => $label_val){
  $s++;
  $tot_datas[]=array($s,$label_val['tamil'],$label_val['english'],$label_val['lbl_name']);
}

if(isset($_POST['lblids'])){   
  $lbls=trim($_POST['lblids']); //print_r($lbls);exit;
 
  $label_echo =$db->query("SELECT tamil,english,lbl_name  FROM m_labels where lbl_name='$lbls'");
  $label_echo2=$label_echo->fetch(PDO::FETCH_ASSOC); 
  die(json_encode($label_echo2));
}


if(isset($_POST['Name_English'])){
  $Name_English= $_POST['Name_English'];
  $Name_Tamil= $_POST['Name_Tamil'];
  $Lable_Name= $_POST['Lable_Name'];

  $uni_id_count =($db->query("SELECT * FROM m_labels where lbl_name='$Lable_Name'")->rowCount());

try {
    if($uni_id_count=='1'){

        $query2 = $db->query("UPDATE m_labels SET tamil='$Name_Tamil', english='$Name_English', active_status='1', updated_date='$created_date', updated_by='$session_id' WHERE lbl_name='$Lable_Name';");
        $data2='update';
      }else{

        $rs = $db->query("INSERT INTO m_labels(tamil, english, lbl_name,active_status,created_date, created_by)VALUES ('$Name_Tamil','$Name_English','$Lable_Name','1','$created_date','$session_id')");
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
              <h4 class="text-blue h4">Add Lable</h4>
              <!-- <p class="mb-30">All bootstrap element classies</p> -->
            </div>
          </div>
           <form id="addlable">
            <div class="row">
              <div class="col-md-3 col-sm-12">
                <div class="form-group">
                  <label>Name English<span class="required_symbol"> *</span></label>
                  <input type="text" class="form-control" name="Name_English" id="Name_English" value="<?php echo $label_echo2['tamil'];?>">
                </div>
              </div>
              <div class="col-md-3 col-sm-12">
                <div class="form-group">
                  <label>Name Tamil<span class="required_symbol"> *</span></label>
                  <input type="text" class="form-control" name="Name_Tamil" id="Name_Tamil" value="<?php echo $label_echo2['english'];?>">
                </div>
              </div>
              <div class="col-md-3 col-sm-12">
                <div class="form-group">
                  <label>Lable Name<span class="required_symbol"> *</span></label>
                  <input type="text" class="form-control"  name="Lable_Name" onchange="check_countdata(this.value,'label','lbl_name','Lable_Name');" id="Lable_Name" value="<?php echo $label_echo2['lbl_name'];?>">
                </div>
              </div>
              <div class="col-md-1 col-sm-12">
                 <div class="form-group">
                    <!-- <button type="button" class="btn btn-primary form_submitbtn_style" id="Editbtn" style="float: right;margin-top: 43%;display: none;">Edit</button> -->
                 <button type="button" class="btn btn-primary addlablebtn form_submitbtn_style" style="margin-top: 43%;">Save</button>
              </div>
              </div>
            </div>
          </form>
        </div>
        <!-- Form grid End -->
         <div class="pd-20 card-box mb-30">
              <table id="addlable_table" class="display" width="100%"></table>
        </div>
        <?php include "../footer.php"; ?>
    </div>
  </div>
<?php include "../common_js.php";?>
<script type="text/javascript">
$("#Name_English").focusout(function(){
  translate('Name_English','Name_Tamil');
});

$(".addlablebtn").on("click",function(e) {
 var chek_vald = $("#addlable").valid();
         if(chek_vald == true){
    var formData = $("#addlable").serialize();
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
$("#addlable").validate({
          rules: {
             Name_English:
            {
              required: true,
            },
            Name_Tamil:
            {
              required: true,
            },
            Lable_Name:
            {
              required: true,
            },
          },
          messages: {
               Name_English: "Please enter Lable Name Tamil",
               Name_Tamil: "Please enter Lable Name English",
               Lable_Name: "Please enter Lable Name",
          },
});
 var dataSet = (<?php echo (json_encode($tot_datas))?>);
$(document).ready(function () {
    $('#addlable_table').DataTable({
        data: dataSet,
        columns: [
            { title: 'S.No'},
            { title: 'Name Tamil'},
            { title: 'Name English'},
            { title: 'Lable Name'},
            { title: 'Edit',
            'render': function (data, type, full, meta){
                return '<button type="button" class="btn btn-primary idscls" data-val="'+full[3]+'"><i class="dw dw-eye"></i>View</button>';
            }
             },

        ],
    });
});
$('#Lable_Name').attr('readonly', false);
$(document).on('click','.idscls', function(){  
    $('.addlablebtn').text('Update');
    var idsval=($(this).data('val')); //alert(idsval);
    $.ajax({
        type:"POST",
        data:{lblids:idsval},
        success:function(data){
          var result = data.replace(/^\s+|\s+$/gm,'');
          if(result !=''){ 
            var result1=JSON.parse(result);
            $('#Lable_Name').attr('readonly', true);
            $('#Name_English').val(result1['english']);
            $('#Name_Tamil').val(result1['tamil']);
            $('#Lable_Name').val(result1['lbl_name']);
          }
        }
      });
}); 
</script>
</body>
</html>
