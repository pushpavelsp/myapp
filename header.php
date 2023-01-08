<?php
//include "securityheaders.php";
$current_filename = explode('/',$_SERVER['REQUEST_URI'])[3];
//print_r($uri); exit;
if(isset($_SESSION["email"])){
	$session_login_style=$_SESSION["email"]; 
}

$session_email=$_SESSION["email"];  
$session_level=$_SESSION["level_code"];       
$approve_status=$_SESSION["approve_status"]; 
$unique_ids1=$_SESSION["unique_ids"]; 
$sub_level=$_SESSION["sub_level"]; 
if($sub_level !=''){
$sub_level1="and b.sub_level_code='$sub_level'";
}
$menu_base_url=Base_url;

if(isset($_POST['langtype'])){   
	$_SESSION["langtype"]=$_POST['langtype'];
	$langtypee=$_POST['langtype'];
	die($langtypee);
}

if(isset($_SESSION["langtype"])){
	$lang=$_SESSION["langtype"] ? $_SESSION['langtype'] : '1';
}else{
	$lang=1;
}
if($lang==1){
	$language="tamil";
}elseif($lang==2){
	$language="english";
} 

$label = $db->query("SELECT $language,lbl_name from m_labels where active_status='1'");  
$label1=$label->fetchAll(PDO::FETCH_ASSOC);    
foreach ($label1 as $labelkey => $labelvalue) { 
	$labels[$labelvalue['lbl_name']]=$labelvalue[$language];
} 



if($sub_level !=''){
$sub_level1="and b.sub_level_code='$sub_level'";
}
$menu_base_url=Base_url;
 
if($langtype==1){
  $menu_name= "b.menu_name_tamil"; 
  $level_name= "c.level_name_tamil"; 
}elseif($langtype==2){
  $menu_name= "b.menu_name"; 
  $level_name= "c.level_name_english"; 
}else{
  $menu_name= "b.menu_name_tamil"; 
  $level_name= "c.level_name_tamil";
}  
  
  

$menu_field=$db->query("SELECT a.level_code,$menu_name as menu_name,b.menu_url,$level_name as level_name,b.sub_level_code from login_details as a left join m_menu_field as b on a.level_code=b.level_code left join m_first_level_menu as c on a.level_code=c.level_code where a.email='$session_email' and a.level_code='$session_level' $sub_level1"); 

$menu_field1=$menu_field->fetchAll(PDO::FETCH_ASSOC);
foreach ($menu_field1 as $menu_field1key => $menu_field1value) { 
  $left_menu_data[$menu_field1value['level_code']][$menu_field1value['menu_name']]=$menu_field1value['menu_url']; 
  //$level_name_data[$menu_field1value['level_code']]=$menu_field1value['level_name']; 
  $sub_level_code[$menu_field1value['menu_url']]=$menu_field1value['sub_level_code']; 
} 


