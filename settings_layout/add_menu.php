<?php  
include "../db_connect.php";
 include "../commen_php.php";
$created_date=date("Y/m/d");
$labels=$_SESSION["lbl_data"];

if(isset($_SESSION["langtype"])){
  $langtypee=$_SESSION["langtype"] ? $_SESSION['langtype'] : '1';
}else{
  $langtypee=1;
}
 
if($langtypee=='1'){ 
  $level_name= "level_name_tamil";  
}elseif($langtypee=='2'){ 
  $level_name= "level_name_english"; 
}else{
  $level_name= "level_name_tamil";  
}

$first_menu = $db->query("select level_code,$level_name as level_name from m_first_level_menu where active_status='1'");   
 $first_menu1=$first_menu->fetchAll(PDO::FETCH_ASSOC); 
 

$menu = $db->query("select * from m_menu_field"); 
$menu1=$menu->fetchAll(PDO::FETCH_ASSOC); 
$s=0; 
foreach($menu1 as $menukey => $menu_val){  
  $s++;    
  $tot_datas[]=array($s,$menu_val['menu_name'],$menu_val['menu_name_tamil'],$menu_val['menu_url'],$menu_val['level_code'],$menu_val['menu_id']); 
}   

  

if(isset($_POST['lblids'])){ 
  $lblids= stripQuotes(killChars($_POST['lblids']));   
  $menu_echo =$db->query("SELECT menu_name,menu_name_tamil,menu_url,level_code FROM m_menu_field where menu_id='$lblids'"); 
  $menu_echo2=$menu_echo->fetch(PDO::FETCH_ASSOC); 
  die(json_encode($menu_echo2));  
}


