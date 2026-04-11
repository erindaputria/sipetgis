<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_Stok_Pakan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Data_Stok_Pakan_Model');
        $this->load->library('session');
        $this->load->helper('url');
        
        // Cek session login
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['stok_data'] = $this->Data_Stok_Pakan_Model->get_all_stok();
        $data['jenis_pakan_list'] = $this->Data_Stok_Pakan_Model->get_distinct_jenis_pakan();
        $data['merk_pakan_list'] = $this->Data_Stok_Pakan_Model->get_distinct_merk_pakan();
        $data['demplot_list'] = $this->Data_Stok_Pakan_Model->get_distinct_demplot();
        
        $this->load->view('admin/data/data_stok_pakan', $data);
    }

    // Fungsi untuk mendapatkan data JSON (untuk AJAX)
    public function get_data()
    {
        $data = $this->Data_Stok_Pakan_Model->get_all_stok();
        echo json_encode($data);
    }

    // Fungsi untuk mendapatkan detail stok by ID
    public function detail($id)
    {
        $data = $this->Data_Stok_Pakan_Model->get_stok_by_id($id);
        if ($data) {
            echo json_encode([
                'status' => 'success',
                'data' => $data
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    // Fungsi untuk filter berdasarkan periode
    public function filter_by_periode()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        
        if (empty($start_date) || empty($end_date)) {
            $start_date = date('Y-m-01');
            $end_date = date('Y-m-t');
        }
        
        $data = $this->Data_Stok_Pakan_Model->get_by_periode($start_date, $end_date);
        
        echo json_encode([
            'status' => 'success',
            'data' => $data,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
    }

    // Fungsi untuk filter berdasarkan jenis pakan
    public function filter_by_jenis_pakan($jenis_pakan)
    {
        $data = $this->Data_Stok_Pakan_Model->get_by_jenis_pakan(urldecode($jenis_pakan));
        
        echo json_encode([
            'status' => 'success',
            'data' => $data
        ]);
    }

    // Fungsi untuk filter berdasarkan merk pakan
    public function filter_by_merk_pakan($merk_pakan)
    {
        $data = $this->Data_Stok_Pakan_Model->get_by_merk_pakan(urldecode($merk_pakan));
        
        echo json_encode([
            'status' => 'success',
            'data' => $data
        ]);
    }

    // Fungsi untuk filter berdasarkan demplot
    public function filter_by_demplot($id_demplot)
    {
        $data = $this->Data_Stok_Pakan_Model->get_by_demplot($id_demplot);
        
        echo json_encode([
            'status' => 'success',
            'data' => $data
        ]);
    }

    // Fungsi untuk menghapus data
    public function hapus($id)
    {
        $result = $this->Data_Stok_Pakan_Model->delete_stok($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data stok pakan berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data stok pakan');
        }
        
        redirect('data_stok_pakan');
    }

    // Fungsi untuk mendapatkan statistik
    public function get_statistik()
    {
        $statistik = [
            'total_transaksi' => $this->Data_Stok_Pakan_Model->count_all(),
            'total_stok_awal' => $this->Data_Stok_Pakan_Model->sum_stok_awal(),
            'total_stok_masuk' => $this->Data_Stok_Pakan_Model->sum_stok_masuk(),
            'total_stok_keluar' => $this->Data_Stok_Pakan_Model->sum_stok_keluar(),
            'total_stok_akhir' => $this->Data_Stok_Pakan_Model->sum_stok_akhir(),
            'total_jenis_pakan' => count($this->Data_Stok_Pakan_Model->get_distinct_jenis_pakan()),
            'total_merk_pakan' => count($this->Data_Stok_Pakan_Model->get_distinct_merk_pakan()),
            'total_demplot' => count($this->Data_Stok_Pakan_Model->get_distinct_demplot())
        ];
        
        echo json_encode($statistik);
    }
    
    // Fungsi untuk mendapatkan stok terkini per jenis
    public function get_current_stok()
    {
        $data = $this->Data_Stok_Pakan_Model->get_current_stok_per_jenis();
        echo json_encode($data);
    }
    
    // Fungsi untuk mendapatkan statistik per bulan
    public function statistik_per_bulan()
    {
        $tahun = $this->input->get('tahun') ?: date('Y');
        $data = $this->Data_Stok_Pakan_Model->get_statistik_per_bulan($tahun);
        echo json_encode($data);
    }
    
    // Fungsi untuk mendapatkan statistik per jenis pakan
    public function statistik_per_jenis()
    {
        $data = $this->Data_Stok_Pakan_Model->get_statistik_per_jenis();
        echo json_encode($data);
    }
    
    // Fungsi untuk mendapatkan statistik per merk
    public function statistik_per_merk()
    {
        $data = $this->Data_Stok_Pakan_Model->get_statistik_per_merk();
        echo json_encode($data);
    }
    
    // Fungsi untuk mendapatkan statistik per demplot
    public function statistik_per_demplot()
    {
        $data = $this->Data_Stok_Pakan_Model->get_statistik_per_demplot();
        echo json_encode($data);
    }
    
    // Fungsi untuk mendapatkan stok opname summary
    public function stok_opname_summary()
    {
        $data = $this->Data_Stok_Pakan_Model->get_stok_opname_summary();
        echo json_encode($data);
    }
}
?>