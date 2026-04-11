<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_Pemotongan_Unggas extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Data_Pemotongan_Unggas_Model');
        $this->load->library('session');
        $this->load->helper('url');
        
        // Cek session login
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['pemotongan_data'] = $this->Data_Pemotongan_Unggas_Model->get_all_pemotongan();
        $data['petugas_list'] = $this->Data_Pemotongan_Unggas_Model->get_distinct_petugas();
        $data['rpu_list'] = $this->Data_Pemotongan_Unggas_Model->get_distinct_rpu();
        
        $this->load->view('admin/data/data_pemotongan_unggas', $data);
    }

    // Fungsi untuk mendapatkan data JSON (untuk AJAX)
    public function get_data()
    {
        $data = $this->Data_Pemotongan_Unggas_Model->get_all_pemotongan();
        echo json_encode($data);
    }

    // Fungsi untuk mendapatkan detail pemotongan by ID
    public function detail($id)
    {
        $data = $this->Data_Pemotongan_Unggas_Model->get_pemotongan_by_id($id);
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
        
        $data = $this->Data_Pemotongan_Unggas_Model->get_by_periode($start_date, $end_date);
        
        echo json_encode([
            'status' => 'success',
            'data' => $data,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
    }

    // Fungsi untuk filter berdasarkan RPU
    public function filter_by_rpu($id_rpu)
    {
        // You might need to implement this method in the model
        // For now, we'll get all and filter
        $data = $this->Data_Pemotongan_Unggas_Model->get_all_pemotongan();
        $filtered = array_filter($data, function($item) use ($id_rpu) {
            return $item['id_rpu'] == $id_rpu;
        });
        
        echo json_encode([
            'status' => 'success',
            'data' => array_values($filtered)
        ]);
    }

    // Fungsi untuk menghapus data
    public function hapus($id)
    {
        $result = $this->Data_Pemotongan_Unggas_Model->delete_pemotongan($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data pemotongan unggas berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data pemotongan unggas');
        }
        
        redirect('data_pemotongan_unggas');
    }

    // Fungsi untuk mendapatkan statistik
    public function get_statistik()
    {
        $total_ekor = $this->Data_Pemotongan_Unggas_Model->sum_total_ekor();
        $total_berat = $this->Data_Pemotongan_Unggas_Model->sum_total_berat();
        
        $statistik = [
            'total_kegiatan' => $this->Data_Pemotongan_Unggas_Model->count_all(),
            'total_ekor' => $total_ekor,
            'total_berat' => $total_berat,
            'total_rpu' => count($this->Data_Pemotongan_Unggas_Model->get_distinct_rpu())
        ];
        
        echo json_encode($statistik);
    }
    
    // Fungsi untuk mendapatkan statistik per bulan
    public function statistik_per_bulan()
    {
        $tahun = $this->input->get('tahun') ?: date('Y');
        $data = $this->Data_Pemotongan_Unggas_Model->get_statistik_per_bulan($tahun);
        echo json_encode($data);
    }
    
    // Fungsi untuk mendapatkan statistik per RPU
    public function statistik_per_rpu()
    {
        $data = $this->Data_Pemotongan_Unggas_Model->get_statistik_per_rpu();
        echo json_encode($data);
    }
}
?>