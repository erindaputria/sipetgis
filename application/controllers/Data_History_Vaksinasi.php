<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_History_Vaksinasi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Data_History_Vaksinasi_Model');
        $this->load->helper('url');
        $this->load->library('session');
        
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    } 

    public function index()
    {
        $data = [];
        $this->load->view('admin/data/data_history_vaksinasi', $data);
    }

    public function get_all_data()
    {
        header('Content-Type: application/json');
        $data = $this->Data_History_Vaksinasi_Model->get_all_vaksinasi();
        echo json_encode($data);
    }

    public function get_detail($id)
    {
        header('Content-Type: application/json');
        $data = $this->Data_History_Vaksinasi_Model->get_vaksinasi_by_id($id);
        echo json_encode($data);
    }

    public function delete($id)
    {
        $result = $this->Data_History_Vaksinasi_Model->delete_vaksinasi($id);
        $response = [
            'status' => $result ? 'success' : 'error',
            'message' => $result ? 'Data berhasil dihapus' : 'Gagal menghapus data'
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function update($id)
    {
        $update_data = [
            'tanggal_vaksinasi' => $this->input->post('tanggal_vaksinasi'),
            'nama_petugas' => $this->input->post('nama_petugas'),
            'nama_peternak' => $this->input->post('nama_peternak'),
            'nik' => $this->input->post('nik'),
            'kecamatan' => $this->input->post('kecamatan'),
            'kelurahan' => $this->input->post('kelurahan'),
            'alamat' => $this->input->post('alamat'),
            'rt' => $this->input->post('rt'),
            'rw' => $this->input->post('rw'),
            'latitude' => $this->input->post('latitude'),
            'longitude' => $this->input->post('longitude'),
            'jumlah' => $this->input->post('jumlah'),
            'komoditas_ternak' => $this->input->post('komoditas_ternak'),
            'jenis_vaksinasi' => $this->input->post('jenis_vaksinasi'),
            'dosis' => $this->input->post('dosis'),
            'telp' => $this->input->post('telp'),
            'bantuan_prov' => $this->input->post('bantuan_prov'),
            'keterangan' => $this->input->post('keterangan')
        ];
        
        $this->db->where('id_vaksinasi', $id);
        $result = $this->db->update('input_vaksinasi', $update_data);
        
        $response = [
            'status' => $result ? 'success' : 'error',
            'message' => $result ? 'Data berhasil diperbarui' : 'Gagal memperbarui data'
        ];
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}