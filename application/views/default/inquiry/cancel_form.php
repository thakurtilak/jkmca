<form action="" method="POST" name="cancelInquiryForm" id="cancelInquiryForm">
    <div class="alert alert-danger" id="errorMessage" style="display: none;"></div>
    <div class="form-group">
        <div class="pull-left model-job-info alert alert-warning">
            <label class="control-label">Temp. Ref No.</label>
            <h4><?php echo $inquiryDetail->ref_no;?></h4>
        </div>

    </div>
    <div class="form-group">
        <div class="pull-left model-static-info alert alert-info">
            <label class="control-label">Client Name</label>
             <h5><?php echo $inquiryDetail->first_name." ".$inquiryDetail->last_name;?></h5>
        </div>
        <div class="pull-left model-static-info alert alert-info">
            <label class="control-label">Father's Name</label>
            <h5><?php echo $inquiryDetail->fathers_first_name." ".$inquiryDetail->fathers_last_name;?></h5>
        </div>
        <div class="pull-right model-static-info alert alert-info">
            <label class="control-label">Mobile</label>
            <h5><?php echo $inquiryDetail->mobile;?></h5>
        </div>
    </div>
    <div class="form-group">
        <input type="hidden" name="refId" id="refId" value="<?php echo $inquiryDetail->ref_no; ?>">
        <label class="control-label">Cancel Reason<sup>*</sup></label>
        <textarea class="ims_form_control" name="reason" required placeholder="Reason" />
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

       $("#cancelInquiryForm").validate({
            rules:{
                reason:{
                    required:true
                },
                refId:{
                    required:true
                }
            },
            messages:{
                reason:{
                    required:"This field is required"
                },
                refId:{
                    required:"This field is required"
                }
            }
       });

        $("#cancelInquiryForm").submit(function (e) {
            e.preventDefault();
            if($(this).valid()){
                var refId = $("#refId").val();
                var SubmitURL = BASEURL + "inquiry/cancel-form/"+refId;
                $.ajax({
                    type: "POST",
                    url: SubmitURL,
                    cache: false,
                    data : $("#cancelInquiryForm").serialize(),
                    success: function (data) {
                        var response = $.parseJSON(data);
                        if(response.success) {
                            $("#cancelInquiryModel").modal('hide');
                            table.draw();
                        } else {
                            $("#errorMessage").show().text("There is an error while cancel Inquiry.");
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