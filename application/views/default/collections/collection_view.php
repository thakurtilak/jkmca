<input type="hidden" name="id" id="id" value="<?php echo $invoiceDetail->invoice_req_id; ?>">

     <div class="view_order_info">
        <!--Request Invoice Details -->
        <!--<h3 class="form-box-title"> Invoice Details</h3>-->
        <ul class="order_view_detail">
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Invoice Number</span>
                    <span class="ov_data"><?php echo $invoiceDetail->invoice_no; ?></span>
                </div>
            </li>
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Invoice Date</span>
                    <span class="ov_data"><?php echo date('d-M-Y', strtotime($invoiceDetail->invoice_date)); ?></span>
                </div>
            </li>
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Payment Due Date</span>
                    <span class="ov_data"><?php echo date('d-M-Y', strtotime($invoiceDetail->payment_due_date)); ?></span>
                </div>
            </li>
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Payment Net Amt.</span>
                    <span class="ov_data"><?php echo $invoiceDetail->currency_symbol." ".formatAmount($invoiceDetail->invoice_net_amount); ?></span>
                </div>
            </li>
            <li class="od_block">
                <div class="order_info_block">
                    <span class="ov_title">Requested By</span>
                    <span class="ov_data"><?php echo $invoiceDetail->requestorname; ?></span>
                </div>
            </li>
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Generated By</span>
                    <span class="ov_data"><?php echo $invoiceDetail->generatedBy; ?></span>
                </div>
            </li>
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Client Name</span>
                    <span class="ov_data"><?php echo $invoiceDetail->client_name; ?></span>
                </div>
            </li>
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Category</span>
                    <span class="ov_data"><?php echo $invoiceDetail->category_name; ?></span>
                </div>
            </li>
        </ul>
         </div>
         <form action="" method="post" id="update-collection" name="update-collection" enctype="multipart/form-data">
             <h3 class="form-box-title"> Payment Detail</h3>
          <?php if($invoiceDetail->invoice_already_generated=='Y'){?>

              <td>
                  <h5 class="ov_title">Invoice is Already Generated.</h5>
              </td>
          <?php } ?>

              <ul class="order_view_detail">
              <li>
                  <div class="order_info_block">
                      <span class="ov_title">Payment Received</span>
                      <td><input name="pymt_recieved" type="radio" id="pymt_recieved" value="Y" checked="checked" disabled="disabled"/>Yes&nbsp;
                          <input name="pymt_recieved" type="radio" id="pymt_recieved" value="N" disabled="disabled"/>No</td>
                  </div>
              </li>
                 <li>
                     <div class="order_info_block">
                         <span class="ov_title">Payment Type</span>
                         <td><input name="pymt_type" type="radio" id="pymt_type" value="F" checked="checked" disabled="disabled"/>Full&nbsp;<input type="radio" name="pymt_type" id="pymt_type" value="P" disabled="disabled"/>Part</td>
                     </div>
                 </li>
                  <li>
                      <div class="order_info_block">
                          <span class="ov_title">Gross Invoice Amount</span>
                          <span class="ov_data"><?php echo $invoiceDetail->currency_symbol." ".formatAmount($invoiceDetail->invoice_gross_amount); ?></span>
                          <input type="hidden" id="grass_invoice_amount_hidden" value="<?php echo $invoiceDetail->invoice_gross_amount; ?>" />
                      </div>
                  </li>
                  <li>
                      <div class="order_info_block">
                          <span class="ov_title">Amount Received</span>
                          <span class="ov_data"><?php echo $invoiceDetail->currency_symbol; ?>&nbsp;<input name="invoice_amt_recieved" type="text" class="ims_form_control" style="width: 90%" id="invoice_amt_recieved" onchange="chkbal(<?php echo $invoiceDetail->invoice_gross_amount; ?>);"/>
                      </span>
                      </div>
                      <span class="error" id="msg" style="color:red"></span>
                  </li>
                  <li>
                      <div class="order_info_block">
                          <span class="ov_title">Date of Payment</span>
                          <input name="pymt_date" type="text" class="agreement_date ims_form_control date_icon sel_date" id="pymt_date" value="<?php echo date('d-M-Y') ?>" readonly/>
                      </div>
                  </li>
                  <li>
                 <div class="order_info_block">
                     <span class="ov_title">Payment Mode</span>
                     <select name="pymt_mode" id="pymt_mode" class="ims_form_control" >
                         <option value="">Select Mode</option>
                         <option value="cash">Cash</option>
                         <option value="check">Cheque</option>
                         <option value="draft">Draft</option>
                         <option value="wire">Wire</option>
                     </select>
                 </div>
             </li>
                  <li>
                      <div class="order_info_block">
                         <span class="ov_title" id="payment_id">Transaction ID</span>
                          <input type="text" name="trnsact_id" id="trnsact_id" class="ims_form_control"/>
                      </div>
                  </li>
                  <li>
                      <div class="order_info_block">
                          <span class="ov_title">Amount Balance</span>
                          <span class="ov_data"><div id="bal" ><?php echo $invoiceDetail->currency_symbol." ".formatAmount($invoiceDetail->invoice_gross_amount); ?></div></span>

                      </div>


                  </li>
                  </ul>
                  <ul class="order_view_detail">
                  <li>
                      <div class="order_info_block">
                          <span class="ov_title">Collectors Remark on Payment</span>
                          <textarea name="pymt_remarks" id="pymt_remarks" cols="110" rows="5"></textarea>
                      </div>
                  </li>
              </ul>
             <div>
    <input name="submit" type="button" class="btn-theme ml10 btn-submit mdl-js-button mdl-js-ripple-effect ripple-white" id="submit" onClick="return collection_submit()"  value="Submit" />
    <input name="pymt_reset_btn" type="reset" onClick="reset_form();" class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white" id="pymt_reset_btn" value="Reset" />
    </div>

         </form>

