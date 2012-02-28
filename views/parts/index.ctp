<div class="parts index">

<h2><?php __('Inventario');?></h2>

<ul class="filters">
    <li><a href="/parts/">Todo</a></li>
    <?php
        foreach($families as $id => $name)
        {
            echo "<li><a href='/parts/index/family:$id'>$name</a></li>";
        }
    ?>
</ul>

<table cellpadding="0" cellspacing="0" class="tablesorter">
<thead>
<tr>
	<th>Codigo</th>
	<th>Familia</th>
	<th>No Parte</th>
    <th>Bobinas</th>
    <th>Largo</th>
    <th>Ancho</th>
    <th>Alto</th>
    <th>Piezas</th>
	<th>Ingreso</th>
	<th>Documento</th>
	<th>Comentarios</th>			    
</tr>
</thead>
<tbody>
<?php
$i = 0;
$totalPieces = 0;
$first_entry_id = 0;
$first_part_num = 0;
$first_receipt = 0;
$first_comment = 0;
foreach ($entries as $idx => $entry) {
    $family = $families[$entry['Part']['family_id']];
    $entry['Part']['Family'] = $family;
    if ($family == 'MUV')
    {
        $prev_part = array_key_exists($idx-1, $entries) ? $entries[$idx-1]['Part']['id'] : 0;
        $next_part = array_key_exists($idx+1, $entries) ? $entries[$idx+1]['Part']['id'] : 0;
        // SI NO HAY DISPATCH ID, QUIERE DECIR QUE ES UNA SALIDA
        if ($entry['Entry']['dispatch_id'] != null)
        {
            $totalPieces -= $entry['Entry']['pieces'];
        }
        // SI HAY RECEIPT ID, QUIERE DECIR QUE ES UNA ENTRADA
        if ($entry['Entry']['receipt_id'] != null)
        {
            $totalPieces += $entry['Entry']['pieces'];
        }

        // Si esta es la primer entrada de un número de parte
        if ($prev_part != $entry['Part']['id'])
        {
            $first_receipt = $entry['Entry']['receipt_id'];
            $first_comment = $entry['Entry']['comments'];
        }
        // Si esta es la última entrada de un número de parte
        if ($next_part != $entry['Part']['id'])
        {
            $class = ($i++%2) ? 'altrow' : '';
            // conservar el primer código, comentario y receipt_id
            $entry['Entry']['receipt_id'] = $first_receipt;
            $entry['Entry']['comments'] = $first_comment;
            print_part_row($html, $class, $entry, $totalPieces);
            $totalPieces = 0;
        }
    }
    else
    {
        $class = ($i++%2) ? 'altrow' : '';
        print_part_row($html, $class, $entry);
    }
}
?>
</tbody>
</table>
</div>

<div class="actions">

	<ul>
		<li>
            <?php 
            if (isset($family_id))
            {
                echo $html->link(__('Exportar a .XLS', true), array('action' => 'export',$family_id)); 
            }
            else
            {
                echo $html->link(__('Exportar a .XLS', true), array('action' => 'export'));
            }
            ?>
        </li>
	</ul>
</div>

<?php function print_part_row($html, $class, $entry, $totalPieces=null) { ?>
    <tr class="<?php echo $class;?>">
        <td><?php echo $entry['Part']['family_id'] == 1 ? $entry['Part']['first_code'] : $entry['Entry']['id'];?></td>
        <td><?php echo $entry['Part']['Family']; ?></td>
        <td class="part-num"><?php echo $entry['Part']['number']; ?></td>
        <td class="bobina"><?php echo $entry['Identifier']['number']; ?></td>
        <td><?php echo $entry['Part']['long']; ?></td>
        <td><?php echo $entry['Part']['width']; ?></td>
        <td><?php echo $entry['Part']['height']; ?></td>
        <td><?php echo ($totalPieces === null) ? $entry['Entry']['pieces'] : $totalPieces; ?></td>
        <td><?php echo $entry['Entry']['created']; ?></td> 
        <td><?php echo $html->link($entry['Entry']['receipt_id'], array('controller'=>'receipts', 'action'=>'view', $entry['Entry']['receipt_id'])); ?></td> 
        <td class="comment-box" style="width: auto;">
            <?php
                if(!trim($entry['Entry']['comments']))
                    $comment = "---";
                else
                    $comment = str_replace("\n", "<br>", $entry['Entry']['comments']);
            ?>
            <span class="comment" id="<?php echo $entry['Entry']['id']; ?>"><?php echo  $comment; ?></span>
            <?php echo $html->image('Edit_32.png', array("width"=>"18"));?>
        </td>     		    		   		
    </tr>
<?php } ?>
