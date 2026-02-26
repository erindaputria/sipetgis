<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Jenis_Usaha_Model extends CI_Model {
    
    protected $table = 'input_jenis_usaha';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function save_jenis_usaha($data) {
        return $this->db->insert($this->table, $data);
    }
    
    public function get_jenis_usaha_by_kecamatan($kecamatan) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->order_by('tanggal_input', 'DESC');
        return $this->db->get()->result_array();
    }
    
    public function get_all_jenis_usaha($kecamatan = null) {
        $this->db->select('*');
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $this->db->order_by('tanggal_input', 'DESC');
        return $this->db->get()->result_array();
    }
    
    public function get_by_periode($tahun, $kecamatan) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->where("YEAR(tanggal_input)", $tahun);
        $this->db->order_by('tanggal_input', 'DESC');
        return $this->db->get()->result_array();
    }
    
    public function count_all($kecamatan = null) {
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        return $this->db->count_all_results();
    }
    
    // ============ METHOD UNTUK DASHBOARD ============
    
    /**
     * Count unique pemilik (menggunakan nama_peternak)
     */
    public function count_unique_pemilik($kecamatan = null) {
        $this->db->select('COUNT(DISTINCT nama_peternak) as total');
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['total'] ?? 0;
    }
    
    /**
     * Sum total jumlah (ternak)
     */
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
    
    /**
     * ALIAS untuk sum_jumlah - mendapatkan total ternak saat ini
     */
    public function get_total_ternak_saat_ini($kecamatan = null) {
        return $this->sum_jumlah($kecamatan);
    }
    
    /**
     * Get statistik per komoditas ternak (sebelumnya jenis_usaha)
     * Menggunakan kolom komoditas_ternak, bukan jenis_usaha
     */
    public function get_statistik_jenis_usaha($kecamatan = null) {
        $this->db->select('komoditas_ternak, SUM(jumlah) as total_jumlah');
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
                'jenis_usaha' => $row['komoditas_ternak'], // Ubah key menjadi jenis_usaha untuk kompatibilitas
                'total_jumlah' => $row['total_jumlah'] ?? 0
            );
        }
        
        return $statistik;
    }
    
    /**
     * Get statistik per kelurahan
     */
    public function get_statistik_per_kelurahan($kecamatan = null) {
        $this->db->select('kelurahan, COUNT(*) as total_usaha, SUM(jumlah) as total_jumlah');
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
                'total_usaha' => $row['total_usaha'],
                'total_jumlah' => $row['total_jumlah'] ?? 0
            );
        }
        
        return $statistik;
    }
    
    /**
     * Get distinct komoditas ternak (untuk filter)
     */
    public function get_distinct_jenis_usaha($kecamatan) {
        $this->db->distinct();
        $this->db->select('komoditas_ternak');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->where('komoditas_ternak IS NOT NULL');
        $this->db->where('komoditas_ternak !=', '');
        $this->db->order_by('komoditas_ternak', 'ASC');
        return $this->db->get()->result_array();
    }
    
    /**
     * Check if table exists
     */
    public function check_table_exists() {
        return $this->db->table_exists($this->table);
    }
}