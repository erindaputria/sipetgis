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
        $this->db->select('
            id,
            nama_peternak,
            nik, 
            tanggal_pengobatan,
            keterangan,
            kecamatan,
            kelurahan,
            alamat,
            rt,
            rw,
            latitude,
            longitude,
            foto_pengobatan,
            nama_petugas,
            telp,
            bantuan_prov,
            komoditas_ternak,
            gejala_klinis,
            jenis_pengobatan,
            jumlah
        ');
        $this->db->from('input_pengobatan');
        $this->db->order_by('tanggal_pengobatan', 'DESC');
        $this->db->order_by('id', 'DESC');
        
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_pengobatan_by_kecamatan($kecamatan)
    {
        $this->db->select('
            id,
            nama_peternak,
            nik,
            tanggal_pengobatan,
            keterangan,
            kecamatan,
            kelurahan,
            alamat,
            rt,
            rw,
            latitude,
            longitude,
            foto_pengobatan,
            nama_petugas,
            telp,
            bantuan_prov,
            komoditas_ternak,
            gejala_klinis,
            jenis_pengobatan,
            jumlah
        ');
        $this->db->from('input_pengobatan');
        $this->db->where('kecamatan', $kecamatan);
        $this->db->order_by('tanggal_pengobatan', 'DESC');
        $this->db->order_by('id', 'DESC');
        
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_pengobatan_by_id($id)
    {
        $this->db->select('
            id,
            nama_peternak,
            nik,
            tanggal_pengobatan,
            keterangan,
            kecamatan,
            kelurahan,
            alamat,
            rt,
            rw,
            latitude,
            longitude,
            foto_pengobatan,
            nama_petugas,
            telp,
            bantuan_prov,
            komoditas_ternak,
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
        
        $this->db->where('id', $id);
        $this->db->delete('input_pengobatan');
        
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }
    
    public function update_pengobatan($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('input_pengobatan', $data);
    }
    
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