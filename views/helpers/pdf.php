<?php 
/*
** File: pdf.php
** Loaction: views/helpers
 * help for pdf and barcode printing
 * ---------------------------------
 * @package helpers
 */
vendor('pdfb/pdfb');
class pdfHelper extends PDFB {
	var $headerData = null;
	var $footerData = null;

	function __construct($orientation='P', $unit='mm', $format='A4') {
		$this->set($orientation, $unit, $format);
	}

	function set($orientation='P', $unit='mm', $format='A4') {
		parent::PDFB($orientation, $unit, $format);
	}

	function Header() { 
	  // To do: manage headerData array
	}

	function Footer() { 
	  // To do: manage footerData array
	}

}
?>