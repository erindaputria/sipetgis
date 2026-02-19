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
        $this->load->model('P_Input_Pelaku_Usaha_Model');
        
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
        
        // Statistik Pelaku Usaha
        $total_peternak = $this->P_Input_Pelaku_Usaha_Model->count_unique_peternak($kecamatan);
        $total_tambah = $this->P_Input_Pelaku_Usaha_Model->sum_tambah($kecamatan);
        $total_kurang = $this->P_Input_Pelaku_Usaha_Model->sum_kurang($kecamatan);
        $total_ternak_saat_ini = $total_tambah - $total_kurang;
        
        // Data komoditas untuk chart
        $komoditas = $this->P_Input_Pelaku_Usaha_Model->get_statistik_komoditas($kecamatan);
        $jumlah_komoditas = count($komoditas);
        
        // Data untuk chart
        $chart_labels = [];
        $chart_data = [];
        $chart_colors = ['#1a73e8', '#34a853', '#fbbc05', '#ea4335', '#9334e6'];
        
        foreach ($komoditas as $index => $item) {
            $chart_labels[] = $item['komoditas_ternak'];
            $chart_data[] = (int)$item['total_ternak'];
        }
        
        // Jika tidak ada data, gunakan default
        if (empty($chart_labels)) {
            $chart_labels = ['Sapi Potong', 'Kambing', 'Ayam Ras Petelur', 'Ayam Kampung', 'Itik'];
            $chart_data = [0, 0, 0, 0, 0];
            $jumlah_komoditas = 5;
        }
        
        // Kirim data ke view
        $data['total_peternak'] = $total_peternak;
        $data['jumlah_komoditas'] = $jumlah_komoditas;
        $data['total_ternak'] = $total_ternak_saat_ini;
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
        
        $this->load->view('p_dashboard_petugas', $data);
    }
}