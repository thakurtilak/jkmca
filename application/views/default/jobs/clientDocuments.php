<?php if (isset($clientDocuments) && count($clientDocuments)): ?>
    <div class="col-sm-12">
        <div class="box-form client_adress">
            <h3 class="form-box-title">Client Documents</h3>
            <div class="theme-form">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="ims_datatable table-responsive"
                             style="background: #FFFFFF;">
                            <!-- <h3 class="form-box-title">Client Details </h3>-->
                            <table id="clientList"
                                   class="table table-striped table-bordered table-condensed table-hover"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th width="40%">Document Name</th>
                                    <th>Attached File</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (count($clientDocuments)):
                                    foreach ($clientDocuments as $doc): ?>
                                        <tr>
                                            <td><?php echo ($doc->attach_type != 0) ? $doc->documentName : $doc->other_file_name; ?></td>
                                            <td><span class="ov_data"><a
                                                        href="<?php echo base_url(); ?><?php echo $doc->attach_file_path; ?>"
                                                        title="<?php echo $doc->attach_file_name; ?>"
                                                        target="_blank"><?php echo $doc->attach_file_name; ?></a></span>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                else: ?>
                                    <tr>
                                        <td colspan="2">No Document found</td>
                                    </tr>
                                <?php endif;
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>