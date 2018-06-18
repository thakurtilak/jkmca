<div class="content-wrapper">
    <div class="content_header">
        <h3>System Dashboard</h3>
    </div>
    <div class="container-fluid">
        <?php if($this->session->flashdata('error') != '') { ?>
            <div class="alert alert-danger" style="margin-top:18px;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php } ?>
        <?php if($this->session->flashdata('success') != '') { ?>
        <div class="alert alert-info" style="margin-top:18px;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            <?php echo $this->session->flashdata('success'); ?>
        </div>
        <?php } ?>

    </div>
</div>
<style>
    .top-heading {
        border-bottom: 2px solid gray;
    }
</style>