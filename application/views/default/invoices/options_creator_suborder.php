<!--Options creator for suborder-->

<option value="">Select Suborder</option>
<?php
if(isset($suborderinfo)):
    foreach($suborderinfo as $option): ?>
        <option value="<?php echo $option->order_id; ?>"><?php echo ucwords($option->project_name); ?></option>
    <?php      endforeach;
endif;
?>