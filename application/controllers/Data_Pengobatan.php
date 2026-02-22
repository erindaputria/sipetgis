<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_Pengobatan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Data_Pengobatan_Model');
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
        $data['komoditas_list'] = $this->Data_Pengobatan_Model->get_distinct_komoditas();
        $data['kecamatan_list'] = $this->Data_Pengobatan_Model->get_distinct_kecamatan();
        
        $this->load->view('admin/data/data_pengobatan', $data);
    }

    public function get_all_data()
    {
        $user_kecamatan = $this->session->userdata('kecamatan');
        $user_level = $this->session->userdata('level');
        
        // Untuk admin bisa lihat semua, untuk petugas hanya kecamatannya
        if ($user_level == 'admin') {
            $data = $this->Data_Pengobatan_Model->get_all_pengobatan();
        } else {
            $data = $this->Data_Pengobatan_Model->get_pengobatan_by_kecamatan($user_kecamatan);
        }
        
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function get_detail($id)
    {
        $data = $this->Data_Pengobatan_Model->get_pengobatan_by_id($id);
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
        
        $result = $this->Data_Pengobatan_Model->delete_pengobatan($id);
        $response = [
            'status' => $result ? 'success' : 'error',
            'message' => $result ? 'Data berhasil dihapus' : 'Gagal menghapus data'
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    /**
     * Test endpoint untuk cek koneksi database
     */
    public function test_db()
    {
        $query = $this->db->get('input_pengobatan');
        echo 'Total data di tabel input_pengobatan: ' . $query->num_rows() . '<br>';
        echo '<pre>';
        print_r($query->result_array());
        echo '</pre>';
    }
}