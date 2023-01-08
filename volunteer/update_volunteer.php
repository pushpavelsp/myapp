<div class="tab-pane fade" id="vol_update_profile" role="tabpanel">
<div class="pd-20 profile-task-wrap">
<div class="container pd-0">
    <form id="volunteer_update_form_id">
          <div class="row">
<!--  volunteer name(English) -->
            <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['vol_name'];?><span style="color: green"> (Initial)</span><span class="required_symbol">* </span></label>
                <input type="text" class="form-control " name="vol_name" id="vol_name" onkeypress="return allowOnlyLetters(event ,'vol_name');" value="<?php echo $vol_echo1['vol_name'];?>">
                <span id="lblvol_name" class="required_error_msg"></span>

              </div>
            </div>
<!--  volunteer name(Tamil)-->
            <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['vol_name'];?><span style="color: green"> (Initial)</span><span class="required_symbol">* </span></label>
                <input type="text" class="form-control " name="vol_name_tamil" id="vol_name_tamil" value="<?php echo $vol_echo1['vol_name_tamil'];?>">
                <span id="lblvol_name_tamil" class="required_error_msg"></span>
              </div>
            </div>
<!--  Gender -->
            <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['gender'];?> <span class="required_symbol">*</span></label><br>
                <select name="vol_gender" placeholder="Select Gender" id="vol_gender" class="form-control ">
                  <option value="">Select</option>
                  <?php
                          foreach ($gender_codes as $genderkey => $gendervalue) { 
                              if($vol_echo1['vol_gender']==$genderkey){  ?>
                                  <option value="<?php echo $genderkey;?>" selected><?php echo $gendervalue;?></option>
                         <?php   }else{ ?> 
                    <option value="<?php echo $genderkey;?>"><?php echo $gendervalue;?></option>
                  <?php  }
                               
                              } ?>
              
                </select>
                <span id="lblgender" class="required_error_msg"></span>
              </div>
          </div>
          </div>
          <div class="row"> 
<!--  Date Of Birth -->
            <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['dob'];?><span class="required_symbol">*</span></label>
                <input type="text" class="form-control date-picker" name="vol_dob" id="vol_dob" onchange="dob_calculator(this.value,'lblvol_dob','vol_age')" value="<?php echo $volunteer_dob[0];?>">
                <span id="lblvol_dob" class="required_error_msg"></span>
              </div>
            </div>
<!--  Father name -->
            <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['father_name'];?><span class="required_symbol">*</span></label>
                <input type="text" class="form-control " name="vol_father_name" id="vol_father_name" onkeypress="return allowOnlyLetters(event,'vol_father_name');" value="<?php echo $vol_echo1['vol_father_name'];?>">
                <span id="lblvol_father" class="required_error_msg"></span>
              </div>
            </div>

<!--  Email Id -->
            <div class="col-md-4 col-sm-12">
             <div class="form-group ">
              <label><?php echo $labels['email_id'];?><span class="required_symbol">*</span></label>
              <input type="text"  class="form-control emailcls mailcls" name="vol_email" id="vol_email" onchange="check_countdata(this.value,'volunteer','vol_email','vol_email'); mailvalid('vol_email');" value="<?php echo $vol_echo1['vol_email'];?>" disabled> 
              <span id="lblvol_email" class="required_error_msg"></span>
             </div>
            </div>
          </div>
          <div class="row">
<!--  Mobile Number -->
            <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['mobileno'];?><span class="required_symbol">*</span></label>
                <input type="text" class="form-control "  name="vol_mobile" id="vol_mobile" maxlength="10" onkeypress="return isNumber(event);" onchange="check_countdata(this.value,'volunteer','vol_mobile','vol_mobile');" onkeyup="firstnumvalid(this.value,'vol_mobile');" value="<?php echo $vol_echo1['vol_mobile'];?>">
                <span id="lblvol_mobile" class="required_error_msg"></span>
              </div>
            </div>
