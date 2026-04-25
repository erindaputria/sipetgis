<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_usaha extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Jenis_usaha_model');
        $this->load->library('session');
        $this->load->helper('security');
        $this->load->helper('url');
    }
    
    public function index() {
        $data['jenis_usaha'] = $this->Jenis_usaha_model->get_all();
        $this->load->view('admin/jenis_usaha', $data);
    }
    
    public function simpan() {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('jenis_usaha', 'Jenis Usaha', 'required|min_length[3]|max_length[100]');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', strip_tags($errors));
            redirect('jenis_usaha');
        }
        
        $jenis_usaha = trim($this->input->post('jenis_usaha'));
        
        if ($this->Jenis_usaha_model->check_exists($jenis_usaha)) {
            $this->session->set_flashdata('error', 'Jenis Usaha "' . $jenis_usaha . '" sudah ada!');
            redirect('jenis_usaha');
        }
        
        $data = array(
            'jenis_usaha' => $jenis_usaha
        );
        
        $result = $this->Jenis_usaha_model->insert($data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data jenis usaha berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data jenis usaha');
        }
        
        redirect('jenis_usaha');
    }
    
    public function update() {
        $id = $this->input->post('id');
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('jenis_usaha', 'Jenis Usaha', 'required|min_length[3]|max_length[100]');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', strip_tags($errors));
            redirect('jenis_usaha');
        }
        
        $jenis_usaha = trim($this->input->post('jenis_usaha'));
        
        if ($this->Jenis_usaha_model->check_exists($jenis_usaha, $id)) {
            $this->session->set_flashdata('error', 'Jenis Usaha "' . $jenis_usaha . '" sudah ada!');
            redirect('jenis_usaha');
        }
        
        $data = array(
            'jenis_usaha' => $jenis_usaha
        );
        
        $result = $this->Jenis_usaha_model->update($id, $data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data jenis usaha berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data jenis usaha');
        }
        
        redirect('jenis_usaha');
    }
    
    // Method hapus dengan parameter default null untuk menghindari error
    public function hapus($id = null) {
        // Jika id tidak ada di parameter, coba ambil dari URI segment
        if ($id === null) {
            $id = $this->uri->segment(3);
        }
        
        // Jika masih tidak ada, coba dari GET
        if ($id === null) {
            $id = $this->input->get('id');
        }
        
        // Validasi akhir
        if ($id === null || $id === '') {
            $this->session->set_flashdata('error', 'ID tidak ditemukan! Silakan coba lagi.');
            redirect('jenis_usaha');
        }
        
        // Cek apakah data ada
        $data = $this->Jenis_usaha_model->get_by_id($id);
        if (!$data) {
            $this->session->set_flashdata('error', 'Data jenis usaha dengan ID ' . $id . ' tidak ditemukan!');
            redirect('jenis_usaha');
        }
        
        $result = $this->Jenis_usaha_model->delete($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data jenis usaha "' . $data->jenis_usaha . '" berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data jenis usaha');
        }
        
        redirect('jenis_usaha');
    }
    
    public function get_csrf() {
        $this->output->set_content_type('application/json');
        echo json_encode([
            'csrf_token' => $this->security->get_csrf_hash()
        ]);
    }
}
?>