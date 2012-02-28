<div class="receipts form">
<?php echo $form->create('Receipt');?>
	<fieldset>
 		<legend><?php __('Edit Receipt');?></legend>
	<?php
		echo $form->input('id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('Receipt.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Receipt.id'))); ?></li>
		<li><?php echo $html->link(__('List Receipts', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Entries', true), array('controller' => 'entries', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Entry', true), array('controller' => 'entries', 'action' => 'add')); ?> </li>
	</ul>
</div>
