<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_Penjual_Obat extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load model jika diperlukan
        // $this->load->model('PenjualObat_model');
    }

    public function index()
    {
        // $data['penjual_obat'] = $this->PenjualObat_model->get_all_data();
        $this->load->view('admin/data/data_penjual_obat');
        
    }

    // Fungsi untuk mendapatkan data JSON (jika menggunakan AJAX)
    public function get_data()
    {
        // $data = $this->PenjualObat_model->get_all_data();
        // echo json_encode($data);
    }

    // Fungsi untuk menambah data
    public function tambah()
    {
        // Logika untuk menambah data
    }

    // Fungsi untuk mengedit data
    public function edit($id)
    {
        // Logika untuk mengedit data
    }

    // Fungsi untuk menghapus data
    public function hapus($id)
    {
        // Logika untuk menghapus data
    }

    // Fungsi untuk mendapatkan detail penjual obat
    public function detail($id)
    {
        // $data = $this->PenjualObat_model->get_detail($id);
        // echo json_encode($data);
    }
}
?>