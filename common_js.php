<script type="text/javascript"> 
$( document ).ready(function() {
    $('.readonly').prop('readonly', true);
}); 

function mailvalid(mailids) {  
  var a=$('#'+mailids+'').val();
      var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
      if (reg.test(a) == false ) 
        {   
          toastr.warning('Enter Valid Email ID'); 
          $('#'+mailids+'').val('');
          $('#'+mailids+'').val('').focus(); 
           return false;
        }   
        return true;
}  
function firstnumvalid(num,id) { 
  var fnum = num.slice(0, 1); //alert(lng); 
    if(fnum==6 || fnum==7 || fnum==8 || fnum==9){ 
    }else{
     $('#'+id+'').val(''); 
     $('#lbl'+id+'').html('Mobile No. Starts with 5-9');
    }  
} 
function stdvalid(num,id) { 
  var stdcode1 = num.slice(0, 2);   
  var stdvalid2=stdcode1.length  
    if(stdvalid2==2){  
    if(stdcode1=='04'){  
      $('#lbl'+id+'').html('');
    }else{
    $('#'+id+'').val('');  
    $('#lbl'+id+'').html('STD Code Starts With 04');
    }
    }   
} 

function pincodevalid(pincode,pincodeid) { 
  var pincode2 = pincode.slice(0, 1); //alert(lng); 
    if(pincode2==6){ 
      $('#lbl'+pincodeid+'').html('');
    }else{
     $('#'+pincodeid+'').val(''); 
     $('#lbl'+pincodeid+'').html('Pincode Code Starts With 6');
    }  
} 
function pincodlength(pincode,pincodeid,length) { 
  var pincodelength = pincode.toString().length; //alert(pincodelength); 
    if(pincodelength==6){ 
      $('#'+length+'').text(''); 
    }else{
     $('#'+pincodeid+'').val(''); 
     $('#'+length+'').text('Enter Valid Pincode'); 
     $('#'+pincodeid+'').focus(); 
    }  
} 

function check_countdata(input1,table1,column1,id,mailpassword){     
    $.ajax({ 
        type:'POST',  
        data:{input:input1,table:table1,column:column1,mailpass:mailpassword},
        success:function(data){   
          if(data=='Already'){  //alert(id); 
            $('#lbl'+id+'').text('Registered Already! Thank You!');
            $('#'+id+'').val('').focus();  
          }else{
             $('#lbl'+id+'').text(''); 
          } 
        } 
      }); 
  }  
$('.Edithide').show();
$('.updatebtnshow').hide(); 
$('.disabled').prop('disabled', true); 
$('.image_input').hide(); 
$('.viewbutton').show();
function edithide(btnval){   //alert(btnval);  
  if(btnval !=''){
    $('.Edithide').hide();
    $('.updatebtnshow').show(); 
    $('.image_input').show(); 
    $('.viewbutton').hide(); 
    $('.disabled').prop('disabled', false);
  }else{
    $('.Edithide').show();
    $('.updatebtnshow').hide();
    $('.disabled').prop('disabled', true); 
    $('.image_input').hide(); 
    $('.viewbutton').show();
  } 
}   
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
    return false;
    }
    return true;
  }   
function allowOnlyLetters(e,ids) {  
      var keyCode = e.keyCode || e.which; 
      var lblError = document.getElementById('lbl'+ids);
      lblError.innerHTML = ""; 
      var regex = /^[a-zA-Z\s]*$/; 
      var isValid = regex.test(String.fromCharCode(keyCode));
      if (!isValid) {
          lblError.innerHTML = "Only Alphabets allowed."; 
      } 
      return isValid;
  }
  function fileValidation(ids,err_msg) {  
    var fileInput =
      document.getElementById(''+ids+''); 
    var filePath = fileInput.value; 
// Allowing file type
  var allowedExtensions =/(\.jpg|\.jpeg|\.png)$/i; 
  if (!allowedExtensions.exec(filePath)) { 
    $('#'+err_msg+'').html('your file type jpg,jpeg,png');
    fileInput.value = '';
    return false;
  }else{
    $('#'+err_msg+'').html('');
  }
  /* else
  { 
  // Image preview
  if (fileInput.files && fileInput.files[0]) {
  var reader = new FileReader();
  reader.onload = function(e) {
  document.getElementById(
  'imagePreview').innerHTML =
  '<img src="' + e.target.result
  + '"/>';
  }; 
  reader.readAsDataURL(fileInput.files[0]);
  }
  }*/
// Allowing file size
var inputElement = document.getElementById(''+ids+'')
  var fileLimit = 250; // could be whatever you want 
  var files = inputElement.files;  
  var fileSize = files[0].size; 
  var fileSizeInKB = (fileSize/1024); 
  if(fileSizeInKB < fileLimit){
   // console.log("file go for launch") 
  } else {   
   $('#'+err_msg+'').html('File Size: Max 250KB');
  $('#'+ids+'').val('');
  }
  
  }
 /*
function formeditupdate(check,status,opt){   
  if(check =='1' && status ==''){    
     $('.disabled').prop('disabled', false); 
     $('#Updatehide').hide();
     $('#edithide').show();
  }else if(check =='1' && status !='' && opt ==2){    
     $('#Updatehide').hide();  
     $('#uni_logo').hide();  
     $('#edithide').show();
     $('.viewbutton').show();
    $(".disabled").attr('disabled','disabled');
  }else if(check =='3'){    
     $('#Updatehide').show();
     $('#uni_logo').show();
     $('.disabled').prop('disabled', false); 
     $('#edithide').hide(); 
     $('.viewbutton').hide(); 
  }     
} */
function translate (input,result){ 
  var sourceText = $('#'+input+'').val();  
  var sourceLang = 'en';
  var targetLang = 'ta';  
  var url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl="+ sourceLang + "&tl=" + targetLang + "&dt=t&q=" + encodeURI(sourceText); 
  $.getJSON(url, function(data) {
      $('#'+result+'').val(data[0][0][0]);
    }); 
}   
function status_switch(status,tablename,updatecolumn,wharecolumn,whareid,loginmaill,remarkdata,updatedata,reload_page=''){ //alert(status);
  var status1=status;  
   $.ajax({ 
        type:'POST',  
        data:{switchstatus:status1,table1:tablename,column1:updatecolumn,wharecolumn1:wharecolumn,whareid1:whareid,mailid:loginmaill,remark:remarkdata,update_data:updatedata,reload:reload_page},
        success:function(data){   //alert(data); 
          if(data=='2'){ 
            Swal.fire('Disapproved!', '', 'info') 
            setTimeout(function() {window.history.back();}, 1000);  
          }else if(data=='1'){ 
             Swal.fire('Approved!', '', 'success')
            setTimeout(function() {window.history.back();}, 1000);  
          }else if(data=='3'){  
            setTimeout(function() {window.location.reload();}, 1000); 
          }else if(data==''){  
            setTimeout(function() {window.history.back();}, 1000);  
          }  
        } 
      });
} 
function login_approve_status(status,mail,upadteid1,levelcode){ //alert(status); 
  $.ajax({ 
        type:'POST',   
        data:{loginapproveid:status,mailids:mail,upadteid:upadteid1,level_code:levelcode},
        success:function(data){   
         /* if(data=='approve_status'){
            setTimeout(function() {window.location.reload();}, 500);  
          }*/
        } 
      }); 
}

