<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_Pengobatan_Model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_pengobatan()
    {
        // Ambil semua data dari input_pengobatan
        $this->db->select('
            id,
            nama_peternak,
            nik,
            tanggal_pengobatan,
            keterangan,
            kecamatan,
            kelurahan,
            rt,
            rw,
            latitude,
            longitude,
            foto_pengobatan,
            nama_petugas,
            telp,
            bantuan_prov,
            komoditas_ternak,
            jenis_kelamin,
            gejala_klinis,
            jenis_pengobatan,
            jumlah
        ');
        $this->db->from('input_pengobatan');
        $this->db->order_by('tanggal_pengobatan', 'DESC');
        $this->db->order_by('id', 'DESC');
        
        $query = $this->db->get();
        $result = $query->result_array();
        
        // Log untuk debug
        log_message('debug', 'Data_Pengobatan_Model::get_all_pengobatan() - Jumlah data: ' . count($result));
        
        return $result;
    }

    public function get_pengobatan_by_kecamatan($kecamatan)
    {
        // Ambil data berdasarkan kecamatan
        $this->db->select('
            id,
            nama_peternak,
            nik,
            tanggal_pengobatan,
            keterangan,
            kecamatan,
            kelurahan,
            rt,
            rw,
            latitude,
            longitude,
            foto_pengobatan,
            nama_petugas,
            telp,
            bantuan_prov,
            komoditas_ternak,
            jenis_kelamin,
            gejala_klinis,
            jenis_pengobatan,
            jumlah
        ');
        $this->db->from('input_pengobatan');
        $this->db->where('kecamatan', $kecamatan);
        $this->db->order_by('tanggal_pengobatan', 'DESC');
        $this->db->order_by('id', 'DESC');
        
        $query = $this->db->get();
        $result = $query->result_array();
        
        log_message('debug', 'Data_Pengobatan_Model::get_pengobatan_by_kecamatan(' . $kecamatan . ') - Jumlah data: ' . count($result));
        
        return $result;
    }

    public function get_pengobatan_by_id($id)
    {
        // Ambil data berdasarkan ID
        $this->db->select('
            id,
            nama_peternak,
            nik,
            tanggal_pengobatan,
            keterangan,
            kecamatan,
            kelurahan,
            rt,
            rw,
            latitude,
            longitude,
            foto_pengobatan,
            nama_petugas,
            telp,
            bantuan_prov,
            komoditas_ternak,
            jenis_kelamin,
            gejala_klinis,
            jenis_pengobatan,
            jumlah
        ');
        $this->db->from('input_pengobatan');
        $this->db->where('id', $id);
        
        $query = $this->db->get();
        return $query->row_array();
    }

    public function delete_pengobatan($id)
    {
        // Mulai transaksi
        $this->db->trans_start();
        
        // Ambil data foto untuk dihapus
        $this->db->select('foto_pengobatan');
        $this->db->from('input_pengobatan');
        $this->db->where('id', $id);
        $data = $this->db->get()->row_array();
        
        if ($data && !empty($data['foto_pengobatan'])) {
            $file_path = FCPATH . 'uploads/pengobatan/' . $data['foto_pengobatan'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        
        // Hapus data
        $this->db->where('id', $id);
        $this->db->delete('input_pengobatan');
        
        // Selesaikan transaksi
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }
    
    /**
     * Get distinct komoditas untuk filter
     */
    public function get_distinct_komoditas()
    {
        $this->db->distinct();
        $this->db->select('komoditas_ternak');
        $this->db->from('input_pengobatan');
        $this->db->where('komoditas_ternak IS NOT NULL');
        $this->db->where('komoditas_ternak !=', '');
        $this->db->order_by('komoditas_ternak', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get distinct kecamatan untuk filter
     */
    public function get_distinct_kecamatan()
    {
        $this->db->distinct();
        $this->db->select('kecamatan');
        $this->db->from('input_pengobatan');
        $this->db->where('kecamatan IS NOT NULL');
        $this->db->where('kecamatan !=', '');
        $this->db->order_by('kecamatan', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
}