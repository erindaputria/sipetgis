<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_Rpu extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Data_Rpu_Model');
        $this->load->library('session');
        $this->load->helper('url');
        
        // Cek session login
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['rpu_data'] = $this->Data_Rpu_Model->get_all_rpu();
        $data['pejagal_list'] = $this->Data_Rpu_Model->get_distinct_pejagal();
        $data['komoditas_list'] = $this->Data_Rpu_Model->get_distinct_komoditas();
        $data['kecamatan_list'] = $this->Data_Rpu_Model->get_distinct_kecamatan();
        
        $this->load->view('admin/data/data_rpu', $data);
    }

    // Fungsi untuk mendapatkan data JSON (untuk AJAX)
    public function get_data()
    {
        $data = $this->Data_Rpu_Model->get_all_rpu();
        echo json_encode($data);
    }

    // Fungsi untuk mendapatkan detail RPU by ID
    public function detail($id)
    {
        $data = $this->Data_Rpu_Model->get_rpu_by_id($id);
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
        
        $data = $this->Data_Rpu_Model->get_by_periode($start_date, $end_date);
        
        echo json_encode([
            'status' => 'success',
            'data' => $data,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
    }

    // Fungsi untuk menghapus data
    public function hapus($id)
    {
        $result = $this->Data_Rpu_Model->delete_rpu($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data RPU berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data RPU');
        }
        
        redirect('data_rpu');
    }

    // Fungsi untuk mendapatkan statistik
    public function get_statistik()
    {
        $statistik = [
            'total_kegiatan' => $this->Data_Rpu_Model->count_all(),
            'total_ekor' => $this->Data_Rpu_Model->sum_total_ekor(),
            'total_berat' => $this->Data_Rpu_Model->sum_total_berat(),
            'total_pejagal' => count($this->Data_Rpu_Model->get_distinct_pejagal())
        ];
        
        echo json_encode($statistik);
    }
}
?>