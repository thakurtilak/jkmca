//var $ = jQuery;
$(document).ready(function () {

    $.validator.addMethod("pan", function(value, element)
    {
        return this.optional(element) || /^[A-Z]{5}\d{4}[A-Z]{1}$/.test(value);
    }, "Invalid Pan Number");

    $.validator.addMethod("aadhar", function(value, element)
    {
        return this.optional(element) || /^\d{4}\d{4}\d{4}$/.test(value);
    }, "Invalid Aadhar Number");

    $("#tempJobCard").validate({
        ignore: ":hidden:not(.file-upload-input)",
        rules: {
            first_name: {required: true},
            father_first_name : {required: true},
            work_type: {required: true},
            staff: {required: true},
            pan_no: {required: '#aadhar_no:blank', pan:true},
            aadhar_no:{required:'#pan_no:blank',aadhar:true},
            mobile_number:{required:true}
        },
        messages: {
            first_name: {required: "This field is required"},
            father_first_name : {required: "This field is required"},
            work_type: {required: "This field is required"},
            pan_no: {required: "This field is required"},
            aadhar_no: {required: "This field is required"},
            staff: {required: "This field is required"},
            mobile_number:{required:"This field is required"}
        }
    });

    $("#aadhar_no, #pan_no").blur(function () {
       var searchKey = $(this).val();
       var isFieldValid =  $(this).valid();
       var eleID = $(this).attr('id');
       if(isFieldValid && searchKey) {
           $.ajax({
               type: "POST",
               url: BASEURL+"inquiry/getClientDetails",
               data: {searchKey:searchKey},
               beforeSend: function() {
                   // setting a timeout
                   $(".loader-wrapper").show();
               },
               success: function (data){
                   response = JSON.parse(data);
                   if(response.clientDetail) {
                     populateClientDetails(response);
                   } /*else {
                        $("#first_name").val("");
                        $("#last_name").val('');
                    
                        $("#father_first_name").val('');
                        $("#father_last_name").val('');
                        if(eleID == 'pan_no') {
                            $("#aadhar_no").val('');
                        } else {
                            $("#pan_no").val('');
                        }
                        $("#mobile_number").val('');
                        $("#client_id").val('');
                   }*/
               },
               error: function (error) {
                   $(".loader-wrapper").hide();
               },
               complete: function() {
                   $(".loader-wrapper").hide();
               }
           });
       }

    });

    
});

function populateClientDetails(response) {
    response = response.clientDetail;
    $("#first_name").val(response.first_name);
    $("#last_name").val(response.last_name);

    $("#father_first_name").val(response.father_first_name);
    $("#father_last_name").val(response.father_last_name);

    $("#mobile_number").val(response.mobile);
    $("#pan_no").val(response.pan_no);
    $("#aadhar_no").val(response.aadhar_number);
    $("#client_id").val(response.client_id);
}
