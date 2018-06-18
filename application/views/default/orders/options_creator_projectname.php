<!--Options Creator for project name-->
<option value=""> Project Name*</option>
<?php
if(isset($projectname)):
    foreach($projectname as $option): ?>
        <option value="<?php echo $option->order_id; ?>"><?php echo ucwords($option->project_name); ?></option>
    <?php      endforeach;
endif;
?>