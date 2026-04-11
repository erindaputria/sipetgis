<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layanan_Klinik extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Layanan_Klinik_Model');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('security');
    }
    
    public function index() {
        $data['layanan_klinik'] = $this->Layanan_Klinik_Model->get_all();
        $this->load->view('admin/layanan_klinik', $data);
    }
    
    public function simpan() {
        // Validasi input
        $this->form_validation->set_rules('nama_layanan', 'Nama Layanan', 'required|min_length[3]|max_length[100]');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect('layanan_klinik');
        }
        
        // Cek nama layanan sudah ada atau belum
        $nama_layanan = $this->input->post('nama_layanan');
        if ($this->Layanan_Klinik_Model->check_nama($nama_layanan)) {
            $this->session->set_flashdata('error', 'Nama layanan sudah terdaftar');
            redirect('layanan_klinik');
        }
        
        $data = array(
            'nama_layanan' => $nama_layanan
        );
        
        $result = $this->Layanan_Klinik_Model->insert($data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data layanan klinik berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data layanan klinik');
        }
        
        redirect('layanan_klinik');
    }
    
    public function update() {
        $id = $this->input->post('id_layanan');
        
        if (!$id) {
            $this->session->set_flashdata('error', 'ID layanan tidak ditemukan');
            redirect('layanan_klinik');
        }
        
        // Validasi input
        $this->form_validation->set_rules('nama_layanan', 'Nama Layanan', 'required|min_length[3]|max_length[100]');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect('layanan_klinik');
        }
        
        // Cek nama layanan sudah ada untuk data lain
        $nama_layanan = $this->input->post('nama_layanan');
        $existing = $this->Layanan_Klinik_Model->check_nama_except($nama_layanan, $id);
        if ($existing) {
            $this->session->set_flashdata('error', 'Nama layanan sudah digunakan oleh data lain');
            redirect('layanan_klinik');
        }
        
        $data = array(
            'nama_layanan' => $nama_layanan
        );
        
        $result = $this->Layanan_Klinik_Model->update($id, $data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data layanan klinik berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data layanan klinik');
        }
        
        redirect('layanan_klinik');
    }
    
    public function hapus($id) {
        if (!$id) {
            $this->session->set_flashdata('error', 'ID layanan tidak ditemukan');
            redirect('layanan_klinik');
        }
        
        $result = $this->Layanan_Klinik_Model->delete($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data layanan klinik berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data layanan klinik');
        }
        
        redirect('layanan_klinik');
    }
}