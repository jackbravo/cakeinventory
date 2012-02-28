<div class="entries form">
<?php echo $form->create('Entry');?>
	<fieldset>
 		<legend><?php __('Add Entry');?></legend>
	<?php
		echo $form->input('part_id');
		echo $form->input('comments');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Entries', true), array('action' => 'index'));?></li>
	</ul>
</div>
