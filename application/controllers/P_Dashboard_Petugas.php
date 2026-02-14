<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Dashboard_Petugas extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        
        // Cek apakah user sudah login
        if(!$this->session->userdata('username')) {
            redirect('login');
        }
        
        // Cek apakah role-nya petugas
        if($this->session->userdata('role') != 'Petugas Kecamatan') {
            redirect('login');
        }
    }

    public function index()
    {
        // Kirim data session ke view
        $data['kecamatan'] = $this->session->userdata('kecamatan');
        $data['username'] = $this->session->userdata('username');
        $data['role'] = $this->session->userdata('role');
        
        $this->load->view('p_dashboard_petugas', $data);
    }
}
?>