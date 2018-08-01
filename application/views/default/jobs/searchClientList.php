<?php if(count($clientList)): ?>
    <div class="ims_datatable table-responsive" style="background: #FFFFFF;">
        <!-- <h3 class="form-box-title">Client Details </h3>-->
        <table id="clientList" class="table table-striped table-bordered table-condensed table-hover" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Choose</th>
                <th>Client Code</th>
                <th width="15%">Name</th>
                <th>Firm Name</th>
                <th>Father Name</th>
                <th>PAN</th>
                <th>Aadhar NO.</th>
                <th>Mobile NO.</th>
            </tr>
            </thead>
            <tbody>
            <?php  foreach ($clientList as $client): ?>
                <tr class="item">
                    <td>
                        <div class="radio radio-inline">
                            <input type="radio" id="client_<?php echo $client->client_id;?>" name="client" value="<?php echo $client->client_id;?>">
                            <label for="client_<?php echo $client->client_id;?>"></label>
                        </div>
                    </td>
                    <td><?php echo $client->client_id; ?></td>
                    <td><?php echo $client->first_name.' '.$client->last_name; ?></td>
                    <td><?php echo $client->firm_name; ?></td>
                    <td><?php echo $client->father_first_name.' '.$client->father_last_name; ?></td>
                    <td><?php echo ($client->pan_no)? $client->pan_no :'--'; ?></td>
                    <td><?php echo ($client->aadhar_number) ? $client->aadhar_number :'--' ; ?></td>
                    <td><?php echo ($client->mobile)? $client->mobile : '--'; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div><!--ims_datatab-->
<?php else: ?>
    <div class="col-sm-4">No Record Founds</div>
<?php endif; ?>
<style>
    tr.selected{
        background: #e8b31d !important;
    }
</style>
<script>
    $(document).ready(function () {

    $("input[name='client']").click(function () {
        var clientId = $("input[name='client']:checked").val();
        $("#client_code").val(clientId);
        if(clientId){
            $("tr.item").removeClass("selected")
            $(this).parent().parent().parent().addClass("selected");
            $.ajax({
                type: "POST",
                url: BASEURL+"jobs/getClientDetails",
                data: {clientId:clientId},
                beforeSend: function() {
                    // setting a timeout
                    $(".loader-wrapper").show();
                },
                success: function (data) {
                    populateClientDetails(data);
                },
                error: function (error) {
                    $(".loader-wrapper").hide();
                    alert("There is an error while getting clients. Please try again.");
                },
                complete: function() {
                    $(".loader-wrapper").hide();
                }
            });
        }
    });
    })
</script>
