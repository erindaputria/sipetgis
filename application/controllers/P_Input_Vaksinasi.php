<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Vaksinasi extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // Load library yang diperlukan
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('P_Input_Vaksinasi_Model');
    }
    
    public function index() {
        // Data untuk view
        $data['title'] = 'Input Vaksinasi Ternak - SIPETGIS';
        
        // Ambil data dari model
        $data['vaksinasi_data'] = $this->P_Input_Vaksinasi_Model->get_vaksinasi_for_table();
        
        // Load view tanpa folder petugas
        $this->load->view('p_input_vaksinasi', $data);
    }
    
    public function save() {
        // Set response header sebagai JSON
        $this->output->set_content_type('application/json');
        
        // Validasi input
        $this->form_validation->set_rules('nama_peternak', 'Nama Peternak', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('komoditas_ternak', 'Komoditas Ternak', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('jenis_vaksinasi', 'Jenis Vaksinasi', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|integer|greater_than[0]');
        $this->form_validation->set_rules('tanggal_vaksinasi', 'Tanggal Vaksinasi', 'required');
        $this->form_validation->set_rules('bantuan_prov', 'Bantuan Provinsi', 'required');
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
        $foto_vaksinasi = '';
        if (!empty($_FILES['foto_vaksinasi']['name'])) {
            $config['upload_path'] = FCPATH . 'uploads/vaksinasi/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 5120;
            $config['encrypt_name'] = TRUE;
            
            // Buat folder jika belum ada
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }
            
            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('foto_vaksinasi')) {
                $upload_data = $this->upload->data();
                $foto_vaksinasi = $upload_data['file_name'];
            }
        }
        
        // Siapkan data untuk disimpan
        $data = array(
            'nama_peternak' => $this->input->post('nama_peternak'),
            'komoditas_ternak' => $this->input->post('komoditas_ternak'),
            'jenis_vaksinasi' => $this->input->post('jenis_vaksinasi'),
            'jumlah' => $this->input->post('jumlah'),
            'tanggal_vaksinasi' => $this->input->post('tanggal_vaksinasi'),
            'keterangan' => $this->input->post('keterangan'),
            'bantuan_prov' => $this->input->post('bantuan_prov'),
            'kelurahan' => $this->input->post('kelurahan'),
            'rt' => $this->input->post('rt'),
            'rw' => $this->input->post('rw'),
            'latitude' => $this->input->post('latitude'),
            'longitude' => $this->input->post('longitude'),
            'foto_vaksinasi' => $foto_vaksinasi
        );
        
        // Simpan ke database
        $result = $this->P_Input_Vaksinasi_Model->save_vaksinasi($data);
        
        if ($result) {
            echo json_encode(array(
                'status' => 'success',
                'message' => 'Data vaksinasi berhasil disimpan!'
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
        $data = $this->P_Input_Vaksinasi_Model->get_all_vaksinasi();
        echo json_encode(array('data' => $data));
    }
}
?>