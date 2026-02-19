<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akses_Pengguna extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Akses_Pengguna_Model');
        $this->load->library('session');
    }
    
    public function index() {
        $data['akses'] = $this->Akses_Pengguna_Model->get_all();
        $this->load->view('akses_pengguna', $data);
    }
    
    public function simpan() {
        // Validasi password
        $password = $this->input->post('password');
        $confirm_password = $this->input->post('confirm_password');
        
        if ($password !== $confirm_password) {
            $this->session->set_flashdata('error', 'Password dan Konfirmasi Password tidak sama');
            redirect('akses_pengguna');
        }
        
        if (strlen($password) < 6) {
            $this->session->set_flashdata('error', 'Password minimal 6 karakter');
            redirect('akses_pengguna');
        }
        
        // JANGAN hash password, simpan sebagai plain text agar admin bisa lihat
        $data = array(
            'username' => $this->input->post('username'),
            'password' => $password, // Simpan plain text
            'level' => $this->input->post('level'),
            'telepon' => $this->input->post('telepon'),
            'kecamatan' => $this->input->post('kecamatan'),
            'status' => $this->input->post('status')
        );
        
        $result = $this->Akses_Pengguna_Model->insert($data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data pengguna berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data pengguna');
        }
        
        redirect('akses_pengguna');
    }
    
    public function update() {
        $id = $this->input->post('id');
        
        $data = array(
            'username' => $this->input->post('username'),
            'level' => $this->input->post('level'),
            'telepon' => $this->input->post('telepon'),
            'kecamatan' => $this->input->post('kecamatan'),
            'status' => $this->input->post('status')
        );
        
        // Jika password diisi, update password (tetap plain text)
        $password = $this->input->post('password');
        if (!empty($password)) {
            $data['password'] = $password; // Simpan plain text
        }
        
        $result = $this->Akses_Pengguna_Model->update($id, $data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data pengguna berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data pengguna');
        }
         
        redirect('akses_pengguna');
    }
    
    public function hapus($id) {
        $result = $this->Akses_Pengguna_Model->delete($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data pengguna berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data pengguna');
        }
        
        redirect('akses_pengguna');
    }
} 