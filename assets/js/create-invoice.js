    /**
     * Created by nishi.jain on 09-Jan-18.
     */
    /**
     * Created by nishi.jain on 09-Jan-18.
     */
    $validator = null;
    var FromEndDate = new Date();
    $(document).ready(function () {
        $("#noAttachment").hide();
        /*datepicker*/
        $("#po_ro_date").datepicker({format: "d-M-yyyy",autoclose: true, startDate: '-1y',endDate: FromEndDate});

        /*Clone fields*/
        $invoiceCloneObje = $("#invoice_schedule_row_1").clone();
        $attachmentCloneObje = $("#order_attachment_box_1").clone();

        /*
         * Client Side Validations.
         * @purpose - Client Side validations for create invoice.
         * @Date - 18/01/2018
         * @author - NJ
         */
        $validator = $("#create-invoice").validate({
            ignore: ":hidden:not(.file-upload-input)",
            rules: {
                category_id: {required: true},
                subcategory_id: {required: true},
                comp_name : {required: true},
                sales_person: {required: true},
                manager_person: {required: true},
                client_name: {required: true},
                postal_address: {required: true},
                manager_name: {required: true},
                contact_number: {required: true},
                email_id: {required: true},
               /* acc_person: {required: true},
                contact_number1: {required: true},
                email_id1: {required: true},*/
                inv_amount: {required: true,number:true},
                currency: {required: true},
              /* 'client_agreement[]': {required: true},*/
                //po_ro_date: {required: true},
                po_detail: {required: true},
                //po_ro_number: {required: true},
                pay_term: {required: true},
                attach_type: {required: true},
                attachment: {required: true},
                //delivery_required: {required: true},
                //actual_delivered: {required: true},
                //units: {required: true},
               // 'invoice_doc[]': {required: true},
                'file-upload-input[]': {extension:"gif|jpg|png|jpeg|pdf|zip|docx|doc|xls|xlsx|eml|msg"},
                //remarks: {required: true},
                po_ro_number:{
                    required:{
                        depends: function(element){
                            var status = true;
                            if( $("#no_po:checked").val() !== undefined){
                                var status = false;
                            }
                            return status;
                        }
                    }
                },
                po_ro_date:{
                    required:{
                        depends: function(element){
                            var status = true;
                            if( $("#no_po:checked").val() !== undefined){
                                var status = false;
                            }
                            return status;
                        }
                    }
                }
            },
            messages: {
                category_id: {required: "This field is required"},
                subcategory_id: {required: "This field is required"},
                comp_name : {required: "This field is required"},
                sales_person: {required: "This field is required"},
                manager_person: "This field is required",
                client_name: {required: "This field is required"},
                postal_address: "This field is required",
                manager_name: {required: "This field is required"},
                contact_number: {required: "This field is required"},
                email_id: {required: "This field is required"},
                acc_person: {required: "This field is required"},
                contact_number1: {required: "This field is required"},
                email_id1: {required: "This field is required"},
                inv_amount: {required: "This field is required", number:"The field should contain a numeric value"},
                currency: {required:"This field is required"},
                /*'client_agreement[]': {required: "This field is required"},*/
                po_ro_date: {required: "This field is required"},
                po_detail: {required: "This field is required"},
                po_ro_number: {required: "This field is required"},
                pay_term: {required: "This field is required"},
                //delivery_required: {required: "This field is required"},
                //actual_delivered: {required: "This field is required"},
                //units: {required: "This field is required"},
                attach_type: {required: "This field is required"},
                attachment: {required: "This field is required"},
                //'invoice_doc[]': {required: "Please select attachment type"},
                'file-upload-input[]': {extension:"Invalid file format"},
                //remarks: {required: "This field is required"}
            }
        });

        function resetForm($form) {
            $form.find('input:text, input:password, input:file, select, textarea').val('');
            $form.find('input:radio, input:checkbox')
                .removeAttr('checked').removeAttr('selected');
        }
        $("#resetInvoice").click(function () {
            resetForm($('#create-invoice'));
            $("input[name^='invoice_amount[']").attr("value", "");
            $("input[name^='invoice_comment[']").attr("value", "");
            $("input[name^='invoice_startdate[']").attr("value", "");
            $("label[for^='invoice_status_c_']").attr("value", "");
            $("label[for^='invoice_status_t_']").attr("value", "");

            $("#totalInvoiceAmount").html('');

            //DHARMENDRA
            $(".selectpicker").html('');
            $(".selectpicker").selectpicker('refresh');
            $('#invoicebox').hide();
            $('.suborder').hide();
            $('.status').hide();
            $("#comp_name").attr("placeholder", "Campaign Name");
            $("#po_ro_number").attr("placeholder", "PO Number");
            $("#po_detail").attr("placeholder", "PO Details");
            $(".po_heading").text("PO Details");

            $("#client_name option").not(':eq(0), :selected').remove();
            $("#manager_name option").not(':eq(0), :selected').remove();
            $("#acc_person option").not(':eq(0), :selected').remove();
            $( "#manager_name" ).prop( "disabled", false );
            $( "#contact_number" ).prop( "disabled", false );
            $( "#email_id" ).prop( "disabled", false );
            $( "#acc_person" ).prop( "disabled", false );
            $( "#contact_number1" ).prop( "disabled", false );
            $( "#email_id1" ).prop( "disabled", false );
            $( "#client_name" ).prop( "disabled", false );
            $( "#postal_address" ).prop( "disabled", false );
            $('.invoiceGenerated').hide();
            $('#invoicebox').hide()
            $('#comp_name').show();
            $("#order_id").hide();
            $(".subcategory").hide();
            $('.suborder').hide();
            $("#suborder_id").html('');

            $('.deliveryRequired').hide();
            $('.actualDelivered').hide();
            $('.units').hide();
            $('.nopo').hide();
   });

        /*File handling*/
        $(document).on('click', '.file-upload-button', function(){
            $(this).parent().find("input[type='file']").click();
        });

        $(document).on('change', '.custom-file-upload-hidden', function(){
            var fileID = $(this).attr('id');
            var filename = $("#"+fileID).val().split('\\').pop();
            $("#"+fileID).parent().find(".file-upload-span").text(filename);
            $("#"+fileID).parent().find(".file-upload-input").val(filename);
            $("#"+fileID).parent().find(".file-upload-input").blur();
        });


        /*Delete single invoice attachment record*/
        $(document).on('click', '.delete_attachment', function() {
            $deleteBox = $(this).parent().parent().parent();
            $deleteBox.remove();
        });

        /*
         * getInfoByClientID.
         * @purpose -Populate Details on onchange of clientId.
         * @Date - 18/01/2018
         * @author - NJ
         */
        $("#client_name").on('change', function () {
            var clientID = $(this).val();
            $.ajax({
                type: "POST",
                url: BASEURL + "invoice/getInfoByClient",
                dataType: 'json',
                data: {client: clientID},
                beforeSend: function () {
                    // setting a timeout
                    $('.loader-wrapper').show()
                },
                success: function (response) {
                    if (response != 0) {
                        $validator.resetForm();
                        populateAgreementName(response);
                        populateManagerDetails(response);
                        populateAccountDetails(response);
                        populateClientAddress(response);
                    }
                },
                error: function (error) {
                    $('.loader').hide();
                    alert("There is an error while getting details. Please try again.");
                },
                complete: function () {
                    $('.loader-wrapper').hide();
                },
            });
        });
        /*
         * getManagerInfoByManagerId.
         * @purpose -Populate SalespersonDetails on onchange of SalespersonId.
         * @Date - 18/01/2018
         * @author - NJ
         */
        $("#manager_name").on('change',function(){
            var salesId = $(this).val();
            if(salesId =='') {
                return;
            }
            $.ajax({
                type: "POST",
                url: BASEURL+"invoice/getManagerInfoByManagerName",
                dataType: 'json',
                data: {salesId:salesId},
                beforeSend: function() {
                    // setting a timeout
                    //$('.loader-wrapper').show()
                },
                success: function (response) {
                    if(response != 0) {
                        $validator.resetForm();
                        populateSalesPersons(response)
                    }
                },
                error: function (error) {
                    alert("There is an error while getting record. Please try again");
                    return;
                },
                complete: function() {
                    //$('.loader-wrapper').hide();
                },
            });

        });
        /*
         * getAccountInfoByAccountId.
         * @purpose -Populate AccountpersonDetails on onchange of AccountpersonId.
         * @Date - 18/01/2018
         * @author - NJ
         */
        $("#acc_person").on('change',function(){
            var accountId = $(this).val();
            if(accountId =='') {
                return;
            }
            $.ajax({
                type: "POST",
                url: BASEURL+"invoice/getAccountInfoByAccountName",
                dataType: 'json',
                data: {accountId:accountId},
                beforeSend: function() {
                    // setting a timeout
                    //$('.loader-wrapper').show()
                },
                success: function (response) {
                    if(response != 0) {
                        $validator.resetForm();
                        populateAccountPersons(response);
                    }
                },
                error: function (error) {
                    alert("There is an error while getting record. Please try again");
                    return;
                },
                complete: function() {
                    $('.loader-wrapper').hide();
                },
            });

        });


        $("#client_name").on('change', function () {
            $('#contact_number').val('');
            $('#email_id').val('');
            $('#contact_number1').val('');
            $('#email_id1').val('');
            $('#manager_name').find("option:first").attr("selected", "selected");
            $('#acc_person').find("option:first").attr("selected", "selected");
            $("#client_agreement").html('');
            $("#client_agreement").selectpicker('refresh');

        });


        $("#category_id").on('change', function () {
            $('#contact_number').val('');
            $('#email_id').val('');
            $('#contact_number1').val('');
            $('#email_id1').val('');
            $('#manager_name').find("option:first").attr("selected", "selected");
            $('#acc_person').find("option:first").attr("selected", "selected");
            $("#client_agreement").html('');
            $("#client_agreement").selectpicker('refresh');

        });




        /*
         * getInfoByCategoryId.
         * @purpose -Populate Details on onchange of categoryId.
         * @Date - 18/01/2018
         * @author - NJ
         */
        $("#category_id").on('change', function () {
            var categoryId = $(this).val();
            if(categoryId =='') {
                return;
            }

            if(categoryId!=TECHNOLOGYCAT ||categoryId!=TECHNOLOGYINCCAT)
            {
               // var nextIndex = $(".file-upload-wrapper").length + 1;
                $("input[name='attachment[]']").attr({name:'add_agreement_name[]',value:''});

               // var nextIndex = $(".attachtype").length + 1;
                $("select[name='invoice_doc[]']").attr({name:'add_invoice_doc[]',value:''});
            }


            updateInvoicePageContent(categoryId);
            disableFieldsByCategory(categoryId);
            $.ajax({
                type: "POST",
                url: BASEURL + "invoice/getInfoByCategory",
                dataType: 'json',
                data: {categoryId: categoryId},
                beforeSend: function () {
                    // setting a timeout
                    $('.loader-wrapper').show()
                },
                success: function (response) {

                    if (response != 0) {
                        resetForm($('#create-invoice'));
                        $("#category_id").val(categoryId );
                        $("#totalInvoiceAmount").html('');
                        $(".selectpicker").html('');
                        $(".selectpicker").selectpicker('refresh');
                        $("#client_name option").not(':eq(0), :selected').remove();
                        $("#manager_name option").not(':eq(0), :selected').remove();
                        $("#acc_person option").not(':eq(0), :selected').remove();

                        $('input[type=checkbox]').prop('checked', false);

                        $validator.resetForm();
                        populateProjectName(response);
                        populateClientName(response);
                    }
                },
                error: function (error) {
                    $('.loader').hide();
                    alert("There is an error while getting details. Please try again.");
                },
                complete: function () {
                    $('.loader-wrapper').hide();
                },
            });
        });

        /*
         * getDetailsByProjectId.
         * @purpose -Populate Details on onchange of ProjectId.
         * @Date - 18/01/2018
         * @author - NJ
         */
        $("#order_id").on('change',function(){

            var projectdetails = $(this).val();
            if(projectdetails =='') {
                return;
            }
            $.ajax({
                type: "POST",
                url: BASEURL+"invoice/getDetailsByProjectName",
                dataType: 'json',
                data: {projectDetails:projectdetails},
                beforeSend: function() {
                    // setting a timeout
                    $('.loader-wrapper').show()
                },
                success: function (response) {
                    if(response != 0) {
                        $validator.resetForm();
                        populateDetailsByProjectName(response);
                        populateAttachment(response);
                        populateSuborder(response);
                        populateInvoiceSchedule(response);
                    }
                },
                error: function (error) {
                    alert("There is an error while getting record. Please try again");
                    return;
                },
                complete: function() {
                    $('.loader-wrapper').hide();
                },
            });

        });

        /*
         * getDetailsBySuborderID.
         * @purpose -Populate Details on onchange of SuborderId.
         * @Date - 18/01/2018
         * @author - NJ
         */
          $("#suborder_id").on('change',function(){
          var suborderdetails = $(this).val();
            if(suborderdetails =='') {
                return;
            }
            $.ajax({
                type: "POST",
                url: BASEURL+"invoice/getDetailsBySuborder",
                dataType: 'json',
                data: {suborderDetails:suborderdetails},
                beforeSend: function() {
                    // setting a timeout
                    $('.loader-wrapper').show()
                },
                success: function (response) {
                    if(response != 0) {
                        $(".order_attachment_box").not(':first').remove();
                        $("#invoicebox").not(':first').remove();
                        $validator.resetForm();
                        populateDetailsBySuborder(response);
                        populateAttachment(response);
                        populateInvoiceSchedule(response);
                    }
                },
                error: function (error) {
                    alert("There is an error while getting record. Please try again");
                    return;
                },
                complete: function() {
                    $('.loader-wrapper').hide();
                },
            });

        });

    });
       /*
       * updateInvoicePageContent.
       * @purpose -Update Details on onchange of CategoryId.
       * @Date - 18/01/2018
       * @author - NJ
       */
        function updateInvoicePageContent(category_id) {

        if(category_id== TECHNOLOGYCAT ||category_id== TECHNOLOGYINCCAT)
        {
            $("#add_more").hide();
            $('.multiple_nopo').hide();
            $('.status').hide();
            $('.subcategory').hide();
            $('.invoiceGenerated').show();
            $('#order_id').show();
            $('.nopo').show();
            $("#comp_name").hide();
            $('.deliveryRequired').hide();
            $('.actualDelivered').hide();
            $('.units').hide();
            $("#order_id").attr("placeholder", "Project Name");
            $(".po_heading").text("PO Details");
            if(category_id== TECHNOLOGYCAT ){
                $("#po_ro_number").attr("placeholder", "PO/RO Number");
                $("#po_detail").attr("placeholder", "Invoice Description");
            }
            if(category_id== TECHNOLOGYINCCAT ){
                $("#po_ro_number").attr("placeholder", "PO Number");
                $("#po_detail").attr("placeholder", "PO Details");
            }
        }
        else if(category_id==  WIRELESSCAT ||category_id== WIRELESSINCCAT)
        {
            $("#add_more").show();
            $('.multiple_nopo').hide();
            $('#invoicebox').hide();
            $('.suborder').hide();
            $('.status').show();
            $('.subcategory').show();
            $('.invoiceGenerated').hide();
            $('#comp_name').show();
            $("#order_id").hide();
            $('.deliveryRequired').hide();
            $('.actualDelivered').hide();
            $('.units').hide();
            $('.nopo').hide();
            $("#comp_name").attr("placeholder", "Invoice Name");
            if(category_id== WIRELESSCAT ||category_id== WIRELESSINCCAT)
            {
                $("#po_ro_number").attr("placeholder", "PO Number");
                $("#po_detail").attr("placeholder", "PO Details");
                $(".po_heading").text("PO Details");
            }
            if(category_id== WIRELESSCAT ||category_id== WIRELESSINCCAT )
            {

                $('.invoiceDescription').hide();

            }
        }
        else if(category_id== CONTENTCAT ||category_id== LOCALIZATIONCAT || category_id== LOCALIZATIONINCCAT)
        {
            $("#add_more").show();
            $('.multiple_nopo').hide();
            $('#invoicebox').hide();

            $('.suborder').hide();
            $('.subcategory').hide();
            $('.status').hide();
            $('#comp_name').show();
            $("#order_id").hide();
            $('.deliveryRequired').hide();
            $('.actualDelivered').hide();
            $('.units').hide();
            $('.nopo').hide();

            $("#comp_name").attr("placeholder", "Project Name");
            $("#po_ro_number").attr("placeholder", "PO Number");
            $("#po_detail").attr("placeholder", "PO Details");
            $(".po_heading").text("PO Details");
            if(category_id== CONTENTCAT)
            {
                $('.multiple_nopo').show();
                $('.invoiceGenerated').hide();
            }else if(category_id== LOCALIZATIONCAT ||category_id== LOCALIZATIONINCCAT)
            {
                $('.multiple_nopo').hide();
                $('.invoiceGenerated').show();

            }
        }
        else if(category_id== ADNETWORKSCAT || category_id== ADSALESCAT ||category_id== ADNETWORKSINCCAT)
        {

            $("#add_more").show();
            $('.multiple_nopo').hide();
            $('#invoicebox').hide();

            $('.suborder').hide();
            $('.status').hide();
            $('.subcategory').hide();
            $('.invoiceGenerated').hide();
            $('#comp_name').show();
            $("#order_id").hide();
            $('.deliveryRequired').hide();
            $('.actualDelivered').hide();
            $('.units').hide();
            $('.nopo').hide();
            $("#comp_name").attr("placeholder", "Campaign Name");

            if(category_id== ADSALESCAT)
            {
                $('.deliveryRequired').show();
                $('.actualDelivered').show();
                $('.units').show();
            }
            $("#po_ro_number").attr("placeholder", "RO Number");
            $("#po_detail").attr("placeholder", "RO Details");
            $(".po_heading").text("RO Details");
        }
        else if(category_id== ADSALESINCCAT)
        {
            $('.subcategory').hide();
            $('.status').hide();
            $('#comp_name').show();
            $("#order_id").hide();
            $('.invoiceGenerated').hide();
            $("#po_ro_number").attr("placeholder", "RO Number");
            $("#po_detail").attr("placeholder", "RO Details");
            $(".po_heading").text("RO Details");
            $('.deliveryRequired').show();
            $('.actualDelivered').show();
            $('.units').show();
            $('.nopo').hide();
        }
    }

    function disableFieldsByCategory(category_id)
    {
        if(category_id== TECHNOLOGYCAT ||category_id== TECHNOLOGYINCCAT)
        {
            //$( "#manager_name" ).prop( "disabled", true );
            $( "#contact_number" ).prop( "disabled", true );
            $( "#email_id" ).prop( "disabled", true );
            //$( "#acc_person" ).prop( "disabled", true );
            $( "#contact_number1" ).prop( "disabled", true );
            $( "#email_id1" ).prop( "disabled", true );
            $( "#client_name" ).prop( "disabled", true );
            $( "#postal_address" ).prop( "disabled", true );
            //$("#po_ro_number").prop( "disabled", true );
            $("#pay_term").prop( "disabled", true );
            //$("#no_po").prop( "disabled", true );
            //$("#po_ro_date").prop( "disabled", true );

  }
        else{
            $( "#manager_name" ).prop( "disabled", false );
            $( "#contact_number" ).prop( "disabled", false );
            $( "#email_id" ).prop( "disabled", false );
            $( "#acc_person" ).prop( "disabled", false );
            $( "#contact_number1" ).prop( "disabled", false );
            $( "#email_id1" ).prop( "disabled", false );
            $( "#client_name" ).prop( "disabled", false );
            $( "#postal_address" ).prop( "disabled", false );
            $( "#po_ro_number" ).prop( "disabled", false );
            $("#pay_term").prop( "disabled",false );

        }
    }

   /* function multiplePO(obj) {
        if (obj.checked) {
            // document.getElementById("notother").style.display="none";


            alert("In case of Multiple PO, You need to zip all the PO's in a single zip file and attach the zip file !!");
        } else {
            // document.getElementById("notother").style.display="block";
        }
    }*/
        /*
       * updateInvoicePageContent.
       * @purpose -Update Details on onchange of CategoryId.
       * @Date - 18/01/2018
       * @author - NJ
       */

        function populateDetailsByProjectName(response) {
        var projectInfo = response.projectinfo;
        if(projectInfo[0].project_type=="FB" || ((projectInfo[0].project_type=="TNM") && (projectInfo[0].efforts_unit=="M")))
        {
            $('#invoicebox').show();
            $('#tnmbox').hide();
        }
        if((projectInfo[0].project_type=="TNM")&&(projectInfo[0].efforts_unit!="M")){
            $('#tnmbox').show();
            $('#invoicebox').hide();
            $("#initial_hours").val(projectInfo[0].initial_hours);
            $("#effort_unit").val(projectInfo[0].efforts_unit);
            $("#effort_unit").prop("disabled", true);
            $("#rate").val(projectInfo[0].hourly_rate);
            $("#hourCurncy").val(projectInfo[0].hour_rate_currency);
            $("#hourCurncy").prop("disabled", true);
        }
        $("#invoice_description").val(projectInfo[0].project_description);
        $("#po_ro_number").val(projectInfo[0].po_no);

        //As per pankaj sir feedbacks
        $("#sales_person").val(projectInfo[0].wd_sales_person_id);
        $("#manager_person").val(projectInfo[0].wd_tech_head_id);
        $("#currency").val(projectInfo[0].order_currency);

        if(projectInfo[0].po_no=='None') {
            $("#no_po").prop("checked", true);
        }
        $("#po_ro_date").val(projectInfo[0].po_date);
        $("#po_detail").val(projectInfo[0].po_dtl);
        $("#pay_term").val(projectInfo[0].payment_term);
        $("#remarks").val(projectInfo[0].invoice_originator_remarks);

         var clientInfo = response.clientinfo;

            $("#client_name").val(clientInfo[0].client_id);
            var accountInfo = response.accountinfo;
            if(accountInfo.length == 0) {
                var accountId = "";
            } else
            {
                var accountId =  accountInfo[0].account_id;
                $("#contact_number1").val(accountInfo[0].account_contact_no);
                $("#email_id1").val(accountInfo[0].account_person_email);
            }
            var managerInfo = response.managerinfo;
            if(managerInfo.length == 0) {
                var salespersonId = "";
            } else
            {
                var salespersonId =  managerInfo[0].salesperson_id;
                $("#contact_number").val(managerInfo[0].sales_contact_no);
                $("#email_id").val(managerInfo[0].sales_person_email);
            }
            $("#postal_address").val(clientInfo[0].address);

            getClientInfo(clientInfo[0].client_id,accountId, salespersonId);

            var payment = projectInfo[0].payment_term;
            var paymentterm = $("<input>").attr("type", "hidden").attr("name", "payment").val(payment);
            $('#create-invoice').append(paymentterm);

            var po_no =projectInfo[0].po_no;
            var pono = $("<input>").attr("type", "hidden").attr("name", "po_number").val(po_no);
            $('#create-invoice').append(pono);

            var po_date =projectInfo[0].po_date;
            var podate = $("<input>").attr("type", "hidden").attr("name", "po_date").val(po_date);
            $('#create-invoice').append(podate);


    }

      /*
     * populateDetailsBySuborder.
     * @purpose -Update Details on onchange of SuborderId.
     * @Date - 18/01/2018
     * @author - NJ
     */
     function populateDetailsBySuborder(response){
         $("#invoice_description").val('');
         $("#po_ro_number").val('');
         $("#po_ro_date").val('');
         $("#po_detail").val('');
         $("#pay_term").val('');
         $("#remarks").val('');

         var suborderdetailedInfo = response.suborderdetailedinfo;
         $("#invoice_description").val(suborderdetailedInfo[0].project_description);
         $("#po_ro_number").val(suborderdetailedInfo[0].po_no);
         $("#po_ro_date").val(suborderdetailedInfo[0].po_date);
         $("#po_detail").val(suborderdetailedInfo[0].po_dtl);
         $("#pay_term").val(suborderdetailedInfo[0].payment_term);
         $("#remarks").val(suborderdetailedInfo[0].invoice_originator_remarks);

         //As per pankaj sir feedbacks
         $("#sales_person").val(suborderdetailedInfo[0].wd_sales_person_id);
         $("#manager_person").val(suborderdetailedInfo[0].wd_tech_head_id);
         $("#currency").val(suborderdetailedInfo[0].order_currency);

         if(suborderdetailedInfo[0].project_type=="FB" || ((suborderdetailedInfo[0].project_type=="TNM") && (suborderdetailedInfo[0].efforts_unit=="M")))
         {
             $('#invoicebox').show();
             $('#tnmbox').hide();

         }
         if((suborderdetailedInfo[0].project_type=="TNM")&&(suborderdetailedInfo[0].efforts_unit!="M")){
             $('#tnmbox').show();
             $('#invoicebox').hide();
             $("#initial_hours").val(suborderdetailedInfo[0].initial_hours);
             $("#effort_unit").val(suborderdetailedInfo[0].efforts_unit);
             $("#effort_unit").prop("disabled", true);
             $("#rate").val(suborderdetailedInfo[0].hourly_rate);
             $("#hourCurncy").val(suborderdetailedInfo[0].hour_rate_currency);
             $("#hourCurncy").prop("disabled", true);
         }
     }

       /*
       * populateSuborder.
       * @purpose -Show Suborder if exists,else Hide.
       * @Date - 18/01/2018
       * @author - NJ
       */

        function populateSuborder(response) {
        var suborderOptions = response.suborderoptions;
        if(suborderOptions==0)
        {
            $('.suborder').hide();
        }
        else
        {
            $('.suborder').show();
            $("#suborder_id").html('');
            $("#suborder_id").html(suborderOptions);
        }
        }

        /*
         * populateInvoiceSchedule.
         * @purpose -populate Invoice Schedule.
         * @Date - 18/01/2018
         * @author - NJ
         */
        function populateInvoiceSchedule(response) {
            $(".one").remove();

        var invoicescheduleInfo = response.invoicescheduleinfo;
        if(invoicescheduleInfo.length==1)
        {
            if($("#invoice_schedule_row_1").length == 1) {
                $("#invoice_startdate_1").val(invoicescheduleInfo[0].invoice_date);
                $("#invoice_amount_1").val(invoicescheduleInfo[0].invoice_amount);
                $("#invoice_comment_1").val(invoicescheduleInfo[0].invoice_comment);
                $("input[name='invoice_schedule_id[]']").val(invoicescheduleInfo[0].schedule_id);
                if(invoicescheduleInfo[0].status=='C')
                {
                    $("#invoice_status_c_1").prop('checked', true);
                }

                if(invoicescheduleInfo[0].status=='T')
                {
                    $("#invoice_status_t_1").prop('checked', true);
                }
            }
        } else if(invoicescheduleInfo.length > 1) {

            var invoicescheduleDetail = invoicescheduleInfo[0];
            if ($("#invoice_schedule_row_1").length == 1) {
                $("#invoice_startdate_1").val(invoicescheduleInfo[0].invoice_date);
                $("#invoice_amount_1").val(invoicescheduleInfo[0].invoice_amount);
                $("#invoice_comment_1").val(invoicescheduleInfo[0].invoice_comment);
                $("input[name='invoice_schedule_id[]']").val(invoicescheduleInfo[0].schedule_id);
                if(invoicescheduleInfo[0].status=='C')
                {
                    $("#invoice_status_c_1").prop('checked', true);
                }

                if(invoicescheduleInfo[0].status=='T')
                {
                    $("#invoice_status_t_1").prop('checked', true);
                }

            } else {

                var nextIndex = 1;

                var invoicescheduleDetail = invoicescheduleInfo[0];

                var invoicedate = invoicescheduleDetail.invoice_date;
                $("#invoice_startdate_1").val(invoicedate);

                var invoiceamount = invoicescheduleDetail.invoice_amount;
                $("#invoice_amount_1").val(invoiceamount);

                var invoicecomment = invoicescheduleDetail.invoice_comment;
                $("#invoice_comment_1").val(invoicecomment);

                $("input[name='invoice_schedule_id[]']").val(invoicescheduleDetail.schedule_id);
                var invoicestatus = invoicescheduleDetail.status;
                if(invoicestatus=='C')
                {
                    $("#invoice_status_c_1").prop("checked", true);
                }
                if(invoicestatus=='T')
                {
                    $("#invoice_status_t_1").prop("checked", true);
                }
                $invoiceCloneObjeNew = $invoiceCloneObje;
               $invoiceCloneObjeNew.addClass("one");
              //  $invoiceCloneObjeNew.attr('id', 'invoice_amount_' + nextIndex);
               // $invoiceCloneObjeNew.attr('id', 'invoice_comment_' + nextIndex);
                $invoiceCloneObjeNew.each(function () {
                    $(this).find("input[name^='invoice_startdate[']").attr({name: 'invoice_startdate[' + invoicescheduleDetail.schedule_id + ']'});
                    $(this).find("input[name^='invoice_startdate[']").attr({value: invoicedate});

                    $(this).find("input[name^='invoice_amount[']").attr({name: 'invoice_amount[' + invoicescheduleDetail.schedule_id + ']'});
                    $(this).find("input[name^='invoice_amount[']").attr({value: invoiceamount});

                    $(this).find("input[name^='invoice_comment[']").attr({name: 'invoice_comment[' + invoicescheduleDetail.schedule_id + ']'});
                    $(this).find("input[name^='invoice_comment[']").attr({value: invoicecomment});


                    $(this).find("input[value='C']").attr({id:'invoice_status_c_'+nextIndex, name:'invoice_status_'+nextIndex});
                    $(this).find("input[value='T']").attr({id:'invoice_status_t_'+nextIndex, name:'invoice_status_'+nextIndex});
                    $(this).find("label[for^='invoice_status_c']").attr({for:'invoice_status_c_'+nextIndex});
                    $(this).find("label[for^='invoice_status_t']").attr({for:'invoice_status_t_'+nextIndex});
                    $(this).find("input[name='invoice_schedule_id[]']").attr({value: invoicescheduleDetail.schedule_id});
                    if(invoicestatus=='C')
                    {
                        $(this).find("label[for^='invoice_status_c']").prop('checked', true);
                    }
                    if(invoicestatus=='T')
                    {
                        $(this).find("label[for^='invoice_status_t']").prop('checked', true);
                    }
                });
                $cloneHtml = $invoiceCloneObjeNew.wrap('<div>').parent().html();
                $('#totalamount').before($cloneHtml);
               // $("#invoicebox").append($cloneHtml);
            }
            for (i = 1; i <= invoicescheduleInfo.length - 1; i++) {

                var nextIndex = i + 1;
                var invoicescheduleDetail = invoicescheduleInfo[i];
                var invoicedate = invoicescheduleDetail.invoice_date;
                var invoiceamount = invoicescheduleDetail.invoice_amount;
                var invoicecomment = invoicescheduleDetail.invoice_comment;
                var invoicestatus = invoicescheduleDetail.status;
                $invoiceCloneObjeNew = $invoiceCloneObje;
                $invoiceCloneObjeNew.addClass("one");
                $invoiceCloneObjeNew.each(function () {
                    $(this).find("input[name^='invoice_startdate[']").attr({name: 'invoice_startdate[' + invoicescheduleDetail.schedule_id + ']', id:'invoice_startdate_'+nextIndex});
                    $(this).find("input[name^='invoice_startdate[']").attr({value: invoicedate});

                    $(this).find("input[name^='invoice_amount[']").attr({name: 'invoice_amount[' + invoicescheduleDetail.schedule_id + ']', id:'invoice_amount_'+nextIndex});
                    $(this).find("input[name^='invoice_amount[']").attr({value: invoiceamount});

                    $(this).find("input[name^='invoice_comment[']").attr({name: 'invoice_comment[' + invoicescheduleDetail.schedule_id + ']', id:'invoice_comment_'+nextIndex});
                    $(this).find("input[name^='invoice_comment[']").attr({value: invoicecomment});

                    $(this).find("input[value='C']").attr({id:'invoice_status_c_'+nextIndex, name:'invoice_status_' + invoicescheduleDetail.schedule_id});
                    $(this).find("input[value='T']").attr({id:'invoice_status_t_'+nextIndex, name:'invoice_status_' + invoicescheduleDetail.schedule_id});
                    $(this).find("label[for^='invoice_status_c']").attr({for:'invoice_status_c_'+nextIndex});
                    $(this).find("label[for^='invoice_status_t']").attr({for:'invoice_status_t_'+nextIndex});
                    $(this).find("input[name='invoice_schedule_id[]']").attr({value: invoicescheduleDetail.schedule_id});
                    if(invoicestatus=='C')
                    {
                        $(this).find("input[id^='invoice_status_c_']").attr('checked', true);
                        $(this).find("input[id^='invoice_status_t_']").attr('checked', false);
                    }

                    if(invoicestatus=='T')
                    {
                        $(this).find("input[id^='invoice_status_t_']").attr('checked', true);
                        $(this).find("input[id^='invoice_status_c_']").attr('checked', false);
                    }
                });
                $cloneHtml = $invoiceCloneObjeNew.wrap('<div>').parent().html();
                $('#totalamount').before($cloneHtml);
                //$("#totalamount").prepend($cloneHtml);
            }
        }
        var netSubTotal = 0;
        $("input[name^='invoice_amount[']").each(function() {

            if($(this).val() !='') {
                netSubTotal = netSubTotal + parseInt($(this).val());
            }
        });
        $cloneHtml = $("#totalInvoiceAmount").text(netSubTotal);

        $("#totalInvoiceAmount").append($cloneHtml);
    }

    /*
     * populateAttachment.
     * @purpose -populate Attachment.
     * @Date - 18/01/2018
     * @author - NJ
     */
    function populateAttachment(response) {
        $('.order_attachment_box').remove(); /*Clean old of exist*/

        var attachmentinfo = response.attachmentinfo;
        //alert(attachmentinfo.length);
        if(attachmentinfo.length == 0) /*For those order that do not have pre attachments */
        {
            var nextIndex = 1
            $attachmentCloneObjeNew = $attachmentCloneObje;
            $attachmentCloneObjeNew.attr('id', 'order_attachment_box_' + nextIndex);

            if($attachmentCloneObje.find("select[name^='invoice_doc[']").length > 0) {
                $attachmentCloneObjeNew.find("select[name^='invoice_doc['] option").removeAttr("selected");
            } else{
                $attachmentCloneObjeNew.find("select[name^='add_invoice_doc['] option").removeAttr("selected");
            }

            $attachmentCloneObjeNew.each(function () {
                if($(this).find("input[name^='attachment[']").length > 0) {
                    $(this).find("input[name^='attachment[']").attr({name: 'add_agreement_name[]', id:'attachment'+nextIndex});
                } else {
                    $(this).find("input[name^='add_agreement_name[']").attr({name: 'add_agreement_name[]', id:'attachment'+nextIndex});
                }

                $(this).find(".file-upload-input").attr({value: ''});
                if($(this).find("select[name^='invoice_doc[']").length > 0) {
                    $(this).find("select[name^='invoice_doc[']").attr({name: 'add_invoice_doc[]', id:'invoice_doc'+nextIndex});
                } else {
                    $(this).find("select[name^='add_invoice_doc[']").attr({name: 'add_invoice_doc[]', id:'invoice_doc'+nextIndex});
                }

            });
            $attachmentCloneObjeNew.find(".file-upload-span").html('');
            $attachmentCloneObjeNew.find("input[name^='file-upload-input[']").attr({id:'file-upload-input_'+nextIndex});
            $attachmentCloneObjeNew.find("label[for^=file-upload-input]").attr({id:'file-upload-input_'+nextIndex+'-error', for:'file-upload-input_'+nextIndex});

            $attachmentCloneObjeNew.find(".add_more_btn").attr('id', 'add_more_btn_' + nextIndex);
            $attachmentCloneObjeNew.find(".delete_record ").attr('id', 'delete_record_' + nextIndex);

            $cloneHtml = $attachmentCloneObjeNew.wrap('<div>').parent().html();
            // $(".order_attachment_box:last").after($cloneHtml);
            $(".add_more_attach_inv").parent().before($cloneHtml);
            //$(".add:not(:first)").hide();
            $("#delete_record_1").hide();
            $("#add_more_btn_1").show();
            //$(".add").show();
            //$(".delete_record").hide();
        } else if(attachmentinfo.length >= 1) {

            if ($(".order_attachment_box").length == 1) { /*Will not Execute AT all (already removing this element at first place)*/
                var attachmentDetail = attachmentinfo[0];
                $("select[name='invoice_doc[]'").attr({name: 'invoice_doc[' + attachmentDetail.attach_id + ']'});

                $("#invoice_doc1").val(attachmentinfo[0].attach_type);
                var original_name = attachmentinfo[0].attach_file_name.split(/_(.+)/)[1];
                $("input[name='attachment[]'").attr({name: 'attachment[' + attachmentDetail.attach_id + ']'});
               // $(this).find(".file-upload-input").attr({value: original_name});
                $(".file-upload-input").val( original_name);
            } else {
                var nextIndex = 1;
                var attachmentDetail = attachmentinfo[0];
                var attachtype = attachmentDetail.attach_type;
                var original_name = attachmentDetail.attach_file_name.split(/_(.+)/)[1];
                if(original_name == 'undefined') {
                    original_name = attachmentDetail.attach_file_name;
                } else {
                    var FirstPart =  attachmentDetail.attach_file_name.split(/_(.+)/)[0];
                    if(!$.isNumeric(FirstPart)) {
                        original_name = attachmentDetail.attach_file_name;
                    }
                }
                var $link = original_name;
                if(attachmentDetail.attach_file_path) {
                    var fileOriginalPath = BASEURL + attachmentDetail.attach_file_path.split('public_html/')[1];
                    fileOriginalPath = fileOriginalPath.replace(/\/+$/,'');
                    fileOriginalPath += "/"+attachmentDetail.attach_file_name;
                    $link = "<a target='_blank' href='"+fileOriginalPath+"'>"+original_name+"</a>"
                }
                $attachmentCloneObjeNew = $attachmentCloneObje;
                $attachmentCloneObjeNew.attr('id', 'order_attachment_box_' + nextIndex);
                if($attachmentCloneObje.find("select[name^='invoice_doc[']").length > 0) {
                    $attachmentCloneObjeNew.find("select[name^='invoice_doc['] option").removeAttr("selected");
                    $attachmentCloneObjeNew.find("select[name^='invoice_doc[']").attr({name: 'invoice_doc[' + attachmentDetail.attach_id + ']', id:'invoice_doc'+nextIndex});
                    var ddl = $attachmentCloneObjeNew.find("select[name^='invoice_doc[']");
                    ddl.find("option[value = '" + attachtype + "']").attr("selected", "selected");
                } else {
                    $attachmentCloneObjeNew.find("select[name^='add_invoice_doc['] option").removeAttr("selected");
                    $attachmentCloneObjeNew.find("select[name^='add_invoice_doc[']").attr({name: 'invoice_doc[' + attachmentDetail.attach_id + ']', id:'invoice_doc'+nextIndex});
                    var ddl = $attachmentCloneObjeNew.find("select[name^='invoice_doc[']");
                    ddl.find("option[value = '" + attachtype + "']").attr("selected", "selected");
                }

                $attachmentCloneObjeNew.each(function () {
                    if($(this).find("input[name^='attachment[']").length > 0) {
                        $(this).find("input[name^='attachment[']").attr({name: 'attachment[' + attachmentDetail.attach_id + ']'});
                        $(this).find(".file-upload-input").attr({value: original_name});
                    } else {
                        $(this).find("input[name^='add_agreement_name[']").attr({name: 'attachment[' + attachmentDetail.attach_id + ']'});
                        $(this).find(".file-upload-input").attr({value: original_name});
                    }
                });
                $attachmentCloneObjeNew.find(".file-upload-span").html($link);

                $attachmentCloneObjeNew.find("input[name^='file-upload-input[']").attr({id:'file-upload-input_'+nextIndex});
                $attachmentCloneObjeNew.find("label[for^=file-upload-input]").attr({id:'file-upload-input_'+nextIndex+'-error', for:'file-upload-input_'+nextIndex});
                $attachmentCloneObjeNew.find(".add_more_btn").attr('id', 'add_more_btn_' + nextIndex);
                $attachmentCloneObjeNew.find(".delete_record ").attr('id', 'delete_record_' + nextIndex);
                $cloneHtml = $attachmentCloneObjeNew.wrap('<div>').parent().html();
                $(".add_more_attach_inv").parent().before($cloneHtml);
            }

            for (i = 1; i <= attachmentinfo.length - 1; i++) {
                var nextIndex = i + 1;
                var attachmentDetail = attachmentinfo[i];
                var original_name = attachmentDetail.attach_file_name.split(/_(.+)/)[1];
                if(original_name == 'undefined') {
                    original_name = attachmentDetail.attach_file_name;
                } else {
                    var FirstPart =  attachmentDetail.attach_file_name.split(/_(.+)/)[0];
                    if(!$.isNumeric(FirstPart)) {
                        original_name = attachmentDetail.attach_file_name;
                    }
                }
                var $link = original_name;
                if(attachmentDetail.attach_file_path) {
                    var fileOriginalPath = BASEURL + attachmentDetail.attach_file_path.split('public_html/')[1];
                    fileOriginalPath = fileOriginalPath.replace(/\/+$/,'');
                    fileOriginalPath += "/"+attachmentDetail.attach_file_name;
                    $link = "<a target='_blank' href='"+fileOriginalPath+"'>"+original_name+"</a>"
                }
                var attachtype = attachmentDetail.attach_type;
                $attachmentCloneObjeNew = $attachmentCloneObje;
                $attachmentCloneObjeNew.attr('id', 'order_attachment_box_' + nextIndex);

                if($attachmentCloneObje.find("select[name^='invoice_doc[']").length > 0) {
                    $attachmentCloneObjeNew.find("select[name^='invoice_doc['] option").removeAttr("selected");
                } else{
                    $attachmentCloneObjeNew.find("select[name^='add_invoice_doc['] option").removeAttr("selected");
                }

                $attachmentCloneObjeNew.each(function () {

                    if($(this).find("input[name^='attachment[']").length > 0) {
                        $(this).find("input[name^='attachment[']").attr({
                            name: 'attachment[' + attachmentDetail.attach_id + ']',
                            id: 'attachment' + nextIndex
                        });
                    } else{
                        $(this).find("input[name^='add_agreement_name[']").attr({
                            name: 'attachment[' + attachmentDetail.attach_id + ']',
                            id: 'attachment' + nextIndex
                        });
                    }

                    $(this).find(".file-upload-input").attr({value: original_name});

                    if($(this).find("select[name^='invoice_doc[']").length > 0) {
                        $(this).find("select[name^='invoice_doc[']").attr({
                            name: 'invoice_doc[' + attachmentDetail.attach_id + ']',
                            id: 'invoice_doc' + nextIndex
                        });
                        var ddl = $(this).find("select[name^='invoice_doc[']");
                        ddl.find("option[value = '" + attachtype + "']").attr("selected", "selected");
                    } else  {
                        $(this).find("select[name^='add_invoice_doc[']").attr({
                            name: 'invoice_doc[' + attachmentDetail.attach_id + ']',
                            id: 'invoice_doc' + nextIndex
                        });
                        var ddl = $(this).find("select[name^='invoice_doc[']");
                        ddl.find("option[value = '" + attachtype + "']").attr("selected", "selected");
                    }
                });
                $attachmentCloneObjeNew.find(".file-upload-span").html($link);

                $attachmentCloneObjeNew.find("input[name^='file-upload-input[']").attr({id:'file-upload-input_'+nextIndex});
                $attachmentCloneObjeNew.find("label[for^=file-upload-input]").attr({id:'file-upload-input_'+nextIndex+'-error', for:'file-upload-input_'+nextIndex});
                $attachmentCloneObjeNew.find(".add_more_btn").attr('id', 'add_more_btn_' + nextIndex);
                $attachmentCloneObjeNew.find(".delete_record ").attr('id', 'delete_record_' + nextIndex);
                $cloneHtml = $attachmentCloneObjeNew.wrap('<div>').parent().html();
                $(".add_more_attach_inv").parent().before($cloneHtml);
                //$(".add:not(:first)").hide();
                //$(".delete_record:not(:first)").show();
            }
            $(".add_more_btn:not(:first)").hide();
            $("#delete_record_1").hide();
            $("#add_more_btn_1").show();
        }
    }
    /*
     * addMoreAttachment.
     * @purpose -Add more Attachment.
     * @Date - 18/01/2018
     * @author - NJ
     */

    function addMoreAttachment() {
        //$(".delete_attachment").show();
        var nextIndex = $(".attachtype").length + 1;
        var LastEl = $(".order_attachment_box").last();
        var lastid = LastEl.attr('id');
        var LastIdParts = lastid.split("order_attachment_box_");
        var lenth = LastIdParts[1];
        var nextIndex = parseInt(lenth) + 1;
        $attachmentCloneObje.attr({id:'order_attachment_box_'+nextIndex});

        if($attachmentCloneObje.find("select[name^='invoice_doc[']").length > 0) {
            $attachmentCloneObje.find("select[name^='invoice_doc[']").attr({
                name: 'add_invoice_doc[]',
                id: 'invoice_doc' + nextIndex,
                value: ''
            });
            $attachmentCloneObje.find("option[selected]").removeAttr("selected");
        } else {
            $attachmentCloneObje.find("select[name^='add_invoice_doc[']").attr({
                name: 'add_invoice_doc[]',
                id: 'invoice_doc' + nextIndex,
                value: ''
            });
            $attachmentCloneObje.find("option[selected]").removeAttr("selected");
        }
        //var nextIndex = $(".file-upload-wrapper").length + 1;
        $attachmentCloneObje.find(".file-upload-wrapper").attr('id','file-upload-wrapper_'+nextIndex);

        if($attachmentCloneObje.find("input[name^='attachment[']").length > 0) {
            $attachmentCloneObje.find("input[name^='attachment[']").attr({id:'attachment'+nextIndex,value:''});
            $attachmentCloneObje.find("input[name^='attachment[']").attr({name:'add_agreement_name[]'});
        } else {
            $attachmentCloneObje.find("input[name^='add_agreement_name[']").attr({id:'attachment'+nextIndex,value:''});
            $attachmentCloneObje.find("input[name^='add_agreement_name[']").attr({name:'add_agreement_name[]'});
        }
        $attachmentCloneObje.find(".file-upload-span").html('');
        $attachmentCloneObje.find("input[name^='file-upload-input[']").attr({name:"file-upload-input[]" ,id:'file-upload-input_'+nextIndex, value:''});
        $attachmentCloneObje.find("label[for^=file-upload-input]").attr({id:'file-upload-input_'+nextIndex+'-error', for:'file-upload-input_'+nextIndex});

        $attachmentCloneObje.find(".add_more_btn").attr('id', 'add_more_btn_' + nextIndex);
        $attachmentCloneObje.find(".delete_record ").attr('id', 'delete_record_' + nextIndex);

        $attachmentCloneObje.find(".add_more_btn").hide();
		$attachmentCloneObje.find(".delete_attachment").show();

        $cloneHtml = $attachmentCloneObje.wrap('<div>').parent().html();
        $(".add_more_attach_inv").parent().before($cloneHtml);
    }

    /*
     * populateAgreementName.
     * @purpose -Populate Agreement Name.
     * @Date - 18/01/2018
     * @author - NJ
     */
    function populateAgreementName(response) {
        /*Populate AgreementName*/
        var agreementOptions = response.agreementoptions;

  if(agreementOptions!=''){
            $('.selectpicker').selectpicker('show');
            $("#client_agreement").html('');
            $("#client_agreement").html(agreementOptions);
            $("#client_agreement").selectpicker('refresh');
            $("#noAttachment").hide();

        }else{
            $("#client_agreement").hide();
            $('.selectpicker').selectpicker('hide');

            $("#noAttachment").show();
            $("#noAttachment").html('No Attachment.');

        }

    }
    /*
     * populateManagerDetails.
     * @purpose -populate Manager Details
     * @Date - 18/01/2018
     * @author - NJ
     */
    function populateManagerDetails(response) {
        /*Populate ManagerDetails*/
        var managerOptions = response.manageroptions;
        $("#manager_name").html('');
        $("#manager_name").html(managerOptions);
        /*As per Amit Goyal Sir's Feedback manager should be by selected any one of them-08-May-2018*/
        var category_id = $("#category_id").val();
        if(category_id== LOCALIZATIONCAT ||category_id== LOCALIZATIONINCCAT)
        {
            $("#manager_name").find('option:eq(1)').prop('selected', true);
            $("#manager_name").trigger('change');
        }
    }
    /*
     * populateAccountDetails.
     * @purpose -Populate Account Details.
     * @Date - 18/01/2018
     * @author - NJ
     */
    function populateAccountDetails(response) {
        /*Populate AccountDetails*/
        var accountpersonOptions = response.accountpersonoptions;
        $("#acc_person").html('');
        $("#acc_person").html(accountpersonOptions);

        /*As per Amit Goyal Sir's Feedback manager should be by selected any one of them- 08-May-2018*/
        var category_id = $("#category_id").val();
        if(category_id== LOCALIZATIONCAT ||category_id== LOCALIZATIONINCCAT)
        {
            $("#acc_person").find('option:eq(1)').prop('selected', true);
            $("#acc_person").trigger('change');
        }
    }
    /*
     * populateClientAddress.
     * @purpose -Populate Client Address.
     * @Date - 18/01/2018
     * @author - NJ
     */
    function populateClientAddress(response)
    {
        var clientAddress= response.clientaddress;
        $("#postal_address").val(clientAddress[0].address);
    }

    /*
     * populateSalesPersons.
     * @purpose -populate SalesPersons.
     * @Date - 18/01/2018
     * @author - NJ
     */
    function populateSalesPersons(response) {
        var salesPersonsDetails = response.salespersonsdetails;

        $("#contact_number").val(salesPersonsDetails[0].sales_contact_no);
        $("#email_id").val(salesPersonsDetails[0].sales_person_email);

    } /*END SALES PERSON*/

    /*
     * populateAccountPersons.
     * @purpose -Populate Account Persobs.
     * @Date - 18/01/2018
     * @author - NJ
     */
    function populateAccountPersons(response) {
        /*Populate Account person*/
        var accountPersonsDetails = response.accountpersonsdetails;
        $("#contact_number1").val(accountPersonsDetails[0].account_contact_no);
        $("#email_id1").val(accountPersonsDetails[0].account_person_email);
    }
    /*
     * setPoDetails.
     * @purpose -If No Po is checked true,PoNo displays none.
     * @Date - 18/01/2018
     * @author - NJ
     */
    function setPoDetails(){
        if( $("#no_po").prop('checked') == true)
        {
            $("#po_ro_number").val('None');
            $("#po_ro_number").prop("disabled", true);
            $("#po_ro_date").datepicker().val('');

        } else {
            $("#po_ro_number").val('');
            $("#po_ro_number").prop("disabled", false);

        }
    }
    /*
     * populateProjectName.
     * @purpose -populate ProjectName.
     * @Date - 18/01/2018
     * @author - NJ
     */
    function populateProjectName(response) {
        /*Populate ProjectName*/
        var projectOptions = response.projectoptions;
        $("#order_id").html('');
        $("#order_id").html(projectOptions);
    }
    /*
     * populateClientName.
     * @purpose -populate ClientName.
     * @Date - 18/01/2018
     * @author - NJ
     */
    function populateClientName(response) {
        var clientnameOptions = response.clientnameoptions;
        $("#client_name").html('');
        $("#client_name").html(clientnameOptions);
    }
    /*
     * setInvoiceAmount.
     * @purpose -set Invoice Amount.
     * @Date - 18/01/2018
     * @author - NJ
     */
    function setInvoiceAmount(){
        var netSubTotal = 0;
        $('input[name="invoice_schedule_id[]"]:checked').each(function() {
            var rowContainer = $(this).parent().parent().parent().parent();
            var rowAmt = rowContainer.find('input[name^="invoice_amount["]').val();
            if(rowAmt !='') {
                netSubTotal = netSubTotal + parseFloat(rowAmt);
            }
        });
        if(netSubTotal == 0) {
            $("#inv_amount").val('');
        } else  {
            $("#inv_amount").val(netSubTotal);
        }
    }

    function getClientInfo(clientID, account_id, salesperson_id){
        $.ajax({
            type: "POST",
            url: BASEURL + "invoice/getInfoByClient",
            dataType: 'json',
            data: {client: clientID},
            beforeSend: function () {
                // setting a timeout
                $('.loader-wrapper').show()
            },
            success: function (response) {
                if (response != 0) {
                    $validator.resetForm();
                    populateAgreementName(response);
                    populateManagerDetails(response);
                    populateAccountDetails(response);
                    populateClientAddress(response);
                    $("#acc_person").val(account_id);
                    $("#manager_name").val(salesperson_id);
                    //var managerinput = $("<input>").attr("type", "hidden").attr("name", "manager").val(salesperson_id);
                    //var accountinput = $("<input>").attr("type", "hidden").attr("name", "account_person").val(account_id);
                    var client = $("<input>").attr("type", "hidden").attr("name", "client").val(clientID);
                    //$('#create-invoice').append(managerinput);
                    //$('#create-invoice').append(accountinput);
                    $('#create-invoice').append(client);


                }
            },
            error: function (error) {
                $('.loader').hide();
                alert("There is an error while getting details. Please try again.");
            },
            complete: function () {
                $('.loader-wrapper').hide();
            },
        });
    }