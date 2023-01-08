<?php   
include "../db_connect.php";
include "../commen_php.php"; 

if($_SESSION['unique_ids']==''){    
  header('Location:'.$Base_url21.'login_page.php');  
}

$coordinator = ($db->query("SELECT * FROM coordinator")->rowCount());  
$no_of_po = ($db->query("select * from po_officer")->rowCount());
 
 $volunteer_dashboard =$db->query("select * from volunteer");
$volunteer_db=$volunteer_dashboard->fetchAll(PDO::FETCH_ASSOC); 
$v=0;  
foreach($volunteer_db as $volunteer_dbkey => $volunteer_dbval){
$v++;   
  $volunteer_status_count=$volunteer_dbval['uni_active_status'];
  $vol_gender=$volunteer_dbval['vol_gender'];
  if($volunteer_status_count==0){
    $vol_pending=$v;
  }elseif($volunteer_status_count==1){
     $vol_approve=$v;
  }elseif($volunteer_status_count==2){
     $vol_reject=$v;
  }elseif($vol_gender==1){
     $vol_male=$v;
  }elseif($vol_gender==2){
     $vol_female=$v;
  }elseif($vol_gender==3){
     $vol_others=$v;
  } 
  $tot_vol=$v;

}  //print_r($district_count);exit;


$university_dashboar =$db->query("select * from university");
$universi1ty1=$university_dashboar->fetchAll(PDO::FETCH_ASSOC); 
$s=0; 
foreach($universi1ty1 as $universi1tykey => $universi1tyval){  
  $s++;    
  $uni_status_count=$universi1tyval['uni_active_status'];
  if($uni_status_count==0){
    $uni_pending=$s;
  }elseif($uni_status_count==1){
     $uni_approve=$s;
  }elseif($uni_status_count==2){
     $uni_reject=$s;
  } 
  $tot_univarisy=$s;
}  
//print_r($uni_reject);exit;

$college =$db->query("select * from college");
$college1=$college->fetchAll(PDO::FETCH_ASSOC); 
$c1=0; 
foreach($college1 as $college1key => $college1val){  
  $c1++;    
  $collegeval_count=$college1val['active_status'];
  if($collegeval_count==0){
    $col_pending=$c1;
  }elseif($collegeval_count==1){
     $col_approve=$c1;
  }elseif($collegeval_count==2){
     $col_reject=$c1;
  }
  $tot_college=$c1;
}  


$volunteer_chart =$db->query("select a.vol_district,a.vol_gender,b.district_name from volunteer as a left join district as b on a.vol_district=b.district_code ORDER BY district_name");
$volunteer_chart1=$volunteer_chart->fetchAll(PDO::FETCH_ASSOC);
$tot_diatrict=array();
$c=0; 
foreach($volunteer_chart1 as $volunteerkey => $volunteerval){  
$c++;   
   $vol_gender=$volunteerval['vol_gender']; 
  if($vol_gender=='1'){  
    $gender_count[$volunteerval['district_name']]['male'] +=1; 
  }elseif($vol_gender=='2'){  
    $gender_count[$volunteerval['district_name']]['female'] +=1;  
  }elseif($vol_gender=='3'){   
    $gender_count[$volunteerval['district_name']]['others'] +=1; 
  }  
  $chart_data[$volunteerval['district_name']] += 1;    
}  

 //print_r($chart_data);print_r('<br>');exit;
foreach ($chart_data as $district_name => $count) { 
  $datass1['districtname'][]=$district_name;
  $datass1['districtcount'][]=$count;
  //$tot_data[]=$datass1;  
  //$data_gender[$district_name] = array("male" =>$gender_count[$district_name]['male'] ?? 0 , "female" =>$gender_count[$district_name]['female'] ?? 0,"others" =>$gender_count[$district_name]['others'] ?? 0); 
  $maleee[]=$gender_count[$district_name]['male'] ?? 0;
  $datass1['female'][]=$gender_count[$district_name]['female'] ?? 0;
  $datass1['others'][]=$gender_count[$district_name]['others'] ?? 0;
} 
   //print_r($male1);print_r('<br>');
 
  //exit;


