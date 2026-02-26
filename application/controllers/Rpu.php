<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rpu extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Rpu_Model'); // Panggil Rpu_Model (dengan underscore)
        $this->load->library('session');
        $this->load->helper('url');
    }
    
    public function index() {
        $data['rpu'] = $this->Rpu_Model->get_all(); // Panggil method dari Rpu_Model
        $this->load->view('rpu', $data);
    }
    
    public function simpan() {
        // Validasi input
        $pejagal = $this->input->post('pejagal');
        
        if (empty($pejagal)) {
            $this->session->set_flashdata('error', 'Nama RPU/Pejagal tidak boleh kosong');
            redirect('rpu');
        }
        
        $data = array(
            'pejagal' => $pejagal,
            'latitude' => $this->input->post('latitude') ?: null,
            'longitude' => $this->input->post('longitude') ?: null
        );
        
        $result = $this->Rpu_Model->insert($data); // Panggil method dari Rpu_Model
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data RPU berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data RPU');
        }
        
        redirect('rpu');
    }
    
    public function update() {
        $id = $this->input->post('id');
        
        $data = array(
            'pejagal' => $this->input->post('pejagal'),
            'latitude' => $this->input->post('latitude') ?: null,
            'longitude' => $this->input->post('longitude') ?: null
        );
        
        $result = $this->Rpu_Model->update($id, $data); // Panggil method dari Rpu_Model
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data RPU berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data RPU');
        }
         
        redirect('rpu');
    }
    
    public function hapus($id) {
        $result = $this->Rpu_Model->delete($id); // Panggil method dari Rpu_Model
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data RPU berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data RPU');
        }
        
        redirect('rpu');
    }
}