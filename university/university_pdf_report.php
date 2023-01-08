<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/NSS/vendor/autoload.php';
 //include "../vendor/mpdf/mpdf/mpdf.php";
 include "../db_connect.php";
 include "../commen_php.php";
 $unique_ids=$_SESSION["unique_ids"]; 

//Getting Lables

// $label = $db->query("SELECT * from m_labels");  
// $label1=$label->fetchAll(PDO::FETCH_ASSOC);    
// foreach ($label1 as $labelkey => $labelvalue) { 
//   $labels[$labelvalue['lbl_name']]=$labelvalue['english'];
// }


if(isset($_POST['unique_ids'])){ 
  $idss= stripQuotes(killChars(trim($_POST['unique_ids'])));  
 
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


td,tr { vertical-align: top; 
    font-size:15px;
     border: 10px solid black;

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
 <h1 style="text-align:center; color:#1c1085;"><b>'.dsfdsg.'</b></h1>

<table class="items" width="100%"" style="font-size: 9pt; border-collapse: collapse;border:10px solid black"  cellpadding="10">
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