<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_Usaha_Model extends CI_Model {
    
    private $table = 'jenis_usaha';
    private $table_input = 'input_jenis_usaha';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    // Menggabungkan data dari tabel jenis_usaha dan input_jenis_usaha
    public function get_all_combined() {
        $sql = "
            SELECT 
                'master' as source,
                id,
                nama_peternak,
                jenis_usaha,
                jumlah,
                alamat,
                kecamatan,
                NULL as tanggal_input
            FROM {$this->table}
            
            UNION ALL
            
            SELECT 
                'input' as source,
                NULL as id,
                nama_peternak,
                jenis_usaha,
                jumlah,
                alamat,
                kecamatan,
                tanggal_input
            FROM {$this->table_input}
            
            ORDER BY nama_peternak ASC
        ";
        
        return $this->db->query($sql)->result();
    }
    
    // Untuk mengambil data dari tabel jenis_usaha saja (master admin)
    public function get_all() {
        $this->db->order_by('nama_peternak', 'ASC');
        return $this->db->get($this->table)->result();
    }
    
    // Untuk mengambil data dari input_jenis_usaha saja (data petugas)
    public function get_all_from_input() {
        $this->db->select('NULL as id, nama_peternak, jenis_usaha, jumlah, alamat, kecamatan, tanggal_input');
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
    
    // Untuk filter dari kedua tabel berdasarkan kecamatan
    public function get_combined_by_kecamatan($kecamatan) {
        $sql = "
            SELECT 
                'master' as source,
                id,
                nama_peternak,
                jenis_usaha,
                jumlah,
                alamat,
                kecamatan,
                NULL as tanggal_input
            FROM {$this->table}
            WHERE kecamatan = ?
            
            UNION ALL
            
            SELECT 
                'input' as source,
                NULL as id,
                nama_peternak,
                jenis_usaha,
                jumlah,
                alamat,
                kecamatan,
                tanggal_input
            FROM {$this->table_input}
            WHERE kecamatan = ?
            
            ORDER BY nama_peternak ASC
        ";
        
        return $this->db->query($sql, array($kecamatan, $kecamatan))->result();
    }
}