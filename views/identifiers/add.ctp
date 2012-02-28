<div class="identifiers form">
<?php echo $form->create('Identifier');?>
	<fieldset>
 		<legend><?php __('Add Identifier');?></legend>
	<?php
		echo $form->input('number');
		echo $form->input('part_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Identifiers', true), array('action' => 'index'));?></li>
	</ul>
</div>
