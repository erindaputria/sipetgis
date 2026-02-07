<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index()
    {
        // $this->load->model('Dashboard_model');
        // $data = $this->Dashboard_model->get_summary();
        $this->load->view('login');
        
    }
    
    
}