if(isset($_POST['menu_name'])){   
  $lblids= stripQuotes(killChars($_POST['lblids']));  
  $menu_name= stripQuotes(killChars($_POST['menu_name']));
  $menu_name_tamil= stripQuotes(killChars($_POST['menu_name_tamil']));
  $menu_url= stripQuotes(killChars($_POST['menu_url'])); 
  $level_code= stripQuotes(killChars($_POST['level_code']));  
  $menu_id= stripQuotes(killChars($_POST['menu_id']));  
// print_r();exit;
  if($menu_id !=''){
    $datas = $db->query("UPDATE m_menu_field SET menu_name='$menu_name', menu_name_tamil='$menu_name_tamil',menu_url='$menu_url',level_code='$level_code', active_status='1',updated_date=now(), updated_by='$session_id' WHERE menu_id='$menu_id'");  
    $data2='update'; 
  }else{

    $datas = $db->query("INSERT INTO m_menu_field(menu_name, menu_name_tamil, menu_url,level_code,active_status,created_date, created_by)VALUES ('$menu_name','$menu_name_tamil','$menu_url','$level_code','1','$created_date','$session_id')");
    $data2='insert'; 
  }
   
  if($datas){
    $dataa=$data2;
  }else{
    $dataa='notinsert';  
  }  
  die($dataa); 
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
              <h4 class="text-blue h4">Add Menu Field</h4>
            
            </div> 
          </div>
           <form id="addmenu">
            <div class="row">
                <div class="col-md-3 col-sm-12">
                <div class="form-group">
                  <label>Level Name<span class="required_symbol"> *</span></label>
                    <select class="custom-select col-12" name="level_code" id="level_code"> 
                  <option value="" hidden="true">Select University</option>   
                  <?php
                  foreach ($first_menu1 as $first_menu1key => $first_menu1value) { ?> 
                      <option  value="<?php echo $first_menu1value['level_code'];?>"><?php echo $first_menu1value['level_name'];?></option>   
                    <?php  
                  }
                  ?> 
                </select> 
                </div>
              </div>
              <div class="col-md-3 col-sm-12">
                <div class="form-group">
                  <label>Menu Name<span class="required_symbol"> *</span></label>
                  <input type="text" class="form-control" name="menu_name" id="menu_name" value="<?php echo $menu_echo2['menu_name'];?>">
                </div>
              </div>
              <div class="col-md-3 col-sm-12">
                <div class="form-group">
                  <label>Menu Name Tamil<span class="required_symbol"> *</span></label>
                  <input type="text" class="form-control" name="menu_name_tamil" id="menu_name_tamil" value="<?php echo $menu_echo2['menu_name_tamil'];?>">
                </div>
              </div>
            <!-- </div>
            <div class="row"> -->
              <div class="col-md-3 col-sm-12">
                <div class="form-group">
                  <label>Menu URL<span class="required_symbol"> *</span></label>
                  <input type="text" class="form-control" name="menu_url" id="menu_url" value="<?php echo $menu_echo2['menu_url'];?>">
                </div>
              </div> 
            <!-- </div>
            <div class="row"> -->
              <div class="col-md-6 col-sm-12">                 
                 <input type="text" hidden class="form-control" id="menu_id" name="menu_id" >
</div>
               <div class="col-md-5 col-sm-12"></div>
              <div class="col-md-1 col-sm-12">
                 <div class="form-group">
                   <!--  <button type="button" class="btn btn-primary form_submitbtn_style" id="Editbtn" style="float: right;margin-top: 43%;display: none;">Edit</button> -->
                 <button type="button" class="btn btn-primary addmenubtn form_submitbtn_style" style="margin-top: 43%;">Save</button>
              </div>
              </div>
            </div>
          </form>
        </div>
        <!-- Form grid End -->
         <div class="pd-20 card-box mb-30"> 
              <table id="addmenu_table" class="display" width="100%"></table>
        </div> 
        <?php include "../footer.php"; ?> 
    </div>
  </div>
<?php include "../common_js.php";?>
<script type="text/javascript"> 
  
//English to tamil translate

  $("#menu_name").focusout(function(){    
      translate('menu_name','menu_name_tamil'); 
    })

$(".addmenubtn").on("click",function(e) {  
 var chek_vald = $("#addmenu").valid(); 
         if(chek_vald == true){ 
    var formData = $("#addmenu").serialize();    
    $.ajax({ 
        type:"POST", 
        data:formData, 
        success:function(data){      
          var result = data.replace(/^\s+|\s+$/gm,'');  
          if(result=='insert'){  
              alert('Data Successfully Insert');
              setTimeout(function() {window.location.reload();}, 1000);  
          }else if(result=='update'){  
           alert('Data Update Successfully');
           setTimeout(function() {window.location.reload();}, 1000);  
          } else{  
            alert('Data not Insert');
          }  
        } 
      });  
  }
});  
$("#addmenu").validate({
          rules: {
             menu_name: 
            {
              required: true, 
            }, 
            menu_name_tamil: 
            {
              required: true, 
            },  
            menu_url: 
            {
              required: true, 
            },
            level_code: 
            {
              required: true, 
            }, 
          },
          messages: {
               menu_name: "Please enter Menu Name ",
               menu_name_tamil: "Please enter Menu Name Tamil", 
               menu_url: "Please enter Menu URL",
               level_code: "Please enter Menu level code",  
          }, 
}); 
 var dataSet = (<?php echo (json_encode($tot_datas))?>);  
$(document).ready(function () {  
    $('#addmenu_table').DataTable({
        data: dataSet,
        columns: [  
            { title: 'S.No'},   
            { title: 'Menu Name'},
            { title: 'Menu Name Tamil'},
            { title: 'Menu URL'},
            { title: 'Level Code'},   
            { title: 'Edit',
            'render': function (data, type, full, meta){   
                return '<button type="button" class="btn btn-primary idscls" data-val="'+full[5]+'"><i class="dw dw-eye"></i>Edit</button>';
            }
             },
            
        ],
    });
}); 
$(document).on('click','.idscls', function(){ 
   /*  $(".disabled").attr('disabled','disabled'); 
    $('#Editbtn').show();  
    $('.addmenubtn').hide(); */ 
    $('.addmenubtn').text('Update');  
    var idsval=($(this).data('val'));  
    $.ajax({ 
        type:"POST", 
        data:{lblids:idsval}, 
        success:function(data){ // console.log(data); alert();  
          var result = data.replace(/^\s+|\s+$/gm,'');
          if(result !=''){  
            var result1=JSON.parse(result);  
            $('#menu_name').val(result1['menu_name']);
            $('#menu_name_tamil').val(result1['menu_name_tamil']);
            $('#menu_url').val(result1['menu_url']); 
            $('#level_code').val(result1['level_code']); 
            $('#menu_id').val(idsval); 
          } 
        } 
      }); 
});  
/*$(document).on('click','#Editbtn', function(){ 
   $(".disabled").removeAttr('disabled');  
   $('#Lable_Name').attr('readonly', true);  
    $('#Editbtn').hide();  
    $('.addmenubtn').show();
    $('.addmenubtn').text('Update');  
});*/
</script> 
</body>
</html>