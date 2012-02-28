<div class="login">
<h2>Login</h2>	
	<?php echo $form->create('User', array('action' => 'login'));?>
		<?php echo $form->input('username',array('label'=>'Usuario'));?>
		<?php echo $form->input('password',array('label'=>'Clave'));?>
		<?php echo $form->submit('Login');?>
	<?php echo $form->end(); ?>
</div>
