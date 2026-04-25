<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_penjual_pakan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Data_penjual_pakan_model');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function index()
    {
        $this->load->view('admin/data/data_penjual_pakan');
    }

    public function get_all_data()
    {
        header('Content-Type: application/json');
        $data = $this->Data_penjual_pakan_model->get_all_penjual_pakan();
        echo json_encode($data);
    }

    public function get_detail($id)
    {
        header('Content-Type: application/json');
        $data = $this->Data_penjual_pakan_model->get_penjual_pakan_by_id($id);
        echo json_encode($data);
    }

    public function delete($id)
    {
        header('Content-Type: application/json');
        $result = $this->Data_penjual_pakan_model->delete_penjual_pakan($id);
        echo json_encode([
            'status' => $result ? 'success' : 'error',
            'message' => $result ? 'Data berhasil dihapus' : 'Gagal menghapus data'
        ]);
    }

    public function update($id)
    {
        header('Content-Type: application/json');
        
        $update_data = [
            'nama_toko' => $this->input->post('nama_toko'),
            'nama_pemilik' => $this->input->post('pemilik'),
            'kecamatan' => $this->input->post('kecamatan'),
            'alamat' => $this->input->post('alamat'),
            'latitude' => $this->input->post('latitude'),
            'longitude' => $this->input->post('longitude'),
            'telp' => $this->input->post('telepon'),
            'surat_ijin' => $this->input->post('status') == 'Aktif' ? 'Y' : 'N',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('id_penjual', $id);
        $result = $this->db->update('penjual', $update_data);
        
        echo json_encode([
            'status' => $result ? 'success' : 'error',
            'message' => $result ? 'Data berhasil diperbarui' : 'Gagal memperbarui data'
        ]);
    }
}