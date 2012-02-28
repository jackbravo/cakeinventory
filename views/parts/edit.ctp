<div class="parts form">
<?php
	echo $javascript->link('jquery-1.4.2.min', false); 
 	echo $javascript->link('jquery.jeditable.mini', false);
?>
<script type="text/javascript" charset="utf-8"> 
jQuery(function() {
  $(".comment").editable("/entries/edit/", { 
      indicator : "<img src='/img/indicator.gif'>",
      type   : 'textarea',
      submitdata: { _method: "put" },
      select : true,
      submit : 'Guardar',
      cancel : 'Cancelar',
      cssclass : "editable"
  });
});
</script>
<?php echo $form->create('Part');?>
	<fieldset>
 		<legend><?php __('Edit Part');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('family_id');
		echo $form->input('number');
		echo $form->input('long');
		echo $form->input('width');
		echo $form->input('height');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="comments">
	<?php foreach($entries	 as $entry): ?>
	<?php if(!strlen(trim($entry['Entry']['comments']))) { $comment = 'Sin Comentarios.'; } else { $comment = $entry['Entry']['comments']; } ?>
	<div class="comment" id="<?php echo $entry['Entry']['id']; ?>" style="display: block; clear: both; margin-bottom: 10px;"><?php echo  $comment; ?></div>
	<?php endforeach; ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('Part.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Part.id'))); ?></li>
		<li><?php echo $html->link(__('List Parts', true), array('action' => 'index'));?></li>
	</ul>
</div>
