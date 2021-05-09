<?php 

if(Session::is_set('login-error')):

?>

<div class="alert alert-danger">
	<?php echo Session::get('login-error'); Session::unset('login-error'); ?>
</div>


<?php endif;

if(Session::is_set('register-error')):

?>

<div class="alert alert-danger">
	<?php echo Session::get('register-error'); Session::unset('register-error'); ?>
</div>


<?php endif; ?>