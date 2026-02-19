<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Vaksinasi_Model extends CI_Model {
    
    protected $table = 'input_vaksinasi';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_all_vaksinasi($kecamatan = null) {
        $this->db->select('*');
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $this->db->order_by('tanggal_vaksinasi', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_vaksinasi_for_table() {
        $this->db->select('nama_peternak, komoditas_ternak, jenis_vaksinasi, jumlah, tanggal_vaksinasi');
        $this->db->from($this->table);
        $this->db->order_by('tanggal_vaksinasi', 'DESC');
        $this->db->limit(10);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_vaksinasi_by_kecamatan($kecamatan) {
        $this->db->select('nama_peternak, komoditas_ternak, jenis_vaksinasi, jumlah, tanggal_vaksinasi');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->order_by('tanggal_vaksinasi', 'DESC');
        $this->db->limit(10);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function save_vaksinasi($data) {
        return $this->db->insert($this->table, $data);
    }
    
    public function count_all($kecamatan = null) {
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        return $this->db->count_all_results($this->table);
    }
    
    public function sum_jumlah($kecamatan = null) {
        $this->db->select('SUM(jumlah) as total');
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['total'] ?? 0;
    }
    
    public function get_statistik_per_bulan($tahun = null, $kecamatan = null) {
        $tahun = $tahun ?: date('Y');
        
        $this->db->select("MONTH(tanggal_vaksinasi) as bulan, COUNT(*) as total_kasus, SUM(jumlah) as total_ternak");
        $this->db->from($this->table);
        $this->db->where("YEAR(tanggal_vaksinasi)", $tahun);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $this->db->group_by("MONTH(tanggal_vaksinasi)");
        $this->db->order_by("bulan", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_statistik_per_komoditas($kecamatan = null) {
        $this->db->select("komoditas_ternak, COUNT(*) as total_kasus, SUM(jumlah) as total_ternak");
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $this->db->group_by("komoditas_ternak");
        $this->db->order_by("total_kasus", "DESC");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_statistik_per_kelurahan($kecamatan = null) {
        $this->db->select('kelurahan, COUNT(*) as total_kasus, SUM(jumlah) as total_ternak');
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $this->db->group_by('kelurahan');
        $this->db->order_by('total_kasus', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
}