<div class="tab-pane fade" id="uni_pdf_report" role="tabpanel">
<div class="pd-20 profile-task-wrap">
<div class="container pd-0">
    <form id="university_pdf_report">
<table class="table table-bordered">
  <thead class="thead-dark">
    <tr>
      <th scope="col">University Name</th>
      <th scope="col">Coordinator Name</th>
      <th scope="col">No.of college</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?php echo $university_echo['uni_name'];?></td>
      <td><?php echo $coord_echo['coord_name'] ?></td>
      <td><?php echo $university_echo['no_of_clg'];?></td>
    </tr>
</tbody>
</table>

<table class="table table-bordered">
  <thead class="thead-dark">
    <tr>
     <th scope="col">No.of Registered Colleges</th>
      <th scope="col">No.of Un-Registered Colleges</th>
      <!-- <th scope="col">No.of college</th> -->
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?php echo $no_of_reg_clg ?></td>
      <td><?php echo $no_of_unreg_clg ?></td>
     <!--  <td>@mdo</td> -->
    </tr>
</tbody>
</table>


<table class="table table-bordered">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Approved Colleges</th>
      <th scope="col">Disapproved Colleges</th>
      <th scope="col">Pending Colleges</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?php echo $approved_clg_count ?></td>
      <td><?php echo $disapproved_clg_count ?></td>
      <td><?php echo $pending_clg_count ?></td>
    </tr>
</tbody>
</table>


<table class="table table-bordered">
  <thead class="thead-dark">
    <tr>
      <th scope="col">No.of Programme Officers</th>
      <th scope="col">No.of Funded Units</th>
      <th scope="col">No.of Non-Funded Units</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?php echo $no_of_po ?></td>
      <td><?php echo $no_of_funded_unit ?></td>
      <td><?php echo $no_of_nonfunded_unit ?></td>
    </tr>
</tbody>
</table>


<table class="table table-bordered">
  <thead class="thead-dark">
    <tr>
      <th scope="col">No.of Volunteers</th>
      <th scope="col">No.of Boys</th>
      <th scope="col">No.of Girls</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?php echo $no_of_volunteer ?></td>
      <td><?php echo $no_of_vol_boys ?></td>
      <td><?php echo $no_of_vol_girls ?></td>
    </tr>
</tbody>
</table>


<table class="table table-bordered">
  <thead class="thead-dark">
    <tr>
     <th scope="col">No.of SC</th>
      <th scope="col">No.of ST</th>
      <th scope="col">No.of OC</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?php echo $no_of_vol_sc ?></td>
      <td><?php echo $no_of_vol_sc ?></td>
      <td><?php echo $no_of_vol_oc ?></td>
    </tr>
</tbody>
</table>

                   </div>
<div class="row"> 
          <div class="col-sm-12"> 
       <button type="submit"  class="btn btn-primary form_submitbtn_style btn-sm "><i class="icon-copy fa fa-download" aria-hidden="true"></i> <?php echo $labels['print'];?></button> 
          </div> 
        </div>  
        <!-- <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="form-group Secondary ">
                <span class="font-weight-bold">University Name </span>
            </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="form-group ">
                <span ><?php echo $university_echo['uni_name'];?></span>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="form-group Secondary">
                <span class="font-weight-bold">No.of Colleges</span>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="form-group ">
                <span><?php echo $university_echo['no_of_clg'];?></span>
                </div>
            </div>
        </div>

          <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="form-group Secondary">
                <span class="font-weight-bold">No.of Registered Colleges</span>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="form-group ">
                <span><?php echo $no_of_reg_clg ?></span>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="form-group Secondary">
                <span class="font-weight-bold">No.of Non-Registered Colleges</span>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="form-group ">
                <span><?php echo $no_of_unreg_clg ?></span>
                </div>
            </div>
        </div>
        <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="form-group ">
                    <span class="font-weight-bold">Approved Colleges</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group ">
                    <span><?php echo $approved_clg_count ?></span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group ">
                    <span class="font-weight-bold">Disapproved Colleges</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group ">
                    <span><?php echo $disapproved_clg_count ?></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="form-group ">
                    <span class="font-weight-bold">Pending Colleges</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group ">
                    <span><?php echo $pending_clg_count ?></span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group ">
                    <span class="font-weight-bold">No.of Programme Officers</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group ">
                    <span><?php echo $no_of_po ?></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="form-group ">
                    <span class="font-weight-bold">No.of Funded Units</span>
                    </div>  
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group ">
                    <span><?php echo $no_of_funded_unit ?></span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group ">
                    <span class="font-weight-bold">No.of Non-Funded Units</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group ">
                    <span><?php echo $no_of_nonfunded_unit ?></span>
                    </div>
                </div>
            </div>
             <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="form-group ">
                    <span class="font-weight-bold">No.of Volunteers</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group ">
                    <span><?php echo $no_of_volunteer ?></span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group ">
                    <span class="font-weight-bold">No.of Boys</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group ">
                    <span><?php echo $no_of_vol_boys ?></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="form-group ">
                    <span class="font-weight-bold">No.of Girls</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group ">
                    <span><?php echo $no_of_vol_girls ?></span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group ">
                    <span class="font-weight-bold">No.of SC/ST</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group ">
                    <span><?php echo $no_of_vol_sc_st ?></span>
                    </div>
                </div>
            </div>
 -->

        </form> 
      </div>
      <!-- Form grid End -->
    </div>
  </div>
 
</div>  
</div>  
</div>  
 
     