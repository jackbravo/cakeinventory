<?php 
$this->layout = null;

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition: attachment;filename=Inventario".date("d/m/Y").".xls");
header("Content-Transfer-Encoding: binary");


?>

<table>
	<tr>
		<th>Codigo</th>
		<th>Familia</th>
		<th>No de Parte</th>
		<th>Bobina</th>
		<th>Largo</th>
		<th>Ancho</th>
		<th>Alto</th>
		<th>Piezas</th>
		<th>Fecha de Ingreso</th>
		<th>Documento</th>
		<th>Comentarios</th>
	</tr>
	<?php
$i = 0;
$totalPieces = 0;
$first_entry_id = 0;
$fisrt_part_num = 0;
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
            $first_entry_id = $entry['Entry']['id'];
            $first_part_num = $entry['Part']['number'];
        }
        // Si esta es la última entrada de un número de parte
        if ($next_part != $entry['Part']['id'])
        {
            $class = ($i++%2) ? 'altrow' : '';
            $entry['Entry']['id'] = $first_entry_id; // conservar el primer código
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
</table>

<?php function print_part_row($html, $class, $entry, $totalPieces=null) { ?>
    <tr class="<?php echo $class;?>">
        <td><?php echo $entry['Entry']['id']; ?></td>
        <td><?php echo $entry['Part']['Family']; ?></td>
        <td><?php echo $entry['Part']['number']; ?></td>
        <td><?php echo $entry['Identifier']['number']; ?></td>
        <td><?php echo $entry['Part']['long']; ?></td>
        <td><?php echo $entry['Part']['width']; ?></td>
        <td><?php echo $entry['Part']['height']; ?></td>
        <td><?php echo ($totalPieces === null) ? $entry['Entry']['pieces'] : $totalPieces; ?></td>
        <td><?php echo $entry['Entry']['created']; ?></td> 
        <td><?php echo $html->link($entry['Entry']['receipt_id'], array('controller'=>'receipts', 'action'=>'view', $entry['Entry']['receipt_id'])); ?></td> 
        <td><?php echo trim($entry['Entry']['comments']); ?></td>
    </tr>
<?php } ?>
