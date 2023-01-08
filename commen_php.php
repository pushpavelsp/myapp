<?php 
/*$urll=Base_url;  
$urll2= "".$urll."mail_sent.php";//print_r($urll2);exit;*/
require "../mail_sent.php"; 
 if(isset($_POST['input'])){  
    $input=$_POST['input'];     
    $table=$_POST['table'];     
    $column=$_POST['column']; 
    $mailpass=$_POST['mailpass']; 
    $qry_dataa="$table WHERE $column='$input'";   
    //print_r("SELECT * FROM $qry_dataa");exit;
     $count = ($db->query("SELECT * FROM $qry_dataa")->rowCount());   
     if($count >=1){
      $comendata='Already';
     }   
    die($comendata);
  } 


function stripQuotes($strWords)
{
$stripQuotes = str_replace("'", "''",$strWords);
 return $stripQuotes;
}
function killChars($strWords)
{
 $badChars = array("select", "#", "$", "drop", ";", "--", "-","insert",  "delete" , "and", "or", "xp_","union","|","&",";","$","%","'","\'",'\"',"<>","+","SELECT","INSERT","DELETE","AND","UNION",">","<","<=",">=","!=","||","=");
 $newChars = $strWords;
for($i=0;$i<count($badChars);$i++)
{
 $newChars = str_replace($badChars[$i], "",$newChars);
}

 return $newChars;
} 

if(isset($_POST['switchstatus'])){  
  $switchstatus=$_POST['switchstatus'];
  $table1=$_POST['table1']; 
  $column1=$_POST['column1']; 
  $wharecolumn1=$_POST['wharecolumn1']; 
  $whareid1=$_POST['whareid1']; 
  $reload=$_POST['reload']; 
  $mailid1=$_POST['mailid'];   
  if($_POST['remark'] !=''){
     $remarks2="'" . $_POST['remark']. "'";
    $remark_column=',remark='; 
    $remark_datas=$remark_column.$remarks2;  
    if($switchstatus=='2' || $switchstatus=='0'){ 
      mail_sent(5,$loginwhareid,'','',$_POST['remark']);  
    
  }  
  }
   
  

  $statusupdate="$table1 SET $column1='$switchstatus' $remark_datas WHERE $wharecolumn1='$whareid1'";  
    
  $statusupdate1 = $db->query("UPDATE $statusupdate"); 
  if($statusupdate1){   
    if($reload=='3')
     $switchstatus1=$reload;
    }else{
      $switchstatus1=$switchstatus;
    } 
     //print_r($switchstatus1);exit;
    die($switchstatus1);
}

if(isset($_POST['loginapproveid'])){  
  $loginapproveid=$_POST['loginapproveid']; 
  $mailids=strtolower($_POST['mailids']);   
  $upadteid=$_POST['upadteid'];  
  $level_code=$_POST['level_code'];  
  if($loginapproveid=='1'){
    $genrate_psw=password_genrate(); 
    $psw=mail_sent(2,$mailids,$genrate_psw,'','');   
    $password = password_hash($genrate_psw,PASSWORD_DEFAULT); 
    $select_login_details = ($db->query("select * from login_details WHERE email='$mailids'")->rowCount()); 

    /* $login_details1=$select_login_details->fetch(PDO::FETCH_ASSOC)[''];  */
  if($select_login_details=='0'){ 
   // print_r();exit;
    $statusupdate1 = $db->query("INSERT INTO login_details(email, password, confirm_psw, level_code, approve_status, user_reference_id,created_by, created_time)VALUES ('$mailids', '$password', '$genrate_psw', '$level_code', '$loginapproveid', '$upadteid', '$mailids', 'now()')"); 
  }else{
     // print_r();exit; 
       $statusupdate1 = $db->query("UPDATE login_details SET approve_status='$loginapproveid' WHERE email='$mailids';"); 
  }  
  }else{  
     $statusupdate1 = $db->query("UPDATE login_details SET approve_status='$loginapproveid' WHERE email='$mailids';"); 
  }   
  // if($statusupdate1){
  //   $switchdata='approve_status';
  //   die($switchdata);
  // } 
}

function genrateotp(){ 
  $rand_num = mt_rand(100000,999999);  
  return $rand_num;
}

function password_genrate(){ 
  $bytes = openssl_random_pseudo_bytes(3);
  $pass = bin2hex($bytes);
  return $pass;
}
 

function mindate($min_age) {
        $date=date_create("today");
        date_sub($date,date_interval_create_from_date_string("$min_age years"));
        echo date_format($date,"d-m-Y");
    }   

function maxdate($max_age) {
    $date=date_create("today");
    date_sub($date,date_interval_create_from_date_string("$max_age years"));
    echo date_format($date,"d-m-Y");
}

if(isset($_SESSION["langtype"])){
    $langtype=$_SESSION["langtype"] ? $_SESSION['langtype'] : '1';
  }else{
    $langtype=1;
  }
  if($langtype==1){
    $districtname= "district_tname"; 
  }elseif($langtype==2){
    $districtname= "district_name"; 
  }else{
    $districtname= "district_tname"; 
  } 

//view page district
function view_page_districs($input){ 
  global $db,$districtname;
$district=$db->query("SELECT district_code, $districtname as district_name  FROM district  order by district_name");  
$district1=$district->fetchAll(PDO::FETCH_ASSOC); 
foreach ($district1 as $districtkey => $districtvalue) {   
  $district_codes1[$districtvalue['district_code']]=$districtvalue['district_name'];  
}
  $district_echo=json_decode($input,true);  
  foreach ($district_codes1 as $districtkey => $districtvalue){  
    if(in_array($districtkey, $district_echo)){  
          $districtvalue1 .=$districtvalue.',';
      }
    } 

    return $districtvalue1;
}

//datatable status count
function datatable_status_count($column,$table_name,$where_column,$where_id){
  global $db;
  if($where_id !=''){
     $where_condition="$table WHERE $where_column='$where_id'"; 
  } 
  $status_count = $db->query("SELECT $column as data_status, COUNT(*) AS countdata FROM $table_name $where_condition GROUP BY $column;"); 
  $status_count1=$status_count->fetchAll(PDO::FETCH_ASSOC);  
  foreach ($status_count1 as $status_count1key => $status_count1value) {
    if($status_count1value['data_status']==0){
      $Pendingdata=$status_count1value['countdata'];
    }elseif($status_count1value['data_status']==1){
      $approvedata=$status_count1value['countdata'];
    }elseif($status_count1value['data_status']==2){
      $Disapproved=$status_count1value['countdata'];
    } 
  }
  return $Pendingdata.'~'.$approvedata.'~'.$Disapproved;
}

function datatable_status_select_option(){
  global $db;
  $status=$db->query("SELECT status_id,status FROM m_approve_status");  
  $status1=$status ->fetchAll(PDO::FETCH_ASSOC); 
  foreach ($status1 as $statuskey => $statusvalue) { 
    $status_codes[$statusvalue['status_id']]=$statusvalue['status'];  
  }  
  return $status_codes;
}

function datatable_page_title(){
  global $db;
    $page_title_lbl=base64_decode($_GET['status'],true);  
    if($page_title_lbl==''){ 
      $page_title_lbl2='0'; 
    }else{ 
      $page_title_lbl2=$page_title_lbl; 
    }
    $m_approve_status = $db->query("select * from m_approve_status where status_id='$page_title_lbl2'");
    $label_via_status=$m_approve_status->fetch(PDO::FETCH_ASSOC)['status']; 
   
   return $label_via_status;
 }

?>