<!-- Script Code -->

<script>

    $("#pymt_date").datepicker({format: "dd-M-yyyy", autoClose: true, keepOpen: false}).on('show.bs.modal', function(event) {
        // prevent datepicker from firing bootstrap modal "show.bs.modal"
        event.stopPropagation();
    });


    $("#update-collection").validate({

        rules: {
            invoice_amt_recieved: {required: true,number:true, equalTo:"#grass_invoice_amount_hidden"},
            pymt_mode: {required: true},
            pymt_remarks : {required: true},
            trnsact_id: {required: true, alphanumeric:true},
 },
        messages: {
            invoice_amt_recieved: {required: "This field is required ", number:"The field should contain a numeric value", equalTo:"Amount should be equal to Gross Amount !! \n Please enter the correct Amount !!"},
            pymt_mode: {required: "This field is required"},
            pymt_remarks : {required: "This field is required "},
            trnsact_id : {required: "This field is required ", alphanumeric:"Invalid input data"},
        }
    });

    $("#pymt_mode").on('change', function () {

        var Id = $(this).val();
        if(Id == 'cash')
        {
            $( "#trnsact_id" ).prop( "disabled", true );
            $("#trnsact_id-error").text("");
            $("#payment_id").html("Cash");
        }
        else if(Id == 'check'){
            $( "#trnsact_id" ).prop( "disabled", false );
            $("#payment_id").html("Cheque No.");
        }
        else if(Id == 'draft'){
            $( "#trnsact_id" ).prop( "disabled", false );
            $("#payment_id").html("Draft No.");
        }
        else if(Id == 'wire'){
            $( "#trnsact_id" ).prop( "disabled", false );
            $("#payment_id").html("Payment ID");
        }
        else{
            $( "#trnsact_id" ).prop( "disabled", true );
            $("#payment_id").html("Transaction ID");
        }
    });



    function reset_form() {

        $("#invoice_amt_recieved").value = "";
        $("#pymt_date").datepicker().val('');
        $("#pymt_remarks").value = "";
        $('#pymt_mode').selectedIndex = "--Select Mode--";
        $("label.error, span.error").text('');
        var amt = $("#grass_invoice_amount_hidden").val();
        var bal = $("#bal").html();
        var bal1 = bal.split(' ');
        var balhtml = bal1[0] + " " + amt;
        $("#bal").html(balhtml);
        $("#payment_id").html("Transaction ID");
        return false;
    }

    function chkbal(amt) {
        var grossamount = amt;
        if ($("#invoice_amt_recieved").val() == "") {
            $("#bal").html(grossamount);

            return false;
        }
        var originalAmt = $("#grass_invoice_amount_hidden").val();/*Now comparing value with hidden field data*/
        var bal = $("#bal").html();
        var bal1 = bal.split(' ');
        var bal2 = parseInt(bal1[1]); /*Using grass_invoice_amount_hidden instead of bal2*/
        var amtbal = parseInt(originalAmt) - parseInt($("#invoice_amt_recieved").val());

        $("#bal").html('');
        $("#bal").html(bal1[0] + " " + amtbal);


        if ($("#invoice_amt_recieved").val() =='') {
            $("#msg").html("This field is required");
            return false;
        }


        if ($("#invoice_amt_recieved").val() != grossamount) {

            //$("#msg").html("Amount should be equal to Gross Amount !! \n Please enter the correct Amount !!");
            //$("#invoice_amt_recieved").val('');
            //$("#invoice_amt_recieved").focus()
            $("#bal").html(bal1[0] + " " + grossamount);
            return false;
        }
        else{
            $("#msg").html("");
        }
    }



    function collection_submit() {

        $isValid = $("#update-collection").valid();
        if($isValid) {
            var comment = $('#pymt_remarks').val();
            var amount = $('#invoice_amt_recieved').val();
            var paymentmode = $('#pymt_mode option:selected').val();
            var transactionId = $('#trnsact_id').val();
            var pymtdate = $("#pymt_date").val();
            var id = $("#id").val();

            $.ajax({
                type: "POST",
                url: BASEURL + "collections/pymtCollection",
                data: {
                    Id: id,
                    comment: comment,
                    amount: amount,
                    paymentmode: paymentmode,
                    transactionId: transactionId,
                    pymtdate: pymtdate
                },
                beforeSend: function () {
                    $('.loader-wrapper').show()
                },
                success: function (res) {
                    $('.loader-wrapper').hide();
                    if(res) {
                        var data = JSON.parse(res);
                        if (data.success == '1') {
                            window.location.href = BASEURL+"collections/update-payment";
                            $("#success_msg").html(data.message);

                        } else if (data.success == '0') {
                            window.location.href = BASEURL+"collections/update-payment";
                            $("#error_msg").html(data.message);
                        }
                    } else  {
                        window.location.href = BASEURL+"collections/update-payment";
                    }
                    return false;

                },
                error: function (error) {
                    alert("There is network error.");
                    return false;
                },
                complete: function () {
                    $('.loader-wrapper').hide();
                },
            });
            return false;
        }

    }





</script>

<!--pending_invoice_info -->






