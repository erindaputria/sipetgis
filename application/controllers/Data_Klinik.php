<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_klinik extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index()
    {
        $this->load->view('admin/data/data_klinik');
    }

    public function get_all_data()
    {
        header('Content-Type: application/json');
        
        // Query langsung tanpa model untuk test
        $query = $this->db->get('input_klinik_hewan');
        $data = $query->result_array();
        
        echo json_encode($data);
    }

    public function get_detail($id)
    {
        header('Content-Type: application/json');
        
        $this->db->where('id', $id);
        $query = $this->db->get('input_klinik_hewan');
        $data = $query->row_array();
        
        echo json_encode($data);
    }

    public function delete($id)
    {
        header('Content-Type: application/json');
        
        $this->db->where('id', $id);
        $result = $this->db->delete('input_klinik_hewan');
        
        echo json_encode([
            'status' => $result ? 'success' : 'error',
            'message' => $result ? 'Data berhasil dihapus' : 'Gagal menghapus data'
        ]);
    }

    public function update($id)
    {
        header('Content-Type: application/json');
        
        $update_data = [
            'nama_klinik' => $this->input->post('nama_klinik'),
            'kecamatan' => $this->input->post('kecamatan'),
            'kelurahan' => $this->input->post('kelurahan'),
            'alamat' => $this->input->post('alamat'),
            'rt' => $this->input->post('rt'),
            'rw' => $this->input->post('rw'),
            'telp' => $this->input->post('telepon'),
            'latitude' => $this->input->post('latitude'),
            'longitude' => $this->input->post('longitude'),
            'jumlah_dokter' => $this->input->post('jumlah_dokter'),
            'jenis_layanan' => $this->input->post('jenis_layanan'),
            'surat_ijin' => $this->input->post('surat_ijin'),
            'keterangan' => $this->input->post('keterangan')
        ];
        
        $this->db->where('id', $id);
        $result = $this->db->update('input_klinik_hewan', $update_data);
        
        echo json_encode([
            'status' => $result ? 'success' : 'error',
            'message' => $result ? 'Data berhasil diperbarui' : 'Gagal memperbarui data'
        ]);
    }
}
?>