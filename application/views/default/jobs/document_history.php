<?php if(count($documents)): ?>
    <div class="ims_datatable table-responsive" style="background: #FFFFFF;">
        <!-- <h3 class="form-box-title">Client Details </h3>-->
        <table id="clientDocList" class="table table-striped table-bordered table-condensed table-hover" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Document</th>
                <th>Document Name</th>
            </tr>
            </thead>
            <tbody>
            <?php  foreach ($documents as $doc): ?>
                <tr>
                    <td><?php echo ($doc->attach_type != 0) ? $doc->documentName : $doc->other_file_name; ?></td>
                    <td><span class="ov_data"><a href="<?php echo base_url();?><?php echo $doc->attach_file_path; ?>" title="<?php echo $doc->attach_file_name; ?>" target="_blank"><?php echo $doc->attach_file_name; ?></a></span></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div><!--ims_datatab-->
<?php else: ?>
    <div class="col-sm-4">No Record Founds</div>
<?php endif; ?>
