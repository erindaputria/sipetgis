<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Gunakan path manual ke dompdf
require_once APPPATH . 'libraries/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf {
    
    public $dompdf;
    
    public function __construct() {
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);
        
        $this->dompdf = new Dompdf($options);
    }
    
    public function loadHtml($html) {
        $this->dompdf->loadHtml($html);
    }
    
    public function setPaper($size, $orientation) {
        $this->dompdf->setPaper($size, $orientation);
    }
    
    public function render() {
        $this->dompdf->render();
    }
    
    public function stream($filename, $options = array()) {
        $this->dompdf->stream($filename, $options);
    }
    
    public function output() {
        return $this->dompdf->output();
    }
}
?>