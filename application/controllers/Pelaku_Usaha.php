<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelaku_Usaha extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Pelaku_Usaha_Model');
        $this->load->library('session');
        $this->load->helper('security');
        
        // Cek login (sesuaikan dengan sistem autentikasi Anda)
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
    
    public function index() {
        $data['pelaku_usaha'] = $this->Pelaku_Usaha_Model->get_all();
        $data['title'] = 'Master Data Pelaku Usaha';
        $data['active_menu'] = 'pelaku_usaha';
        
        $this->load->view('admin/pelaku_usaha', $data);
    }
    
    public function simpan() {
        // Validasi input
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('nama', 'Nama Pelaku Usaha', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('nik', 'NIK', 'required|exact_length[16]|numeric');
        $this->form_validation->set_rules('telepon', 'Telepon', 'min_length[10]|max_length[15]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
        $this->form_validation->set_rules('jenis_usaha', 'Jenis Usaha', 'required');
        $this->form_validation->set_rules('latitude', 'Latitude', 'numeric');
        $this->form_validation->set_rules('longitude', 'Longitude', 'numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect('pelaku_usaha');
        }
        
        // Cek NIK sudah ada atau belum
        $nik = $this->input->post('nik');
        if ($this->Pelaku_Usaha_Model->check_nik($nik)) {
            $this->session->set_flashdata('error', 'NIK sudah terdaftar');
            redirect('pelaku_usaha');
        }
        
        $data = array(
            'nama' => $this->input->post('nama'),
            'nik' => $nik,
            'telepon' => $this->input->post('telepon'),
            'alamat' => $this->input->post('alamat'),
            'kecamatan' => $this->input->post('kecamatan'),
            'jenis_usaha' => $this->input->post('jenis_usaha'),
            'latitude' => $this->input->post('latitude'),
            'longitude' => $this->input->post('longitude'),
            'status' => $this->input->post('status') ?: 'Aktif',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        
        $result = $this->Pelaku_Usaha_Model->insert($data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data pelaku usaha berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data pelaku usaha');
        }
        
        redirect('pelaku_usaha');
    }
    
    public function update() {
        $id = $this->input->post('id');
        
        // Validasi input
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('nama', 'Nama Pelaku Usaha', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('nik', 'NIK', 'required|exact_length[16]|numeric');
        $this->form_validation->set_rules('telepon', 'Telepon', 'min_length[10]|max_length[15]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
        $this->form_validation->set_rules('jenis_usaha', 'Jenis Usaha', 'required');
        $this->form_validation->set_rules('latitude', 'Latitude', 'numeric');
        $this->form_validation->set_rules('longitude', 'Longitude', 'numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect('pelaku_usaha');
        }
        
        // Cek NIK sudah ada untuk pengguna lain
        $nik = $this->input->post('nik');
        $existing = $this->Pelaku_Usaha_Model->check_nik_except($nik, $id);
        if ($existing) {
            $this->session->set_flashdata('error', 'NIK sudah digunakan oleh pelaku usaha lain');
            redirect('pelaku_usaha');
        }
        
        $data = array(
            'nama' => $this->input->post('nama'),
            'nik' => $nik,
            'telepon' => $this->input->post('telepon'),
            'alamat' => $this->input->post('alamat'),
            'kecamatan' => $this->input->post('kecamatan'),
            'jenis_usaha' => $this->input->post('jenis_usaha'),
            'latitude' => $this->input->post('latitude'),
            'longitude' => $this->input->post('longitude'),
            'status' => $this->input->post('status'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        
        $result = $this->Pelaku_Usaha_Model->update($id, $data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data pelaku usaha berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data pelaku usaha');
        }
        
        redirect('pelaku_usaha');
    }
    
    public function hapus($id) {
        $result = $this->Pelaku_Usaha_Model->delete($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data pelaku usaha berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data pelaku usaha');
        }
        
        redirect('pelaku_usaha');
    }
    
    public function detail($id) {
        $data['pelaku'] = $this->Pelaku_Usaha_Model->get_by_id($id);
        
        if (!$data['pelaku']) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('pelaku_usaha');
        }
        
        $data['title'] = 'Detail Pelaku Usaha';
        $data['active_menu'] = 'pelaku_usaha';
        
        $this->load->view('admin/pelaku_usaha_detail', $data);
    }
}