<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Dashboard_Petugas extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('P_Input_Pengobatan_Model');
        $this->load->model('P_Input_Vaksinasi_Model');
        $this->load->model('P_Input_Jenis_Usaha_Model');
        
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
        // Ambil kecamatan dari session
        $kecamatan = $this->session->userdata('kecamatan');
        
        // Statistik Pengobatan
        $total_pengobatan = $this->P_Input_Pengobatan_Model->count_all($kecamatan);
        $total_ternak_diobati = $this->P_Input_Pengobatan_Model->sum_jumlah($kecamatan);
        
        // Statistik Vaksinasi
        $total_vaksinasi = $this->P_Input_Vaksinasi_Model->count_all($kecamatan);
        $total_ternak_divaksin = $this->P_Input_Vaksinasi_Model->sum_jumlah($kecamatan);
        
        // Statistik Jenis Usaha
        $total_pemilik_usaha = $this->P_Input_Jenis_Usaha_Model->count_unique_pemilik($kecamatan);
        $total_jumlah_ternak = $this->P_Input_Jenis_Usaha_Model->get_total_ternak_saat_ini($kecamatan);
        $total_usaha = $this->P_Input_Jenis_Usaha_Model->count_all($kecamatan);
        
        // Data komoditas ternak untuk chart
        $komoditas_ternak = $this->P_Input_Jenis_Usaha_Model->get_statistik_jenis_usaha($kecamatan);
        $jumlah_jenis_usaha = count($komoditas_ternak);
        
        // Data untuk chart
        $chart_labels = [];
        $chart_data = [];
        $chart_colors = ['#1a73e8', '#34a853', '#fbbc05', '#ea4335', '#9334e6', '#ff6d00', '#00acc1', '#8e24aa'];
        
        foreach ($komoditas_ternak as $index => $item) {
            $chart_labels[] = $item['jenis_usaha']; // Ini akan berisi nilai dari komoditas_ternak
            $chart_data[] = (int)$item['total_jumlah'];
        }
        
        // Jika tidak ada data, gunakan default
        if (empty($chart_labels)) {
            $chart_labels = ['Sapi Potong', 'Kambing', 'Ayam Ras Petelur', 'Ayam Kampung', 'Itik'];
            $chart_data = [0, 0, 0, 0, 0];
            $jumlah_jenis_usaha = 5;
        }
        
        // Kirim data ke view
        $data['total_pemilik_usaha'] = $total_pemilik_usaha;
        $data['jumlah_jenis_usaha'] = $jumlah_jenis_usaha;
        $data['total_ternak'] = $total_jumlah_ternak;
        $data['total_usaha'] = $total_usaha;
        $data['total_pengobatan'] = $total_pengobatan;
        $data['total_ternak_diobati'] = $total_ternak_diobati;
        $data['total_vaksinasi'] = $total_vaksinasi; 
        $data['total_ternak_divaksin'] = $total_ternak_divaksin; 
        $data['chart_labels'] = $chart_labels;
        $data['chart_data'] = $chart_data;
        $data['chart_colors'] = array_slice($chart_colors, 0, count($chart_labels));
        
        // Data session
        $data['kecamatan'] = $kecamatan;
        $data['username'] = $this->session->userdata('username');
        $data['role'] = $this->session->userdata('role');
        
        $this->load->view('petugas/p_dashboard_petugas', $data);
    }
}