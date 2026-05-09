<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_history_vaksinasi_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_vaksinasi()
    {
        $this->db->select(' 
            id_vaksinasi as id,
            nama_peternak,
            nik,
            tanggal_vaksinasi,
            keterangan,
            kecamatan,
            kelurahan,
            alamat,
            rt,
            rw,
            latitude,
            longitude,
            foto_vaksinasi,
            nama_petugas,
            telp,
            bantuan_prov,
            komoditas_ternak,
            jenis_vaksinasi,
            dosis,
            jumlah
        ');
        $this->db->from('input_vaksinasi');
        $this->db->order_by('tanggal_vaksinasi', 'DESC');
        $this->db->order_by('id_vaksinasi', 'DESC');
        
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_vaksinasi_by_kecamatan($kecamatan)
    {
        $this->db->select('
            id_vaksinasi as id,
            nama_peternak,
            nik,
            tanggal_vaksinasi,
            keterangan,
            kecamatan,
            kelurahan,
            alamat,
            rt,
            rw,
            latitude,
            longitude,
            foto_vaksinasi,
            nama_petugas,
            telp,
            bantuan_prov,
            komoditas_ternak,
            jenis_vaksinasi,
            dosis,
            jumlah
        ');
        $this->db->from('input_vaksinasi');
        $this->db->where('kecamatan', $kecamatan);
        $this->db->order_by('tanggal_vaksinasi', 'DESC');
        $this->db->order_by('id_vaksinasi', 'DESC');
        
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_vaksinasi_by_id($id)
    {
        $this->db->select('
            id_vaksinasi as id,
            nama_peternak,
            nik,
            tanggal_vaksinasi,
            keterangan,
            kecamatan,
            kelurahan,
            alamat,
            rt,
            rw,
            latitude,
            longitude,
            foto_vaksinasi,
            nama_petugas,
            telp,
            bantuan_prov,
            komoditas_ternak,
            jenis_vaksinasi,
            dosis,
            jumlah
        ');
        $this->db->from('input_vaksinasi');
        $this->db->where('id_vaksinasi', $id);
        
        $query = $this->db->get();
        return $query->row_array();
    }

    public function delete_vaksinasi($id)
    {
        $this->db->trans_start();
        
        // Ambil data foto untuk dihapus
        $this->db->select('foto_vaksinasi');
        $this->db->from('input_vaksinasi');
        $this->db->where('id_vaksinasi', $id);
        $data = $this->db->get()->row_array();
        
        if ($data && !empty($data['foto_vaksinasi'])) {
            $file_path = FCPATH . 'uploads/vaksinasi/' . $data['foto_vaksinasi'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        
        $this->db->where('id_vaksinasi', $id);
        $this->db->delete('input_vaksinasi');
        
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }
    
    public function update_vaksinasi($id, $data)
    {
        $this->db->where('id_vaksinasi', $id);
        return $this->db->update('input_vaksinasi', $data);
    }
    
    public function get_distinct_komoditas()
    {
        $this->db->distinct();
        $this->db->select('komoditas_ternak');
        $this->db->from('input_vaksinasi');
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
        $this->db->from('input_vaksinasi');
        $this->db->where('kecamatan IS NOT NULL');
        $this->db->where('kecamatan !=', '');
        $this->db->order_by('kecamatan', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
}