<div class="alert alert-danger" id="conversionEditError" style="display: none"></div>
<form action="<?php echo base_url(); ?>currency/edit/<?php echo $id; ?>" method="POST" name="editConversionForm" id="editConversionForm">
    <div class="form-group">
        <label class="ims_form_label">Month</label>
        <input readonly="readonly" value="<?php echo date('M-Y', strtotime($cRecord->month));?>" placeholder="Month" type="text" class="ims_form_control" name="conversion_month" id="conversion_month"/>
        <input value="<?php echo date('Y-m-01', strtotime($cRecord->month));?>" type="hidden" class="ims_form_control" name="conversion_month_actual" id="conversion_month_actual"/>
        <input value="<?php echo $id; ?>" type="hidden" class="ims_form_control" name="edit_id" id="edit_id"/>
    </div>
    <div class="form-group">
        <label class="ims_form_label"><?php echo $cRecord->currency_name ?><sup>*</sup></label>
        <input value="<?php echo $cRecord->conversion_rate ?>" placeholder="<?php echo $cRecord->currency_symbol ?> Conversion Rate" type="text" class="currency ims_form_control" name="conversion" id="conversion"/>
    </div>
    <div class="form-group clearfix">
    <a href="#rateModal" data-toggle="modal" class="pull-left current_rate">See Current Rates</a>
		</div>
</form>

<script>
    var $editConversionFormValidator;
    $(document).ready(function(){
        $editConversionFormValidator = $("#editConversionForm").validate({
            rules:{
                conversion:{
                    required: true,
                    number:true
                }
            },
            messages:{
                conversion:{
                    required: "This field is required",
                    number:"Please enter a valid number"
                }
            }
        });
        /*Conversion Edit Form*/
        $("#conversionEditSubmit").click(function(){
            var isValid = $("#editConversionForm").valid();
            var id = $("#edit_id").val();

            if(isValid && id) {
                var editUrl = BASEURL + "currency/edit/"+id;
                var form = $("#editConversionForm");
                var formData = form.serialize();
                $.ajax({
                    type: "POST",
                    url: editUrl,
                    cache: false,
                    data:formData,
                    beforeSend: function () {
                        $('.loader-wrapper').show();
                    },
                    success: function (res) {
                        if(res) {
                            res = JSON.parse(res);
                            if(res.success) {
                                $("#conversionEditError").text('');
                                $("#conversionEditError").hide();

                                $("#conversionSuccess").show();
                                $("#conversionSuccess").text(res.message);
                                $('#editModal').modal('hide');
                                table.draw();
                            } else if(res.error) {
                                $("#conversionEditError").text(res.error);
                                $("#conversionEditError").show();

                                $("#conversionSuccess").hide();
                                $("#conversionSuccess").text('');
                            } else {
                                $("#conversionEditError").text("There is an error while updating conversion.");
                                $("#conversionEditError").show();

                                $("#conversionSuccess").hide();
                                $("#conversionSuccess").text('');
                            }
                        }

                        $('.loader-wrapper').hide();
                    },
                    error: function (err) {
                        $("#conversionEditError").text("There is an error while updating conversion.");
                        $("#conversionEditError").show();
                        $('.loader-wrapper').hide();
                    }
                });
            }
            return false;
        });
    })
</script>