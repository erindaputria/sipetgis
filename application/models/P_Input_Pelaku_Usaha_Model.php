<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Pelaku_Usaha_Model extends CI_Model {
    
    protected $table = 'input_pelaku_usaha';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_all_pelaku_usaha($kecamatan = null) {
        $this->db->select('*');
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $this->db->order_by('tanggal_input', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_pelaku_usaha_for_table() {
        $this->db->select('nama_peternak, komoditas_ternak, jumlah_tambah, jumlah_kurang, tanggal_input');
        $this->db->from($this->table);
        $this->db->order_by('tanggal_input', 'DESC');
        $this->db->limit(10);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_pelaku_usaha_by_kecamatan($kecamatan) {
        $this->db->select('nama_peternak, komoditas_ternak, jumlah_tambah, jumlah_kurang, tanggal_input');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->order_by('tanggal_input', 'DESC');
        $this->db->limit(10);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function save_pelaku_usaha($data) {
        return $this->db->insert($this->table, $data);
    }
    
    public function check_table_exists() {
        return $this->db->table_exists($this->table);
    }
    
    public function count_unique_peternak($kecamatan = null) {
        $this->db->select('COUNT(DISTINCT nama_peternak) as total');
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['total'] ?? 0;
    }
    
    public function sum_tambah($kecamatan = null) {
        $this->db->select('SUM(jumlah_tambah) as total');
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['total'] ?? 0;
    }
    
    public function sum_kurang($kecamatan = null) {
        $this->db->select('SUM(jumlah_kurang) as total');
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['total'] ?? 0;
    }
    
    public function get_statistik_komoditas($kecamatan = null) {
        $this->db->select('komoditas_ternak, SUM(jumlah_tambah) as total_tambah, SUM(jumlah_kurang) as total_kurang');
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $this->db->group_by('komoditas_ternak');
        $query = $this->db->get();
        $result = $query->result_array();
        
        $statistik = [];
        foreach ($result as $row) {
            $statistik[] = array(
                'komoditas_ternak' => $row['komoditas_ternak'],
                'total_ternak' => ($row['total_tambah'] ?? 0) - ($row['total_kurang'] ?? 0)
            );
        }
        
        return $statistik;
    }
    
    public function get_statistik_per_kelurahan($kecamatan = null) {
        $this->db->select('kelurahan, COUNT(*) as total_peternak, SUM(jumlah_tambah) as total_tambah, SUM(jumlah_kurang) as total_kurang');
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $this->db->group_by('kelurahan');
        $query = $this->db->get();
        $result = $query->result_array();
        
        $statistik = [];
        foreach ($result as $row) {
            $statistik[] = array(
                'kelurahan' => $row['kelurahan'],
                'total_peternak' => $row['total_peternak'],
                'total_ternak' => ($row['total_tambah'] ?? 0) - ($row['total_kurang'] ?? 0)
            );
        }
        
        return $statistik;
    }
    
    public function get_total_ternak_saat_ini($kecamatan = null) {
        $total_tambah = $this->sum_tambah($kecamatan);
        $total_kurang = $this->sum_kurang($kecamatan);
        return $total_tambah - $total_kurang;
    }
}