<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelaku_usaha extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Pelaku_usaha_model');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('security');
         
        // Cek login (sesuaikan dengan sistem autentikasi Anda)
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
    
    public function index() {
        $data['pelaku_usaha'] = $this->Pelaku_usaha_model->get_all();
        $data['title'] = 'Master Data Pelaku Usaha';
        $data['active_menu'] = 'pelaku_usaha';
        
        $this->load->view('admin/pelaku_usaha', $data);
    }
    
    public function simpan() {
        // Validasi input
        $this->form_validation->set_rules('nama', 'Nama Pelaku Usaha', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('nik', 'NIK', 'required|exact_length[16]|numeric');
        $this->form_validation->set_rules('telepon', 'Telepon', 'min_length[10]|max_length[15]|numeric');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect('pelaku_usaha');
        }
        
        // Cek NIK sudah ada atau belum
        $nik = $this->input->post('nik');
        if ($this->Pelaku_usaha_model->check_nik($nik)) {
            $this->session->set_flashdata('error', 'NIK sudah terdaftar');
            redirect('pelaku_usaha');
        }
        
        $data = array(
            'nama' => $this->input->post('nama', TRUE),
            'nik' => $nik,
            'telepon' => $this->input->post('telepon', TRUE),
            'alamat' => $this->input->post('alamat', TRUE),
            'kecamatan' => $this->input->post('kecamatan', TRUE),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        
        $result = $this->Pelaku_usaha_model->insert($data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data pelaku usaha berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data pelaku usaha');
        }
        
        redirect('pelaku_usaha');
    }
    
    public function update() {
        // Validasi input
        $this->form_validation->set_rules('id', 'ID', 'required|numeric');
        $this->form_validation->set_rules('nama', 'Nama Pelaku Usaha', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('nik', 'NIK', 'required|exact_length[16]|numeric');
        $this->form_validation->set_rules('telepon', 'Telepon', 'min_length[10]|max_length[15]|numeric');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect('pelaku_usaha');
        }
        
        $id = $this->input->post('id');
        $nik = $this->input->post('nik');
        
        // Cek apakah data dengan ID tersebut ada
        $existing_data = $this->Pelaku_usaha_model->get_by_id($id);
        if (!$existing_data) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('pelaku_usaha');
        }
        
        // Cek NIK sudah ada untuk pengguna lain (kecuali data sendiri)
        $check_nik = $this->Pelaku_usaha_model->check_nik_except($nik, $id);
        if ($check_nik) {
            $this->session->set_flashdata('error', 'NIK sudah digunakan oleh pelaku usaha lain');
            redirect('pelaku_usaha');
        }
        
        $data = array(
            'nama' => $this->input->post('nama', TRUE),
            'nik' => $nik,
            'telepon' => $this->input->post('telepon', TRUE),
            'alamat' => $this->input->post('alamat', TRUE),
            'kecamatan' => $this->input->post('kecamatan', TRUE),
            'updated_at' => date('Y-m-d H:i:s')
        );
        
        $result = $this->Pelaku_usaha_model->update($id, $data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data pelaku usaha berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data pelaku usaha');
        }
        
        redirect('pelaku_usaha');
    }
    
    public function hapus($id) {
        if (!is_numeric($id)) {
            $this->session->set_flashdata('error', 'ID tidak valid');
            redirect('pelaku_usaha');
        }
        
        // Cek apakah data dengan ID tersebut ada
        $existing_data = $this->Pelaku_usaha_model->get_by_id($id);
        if (!$existing_data) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('pelaku_usaha');
        }
        
        $result = $this->Pelaku_usaha_model->delete($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data pelaku usaha berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data pelaku usaha');
        }
        
        redirect('pelaku_usaha');
    }
    
    public function detail($id) {
        if (!is_numeric($id)) {
            $this->session->set_flashdata('error', 'ID tidak valid');
            redirect('pelaku_usaha');
        }
        
        $data['pelaku'] = $this->Pelaku_usaha_model->get_by_id($id);
         
        if (!$data['pelaku']) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('pelaku_usaha');
        }
        
        $data['title'] = 'Detail Pelaku Usaha';
        $data['active_menu'] = 'pelaku_usaha';
        
        $this->load->view('admin/pelaku_usaha_detail', $data);
    }
}
?>