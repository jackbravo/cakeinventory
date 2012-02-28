<div class="receipts view">
<h2>
    <?php  __('Entrada #'.$receipt['Receipt']['id']);?>
</h2>
<h3>
    <?php  __('Fecha: '.$receipt['Receipt']['created']);?>
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
		<th><?php __('Cod.'); ?></th>
		<th><?php __('No. Parte'); ?></th>
		<th><?php if ($family[0]['Family'] != 'MUV') __('Bobina'); ?></th>
		<th><?php __('Largo'); ?></th>
		<th><?php __('Ancho'); ?></th>
		<th><?php __('Alto'); ?></th>
		<th><?php __('Piezas'); ?></th>
		<th><?php __('Coment.'); ?></th>
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
			<td><?php echo $entry['Identifier']['number']; ?></td>
			<td><?php echo $entry['Part']['long'];?></td>
			<td><?php echo $entry['Part']['width'];?></td>
			<td><?php echo $entry['Part']['height'];?></td>
            <td><?php echo $entry['Entry']['pieces'];?></td>
            <td><?php echo $entry['Entry']['comments'];?></td>
            <td class="actions">
                <?php echo $html->link('Borrar', array('controller' => 'entries', 'action' => 'delete', $entry['Entry']['id'], 'from'=>'receipts'), null, sprintf('Seguro que deseas borrar el codigo # %s?', $code)); ?>
            </td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php } ?>

</div>
 <div class="actions">
	<ul>
		<li><?php echo $html->link(__('Listado', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Imprimir Etiquetas', true), array('action' => 'barcode', $receipt['Receipt']['id'])); ?> </li>
        <li><?php echo $html->link(__('Borrar Entrada', true), array('action' => 'delete', $receipt['Receipt']['id']), null, sprintf(__('Estas seguro que quieres borrar la entrada # %s?', true), $receipt['Receipt']['id'])); ?> </li>
	</ul>
</div>
