<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vaksin extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Vaksin_model');
        $this->load->library('session');
    }
    
    public function index() {
        $data['vaksin'] = $this->Vaksin_model->get_all();
        $data['title'] = 'Master Data Vaksin';
        
        // Langsung load view vaksin tanpa templates
        $this->load->view('admin/vaksin', $data);
    }
    
    public function simpan() {
        $data = array(
            'jenis_vaksin' => $this->input->post('jenis_vaksin'),
            'tahun' => $this->input->post('tahun'),
            'status_perolehan' => $this->input->post('status_perolehan'),
            'bantuan_prov' => $this->input->post('bantuan_prov')
        );
        
        $result = $this->Vaksin_model->insert($data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data master vaksin berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data master vaksin');
        }
        
        redirect('vaksin');
    }
    
    public function hapus($id) {
        $result = $this->Vaksin_model->delete($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data master vaksin berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data master vaksin');
        }
        
        redirect('vaksin');
    }
    
    public function update() {
        $id = $this->input->post('id_vaksin');
        $data = array(
            'jenis_vaksin' => $this->input->post('jenis_vaksin'),
            'tahun' => $this->input->post('tahun'),
            'status_perolehan' => $this->input->post('status_perolehan'),
            'bantuan_prov' => $this->input->post('bantuan_prov')
        );
        
        $result = $this->Vaksin_model->update($id, $data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data master vaksin berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data master vaksin');
        }
        
        redirect('vaksin');
    }
}