?>  
<!DOCTYPE html>
<html>
<?php include "../head.php"; ?>  
<style type="text/css">
.counter{
color: #666;
font-family: 'Poppins', sans-serif;
text-align: center;
width: 200px;
height: 200px;
padding: 0 20px 20px 0;
margin: 0 auto;
position: relative;
z-index: 1;
}
.counter:before,
.counter:after{
content: "";
background: linear-gradient(#F3AC2F, #ED6422);
position: absolute;
top: 10px;
left: 10px;
right: 0;
bottom: 0;
z-index: -1;
}
.counter:after{
background: transparent;
border: 2px dashed rgba(255,255,255,0.5);
top: 20px;
left: 20px;
right: 10px;
bottom: 10px;
}
.counter .counter-content{
background-color: #fff;
height: 100%;
padding: 23px 15px;
box-shadow: 5px 5px 5px rgba(0,0,0,0.25);
position: relative;
}
.counter .counter-content:before,
.counter .counter-content:after{
content: '';
background: linear-gradient(to top right, #ad3a05 50%, transparent 52%);
height: 10px;
width: 10px;
position: absolute;
right: -10px;
top: 0;
}
.counter .counter-content:after{
transform: rotate(180deg);
top: auto;
bottom: -10px;
right: auto;
left: 0;
}
.counter .counter-icon{
font-size: 35px;
line-height: 35px;
margin: 0 0 15px;
}
.counter h3{
color: #F36526;
font-size: 18px;
font-weight: 600;
letter-spacing: 1px;
line-height: 20px;
text-transform: uppercase;
margin: 0 0 7px;
}
.counter .counter-value{
font-size: 30px;
font-weight: 600;
display: block;
}
.counter.purple:before{ background: linear-gradient(#C4588C, #BE2A8D); }
.counter.purple .counter-content:before,
.counter.purple .counter-content:after{
background: linear-gradient(to top right, #7c1058 50%, transparent 52%);
}
.counter.purple h3{ color: #BE2A8D; }
.counter.blue:before{ background: linear-gradient(#7ACBC5, #2D9C91); }
.counter.blue .counter-content:before,
.counter.blue .counter-content:after{
background: linear-gradient(to top right, #0a5b53 50%, transparent 52%);
}
.counter.blue h3{ color: #2D9C91; }
.counter.green:before{ background: linear-gradient(#558b2f, #558b2f); }
.counter.green .counter-content:before,
.counter.green .counter-content:after{
background: linear-gradient(to top right, #558b2f 50%, transparent 52%);
}
.counter.green h3{ color: #558b2f; } 

.counter.red:before{ background: linear-gradient(#ff3d00, #ff3d00); }
.counter.red .counter-content:before,
.counter.red .counter-content:after{
background: linear-gradient(to top right, #ff3d00 50%, transparent 52%);
}
.counter.red h3{ color: #ff3d00; } 
.counter.yellow:before{ background: linear-gradient(#ffd600, #ffd600); }
.counter.yellow .counter-content:before,
.counter.yellow .counter-content:after{
background: linear-gradient(to top right, #ffd600 50%, transparent 52%);
}
.counter.yellow h3{ color: #ffd600; }

.counter.darkblue:before{ background: linear-gradient(#3b5998, #3b5998); }
.counter.darkblue .counter-content:before,
.counter.darkblue .counter-content:after{
background: linear-gradient(to top right, #3b5998 50%, transparent 52%);
}
.counter.darkblue h3{ color: #3b5998; }

.counter.olivegreen:before{ background: linear-gradient(#cddc35, #cddc35); }
.counter.olivegreen .counter-content:before,
.counter.olivegreen .counter-content:after{
background: linear-gradient(to top right, #cddc35 50%, transparent 52%);
}
.counter.olivegreen h3{ color: #cddc35; }

.counter.skyblue:before{ background: linear-gradient(#26c6da, #26c6da); }
.counter.skyblue .counter-content:before,
.counter.skyblue .counter-content:after{
background: linear-gradient(to top right, #26c6da 50%, transparent 52%);
}
.counter.skyblue h3{ color: #26c6da; }


@media screen and (max-width:990px){
.counter { margin-bottom: 40px; }
} 
</style>
<body> 
<?php include "../header.php"; ?>  
<div class="mobile-menu-overlay"></div> 
<div class="main-container">
<nav aria-label="breadcrumb">
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="">Home &nbsp; &nbsp;</a></li> 
</ol>
</nav>    
<div class="container pd-20 card-box mb-30"> 
<div class="card-box height-100-p overflow-hidden">
<div class="profile-tab height-100-p">
<div class="tab height-100-p">
<ul class="nav nav-tabs customtab" role="tablist" style="background-color: #26c6da;">
<li class="nav-item">
<a class="nav-link active" data-toggle="tab" href="#timeline" role="tab" aria-selected="true">Details</a>
</li>
<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#tasks" role="tab" aria-selected="false">Tasks</a>
</li> 
</ul>
<div class="tab-content"> 
<div class="tab-pane fade active show" id="timeline" role="tabpanel">

<div class="row" style="background-color:#eceff1">
<div class="col-md-3 col-sm-6">
<br>
<div class="counter skyblue">
<div class="counter-content">
<div class="counter-icon">
<!-- <i class="fa fa-rocket"></i> -->
<i class="icon-copy fa fa-university" aria-hidden="true" style="color:#26c6da"></i> 
</div>
<h3>Total No.of University</h3>
<span class="counter-value"><?php echo $tot_univarisy ? $tot_univarisy:'0'; ?></span>
</div>
</div>
</div> 
<div class="col-md-3 col-sm-6">
<br>
<div class="counter purple">
<div class="counter-content"> 
<div class="counter-icon">
<!-- <i class="fa fa-rocket"></i> -->
<!-- <i class="icon-copy dw dw-building" ></i>  -->
<i class="icon-copy fa fa-user" aria-hidden="true" style="color:#BE2A8D"></i>
</div>
<h3>No.of Coordinator</h3> 
<span class="counter-value"><?php echo $coordinator ? $coordinator:'0'; ?></span>
</div>
</div>
<br>
</div>
<div class="col-md-3 col-sm-6">
<br>  
<div class="counter blue">
<div class="counter-content">
<div class="counter-icon">
<!-- <i class="fa fa-rocket"></i> -->
<i class="icon-copy dw dw-building" style="color:#2D9C91"></i> 
</div>
<h3>Total No.of Colleges</h3>
<span class="counter-value"><?php echo $tot_college?$tot_college:'0'; ?></span>
</div>
</div>
<br>
</div>
<div class="col-md-3 col-sm-6">
<br>
<div class="counter blue">
<div class="counter-content">
<div class="counter-icon">
<!-- <i class="fa fa-rocket"></i> -->
<i class="icon-copy fa fa-user-circle-o" aria-hidden="true" style="color:#2D9C91"></i>
<!-- <i class="icon-copy dw dw-building" style="color:#33691e"></i>  -->
</div>
<h3>Total No.of Program Officer</h3>
<span class="counter-value"><?php echo $no_of_po?$no_of_po:'0'; ?></span>
</div>
</div>
<br>
</div>  
</div>
<div>
<br>
<br>
<div class="row">
<div class="col-md-6 col-sm-6">
<h5><center>University</center></h5>
<table class="table table-bordered">
<thead class="thead" style="background-color: #26c6da;">
<tr> 
<th scope="col">Approved University</th>
<th scope="col">Disapproved University</th>
<th scope="col">Pending University</th>
</tr>
</thead>
<tbody>
<tr>
<td><?php echo $uni_pending ? $uni_pending:'0';?></td>
<td><?php echo $uni_approve ? $uni_approve:'0'; ?></td>
<td><?php echo $uni_reject ? $uni_reject:'0';?></td>
</tr>
</tbody>
</table>
</div>
<div class="col-md-6 col-sm-6">
<h5><center>College</center></h5>
<table class="table table-bordered">
<thead class="thead" style="background-color: #26c6da;">
<tr> 
<th scope="col">Approved College</th>
<th scope="col">Disapproved College</th>
<th scope="col">Pending College</th>
</tr>
</thead>
<tbody>
<tr>  
<td><?php echo $col_pending ? $col_pending:'0'; ?></td>
<td><?php echo $col_approve ? $col_approve:'0'; ?></td> 
<td><?php echo $col_reject ? $col_reject:'0'; ?></td> 
</tr>
</tbody>
</table>
</div> 
</div> 
<div class="row">
<div class="col-md-12 col-sm-12">
<h5><center>Volunteer</center></h5>
<table class="table table-bordered">
<thead class="thead" style="background-color: #26c6da;">
<tr>
<th scope="col">Total No.Of Volunteers</th>
<th scope="col">Male</th>
<th scope="col">Female</th>
<th scope="col">Others</th>
<th scope="col">Approved</th>
<th scope="col">Disapproved</th>
<th scope="col">Pending</th>
</tr>
</thead>
<tbody>
<tr>       
<td><?php echo $tot_vol?$tot_vol:'0';?></td> 
<td><?php echo $vol_male?$vol_male:'0';?></td> 
<td><?php echo $vol_female?$vol_female:'0';?></td> 
<td><?php echo $vol_others?$vol_others:'0';?></td> 
<td><?php echo $vol_approve?$vol_approve:'0';?></td> 
<td><?php echo $vol_reject?$vol_reject:'0';?></td> 
<td><?php echo $vol_pending?$vol_pending:'0';?></td> 
</tr>
</tbody>
</table>
</div> 
</div> 
<br>
<br>
<style>
#chartdiv {
  width: 100%;
  height: 500px;
}
</style>
<div class="row">
<div class="col-md-12 col-sm-12">
  <h5><center>District Wise Volunteers</center></h5>
 <div id="chartdiv"></div>
</div> 
</div> 



</div>
</div>  
<div class="tab-pane fade" id="tasks" role="tabpanel">
2
</div> 
</div>
</div>
</div>
</div>
</div> 
</div> 


<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>   
<script> 
  var datas1=<?php echo json_encode($datass1)?>;console.log(datas1); 
   
am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartdiv");


// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);


// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
var chart = root.container.children.push(am5xy.XYChart.new(root, {
  panX: false,
  panY: false,
  wheelX: "panX",
  wheelY: "zoomX",
  layout: root.verticalLayout
}));

// Add scrollbar
// https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
chart.set("scrollbarX", am5.Scrollbar.new(root, {
  orientation: "horizontal"
}));

var data = [{
  "year": "2021",
  "europe": 2.5,
  "namerica": 2.5,
  "asia": 2.1,
  "lamerica": 1,
  "meast": 0.8,
  "africa": 0.4
}, {
  "year": "2022",
  "europe": 2.6,
  "namerica": 2.7,
  "asia": 2.2,
  "lamerica": 0.5,
  "meast": 0.4,
  "africa": 0.3
}, {
  "year": "2023",
  "europe": 2.8,
  "namerica": 2.9,
  "asia": 2.4,
  "lamerica": 0.3,
  "meast": 0.9,
  "africa": 0.5
}]


// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
  categoryField: "year",
  renderer: am5xy.AxisRendererX.new(root, {}),
  tooltip: am5.Tooltip.new(root, {})
}));

xAxis.data.setAll(data);

var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
  min: 0,
  renderer: am5xy.AxisRendererY.new(root, {})
}));


// Add legend
// https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
var legend = chart.children.push(am5.Legend.new(root, {
  centerX: am5.p50,
  x: am5.p50
}));


// Add series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
function makeSeries(name, fieldName) {
  var series = chart.series.push(am5xy.ColumnSeries.new(root, {
    name: name,
    stacked: true,
    xAxis: xAxis,
    yAxis: yAxis,
    valueYField: fieldName,
    categoryXField: "year"
  }));

  series.columns.template.setAll({
    tooltipText: "{name}, {categoryX}: {valueY}",
    tooltipY: am5.percent(10)
  });
  series.data.setAll(data);

  // Make stuff animate on load
  // https://www.amcharts.com/docs/v5/concepts/animations/
  series.appear();

  series.bullets.push(function () {
    return am5.Bullet.new(root, {
      sprite: am5.Label.new(root, {
        text: "{valueY}",
        fill: root.interfaceColors.get("alternativeText"),
        centerY: am5.p50,
        centerX: am5.p50,
        populateText: true
      })
    });
  });

  legend.data.push(series);
}

makeSeries("Europe", "europe");
makeSeries("North America", "namerica");
makeSeries("Asia", "asia");
makeSeries("Latin America", "lamerica");
makeSeries("Middle East", "meast");
makeSeries("Africa", "africa");


// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
chart.appear(1000, 100);

});
</script>
<?php include "../footer.php"; ?>
<?php include "../common_js.php";?>
</body>
</html>