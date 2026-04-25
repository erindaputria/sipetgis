<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_klinik_model extends CI_Model {

    public function get_all_data()
    {
        // Debug: cek apakah model bisa diload
        if (!class_exists('Data_klinik_model')) {
            echo json_encode(['error' => 'Model tidak ditemukan']);
            return;
        }
        
        // Debug: cek apakah database terhubung
        if (!$this->db->conn_id) {
            echo json_encode(['error' => 'Database tidak terhubung']);
            return;
        }
        
        // Debug: cek apakah tabel ada
        if (!$this->db->table_exists('input_klinik_hewan')) {
            echo json_encode(['error' => 'Tabel input_klinik_hewan tidak ditemukan']);
            return;
        }
        
        $data = $this->Data_klinik_model->get_all_klinik();
        echo json_encode($data);
    }

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_klinik()
    {
        $this->db->select('
            id,
            nama_klinik,
            nama_pemilik,
            keterangan,
            alamat,
            kecamatan,
            kelurahan,
            rt,
            rw,
            latitude,
            longitude,
            telp,
            jumlah_dokter,
            jenis_layanan,
            foto_klinik,
            surat_ijin,
            sertifikat_standar,
            nib,
            created_at,
            updated_at
        ');
        $this->db->from('input_klinik_hewan');
        $this->db->order_by('created_at', 'DESC');
        $this->db->order_by('id', 'DESC');
        
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_klinik_by_kecamatan($kecamatan)
    {
        $this->db->select('
            id,
            nama_klinik,
            nama_pemilik,
            keterangan,
            alamat,
            kecamatan,
            kelurahan,
            rt,
            rw,
            latitude,
            longitude,
            telp,
            jumlah_dokter,
            jenis_layanan,
            foto_klinik,
            surat_ijin,
            sertifikat_standar,
            nib,
            created_at,
            updated_at
        ');
        $this->db->from('input_klinik_hewan');
        $this->db->where('kecamatan', $kecamatan);
        $this->db->order_by('created_at', 'DESC');
        $this->db->order_by('id', 'DESC');
        
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_klinik_by_id($id)
    {
        $this->db->select('
            id,
            nama_klinik,
            nama_pemilik,
            keterangan,
            alamat,
            kecamatan,
            kelurahan,
            rt,
            rw,
            latitude,
            longitude,
            telp,
            jumlah_dokter,
            jenis_layanan,
            foto_klinik,
            surat_ijin,
            sertifikat_standar,
            nib,
            created_at,
            updated_at
        ');
        $this->db->from('input_klinik_hewan');
        $this->db->where('id', $id);
        
        $query = $this->db->get();
        return $query->row_array();
    }

    public function delete_klinik($id)
    {
        $this->db->trans_start();
        
        // Ambil data foto untuk dihapus
        $this->db->select('foto_klinik');
        $this->db->from('input_klinik_hewan');
        $this->db->where('id', $id);
        $data = $this->db->get()->row_array();
        
        if ($data && !empty($data['foto_klinik'])) {
            $file_path = FCPATH . 'uploads/klinik/' . $data['foto_klinik'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        
        $this->db->where('id', $id);
        $this->db->delete('input_klinik_hewan');
        
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }
    
    public function update_klinik($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('input_klinik_hewan', $data);
    }
    
    public function get_distinct_kecamatan()
    { 
        $this->db->distinct();
        $this->db->select('kecamatan');
        $this->db->from('input_klinik_hewan');
        $this->db->where('kecamatan IS NOT NULL');
        $this->db->where('kecamatan !=', '');
        $this->db->order_by('kecamatan', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    public function get_distinct_ijin()
    {
        $this->db->distinct();
        $this->db->select('surat_ijin');
        $this->db->from('input_klinik_hewan');
        $this->db->where('surat_ijin IS NOT NULL');
        $this->db->order_by('surat_ijin', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    public function get_distinct_layanan()
    {
        $this->db->distinct();
        $this->db->select('jenis_layanan');
        $this->db->from('input_klinik_hewan');
        $this->db->where('jenis_layanan IS NOT NULL');
        $this->db->where('jenis_layanan !=', '');
        $this->db->order_by('jenis_layanan', 'ASC'); 
        $query = $this->db->get();
        
        return $query->result_array();
    }
}