<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_pengobatan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Data_pengobatan_model');
        $this->load->helper('url');
        $this->load->library('session');
         
        // CEK SESSION LOGIN
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    } 
 
    public function index()
    {
        $user_kecamatan = $this->session->userdata('kecamatan');
        $user_level = $this->session->userdata('level');
        
        $data['user_kecamatan'] = $user_kecamatan;
        $data['user_level'] = $user_level;
        
        // Jika petugas, set kecamatannya
        if ($user_level != 'admin') {
            $data['kecamatan_filter'] = $user_kecamatan;
        }
        
        // Ambil data untuk filter dropdown
        $data['komoditas_list'] = $this->Data_pengobatan_model->get_distinct_komoditas();
        $data['kecamatan_list'] = $this->Data_pengobatan_model->get_distinct_kecamatan();
        
        $this->load->view('admin/data/data_pengobatan', $data);
    }

    public function get_all_data()
    {
        header('Content-Type: application/json');
        $data = $this->Data_pengobatan_model->get_all_pengobatan();
        echo json_encode($data);
    }

    public function get_detail($id)
    {
        $data = $this->Data_pengobatan_model->get_pengobatan_by_id($id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function delete($id)
    {
        // Cek akses
        $user_level = $this->session->userdata('level');
        $user_kecamatan = $this->session->userdata('kecamatan');
        
        // Untuk petugas, cek apakah data milik kecamatannya
        if ($user_level != 'admin') {
            $this->db->select('kecamatan');
            $this->db->from('input_pengobatan');
            $this->db->where('id', $id);
            $data = $this->db->get()->row_array();
            
            if (!$data || $data['kecamatan'] != $user_kecamatan) {
                $response = [
                    'status' => 'error',
                    'message' => 'Anda tidak memiliki akses untuk menghapus data ini'
                ];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }
        }
        
        $result = $this->Data_pengobatan_model->delete_pengobatan($id);
        $response = [
            'status' => $result ? 'success' : 'error',
            'message' => $result ? 'Data berhasil dihapus' : 'Gagal menghapus data'
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    public function test_db()
    {
        $query = $this->db->get('input_pengobatan');
        echo 'Total data di tabel input_pengobatan: ' . $query->num_rows() . '<br>';
        echo '<pre>';
        print_r($query->result_array());
        echo '</pre>';
    }

    public function update($id)
    {
        // Cek akses
        $user_level = $this->session->userdata('level');
        $user_kecamatan = $this->session->userdata('kecamatan');
        
        // Untuk petugas, cek apakah data milik kecamatannya
        if ($user_level != 'admin') {
            $this->db->select('kecamatan');
            $this->db->from('input_pengobatan');
            $this->db->where('id', $id);
            $data = $this->db->get()->row_array();
            
            if (!$data || $data['kecamatan'] != $user_kecamatan) {
                $response = [
                    'status' => 'error',
                    'message' => 'Anda tidak memiliki akses untuk mengedit data ini'
                ];
                echo json_encode($response);
                return;
            }
        }
        
        $update_data = [
            'tanggal_pengobatan' => $this->input->post('tanggal_pengobatan'),
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
            'telp' => $this->input->post('telp'),
            'gejala_klinis' => $this->input->post('gejala_klinis'),
            'jenis_pengobatan' => $this->input->post('jenis_pengobatan'),
            'bantuan_prov' => $this->input->post('bantuan_prov'),
            'keterangan' => $this->input->post('keterangan')
        ];
        
        $this->db->where('id', $id); 
        $result = $this->db->update('input_pengobatan', $update_data);
        
        $response = [
            'status' => $result ? 'success' : 'error',
            'message' => $result ? 'Data berhasil diperbarui' : 'Gagal memperbarui data'
        ];
        
        header('Content-Type: application/json');
        echo json_encode($response); 
    }
}