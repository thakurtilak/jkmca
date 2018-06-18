<div class="content-wrapper">
    <div class="content_header">
        <h3><?php echo (isset($tax)? "Edit":"Add"); ?> Tax</h3>
    </div>
    <div class="inner_bg content_box">
        <div class="row">
            <div class="col-sm-12">
                <?php if($this->session->flashdata('error') != '') { ?>
                    <div class="alert alert-danger" style="margin-top:18px;">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php } ?>
                <form id="taxAddFrom" name="taxAddFrom" method="post" action="">
                    <div class="box-form">
                        <div class="theme-form">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form_label">Financial*</label>
                                        <select <?php echo (isset($tax)) ? 'disabled':''; ?> class="ims_form_control" name="financial_year" id="financial_year">
                                            <option value="">Financial Year</option>
                                            <?php if($financialYears) : foreach($financialYears as $year): ?>
                                                <option <?php echo (isset($tax) && $tax->financial_year == $year) ? 'selected':''; ?> value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                            <?php endforeach; endif; ?>
                                        </select>
                                        <?php echo form_error('financial_year'); ?>
                                    </div>
                                </div><!--col-sm-3-->
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form_label">Tax Name*</label>
                                        <input name="tax_detail" type="text" class="ims_form_control" id="tax_detail" value="<?php echo (isset($tax)) ? $tax->tax_detail :''; ?>" placeholder="Tax Name" />
                                        <?php echo form_error('tax_detail'); ?>
                                    </div>
                                </div><!--col-sm-3-->

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form_label">Tax Value(%)*</label>
                                        <input name="tax" type="text" class="ims_form_control" id="tax" value="<?php echo (isset($tax)) ? $tax->tax :''; ?>" placeholder="Tax Value" />
                                        <?php echo form_error('tax'); ?>
                                    </div>
                                </div><!--col-sm-3-->
                            </div><!--row-->
                        </div><!--theme-form-->
                    </div><!--box-form-->
                    <div class="col-sm-12">
                        <div class="form-footer">
                            <input type="submit" name="Submit" id="Submit" value="<?php echo (isset($tax)? "Edit Tax":"Add Tax"); ?>" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white">
                            <input name="reset" type="reset" class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white" id="reset" value="Reset">
                        </div>
                    </div><!--col-sm-12-->
                </form>
            </div><!--col-sm-12-->
        </div><!--row-->
    </div><!--inner_bg-->
</div><!--content-wrapper-->
<!--=================================== Old ======================================-->
<script type="text/javascript">
    $(document).ready(function(){
        $("#taxAddFrom").validate({
            rules:{
                financial_year:{
                    required:true
                },
                tax_detail:{
                    required:true
                },
                tax:{
                    required:true,
                    number:true
                }
            },
            messages:{
                financial_year:{
                    required:"This field is required"
                },
                tax_detail:{
                    required:"This field is required"
                },
                tax:{
                    required:"This field is required",
                    number:"Please enter a valid number"
                }
            }
        });
    });
</script>