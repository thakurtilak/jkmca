var FromEndDate = new Date();
//var $ = jQuery;
$(document).ready(function () {
    $(".income_tax_work").hide();

    /* Clone Fields*/
    $incomeBoxCloneObje = $("#income_box_1").clone();
    $attachmentCloneObje = $("#order_attachment_box_1").clone();

    $("#completion_date").datepicker({format: "d-M-yyyy", autoclose: true, startDate: FromEndDate});

    $("#jobCards").validate({
        ignore: ":hidden:not(.file-upload-input)",
        rules: {
            client: {required: true},
            client_code : {required: true},
            work_type: {required: true},
            price: {required: true},
            staff: {required: true},
            completion_date: {required: true},
            "file-upload-input": {required: true,extension:"gif|jpg|png|jpeg|pdf|zip|docx|doc|xls|xlsx|eml|msg"},
            "add_job_doc[]" : {required: true},
            "file-upload-input[]": {required: true,extension:"gif|jpg|png|jpeg|pdf|zip|docx|doc|xls|xlsx|eml|msg"}
        },
        messages: {
            client: {required: "This field is required"},
            client_code : {required: "This field is required"},
            work_type: {required: "This field is required"},
            price: {required: "This field is required"},
            staff: {required: "This field is required"},
            completion_date: {required: "This field is required"},
            "file-upload-input": {required: "This field is required",extension:"Invalid file format"},
            "add_job_doc[]" : {required: "This field is required"},
            "file-upload-input[]": {required: "This field is required",extension:"Invalid file format"}
        }
    });

    $("#client_search").keyup(function () {
       var searchKey = $(this).val();
       if(searchKey.length >= 3) {
           $.ajax({
               type: "POST",
               url: BASEURL+"jobs/getClientList",
               data: {searchKey:searchKey},
               beforeSend: function() {
                   // setting a timeout
                   $(".loader-wrapper").show();
               },
               success: function (data){
                   $("#clientListTable").html(data);
               },
               error: function (error) {
                   $(".loader-wrapper").hide();
                   alert("There is an error while getting clients. Please try again.");
               },
               complete: function() {
                   $(".loader-wrapper").hide();
               }
           });
       }

    });

    $("#work_type").change(function () {
        var workType = $(this).val();
        displayWorkTypeForm(workType);
        var clientId = $("input[name='client']:checked").val();
        if(workType){
            $.ajax({
                type: "POST",
                url: BASEURL+"jobs/getDetailByWorkType",
                data: {work_type:workType, clientId:clientId},
                beforeSend: function() {
                    // setting a timeout
                    $(".loader-wrapper").show();
                },
                success: function (res) {
                    data = JSON.parse(res);
                    $("#price").attr("readonly", "readonly");
                    $("#price").val(data.price);
                    $("#remaining_amount").val(data.price);
                    $("#formFields").html(data.formFields);
                },
                error: function (error) {
                    $(".loader-wrapper").hide();
                    alert("There is an error while getting clients. Please try again.");
                },
                complete: function() {
                    $(".loader-wrapper").hide();
                }
            });
        }
    });

    $("#completion_date").bind("keyup","keydown", function(event) {
        var inputLength = event.target.value.length;
        if(inputLength === 2 || inputLength === 5){
            var thisVal = event.target.value;
            thisVal += "-";
            $(event.target).val(thisVal);
        }
    });

    $(document).on("change",".source_of_income", function () {
        var Stype = $(this).val();
        var typeSelf = this;
        $.ajax({
            type: "POST",
            url: BASEURL+"jobs/getIncomeSourceFields",
            data: {type:Stype},
            beforeSend: function() {
                // setting a timeout
                $(".loader-wrapper").show();
            },
            success: function (data) {
                $(typeSelf).parent().parent().parent().find(".remove-fields").remove();
                $(typeSelf).parent().parent().parent().append(data);
            },
            error: function (error) {
                $(".loader-wrapper").hide();
                alert("There is an error while getting clients. Please try again.");
            },
            complete: function() {
                $(".loader-wrapper").hide();
            },
        });
    });

    $("#editPrice").click(function () {
        $("#price").removeAttr("readonly");
        $("#price").focus();
    });

    $("#price").keyup(function () {
        var price = $(this).val();
        var ad = $("#advance_price").val();
        if(parseFloat(ad) > parseFloat(price)) {
            $("#advance_price").val("");
            ad = 0;
        }
        var remaining_amount = price;
        if(ad > 0) {
            remaining_amount = price - ad;
        }
        $("#remaining_amount").val(remaining_amount);
    });

    $("#advance_price").keyup(function () {
        var ad = $(this).val();
        var price = $("#price").val();
        if(parseFloat(ad) > parseFloat(price)) {
            $(this).val("");
            ad = 0;
            alert("Invalid advance amount");
            //return;
        }
        var remaining_amount = price;
        if(ad > 0) {
            remaining_amount = price - ad;
        }
        $("#remaining_amount").val(remaining_amount);
    });

    /*File Handling*/
    $(document).on("click", ".file-upload-button", function () {
        $(this).parent().find("input[type='file']").click();
    });
    $(document).on("change", ".custom-file-upload-hidden", function () {
        var fileID = $(this).attr("id");
        var filename = $("#" + fileID).val().split("\\").pop();
        $("#" + fileID).parent().find(".file-upload-input").val(filename);
    });

    $(document).on("change", ".custom-file-upload-hidden1", function () {
        var fileID = $(this).attr("id");
        //alert(fileID);
        var filename = $("#" + fileID).val().split("\\").pop();
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
});

function displayWorkTypeForm(workType) {
    if(workType == "2"){
        $(".income_tax_work").show();
    } else {
        $(".income_tax_work").hide();
    }
}

function populateClientDetails(response) {

    if (!populateClientDetails){
        alert("Unable to load client details." );
        return;
    }
    response = JSON.parse(response);
    $("#clientDocumentSec").html(response.clientDocumentHtml);
    response = response.clientDetail;
    $("#first_name").val(response.first_name);
    $("#middle_name").val(response.middle_name);
    $("#last_name").val(response.last_name);

    $("#father_first_name").val(response.father_first_name);
    $("#father_middle_name").val(response.father_middle_name);
    $("#father_last_name").val(response.father_last_name);

    $("#mobile_number").val(response.mobile);
    $("#pan_no").val(response.pan_no);
    $("#aadhar_no").val(response.aadhar_number);
    $("#dob").val(response.dob);

    $address = response.address1+" "+response.address2;
    $address += ", "+response.city +" "+response.zip_code;
    $("#address").val($address);
}

function addMoreIncome() {
    var $total = $(".income_box").length;
    if($total >= 6) {
        alert("You can not add more source of income");
        return;
    }
    $incomeBoxCloneObje = $("#income_box_1").clone();
    var LastEl = $(".income_box").last();
    var lastid = LastEl.attr("id");
    if(lastid == undefined) {
        var nextIndex = 1;
    } else {
        var LastIdParts = lastid.split("income_box_");
        var lenth = LastIdParts[1];
        var nextIndex = parseInt(lenth) + 1;
    }
    $incomeBoxCloneObje.attr("id", "income_box_"+nextIndex)

    $cloneHtml = $incomeBoxCloneObje.wrap("<div>").parent().html();
    $(".income_box").parent().append($cloneHtml);
}

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