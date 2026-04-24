<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_Penjual_Obat_Model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_penjual_obat()
    {
        $this->db->select('
            id_penjual as id,
            nama_toko,
            nama_pemilik as pemilik,
            nik,
            nama_petugas,
            tanggal_input,
            keterangan,
            nib,
            alamat,
            kecamatan,
            kelurahan,
            rt,
            rw,
            latitude,
            longitude,
            telp as telepon,
            dagangan,
            foto_toko,
            surat_ijin as status,
            obat_hewan,
            kategori_obat,
            jenis_obat,
            created_at,
            updated_at
        ');
        $this->db->from('penjual');
        $this->db->where('dagangan', 'Obat');
        $this->db->order_by('tanggal_input', 'DESC');
        $this->db->order_by('id_penjual', 'DESC');
        
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_penjual_obat_by_kecamatan($kecamatan)
    {
        $this->db->select('
            id_penjual as id,
            nama_toko,
            nama_pemilik as pemilik,
            nik,
            nama_petugas,
            tanggal_input,
            keterangan,
            nib,
            alamat,
            kecamatan,
            kelurahan,
            rt,
            rw,
            latitude,
            longitude,
            telp as telepon,
            dagangan,
            foto_toko,
            surat_ijin as status,
            obat_hewan,
            kategori_obat,
            jenis_obat,
            created_at,
            updated_at
        ');
        $this->db->from('penjual');
        $this->db->where('dagangan', 'Obat');
        $this->db->where('kecamatan', $kecamatan);
        $this->db->order_by('tanggal_input', 'DESC');
        $this->db->order_by('id_penjual', 'DESC');
        
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_penjual_obat_by_id($id)
    {
        $this->db->select('
            id_penjual as id,
            nama_toko,
            nama_pemilik as pemilik,
            nik,
            nama_petugas,
            tanggal_input,
            keterangan,
            nib,
            alamat,
            kecamatan,
            kelurahan,
            rt,
            rw,
            latitude,
            longitude,
            telp as telepon,
            dagangan,
            foto_toko,
            surat_ijin as status,
            obat_hewan,
            kategori_obat,
            jenis_obat,
            created_at,
            updated_at
        ');
        $this->db->from('penjual');
        $this->db->where('dagangan', 'Obat');
        $this->db->where('id_penjual', $id);
        
        $query = $this->db->get();
        return $query->row_array();
    }

    public function delete_penjual_obat($id)
    {
        $this->db->trans_start();
        
        // Ambil data foto untuk dihapus
        $this->db->select('foto_toko');
        $this->db->from('penjual');
        $this->db->where('id_penjual', $id);
        $this->db->where('dagangan', 'Obat');
        $data = $this->db->get()->row_array();
        
        if ($data && !empty($data['foto_toko'])) {
            $file_path = FCPATH . 'uploads/penjual/' . $data['foto_toko'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        
        $this->db->where('id_penjual', $id);
        $this->db->where('dagangan', 'Obat');
        $this->db->delete('penjual');
        
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }
    
    public function update_penjual_obat($id, $data)
    {
        $this->db->where('id_penjual', $id);
        $this->db->where('dagangan', 'Obat');
        return $this->db->update('penjual', $data);
    }
    
    public function get_distinct_kecamatan()
    { 
        $this->db->distinct();
        $this->db->select('kecamatan');
        $this->db->from('penjual');
        $this->db->where('dagangan', 'Obat');
        $this->db->where('kecamatan IS NOT NULL');
        $this->db->where('kecamatan !=', '');
        $this->db->order_by('kecamatan', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    public function get_distinct_status()
    {
        $this->db->distinct();
        $this->db->select('surat_ijin as status');
        $this->db->from('penjual');
        $this->db->where('dagangan', 'Obat');
        $this->db->where('surat_ijin IS NOT NULL');
        $this->db->order_by('surat_ijin', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    public function get_distinct_kategori_obat()
    {
        $this->db->distinct();
        $this->db->select('kategori_obat');
        $this->db->from('penjual');
        $this->db->where('dagangan', 'Obat');
        $this->db->where('kategori_obat IS NOT NULL');
        $this->db->where('kategori_obat !=', '');
        $this->db->order_by('kategori_obat', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
}