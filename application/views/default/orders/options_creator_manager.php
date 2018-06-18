<!--Options creato for Salesperson Name-->

<option value=""> Manager Name*</option>
<?php
if(isset($managername)):
    foreach($managername as $option): ?>
        <option value="<?php echo $option->salesperson_id; ?>"><?php echo ucwords($option->sales_person_name); ?></option>
    <?php      endforeach;
endif;
?>