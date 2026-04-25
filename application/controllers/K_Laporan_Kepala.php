<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class K_laporan_kepala extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Load libraries and model
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('K_laporan_kepala_model');
    }

    public function index() {
        $this->kepemilikan_ternak();
    }

    // ==================== VIEW METHODS ====================
    
    /**
     * Laporan Kepemilikan Ternak
     */
    public function kepemilikan_ternak() {
        $data['title'] = 'Laporan Kepemilikan Ternak';
        $data['tahun'] = $this->K_laporan_kepala_model->get_tahun_range();
        $data['kecamatan'] = $this->K_laporan_kepala_model->get_kecamatan_from_table('data_kepemilikan_ternak');
        $data['bulan'] = $this->K_laporan_kepala_model->get_all_bulan();
        
        $this->load->view('kepala/laporan/laporan_kepemilikan_ternak', $data);
    }
    
    /**
     * Laporan History Data Ternak
     */
    public function history_data_ternak() {
        $data['title'] = 'Laporan History Data Ternak';
        $data['tahun'] = $this->K_laporan_kepala_model->get_tahun_range();
        $data['kecamatan'] = $this->K_laporan_kepala_model->get_kecamatan_from_table('data_history_ternak');
        $data['bulan'] = $this->K_laporan_kepala_model->get_all_bulan();
        
        $this->load->view('kepala/laporan/laporan_history_data_ternak', $data);
    }
    
    /**
     * Laporan Vaksinasi
     */
    public function vaksinasi() {
        $data['title'] = 'Laporan Vaksinasi';
        $data['tahun'] = $this->K_laporan_kepala_model->get_tahun_range();
        $data['kecamatan'] = $this->K_laporan_kepala_model->get_kecamatan_from_table('data_vaksinasi');
        $data['bulan'] = $this->K_laporan_kepala_model->get_all_bulan();
        
        $this->load->view('kepala/laporan/laporan_vaksinasi', $data);
    }
    
    /**
     * Laporan History Vaksinasi
     */
    public function history_vaksinasi() {
        $data['title'] = 'Laporan History Data Vaksinasi';
        $data['tahun'] = $this->K_laporan_kepala_model->get_tahun_range();
        $data['kecamatan'] = $this->K_laporan_kepala_model->get_kecamatan_from_table('data_history_vaksinasi');
        $data['bulan'] = $this->K_laporan_kepala_model->get_all_bulan();
        
        $this->load->view('kepala/laporan/laporan_history_data_vaksinasi', $data);
    }
    
    /**
     * Laporan Pengobatan Ternak
     */
    public function pengobatan_ternak() {
        $data['title'] = 'Laporan Pengobatan Ternak';
        $data['tahun'] = $this->K_laporan_kepala_model->get_tahun_range();
        $data['kecamatan'] = $this->K_laporan_kepala_model->get_kecamatan_from_table('data_pengobatan_ternak');
        $data['bulan'] = $this->K_laporan_kepala_model->get_all_bulan();
        
        $this->load->view('kepala/laporan/laporan_pengobatan_ternak', $data);
    }
    
    /**
     * Laporan Penjual Pakan Ternak - SEKARANG BISA PILIH TAHUN
     */
    public function penjual_pakan() {
        $data['title'] = 'Laporan Penjual Pakan Ternak';
        $data['tahun'] = $this->K_laporan_kepala_model->get_tahun_range();  // TAMBAHKAN INI
        $data['kecamatan'] = $this->K_laporan_kepala_model->get_kecamatan_from_table('data_penjual_pakan');
        $data['bulan'] = $this->K_laporan_kepala_model->get_all_bulan();      // TAMBAHKAN INI
        
        $this->load->view('kepala/laporan/laporan_penjual_pakan_ternak', $data);
    }
    
    /**
     * Laporan Data Klinik Hewan - SEKARANG BISA PILIH TAHUN
     */
    public function data_klinik_hewan() {
        $data['title'] = 'Laporan Data Klinik Hewan';
        $data['tahun'] = $this->K_laporan_kepala_model->get_tahun_range();  // TAMBAHKAN INI
        $data['kecamatan'] = $this->K_laporan_kepala_model->get_kecamatan_from_table('data_klinik_hewan');
        $data['bulan'] = $this->K_laporan_kepala_model->get_all_bulan();      // TAMBAHKAN INI
        
        $this->load->view('kepala/laporan/laporan_data_klinik_hewan', $data);
    }
    
    /**
     * Laporan Penjual Obat Hewan - SEKARANG BISA PILIH TAHUN
     */
    public function penjual_obat_hewan() {
        $data['title'] = 'Laporan Penjual Obat Hewan';
        $data['tahun'] = $this->K_laporan_kepala_model->get_tahun_range();  // TAMBAHKAN INI
        $data['kecamatan'] = $this->K_laporan_kepala_model->get_kecamatan_from_table('data_penjual_obat');
        $data['bulan'] = $this->K_laporan_kepala_model->get_all_bulan();      // TAMBAHKAN INI
        
        $this->load->view('kepala/laporan/laporan_penjual_obat_hewan', $data);
    }
    
    /**
     * Laporan Data TPU/RPU - SEKARANG BISA PILIH TAHUN
     */
    public function data_tpu_rpu() {
        $data['title'] = 'Laporan Data TPU / RPU';
        $data['tahun'] = $this->K_laporan_kepala_model->get_tahun_range();  // TAMBAHKAN INI
        $data['kecamatan'] = $this->K_laporan_kepala_model->get_kecamatan_from_table('data_tpu_rpu');
        $data['bulan'] = $this->K_laporan_kepala_model->get_all_bulan();      // TAMBAHKAN INI
        
        $this->load->view('kepala/laporan/laporan_data_tpu_rpu', $data);
    }
    
    /**
     * Laporan Demplot Peternakan - SEKARANG BISA PILIH TAHUN
     */
    public function demplot_peternakan() {
        $data['title'] = 'Laporan Demplot Peternakan';
        $data['tahun'] = $this->K_laporan_kepala_model->get_tahun_range();  // TAMBAHKAN INI
        $data['kecamatan'] = $this->K_laporan_kepala_model->get_kecamatan_from_table('data_demplot');
        $data['bulan'] = $this->K_laporan_kepala_model->get_all_bulan();      // TAMBAHKAN INI
        
        $this->load->view('kepala/laporan/laporan_demplot_peternakan', $data);
    }
    
    /**
     * Laporan Stok Pakan
     */
    public function stok_pakan() {
        $data['title'] = 'Laporan Stok Pakan';
        $data['tahun'] = $this->K_laporan_kepala_model->get_tahun_range();
        $data['kecamatan'] = $this->K_laporan_kepala_model->get_kecamatan_from_table('data_stok_pakan');
        
        $this->load->view('kepala/laporan/laporan_stok_pakan', $data);
    }

    // ==================== API ENDPOINTS FOR AJAX ====================
    
    /**
     * API untuk Kepemilikan Ternak
     */
    public function api_kepemilikan_ternak() {
        $filter = [
            'tahun' => $this->input->get('tahun'),
            'bulan' => $this->input->get('bulan'),
            'kecamatan' => $this->input->get('kecamatan')
        ];
        
        $data = $this->K_laporan_kepala_model->get_data_with_filter('data_kepemilikan_ternak', $filter, 'tanggal_data');
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'success', 'data' => $data]));
    }
    
    /**
     * API untuk History Data Ternak
     */
    public function api_history_ternak() {
        $filter = [
            'tahun' => $this->input->get('tahun'),
            'bulan' => $this->input->get('bulan'),
            'kecamatan' => $this->input->get('kecamatan')
        ];
        
        $data = $this->K_laporan_kepala_model->get_data_with_filter('data_history_ternak', $filter, 'tanggal_update');
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'success', 'data' => $data]));
    }
    
    /**
     * API untuk Vaksinasi
     */
    public function api_vaksinasi() {
        $filter = [
            'tahun' => $this->input->get('tahun'),
            'bulan' => $this->input->get('bulan'),
            'kecamatan' => $this->input->get('kecamatan')
        ];
        
        $data = $this->K_laporan_kepala_model->get_data_with_filter('data_vaksinasi', $filter, 'tanggal_vaksinasi');
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'success', 'data' => $data]));
    }
    
    /**
     * API untuk History Vaksinasi
     */
    public function api_history_vaksinasi() {
        $filter = [
            'tahun' => $this->input->get('tahun'),
            'bulan' => $this->input->get('bulan'),
            'kecamatan' => $this->input->get('kecamatan')
        ];
        
        $data = $this->K_laporan_kepala_model->get_data_with_filter('data_history_vaksinasi', $filter, 'tanggal_vaksinasi');
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'success', 'data' => $data]));
    }
    
    /**
     * API untuk Pengobatan Ternak
     */
    public function api_pengobatan() {
        $filter = [
            'tahun' => $this->input->get('tahun'),
            'bulan' => $this->input->get('bulan'),
            'kecamatan' => $this->input->get('kecamatan')
        ];
        
        $data = $this->K_laporan_kepala_model->get_data_with_filter('data_pengobatan_ternak', $filter, 'tanggal_pengobatan');
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'success', 'data' => $data]));
    }
    
    /**
     * API untuk Penjual Pakan
     */
    public function api_penjual_pakan() {
        $filter = [
            'tahun' => $this->input->get('tahun'),      // TAMBAHKAN filter tahun
            'bulan' => $this->input->get('bulan'),      // TAMBAHKAN filter bulan
            'kecamatan' => $this->input->get('kecamatan')
        ];
        
        $data = $this->K_laporan_kepala_model->get_data_with_filter('data_penjual_pakan', $filter, 'tanggal_data');
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'success', 'data' => $data]));
    }
    
    /**
     * API untuk Klinik Hewan
     */
    public function api_klinik() {
        $filter = [
            'tahun' => $this->input->get('tahun'),      // TAMBAHKAN filter tahun
            'bulan' => $this->input->get('bulan'),      // TAMBAHKAN filter bulan
            'kecamatan' => $this->input->get('kecamatan')
        ];
        
        $data = $this->K_laporan_kepala_model->get_data_with_filter('data_klinik_hewan', $filter, 'tanggal_data');
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'success', 'data' => $data]));
    }
    
    /**
     * API untuk Penjual Obat
     */
    public function api_penjual_obat() {
        $filter = [
            'tahun' => $this->input->get('tahun'),      // TAMBAHKAN filter tahun
            'bulan' => $this->input->get('bulan'),      // TAMBAHKAN filter bulan
            'kecamatan' => $this->input->get('kecamatan')
        ];
        
        $data = $this->K_laporan_kepala_model->get_data_with_filter('data_penjual_obat', $filter, 'tanggal_data');
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'success', 'data' => $data]));
    }
    
    /**
     * API untuk TPU/RPU
     */
    public function api_tpu_rpu() {
        $filter = [
            'tahun' => $this->input->get('tahun'),      // TAMBAHKAN filter tahun
            'bulan' => $this->input->get('bulan'),      // TAMBAHKAN filter bulan
            'kecamatan' => $this->input->get('kecamatan')
        ];
        
        $data = $this->K_laporan_kepala_model->get_data_with_filter('data_tpu_rpu', $filter, 'tanggal_data');
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'success', 'data' => $data]));
    }
    
    /**
     * API untuk Demplot
     */
    public function api_demplot() {
        $filter = [
            'tahun' => $this->input->get('tahun'),      // TAMBAHKAN filter tahun
            'bulan' => $this->input->get('bulan'),      // TAMBAHKAN filter bulan
            'kecamatan' => $this->input->get('kecamatan')
        ];
        
        $data = $this->K_laporan_kepala_model->get_data_with_filter('data_demplot', $filter, 'tanggal_data');
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'success', 'data' => $data]));
    }
    
    /**
     * API untuk Stok Pakan
     */
    public function api_stok_pakan() {
        $filter = [
            'tahun' => $this->input->get('tahun'),
            'kecamatan' => $this->input->get('kecamatan')
        ];
        
        $data = $this->K_laporan_kepala_model->get_data_with_filter('data_stok_pakan', $filter, 'tanggal_data');
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'success', 'data' => $data]));
    }
}