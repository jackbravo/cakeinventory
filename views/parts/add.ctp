<div class="parts form">
<?php echo $form->create('Part');?>
	<fieldset>
 		<legend><?php __('Add Part');?></legend>
	<?php
		echo $form->input('family_id');
		echo $form->input('number');
		echo $form->input('long');
		echo $form->input('width');
		echo $form->input('height');
		echo $form->input('pieces');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Parts', true), array('action' => 'index'));?></li>
	</ul>
</div>