<!--select Aadhar /virtual Id -->
           <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['aadhaarno_r_virtual'];?></label>
                  <select class="custom-select col-12" name="aadhaar_r_virtual" id="aadhaar_r_virtual" onchange="select_proof(this.value);">
                   <option value="" >Select</option> 
                   <option hidden="true"  value="null"><?php echo $labels['choose'];?></option> 
                    <?php
                  foreach ($aad_vir_codes as $aad_virkey => $aad_virvalue) { 
                    if($vol_echo1['vol_aadhaar_or_virtual']==$aad_virkey){  ?>
                      <option value="<?php echo $aad_virkey;?>" selected><?php echo $aad_virvalue;?></option>
                  <?php   }else{ ?> 
                    <option value="<?php echo $aad_virkey;?>"><?php echo $aad_virvalue;?></option>
                  <?php  }
                } ?>
          </select>
                <span id="lblaadhaar_r_virtual" class="required_error_msg"></span>
              </div>
            </div>           
<!-- Aadhaar Number-->
            <div class="col-md-4 col-sm-12">
                <div class="form-group aadhaarno"> 
                <label><?php echo $labels['aadhaarno'];?></label>
                <input type="text" class="form-control" name="vol_aadhaar" id="vol_aadhaar" onchange="check_countdata(this.value,'volunteer','vol_aadhaar','vol_aadhaar');aadharverify(this.value,'lblvol_aadhaar','vol_aadhaar');" onkeypress="return isNumber(event);" maxlength="12" value="<?php echo $vol_echo1['vol_aadhaar'];?>">
                <span id="lblvol_aadhaar" class="required_error_msg"></span>
              </div> 
<!-- Virtual ID-->
                <div class="form-group virtualid"> 
                <label><?php echo $labels['virtualid'];?></label>
                  <input type="text" class="form-control" name="vol_virtual" id="vol_virtual" onchange="check_countdata(this.value,'volunteer','virtualid','vol_virtual');" onkeypress="return isNumber(event);" maxlength="16" value="<?php echo $vol_echo1['vol_virtual'];?>">
                <span id="lblvol_virtual" class="required_error_msg"></span>
              </div>
          </div>
        </div>
          <div class="row">

<!-- Community -->
            <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['community'];?><span class="required_symbol">*</span></label>
                  <select class="form-control " name="vol_community" id="vol_community">
                    <option value="">Select</option>
               <?php
                  foreach ($community_codes as $communitykey => $communityvalue) { 
                    if($vol_echo1['vol_community']==$communitykey){  ?>
                      <option value="<?php echo $communitykey;?>" selected><?php echo $communityvalue;?></option>
                  <?php   }else{ ?> 
                    <option value="<?php echo $communitykey;?>"><?php echo $communityvalue;?></option>
                  <?php  }
                } ?>
                </select>
                <span id="lblvol_community" class="required_error_msg"></span>
              </div>
            </div>
<!-- degree course -->


              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                <label><?php echo $labels['degree_course'];?><span class="required_symbol">*</span></label>
                  <select class="form-control" name="vol_degree_course" id="vol_degree_course">
                    <option value="">Select</option>
                 <?php
                  foreach ($degree_name as $degree_coursekey => $degree_coursevalue) { 
                    if($vol_echo1['vol_degree_id']==$degree_coursekey){  ?>
                      <option value="<?php echo $degree_coursekey;?>" selected><?php echo $degree_coursevalue;?></option>
                  <?php   }else{ ?> 
                    <option value="<?php echo $degree_coursekey;?>"><?php echo $degree_coursevalue;?></option>
                  <?php  }
                } ?>

                </select>
                  <span id="lblvol_degree_course" class="required_error_msg"></span>
                </div>
              </div>
<!-- Year of Admission -->            
            <div class="col-md-4 col-sm-12">
              <div class="form-group" >
                <label><?php echo $labels['adm_year'];?><span class="required_symbol">*</span></label> 
                <input type="text" class="form-control date-picker" name="vol_adm_year" id="vol_adm_year" value="<?php echo $vol_echo1['vol_adm_year'];?>">
                <span id="lblvol_adm_year" class="required_error_msg"></span>
              </div>
            </div>
          </div>
          <div class="row">
