<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class K_dashboard_kepala extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('K_dashboard_kepala_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        // Cek login (sesuaikan dengan sistem Anda)
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        } 
    }  

    public function index()
    {
        // Data Pelaku Usaha
        $data['total_pelaku_usaha'] = $this->K_dashboard_kepala_model->count_pelaku_usaha();
        $data['total_jenis_usaha'] = $this->K_dashboard_kepala_model->count_jenis_usaha();
        $data['statistik_kecamatan'] = $this->K_dashboard_kepala_model->get_statistik_per_kecamatan();
        
        // Data untuk grafik
        $data['grafik_kecamatan'] = $this->K_dashboard_kepala_model->get_data_for_chart();
        
        // Data untuk modal
        $data['pelaku_usaha_per_kecamatan'] = $this->K_dashboard_kepala_model->get_pelaku_usaha_per_kecamatan();
        $data['detail_pelaku_usaha_per_kecamatan'] = $this->K_dashboard_kepala_model->get_detail_pelaku_usaha_per_kecamatan();
        $data['total_pelaku_usaha_all'] = $this->K_dashboard_kepala_model->get_total_pelaku_usaha_all();
        
        $data['total_per_komoditas'] = $this->K_dashboard_kepala_model->get_total_per_komoditas();
        $data['total_peternak'] = $this->K_dashboard_kepala_model->get_total_peternak();
        
        // Data Vaksinasi
        $data['total_vaksinasi_pmk'] = $this->K_dashboard_kepala_model->get_total_vaksinasi_pmk();
        $data['total_vaksinasi_ndai'] = $this->K_dashboard_kepala_model->get_total_vaksinasi_ndai();
        $data['total_vaksinasi_lsd'] = $this->K_dashboard_kepala_model->get_total_vaksinasi_lsd();
        $data['persen_vaksinasi_pmk'] = $this->K_dashboard_kepala_model->get_persentase_vaksinasi('PMK');
        $data['persen_vaksinasi_ndai'] = $this->K_dashboard_kepala_model->get_persentase_vaksinasi('ND/AI');
        $data['persen_vaksinasi_lsd'] = $this->K_dashboard_kepala_model->get_persentase_vaksinasi('LSD');
        
        // Data Tempat Usaha
        $data['total_klinik_hewan'] = $this->K_dashboard_kepala_model->get_total_klinik_hewan();
        $data['total_penjual_obat'] = $this->K_dashboard_kepala_model->get_total_penjual_obat();
        $data['total_penjual_pakan'] = $this->K_dashboard_kepala_model->get_total_penjual_pakan();
        
        // ============ TAMBAHKAN INI ============
        // Data RPU/TPU (ambil dari database atau statis)
        $data['total_rpu_tpu'] = $this->K_dashboard_kepala_model->get_total_rpu_tpu();
        // =======================================
        
        // Data per kecamatan untuk modal
        $data['klinik_per_kecamatan'] = $this->K_dashboard_kepala_model->get_klinik_hewan_per_kecamatan();
        $data['penjual_obat_per_kecamatan'] = $this->K_dashboard_kepala_model->get_penjual_obat_per_kecamatan();
        $data['penjual_pakan_per_kecamatan'] = $this->K_dashboard_kepala_model->get_penjual_pakan_per_kecamatan();
        $data['vaksinasi_per_kecamatan'] = $this->K_dashboard_kepala_model->get_vaksinasi_per_kecamatan_detail();
        $data['rpu_tpu_per_kecamatan'] = $this->K_dashboard_kepala_model->get_rpu_tpu_per_kecamatan();
        
        $data['title'] = 'Dashboard Kepala Dinas';
        $data['active_menu'] = 'dashboard';
        
        $this->load->view('kepala/k_dashboard_kepala', $data);
    }
    
    // API endpoint untuk AJAX
    public function get_data_json()
    {
        $data = array(
            'total_pelaku_usaha' => $this->K_dashboard_kepala_model->count_pelaku_usaha(),
            'total_jenis_usaha' => $this->K_dashboard_kepala_model->count_jenis_usaha(),
            'statistik_kecamatan' => $this->K_dashboard_kepala_model->get_statistik_per_kecamatan()
        );
        
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
?>