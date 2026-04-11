<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Include TCPDF library
require_once(dirname(__FILE__) . '/tcpdf/tcpdf.php');

class Pdf extends TCPDF
{
    public function __construct()
    {
        parent::__construct();
    }
    
    // Page header
    public function Header()
    {
        // You can add custom header here if needed
    }
    
    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Halaman ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}