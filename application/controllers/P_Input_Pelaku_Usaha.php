<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Pelaku_Usaha extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // Load library yang diperlukan
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('P_Input_Pelaku_Usaha_Model');
    }
    
    public function index() {
        // Data untuk view
        $data['title'] = 'Input Pelaku Usaha Ternak - SIPETGIS';
        
        // Ambil data dari model
        $data['pelaku_usaha_data'] = $this->P_Input_Pelaku_Usaha_Model->get_pelaku_usaha_for_table();
        
        // Load view
        $this->load->view('p_input_pelaku_usaha', $data);
    }
    
    public function save() {
        // Set response header sebagai JSON
        $this->output->set_content_type('application/json');
        
        // Validasi input
        $this->form_validation->set_rules('nama_peternak', 'Nama Peternak', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('komoditas_ternak', 'Komoditas Ternak', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('jumlah_tambah', 'Jumlah Tambah', 'required|integer');
        $this->form_validation->set_rules('jumlah_kurang', 'Jumlah Kurang', 'required|integer');
        $this->form_validation->set_rules('tanggal_input', 'Tanggal Input', 'required');
        $this->form_validation->set_rules('kelurahan', 'Kelurahan', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('latitude', 'Latitude', 'required');
        $this->form_validation->set_rules('longitude', 'Longitude', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array(
                'status' => 'error',
                'message' => validation_errors()
            ));
            return;
        }
        
        // Handle upload foto
        $foto_usaha = '';
        if (!empty($_FILES['foto_usaha']['name'])) {
            $config['upload_path'] = FCPATH . 'uploads/pelaku_usaha/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 5120;
            $config['encrypt_name'] = TRUE;
            
            // Buat folder jika belum ada
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }
            
            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('foto_usaha')) {
                $upload_data = $this->upload->data();
                $foto_usaha = $upload_data['file_name'];
            }
        }
        
        // Siapkan data untuk disimpan
        $data = array(
            'nama_peternak' => $this->input->post('nama_peternak'),
            'komoditas_ternak' => $this->input->post('komoditas_ternak'),
            'jumlah_tambah' => $this->input->post('jumlah_tambah'),
            'jumlah_kurang' => $this->input->post('jumlah_kurang'),
            'tanggal_input' => $this->input->post('tanggal_input'),
            'keterangan' => $this->input->post('keterangan'),
            'kecamatan' => $this->input->post('kecamatan'),
            'kelurahan' => $this->input->post('kelurahan'),
            'rt' => $this->input->post('rt'),
            'rw' => $this->input->post('rw'),
            'latitude' => $this->input->post('latitude'),
            'longitude' => $this->input->post('longitude'),
            'foto_usaha' => $foto_usaha
        );
        
        // Simpan ke database
        $result = $this->P_Input_Pelaku_Usaha_Model->save_pelaku_usaha($data);
        
        if ($result) {
            echo json_encode(array(
                'status' => 'success',
                'message' => 'Data pelaku usaha berhasil disimpan!'
            ));
        } else {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Gagal menyimpan data. Silakan coba lagi.'
            ));
        }
    }
    
    public function get_data() {
        $this->output->set_content_type('application/json');
        $data = $this->P_Input_Pelaku_Usaha_Model->get_all_pelaku_usaha();
        echo json_encode(array('data' => $data));
    }
}