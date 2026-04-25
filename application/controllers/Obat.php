<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obat extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Obat_model');
        $this->load->library('session');
    }
    
    public function index() {
        $data['obat'] = $this->Obat_model->get_all();
        $this->load->view('admin/obat', $data);
    }
    
    public function simpan() {
        $data = array(
            'obat' => $this->input->post('obat'),
            'jenis_pengobatan' => $this->input->post('jenis_pengobatan'),
            'dosis' => $this->input->post('dosis')
        );
        
        $result = $this->Obat_model->insert($data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data obat berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data obat');
        }
        
        redirect('obat');
    }
    
    public function update() {
        $id = $this->input->post('id_obat');
        
        $data = array(
            'obat' => $this->input->post('obat'),
            'jenis_pengobatan' => $this->input->post('jenis_pengobatan'),
            'dosis' => $this->input->post('dosis')
        );
        
        $result = $this->Obat_model->update($id, $data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data obat berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data obat');
        }
        
        redirect('obat');
    }
    
    public function hapus($id) {
        $result = $this->Obat_model->delete($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data obat berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data obat');
        }
        
        redirect('obat');
    }
}
?>