?>  
<style>
	body{overflow-x: hidden;}
	@media only screen and (min-width: 768px) {
		.dropdown:hover .dropdown-menu {
			display: block;
			margin-top: 0;
		}
	}
	/*nav bar*/
	.top-head{background:#1b3964 !important;}
	.navbar-light{background:#1b3964 !important;}
	.nav-link{color: #fff !important; }
	.ul-b{margin-bottom: 0rem !important;}
	/*.navbar-expand-lg .navbar-collapse{display: flex; justify-content: center !important;}*/
	.navbar-expand-lg .navbar-collapse{justify-content:center;}
 
</style>
<div class="top-head">
	<div class="row justify-content-md-center align-items-center">
		<div class="col col-lg-4">

		</div>
		<div class="col-md-auto my-1">
			
			<div  class="sizestyle" >
				<!-- Font Size Increase --> 
				<a class="font-increase" href="javascript:void(0);" onclick="changeFontSizeinc('content','2');" style="font-size:15px;color:#232121;border: 1px solid; border-radius: 6px; margin-left: 17px; background-color: #f0ecec; padding: 1px;">&nbsp;A+</a>

				<a href="javascript:window.location.reload(true)" style="font-size:15px;color:#232121;border: 1px solid; border-radius: 6px; background-color: #f0ecec; padding: 1px;">&nbsp;A&nbsp;</a>
				<!-- Font Size Decrease --> 

				<a class="font-minus" href="javascript:void(0);" onclick="changeFontSizedec('content','-1');" style="font-size:15px;color:#232121;border: 1px solid; border-radius: 6px; padding: 1px; background-color: #f0ecec;">&nbsp;A- </a>&nbsp;

				<!-- Screen Reader Access --> 
				<a target="_blank" rel = "noopener noreferrer" href="<?php echo Base_url;?>screen_reader.php" style="color: #fff;font-size:12px; font-weight: bold;">  <img src="<?php echo Base_url;?>vendors/images /sr.jpg" alt="" height="20" width="20"> &nbsp;<?php if($lang == '1'){echo "திரை வாசிப்பு மென்பொருள்";}elseif($lang == '2'){ echo "Screen Reader Access";}else{ echo "திரை வாசிப்பு மென்பொருள்"; } ?> |</a>
				<!--Tamil / English change text -->

				<?php if($lang==1){ ?>
					<a class="lang" href="javascript:void(0);" onclick="change_lang('2');" style="font-size:15px;color:#fff; font-weight: bold; ">&nbsp; English </a>&nbsp;
				<?php }else{ ?>
					<a class="lang" href="javascript:void(0);" onclick="change_lang('1');" style="font-size:15px;color:#fff; font-weight: bold; ">&nbsp; தமிழ் </a>&nbsp;
				<?php } ?>
			</div>
		</div>
		<div class="col col-lg-2 mx-auto">
			<span class="text-white">Beta Version</span>
		</div>
		<div class="col col-lg-2"> 
			<ul class="ul-b">
				<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?php if($session_login_style){ ?>  Logout  <?php }else{ ?>  Login  <?php } ?>
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					 <?php if($session_login_style){ ?>  
     <a class="dropdown-item" href="<?php echo Base_url;?>change_password.php"><i class="dw dw-settings2"></i> Change Password</a>   
 <a class="dropdown-item" href="<?php echo Base_url;?>logout.php"><i class="dw dw-user1"></i>&nbsp;Logout</a> 
     <?php }else{ ?>      
   <a class="dropdown-item" href="<?php echo Base_url;?>login_page.php"><i class="dw dw-user1"></i>Login</a>     
    <?php } ?>      
				</div>
			</li>
			</ul>
          
		</div>
	</div>

</div>
<div class="">
	<div class=" text-center">
		<div class="row align-items-center" >
			<div class="col-md-4 my-1">
				<img src="http://localhost/NSS/vendors/images/tn_logo.png" alt="" class="light-logo" style="width: 20%;">
			</div>
			<div class="col-md-4 my-4">
				<h5>GOVERNMENT OF TAMILNADU
				NATIONAL SERVICE SCHEME -NSS</h5>
			</div>

			<div class="col-md-4 my-0">
				<img src="http://localhost/NSS/vendors/images/nss-logo1.png" alt="" class="light-logo" style="width: 20%">
			</div>
		</div>
	</div>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light ">
	<!-- <a class="navbar-brand" href="#">Navbar</a> -->
	<div class="row">
		<!-- <div class="text-center"> 
			<h6 class="text-white">GOVERNMENT OF TAMILNADU NATIONAL SERVICE SCHEME -NSS</h6>
		</div>
		<div class="col-9">
			<img src="http://localhost/NSS/vendors/images/nss-logo1.png" alt="" class="light-logo" style="width: 20%">
		</div> -->
		<div class="col-3">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
		</div>
	</div>
<style type="text/css">
	.navitem:hover {
  background-color: #607f7f;
}.nav-item.active_menu {
  background-color: #607f7f;
}
</style>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav">
 <?php   foreach ($left_menu_data as $left_menu_datakey => $left_menu_datavalue){  
 	foreach ($left_menu_datavalue as $menu_name => $menu_url) { 
 		
 	$current_filename2=explode('/',$menu_url)[1];   
 			 if($sub_level ==''){
                if($sub_level_code[$menu_url] ==''){
             if($current_filename==$current_filename2){  

 		 ?>	
 			<li class="nav-item navitem active_menu">
				<a class="nav-link" href="<?php echo $menu_base_url;?><?php echo $menu_url;?>"><?php echo $menu_name?></a>
			</li>
 	<?php	}else{ 	?>	
 		<li class="nav-item navitem">
				<a class="nav-link" href="<?php echo $menu_base_url;?><?php echo $menu_url;?>"><?php echo $menu_name?></a>
			</li>
 	<?php	} 
		 }
		}else{ 	?>	
 			<li class="nav-item navitem active_menu">
				<a class="nav-link" href="<?php echo $menu_base_url;?><?php echo $menu_url;?>"><?php echo $menu_name?></a>
			</li>
 	<?php	}	  
    }	 } 
     ?>
     <li class="nav-item navitem">
				<a class="nav-link"><?php echo $session_login_style?></a>
			</li>

			<!-- <li class="nav-item dropdown active">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Dropdown
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="#">Action</a>
					<a class="dropdown-item" href="#">Another action</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#">Something else here</a>
				</div>
			</li> --> 
		</ul>
<!-- <form class="form-inline my-2 my-lg-0">
<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
</form> -->
</div>
</nav>
<script>  
 $(document).ready(function () {  
      $('.header_menu_align > a')
          .click(function (e) {
        $('.header_menu_align > a')
          .removeClass('headeractivetab');
        $(this).addClass('headeractivetab');
      });
    });
    function change_lang(status){
      var langtype1=status; //alert(langtype1); 
         $.ajax({ 
        type:"POST", 
        data:{langtype:langtype1}, 
        success:function(data){   
          if(data !=''){  
            window.location.reload();
          }  
        } 
      });
    }

     function changeFontSizeinc(element, step) {
         step = parseInt(step, 10);
         var el = $('p,div,a,h1,h2,table,label,textarea,select,input,radio,checkbox,h4:not("#eNag")');
         $.each(el, function () {
             var curFont = parseInt($(this).css('font-size'));
             $(this).css('font-size', '18' + 'px');
         });
     }

    function changeFontSizedec(element, step) {
         step = parseInt(step, 10);
         var el = $('p,div,a,h1,h2,table,label,textarea,select,input,radio,checkbox,h4:not("#eNag")');
         $.each(el, function () {
             var curFont = parseInt($(this).css('font-size'));
             $(this).css('font-size', '12' + 'px');
         });
      }

      function resetFontSize(element) {
         var el = $('p,div,a,h1,h2,h4,table,textarea,placeholder,label,select,radio,checkbox,a:not("#serv"),input:not("#serv")');
         $.each(el, function () {
             $(this).css('font-size', '10px');
         });
      }  	
</script>