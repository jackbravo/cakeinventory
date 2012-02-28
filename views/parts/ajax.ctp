<?php
    if (isset($dim))
    {
        echo $dim;
    }
    else
    {
        if (!isset($nothingSelected))
        {
            ?>
            <select name="data[Receipt][Part][]" style="width: 100px;" onchange="changePart(this)">
                <option></option>
                <?php
                    foreach($parts as $part)
                    {
                        echo "<option value='".$part['Part']['id']."'>";
                        echo $part['Part']['number'];
                        echo "</option>";
                    }
                ?>
                <option value='new'>Otro</option>
            </select>
            <input type="text" name="data[Receipt][Part][new][]" style="display: none;" />
            <?php
        }
        else
        {
            ?>
            <select name="data[Receipt][Part][]" style="width: 100px;" onchange="changePart(this)">
                <option></option>
            </select>
            <input type="text" name="data[Receipt][Part][new][]" style="display: none;" />    
            <?php
        }
    }
?>