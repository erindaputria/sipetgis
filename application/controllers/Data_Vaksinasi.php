<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_vaksinasi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->model('Data_vaksinasi_model'); 
        
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
 
    public function index()
    {
        $data['vaksinasi'] = $this->Data_vaksinasi_model->get_all_vaksinasi();
        $this->load->view('admin/data/data_vaksinasi', $data);
    }
    
    public function get_detail()
    {
        $jenis_vaksin = $this->input->post('jenis_vaksin');
        $tahun = $this->input->post('tahun');
        
        $data = $this->Data_vaksinasi_model->get_detail_vaksinasi($jenis_vaksin, $tahun);
        
        echo json_encode($data);
    }
    
    public function filter_data()
    {
        $komoditas = $this->input->post('komoditas');
        
        $data = $this->Data_vaksinasi_model->get_vaksinasi_by_komoditas($komoditas);
        
        echo json_encode($data);
    }
}