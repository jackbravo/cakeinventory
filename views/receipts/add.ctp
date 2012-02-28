<?php
    $javascript->link('basicAjax', false);
?>
<script>

    var Rows = 1;

    function addEntryReceipt()
    {
        var entriesTable = document.getElementById('entriesTable');
        var entriesRows = entriesTable.getElementsByTagName('TR');
        var lastRow = entriesRows[entriesRows.length-1];
        var newRow = lastRow.cloneNode(true);
        newRow.id = "entry"+(++Rows);
        var inputs = newRow.getElementsByTagName('INPUT');
        for (var index = 0; index<inputs.length; index++)
        {
            inputs[index].value = "";
        }
        var selects = newRow.getElementsByTagName('SELECT');
        var lastSelects = lastRow.getElementsByTagName('SELECT');
        for (var index = 0; index<selects.length; index++)
        {
            if (selects[index].name == 'data[Receipt][Family]')
            {
                selects[index].selectedIndex = lastSelects[index].selectedIndex;
            }
        }
        entriesTable.appendChild(newRow);
    }
    
    function removeEntryReceipt(e)
    {
        var rows = e.parentNode.parentNode.parentNode.parentNode.getElementsByTagName('TR');
        if (rows.length > 2)
        {
            e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
        }
    }
    
    var waitingSelectParts;
    var waitingSelectPartsParent;
    
    function changeFamily(e)
    {
        
        
        var selectParts;
        var entryRow = e.parentNode;
        do
        {
            entryRow = entryRow.parentNode;
        }
        while(entryRow.tagName != 'TR');
        
        if(e.getElementsByTagName('OPTION')[e.selectedIndex].innerHTML == 'MUV')
        {
            entryRow.getElementsByTagName('TD')[2].getElementsByTagName('INPUT')[0].readOnly = true;
            entryRow.getElementsByTagName('TD')[2].getElementsByTagName('INPUT')[0].className = 'readOnly';
            
        }
        else
        {
            entryRow.getElementsByTagName('TD')[2].getElementsByTagName('INPUT')[0].readOnly = false;
            entryRow.getElementsByTagName('TD')[2].getElementsByTagName('INPUT')[0].className = '';
        }
        
        selectParts = entryRow.getElementsByTagName('TD')[1].getElementsByTagName('SELECT')[0];
        selectParts.disabled = true;
        waitingSelectParts = selectParts;
        waitingSelectPartsParent = selectParts.parentNode;
        
        basicAjax('/parts/ajax/family:'+e.value,waitingSelectParts.parentNode,enableSelectParts);
    }    
    
    function enableSelectParts()
    {
        waitingSelectPartsParent.getElementsByTagName('SELECT')[0].onchange();
    }

    var longInput,widthInput,heightInput;
    
    function changePart(el)
    {
        if (el.getElementsByTagName('OPTION')[el.selectedIndex].value == 'new')
        {
            var nextInput = el.nextSibling;;
            
            while (nextInput.tagName != 'INPUT')
            {
                nextInput = nextInput.nextSibling;
            }
            nextInput.style.display = 'inline-block';
        }
        else
        {
            var nextInput = el.nextSibling;;
            
            while (nextInput.tagName != 'INPUT')
            {
                nextInput = nextInput.nextSibling;
            }
            
            nextInput.style.display = 'none';
        }
        
        var entryRow = el.parentNode;
        do
        {
            entryRow = entryRow.parentNode;
        }
        while(entryRow.tagName != 'TR');
        
        longInput = entryRow.getElementsByTagName('TD')[3].getElementsByTagName('INPUT')[0];
        widthInput = entryRow.getElementsByTagName('TD')[4].getElementsByTagName('INPUT')[0];
        heightInput = entryRow.getElementsByTagName('TD')[5].getElementsByTagName('INPUT')[0];
        
        if(el.selectedIndex>0 && el.getElementsByTagName('OPTION')[el.selectedIndex].value != 'new')
        {           
            $.ajax({
                url: '/parts/ajax/'+el.value+'/all',
                dataType: "json",
                success: function (data) {
                    setLongInput(data.long);
                    setWidthInput(data.width);
                    setHeightInput(data.height);
                },
                error: function (request, text) {
                    alert("Error al procesar numero de parte "+el.value+". Error: "+text);
                }
            });
            //basicAjax('/parts/ajax/'+el.value+'/long',null,setLongInput);
            //basicAjax('/parts/ajax/'+el.value+'/width',null,setWidthInput);
            //basicAjax('/parts/ajax/'+el.value+'/height',null,setHeightInput);
        }
        else if (el.getElementsByTagName('OPTION')[el.selectedIndex].value == 'new')
        {
            setLongInput("");
            setWidthInput("");
            setHeightInput("");
        }
        else if (el.selectedIndex==0)
        {
            longInput.value = "";
            longInput.readOnly = true;
            widthInput.value = "";
            widthInput.readOnly = true;
            heightInput.value = "";
            heightInput.readOnly = true;
        }
    }
    
    function setLongInput(txt)
    {
        if (txt == '')
        {
            longInput.readOnly = false;
        }
        else
        {
            longInput.value = txt;
            longInput.readOnly = false;
        }
    }
    
    function setWidthInput(txt)
    {
        if (txt == '')
        {
            widthInput.readOnly = false;
        }
        else
        {
            widthInput.value = txt;
            widthInput.readOnly = false;
        }
    }
    
    function setHeightInput(txt)
    {
        if (txt == '')
        {
            heightInput.readOnly = false;
        }
        else
        {
            heightInput.value = txt;
            heightInput.readOnly = false;
        }
    }
    
