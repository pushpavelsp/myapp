<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '0');
date_default_timezone_set('Asia/Kolkata');
$created_date = date('m/d/Y h:i:s a', time());
$_SESSION["created_date"]=$created_date; 
 $host='localhost';
$dbb = 'nssdetails';
$username = 'postgres';
$password = '1234';
$port ='5432';  
/*$host='192.168.200.32'; */
/*$host='localhost';
$dbb = 'nssdetails';
$username = 'postgres';
$password = 'postgres';
$port ='5433';*/
 //connection ip 5434
$dsn = "pgsql:host=$host;port=$port;dbname=$dbb;user=$username;password=$password";
 
try{
 // create a PostgreSQL database connection
 $db = new PDO($dsn);
 
 // display a message if connected to the PostgreSQL successfully
 if($db){
    //echo "<strong>database successfully!</strong>";
 }
} catch (PDOException $e){
 // report error message
 echo $e->getMessage();
}
 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $xyzlink = "https"; }
else{
    $xyzlink = "http"; 
  }
$xyzlink .= "://".$_SERVER['HTTP_HOST'];
define("Base_url",$xyzlink."/NSS/");


$pagename=basename($_SERVER['PHP_SELF']); 
$Base_url21=Base_url;  
if($pagename=='login_page.php'){
	unset($_SESSION['email']);
	unset($_SESSION['level_code']);
	unset($_SESSION['approve_status']); 
	unset($_SESSION['unique_ids']);  
}else{ 
	if($_SESSION['unique_ids'] !='' || $_SESSION['level_code'] !=''  && $pagename=='screen_reader.php'){    
		 
	}elseif($_SESSION['unique_ids'] !='' && $_SESSION['level_code'] !=''){ 
			$SESSION_userid=$_SESSION['unique_ids'];
			$SESSION_levelid=$_SESSION['level_code']; 
			$SESSION_sub_level=$_SESSION["sub_level"];  
			if($pagename=='change_password.php'){     
			}else{   
				//print_r()
				$pagecheck_count = $db->query("select b.menu_name,b.menu_name_tamil,a.level_code,b.menu_url from login_details as a left join m_menu_field as b on a.level_code=b.level_code where a.user_reference_id='$SESSION_userid' and b.level_code='$SESSION_levelid' and b.page_name='$pagename'");
			$pagecheck_data=$pagecheck_count ->fetch(PDO::FETCH_ASSOC);  
			$pagecheck_count1=$pagecheck_count ->rowCount();  
				if($pagecheck_count1 !=1){ 
					header('Location:'.$Base_url21.'login_page.php');
				} 
			}
		 
	}else 
	if($_SESSION['unique_ids']=='' || $_SESSION['level_code']=='' && $pagename=='forgot_password.php'){   
		//header('Location:'.$Base_url21.'forgot_password.php');   
	}elseif($_SESSION['unique_ids']=='' || $_SESSION['level_code']==''  && $pagename=='screen_reader.php'){    
		 
	}elseif($_SESSION['unique_ids']=='' || $_SESSION['level_code']==''){    
		header('Location:'.$Base_url21.'login_page.php');  
	}  
}  

?>