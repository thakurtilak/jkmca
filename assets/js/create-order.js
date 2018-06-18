    /**
     * Created by nishi.jain on 19-Jan-18.
     */
        $validator = null;
        var FromEndDate = new Date();
        $(document).ready(function () {
            $("#noAttachment").hide();
        $invoiceCloneObje = $("#invoice_schedule_row_1").clone();
        $attachmentCloneObje = $("#order_attachment_box_1").clone();

        /*
         * Datepicker
         * @purpose - Apply datepicker on all date fields..
         * @Date - 25/01/2018
         * @author - NJ
         */

        var startDateCal = $("#start_date").datepicker({
            format: "d-M-yyyy",
            autoclose: true,
            startDate: '-1y',
            endDate:'+1y',
        }).on('changeDate', function(e){
            var selected = e.date;
           // endDateCal.setStartDate(selected);
            $('#end_date').datepicker('setStartDate', selected);
        });
       var endDateCal = $("#end_date").datepicker({
            format: "d-M-yyyy",
            autoclose: true,
            startDate: '-1y',
            endDate:'+5y'
        }).on('changeDate', function(e){
            var selected = e.date;
           $('#start_date').datepicker('setEndDate', selected);
        });

        $("#po_date").datepicker({format: "d-M-yyyy",autoclose: true, startDate: '-1y',endDate: FromEndDate});
        $(".invoice_schedule_date").datepicker({format: "d-M-yyyy",autoclose: true, startDate: '-1y', endDate:'+5y'});

        /*
         * ClientSide Validations.
         * @purpose - Client Side Validations..
         * @Date - 25/01/2018
         * @author - NJ
         */


       $validator = $("#createOrder").validate({
           /* submitHandler: function(form) {
                //return false;
                $(form).submit();
            },*/
            ignore: ":hidden:not(.file-upload-input)",
            rules: {
                category_id: {required: true},
                client: {required: true},
                project_type:{required: true},
                order_type:{required: true},
                start_date:{required: true},
                project_name:{required: true},
                order_id:{required: true},
                project_description:{required: true},
                wd_sales_id:{required:true},
                wd_tech_head_id:{required:true},
                efforts_unit:{required:true},
                unit_rate:{required:true,number:true},
                hourCurncy:{required:true},
                end_date:{required: true},
                total_efforts: {required: true,number:true},
                effort_unit: {required: true},
                order_amount: {required: true, number:true},
                order_curncy: {required: true},
                duration:{required: true,digits:true},
                "add_invoice_startdate[]": {required: true},
                "add_invoice_amount[]": {required: true, number:true},
                sales_contact_person:{required: true},
                sales_contact_no:{required: true},
                /*account_contact_no:{required: true},*/
                sales_email_id:{required: true, email:true},
                client_address:{required: true},
                invoice_org_remarks: {required: true},
              /*  account_contact_person:{required: true},
                account_email_id:{required: true, email:true},*/
                po_no:{
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
                po_date:{
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
                project_name: {
                    remote: {
                        url: BASEURL+"/orders/projectExists",
                        type: "post",
                        data:
                        {
                            project: function()
                            {
                                return $( "#project_name" ).val();
                            }
                        }
                    }
                },
                po_dtl:{
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
                "file-upload-input[]":{
                  /*  required:{
                        depends: function(element){
                            var status = true;
                            if( $("#no_po:checked").val() !== undefined){
                                var status = false;
                            }
                            return status;
                        }
                    } */extension:"gif|jpg|png|jpeg|pdf|zip|docx|doc|xls|xlsx|eml|msg"
                },
                payment_term:{required:true},

            },

            messages: {
                category_id: {required: "This field is required" },
                client: {required: "This field is required"},
                project_type:{required: "This field is required"},
                order_type: {required: "This field is required"},
                start_date:{required: "This field is required"},
                project_name:{required: "This field is required"},
                order_id:{required: "This field is required"},
                project_description:{required: "This field is required"},
                wd_sales_id:{required:"This field is required"},
                wd_tech_head_id:{required:"This field is required"},
                efforts_unit: {required:"This field is required"},
                unit_rate:{required:"This field is required",number:"Only number allow"},
                hourCurncy:{required:"This field is required"},
                end_date:{required: "This field is required"},
                total_efforts: {required: "This field is required",number:"The field should contain a numeric value"},
                effort_unit: {required: "This field is required"},
                order_amount: { required: "This field is required", number:"The field should contain a numeric value"},
                order_curncy: {required: "This field is required"},
                duration:{required: "This field is required",digits:"Only digits allow"},
                "add_invoice_startdate[]": {required: "This field is required"},
                "add_invoice_amount[]": {required: "This field is required", number:"The field should contain a numeric value"},
                sales_contact_person:{required: "This field is required"},
                sales_contact_no:{required: "This field is required"},
                sales_email_id:{required: "This field is required", email:"Invalid email address"},
                client_address:{required: "This field is required"},
               /* account_contact_person:{required: "Please select account person"},
                account_contact_no:{required:"Please enter contact no."},
                account_email_id:{required: "Please enter email id", email:"Invalid email address"},*/
                po_no:{required:"This field is required"},
                po_date:{required:"This field is required"},
               "file-upload-input[]":{extension:"Invalid file format"},
                po_dtl:{required:"This field is required"},
                "payment_term":{required:"This field is required"},
                invoice_org_remarks: {required: "This field is required"},
                project_name:{
                    remote: jQuery.validator.format("{0} is already taken.")
                }
            }

        });

            function resetForm($form) {
                $form.find('input:text, input:password, input:file, select, textarea').val('');
                $form.find('input:radio, input:checkbox')
                    .removeAttr('checked').removeAttr('selected');
            }
            $("#resetCreateOrder").click(function () {
                resetForm($('#createOrder'));
                $("input[name^='invoice_amount[']").attr("value", "");
                $("input[name^='invoice_comment[']").attr("value", "");
                $("input[name^='invoice_startdate[']").attr("value", "");
                $("label[for^='invoice_status_c_']").attr("value", "");
                $("label[for^='invoice_status_t_']").attr("value", "");
                $("#totalInvoiceAmount").html('');
                $("#client_agreement").html('');
                $("#client_agreement").selectpicker('refresh');
                $("#client option").not(':eq(0), :selected').remove();
                $("#sales_contact_person option").not(':eq(0), :selected').remove();
                $("#account_contact_person option").not(':eq(0), :selected').remove();
                $("#order_id").hide();
                $("#project_name").show();
                $("#invoicebox").hide();
                $('.unit_rate').hide();
                $('.hourCurncy').hide();
                $('.efforts_unit').hide();
                $(".end_date").show();
                $(".tnmDuration").show();
                //$("#project_type").reset();
            });

        /*
         * Get Client by Category
         * @purpose - To get client according to category selected..
         * @Date - 25/01/2018
         * @author - NJ
         */
        $("#category_id").on('change', function () {
            var categoryId = $(this).val();

            $.ajax({
                type: "POST",
                url: BASEURL + "orders/getClientByCategory",
                data: {cat_id: categoryId},
                beforeSend: function () {
                    // setting a timeout
                    $('.loader-wrapper').show()
                },
                success: function (data) {
                    $validator.resetForm();
                    /*For reseting entire form*/
                    resetForm($('#createOrder'));
                    $("#category_id").val(categoryId);
                    $("input[name^='invoice_amount[']").attr("value", "");
                    $("input[name^='invoice_comment[']").attr("value", "");
                    $("input[name^='invoice_startdate[']").attr("value", "");
                    $("label[for^='invoice_status_c_']").attr("value", "");
                    $("label[for^='invoice_status_t_']").attr("value", "");
                    $("#totalInvoiceAmount").html('');
                    $("#client_agreement").html('');
                    $("#client_agreement").selectpicker('refresh');
                    $("#client option").not(':eq(0), :selected').remove();
                    $("#sales_contact_person option").not(':eq(0), :selected').remove();
                    $("#account_contact_person option").not(':eq(0), :selected').remove();
                    $("#order_id").hide();
                    $("#project_name").show();
                    $("#invoicebox").hide();
                    $('.unit_rate').hide();
                    $('.hourCurncy').hide();
                    $('.efforts_unit').hide();
                    $(".end_date").show();
                    $(".tnmDuration").show();
                    //$("#project_type").reset();
                    /*END For reseting entire form*/


                    $("#client").html('');
                    $("#client").html(data);
                },
                error: function (error) {
                    $('.loader').hide();
                    alert("There is an error while getting clients. Please try again.");
                },
                complete: function () {
                    $('.loader-wrapper').hide();
                },
            });

        });

        /*
         *  getInfoByClient
         * @purpose - To get  details according to client selected..
         * @Date - 02/02/2018
         * @author - NJ
         */
        $("#client").on('change', function () {
            var clientname = $(this).val();
            $.ajax({
                type: "POST",
                url: BASEURL + "orders/getInfoByClient",
                dataType: 'json',
                data: {client: clientname},
                beforeSend: function () {
                    // setting a timeout
                    $('.loader-wrapper').show()
                },
                success: function (response) {
                    if (response != 0) {
                        $validator.resetForm();
                        populateProjectName(response);
                        populateAgreementName(response);
                        populateManagerDetails(response);
                        populateAccountDetails(response);
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


            $("#client").on('change', function () {
                $('#sales_contact_no').val('');
                $('#sales_email_id').val('');
                $("#client_address").val('');
                $('#account_contact_no').val('');
                $('#account_email_id').val('');
                $('#sales_contact_person').find("option:first").attr("selected", "selected");
                $('#account_contact_person').find("option:first").attr("selected", "selected");
                $("#client_agreement").html('');
                $("#client_agreement").selectpicker('refresh');

            });


            $("#category_id").on('change', function () {
                $('#sales_contact_no').val('');
                $('#sales_email_id').val('');
                $("#client_address").val('');
                $('#account_contact_no').val('');
                $('#account_email_id').val('');
                $('#sales_contact_person').find("option:first").attr("selected", "selected");
                $('#account_contact_person').find("option:first").attr("selected", "selected");
                $("#client_agreement").html('');
                $("#client_agreement").selectpicker('refresh');

            });

        /*
         *  GetManagerDetailsByManagerName
         * @purpose - To get Client Manager details according to Manager name selected..
         * @Date - 25/01/2018
         * @author - NJ
         */
        $("#sales_contact_person").on('change',function(){
            var salesId = $(this).val();
            if(salesId =='') {
                return;
            }
            $.ajax({
                type: "POST",
                url: BASEURL+"orders/getManagerInfoByManagerName",
                dataType: 'json',
                data: {salesId:salesId},
                beforeSend: function() {
                    // setting a timeout
                    //$('.loader-wrapper').show()
                },
                success: function (response) {
                    if(response != 0) {

                        populateSalesPersons(response);
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
         *  GetAccountDetailsByAccountPersonName
         * @purpose - To get Client Manager details according to AccountPerson name selected..
         * @Date - 25/01/2018
         * @author - NJ
         */
        $("#account_contact_person").on('change',function(){
            var accountId = $(this).val();
            if(accountId =='') {
                return;
            }
            $.ajax({
                type: "POST",
                url: BASEURL+"orders/getAccountInfoByAccountName",
                dataType: 'json',
                data: {accountId:accountId},
                beforeSend: function() {
                    // setting a timeout
                    //$('.loader-wrapper').show()
                },
                success: function (response) {
                    if(response != 0) {
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

        /*
         *  getDetailsByProjectName
         * @purpose - To get details according to Project name selected..
         * @Date - 29/01/2018
         * @author - NJ
         */
         $("#order_id").on('change',function(){
            var projectdetails = $(this).val();
            if(projectdetails =='') {
                return;
            }
            $.ajax({
                type: "POST",
                url: BASEURL+"orders/getDetailsByProjectName",
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
                        //NO NEED To POPULATE SCHEDULES IN CASE OF EDIT
                        //populateInvoiceSchedule(response);
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
         *  Change of input field on onchange of OrderType
         * @purpose - Function for change of input field on onchange of Order Type ..
         * @Date - 25/01/2018
         * @author - NJ
         */
            $("#order_type").on('change',function(){
            var ordertype = this.value;
            if(ordertype=="E")
            {
                $('#order_id').show();
                $("#project_name").hide();
            }
            else
            {
                $('#project_name').show();
                $("#order_id").hide();
            }
        });
        /*
         * Show/Hide Fields on onchange of ProjectType
         * @purpose - Function for Show/Hide Fields on onchange of ProjectType ..
         * @Date - 29/01/2018
         * @author - NJ
         */
        $("#project_type").on('change',function(){

            $('#start_date').datepicker('setStartDate', '-1y');
            $('#start_date').datepicker('setEndDate', '+1y');
            $('#end_date').datepicker('setStartDate', '-1y');
            $('#end_date').datepicker('setEndDate', '+5y');

            $('#start_date').datepicker('setDate', '');
            $('#end_date').datepicker('setDate', '');
            var projecttype = this.value;
            if(projecttype=="TNM")
            {
                $('.unit_rate').show();
                $('.hourCurncy').show();
                $('.efforts_unit').show();
                $(".end_date").hide();
                $("#end_date").val("");
                $("#invoicebox").hide();
            }
            else if(projecttype=="FB")
            {
                $(".end_date").show();
                $(".unit_rate").hide();
                $("#unit_rate").val("");
                $('.hourCurncy').hide();
                $('.efforts_unit').hide();
                $('#efforts_unit').val("");
                $('.invoiceRow').not(':first').remove();
                $("#invoicebox").show();

                $(".tnmDuration").hide();
                $("#duration").val("");
            }
            else{
                $("#invoicebox").hide();
            }
        });

        /*
         * Change Placeholder on onchange of Unit
         * @purpose - Function for Change Placeholder on onchange of Unit ..
         * @Date - 29/01/2018
         * @author - NJ
         */
        $("#efforts_unit").on('change',function(){
            var unit = this.value;
            if(unit=="H")
            {
                $("#total_efforts").attr("placeholder", "Hourly consumption");
                $(".tnmDuration").hide();
                $("#invoicebox").hide();
                $("#duration").val("");

            }
            else if(unit=="D")
            {
                $("#total_efforts").attr("placeholder", "Daily consumption");
                $(".tnmDuration").hide();
                $("#duration").val("");
                $("#invoicebox").hide();

            }
            else if(unit=="M") {
                $("#total_efforts").attr("placeholder", "Monthly consumption");
                $(".tnmDuration").show();
            }
            $("#effort_unit").val(unit);
            $('#effort_unit').prop('disabled', 'disabled');

        });

        /*
         * Cloned Invoice schedule fields on change of month.
         * @purpose - Function for Cloned Invoice schedule fields on change of month...
         * @Date - 30/01/2018
         * @author - NJ
         */
        $("#duration").on('change',function(){
            var num = this.value;
            if(num!=""){
                $("#invoicebox").show();
                $("div[id^='invoice_schedule_row_']").remove();
                $("#invoice_schedules").val("1");
                //num=num-1;
                while (num) {
                    addMoreInvoiceSchedule();
                    //$('#invoice_date_' + new_id).focus();
                    $("#invoice_schedules").val($("#invoice_schedules").val() + ',' + 1);
                    num--;
                }
                $(".delete_record:first").hide();
            }

        });

        /*File Handling*/
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

        $(".delete_record").hide();
        /*Delete single invoice scheduled record*/
        $(document).on('click', '.delete_schedule_invoice', function() {
            $deleteBox = $(this).parent().parent().parent().parent();
            $deleteBox.remove();
        });

        /*Delete single invoice attachment record*/
        $(document).on('click', '.delete_attachment', function() {
            $deleteBox = $(this).parent().parent().parent();
            $deleteBox.remove();
        });

        //Schedule amount sum
      $(document).on('change', "input.invoiceAmount", function() {
            var netSubTotal = 0;
            $("input.invoiceAmount").each(function() {
                if($(this).val() !='') {
                    netSubTotal = netSubTotal + parseInt($(this).val());
                }
            });

            if(!isNaN(netSubTotal)) {
                if(netSubTotal > $("#order_amount").val()){
                    alert("Total schedule amount should not be more than order amount.");
                    $(this).val("");
                    $(this).focus();
                    return;
                }
                $("#totalInvoiceAmount").text(netSubTotal);
            }
        });
    });


         /*
         *  populateSalesPersons
         * @purpose - Function for populateSalesPersons ..
         * @Date - 25/01/2018
         * @author - NJ
         */
        function populateSalesPersons(response) {
            //Populate sales persons
            var salesPersonsDetails = response.salespersonsdetails;
            $("#sales_contact_no").val(salesPersonsDetails[0].sales_contact_no);
            $("#sales_email_id").val(salesPersonsDetails[0].sales_person_email);
            var $address = salesPersonsDetails[0].sales_person_address;
                /*if(salesPersons[0].sales_person_address2 !='' && typeof salesPersons[0].sales_person_address2 != undefined) {
                    $address = $address +" "+ salesPersons[0].sales_person_address2;
                }*/
                $("#client_address").val($address);
        } /*END SALES PERSON*/

        /*
         *  populateAccountPersons
         * @purpose - Function for populateAccountPersons ..
         * @Date - 25/01/2018
         * @author - NJ
         */
        function populateAccountPersons(response) {

        /*Populate Account person*/
        var accountPersonsDetails = response.accountpersonsdetails;
        $("#account_contact_no").val(accountPersonsDetails[0].account_contact_no);
        $("#account_email_id").val(accountPersonsDetails[0].account_person_email);
        }


      /*
     *  populateDetailsByProjectName
     * @purpose - Function for populate details on selection of project name.
     * @Date - 29/01/2018
     * @author - NJ
     */
      function populateDetailsByProjectName(response) {
          var projectInfo = response.projectinfo;
          $("#project_description").val(projectInfo[0].project_description);
          $("#wd_sales_id").val(projectInfo[0].wd_sales_person_id);
          $("#wd_tech_head_id").val(projectInfo[0].wd_tech_head_id);
          $("#po_no").val(projectInfo[0].po_no);
          if(projectInfo[0].po_no=='None') {
              $("#no_po").prop("checked", true);
              $("#po_no").prop("disabled", true);
              $("#po_date").prop("disabled", true);
          }
          $("#po_date").val(projectInfo[0].po_date);
          $("#po_dtl").val(projectInfo[0].po_dtl);
          $("#payment_term").val(projectInfo[0].payment_term);
      }

    /*
     *  populateAttachment
     * @purpose -populate Attachment.
     * @Date - 29/01/2018
     * @author - NJ
     */
       function populateAttachment(response) {
           $('.order_attachment_box').remove(); /*Clean old of exist*/
           var attachmentinfo = response.attachmentinfo;

           if(attachmentinfo.length == 0 ) /*For those order that do not have pre attachments */
           {
               var nextIndex = 1;
               $attachmentCloneObjeNew = $attachmentCloneObje;
               $attachmentCloneObjeNew.attr({id:'order_attachment_box_'+nextIndex});

               $attachmentCloneObjeNew.find(".invoice_doc_wrapper").attr('id','invoice_doc_'+nextIndex);
               $attachmentCloneObjeNew.find(".invoice_attachment_wrapper").attr('id','attachment_'+nextIndex);
               $attachmentCloneObjeNew.find(".file-upload-wrapper").attr('id', 'file-upload-wrapper_' + nextIndex);

               if($attachmentCloneObjeNew.find("select[name^='add_invoice_doc[']").length > 0){
                   $attachmentCloneObjeNew.find("select[name^='add_invoice_doc[']").attr({name: 'add_invoice_doc[]', id:'invoice_doc'+nextIndex});

               } else {
                   $attachmentCloneObjeNew.find("select[name^='invoice_doc[']").attr({name: 'add_invoice_doc[]', id:'invoice_doc'+nextIndex});
               }
               if($attachmentCloneObjeNew.find("input[name^='add_agreement_name[']").length > 0)
               {
                   $attachmentCloneObjeNew.find("input[name^='add_agreement_name[']").attr({name: 'add_agreement_name[]', id:'attachment'+nextIndex});
               } else {
                   $attachmentCloneObjeNew.find("input[name^='attachment[']").attr({name: 'add_agreement_name[]', id:'attachment'+nextIndex});
               }
               $attachmentCloneObjeNew.find(".file-upload-input").attr({value: ''});
               $attachmentCloneObjeNew.find(".file-upload-span").html(" ");

               $attachmentCloneObjeNew.find("input[name^='file-upload-input[']").attr({id:'file-upload-input_'+nextIndex});
               $attachmentCloneObjeNew.find("label[for^=file-upload-input]").attr({id:'file-upload-input_'+nextIndex+'-error', for:'file-upload-input_'+nextIndex});

               $attachmentCloneObjeNew.find(".add_more_btn").attr('id', 'add_more_btn_' + nextIndex);
               $attachmentCloneObjeNew.find(".delete_record ").attr('id', 'delete_record_' + nextIndex);
               $cloneHtml = $attachmentCloneObjeNew.wrap('<div>').parent().html();
               $(".add-more-wrapper").parent().before($cloneHtml);
               $("#delete_record_1").hide();
               $("#add_more_btn_1").show();
           } else if(attachmentinfo.length >= 1) {

               if ($(".order_attachment_box").length == 1) { /*Will not Execute AT all (already removing this element at first place)*/

                   $("#invoice_doc1").val(attachmentinfo[0].attach_type);
                   var original_name = attachmentinfo[0].attach_file_name.split(/_(.+)/)[1];
                   $(document).find("input[name^='attachment[']").attr({name: 'attachment[' + attachmentinfo[0].attach_id + ']'});
                   $(".file-upload-input").attr({value: original_name});

               } else {
                   var nextIndex = 1;
                   var attachmentDetail = attachmentinfo[0];
                   var attachtype = attachmentDetail.attach_type;
                   //$("#invoice_doc1").val(attachtype);

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
                   $attachmentCloneObjeNew.attr({id:'order_attachment_box_'+nextIndex});

                   $attachmentCloneObjeNew.find(".invoice_doc_wrapper").attr('id','invoice_doc_'+nextIndex);
                   $attachmentCloneObjeNew.find(".invoice_attachment_wrapper").attr('id','attachment_'+nextIndex);
                   $attachmentCloneObjeNew.find(".file-upload-wrapper").attr('id', 'file-upload-wrapper_' + nextIndex);

                   if($attachmentCloneObjeNew.find("select[name^='add_invoice_doc[']").length > 0)
                   {
                       $attachmentCloneObjeNew.find("select[name^='add_invoice_doc[']").attr({name: 'invoice_doc[' + attachmentDetail.attach_id + ']', id:'invoice_doc'+nextIndex});
                       var ddl = $attachmentCloneObjeNew.find("select[name^='add_invoice_doc[']");

                       ddl.find("option[value = '" + attachtype + "']").attr("selected", "selected");

                       var dd2 = $attachmentCloneObjeNew.find("select[name^='invoice_doc[']");
                       dd2.find("option[value = '" + attachtype + "']").attr("selected", "selected");
                   } else {
                       $attachmentCloneObjeNew.find("select[name^='invoice_doc[']").attr({name: 'invoice_doc[' + attachmentDetail.attach_id + ']', id:'invoice_doc'+nextIndex});
                       var ddl = $attachmentCloneObjeNew.find("select[name^='invoice_doc[']");
                       ddl.find("option[value = '" + attachtype + "']").attr("selected", "selected");
                   }
                    console.log(attachtype);
                   if($attachmentCloneObjeNew.find("input[name^='add_agreement_name[']").length > 0)
                   {
                       $attachmentCloneObjeNew.find("input[name^='add_agreement_name[']").attr({name: 'attachment[' + attachmentDetail.attach_id + ']', id:'attachment'+nextIndex});
                   } else {
                       $attachmentCloneObjeNew.find("input[name^='attachment[']").attr({name: 'attachment[' + attachmentDetail.attach_id + ']', id:'attachment'+nextIndex});
                   }
                   $attachmentCloneObjeNew.find(".file-upload-input").attr({value: original_name});

                   $attachmentCloneObjeNew.find(".file-upload-span").html($link);



                   $attachmentCloneObjeNew.find("input[name^='file-upload-input[']").attr({id:'file-upload-input_'+nextIndex});
                   $attachmentCloneObjeNew.find("label[for^=file-upload-input]").attr({id:'file-upload-input_'+nextIndex+'-error', for:'file-upload-input_'+nextIndex});

                   $attachmentCloneObjeNew.find(".add_more_btn").attr('id', 'add_more_btn_' + nextIndex);
                   $attachmentCloneObjeNew.find(".delete_record ").attr('id', 'delete_record_' + nextIndex);
                   $cloneHtml = $attachmentCloneObjeNew.wrap('<div>').parent().html();
                   $(".add-more-wrapper").parent().before($cloneHtml);
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
                       fileOriginalPath += "/"+ attachmentDetail.attach_file_name;
                       $link = "<a target='_blank' href='"+fileOriginalPath+"'>"+original_name+"</a>"
                   }
                   var attachtype = attachmentDetail.attach_type;
                   $attachmentCloneObjeNew = $attachmentCloneObje;

                   $attachmentCloneObjeNew.attr({id:'order_attachment_box_'+nextIndex});
                   $attachmentCloneObjeNew.find(".invoice_doc_wrapper").attr('id','invoice_doc_'+nextIndex);
                   $attachmentCloneObjeNew.find(".invoice_attachment_wrapper").attr('id','attachment_'+nextIndex);
                   $attachmentCloneObjeNew.find(".file-upload-wrapper").attr('id', 'file-upload-wrapper_' + nextIndex);

                   $attachmentCloneObjeNew.each(function () {
                       $(this).find("input[name^='attachment[']").attr({name: 'attachment[' + attachmentDetail.attach_id + ']', id:'attachment'+nextIndex});
                       $(this).find(".file-upload-input").attr({value: original_name});
                       $(this).find("select[name^='invoice_doc[']").attr({name: 'invoice_doc[' + attachmentDetail.attach_id + ']', id:'invoice_doc'+nextIndex});
                       var ddl = $(this).find("select[name^='invoice_doc[']");
                       ddl.find("option[value = '" + attachtype + "']").attr("selected", "selected");
                   });
                   $attachmentCloneObjeNew.find(".file-upload-span").html($link);

                   $attachmentCloneObjeNew.find("input[name^='file-upload-input[']").attr({id:'file-upload-input_'+nextIndex});
                   $attachmentCloneObjeNew.find("label[for^=file-upload-input]").attr({id:'file-upload-input_'+nextIndex+'-error', for:'file-upload-input_'+nextIndex});

                   $attachmentCloneObjeNew.find(".add_more_btn").attr('id', 'add_more_btn_' + nextIndex);
                   $attachmentCloneObjeNew.find(".delete_record ").attr('id', 'delete_record_' + nextIndex);

                   //$attachmentCloneObjeNew.find(".add_more_btn").remove();
                   //ele.hide();
                   $cloneHtml = $attachmentCloneObjeNew.wrap('<div>').parent().html();
                   $(".add-more-wrapper").parent().before($cloneHtml);

                   //$(".add_more_btn:not(:first)").hide();
                   //$(".delete_record:not(:first)").show();
               }
               $(".add_more_btn:not(:first)").hide();
               $("#delete_record_1").hide();
               $("#add_more_btn_1").show();
               //$(".delete_record:not(:first)").show();
           }
         }

    /*
     *  populateProjectName
     * @purpose - populate ProjectName.
     * @Date - 29/01/2018
     * @author - NJ
     */
    function populateProjectName(response) {
        /*Populate ProjectName*/
        var projectOptions = response.projectoptions;
        $("#order_id").html('');
        $("#order_id").html(projectOptions);
    }
    function populateInvoiceSchedule(response) {
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
               // $("#invoice_startdate_1").val(invoicescheduleInfo[0].invoice_date);
              //  $("#invoice_amount_1").val(invoicescheduleInfo[0].invoice_amount);
               // $("#invoice_comment_1").val(invoicescheduleInfo[0].invoice_comment);
                $("#invoice_startdate_1").attr({name: 'invoice_startdate[' + invoicescheduleDetail.schedule_id + ']',value:invoicescheduleInfo[0].invoice_date});
                $("#invoice_amount_1").attr({name: 'invoice_amount[' + invoicescheduleDetail.schedule_id + ']',value:invoicescheduleInfo[0].invoice_amount});
                $("#invoice_comment_1").attr({name: 'invoice_comment[' + invoicescheduleDetail.schedule_id + ']',value:invoicescheduleInfo[0].invoice_comment});

                $("input[name='invoice_schedule_id[]']").val(invoicescheduleInfo[0].schedule_id);

                if(invoicescheduleInfo[0].status=='C')
                {
                    $("#invoice_status_c_1").attr({name:'invoice_status_' + invoicescheduleDetail.schedule_id}).prop('checked', true);
                }

                if(invoicescheduleInfo[0].status=='T')
                {
                    $("#invoice_status_t_1").attr({name:'invoice_status_' + invoicescheduleDetail.schedule_id}).prop('checked', true);
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
                    $("#invoice_status_c_1").prop('checked', true);
                }
                if(invoicestatus=='T')
                {
                    $("#invoice_status_t_1").prop('checked', true);
                }
                $invoiceCloneObjeNew = $invoiceCloneObje;
                $invoiceCloneObjeNew.attr('id', 'invoice_startdate_' + nextIndex);
                $invoiceCloneObjeNew.attr('id', 'invoice_amount_' + nextIndex);
                $invoiceCloneObjeNew.attr('id', 'invoice_comment_' + nextIndex);
                $invoiceCloneObjeNew.each(function () {
                    $(this).find("input[name^='add_invoice_startdate[']").attr({name: 'invoice_startdate[' + invoicescheduleDetail.schedule_id + ']',value: invoicedate});
                    //$(this).find("input[name^='add_invoice_startdate[']").attr({});

                    $(this).find("input[name^='add_invoice_amount[']").attr({name: 'invoice_amount[' + invoicescheduleDetail.schedule_id + ']',value: invoiceamount});
                    //$(this).find("input[name^='add_invoice_amount[']").attr({value: invoiceamount});

                    $(this).find("input[name^='add_invoice_comment[']").attr({name: 'invoice_comment[' + invoicescheduleDetail.schedule_id + ']',value: invoicecomment});
                   // $(this).find("input[name^='add_invoice_comment[']").attr({value: invoicecomment});


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
                $("#invoicebox").append($cloneHtml);
            }
            for (i = 1; i <= invoicescheduleInfo.length - 1; i++) {
                var nextIndex = i + 1;
                var invoicescheduleDetail = invoicescheduleInfo[i];
                var invoicedate = invoicescheduleDetail.invoice_date;
                var invoiceamount = invoicescheduleDetail.invoice_amount;
                var invoicecomment = invoicescheduleDetail.invoice_comment;
                var invoicestatus = invoicescheduleDetail.status;
                $invoiceCloneObjeNew = $invoiceCloneObje;
                $invoiceCloneObjeNew.each(function () {
                    $(this).find("input[name^='add_invoice_startdate[']").attr({name: 'invoice_startdate[' + invoicescheduleDetail.schedule_id + ']', id:'invoice_startdate_'+nextIndex,value: invoicedate});

                    $(this).find("input[name^='add_invoice_amount[']").attr({name: 'invoice_amount[' + invoicescheduleDetail.schedule_id + ']', id:'invoice_amount_'+nextIndex,value: invoiceamount});

                    $(this).find("input[name^='add_invoice_comment[']").attr({name: 'invoice_comment[' + invoicescheduleDetail.schedule_id + ']', id:'invoice_comment_'+nextIndex,value: invoicecomment});

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

               $('#totalinv').before($cloneHtml);
               //$("#totalamount").prepend($cloneHtml);
            }
        }
        var netSubTotal = 0;
        $("input.invoiceAmount").each(function() {
            if($(this).val() !='') {
                netSubTotal = netSubTotal + parseInt($(this).val());
            }
        });
        $cloneHtml = $("#totalInvoiceAmount").text(netSubTotal);

        $("#totalInvoiceAmount").append($cloneHtml);
    }
    /*
     *  populateAgreementName
     * @purpose -populate AgreementName.
     * @Date - 29/01/2018
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
     *  populateManagerDetails
     * @purpose -populate Manager Details.
     * @Date - 29/01/2018
     * @author - NJ
     */
    function populateManagerDetails(response) {
        /*Populate ManagerDetails*/
        var managerOptions = response.manageroptions;
        $("#sales_contact_person").html('');
        $("#sales_contact_person").html(managerOptions);
    }

    /*
     *  populateAccountDetails
     * @purpose -populate AccountDetails.
     * @Date - 29/01/2018
     * @author - NJ
     */
    function populateAccountDetails(response) {
        /*Populate AccountDetails*/
        var accountpersonOptions = response.accountpersonoptions;
        $("#account_contact_person").html('');
        $("#account_contact_person").html(accountpersonOptions);

    }

    /*
     *  AddMoreInvoiceSchedule
     * @purpose - Add More InvoiceSchedule.
     * @Date - 29/01/2018
     * @author - NJ
     */
           function addMoreInvoiceSchedule() {
            var nextIndex = $(".invoiceRow").length + 1;
               $invoiceCloneObje.attr('id','invoice_schedule_row_'+nextIndex);
               $invoiceCloneObje.each(function () {
                  $(this).find("input[name^='add_invoice_startdate[']").attr({id:'invoice_startdate_'+nextIndex,value:'',name:'add_invoice_startdate[]'});
                   $(this).find("input[name^='add_invoice_amount[']").attr({id:'invoice_amount_'+nextIndex,value:'',name:'add_invoice_amount[]'});
                  $(this).find("input[name^='add_invoice_comment[']").attr({id:'invoice_comment_'+nextIndex,value:'',name:'add_invoice_comment[]'});
                  $(this).find("input[value^='C']").attr({id:'invoice_status_c_'+nextIndex, name:'invoice_status_'+nextIndex});
                   $(this).find("input[value^='T']").attr({id:'invoice_status_t_'+nextIndex, name:'invoice_status_'+nextIndex});
                   $(this).find("label[for^='invoice_status_c_']").attr({for:'invoice_status_c_'+nextIndex, name:'invoice_status_'+nextIndex});
                   $(this).find("label[for^='invoice_status_t_']").attr({for:'invoice_status_t_'+nextIndex, name:'invoice_status_'+nextIndex});
            });
            $cloneHtml = $invoiceCloneObje.wrap('<div>').parent().html();

            $("#totalinv").before($cloneHtml);
               $(".invoice_schedule_date").datepicker({format: "d-M-yyyy", autoclose: true, startDate: '-1y', endDate:'+5y'});

               $("#invoice_startdate_"+nextIndex).rules("add", {
                   required: true
               });

               $("#invoice_amount_"+nextIndex).rules("add", {
                   required: true,
                   number:true
               });
           }


            /*
             *  addMoreAttachment
             * @purpose -Add More Attachment.
             * @Date - 29/01/2018
             * @author - NJ
             */
          function addMoreAttachment() {

              var LastEl = $(".order_attachment_box").last();
              var lastid = LastEl.attr('id');
              var LastIdParts = lastid.split("order_attachment_box_");
              var lenth = LastIdParts[1];
              var nextIndex = parseInt(lenth) + 1;
              $attachmentCloneObje.attr({id:'order_attachment_box_'+nextIndex});


              $attachmentCloneObje.find(".invoice_doc_wrapper").attr('id','invoice_doc_'+nextIndex);
              $attachmentCloneObje.find(".invoice_attachment_wrapper").attr('id','attachment_'+nextIndex);

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
             // $attachmentCloneObje.find("select[name^='invoice_doc[']").attr({id:'invoice_doc'+nextIndex,value:''});
             // $attachmentCloneObje.find("option[selected]").removeAttr("selected");
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
              //$attachmentCloneObje.find("input[name^='attachment[']").attr({id:'attachment'+nextIndex,value:''});
              $attachmentCloneObje.find("input[name^='file-upload-input[']").attr({id:'file-upload-input_'+nextIndex,value:''});
              $attachmentCloneObje.find("label[for^=file-upload-input]").attr({id:'file-upload-input_'+nextIndex+'-error', for:'file-upload-input_'+nextIndex});

              $attachmentCloneObje.find(".add_more_btn").hide();
              $cloneHtml = $attachmentCloneObje.wrap('<div>').parent().html();
              $(".add-more-wrapper").parent().before($cloneHtml);
          }

    /*
     *  setPoDetails
     * @purpose -setPoDetails.
     * @Date - 29/01/2018
     * @author - NJ
     */
          function setPoDetails(){
                if( $("#no_po").prop('checked') == true)
                {
                    $("#po_no").val('None');
                    $("#po_no").prop("disabled", true);
                    $("#po_date").prop("disabled", true);
                    $("#po_date").datepicker().val('');
                } else {
                    $("#po_no").val('');
                    $("#po_no").prop("disabled", false);
                    $("#po_date").prop("disabled", false);

                }
            }

