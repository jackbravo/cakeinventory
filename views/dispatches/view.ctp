<div class="receipts view">
<h2>
    <?php  __('Salida #'.$dispatch['Dispatch']['id']);?>
</h2>
<h3>
    <?php  __('Fecha: '.$dispatch['Dispatch']['created']);?>
</h3>
</div>

<div class="related">
    <?php 
    foreach($partsByFamily as $family)
    {
    ?>
	<h3><?php __($family[0]['Family']);?></h3>
    <table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo 'Cod.'; ?></th>
		<th><?php echo 'No. Parte'; ?></th>
		<th><?php if ($family[0]['Family'] != 'MUV') echo 'Bobina'; ?></th>
		<th><?php echo 'Largo'; ?></th>
		<th><?php echo 'Ancho'; ?></th>
		<th><?php echo 'Alto'; ?></th>
		<th><?php echo 'Piezas'; ?></th>
		<th><?php echo 'Coment.'; ?></th>
        <th class="actions"></th>
	</tr>
	<?php
		$i = 0;
		foreach ($family as $i => $entry):
            $class = ($i%2) ? 'altrow' : '';
            $code = $entry['Part']['family_id'] == 1 ? $entry['Part']['first_code'] : $entry['Entry']['id'];
		?>
		<tr class="<?php echo $class;?>">
			<td><?php echo $code;?></td>
			<td><?php echo $entry['Part']['number']; ?></td>
			<td><?php echo $entry['Identifier']['number'];?></td>
			<td><?php echo $entry['Part']['long'];?></td>
			<td><?php echo $entry['Part']['width'];?></td>
			<td><?php echo $entry['Part']['height'];?></td>
            <td><?php echo $entry['Entry']['pieces'];?></td>
        	<td><?php echo $entry['Entry']['comments'];?></td>
            <td class="actions">
                <?php echo $html->link('Borrar', array('controller' => 'entries', 'action' => 'delete', $entry['Entry']['id'], 'from'=>'dispatches'), null, sprintf('Seguro que deseas borrar la salida del codigo # %s?', $code)); ?>
            </td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php } ?>

</div>
<div class="actions">
	<ul>
        
		<li><?php echo $html->link(__('Listado', true), array('action' => 'index')); ?> </li>
        <li><?php echo $html->link(__('Borrar Salida', true), array('action' => 'delete', $dispatch['Dispatch']['id']), null, sprintf(__('Estas seguro que quieres borrar la salida # %s?', true), $dispatch['Dispatch']['id'])); ?> </li>
        <li><a href="javascript:parent.history.back();">Regresar</a></li>
	</ul>
</div>
