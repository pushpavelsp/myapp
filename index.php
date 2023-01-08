<?php   
include "db_connect.php"; 

 ///include "commen_php.php";  print_r(546);exit;

?>
 
<!DOCTYPE html>
<html>
<?php include "head.php"; ?>   
 <style type="text/css">
   
/* Extra small devices (phones, 600px and down) */
@media only screen and (max-width: 600px) {    
  .container_style{
    margin-top: -18%;
  } 
}

/* Small devices (portrait tablets and large phones, 600px and up) */
@media only screen and (min-width: 600px) {
   
}

/* Medium devices (landscape tablets, 768px and up) */
@media only screen and (min-width: 768px) {
   .container_style{
    margin-top: 0%;
  } 
} 

/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {
  
} 

/* Extra large devices (large laptops and desktops, 1200px and up) */
@media only screen and (min-width: 1200px) {
  .container_style{
    padding: 21px 80px 0 135px;
  } 
  .scroolimg{
    height: 500px;
  }
  .main-container{
   padding: 21px 80px 0 135px !important;
 }
}
 </style>
 <head>
  <!-- Basic Page Info -->
  <meta charset="utf-8">
  <title>DeskApp - Bootstrap Admin Dashboard HTML Template</title>

  <!-- Site favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="vendors/images/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="vendors/images/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="vendors/images/favicon-16x16.png">

  <!-- Mobile Specific Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="src/plugins/sweetalert2/sweetalert2.css">
  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
  <link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css">
  <link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="vendors/styles/style.css"> 
  <link rel="stylesheet" type="text/css" href="toastr_page.css"> 
  <style type="text/css"> 
.error
{
color:red; 
}
  </style>
</head>
<body>
  <?php 
  include "header.php";  ?>   

  <div class="mobile-menu-overlay"></div>
 
