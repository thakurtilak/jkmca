var FromEndDate = new Date();
$(document).ready(function () {
    $attachmentCloneObje = $("#order_attachment_box_1").clone();

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
            //father_first_name: {required: true},
            //father_last_name: {required: true},
            mobile_number: {required: true, number: true},
            email: { isValidEmail: true},
            pan_no: {pan: true, remote: BASEURL+"clients/check-pan"
                },
            aadhar_no: {aadhar: true, remote: BASEURL+"clients/check-aadhar"},
            //dob: {required: true},
            //account_person_email: {isValidEmail: true},
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
            //father_first_name: {required: "This field is required"},
            //father_last_name: {required: "This field is required"},
            mobile_number: {required: "This field is required"},
            pan_no: {required: "This field is required",remote:"Pan number already exist"},
            aadhar_no: {required: "This field is required",remote:"Aadhar number already exist"},
            //dob: {required: "This field is required"},
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
    });

    /*File Handling*/
    $(document).on('click', '.file-upload-button', function () {
        $(this).parent().find("input[type='file']").click();
    });

    $(document).on('change', '.custom-file-upload-hidden', function () {
        var fileID = $(this).attr('id');
        var filename = $("#" + fileID).val().split('\\').pop();
        $("#" + fileID).parent().find(".file-upload-input").val(filename);
        $("#" + fileID).parent().find(".file-upload-span").text(filename);
    });

    /*Delete single invoice attachment record*/
    $(document).on("click", ".delete_attachment", function() {
        $deleteBox = $(this).parent().parent().parent();
        $deleteBox.remove();
    });

    $(document).on("change", "select[name='add_job_doc[]']", function () {
        if($(this).val() == "0") {
            $(this).next().show();
        } else {
            $(this).next().hide();
        }
    });

    /*Delete job file Model window*/
    $("#deleteFile").on("show.bs.modal", function(e) {
        var id = $(e.relatedTarget).data('target-id');
        var jobFileHref = BASEURL + "clients/delete-file/"+id;
        $("#deleteJobFileForm").prop('action', jobFileHref);

    });

    $('#pan_no').keyup(function(){
        $(this).val($(this).val().toUpperCase());
    });
});

function addMoreAttachment() {
    //$(".delete_attachment").show();
    //var nextIndex = $(".attachtype").length + 1;
    var LastEl = $(".order_attachment_box").last();
    var lastid = LastEl.attr("id");
    var LastIdParts = lastid.split("order_attachment_box_");
    var lenth = LastIdParts[1];
    var nextIndex = parseInt(lenth) + 1;
    $attachmentCloneObje.attr({id:"order_attachment_box_"+nextIndex});

    if($attachmentCloneObje.find("select[name^='job_doc[']").length > 0) {
        $attachmentCloneObje.find("select[name^='job_doc[']").attr({
            name: "add_job_doc[]",
            id: "job_doc" + nextIndex,
            value: ""
        });
        $attachmentCloneObje.find("option[selected]").removeAttr("selected");
    } else {
        $attachmentCloneObje.find("select[name^='add_job_doc[']").attr({
            name: "add_job_doc[]",
            id: "job_doc" + nextIndex,
            value: ""
        });
        $attachmentCloneObje.find("option[selected]").removeAttr("selected");
    }
    //var nextIndex = $(".file-upload-wrapper").length + 1;
    $attachmentCloneObje.find(".file-upload-wrapper").attr("id","file-upload-wrapper_"+nextIndex);

    if($attachmentCloneObje.find("input[name^='add_document_name[']").length > 0) {
        $attachmentCloneObje.find("input[name^='add_document_name[']").attr({id:"document"+nextIndex,value:""});
        $attachmentCloneObje.find("input[name^='add_document_name[']").attr({name:"add_document_name[]"});
    } else {
        $attachmentCloneObje.find("input[name^='add_document_name[']").attr({id:"document"+nextIndex,value:''});
        $attachmentCloneObje.find("input[name^='add_document_name[']").attr({name:"add_document_name[]"});
    }
    $attachmentCloneObje.find(".file-upload-span").html("");
    $attachmentCloneObje.find("input[name^='file-upload-input[']").attr({name:"file-upload-input[]" ,id:"file-upload-input_"+nextIndex, value:""});
    $attachmentCloneObje.find("label[for^=file-upload-input]").attr({id:"file-upload-input_"+nextIndex+"-error", for:"file-upload-input_"+nextIndex});

    //$attachmentCloneObje.find(".add_more_btn").attr("id", "add_more_btn_' + nextIndex);
    $attachmentCloneObje.find(".delete_record ").attr("id", "delete_record_" + nextIndex);

    //$attachmentCloneObje.find(".add_more_btn").hide();
    $attachmentCloneObje.find(".delete_attachment").show();

    $cloneHtml = $attachmentCloneObje.wrap("<div>").parent().html();
    //$(".add_more_attach_inv").parent().before($cloneHtml);
    $(".job-documents-wrapper").append($cloneHtml);
}


