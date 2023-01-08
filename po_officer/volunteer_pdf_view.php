<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/NSS/vendor/autoload.php';
 //include "../vendor/mpdf/mpdf/mpdf.php";
 include "../db_connect.php";
 include "../commen_php.php";

//Getting Lables

$label = $db->query("SELECT * from m_labels");  
$label1=$label->fetchAll(PDO::FETCH_ASSOC);    
foreach ($label1 as $labelkey => $labelvalue) { 
  $labels[$labelvalue['lbl_name']]=$labelvalue['english'];
}


if(isset($_POST['ids'])){ 
  $idss= stripQuotes(killChars(trim($_POST['ids'])));  
 
 $volunteer_echo = $db->query("select u.uni_name,u.uni_name_tamil,clg.clg_name_english,clg.clg_name_tamil,gen.gender_name,d.district_name,d.district_tname,comm.community_name,deg.degree_name,po.po_name,bg.blood_name,v.vol_name,v.vol_name_tamil,v.vol_dob,v.vol_father_name,v.vol_email,v.vol_mobile,v.vol_aadhaar,v.vol_virtual,v.vol_address,v.vol_pincode,v.vol_adm_year,v.vol_doj_nss,v.vol_blood_dona,v.vol_emerg_ser_willing,v.vol_talents,v.vol_list_talents,v.vol_approve_status,v.vol_photo from volunteer v 
  left join university u on u.uni_id=v.uni_id 
  left join college clg on clg.clg_id=v.clg_id 
  left join gender gen on gen.gender_id=v.vol_gender 
  left join district d on d.district_code=v.vol_district 
  left join m_community comm on comm.community_id=v.vol_community 
  left join m_degree deg on deg.degree_id=v.vol_degree_id 
  left join po_officer po on po.po_id=v.vol_po_name 
  left join blood_group bg on bg.bloodgroup_id=v.vol_blood_group 
  where v.vol_id='$idss'");  
 $vol_echo1=$volunteer_echo->fetch(PDO::FETCH_ASSOC); 
} 


//print_r($vol_echo1['vol_name_tamil']);exit;
$volunteer_dob=explode(" ",$vol_echo1['vol_dob']); 

//date as changed from yyyy/mm/dd to dd/mm/yyyy 
$dob=$volunteer_dob[0];
$new_dob = date("d-m-Y", strtotime($dob));  

//print_($volunteer_dob[0]);exit;
$doj_nss = $vol_echo1['vol_doj_nss'];  
$new_doj_nss = date("d-m-Y", strtotime($doj_nss));  

$adm_year =$vol_echo1['vol_adm_year'];
$new_adm_year = date("d-m-Y", strtotime($doj_nss));


//get only year from date & add 2 year

$batch_start_year= date('Y', strtotime($doj_nss));
$batch_end_year=$batch_start_year+2;
$batch=$batch_start_year."-".$batch_end_year;
//For blood group
 if($vol_echo1['vol_blood_dona'] == "Y"){
   $vol_blood= "YES";

   }else{

    $vol_blood="No";
   }
//For Emergency service
if($vol_echo1['vol_emerg_ser_willing'] == "Y"){
    $vol_emerg= "YES";

   }else{

     $vol_emerg="No";
   }
// //For aadhar no
//  if($vol_echo1['vol_aadhaar'] ==''){
//    $vol_aadhaar= "---";

//    }else{

//     $vol_aadhaar=$vol_echo1['vol_aadhaar'] ;
//    }
//For virtual ID
if($vol_echo1['vol_virtual'] != ''){
  $vol_aadhaar_virtual=$vol_echo1['vol_virtual'];
   $vol_aadhaar_virtual_label='Virtual ID'; 

   }else{ 
     $vol_aadhaar_virtual=$vol_echo1['vol_aadhaar'] ;
     $vol_aadhaar_virtual_label='Aadhaar Number';
   
   }

/* Multiselect Value show */
$talents=$db->query("SELECT talents_id, talents,talents_tamil  FROM m_talents");  
$talents1=$talents->fetchAll(PDO::FETCH_ASSOC); 
foreach ($talents1 as $talentskey => $talentsvalue) { 
    $talents_codes[$talentsvalue['talents_id']]=$talentsvalue['talents'];  
}

$vol_talentsas=json_decode($vol_echo1['vol_talents'],true); 
foreach ($vol_talentsas as $vol_talentsaskey => $vol_talentsasvalue) { 
   $add=1;  
$talents_ids=intval($vol_talentsaskey)+$add;   
$talents_name=$talents_codes[$talents_ids];
/*$vol_talent_val= implode(',', $talents_name); 

  print_r($fgdg); */

}
 

$pdf_view .= '
<html>
<head>

<style>
body {
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-size: 14px;
    line-height: 1.42857143;
    color: #333;
    background-color: #fff;
}

h1,h2,h3,h4,h5,h6,
 { font-family: sans-serif;
    font-weight:10px;
    font-weight: 500;
    line-height: 1.1;
    color: inherit;
}
.tn_img_size{
    width: 65%;
    margin-left: 12px;
    margin-top: -20px;
}
.nss_img_size{
    width: 65%;
    margin-left: 75%;
    margin-right:100%;
    margin-top: -4px;
   
}


td { vertical-align: top; 
    font-size:15px;

    align: center;
}
.border
{
    border-style: solid;
}

</style>
</head>
<body>
<!--mpdf
<htmlpagefooter name="myfooter">
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<div class="border">
<div >
      <h1 style="text-align:center; color:#1c1085;"><b>'.$labels["NSS"].'</b></h1>
      <h2 style="text-align:center"><b>'.$vol_echo1["uni_name"].'</b></h2>
      <h2 style="text-align:center"><b>'.$vol_echo1["clg_name_english"].'</b></h2>
 </div>
 <hr style="height:2px; width:100%; border-width:0; color:black; background-color:black">
<div>
 
    <h2 style="text-align:center; color:#1c1085; "><b>'.$labels["vol_form"].'<b></h2>
     <h2 style="text-align:center"><b>Batch ('.$batch.')<b></h2>
    <hr style="height:2px; width:50%; border-width:0; color:black; background-color:black">
    <h2 class="text-Black" style="text-align:center; text-decoration: underline;"><b>'.$labels["personal_info"].'<b></h2>

</div>

<table class="items" width="100%"" style="font-size: 9pt; border-collapse: collapse;"" cellpadding="10">
<tbody>
<tr>
<td width="20%"><b>'.$labels["vol_name"].'</b></td>
<td width="20%">'.$vol_echo1["vol_name"].'</td>
<td width="20%"><b>'.$labels["vol_name"].'</b></td>
<td width="20%">'.$vol_echo1['vol_name_tamil'].'</td>
</tr>

<tr>
<td width="20%"><b>'.$labels["gender"].'</b></td>
<td width="20%">'.$vol_echo1["gender_name"].'</td>
<td width="20%"><b>'.$labels["dob"].'</b></td>
<td width="20%">'. $new_dob.'</td>
</tr>

<tr>
<td width="20%"><b>'.$labels["father_name"].'</b></td>
<td width="20%">'.$vol_echo1["vol_father_name"].'</td>
<td width="20%"><b>'.$labels["email_id"].'</b></td>
<td width="20%">'.$vol_echo1["vol_email"].'</td>
</tr>

<tr>
<td width="20%"><b>'.$labels["mobileno"].'</b></td>
<td width="20%">'.$vol_echo1["vol_mobile"].'</td>
<td width="20%"><b>'.$vol_aadhaar_virtual_label.'</b></td>  
<td width="20%">'. $vol_aadhaar_virtual.'</td>
</tr>

<tr>
 <td width="20%"><b>'.$labels["community"].'</b></td>
<td width="20%">'.$vol_echo1["community_name"].'</td>
<td width="20%"><b>'.$labels["address"].'</b></td>
<td width="20%">'.$vol_echo1["vol_address"].'</td>
</tr>

<tr>
<td width="20%"><b>'.$labels["district"].'</b></td>
<td width="20%">'.$vol_echo1["district_name"].'</td>
<td width="20%"><b>'.$labels["pincode"].'</b></td>
<td width="20%">'.$vol_echo1["vol_pincode"].'</td>
</tr>

<tr>

</tr>

</tbody>
</table>

<hr style="height:2px; width:100%; border-width:0; color:black; background-color:black">
<h2 class="text-Black" style="text-align:center; text-decoration: underline;"><b>'.$labels["nss_details"].'<b></h2>


<table class="items" width="100%"" style="font-size: 9pt; border-collapse: collapse;"" cellpadding="10">
<tbody>
<tr>
<td width="20%"><b>'.$labels["degree_course"].'</b></td>
<td width="20%">'.$vol_echo1["degree_name"].'</td>
<td width="20%"><b>'.$labels["adm_year"].'</b></td>
<td width="20%">'.$new_adm_year.'</td>
</tr>

<tr>
<td width="20%"><b>'.$labels["po_name_pdf"].'</b></td>
<td width="20%">'.$vol_echo1["po_name"].'</td>
<td width="20%"><b>'.$labels["vol_doj_nss"].'</b></td>
<td width="20%">'.$new_doj_nss.'</td>
</tr>

<tr>
<td width="20%"><b>'.$labels["blood_group"].'</b></td>
<td width="20%">'.$vol_echo1["blood_name"].'</td>
<td width="20%"><b>'.$labels["blood_don"].'</b></td>
<td width="20%">'. $vol_blood.'</td>
</tr>

<tr>
<td width="20%"><b>'.$labels["emerg_ser_willing"].'</b></td>
<td width="20%">'. $vol_emerg.'</td>
<td width="20%"><b>'.$labels["talents"].'</b></td>
<td width="20%">'.$talents_name.'</td>
</tr>

<tr>
<td width="20%"><b>'.$labels["list_talents"].'</b></td>
<td width="20%">'.$vol_echo1["vol_list_talents"].'</td>
</tr>

</tbody>
</table>
</div>
</body>
</html>
';

$mpdf = new \Mpdf\Mpdf();

$mpdf->WriteHTML($pdf_view);
$mpdf->SetDisplayMode('fullpage');
$mpdf->Output();
?>