<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100 scroolimg" src="vendors/images/banner-img1.jpg" alt="First slide">
      <div class="carousel-caption d-none d-md-block">
        <h5 class="color-white">Not Me But You</h5>
        <p>Identify the needs and problems of the community and involve them in problem-solving.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img class="d-block w-100 scroolimg" src="vendors/images/banner-img2.jpg" alt="Second slide">
      <div class="carousel-caption d-none d-md-block">
        <h5 class="color-white">NSS Logo-The giant Rath Wheel of the world famous Konark Sun Temple</h5>
        <p>Develop among themselves a sense of social and civic responsibility.</p>
      </div>
    </div> 
  </div>
  <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
        
  <div class="main-container container_style">  
    <div class="pd-ltr-20">
      <div class="pd-20 card-box mb-30">
          <h4 class="h4 text-blue mb-10">Welcome to National Service Scheme</h4>
          <p>The National Service Scheme (NSS) is a Central Sector Scheme of Government of India, Ministry of Youth Affairs & Sports. It provides opportunity to the student youth of 11th & 12th Class of schools at +2 Board level and student youth of Technical Institution, Graduate & Post Graduate at colleges and University level of India to take part in various government led community service activities & programmes.The sole aim of the NSS is to provide hands on experience to young students in delivering community service</p>
        </div>
       <!-- <div class="row">
        <div class="col-xl-3 mb-30">
          <div class="card-box height-100-p widget-style1">
            <div class="d-flex flex-wrap align-items-center">
              <div class="progress-data">
                <div id="chart"></div>
              </div>
              <div class="widget-data">
                <div class="h4 mb-0">2020</div>
                <div class="weight-600 font-14">University</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 mb-30">
          <div class="card-box height-100-p widget-style1">
            <div class="d-flex flex-wrap align-items-center">
              <div class="progress-data">
                <div id="chart2"></div>
              </div>
              <div class="widget-data">
                <div class="h4 mb-0">400</div>
                <div class="weight-600 font-14">Volunteer</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 mb-30">
          <div class="card-box height-100-p widget-style1">
            <div class="d-flex flex-wrap align-items-center">
              <div class="progress-data">
                <div id="chart3"></div>
              </div>
              <div class="widget-data">
                <div class="h4 mb-0">350</div>
                <div class="weight-600 font-14">No.of Female</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 mb-30">
          <div class="card-box height-100-p widget-style1">
            <div class="d-flex flex-wrap align-items-center">
              <div class="progress-data">
                <div id="chart4"></div>
              </div>
              <div class="widget-data">
                <div class="h4 mb-0">6060</div>
                <div class="weight-600 font-14">No.of Male</div>
              </div>
            </div>
          </div>
        </div>
      </div>
        
      <div class="row">
            <div class="col-md-4 mb-30">
              <div class="card-box pricing-card-style2">
                <div class="pricing-card-header">
                  <div class="left">
                    <h5>Standard</h5>
                    <p>For small businesses</p>
                  </div>
                  <div class="right">
                    <div class="pricing-price">
                      €10<span>/month</span>
                    </div>
                  </div>
                </div>
                <div class="pricing-card-body">
                  <div class="pricing-points">
                    <ul>
                      <li>2 TB of space</li>
                      <li>120 days of file recovery</li>
                      <li>Smart Sync</li>
                      <li>Dropbox Paper admin tools</li>
                      <li>Granular sharing permissions</li>
                      <li>User and company-managed groups</li>
                      <li>Live chat support</li>
                    </ul>
                  </div>
                </div>
                <div class="cta">
                  <a href="#" class="btn btn-primary btn-rounded btn-lg">Get Started</a>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-30">
              <div class="card-box pricing-card-style2">
                <div class="pricing-card-header">
                  <div class="left">
                    <h5>Advanced</h5>
                    <p>For big businesses</p>
                  </div>
                  <div class="right">
                    <div class="pricing-price">
                      €15<span>/month</span>
                    </div>
                  </div>
                </div>
                <div class="pricing-card-body">
                  <div class="pricing-points">
                    <ul>
                      <li>Everything in Standard</li>
                      <li>As much space as needed</li>
                      <li>Advanced admin controls</li>
                      <li>Dropbox Showcase</li>
                      <li>Tiered admin roles</li>
                      <li>Advanced user management tools</li>
                      <li>Domain verification</li>
                    </ul>
                  </div>
                </div>
                <div class="cta">
                  <a href="#" class="btn btn-primary btn-rounded btn-lg">Get Started</a>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-30">
              <div class="card-box pricing-card-style2">
                <div class="pricing-card-header">
                  <div class="left">
                    <h5>Enterprise</h5>
                    <p>For enterprises</p>
                  </div>
                  <div class="right">
                    <div class="pricing-price">
                      €25<span>/month</span>
                    </div>
                  </div>
                </div>
                <div class="pricing-card-body">
                  <div class="pricing-points">
                    <ul>
                      <li>Everything in Advanced</li>
                      <li>Account Capture</li>
                      <li>Network control</li>
                      <li>Enterprise management support</li>
                      <li>Domain Insights</li>
                      <li>Advanced training for end users</li>
                      <li>24/7 phone support</li>
                    </ul>
                  </div>
                </div>
                <div class="cta">
                  <a href="#" class="btn btn-primary btn-rounded btn-lg">Get Started</a>
                </div>
              </div>
            </div>
          </div>
         
         <div class="row no-gutters">
                        <div class="col-lg-4 col-md-12 col-sm-12">
                          <div class="blog-img" style="background: url(&quot;vendors/images/img3.jpg&quot;) center center no-repeat;">
                            <img src="vendors/images/img3.jpg" alt="" class="bg_img" style="display: none;">
                          </div>
                        </div>
                        <div class="col-lg-8 col-md-12 col-sm-12">
                          <div class="blog-caption">
                            <h4><a href="#">Lorem ipsum dolor sit amet, consectetur adipisicing elit</a></h4>
                            <div class="blog-by">
                              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
                              <div class="pt-10">
                                <a href="#" class="btn btn-outline-primary">Read More</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>    -->
       
    </div>
  </div>
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-119386393-1');
  </script>  
<!--   <script src="src/plugins/sweetalert2/sweetalert2.all.js"></script>
  <script src="src/plugins/sweetalert2/sweet-alert.init.js"></script>  --> 
  <script src="file_3.6.0_jquery.min.js"></script>
  <script src="js_folder/toastr.js"></script>
  <script src="vendors/scripts/core.js"></script>
  <script src="vendors/scripts/script.min.js"></script>
  <script src="vendors/scripts/process.js"></script>
  <script src="vendors/scripts/layout-settings.js"></script> 
  <script src="src/plugins/datatables/js/jquery.dataTables.min.js"></script>
  <script src="src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
  <script src="src/plugins/datatables/js/dataTables.responsive.min.js"></script>
  <script src="src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
  <script src="vendors/scripts/dashboard.js"></script> 
  <script src="requiredfield_validation.min.js"></script>  
    
</body>
</html>