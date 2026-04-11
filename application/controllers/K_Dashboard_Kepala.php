<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class K_Dashboard_Kepala extends CI_Controller {

    public function index()
    {
        $this->load->view('kepala/k_dashboard_kepala');
    }
} 