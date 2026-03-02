<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_Usaha extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Jenis_Usaha_Model');
        $this->load->library('session');
        $this->load->helper('security');
    }
    
    public function index() {
        $data['jenis_usaha'] = $this->Jenis_Usaha_Model->get_all();
        $this->load->view('admin/jenis_usaha', $data);
    }
    
    public function simpan() {
        // Validasi input
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('nama_peternak', 'Nama Peternak', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('jenis_usaha', 'Jenis Usaha', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect('jenis_usaha');
        }
        
        $data = array(
            'nama_peternak' => $this->input->post('nama_peternak'),
            'jenis_usaha' => $this->input->post('jenis_usaha'),
            'jumlah' => $this->input->post('jumlah'),
            'alamat' => $this->input->post('alamat'),
            'kecamatan' => $this->input->post('kecamatan')
        );
        
        $result = $this->Jenis_Usaha_Model->insert($data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data jenis usaha berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data jenis usaha');
        }
        
        redirect('jenis_usaha');
    }
    
    public function update() {
        $id = $this->input->post('id');
        
        // Validasi input
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('nama_peternak', 'Nama Peternak', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('jenis_usaha', 'Jenis Usaha', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect('jenis_usaha');
        }
        
        $data = array(
            'nama_peternak' => $this->input->post('nama_peternak'),
            'jenis_usaha' => $this->input->post('jenis_usaha'),
            'jumlah' => $this->input->post('jumlah'),
            'alamat' => $this->input->post('alamat'),
            'kecamatan' => $this->input->post('kecamatan')
        );
        
        $result = $this->Jenis_Usaha_Model->update($id, $data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data jenis usaha berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data jenis usaha');
        }
        
        redirect('jenis_usaha');
    } 
    
    public function hapus($id) {
        $result = $this->Jenis_Usaha_Model->delete($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data jenis usaha berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data jenis usaha');
        }
        
        redirect('jenis_usaha');
    }
}