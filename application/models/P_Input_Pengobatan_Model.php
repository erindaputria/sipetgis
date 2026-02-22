<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Pengobatan_Model extends CI_Model {
    
    protected $table = 'input_pengobatan';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Save single pengobatan record
     */
    public function save_pengobatan($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    /**
     * Get pengobatan by kecamatan (untuk petugas)
     */
    public function get_pengobatan_by_kecamatan($kecamatan) {
        if (empty($kecamatan)) {
            return array();
        }
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->order_by('tanggal_pengobatan', 'DESC');
        // Hapus order by id_obat karena kolomnya tidak ada
        // $this->db->order_by('id_obat', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get all pengobatan (untuk admin)
     */
    public function get_all_pengobatan() {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('tanggal_pengobatan', 'DESC');
        // Hapus order by id_obat karena kolomnya tidak ada
        // $this->db->order_by('id_obat', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get pengobatan by ID
     * PERHATIAN: Jika tidak ada kolom id, method ini perlu disesuaikan
     * Mungkin menggunakan kombinasi field lain untuk identifikasi unik
     */
    public function get_pengobatan_by_id($id) {
        // Jika tidak ada kolom id, kita perlu menggunakan field lain
        // Misalnya menggunakan kombinasi nama_peternak + tanggal + komoditas
        // Atau tambahkan kolom id kembali ke database
        
        // Untuk sementara, kembalikan array kosong
        return array();
    }
    
    /**
     * Get by periode (tahun)
     */
    public function get_by_periode($tahun, $kecamatan) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->where("YEAR(tanggal_pengobatan)", $tahun);
        $this->db->order_by('tanggal_pengobatan', 'DESC');
        // Hapus order by id_obat karena kolomnya tidak ada
        // $this->db->order_by('id_obat', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Delete pengobatan
     * PERHATIAN: Jika tidak ada kolom id, method ini perlu disesuaikan
     */
    public function delete_pengobatan($id) {
        // Jika tidak ada kolom id, kita tidak bisa menghapus berdasarkan id
        // Kembalikan false untuk sementara
        return false;
    }

    /**
     * Count all pengobatan data by kecamatan
     */
    public function count_all($kecamatan) {
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        return $this->db->count_all_results();
    }

    /**
     * Sum total jumlah ternak yang diobati by kecamatan 
     */
    public function sum_jumlah($kecamatan) {
        $this->db->select('SUM(jumlah) as total');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $result = $this->db->get()->row();
        return $result->total ? (int)$result->total : 0;
    }
    
    /**
     * Get distinct komoditas by kecamatan
     */
    public function get_distinct_komoditas($kecamatan) {
        $this->db->distinct();
        $this->db->select('komoditas_ternak');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->where('komoditas_ternak IS NOT NULL');
        $this->db->where('komoditas_ternak !=', '');
        $this->db->order_by('komoditas_ternak', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Cek apakah NIK sudah pernah digunakan (opsional untuk notifikasi)
     */
    public function cek_nik_exists($nik, $kecamatan) {
        $this->db->from($this->table);
        $this->db->where('nik', $nik);
        $this->db->where('kecamatan', $kecamatan);
        return $this->db->count_all_results();
    }
}