<!-- Address -->
              <div class="col-md-8 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['address'];?><span class="required_symbol">*</span></label> 
                <input type="text" class="form-control " name="vol_address" id="vol_address" maxlength="250" value="<?php echo $vol_echo1['vol_address'];?>"  onkeypress="return address_spec_char(event);">
                <span id="lblvol_address" class="required_error_msg"></span>
              </div>
            </div>
<!--  District -->
            <div class="col-md-4 col-sm-12">
                <div class="form-group ">
                <label><?php echo $labels['district'];?><span class="required_symbol">*</span></label>
                <select class="form-control " name="vol_district" id="vol_district">
                  <option value="">Select</option>
                 <?php
          foreach ($district_codes as $districtkey => $districtvalue){ 
                    if($vol_echo1['vol_district']==$districtkey){  ?> 
                      <option value="<?php echo $districtkey;?>" selected><?php echo $districtvalue;?></option>
                    <?php }else{  ?> 
                      <option value="<?php echo $districtkey;?>"><?php echo $districtvalue;?></option>
                    <?php   
                  }
                  }  ?>


                
                </select>
                <span id="lblvol_district" class="required_error_msg"></span>
                </div>
              </div>


          </div>
          <div class="row">
<!--  Pincode-->
              <div class="col-md-4 col-sm-12">
                <div class="form-group ">
                  <label><?php echo $labels['pincode'];?><span class="required_symbol">*</span></label>
                  <input type="text" class="form-control "  name="vol_pincode" id="vol_pincode" maxlength="6" onkeypress="return isNumber(event); pincodevalid(this.value,'vol_pincode');" onchange="pincode_validation(event,'vol_pincode');" value="<?php echo $vol_echo1['vol_pincode'];?>">
                   <span id="lblvol_pincode" class="required_error_msg"></span>
                </div>
              </div>  
<!--Program Officer Name-->
            <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['po_name'];?><span class="required_symbol">*</span></label>
                  
                <input type="text" class="form-control "  name="vol_po_name" id="vol_po_name" maxlength="6" value=" <?php echo $po_codes[$vol_echo1['vol_po_name']];?> ">
               
              
                <span id="lblvol_po_name" class="required_error_msg"></span>
              </div>
            </div>
<!-- Date of Join in Nss -->
            <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['yr_join_nss'];?><span class="required_symbol">*</span></label> 
                <input type="text" class="form-control date-picker" name="vol_doj_nss" id="vol_doj_nss" value="<?php echo $vol_echo1['vol_doj_nss'];?>" >
                <span id="lblvol_doj_nss" class="required_error_msg"></span>
              </div>
            </div>
          </div>
          <div class="row">
<!--  Blood Group --> 
            <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['blood_group'];?><span class="required_symbol">*</span></label>
                <select class="form-control " name="vol_blood_group" id="vol_blood_group">
                <option value="">Select</option>   
                   <?php
                  foreach ($bloodgroup_codes as $bloodgroupkey => $bloodgroupvalue) { 
                    if($vol_echo1['vol_blood_group']==$bloodgroupkey){  ?>
                      <option value="<?php echo $bloodgroupkey;?>" selected><?php echo $bloodgroupvalue;?></option>
                  <?php   }else{ ?> 
                    <option value="<?php echo $bloodgroupkey;?>"><?php echo $bloodgroupvalue;?></option>
                  <?php  }
                } ?>
                </select>    
                <span id="lblvol_blood_group" class="required_error_msg"></span> 
              </div>
            </div> 
