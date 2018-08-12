<div class="content-wrapper">
    <!--<div class="content_header">
        <h3>Welcome to JKMCA</h3>
    </div>-->
    <?php if($this->session->flashdata('error') != '' || $this->session->flashdata('success') != '') : ?>
    <div class="inner_bg content_box">
        <div class="row">
            <?php if($this->session->flashdata('error') != '') { ?>
                <div class="alert alert-danger" style="margin-top:18px;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php } ?>
            <?php if($this->session->flashdata('success') != '') { ?>
                <div class="alert alert-success" style="margin-top:18px;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php endif; ?>
    <?php if(isset($approvePendingJobs)): ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="dash_box_block fadeInLeft animated">
                    <div class="dash_box_header">
                        <div class="row">
                            <div class="col-sm-8">
                                <h3 class="dash_box_header-title">Pending Jobs for Approval</h3>
                            </div>
                            <div class="more_result text-right">
                                <a href="<?php echo base_url(); ?>jobs" class="mdl-js-button mdl-js-ripple-effect btn-view action-btn" data-upgraded=",MaterialButton,MaterialRipple">View all<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></a>
                            </div>
                        </div>
                    </div><!--dash_box_header-->
                    <div class="dash_box_body">
                        <div class="table-theme table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Job ID</th>
                                    <th>Client Name</th>
                                    <th>Work Type</th>
                                    <th>Assign To</th>
                                    <th>Complete Date</th>
                                    <th>View</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(count($approvePendingJobs)):
                                    foreach($approvePendingJobs as $item):
                                        $actionLink = "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href='".base_url()."jobs/view-job/".$item->id."' data-target-id=" . $item->id . " title='View Details'><i class='icon-generate_invoice'></i></a>";
                                        $clientName = $item->clientName;
                                        $clientName = "<a href=\"#ClientViewModal\" data-toggle=\"modal\" data-target-id=" . $item->client_id . ">" . $clientName . "</a>";

                                        ?>
                                        <tr>
                                            <td><?php echo $item->job_number; ?></td>
                                            <td><?php echo $clientName; ?></td>
                                            <td><?php echo $item->work; ?></td>
                                            <td><?php echo $item->staff_name; ?></td>
                                            <td><?php echo date('d-M-Y', strtotime($item->complete_date)); ?></td>
                                            <td><?php echo $actionLink; ?></td>
                                        </tr>
                                    <?php endforeach; else: ?>
                                    <tr>
                                        <td colspan="7">No pending Jobs</td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div><!--dash_box_body-->
                </div><!--dash_box_block-->
            </div><!--col-sm-12-->
        </div>
    <?php endif; ?>

    <?php if(isset($paymentPendingJobs)): ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="dash_box_block fadeInRight animated">
                    <div class="dash_box_header">
                        <div class="row">
                            <div class="col-sm-8">
                                <h3 class="dash_box_header-title">Pending Payment</h3>
                            </div>
                            <div class="more_result text-right">
                                <a href="<?php echo base_url(); ?>jobs" class="mdl-js-button mdl-js-ripple-effect btn-view action-btn" data-upgraded=",MaterialButton,MaterialRipple">View all<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></a>
                                <a href="javascript:void(0)" style="font-size: 25px;" class="mdl-js-button mdl-js-ripple-effect btn-view action-btn" id="exportPaymentLaser" title="Export All In Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div><!--dash_box_header-->
                    <div class="dash_box_body">
                        <div class="table-theme table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Job ID</th>
                                    <th>Client Name</th>
                                    <th>Work Type</th>
                                    <th>Total Amount</th>
                                    <th>Remaining Amount</th>
                                    <th>View</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(count($paymentPendingJobs)):
                                    foreach($paymentPendingJobs as $item):
                                        $actionLink = "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href='".base_url()."jobs/view-job/".$item->id."' data-target-id=" . $item->id . " title='View Details'><i class='icon-generate_invoice'></i></a>";
                                        $clientName = $item->clientName;
                                        $clientName = "<a href=\"#ClientViewModal\" data-toggle=\"modal\" data-target-id=" . $item->client_id . ">" . $clientName . "</a>";
                                        ?>
                                        <tr>
                                            <td><?php echo $item->job_number; ?></td>
                                            <td><?php echo $clientName; ?></td>
                                            <td><?php echo $item->work; ?></td>
                                            <td><?php echo formatAmount($item->amount); ?></td>
                                            <td><?php echo formatAmount($item->remaining_amount); ?></td>
                                            <td><?php echo $actionLink; ?></td>
                                        </tr>
                                    <?php endforeach; else: ?>
                                    <tr>
                                        <td colspan="7">No Pending Payment</td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div><!--dash_box_body-->
                </div><!--dash_box_block-->
            </div><!--col-sm-12-->
        </div>
    <?php endif; ?>

    <?php if(isset($pendingJobs)): ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="dash_box_block fadeInLeft animated">
                    <div class="dash_box_header">
                        <div class="row">
                            <div class="col-sm-8">
                                <h3 class="dash_box_header-title">Pending Jobs</h3>
                            </div>
                            <div class="more_result text-right">
                                <a href="<?php echo base_url(); ?>jobs" class="mdl-js-button mdl-js-ripple-effect btn-view action-btn" data-upgraded=",MaterialButton,MaterialRipple">View all<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></a>
                            </div>
                        </div>
                    </div><!--dash_box_header-->
                    <div class="dash_box_body">
                        <div class="table-theme table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Job ID</th>
                                    <th>Client Name</th>
                                    <th>Work Type</th>
                                    <th>Assign To</th>
                                    <th>Created Date</th>
                                    <th>View</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(count($pendingJobs)):
                                    foreach($pendingJobs as $item):
                                        $actionLink = "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" href='".base_url()."jobs/view-job/".$item->id."' data-target-id=" . $item->id . " title='View Details'><i class='icon-generate_invoice'></i></a>";
                                        $clientName = $item->clientName;
                                        $clientName = "<a href=\"#ClientViewModal\" data-toggle=\"modal\" data-target-id=" . $item->client_id . ">" . $clientName . "</a>";

                                        ?>
                                        <tr>
                                            <td><?php echo $item->job_number; ?></td>
                                            <td><?php echo $clientName; ?></td>
                                            <td><?php echo $item->work; ?></td>
                                            <td><?php echo $item->staff_name; ?></td>
                                            <td><?php echo date('d-M-Y', strtotime($item->created_date)); ?></td>
                                            <td><?php echo $actionLink; ?></td>
                                        </tr>
                                    <?php endforeach; else: ?>
                                    <tr>
                                        <td colspan="7">No Pending Jobs</td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div><!--dash_box_body-->
                </div><!--dash_box_block-->
            </div><!--col-sm-12-->
        </div>
    <?php endif; ?>
</div>
<!-- View client Modal-->
<div id="ClientViewModal" class="modal">
    <div class="modal-dialog modal-lg zoomIn animated">
        <div class="modal-content">
            <div class="modal-header ims_modal_header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Client Information</h4>
            </div>
            <div class="modal-body view-details custom_client_scroll">
            </div>
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        /*Client View Model Window*/
        $("#ClientViewModal").on("show.bs.modal", function(e) {
            var modal = $(this);
            modal.find('.view-details').html("");
            var id = $(e.relatedTarget).data('target-id');
            var viewUrl = BASEURL + "clients/view-client/"+id;
            $.ajax({
                type: "GET",
                url: viewUrl,
                cache: false,
                success: function (data) {
                    modal.find('.view-details').html(data);
                    $(".custom_client_scroll").mCustomScrollbar();
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

        $("#ClientViewModal").on("hide.bs.modal", function() {
            $(".custom_client_scroll").mCustomScrollbar("destroy");
        });

        $("#exportPaymentLaser").click(function () {
            $url = BASEURL +"payment/download-excel-pending-all";
            window.location = $url;
        });
    })
</script>