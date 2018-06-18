<div class="content-wrapper">
	<div class="row">
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
	</div>
    <?php
    if(isset($pendingInvocies)){
        echo $pendingInvocies;
    }
    ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="dash_box_block fadeInLeft animated">
                <div class="dash_box_header">
                    <div class="row">
                        <div class="col-sm-8">
                            <h3 class="dash_box_header-title">Pending Collections</h3>
                        </div>
                        <div class="col-sm-4 text-right">
                            <h4 class="dash_box_header_date">Dec 2017 <img src="<?php echo base_url(); ?>assets/images/calendar_icon-dash.svg" width="21"></h4>
                        </div>
                    </div>
                </div><!--dash_box_header-->
                <div class="dash_box_body">
                    <div class="table-theme table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Client Name </th>
                                <th>Invoice No.</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Ad Chakra Networks</td>
                                <td>015245/ACN/2017-18</td>
                                <td><a href="#" class="mdl-js-button mdl-js-ripple-effect btn-view action-btn" data-upgraded=",MaterialButton,MaterialRipple">View<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></a></td>
                            </tr>
                            <tr>
                                <td>Ad Federal</td>
                                <td>0152675/ACN/2017-18</td>
                                <td><a href="#" class="mdl-js-button mdl-js-ripple-effect btn-view action-btn" data-upgraded=",MaterialButton,MaterialRipple">View<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></a></td>
                            </tr>
                            <tr>
                                <td>Alpha CRC Ltd</td>
                                <td>012456/ACN/2017-18</td>
                                <td><a href="#" class="mdl-js-button mdl-js-ripple-effect btn-view action-btn" data-upgraded=",MaterialButton,MaterialRipple">View<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></a></td>
                            </tr>
                            <tr>
                                <td>PCF</td>
                                <td>015245/ACN/2017-18</td>
                                <td><a href="#" class="mdl-js-button mdl-js-ripple-effect btn-view action-btn" data-upgraded=",MaterialButton,MaterialRipple">View<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div><!--dash_box_body-->
            </div><!--dash_box_block-->
        </div><!--col-sm-6-->
        <div class="col-sm-12">
            <div class="dash_box_block fadeInRight animated">
                <div class="dash_box_header">
                    <div class="row">
                        <div class="col-sm-8">
                            <h3 class="dash_box_header-title">Assigned Projects with Total Invoice</h3>
                        </div>
                        <div class="col-sm-4 text-right">
                            <h4 class="dash_box_header_date">Dec 2017 <img src="<?php echo base_url(); ?>assets/images/calendar_icon-dash.svg" width="21"></h4>
                        </div>
                    </div>
                </div><!--dash_box_header-->
                <div class="dash_box_body">
                    <div class="table-theme table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Client Name </th>
                                <th>Total Amount</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Ad Chakra Networks</td>
                                <td>Rs. 6,0000,00</td>
                                <td><a href="#" class="mdl-js-button mdl-js-ripple-effect btn-done action-btn" data-upgraded=",MaterialButton,MaterialRipple">Done<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></a></td>
                            </tr>
                            <tr>
                                <td>Ad Federal</td>
                                <td>Rs. 9,0000.00</td>
                                <td><a href="#" class="mdl-js-button mdl-js-ripple-effect btn-pending action-btn" data-upgraded=",MaterialButton,MaterialRipple">Pending<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></a></td>
                            </tr>
                            <tr>
                                <td>Alpha CRC Ltd</td>
                                <td>Rs. 6,0000,00</td>
                                <td><a href="#" class="mdl-js-button mdl-js-ripple-effect btn-done action-btn" data-upgraded=",MaterialButton,MaterialRipple">Done<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></a></td>
                            </tr>
                            <tr>
                                <td>PCF</td>
                                <td>Rs. 12,0000.00</td>
                                <td><a href="#" class="mdl-js-button mdl-js-ripple-effect btn-pending action-btn" data-upgraded=",MaterialButton,MaterialRipple">Pending<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div><!--dash_box_body-->
            </div><!--dash_box_block-->
        </div><!--col-sm-6-->
    </div><!--row-->
</div><!--content-wrapper-->