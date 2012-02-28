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
    foreach($families as $family_id => $family) {
        if (!array_key_exists($family_id, $partsByFamily)) continue;
?>
	<h3><?php echo $family ?></h3>

    <table cellpadding = "0" cellspacing = "0">
	<tr>
		<th>C&oacute;digo</th>
		<th>No. Parte</th>
		<th><?php if ($family != 'MUV') { echo 'Bobina'; } ?></th>
		<th>Largo</th>
		<th>Ancho</th>
		<th>Alto</th>
		<th>Piezas</th>
		<th>Comentarios</th>
	</tr>
	<?php
		$i = 0;
        foreach($partsByFamily[$family_id] as $entry) {
            $class = ($i++%2)? 'altrow' : '';
		?>
		<tr class="<?php echo $class;?>">
            <?php
                if (!is_array($entry)) {
                    echo "<td colspan='8'>$entry</td>";
                    continue;
                }
            ?>
			<td><?php echo $entry['Entry']['id'];?></td>
			<td><?php echo $entry['Part']['number']; ?></td>
			<td><?php echo $entry['Identifier']['number'];?></td>
			<td><?php echo $entry['Part']['long'];?></td>
			<td><?php echo $entry['Part']['width'];?></td>
			<td><?php echo $entry['Part']['height'];?></td>
            <td><?php echo $entry['Entry']['pieces'];?></td>
        	<td><?php echo $entry['Entry']['comments'];?></td>
		</tr>
	<?php } ?>
	</table>
<?php } ?>

</div>
 <div class="actions">
	<ul>
        <li><?php echo $html->link(__('Guardar', true), array('action' => 'add','validate')); ?> </li>
		<li><?php echo $html->link(__('Listado', true), array('action' => 'index')); ?> </li>
        <li><?php echo $html->link(__('Borrar Salida', true), array('action' => 'index')); ?> </li>
        <li><a href="javascript:parent.history.back();">Regresar</a></li>
	</ul>
</div>
