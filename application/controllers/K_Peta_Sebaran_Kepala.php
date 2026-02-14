<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class K_Peta_Sebaran_Kepala extends CI_Controller {

    public function index()
    {
        // $this->load->model('Dashboard_model');
        // $data = $this->Dashboard_model->get_summary();
        $this->load->view('k_peta_sebaran_kepala');
        
    }
    
    
}
