<div class="families form">
<?php echo $form->create('Family');?>
	<fieldset>
 		<legend><?php __('Add Family');?></legend>
	<?php
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Families', true), array('action' => 'index'));?></li>
	</ul>
</div>
