    /**
     * Created by nishi.jain on 09-Jan-18.
     */
    var FromEndDate = new Date();
    var $validator;
    $(document).ready(function () {
        getClientDetails($clientId);

        $("#reset").click(function(){
            location.reload();
        });
        /* Clone Fields*/
        $salesCloneObje = $("#sales_person_row_1").clone();
        $accountCloneObje = $("#account_person_row_1").clone();
        $agreementCloneObje = $("#agreement_row_1").clone();
        $(".agreement_date").datepicker({format: "d-M-yyyy",autoclose: true,startDate: '-1y',endDate: FromEndDate});


        /*
         * salesGroupRequired
         * @purpose - Client side validation for SalesPerson row.
         * @Date - 18/01/2018
         * @author - NJ
         */
        $.validator.addMethod("salesGroupRequired", function(value, element) {
            var $row = $(element).parent().parent().parent();
            var $sales_person_name = $row.find("input[name='sales_person_name[]']").val();
            var $sales_contact_no = $row.find("input[name='sales_contact_no[]']").val();
            var $sales_person_email = $row.find("input[name='sales_person_email[]']").val();
            if($sales_person_name!='' || $sales_contact_no !='' || $sales_person_email !='' ) {
                if(value == ''){
                    return false;
                }
            }
            return true;
        }, "Field Can't be empty.");

        /*
         * accountGroupRequired
         * @purpose - Client side validation for AccountPerson row.
         * @Date - 18/01/2018
         * @author - NJ
         */
        $.validator.addMethod("accountGroupRequired", function(value, element) {
            var $row = $(element).parent().parent().parent();
            var $account_person_name = $row.find("input[name='account_person_name[]']").val();
            var $account_contact_no = $row.find("input[name='account_contact_no[]']").val();
            var $account_person_email = $row.find("input[name='account_person_email[]']").val();
            if($account_person_name!='' || $account_contact_no !='' || $account_person_email !='' ) {
                if(value == ''){
                    return false;
                }
            }
            return true;
        }, "Field Can't be empty.");

        /*
         * AgreememntGroupRequired
         * @purpose - Client side validation for agreement row.
         * @Date - 18/01/2018
         * @author - NJ
         */
        $.validator.addMethod("agreementGroupRequired", function(value, element) {
            var $row = $(element).parent().parent().parent();
            if($row.attr('class') != 'row') {
                $row = $row.parent().parent();
            }
            var $agreement_no = $row.find("input[name^='agreement_no[']").val();
            var $agreement_date = $row.find("input[name^='agreement_date[']").val();
            var $fileuploadinput = $row.find("input[name='file-upload-input[]']").val();
            if($agreement_no!='' || $agreement_date !='' || $fileuploadinput !='' ) {
                if(value == ''){
                    return false;
                }
            }
            return true;
        }, "Field Can't be empty.");

        $.validator.addMethod("agreementGroupRequired1", function(value, element) {
            var $row = $(element).parent().parent().parent();
            if($row.attr('class') != 'row') {
                $row = $row.parent().parent();
            }
            var $agreement_no = $row.find("input[name='add_agreement_no[]']").val();
            var $agreement_date = $row.find("input[name='add_agreement_date[]']").val();
            var $fileuploadinput = $row.find("input[name='add_file-upload-input[]']").val();
            if($agreement_no!='' || $agreement_date !='' || $fileuploadinput !='' ) {
                if(value == ''){
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
        }, "Please enter a valid Email Address");

        $.validator.addClassRules("emailaddressFACK", { /*removed*/
            isValidEmail: true
        });
        $.validator.addClassRules("sales_person_required", { /*removed*/
            required: true
        });

        $.validator.addClassRules("account_person_required", { /*removed*/
            required: true
        });
        /*
         * getClientByCategoryId
         * @purpose - To get client according to category selected.
         * @Date - 18/01/2018
         * @author - NJ
         */
        $("#category_id").on('change',function(){
            var categoryId  = $(this).val();
            $.ajax({
                type: "POST",
                url: BASEURL+"clients/getClientByCategory",
                data: {cat_id:categoryId},
                beforeSend: function() {
                    // setting a timeout
                    $('.loader-wrapper').show()
                },
                success: function (data) {
                    $("#client").html('');
                    $("#client").html(data);
                },
                error: function (error) {
                    $('.loader').hide();
                    alert("There is an error while getting clients. Please try again.");
                },
                complete: function() {
                    $('.loader-wrapper').hide();
                },
            });

        });

        /*
         * Populate fields on the basis of country.
         * @purpose - Autopopulate fields if country is india.
         * @Date - 18/01/2018
         * @author - NJ
         */
        $("#country").on('change', function(){
            var countryId = $(this).val();
            if(countryId == 101) {
                $(".client-extra-details").show();
            } else {
                $(".client-extra-details").hide();
                $("#state").val('');
                $("#city").val('');
                $("#zip_code").val('');
                $("#gst_no").val('');
                $("#place_of_supply").val('');
            }
        });

        /*
         * getInfoByClientId.
         * @purpose - Populate clients details.
         * @Date - 18/01/2018
         * @author - NJ
         */
        $("#client").on('change',function(){
            var clientId = $(this).val();
            if(clientId =='') {
                return;
            }
            $.ajax({
                type: "POST",
                url: BASEURL+"admin/clients/getInfoByClient",
                dataType: 'json',
                data: {clientId:clientId},
                beforeSend: function() {
                    // setting a timeout
                    $('.loader-wrapper').show()
                },
                success: function (response) {

                    if(response != 0) {
                        var clientInfo = response.clientinfo;
                        $("#address1").val(clientInfo.address1);
                        $("#address2").val(clientInfo.address2);
                        $("#country").val(clientInfo.country);
                        if(clientInfo.country == 101) {
                            $(".client-extra-details").show();
                            $("#state").val(clientInfo.state);
                            $("#city").val(clientInfo.city);
                            $("#zip_code").val(clientInfo.zip_code);
                            $("#gst_no").val(clientInfo.gst_no);
                            $("#place_of_supply").val(clientInfo.place_of_supply);
                        } else {
                            $(".client-extra-details").hide();
                        }
                        //$("label.error").hide();
                        $validator.resetForm();
                        populateSalesPersons(response);
                        populateAccountPersons(response);
                        populateAgreements(response);
                    }
                },
                error: function (error) {
                    alert("error1");
                },
                complete: function() {
                    $('.loader-wrapper').hide();
                },
            });

        });

        /*Delete single account person OR Salesperson*/
        $(document).on('click', '.delete_sales_person, .delete_account_person, .delete_agreement', function() {
            $deleteBox = $(this).parent().parent().parent();
            $deleteBox.remove();
            /*$('#confirm').modal({
             backdrop: 'static',
             keyboard: false
             })
             .one('click', '#delete', function(e) {
             $deleteBox.remove();
             });*/


        });

        /*
         * Client Side Validations.
         * @purpose - Client Side Validations for edit client.
         * @Date - 18/01/2018
         * @author - NJ
         */
     $validator = $("#client_edit").validate({
            /*submitHandler: function(form) {
                //return false;
                $(form).submit();
            },*/

            //ignore: [],
            rules: {
                category_id: {required: true},
                client: {required: true},
                address1:{required: true},
                country:{required: true},
                state: {required: true},
                city: {required: true},
                zip_code:{required: true,minlength:6,number: true},
                gst_no:{required: true,minlength:15,maxlength:15},
                place_of_supply:{required: true},
                "add_sales_person_name[]": {required: true},
                "add_sales_contact_no[]": {required: true},
                "add_sales_person_email[]": {required: true},
                "sales_person_email[]": {required: true},
                //'account_person_email[]': {isValidEmail: true},
               // 'add_account_person_email[]': {isValidEmail: true},

                "agreement_no[]": {agreementGroupRequired: true},
                "agreement_date[]": {agreementGroupRequired: true},
                "file-upload-input[]": {agreementGroupRequired: true,extension:"gif|jpg|png|jpeg|pdf|zip|docx|doc|xls|xlsx|eml|msg"},
                "add_agreement_no[]": {agreementGroupRequired1: true},
                "add_agreement_date[]": {agreementGroupRequired1: true},
                "add_file-upload-input[]": {agreementGroupRequired1: true,extension:"gif|jpg|png|jpeg|pdf|zip|docx|doc|xls|xlsx|eml|msg"},
                state: {required: true},
                country:{required: true},
                zip_code:{required: true,minlength:6,number: true},
               // "file-upload-input[]": {extension:"gif|jpg|png|jpeg|pdf|zip|docx|doc|xls|xlsx|eml"}
            },
            messages: {
                category_id: {required: "This field is required" },
                client: {required: "This field is required"},
                address1:{required: "This field is required"},
                state: {required: "This field is required"},
                city: {required: "This field is required"},
                country: {required: "This field is required"},
                zip_code: { required: "This field is required", number:"Please enter a valid Zip Code"},
                gst_no:{required: "This field is required", minlength:"Invalid GSTIN No.", maxlength:"Invalid GSTIN No."},
                place_of_supply:{required: "This field is required"},
                "add_sales_person_name[]": {required: "This field is required"},
                "add_sales_contact_no[]": {required: "This field is required", number:"Please enter a valid Mobile Number",minlength:"Please enter 10 digit Mobile Number"},
                "add_sales_person_email[]": { required: "This field is required ", isValidEmail:"Please enter a valid Email Address"},
                "sales_person_email[]": { required: "This field is required ", isValidEmail:"Please enter a valid Email Address"},

               // "edit_account_contact_no[]": {required: "This field is required", number:"Please enter a valid Mobile Number",minlength:"Please enter 10 digit Mobile Number"},
               // "edit_account_person_name[]": {required: "This field is required"},
                "account_person_email[]": {isValidEmail: "Please enter a valid Email Address"},

                'add_account_person_email[]': {isValidEmail:"Please enter a valid Email Address"},
                "agreement_no[]": "This field is required",
                "agreement_date[]": {agreementGroupRequired: "This field is required"},
                "file-upload-input[]": {agreementGroupRequired: "This field is required",extension:"Invalid file format"},
                "add_agreement_no[]": {agreementGroupRequired1: "This field is required"},
                "add_agreement_date[]": {agreementGroupRequired1: "This field is required"},
                "add_file-upload-input[]": {agreementGroupRequired1: "This field is required",extension:"Invalid file format"}
            }
     });

        /*File Handling*/
        $(document).on('click', '.file-upload-button', function(){
            $(this).parent().find("input[type='file']").click();
        });

        $(document).on('change', '.custom-file-upload-hidden', function(){
            var fileID = $(this).attr('id');
            var filename = $("#"+fileID).val().split('\\').pop();
            //console.log($("#"+fileID).val());
            $("#"+fileID).parent().find(".file-upload-input").val(filename);
            $("#"+fileID).parent().find(".file-upload-input").blur();
        });

        $(".delete_record").hide();

    });

    /*
     * populateSalesPersons.
     * @purpose - Populate SalesPersons.
     * @Date - 18/01/2018
     * @author - NJ
     */
     function populateSalesPersons(response) {
        //First Clean existing one
        $(".sales_person_row").remove();

        //Populate sales persons
        var salesPersons = response.salespersons;
        if(salesPersons.length == 1)
        {
            if($("#sales_person_row_1").length == 1){
                $("#sales_contact_no_1").val(salesPersons[0].sales_contact_no);
                $("#sales_person_name_1").val(salesPersons[0].sales_person_name);
                $("#sales_person_email_1").val(salesPersons[0].sales_person_email);
            } else {
                var nextIndex = 1;
                var salesPersonDetail = salesPersons[0];
                $salesCloneObje.attr('id','sales_person_row_'+nextIndex);
                $salesCloneObje.each(function () {
                    $(this).find("input[name^='sales_person_name[']").attr({name:'sales_person_name['+salesPersonDetail.salesperson_id+']'}).attr({id:'sales_person_name_'+nextIndex, value:salesPersonDetail.sales_person_name});
                    $(this).find("input[name^='sales_contact_no[']").attr({name:'sales_contact_no['+salesPersonDetail.salesperson_id+']'}).attr({id:'sales_contact_no_'+nextIndex, value:salesPersonDetail.sales_contact_no});
                    $(this).find("input[name^='sales_person_email[']").attr({name:'sales_person_email['+salesPersonDetail.salesperson_id+']'}).attr({id:'sales_person_email_'+nextIndex, value:salesPersonDetail.sales_person_email});
                });
                $cloneHtml = $salesCloneObje.wrap('<div>').parent().html();
                $(".sales_person_box").append($cloneHtml);
            }

        } else if(salesPersons.length > 1) {
            if($("#sales_person_row_1").length == 1){
                $("#sales_contact_no_1").val(salesPersons[0].sales_contact_no);
                $("#sales_person_name_1").val(salesPersons[0].sales_person_name);
                $("#sales_person_email_1").val(salesPersons[0].sales_person_email);
            } else {
                var nextIndex = 1;
                var salesPersonDetail = salesPersons[0];
                $salesCloneObje.attr('id','sales_person_row_'+nextIndex);
                $salesCloneObje.each(function () {
                    $(this).find("input[name^='sales_person_name[']").attr({name:'sales_person_name['+salesPersonDetail.salesperson_id+']'}).attr({id:'sales_person_name_'+nextIndex, value:salesPersonDetail.sales_person_name});
                    $(this).find("input[name^='sales_contact_no[']").attr({name:'sales_contact_no['+salesPersonDetail.salesperson_id+']'}).attr({id:'sales_contact_no_'+nextIndex, value:salesPersonDetail.sales_contact_no});
                    $(this).find("input[name^='sales_person_email[']").attr({name:'sales_person_email['+salesPersonDetail.salesperson_id+']'}).attr({id:'sales_person_email_'+nextIndex, value:salesPersonDetail.sales_person_email});

                });
                $cloneHtml = $salesCloneObje.wrap('<div>').parent().html();
                $(".sales_person_box").append($cloneHtml);
            }

            for(i= 1; i <= salesPersons.length-1;i++)
            {
                var nextIndex = i + 1;
                var salesPersonDetail = salesPersons[i];
                $salesCloneObje.attr('id','sales_person_row_'+nextIndex);
                $salesCloneObje.each(function () {
                    $(this).find("input[name^='sales_person_name[']").attr({name:'sales_person_name['+salesPersonDetail.salesperson_id+']',id:'sales_person_name_'+nextIndex,value:salesPersonDetail.sales_person_name});
                    $(this).find("input[name^='sales_contact_no[']").attr({name:'sales_contact_no['+salesPersonDetail.salesperson_id+']',id:'sales_contact_no_'+nextIndex, value:salesPersonDetail.sales_contact_no});
                    $(this).find("input[name^='sales_person_email[']").attr({name:'sales_person_email['+salesPersonDetail.salesperson_id+']',id:'sales_person_email_'+nextIndex, value:salesPersonDetail.sales_person_email});
                });
                $cloneHtml = $salesCloneObje.wrap('<div>').parent().html();
                $(".sales_person_box").append($cloneHtml);
            }
        } /*END SALES PERSON*/
         $(".delete_record").hide();
    }

    /*
     * populateAccountPersons.
     * @purpose - Populate AccountPersons.
     * @Date - 18/01/2018
     * @author - NJ
     */

    function populateAccountPersons(response) {
        $(".account_person_row").remove();
        /*Populate Account person*/
        var accountPersons = response.accountpersons;
        if(accountPersons.length==1)
        {
            if($("#account_contact_no_1").length == 1) {
                $("#account_contact_no_1").val(accountPersons[0].account_contact_no);
                $("#account_person_name_1").val(accountPersons[0].account_person_name);
                $("#account_person_email_1").val(accountPersons[0].account_person_email);
            } else {
                var nextIndex = 1;
                var accountPersonDetail = accountPersons[0];
                $accountCloneObje.attr('id','account_person_row_'+nextIndex);
                $accountCloneObje.each(function () {
                    $(this).find("input[name^='account_person_name[']").attr({name:'account_person_name['+accountPersonDetail.account_id+']'}).attr({id:'account_person_name_'+nextIndex, value:accountPersonDetail.account_person_name});
                    $(this).find("input[name^='account_contact_no[']").attr({name:'account_contact_no['+accountPersonDetail.account_id+']'}).attr({id:'account_contact_no_'+nextIndex, value:accountPersonDetail.account_contact_no});
                    $(this).find("input[name^='account_person_email[']").attr({name:'account_person_email['+accountPersonDetail.account_id+']'}).attr({id:'account_person_email_'+nextIndex, value:accountPersonDetail.account_person_email});
                });
                $cloneHtml = $accountCloneObje.wrap('<div>').parent().html();
                $(".account_person_box").append($cloneHtml);
            }

        }else if(accountPersons.length > 1) {

            if($("#account_contact_no_1").length == 1) {
                $("#account_contact_no_1").val(accountPersons[0].account_contact_no);
                $("#account_person_name_1").val(accountPersons[0].account_person_name);
                $("#account_person_email_1").val(accountPersons[0].account_person_email);
            } else {
                var nextIndex = 1;
                var accountPersonDetail = accountPersons[0];

                $accountCloneObje.attr('id','account_person_row_'+nextIndex);
                $accountCloneObje.each(function () {
                    $(this).find("input[name^='account_person_name[']").attr({name:'account_person_name['+accountPersonDetail.account_id+']'}).attr({id:'account_person_name_'+nextIndex, value:accountPersonDetail.account_person_name});
                    $(this).find("input[name^='account_contact_no[']").attr({name:'account_contact_no['+accountPersonDetail.account_id+']'}).attr({id:'account_contact_no_'+nextIndex, value:accountPersonDetail.account_contact_no});
                    $(this).find("input[name^='account_person_email[']").attr({name:'account_person_email['+accountPersonDetail.account_id+']'}).attr({id:'account_person_email_'+nextIndex, value:accountPersonDetail.account_person_email});
                });
                $cloneHtml = $accountCloneObje.wrap('<div>').parent().html();
                $(".account_person_box").append($cloneHtml);
            }
            for(i= 1; i <= accountPersons.length-1;i++)
            {
                var nextIndex = i + 1;
                var accountPersonDetail = accountPersons[i];
                $accountCloneObje.each(function () {
                    $(this).find("input[name^='account_person_name[']").attr({name:'account_person_name['+accountPersonDetail.account_id+']',id:'account_person_name_'+nextIndex,value:accountPersonDetail.account_person_name});
                    $(this).find("input[name^='account_contact_no[']").attr({name:'account_contact_no['+accountPersonDetail.account_id+']',id:'account_contact_no_'+nextIndex, value:accountPersonDetail.account_contact_no});
                    $(this).find("input[name^='account_person_email[']").attr({name:'account_person_email['+accountPersonDetail.account_id+']',id:'account_person_email_'+nextIndex,value:accountPersonDetail.account_person_email});
                });
                $cloneHtml = $accountCloneObje.wrap('<div>').parent().html();
                $(".account_person_box").append($cloneHtml);
            }
        } /*END ACCOUNT PERSON*/
        $(".delete_record").hide();
    }

    /*
     * populateAgreements.
     * @purpose - To populate Agreements.
     * @Date - 18/01/2018
     * @author - NJ
     */
    function populateAgreements(response) {
        $(".agreement_row").remove();
        /*Populate Agreements*/
        var agreements = response.agreements;
        if(agreements.length==1)
        {
            if($("#agreement_no_1").length == 1) {

                $("#agreement_no_1").val(agreements[0].agreement_no);
                $("#agreement_date_1").val(agreements[0].agreement_date);
                var original_name ='';
                if(agreements[0].agreement_name !='') {
                    original_name = agreements[0].agreement_name.split(/_(.+)/)[1];
                }
                $("#agreement_file_1").val(original_name);
                $(".file-upload-input").attr({value:original_name});
            } else {
                var nextIndex = 1;
                var agreementDetail = agreements[0];
                var original_name ='';
                if(agreementDetail.agreement_name !== null) {
                    original_name = agreementDetail.agreement_name.split(/_(.+)/)[1];
                }
                //var original_name = agreementDetail.agreement_name.split(/_(.+)/)[1];
                $agreementCloneObjeNew = $agreementCloneObje;
                $agreementCloneObjeNew.attr('id','agreement_row_'+nextIndex);
                $agreementCloneObjeNew.each(function () {

                    $(this).find("input[name^='agreement_no[']").attr({name:'agreement_no['+agreementDetail.agreement_id+']'}).attr({id:'agreement_no_'+nextIndex, value:agreementDetail.agreement_no});
                    $(this).find("input[name^='agreement_date[']").attr({name:'agreement_date['+agreementDetail.agreement_id+']'}).attr({id:'agreement_date_'+nextIndex, value:agreementDetail.agreement_date});
                    $(this).find("input[name^='agreement_file[']").attr({name:'agreement_file['+agreementDetail.agreement_id+']'}).attr({id:'agreement_file_'+nextIndex, value:original_name});
                    $(this).find("input[name^='agreement_name[']").attr({name:'agreement_name['+agreementDetail.agreement_id+']'}).attr({id:'agreement_name_'+nextIndex});
                    $(this).find(".file-upload-input").attr({value:original_name});
                });
                $cloneHtml = $agreementCloneObjeNew.wrap('<div>').parent().html();
                $(".agreement_box").append($cloneHtml);
            }

        }else if(agreements.length > 1) {

            if($("#agreement_no_1").length == 1) {
                $("#agreement_no_1").val(agreements[0].agreement_no);
                $("#agreement_date_1").val(agreements[0].agreement_date);
                var original_name = agreements[0].agreement_name.split(/_(.+)/)[1];
                $("#agreement_file_1").val(original_name);
                $(".file-upload-input").attr({value:original_name});
            } else {
                var nextIndex = 1;
                var agreementDetail = agreements[0];
                var original_name = agreementDetail.agreement_name.split(/_(.+)/)[1];
                $agreementCloneObjeNew = $agreementCloneObje;
                $agreementCloneObjeNew.attr('id','agreement_row_'+nextIndex);
                $agreementCloneObjeNew.each(function () {
                    $(this).find("input[name^='agreement_no[']").attr({name:'agreement_no['+agreementDetail.agreement_id+']'}).attr({id:'agreement_no_'+nextIndex, value:agreementDetail.agreement_no});
                    $(this).find("input[name^='agreement_date[']").attr({name:'agreement_date['+agreementDetail.agreement_id+']'}).attr({id:'agreement_date_'+nextIndex, value:agreementDetail.agreement_date});
                    $(this).find("input[name^='agreement_file[']").attr({name:'agreement_file['+agreementDetail.agreement_id+']'}).attr({id:'agreement_file_'+nextIndex, value:original_name});
                    $(this).find("input[name6='agreement_name[']").attr({name:'agreement_name['+agreementDetail.agreement_id+']'}).attr({id:'agreement_name_'+nextIndex});
                    $(this).find(".file-upload-input").attr({value:original_name});
                });
                $cloneHtml = $agreementCloneObjeNew.wrap('<div>').parent().html();
                $(".agreement_box").append($cloneHtml);
            }
            for(i= 1; i <= agreements.length-1;i++)
            {
                var nextIndex = i + 1;
                var agreementDetail = agreements[i];
                var original_name = agreementDetail.agreement_name.split(/_(.+)/)[1];
                $agreementCloneObjeNew = $agreementCloneObje;
                $agreementCloneObjeNew.attr('id','agreement_row_'+nextIndex);
                $agreementCloneObjeNew.each(function () {
                    $(this).find("input[name^='agreement_no[']").attr({name:'agreement_no['+agreementDetail.agreement_id+']',id:'agreement_no_'+nextIndex,value:agreementDetail.agreement_no});
                    $(this).find("input[name^='agreement_date[']").attr({name:'agreement_date['+agreementDetail.agreement_id+']',id:'agreement_date_'+nextIndex,value:agreementDetail.agreement_date});
                    $(this).find("input[name^='agreement_file[']").attr({name:'agreement_file['+agreementDetail.agreement_id+']',id:'agreement_file_'+nextIndex});
                    $(this).find("input[name^='agreement_name[']").attr({name:'agreement_name['+agreementDetail.agreement_id+']',id:'agreement_name_'+nextIndex,value:original_name});
                    $(this).find(".file-upload-input").attr({value:original_name});
                });
                $cloneHtml = $agreementCloneObjeNew.wrap('<div>').parent().html();
                $(".agreement_box").append($cloneHtml);
            }
        } /*END AGREEMENT*/
        $(".agreement_date").datepicker({format: "d-M-yyyy",autoclose: true,startDate: '-1y',endDate: FromEndDate});
        $(".delete_record").hide();
    }

    /*
     * addMoreSalesPerson.
     * @purpose - Clone SalesPerson.
     * @Date - 18/01/2018
     * @author - NJ
     */
    function addMoreSalesPerson() {
        var nextIndex = parseInt($(".sales_person_row").length) + 1;
        $salesCloneObje.attr('id','sales_person_row_'+nextIndex);
        $salesCloneObje.each(function () {
            if($(this).find("input[name^='sales_person_name[']").length > 0) {
                $(this).find("input[name^='sales_person_name[']").attr("name","add_sales_person_name[]").attr({id:'sales_person_name_'+nextIndex,value:''});
            } else {
                $(this).find("input[name^='add_sales_person_name[']").attr("name","add_sales_person_name[]").attr({id:'sales_person_name_'+nextIndex,value:''});
            }

            if($(this).find("input[name^='sales_contact_no[']").length > 0) {
                $(this).find("input[name^='sales_contact_no[']").attr("name","add_sales_contact_no[]").attr({id:'sales_contact_no_'+nextIndex,value:''});
            } else {
                $(this).find("input[name^='add_sales_contact_no[']").attr("name","add_sales_contact_no[]").attr({id:'sales_contact_no_'+nextIndex,value:''});
            }
            if($(this).find("input[name^='sales_person_email[']").length > 0) {
                $(this).find("input[name^='sales_person_email[']").attr("name","add_sales_person_email[]").attr({id:'sales_person_email_'+nextIndex,value:''});
            } else {
                $(this).find("input[name^='add_sales_person_email[']").attr("name","add_sales_person_email[]").attr({id:'sales_person_email_'+nextIndex,value:''});
            }
        });
        $cloneHtml = $salesCloneObje.wrap('<div>').parent().html();
        $(".sales_person_box").append($cloneHtml);

    }
    /*
     * addMoreAccountPerson.
     * @purpose - Clone AccountPerson.
     * @Date - 18/01/2018
     * @author - NJ
     */
    function addMoreAccountPerson() {
        var nextIndex = parseInt($(".account_person_row").length) + 1;
        $accountCloneObje.attr('id','account_person_row_'+nextIndex);
        $accountCloneObje.each(function () {
            if($(this).find("input[name^='account_person_name[']").length > 0) {
                $(this).find("input[name^='account_person_name[']").attr("name","add_account_person_name[]").attr({id:'account_person_name_'+nextIndex,value:''});
            } else {
                $(this).find("input[name^='add_account_person_name[']").attr("name","add_account_person_name[]").attr({id:'account_person_name_'+nextIndex,value:''});
            }

            if($(this).find("input[name^='account_contact_no[']").length > 0) {
                $(this).find("input[name^='account_contact_no[']").attr("name","add_account_contact_no[]").attr({id:'account_contact_no_'+nextIndex,value:''});
            } else {
                $(this).find("input[name^='add_account_contact_no[']").attr("name","add_account_contact_no[]").attr({id:'account_contact_no_'+nextIndex,value:''});
            }

            if($(this).find("input[name^='account_person_email[']").length > 0) {
                $(this).find("input[name^='account_person_email[']").attr("name","add_account_person_email[]").attr({id:'account_person_email_'+nextIndex,value:''});
            } else {
                $(this).find("input[name^='add_account_person_email[']").attr("name","add_account_person_email[]").attr({id:'account_person_email_'+nextIndex,value:''});
            }
        });
        $cloneHtml = $accountCloneObje.wrap('<div>').parent().html();
        $(".account_person_box").append($cloneHtml);

    }
    /*
     * addMoreAgreement.
     * @purpose - Clone Agreement.
     * @Date - 18/01/2018
     * @author - NJ
     */
    function addMoreAgreement() {
        var LastEl = $(".agreement_row").last();
        var lastid = LastEl.attr('id');
        if(lastid == undefined) {
            var nextIndex = 1;
        } else {
            var LastIdParts = lastid.split("agreement_row_");
            var lenth = LastIdParts[1];
            var nextIndex = parseInt(lenth) + 1;
        }

        //var nextIndex = parseInt($(".agreement_row").length) + 1;
        //$agreementCloneObjeCOPY = $agreementCloneObje;
        var $agreementCloneObjeCOPY = jQuery.extend(true, {}, $agreementCloneObje);

        $agreementCloneObjeCOPY.attr('id','agreement_row_'+nextIndex);
        $cloneHtml = $agreementCloneObjeCOPY.wrap('<div>').parent().html();
        console.log(nextIndex);

        $agreementCloneObjeCOPY.each(function () {
            if($(this).find("input[name^='agreement_no[']").length > 0){
                $(this).find("input[name^='agreement_no[']").attr("name","add_agreement_no[]").attr({id:'agreement_no_'+nextIndex,value:''});
            } else {
                $(this).find("input[name^='add_agreement_no[']").attr("name","add_agreement_no[]").attr({id:'agreement_no_'+nextIndex,value:''});
            }
            if($(this).find("input[name^='agreement_date[']").length > 0){
                $(this).find("input[name^='agreement_date[']").attr("name","add_agreement_date[]").attr({id:'agreement_date_'+nextIndex, value:''});
            } else {
                $(this).find("input[name^='add_agreement_date[']").attr({id:'agreement_date_'+nextIndex, value:''});
            }
            if($(this).find("input[name^='agreement_file[']").length > 0) {
                $(this).find("input[name^='agreement_file[']").attr("name","add_agreement_file[]").attr({id:'agreement_file_'+nextIndex, value:''});
            } else {
                $(this).find("input[name^='add_agreement_file[']").attr("name","add_agreement_file[]").attr({id:'agreement_file_'+nextIndex, value:''});
            }

            if($(this).find("input[name^='agreement_name[']").length > 0) {
                $(this).find("input[name^='agreement_name[']").attr("name","add_agreement_name[]").attr({id:'agreement_name_'+nextIndex});
            } else {
                $(this).find("input[name^='add_agreement_name[']").attr("name","add_agreement_name[]").attr({id:'add_agreement_name_'+nextIndex, value:''});
            }

            if($(this).find("input[name^='file-upload-input[']").length > 0) {
                $(this).find(".file-upload-input").attr({"name":"add_file-upload-input[]", id:'file-upload-input_'+nextIndex, value:''});
            } else {
                $(this).find(".file-upload-input").attr({"name":"add_file-upload-input[]",id:'file-upload-input_'+nextIndex, value:''});
            }
            //$(this).find("input[name^='agreement_name[']").attr("name","add_agreement_name[]").attr({id:'agreement_name_'+nextIndex});
            $(this).find("label[for^=file-upload-input]").attr({id:'file-upload-input_'+nextIndex+'-error', for:'file-upload-input_'+nextIndex});
        });

        $cloneHtml = $agreementCloneObjeCOPY.wrap('<div>').parent().html();
        $(".agreement_box").append($cloneHtml);
        $(".agreement_date").datepicker({format: "d-M-yyyy",autoclose: true,startDate: '-1y',endDate: FromEndDate});
    }

    function getClientDetails(clientId) {
        $.ajax({
            type: "POST",
            url: BASEURL+"admin/clients/getInfoByClient",
            dataType: 'json',
            data: {clientId:clientId},
            beforeSend: function() {
                // setting a timeout
                $('.loader-wrapper').show()
            },
            success: function (response) {

                if(response != 0) {
                    var clientInfo = response.clientinfo;
                    $("#address1").val(clientInfo.address1);
                    $("#address2").val(clientInfo.address2);
                    $("#country").val(clientInfo.country);
                    if(clientInfo.country == 101) {
                        $(".client-extra-details").show();
                        $("#state").val(clientInfo.state);
                        $("#city").val(clientInfo.city);
                        $("#zip_code").val(clientInfo.zip_code);
                        $("#gst_no").val(clientInfo.gst_no);
                        $("#place_of_supply").val(clientInfo.place_of_supply);
                    } else {
                        $(".client-extra-details").hide();
                    }
                    //$("label.error").hide();
                    $validator.resetForm();
                    populateSalesPersons(response);
                    populateAccountPersons(response);
                    populateAgreements(response);
                }
            },
            error: function (error) {
                alert("error");
            },
            complete: function() {
                $('.loader-wrapper').hide();
            },
        });
    }