//aadhar validation
const d = [
      [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
      [1, 2, 3, 4, 0, 6, 7, 8, 9, 5],
      [2, 3, 4, 0, 1, 7, 8, 9, 5, 6],
      [3, 4, 0, 1, 2, 8, 9, 5, 6, 7],
      [4, 0, 1, 2, 3, 9, 5, 6, 7, 8],
      [5, 9, 8, 7, 6, 0, 4, 3, 2, 1],
      [6, 5, 9, 8, 7, 1, 0, 4, 3, 2],
      [7, 6, 5, 9, 8, 2, 1, 0, 4, 3],
      [8, 7, 6, 5, 9, 3, 2, 1, 0, 4],
      [9, 8, 7, 6, 5, 4, 3, 2, 1, 0]
  ]

  // permutation table
  const p = [
      [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
      [1, 5, 7, 6, 2, 8, 3, 0, 9, 4],
      [5, 8, 0, 3, 7, 9, 6, 1, 4, 2],
      [8, 9, 1, 6, 0, 4, 3, 5, 2, 7],
      [9, 4, 5, 3, 1, 2, 6, 8, 7, 0],
      [4, 2, 8, 6, 5, 7, 3, 9, 0, 1],
      [2, 7, 9, 3, 8, 0, 6, 4, 1, 5],
      [7, 0, 4, 6, 9, 1, 3, 2, 5, 8]
  ]

  // validates Aadhar number received as string
  function aadharvalidate(aadharNumber) {
      let c = 0
      let invertedArray = aadharNumber.split('').map(Number).reverse()

      invertedArray.forEach((val, i) => {
          c = d[c][p[(i % 8)][val]]
      })

      return (c === 0)
  }
  function aadharverify(aadharNo,aadhar_error_msg,aadharid) { 
    var aadharNo2 = aadharNo;
    var aadhar_error_msg1 = aadhar_error_msg;
    if(aadharvalidate(aadharNo2)){   
      $('#'+aadhar_error_msg1+'').text('');
    } else { //alert(aadhar_error_msg);alert(aadharid); 
       toastr.error('Your aadhar card no. not valid');
       $('#'+aadharid+'').val('');
    }
  }
  
function dob_calculator(dob,dobid,ageid) {  
    var userinput = dob;  
    var dob = new Date(userinput);  
    var month_diff = Date.now() - dob.getTime();   
    var age_dt = new Date(month_diff); 
    var year = age_dt.getUTCFullYear();  
    var age = Math.abs(year - 1970);  
     $('#'+ageid+'').val(age); 
     //$('#lbl'+dobid+'').html('Please Select Date Of Birth'); 
}  
function ageCalculator() {
        var userinput = document.getElementById("po_dob").value;
        var dob = new Date(userinput);
        if(userinput==null || userinput=='') {
            document.getElementById("message").innerHTML = "**Choose a date please!";  
            return false; 
        } else {
            var month_diff = Date.now() - dob.getTime();
            var age_dt = new Date(month_diff); 
            var year = age_dt.getUTCFullYear();
            var age = Math.abs(year - 1970);
        return document.getElementById("year_calculation_result").value = age;
        }
    }

       
function trained_eti(inputt){ 
  if(inputt=='0'){
    $('.coord_trained_etino').hide();
  }else{
    $('.coord_trained_etino').show();
  }
}   
 

 function address_spec_char(e) {   
    if(e.key=='/' || e.key==',' || e.key=='.' || e.key==' '){  
      return true;    
      e.preventDefault();
    }else{
       var regex = new RegExp("^[a-zA-Z0-9_]+$");
       var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;  
    }
    e.preventDefault();
    return false; 
    }
   
}  

 
</script>
