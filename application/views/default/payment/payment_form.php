<form action="" method="POST" name="paymentUpdateJobForm" id="paymentUpdateJobForm">
    <div class="alert alert-danger" id="errorMessage" style="display: none;"></div>
    <div class="form-group">
        <div class="pull-left model-job-info alert alert-warning">
            <label class="control-label">JobID</label>
            <h4><?php echo $jobDetail->job_number;?></h4>
        </div>

    </div>
    <div class="form-group">
        <div class="pull-left model-static-info alert alert-success">
            <label class="control-label">Amount</label>
             <h3><?php echo formatAmount($jobDetail->amount);?></h3>
        </div>
        <div class="pull-left model-static-info alert alert-info">
            <label class="control-label">Discount</label>
            <h3><?php echo formatAmount($jobDetail->discount_price);?></h3>
        </div>
        <div class="pull-right model-static-info alert alert-danger">
            <label class="control-label">Remaining Amount</label>
            <h3><?php echo formatAmount($jobDetail->remaining_amount);?></h3>
        </div>
    </div>
    <div class="form-group">
        <input type="hidden" name="jobId" id="jobId" value="<?php echo $jobDetail->id; ?>">
        <input type="hidden" name="old_discount" id="old_discount" value="<?php echo $jobDetail->discount_price; ?>">
        <input type="hidden" name="remaining_amount" id="remaining_amount" value="<?php echo $jobDetail->remaining_amount; ?>">

        <label class="control-label">Amount<sup>*</sup></label>
        <input type="text" class="ims_form_control" name="payment" id="payment" required placeholder="Payment" />
    </div>
    <div class="form-group">
        <label class="control-label">Discount ( If Any )</label>
        <input type="text" class="ims_form_control" name="discount" id="discount" placeholder="Discount" />
    </div>
    <div class="form-footer">
        <button type="submit" value="Update" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white" name="Update">Update</button>
        <button class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white" data-dismiss="modal">No</button>
    </div>
</form>
<style>
    .model-static-info{
        padding: 10px 0px;
        //background: darkgray;
        height: 75px;
        width: 32%;
        border-radius: 5px;
        //color: white;
        font-size: 15px;
        text-align: center;
        margin-right: 7px;
    }
    .model-static-info h3{
        margin-top: 5px;
    }
    .model-job-info{
        width: 100%;
    }
</style>
<script>
    $(document).ready(function () {
        $.validator.addMethod('lessThanEqual', function(value, element, param) {
            return this.optional(element) || parseInt(value) <= parseInt($(param).val());
        }, "The value {0} must be less than {1}");

       $("#paymentUpdateJobForm").validate({
            rules:{
                payment:{
                    required:true,
                    number:true,
                    lessThanEqual: "#remaining_amount"
                },
                discount:{
                    number:true,
                    lessThanEqual: "#remaining_amount"
                }
            },
            messages:{
                payment:{
                    required:"This field is required",
                    lessThanEqual:"Payment shouldn't be grater than remaining amount"
                },
                discount:{
                    lessThanEqual: "Discount shouldn't be grater than remaining amount"
                }
            }
       });

        $("#paymentUpdateJobForm").submit(function (e) {
            e.preventDefault();
            if($(this).valid()){
                var jobId = $("#jobId").val();
                var SubmitURL = BASEURL + "payment/payment-form/"+jobId;
                $.ajax({
                    type: "POST",
                    url: SubmitURL,
                    cache: false,
                    data : $("#paymentUpdateJobForm").serialize(),
                    success: function (data) {
                        var response = $.parseJSON(data);
                        if(response.success) {
                            $("#paymentModel").modal('hide');
                            table.draw();
                        } else {
                            $("#errorMessage").show().text("There is an error while update payment.");
                        }
                        //modal.find('.payment_form').html(data);
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }
        });
    });
</script>