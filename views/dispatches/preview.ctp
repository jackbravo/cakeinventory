<div class="dispatches form">
<?php 
if (!isset($entries))
{
    // PANTALLA #5
    ?>
    
        <form method="post" action="/dispatches/preview">
    	<fieldset>
     		<legend><?php __('Crear Salida');?></legend>
            <label for="data[codes]">C&oacute;digos de Salida</label>
            <textarea name="data[codes]"></textarea>
    	</fieldset>
        <div class="submit"><input type="submit" value="Siguiente >" /></div>
        </form> 
        
   
    <?php
} 
else 
{
    // PANTALLA #5.1
    ?>
    <form id="preview" method="post" action="/dispatches/add">
        <script type="text/javascript">
            $(document).ready(function(){
                $("input.pieces").change(function(){
                    var pieces = this.value;
                    var totalPiecesId = "#TotalPieces-" + this.id.split("-")[1];
                    var totalPieces = parseInt($(totalPiecesId).html());
                    if (pieces > totalPieces) {
                        alert("No puedes sacar " + pieces + " piezas, solo hay " + totalPieces);
                        this.value = '';
                        $(this).focus();
                    }
                });
            });
        </script>
    	<fieldset>
     		<legend>Crear Salida -  Familia MUV</legend>
            <table>
                <tr>
                    <th>C&oacute;digo</th>
                    <th>Parte No.</th>
                    <th>Cantidad</th>
                    <th>Piezas totales</th>
                </tr>
                
                <?php
                $i = 0;
                foreach($entries as $entry)
                {
                    if (!isset($entry['Part']['totalPieces']))
                    {
                        continue;
                    }
                    $class = null;
                	if ($i++ % 2 == 0) {
                		$class = ' class="altrow"';
                	}
                    echo "<tr$class>";
                        echo "<td>{$entry['Entry']['id']}</td>";
                        echo "<td>{$entry['Part']['number']}</td>";
                        echo "<td>";
                            if ($entry['Part']['totalPieces'] > 0) {
                                echo "<input class='pieces' type='text' name='data[Entry][pieces][]' id='EntryPieces-{$entry['Part']['id']}' />";
                            } else {
                                echo "<input class='pieces' type='hidden' value='' name='data[Entry][pieces][]' id='EntryPieces-{$entry['Part']['id']}' />";
                                echo "No hay inventario";
                            }
                            echo "<input type='hidden' name='data[Entry][id][]' value='{$entry['Entry']['id']}' />";
                        echo "</td>";
                        echo "<td id='TotalPieces-{$entry['Part']['id']}'>{$entry['Part']['totalPieces']}</td>";
                    echo "</tr>";
                }
                ?>
            </table>
    	</fieldset>
        <div class="submit"><input type="submit" value="Siguiente >" /></div>
        </form> 
    <?php
}
?>
 </div>
