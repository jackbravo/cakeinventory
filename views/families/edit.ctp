<div class="families form">
<?php echo $form->create('Family');?>
	<fieldset>
 		<legend><?php __('Edit Family');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('Family.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Family.id'))); ?></li>
		<li><?php echo $html->link(__('List Families', true), array('action' => 'index'));?></li>
	</ul>
</div>
