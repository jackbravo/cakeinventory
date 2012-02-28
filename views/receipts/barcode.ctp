<?php 

App::import('Vendor', 'pdfb');

 class PDF extends PDFB
  {

  }

  $pdf = new PDF("L", "pt", "letter");
  $pdf->SetAuthor("Ibex Systemms");
  $pdf->SetTitle("Etiquetas");


  $pdf->SetFont("Times", "", 7);


  $pdf->SetDrawColor(224);
  $pdf->SetLineWidth(1);


  $pdf->setSourceFile("pdf/etiqueta.pdf");
  $tplidx = $pdf->ImportPage(1);

foreach($entries as $entry){
  $pdf->AddPage();
  $pdf->useTemplate($tplidx);

  	$barcode_part = $entry['Part']['number'];
	$barcode_dimenciones = "Dimensiones: ".$entry['Part']['long'];
	$barcode_dimenciones1 = " x ".$entry['Part']['width'];
	$barcode_dimenciones2 = " x ".$entry['Part']['height'];
	$barcode_cantidad = " | Cant: ".$entry['Entry']['pieces'];
	$barcode_id = $entry['Entry']['id'];
	
    
    $barcode_bobina = " | Bobina: ".$entry['Identifier']['number'];           
    

    // dos renglones
	$pdf->Text(520, 250, "$barcode_part"."$barcode_bobina");    
	$pdf->Text(520, 260, "$barcode_dimenciones"."$barcode_dimenciones1"."$barcode_dimenciones2"."$barcode_cantidad");    
	$pdf->BarCode("$barcode_id", "C39", 510, 260, 250, 125, 1, 1, 3, 4, "", "PNG");
	    //$pdf->Text(50, 20, "$barcode_bobina");
}

  $pdf->Output();
  $pdf->closeParsers();

?>
