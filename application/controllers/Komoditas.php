<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komoditas extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Komoditas_Model');
        $this->load->library('session');
        $this->load->helper('security');
    }
    
    public function index() {
        $data['komoditas'] = $this->Komoditas_Model->get_all();
        $this->load->view('komoditas', $data);
    }
    
    public function simpan() {
        // Validasi input
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('nama_komoditas', 'Nama Komoditas', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('jenis', 'Jenis', 'required');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect('komoditas');
        }
        
        // Cek nama komoditas sudah ada atau belum
        $nama_komoditas = $this->input->post('nama_komoditas');
        if ($this->Komoditas_Model->check_nama($nama_komoditas)) {
            $this->session->set_flashdata('error', 'Nama komoditas sudah terdaftar');
            redirect('komoditas');
        }
        
        $data = array(
            'nama_komoditas' => $nama_komoditas,
            'jenis_hewan' => $this->input->post('jenis'),
            'satuan' => $this->input->post('satuan'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin')
        );
        
        $result = $this->Komoditas_Model->insert($data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data komoditas berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data komoditas');
        }
        
        redirect('komoditas');
    }
    
    public function update() {
        $id = $this->input->post('id_komoditas');
        
        // Validasi input
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('nama_komoditas', 'Nama Komoditas', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('jenis', 'Jenis', 'required');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect('komoditas');
        }
        
        // Cek nama komoditas sudah ada untuk data lain
        $nama_komoditas = $this->input->post('nama_komoditas');
        $existing = $this->Komoditas_Model->check_nama_except($nama_komoditas, $id);
        if ($existing) {
            $this->session->set_flashdata('error', 'Nama komoditas sudah digunakan oleh data lain');
            redirect('komoditas');
        }
        
        $data = array(
            'nama_komoditas' => $nama_komoditas,
            'jenis_hewan' => $this->input->post('jenis'),
            'satuan' => $this->input->post('satuan'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin')
        );
        
        $result = $this->Komoditas_Model->update($id, $data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data komoditas berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data komoditas');
        }
        
        redirect('komoditas');
    }
    
    public function hapus($id) {
        $result = $this->Komoditas_Model->delete($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data komoditas berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data komoditas');
        }
        
        redirect('komoditas');
    }
}