<div class="content-wrapper">
    <div class="content_header">
        <h3><?php echo "Manage Configurations"; ?></h3>
    </div>
    <div class="inner_bg content_box">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <?php if($this->session->flashdata('error') != '') { ?>
                    <div class="alert alert-danger" id="error_mesg"style="margin-top:18px;">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php } ?>
                <?php if($this->session->flashdata('success') != '') { ?>
                    <div class="alert alert-success" id="success_msg" style="margin-top:18px;">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php } ?>
                <form id="configurationFrom" name="configurationFrom" method="post" action="">


                    <?php if(isset($allGroups)): ?>
                        <?php foreach($allGroups as $group) : ?>
                            <div class="box-form">
                                <h3 class="form-box-title"><?php echo $group->group_name; ?></h3>
                                <div class="theme-form">
                                    <?php if(isset($allConfigurations[$group->group_id])): ?>

                                        <?php $configurations = $allConfigurations[ $group->group_id];
                                        foreach($configurations as $config) : ?>
                                            <div class="form-group">
                                                <label class="ims_form_label"><?php echo $config->config_name; ?>*</label>
                                                <?php if($config->config_field_type == 1) : ?>
                                                    <input name="configurations[<?php echo $config->config_id; ?>]" type="text" class="configurationClass ims_form_control" id="<?php echo $config->config_unique_code; ?>" value="<?php echo $config->config_value; ?>" placeholder="<?php echo $config->config_name; ?>" />
                                                <?php elseif($config->config_field_type == 2): ?>
                                                        <textarea class="configurationClass ims_form_control" name="configurations[<?php echo $config->config_id; ?>]"
                                                                  id="<?php echo $config->config_unique_code; ?>"
                                                                  value="<?php echo $config->config_value; ?>"
                                                                  placeholder="<?php echo $config->config_name; ?>"><?php echo $config->config_value; ?></textarea>
                                                <?php elseif($config->config_field_type == 3): ?>
                                                    <select class="configurationClass ims_form_control" name="configurations[<?php echo $config->config_id; ?>]" id="<?php echo $config->config_unique_code; ?>">
                                                        <option value="">Select <?php echo $config->config_name; ?> </option>
                                                        <?php
                                                        $options = explode('|', $config->config_options);
                                                        if($options) {
                                                            foreach($options as $opt) {
                                                                $keyValue = explode('-', $opt);
                                                                ?>
                                                                <option <?php echo ($keyValue[0] == $config->config_value)? 'selected':'' ?> value="<?php echo $keyValue[0]; ?>"><?php echo $keyValue[1]; ?></option>
                                                        <?php  }
                                                        }
                                                        ?>
                                                    </select>
                                                <?php elseif($config->config_field_type == 4): ?>
                                                       <?php
                                                        $options = explode('|', $config->config_options);
                                                        if($options) {
                                                            foreach($options as $opt) {
                                                                $keyValue = explode('-', $opt);
                                                                ?>
                                                                <div class="radio radio-inline">
                                                                    <input <?php echo ($keyValue[0] == $config->config_value)? 'checked':'' ?> type="radio" class="configurationClass"  id="<?php echo $opt; ?>" value="<?php echo $keyValue[0]; ?>" name="configurations[<?php echo $config->config_id; ?>]" >
                                                                    <label for="<?php echo $keyValue[0]; ?>"> <?php echo $keyValue[1]; ?> </label>
                                                                </div>

                                                            <?php  }
                                                        }
                                                        ?>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <div class="col-sm-12">
                        <div class="form-footer">
                            <input type="submit" name="Submit" id="Submit" value="<?php echo "Update"; ?>" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white">
                            <a href="<?php echo base_url('admin');?>"><input name="cancel" type="button" class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white" id="Cancel" value="Cancel"></a>
                        </div>
                    </div><!--col-sm-12-->
                    <?php endif; ?>
                </form>
            </div><!--col-sm-12-->
        </div><!--row-->
    </div><!--inner_bg-->
</div><!--content-wrapper-->
<!--=================================== Old ======================================-->
<script type="text/javascript">
    var $configurationFormValidator;
    $(document).ready(function(){
        $.validator.addClassRules("configurationClass", {
            required: true
        });
        $configurationFormValidator = $("#configurationFrom").validate({});

        /*ALL Calender Event*/
        var FromEndDate = new Date();
        /*Finacial Year start Month */
        $("#financial_year_start_month").datepicker({
            autoclose: true,
            minViewMode: 1,
            maxViewMode: 1,
            format: 'MM'
            //endDate: FromEndDate,
        });
    });
</script>


