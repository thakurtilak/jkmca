var FromEndDate = new Date();
$(document).ready(function () {
    $("#agreement_date").datepicker({format: "d-M-yyyy", autoclose: true, startDate: '-1y',endDate: FromEndDate});
    $("#dob").datepicker({format: "d-M-yyyy", autoclose: true, endDate: FromEndDate});

    /*
     * AgreememntGroupRequired
     * @purpose - Client side validation for agreement row.
     * @Date - 18/01/2018
     * @author - NJ
     */
    $.validator.addMethod("agreementGroupRequired", function (value, element) {
        var $row = $(element).parent().parent().parent();
        if ($row.attr('class') != 'row') {
            $row = $row.parent().parent();
        }
        var $agreement_no = $row.find("input[name='agreement_no']").val();
        var $agreement_date = $row.find("input[name='agreement_date']").val();
        var $fileuploadinput = $row.find("input[name='file-upload-input']").val();
        if ($agreement_no != '' || $agreement_date != '' || $fileuploadinput != '') {
            if (value == '') {
                return false;
            }
        }
        return true;
    }, "Field Can't be empty.");

    $.validator.addMethod("isValidEmail", function (value, element) {
        if (value == '') {
            return true;
        }
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (!expr.test(value)) {
            return false;
        }
        return true;
    }, "Invalid Email Address");

    $.validator.addMethod("pan", function(value, element)
    {
        return this.optional(element) || /^[A-Z]{5}\d{4}[A-Z]{1}$/.test(value);
    }, "Invalid Pan Number");

    $.validator.addMethod("aadhar", function(value, element)
    {
        return this.optional(element) || /^\d{4}\d{4}\d{4}$/.test(value);
    }, "Invalid Aadhar Number");
    /*
     *  Client side validations for add client
     * @purpose - Validations for add client.
     * @Date - 17/01/2018
     * @author - NJ
     */
    $("#mp_add_client_frm").validate({

        rules: {
            first_name: {required: true},
            //last_name: {required: true},
            father_first_name: {required: true},
            //father_last_name: {required: true},
            mobile_number: {required: true, number: true},
            email: { isValidEmail: true},
            pan_no: {pan: true, remote: BASEURL+"clients/check-pan"
                },
            aadhar_no: {aadhar: true, remote: BASEURL+"clients/check-aadhar"},
            dob: {required: true},
            account_person_email: {isValidEmail: true},
            "agreement_no": {agreementGroupRequired: true},
            "agreement_date": {agreementGroupRequired: true},
            "file-upload-input": {agreementGroupRequired: true, extension: "gif|jpg|png|jpeg|pdf|zip|docx|doc|xls|xlsx|eml|msg"},
            address1: {required: true},
            /* address2: {required: true},*/
            state: {required: true},
            country: {required: true},
            city: {required: true},
            zip_code: {required: true, minlength: 6, number: true},
            gst_no: { minlength: 15, maxlength: 15}
        },
        messages: {
            first_name: {required: "This field is required"},
            last_name: {required: "This field is required"},
            father_first_name: {required: "This field is required"},
            father_last_name: {required: "This field is required"},
            mobile_number: {required: "This field is required"},
            pan_no: {required: "This field is required",remote:"Pan number already exist"},
            aadhar_no: {required: "This field is required",remote:"Aadhar number already exist"},
            dob: {required: "This field is required"},
            account_person_email: {isValidEmail: "Please enter a valid email address"},
            "agreement_no": "This field is required",
            "agreement_date": {agreementGroupRequired: "This field is required"},
            "file-upload-input": {agreementGroupRequired: "This field is required", extension: "Invalid file format"},
            address1: {required: "This field is required"},
            state: {required: "This field is required"},
            country: {required: "This field is required"},
            city: {required: "This field is required"},
            gst_no: {
                minlength: 'Invalid GSTIN No.',
                maxlength: 'Invalid GSTIN No.'
            },
            zip_code: {required: "This field is required", number: "Please enter a valid Zip Code"},
        }
    });

    $("#dob").bind("keyup","keydown", function(event) {
        var inputLength = event.target.value.length;
        if(inputLength === 2 || inputLength === 5){
            var thisVal = event.target.value;
            thisVal += '-';
            $(event.target).val(thisVal);
        }
    })

    /*File Handling*/
    $(document).on('click', '.file-upload-button', function () {
        $(this).parent().find("input[type='file']").click();
    });

    $(document).on('change', '.custom-file-upload-hidden', function () {
        var fileID = $(this).attr('id');
        var filename = $("#" + fileID).val().split('\\').pop();
        $("#" + fileID).parent().find(".file-upload-input").val(filename);
    });

    $('#pan_no').keyup(function(){
        $(this).val($(this).val().toUpperCase());
    });
});


