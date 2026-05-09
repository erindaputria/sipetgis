<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_rpu extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Data_rpu_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        // Cek session login
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    } 

    public function index() 
    {
        $data['rpu_data'] = $this->Data_rpu_model->get_all_rpu();
        $data['pejagal_list'] = $this->Data_rpu_model->get_distinct_pejagal();
        $data['komoditas_list'] = $this->Data_rpu_model->get_distinct_komoditas();
        $data['kecamatan_list'] = $this->Data_rpu_model->get_distinct_kecamatan();
        
        $this->load->view('admin/data/data_rpu', $data);
    }

    // Fungsi untuk mendapatkan data JSON (untuk AJAX)
    public function get_data()
    {
        $data = $this->Data_rpu_model->get_all_rpu();
        echo json_encode($data);
    }

    // Fungsi untuk mendapatkan detail RPU by ID
    public function detail($id)
    {
        $data = $this->Data_rpu_model->get_rpu_by_id($id);
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
        
        $data = $this->Data_rpu_model->get_by_periode($start_date, $end_date);
        
        echo json_encode([
            'status' => 'success',
            'data' => $data,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
    }

    // Fungsi untuk menghapus data (via AJAX)
    public function hapus($id)
    {
        $result = $this->Data_rpu_model->delete_rpu($id);
        
        echo json_encode([
            'status' => $result ? 'success' : 'error',
            'message' => $result ? 'Data RPU berhasil dihapus' : 'Gagal menghapus data RPU'
        ]);
    }
// Fungsi untuk update data (via AJAX)
public function update($id)
{
    $update_data = [
        'pejagal' => $this->input->post('pejagal'),
        'tanggal_rpu' => $this->input->post('tanggal_rpu'),
        'nama_pj' => $this->input->post('nama_pj'),
        'nik_pj' => $this->input->post('nik_pj'),
        'telp_pj' => $this->input->post('telp_pj'),
        'nama_petugas' => $this->input->post('nama_petugas'),
        'kecamatan' => $this->input->post('kecamatan'),
        'kelurahan' => $this->input->post('kelurahan'),
        'rt' => $this->input->post('rt'),
        'rw' => $this->input->post('rw'),
        'lokasi' => $this->input->post('lokasi'),
        'latitude' => $this->input->post('latitude'),
        'longitude' => $this->input->post('longitude'),
        'keterangan' => $this->input->post('keterangan')
    ];
    
    $result = $this->Data_rpu_model->update_rpu($id, $update_data);
    
    echo json_encode([
        'status' => $result ? 'success' : 'error',
        'message' => $result ? 'Data berhasil diperbarui' : 'Gagal memperbarui data'
    ]);
}

    // Fungsi untuk mendapatkan statistik
    public function get_statistik()
    {
        $statistik = [
            'total_kegiatan' => $this->Data_rpu_model->count_all(),
            'total_ekor' => $this->Data_rpu_model->sum_total_ekor(),
            'total_berat' => $this->Data_rpu_model->sum_total_berat(),
            'total_pejagal' => count($this->Data_rpu_model->get_distinct_pejagal())
        ];
        
        echo json_encode($statistik);
    }

    
}
?>