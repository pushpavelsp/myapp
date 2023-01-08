<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>NSS - Goverment of Tamil nadu</title>

	<!-- Site favicon -->
	<link rel="shortcut icon" type="image.png" href="/vendors/images/favicon.png">

	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo Base_url;?>/vendors/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo Base_url;?>/vendors/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo Base_url;?>/vendors/images/favicon-16x16.png">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo Base_url;?>/src/plugins/sweetalert2/sweetalert2.css">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo Base_url;?>/vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Base_url;?>/vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Base_url;?>/src/plugins/datatables/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Base_url;?>/src/plugins/datatables/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Base_url;?>/vendors/styles/style.css"> 
	<link rel="stylesheet" type="text/css" href="<?php echo Base_url;?>/toastr_page.css"> 
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-119386393-1');
  </script>
	<style type="text/css"> 
.error
{
color:red; 
}


/*begin swall staus*/
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
 /*end swall staus*/ 
.required_error_msg {
  color: red;font-size: small;
}
.form_submitbtn_style {
  float: right;
}
.left-side-bar { 
background: #3317a0!important;
}
.breadcrumb{
  display: flex;
justify-content: flex-end!important;
    margin-top: -12px;
    margin-bottom: -0px;
}
.required_symbol{
      color: red;font-size: small;
      margin-left: 5px;
}
	</style>
</head>