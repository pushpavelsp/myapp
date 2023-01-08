<?php   
include "db_connect.php"; 
$created_date=date("Y/m/d"); 
?>
 
<!DOCTYPE html>
<html>
<?php include "head.php"; ?>  
<body>
  <?php include "header.php"; ?> 
  <!-- <?php include "aside_menu.php"; ?>  -->
  <div class="mobile-menu-overlay"></div>
    <div class="main-container">
     <div class="pd-ltr-20">
<!-- Form grid Start -->
        <div class="pd-20 card-box mb-30">
          <div class="clearfix">
            <div class="pull-left">
              <h4 class="text-blue h4"></h4>
            </div> 
          </div>
          <form id="screen_reader_form_id">
            <div class="col-md-12">
              <h3 align="center" ><b>Screen Reader Access</b></h3>
                <h5 style="color:#894460;" align="center" >Screen reader Access to enable people with visual impairments access the website using assistive technologies, such as screen readers.</h5><br/>
              <font size="3">
                <table align="center" class="table table-striped maincontent">
                  <thead>
                    <tr >
                      <th style="font-weight: bold;font-size:17px;" scope="col" >Screen Reader</th>
                      <th style="font-weight: bold;font-size:17px;" scope="col">Website</th>
                      <th style="font-weight: bold;font-size:17px;" scope="col">Free/Commercial</th>
                    </tr>
                  </thead>
                  <tbody>
                      <tr>
                        <td>Non Visual Desktop Access (NVDA)  </td>
                        <td><a href = "http://www.nvda-project.org/" class ="confirmLink" onclick="confirmFunction()"> http://www.nvda-project.org/</a></td>
                        <td>Free</td>
                      </tr>
                      <tr>
                        <td>Screen Access For All (SAFA)</td>
                         <td> <a href = "http://safa-reader.software.informer.com/2.0" class ="confirmLink"> http://safa-reader.software.informer.com/2.0 </a> </td>
                          <td>Free</td>
                        </tr>
                      <tr>
                        <td>System Access To Go </td>
                        <td><a href = "http://www.satogo.com/" class ="confirmLink"> http://www.satogo.com/ </a> </td>
                        <td>Free</td>
                      </tr>
                      <tr>
                        <td>Thunder</td>
                         <td><a href = "http://www.screenreader.net/index.php?pageid=11" class ="confirmLink"> http://www.screenreader.net/index.php?pageid=11 </a> </td>
                        <td>Free</td>
                      </tr>
                      <tr>
                        <td>Hal</td>
                        <td><a href = "http://www.yourdolphin.co.uk/productdetail.asp?id=5" class ="confirmLink"> http://www.yourdolphin.co.uk/productdetail.asp?id=5 </a> </td>
                         <td>Commercial</td>
                      </tr> 
                      <tr>
                        <td>JAWS</td>
                        <td><a href = "http://www.freedomscientific.com/Products/Blindness/JAWS" class ="confirmLink"> http://www.freedomscientific.com/Products/Blindness/JAWS </a> </td>
                         <td>Commercial</td>
                      </tr>
                      <tr>
                       <td>Supernova</td>
                        <td><a href = "http://www.yourdolphin.co.uk/productdetail.asp?id=1" class ="confirmLink"> http://www.yourdolphin.co.uk/productdetail.asp?id=1 </a> </td>
                         <td>Commercial</td>
                      </tr>
                  </tbody>
                </table>
              </font>
            <hr style="margin-top: -21px;"> 
          </div>
        </form> 
      </div>
<!-- Form grid End -->
     <?php include "footer.php"; ?> 
    </div>
  </div> 
</body>
</html>