<!--  Blood Donation -->
            <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['blood_don'];?><span class="required_symbol">*</span></label><br> 
                <div class="form-check form-check-inline ">
                  <input class="form-check-input " type="radio" name="vol_blood_dona" id="vol_blood_dona" value="Y" <?php echo ($vol_echo1['vol_blood_dona'] == "Y" ? 'checked="checked"': ''); ?>>
                  <label class="form-check-label" for="inlineRadio1" ><?php echo $labels['yes'];?></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input " type="radio" name="vol_blood_dona" id="vol_blood_dona" value="N" <?php echo ($vol_echo1['vol_blood_dona'] == "N" ? 'checked="checked"': ''); ?>>
                  <label class="form-check-label" for="inlineRadio2"><?php echo $labels['no'];?></label>
                </div>
              </div>
              <span id="lblvol_blood_dona" class="required_error_msg"></span>
            </div>  
<!--  Willing to work in emergency -->
            <div class="col-md-4 col-sm-12">
              <div class="form-group ">
                <label><?php echo $labels['emerg_ser_willing'];?><span class="required_symbol">*</span></label><br>
                <div class="form-check form-check-inline">
                  <input class="form-check-input " type="radio" name="vol_emerg_ser_willing" id="vol_emerg_ser_willing" value="Y" <?php echo ($vol_echo1['vol_blood_dona'] == "Y" ? 'checked="checked"': ''); ?>>
                  <label class="form-check-label" for="inlineRadio2"><?php echo $labels['yes'];?></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input " type="radio" name="vol_emerg_ser_willing" id="vol_emerg_ser_willing" value="N" <?php echo ($vol_echo1['vol_blood_dona'] == "N" ? 'checked="checked"': ''); ?>>
                  <label class="form-check-label" for="inlineRadio2"><?php echo $labels['no'];?></label>
                </div>
              </div>
            </div>
            <span id="lblvol_emerg_ser_willing" class="required_error_msg"></span>
       
          </div>
       <div class="row">
 <!--Volunteer Photo-->  
         <div class="col-md-6 col-sm-12">
          <div class="form-group">
            <label><?php echo $labels['vol_photo'];?><span style="color: green;font-size: small;">     jpg,jpeg,png(250kb)</span></label>
            <input type="file" class="form-control-file form-control height-auto " name="vol_photo"  id="vol_photo"  onchange="return fileValidation('vol_photo','err_msg');" value="<?php echo $vol_echo1['vol_photo'];?>">  
            <span id="err_msg" class="required_error_msg"></span>
          </div>
        </div>      
<!--Talents -->             
    <div class="col-md-6 col-sm-12">
      <div class="form-group">
        <label><?php echo $labels['talents'];?></label>
          <select class="selectpicker form-control" data-size="5" multiple data-max-options="4" name="vol_talents[]" id="vol_talents"> 
          <option value="">Select</option>
             <?php
             $vol_talents1=json_decode($vol_echo1['vol_talents'],true);
                  foreach ($talents_codes as $talentskey => $talentsvalue) {  
                    if (in_array($talentskey, $vol_talents1)){  ?>
                      <option value="<?php echo $talentskey;?>" selected><?php echo $talentsvalue;?></option>
                  <?php   }else{ ?> 
                    <option value="<?php echo $talentskey;?>"><?php echo $talentsvalue;?></option>
                  <?php  }
                } ?>

          </select>    
      </div>
      <!-- <span id="lblvol_talents" class="required_error_msg"></span>-->
    </div>
 
       </div>
   
  <div class="row">
<!--List out Talents -->              
          <div class="col-md-12 col-sm-12">
            <div class="form-group ">
              <label><?php echo $labels['list_talents'];?><span style="color: green;font-size: small;">     (Minimun 2-3 Line description)</span></label> 
              <textarea class="form-control " name="vol_list_talents" id="vol_list_talents" maxlength="500" ><?php echo $vol_echo1['vol_list_talents'];?></textarea>
              <span id="lblvol_list_talents" class="required_error_msg"></span>
            </div>
          </div>
       </div>
<!--Submit Button -->     
        <div class="row"> 
          <div class="col-sm-12">  
       <button type="submit" class="btn btn-primary form_submitbtn_style"><?php echo $labels['update'];?></button> 
          </div> 
        </div>  
        </form> 
      </div>
      <!-- Form grid End -->
    </div>
  </div>
 
</div>  
</div>  
</div>  
 
     