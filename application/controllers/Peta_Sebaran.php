<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peta_sebaran extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index()
    {
        $data['title'] = 'Peta Sebaran - SIPETGIS';
        $this->load->view('admin/peta_sebaran', $data);
    }
}