<div class="entries form">
<?php echo $form->create('Entry');?>
	<fieldset>
 		<legend><?php __('Edit Entry');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('part_id');
		echo $form->input('comments');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('Entry.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Entry.id'))); ?></li>
		<li><?php echo $html->link(__('List Entries', true), array('action' => 'index'));?></li>
	</ul>
</div>
