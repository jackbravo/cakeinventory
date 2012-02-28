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
    $displayedEntries=array();
    //pr($partsByFamily);
    foreach($partsByFamily as $family)
    {
    ?>
	<h3><?php __($family[0]['Family']['name']);?></h3>
	<?php if (!empty($dispatch['Entry'])):?>
    <table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Código'); ?></th>
		<th><?php __('No. Parte'); ?></th>
		<th>
            <?php 
                if ($family[0]['Family']['name'] != 'MUV')
                {
                    __('Bobina'); 
                }
            ?>
        </th>
		<th><?php __('Largo'); ?></th>
		<th><?php __('Ancho'); ?></th>
		<th><?php __('Alto'); ?></th>
		<th><?php __('Piezas'); ?></th>
		<th><?php __('Comentarios'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($family as $part):
			
            foreach($part['Entry'] as $entry):
                if ($entry['dispatch_id'] != $dispatch['Dispatch']['id'])
                {
                    continue;
                }
                $class = null;
    			if ($i++ % 2 == 0) {
    				$class = ' class="altrow"';
    			}
		?>
            
		<tr<?php echo $class;?>>
			<?php 
				if($part['Family']['name'] == "MUV"){
					$entrada = reset($part['Entry']); 
				} else {
					$entrada = end($part['Entry']); 
				}
							
			?>
			<td><?php echo $entrada['id']; ?></td>
			<td><?php echo $part['Part']['number']; ?></td>
			<td><?php  
                foreach($part['Identifier'] as $identifier)
                {
                    if ($identifier['entry_id'] == $entry['id'])
                    {
                        echo $identifier['number'];
                        break;
                    }
                }?></td>
			<td><?php echo $part['Part']['long'];?></td>
			<td><?php echo $part['Part']['width'];?></td>
			<td><?php echo $part['Part']['height'];?></td>
            <?php
                
                    if ($entry['dispatch_id'] != $dispatch['Dispatch']['id'])
                    {
                        continue;  
                    }
                    if (array_search($entry['id'],$displayedEntries) != false)
                    {
                        continue;
                    }
                    ?>
                    <td><?php echo $entry['pieces'];?></td>
        			<td><?php echo $entry['comments'];?></td>
                    <?php
                    $displayedEntries[] = $entry['id'];
                    break;
                
            ?>
		</tr>
	<?php 
        endforeach;
    endforeach; ?>
	</table>
<?php endif; ?>
<?php
}
?>

</div>
 <div class="actions">
	<ul>
        
		<li><?php echo $html->link(__('Listado', true), array('action' => 'index')); ?> </li>
        <li><?php echo $html->link(__('Borrar Salida', true), array('action' => 'delete', $dispatch['Dispatch']['id']), null, sprintf(__('Estas seguro que quieres borrar la salida # %s?', true), $dispatch['Dispatch']['id'])); ?> </li>
        <li><a href="javascript:parent.history.back();">Regresar</a></li>
	</ul>
</div>
