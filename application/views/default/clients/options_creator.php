
<!--Options creator for client name-->
<option value=""> Client Name*</option>
<?php
if(isset($clientname)):
   foreach($clientname as $option): ?>
    <option value="<?php echo $option->client_id; ?>"><?php echo ucwords($option->client_name); ?></option>
 <?php      endforeach;
endif;
?>