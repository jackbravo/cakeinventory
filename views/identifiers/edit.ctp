<div class="identifiers form">
<?php echo $form->create('Identifier');?>
	<fieldset>
 		<legend><?php __('Edit Identifier');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('number');
		echo $form->input('part_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('Identifier.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Identifier.id'))); ?></li>
		<li><?php echo $html->link(__('List Identifiers', true), array('action' => 'index'));?></li>
	</ul>
</div>
