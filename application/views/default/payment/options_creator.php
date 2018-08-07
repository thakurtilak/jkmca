
<!--Options creator for client name-->
<?php if($laserFor == 1): ?>
<option value=""> Client Name</option>
<?php endif; ?>
<?php if($laserFor == 0): ?>
    <option value=""> Manager/Responsible Name</option>
<?php endif; ?>
<?php
if(isset($clientname)):
   foreach($clientname as $option): ?>
    <option value="<?php echo $option->client_id; ?>"><?php echo ucwords($option->clientName); ?></option>
 <?php      endforeach;
endif;
?>