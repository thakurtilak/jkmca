<!--Options creator for AccountPerson Name-->

<option value=""> Account Person Name</option>
<?php
if(isset($accountpersonname)):
    foreach($accountpersonname as $option): ?>
        <option value="<?php echo $option->account_id; ?>"><?php echo ucwords($option->account_person_name); ?></option>
    <?php      endforeach;
endif;
?>