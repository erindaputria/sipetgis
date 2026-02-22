<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vaksinasi extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Vaksinasi_Model');
        $this->load->library('session');
    }
    
    public function index() {
        $data['vaksinasi'] = $this->Vaksinasi_Model->get_all();
        $data['title'] = 'Master Data Vaksinasi';
        
        // Langsung load view vaksinasi tanpa templates
        $this->load->view('admin/vaksinasi', $data);
    }
    
    public function simpan() {
        $data = array(
            'nama_vaksin' => $this->input->post('nama_vaksin'),
            'tahun' => $this->input->post('tahun'),
            'status_perolehan' => $this->input->post('status_perolehan'),
            'bantuan_prov' => $this->input->post('bantuan_prov')
        );
        
        $result = $this->Vaksinasi_Model->insert($data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data vaksinasi berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data vaksinasi');
        }
        
        redirect('vaksinasi');
    }
    
    public function hapus($id) {
        $result = $this->Vaksinasi_Model->delete($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data vaksinasi berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data vaksinasi');
        }
        
        redirect('vaksinasi');
    }
    
    public function update() {
        $id = $this->input->post('id_vaksin');
        $data = array(
            'nama_vaksin' => $this->input->post('nama_vaksin'),
            'tahun' => $this->input->post('tahun'),
            'status_perolehan' => $this->input->post('status_perolehan'),
            'bantuan_prov' => $this->input->post('bantuan_prov')
        );
        
        $result = $this->Vaksinasi_Model->update($id, $data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data vaksinasi berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data vaksinasi');
        }
        
        redirect('vaksinasi');
    }
}