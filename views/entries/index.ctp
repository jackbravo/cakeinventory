<?php
	$javascript->link('datepicker', false);
	$html->css('datepicker', 'stylesheet', array('media'=>'all' ), false);
?>

<div class="entries index">
<h2><?php __('Remisiones de Entrada');?></h2>

<form>
	
	<h3>Filtrar por fecha</h3>
		<div class="datepicker-wrap">
			<table class="split-date-wrap" cellpadding="0" cellspacing="0" border="0">
	
	        <tbody>
	          <tr>
	          	<td>De:</td>
	            <td><input type="text" class="w2em" id="date-1-dd" name="date-1-dd" value="" maxlength="2" /> /<label for="date-1-dd">DD</label></td>
	            <td><input type="text" class="w2em" id="date-1-mm" name="date-1-mm" value="" maxlength="2" /> /<label for="date-1-mm">MM</label></td>
	            <td class="lastTD"><input type="text" class="w4em" id="date-1" name="date-1" value="" maxlength="4" /><label for="date-1">AAAA</label></td>
	          </tr>
	
	        </tbody>
	      </table> 
	      <script type="text/javascript">
	      // <![CDATA[  
	        var opts = {                            
	                formElements:{"date-1":"Y","date-1-mm":"m","date-1-dd":"d"},
	                showWeeks:true,
	                statusFormat:"l-cc-sp-d-sp-F-sp-Y", 
	                noFadeEffect:true,
	                };           
	        datePickerController.createDatePicker(opts);
	      // ]]>
	      </script> 
 		</div>
	  	<div class="datepicker-wrap">
		  <table class="split-date-wrap" cellpadding="0" cellspacing="0" border="0">
	
	        <tbody>
	          <tr>
	          	<td>Hasta:</td>
	            <td><input type="text" class="w2em" id="date-2-dd" name="date-2-dd" value="" maxlength="2" /> /<label for="date-1-dd">DD</label></td>
	            <td><input type="text" class="w2em" id="date-2-mm" name="date-2-mm" value="" maxlength="2" /> /<label for="date-1-mm">MM</label></td>
	            <td class="lastTD"><input type="text" class="w4em" id="date-2" name="date-2" value="" maxlength="4" /><label for="date-1">AAAA</label></td>
	          </tr>
	
	        </tbody>
	      </table> 
	      <script type="text/javascript">
	      // <![CDATA[  
	        var opts = {                            
	                formElements:{"date-2":"Y","date-2-mm":"m","date-2-dd":"d"},
	                showWeeks:true,
	                statusFormat:"l-cc-sp-d-sp-F-sp-Y", 
	                noFadeEffect:true,
	                };           
	        datePickerController.createDatePicker(opts);
	      // ]]>
	      </script> 		
		</div>
		
		<div class="datepicker-wrap">
			<input type="submit" value="Aplicar Filtro" style="clear:none;" />
			
			<?php echo $html->link('Quitar Filtro', array('action'=>'index')); ?>
		</div>
</form>

<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('part_id');?></th>
	<th><?php echo $paginator->sort('pieces');?></th>
	<th><?php echo $paginator->sort('comments');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($entries as $entry):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $entry['Entry']['id']; ?>
		</td>
		<td>
			<?php echo $entry['Entry']['part_id']; ?>
		</td>
		<td>
			<?php echo $entry['Entry']['pieces']; ?>
		</td>
		<td>
			<?php echo $entry['Entry']['comments']; ?>
		</td>
		<td>
			<?php echo $entry['Entry']['created']; ?>
		</td>
		<td>
			<?php echo $entry['Entry']['modified']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $entry['Entry']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $entry['Entry']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $entry['Entry']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $entry['Entry']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
