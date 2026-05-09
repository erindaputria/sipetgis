<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kepemilikan_jenis_usaha_model extends CI_Model {
    
    private $table = 'kepemilikan_jenis_usaha';
    
    public function __construct() {
        parent::__construct();
        $this->load->database(); 
    }
    
    public function get_all_combined() {
        $sql = "
            SELECT  
                'master' as source,
                id,
                nik,
                nama_peternak,
                jenis_usaha,
                jumlah,
                alamat,
                kecamatan,
                kelurahan,
                rw,
                rt,
                gis_lat,
                gis_long,
                NULL as tanggal_input
            FROM {$this->table}
            ORDER BY nama_peternak ASC
        ";
        
        return $this->db->query($sql)->result();
    }
    
    public function get_all() {
        $this->db->order_by('nama_peternak', 'ASC');
        return $this->db->get($this->table)->result();
    }
    
    public function get_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row();
    }
    
    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }
    
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
    
    public function get_by_kecamatan($kecamatan) {
        $this->db->where('kecamatan', $kecamatan);
        $this->db->order_by('nama_peternak', 'ASC');
        return $this->db->get($this->table)->result();
    }
    
    // HAPUS pengecekan NIK (biar 1 NIK bisa punya banyak usaha)
    public function check_exists_by_nik($nik) {
        return false;
    }
}
?>