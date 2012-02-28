<?php 
App::import('Vendor', 'pdfb');

 class PDF extends PDFB
  {

  }

  // Create a PDF object and set up the properties
  $pdf = new PDF("p", "pt", "letter");
  $pdf->SetAuthor("Ibex Systemms");
  $pdf->SetTitle("Etiquetas");

  // Add custom font
  // Read: http://www.fpdf.org/en/tutorial/tuto7.htm for more info
  // $pdf->AddFont("Trebuchet");
  // $pdf->SetFont("Trebuchet", "", 10);
  $pdf->SetFont("Times", "", 8);

  // Set line drawing defaults
  $pdf->SetDrawColor(224);
  $pdf->SetLineWidth(1);

  // Load the base PDF into template
  $pdf->setSourceFile("pdf/etiqueta.pdf");
  $tplidx = $pdf->ImportPage(1);

  // Add new page & use the base PDF as template
  $pdf->AddPage();
  $pdf->useTemplate($tplidx);


  $pdf->Text(50, 20, "Familia: MUV");
  $pdf->BarCode("577", "C128B", 20, 20, 150, 50, 0.25, 0.25, 2, 2, "", "PNG");


  $pdf->Output();
  $pdf->closeParsers();

?>