</script>

<div class="receipts form">
<?php echo $form->create('Receipt');?>
	<fieldset>
 		<legend><?php __('Crear Entrada');?></legend>
        <table id='entriesTable'>
            <tr>
                <th>Familia</th>
                <th>Parte No.</th>
                <th>Bobina</th>
                <th>Largo</th>
                <th>Ancho</th>
                <th>Alto</th>
                <th>Piezas</th>
                <th>Comentarios</th>
                <th></th>
            </tr>
            <tr id="entry1">
                <td>
                    <?php
                        echo $form->select('Family',$families,null,
                                array(
                                    'onchange'=>'changeFamily(this)',
                                    'name'=>'data[Receipt][Family][]'
                                ));
                    ?>
                </td>
                <td>
                    <select name="data[Receipt][Part][]" style="width: 100px;" onchange="changePart(this)">
                        <option></option>
                    </select>
                    <input type="text" name="data[Receipt][Part][new][]" style="display: none;" />
                </td>
                <td>
                    <?php
                        echo $form->text('Identifier', array('name'=>'data[Receipt][Identifier][]'));
                    ?>
                </td>
                <td>
                    <?php
                        echo $form->text('long', array('name'=>'data[Receipt][long][]'));
                    ?>
                </td>
                <td>
                    <?php
                        echo $form->text('width', array('name'=>'data[Receipt][width][]'));
                    ?>
                </td>
                <td>
                    <?php
                        echo $form->text('height', array('name'=>'data[Receipt][height][]'));
                    ?>
                </td>
                <td>
                    <?php
                        echo $form->text('pieces', array('name'=>'data[Receipt][pieces][]'));
                    ?>
                </td>
                <td>
                    <?php
                        echo $form->text('comments', array('name'=>'data[Receipt][comments][]'));
                    ?>
                </td>
                <td>
                    <a href="#" onclick="removeEntryReceipt(this);">Quitar</a>
                </td>
            </tr>
        </table>
        <a href="javascript:addEntryReceipt()">Agregar Otro</a>
         <?php
                        echo $form->input('created', array('label'=>'Fecha Creada'));
          ?>
	</fieldset>
    <div class="submit"><input type="submit" value="Guardar Entrada" /></div>
    <div style="float: left; clear:none; margin-top:18px;"><?php echo $html->link('Cancelar',array('action'=>'index')) ?></div>
     
    
</div>
