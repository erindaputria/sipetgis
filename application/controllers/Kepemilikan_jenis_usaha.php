<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kepemilikan_jenis_usaha extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Kepemilikan_jenis_usaha_model');
        $this->load->model('Pelaku_usaha_model');
        $this->load->library('session');
        $this->load->helper('security');
    }
    
    public function index() {
        $data['kepemilikan_jenis_usaha'] = $this->Kepemilikan_jenis_usaha_model->get_all_combined();
        $data['pelaku_usaha'] = $this->Pelaku_usaha_model->get_all();
        $this->load->view('admin/kepemilikan_jenis_usaha', $data);
    } 
    
    public function search_pelaku_usaha() {
        // Handle CSRF for AJAX
        if ($this->input->get('csrf_test_name')) {
            $this->security->csrf_verify();
        }
        
        $search = $this->input->get('q');
        
        if (empty($search) || strlen($search) < 2) {
            echo json_encode(['results' => []]);
            return;
        }
        
        $this->db->select('nik, nama');
        $this->db->from('pelaku_usaha');
        $this->db->group_start();
        $this->db->like('nama', $search);
        $this->db->or_like('nik', $search);
        $this->db->group_end();
        $this->db->limit(20);
        $query = $this->db->get();
        $result = $query->result();
        
        $data = [];
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->nik,
                'text' => $row->nama . ' - ' . $row->nik,
                'nik' => $row->nik,
                'nama' => $row->nama
            ];
        }
        
        echo json_encode(['results' => $data]);
    }
    
    public function get_csrf() {
        $this->output->set_content_type('application/json');
        echo json_encode([
            'csrf_token' => $this->security->get_csrf_hash()
        ]);
    }
    
    public function simpan() { 
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('nik', 'NIK', 'required|min_length[15]|max_length[20]');
        $this->form_validation->set_rules('nama_peternak', 'Nama Pelaku Usaha', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('jenis_usaha', 'Jenis Usaha', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect('kepemilikan_jenis_usaha');
        }
        
        if ($this->Kepemilikan_jenis_usaha_model->check_exists_by_nik($this->input->post('nik'))) {
            $this->session->set_flashdata('error', 'Data dengan NIK ini sudah memiliki kepemilikan usaha!');
            redirect('kepemilikan_jenis_usaha');
        }
        
        $data = array(
            'nik' => $this->input->post('nik'),
            'nama_peternak' => $this->input->post('nama_peternak'),
            'jenis_usaha' => $this->input->post('jenis_usaha'),
            'jumlah' => $this->input->post('jumlah'),
            'alamat' => $this->input->post('alamat'),
            'kecamatan' => $this->input->post('kecamatan'),
            'kelurahan' => $this->input->post('kelurahan'),
            'rw' => $this->input->post('rw'),
            'rt' => $this->input->post('rt'),
            'gis_lat' => $this->input->post('gis_lat'),
            'gis_long' => $this->input->post('gis_long')
        );
        
        $result = $this->Kepemilikan_jenis_usaha_model->insert($data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data kepemilikan jenis usaha berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data kepemilikan jenis usaha');
        }
        
        redirect('kepemilikan_jenis_usaha');
    }
    
    public function update() {
        $id = $this->input->post('id');
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('nik', 'NIK', 'required|min_length[15]|max_length[20]');
        $this->form_validation->set_rules('nama_peternak', 'Nama Pelaku Usaha', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('jenis_usaha', 'Jenis Usaha', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect('kepemilikan_jenis_usaha');
        }
        
        $data = array(
            'nik' => $this->input->post('nik'),
            'nama_peternak' => $this->input->post('nama_peternak'),
            'jenis_usaha' => $this->input->post('jenis_usaha'),
            'jumlah' => $this->input->post('jumlah'),
            'alamat' => $this->input->post('alamat'),
            'kecamatan' => $this->input->post('kecamatan'),
            'kelurahan' => $this->input->post('kelurahan'),
            'rw' => $this->input->post('rw'),
            'rt' => $this->input->post('rt'),
            'gis_lat' => $this->input->post('gis_lat'),
            'gis_long' => $this->input->post('gis_long')
        );
        
        $result = $this->Kepemilikan_jenis_usaha_model->update($id, $data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data kepemilikan jenis usaha berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data kepemilikan jenis usaha');
        }
        
        redirect('kepemilikan_jenis_usaha');
    } 
    
    public function hapus($id) {
        $result = $this->Kepemilikan_jenis_usaha_model->delete($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data kepemilikan jenis usaha berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data kepemilikan jenis usaha');
        }
        
        redirect('kepemilikan_jenis_usaha');
    }
}
?>