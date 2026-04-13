<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Dashboard_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        // Cek login (sesuaikan dengan sistem Anda)
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['total_pelaku_usaha'] = $this->Dashboard_model->count_pelaku_usaha();
        $data['total_jenis_usaha'] = $this->Dashboard_model->count_jenis_usaha();
        $data['statistik_kecamatan'] = $this->Dashboard_model->get_statistik_per_kecamatan();
        $data['title'] = 'Dashboard';
        $data['active_menu'] = 'dashboard';
        
        $this->load->view('admin/dashboard', $data);
    }
    
    // API endpoint untuk AJAX jika perlu refresh data
    public function get_data_json()
    {
        $data = array(
            'total_pelaku_usaha' => $this->Dashboard_model->count_pelaku_usaha(),
            'total_jenis_usaha' => $this->Dashboard_model->count_jenis_usaha(),
            'statistik_kecamatan' => $this->Dashboard_model->get_statistik_per_kecamatan()
        );
        
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
?>