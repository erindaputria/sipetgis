<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_pemotongan_unggas extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Data_pemotongan_unggas_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        // Cek session login
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        } 
    }

    public function index()
{
    // Load model RPU untuk mengambil data master RPU
    $this->load->model('Rpu_model');
    $data['rpu_master_list'] = $this->Rpu_model->get_all();
    
    $data['pemotongan_data'] = $this->Data_pemotongan_unggas_model->get_all_pemotongan();
    $data['petugas_list'] = $this->Data_pemotongan_unggas_model->get_distinct_petugas();
    $data['rpu_list'] = $this->Data_pemotongan_unggas_model->get_distinct_rpu();
    
    $this->load->view('admin/data/data_pemotongan_unggas', $data);
}

    // Fungsi untuk mendapatkan data JSON (untuk AJAX)
    public function get_data()
    {
        $data = $this->Data_pemotongan_unggas_model->get_all_pemotongan();
        echo json_encode($data);
    }

    // Fungsi untuk mendapatkan detail pemotongan by ID
    public function detail($id)
    {
        $data = $this->Data_pemotongan_unggas_model->get_pemotongan_by_id($id);
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
        
        $data = $this->Data_pemotongan_unggas_model->get_by_periode($start_date, $end_date);
        
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
        $result = $this->Data_pemotongan_unggas_model->delete_pemotongan($id);
        
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
        $total_ekor = $this->Data_pemotongan_unggas_model->sum_total_ekor();
        $total_berat = $this->Data_pemotongan_unggas_model->sum_total_berat();
        
        $statistik = [
            'total_kegiatan' => $this->Data_pemotongan_unggas_model->count_all(),
            'total_ekor' => $total_ekor,
            'total_berat' => $total_berat,
            'total_rpu' => count($this->Data_pemotongan_unggas_model->get_distinct_rpu())
        ];
        
        echo json_encode($statistik);
    }
    
    // Fungsi untuk mendapatkan statistik per bulan
    public function statistik_per_bulan()
    {
        $tahun = $this->input->get('tahun') ?: date('Y');
        $data = $this->Data_pemotongan_unggas_model->get_statistik_per_bulan($tahun);
        echo json_encode($data);
    }
    
    // Fungsi untuk mendapatkan statistik per RPU
    public function statistik_per_rpu()
    {
        $data = $this->Data_pemotongan_unggas_model->get_statistik_per_rpu();
        echo json_encode($data);
    }

   public function update($id)
{
    // Ambil nama_rpu dari form (kirim dari JS)
    $nama_rpu = $this->input->post('id_rpu');
    
    // Cari id_rpu dari master RPU (jika perlu)
    $id_rpu = null;
    if (!empty($nama_rpu)) {
        $this->load->model('Rpu_model');
        $rpu_data = $this->Rpu_model->get_by_pejagal($nama_rpu);
        $id_rpu = $rpu_data ? $rpu_data->id : null;
    }
    
    $update_data = [
        'tanggal' => $this->input->post('tanggal'),
        'id_rpu' => $id_rpu,
        'nama_rpu' => $nama_rpu, // Simpan juga nama_rpu
        'ayam' => $this->input->post('ayam'),
        'itik' => $this->input->post('itik'),
        'dst' => $this->input->post('dst'),
        'daerah_asal' => $this->input->post('daerah_asal'),
        'nama_petugas' => $this->input->post('nama_petugas'),
        'keterangan' => $this->input->post('keterangan')
    ];
    
    $result = $this->Data_pemotongan_unggas_model->update_pemotongan($id, $update_data);
    
    // Ambil data terbaru untuk dikirim ke client (opsional)
    $updated_data = $result ? $this->Data_pemotongan_unggas_model->get_pemotongan_by_id($id) : null;
    
    echo json_encode([
        'status' => $result ? 'success' : 'error',
        'message' => $result ? 'Data berhasil diperbarui' : 'Gagal memperbarui data',
        'data' => $updated_data
    ]);
}
}
?>