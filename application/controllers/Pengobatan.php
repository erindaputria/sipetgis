<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengobatan extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Pengobatan_Model');
        $this->load->library('session');
    }
    
    public function index() {
        $data['pengobatan'] = $this->Pengobatan_Model->get_all();
        $this->load->view('pengobatan', $data); // Pastikan nama view sesuai
    }
    
    public function simpan() {
        // Debug: lihat apa yang diterima dari form
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // die();
        
        $data = array(
            'nama_pengobatan' => $this->input->post('nama_pengobatan'),
            'jenis_obat' => $this->input->post('jenis_obat'), // Pastikan nama sama dengan form
            'tahun' => $this->input->post('tahun'), // Pastikan nama sama dengan form
            'bantuan_prov' => $this->input->post('bantuan_prov'),
            'keterangan' => $this->input->post('keterangan')
        );
        
        // Debug: lihat data yang akan disimpan
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // die();
        
        $result = $this->Pengobatan_Model->insert($data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data pengobatan berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data pengobatan');
        }
        
        redirect('pengobatan');
    }
    
    public function update() {
        $id = $this->input->post('id_obat');
        
        $data = array(
            'nama_pengobatan' => $this->input->post('nama_pengobatan'),
            'jenis_obat' => $this->input->post('jenis_obat'),
            'tahun' => $this->input->post('tahun'),
            'bantuan_prov' => $this->input->post('bantuan_prov'),
            'keterangan' => $this->input->post('keterangan')
        );
        
        $result = $this->Pengobatan_Model->update($id, $data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data pengobatan berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data pengobatan');
        }
        
        redirect('pengobatan');
    }
    
    public function hapus($id) {
        $result = $this->Pengobatan_Model->delete($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data pengobatan berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data pengobatan');
        }
        
        redirect('pengobatan');
    }
}