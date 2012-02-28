<?php
	$javascript->link('datepicker', false);
	$html->css('datepicker', 'stylesheet', array('media'=>'all' ), false);
?>

<div class="dispatches index">
    <h2><?php __('Remisiones de Salida');?></h2>

    <form method='post'>
    	
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

    <table cellpadding="0" cellspacing="0" style="width:33%">
    <tr>
    	<th><?php echo $paginator->sort('Salida No.','id');?></th>
    	<th><?php echo $paginator->sort('Fecha','created');?></th>
    </tr>
    <?php
    $i = 0;
    foreach ($dispatches as $dispatch):
    	$class = null;
    	if ($i++ % 2 == 0) {
    		$class = ' class="altrow"';
    	}
    ?>
    	<tr<?php echo $class;?>>
    		<td>
    			<?php 
                    echo $html->link(__($dispatch['Dispatch']['id'], true), array('action' => 'view', $dispatch['Dispatch']['id'])); 
                ?>
    		</td>
    		<td>
    			<?php 
                    echo $html->link(__($dispatch['Dispatch']['created'], true), array('action' => 'view', $dispatch['Dispatch']['id'])); 
                ?>
    		</td>
    	</tr>
    <?php endforeach; ?>
    </table>
</div>