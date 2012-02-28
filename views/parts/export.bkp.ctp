<?php
$xls->setHeader('Inventario_'.date('Y_m_d'));

$xls->addXmlHeader();
$xls->setWorkSheetName('Inventario');

$xls->openRow();
$xls->writeString(' ');
$xls->writeString('Codigo');
$xls->writeString('Familia');
$xls->writeString('No. de Parte');
$xls->writeString('Bobina');
$xls->writeString('Largo');
$xls->writeString('Ancho');
$xls->writeString('Alto');
$xls->writeString('Piezas');
$xls->writeString('Fecha de Ingreso');
$xls->writeString('Documento');
$xls->writeString('Comentarios');
$xls->closeRow();

$displayedParts = array();

foreach ($parts as $part):
  
   $fechaEntrada = end($part['Entry']);
   
   if(!empty($fechaEntrada['receipt_id'])){
		$documento = $fechaEntrada['receipt_id'];
   } elseif(!empty($fechaEntrada['dispatch_id'])) {
		$documento = $fechaEntrada['dispatch_id'];
   } else {
  		$documento = "Error";
  }
    				
   
    if ($part['Family']['name']== 'MUV')
    {
            $totalPieces = 0;
            foreach($part['Entry'] as $entry)
            {
                // SI NO HAY DISPATCH ID, QUIERE DECIR QUE ES UNA SALIDA
                if ($entry['dispatch_id'] != null)
                {
                    $totalPieces -= $entry['pieces'];
                }
                // SI HAY RECEIPT ID, QUIERE DECIR QUE ES UNA ENTRADA
                if ($entry['receipt_id'] != null)
                {
                    $totalPieces += $entry['pieces'];
                }
            }
        
            $xls->openRow();
            $xls->writeString(" ");
            $xls->writeString($entry['id']);            
            $xls->writeString($part['Family']['name']);
            $xls->writeString($part['Part']['number']);
            $xls->writeString('');
            $xls->writeNumber($part['Part']['long']);
            $xls->writeNumber($part['Part']['width']);
            $xls->writeNumber($part['Part']['height']);
            $xls->writeNumber($totalPieces);
            $xls->writeNumber($fechaEntrada['created']);
            $xls->writeNumber($documento);
            $xls->writeNumber($fechaEntrada['comments']);                                    
            $xls->closeRow();
    }
    else
    {
        foreach($part['Entry'] as $entry)
        {
            // SI HAY DISPATCH ID, QUIERE DECIR QUE ES UNA SALIDA
            if ($entry['dispatch_id'] != null)
            {
                continue;
            }
            
            $this_id = '';
            foreach($part['Identifier'] as $identifier)
            {
                if ($identifier['entry_id'] == $entry['id'])
                {
                    $this_id = $identifier['number'];
                    break;
                }
            }
        
            $xls->openRow();
            $xls->writeString(" ");
            $xls->writeString($entry['id']);             
            $xls->writeString($part['Family']['name']);
            $xls->writeString($part['Part']['number']);
            $xls->writeString($this_id);
            $xls->writeNumber($part['Part']['long']);
            $xls->writeNumber($part['Part']['width']);
            $xls->writeNumber($part['Part']['height']);
            $xls->writeNumber($entry['pieces']);
            $xls->writeNumber($fechaEntrada['created']);
            $xls->writeNumber($documento);
            $xls->writeNumber($fechaEntrada['comments']);                         
            $xls->closeRow();
        }
    }
    
endforeach;

$xls->addXmlFooter();
exit();
?>