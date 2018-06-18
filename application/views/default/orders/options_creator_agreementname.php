<?php
if(isset($agreementname) && !empty($agreementname)):
    foreach($agreementname as $option):?>

        <option value="<?php echo $option->agreement_id; ?>"><?php echo substr(($option->agreement_name),strpos($option->agreement_name, "_") + 1); ?></option>
    <?php      endforeach;
endif;
?>