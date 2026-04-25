<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kepemilikan_jenis_usaha_model extends CI_Model {
    
    private $table = 'kepemilikan_jenis_usaha';
    private $table_input = 'input_kepemilikan_jenis_usaha';
    
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
            
            UNION ALL
            
            SELECT 
                'input' as source,
                NULL as id,
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
                tanggal_input
            FROM {$this->table_input}
            
            ORDER BY nama_peternak ASC
        ";
        
        return $this->db->query($sql)->result();
    }
    
    public function get_all() {
        $this->db->order_by('nama_peternak', 'ASC');
        return $this->db->get($this->table)->result();
    }
    
    public function get_all_from_input() {
        $this->db->select('NULL as id, nik, nama_peternak, jenis_usaha, jumlah, alamat, kecamatan, kelurahan, rw, rt, gis_lat, gis_long, tanggal_input');
        $this->db->from($this->table_input);
        $this->db->order_by('nama_peternak', 'ASC');
        return $this->db->get()->result();
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
    
    public function get_combined_by_kecamatan($kecamatan) {
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
            WHERE kecamatan = ?
            
            UNION ALL
            
            SELECT 
                'input' as source,
                NULL as id,
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
                tanggal_input
            FROM {$this->table_input}
            WHERE kecamatan = ?
            
            ORDER BY nama_peternak ASC
        ";
        
        return $this->db->query($sql, array($kecamatan, $kecamatan))->result();
    }
    
    public function check_exists_by_nik($nik) {
        $this->db->where('nik', $nik);
        return $this->db->get($this->table)->num_rows() > 0;
    }
}
?>