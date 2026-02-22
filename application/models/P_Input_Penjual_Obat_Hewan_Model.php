<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Penjual_Obat_Hewan_Model extends CI_Model {
    
    protected $table = 'input_penjual_obat_hewan';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Save penjual obat record
     */
    public function save_penjual_obat($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    /**
     * Get penjual obat by kecamatan (untuk petugas)
     */
    public function get_penjual_obat_by_kecamatan($kecamatan) {
        if (empty($kecamatan)) {
            return array();
        }
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get all penjual obat (untuk admin)
     */
    public function get_all_penjual_obat() {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get by periode (tahun)
     */
    public function get_by_periode($tahun, $kecamatan) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->where("YEAR(created_at)", $tahun);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Count all penjual obat data by kecamatan
     */
    public function count_all($kecamatan) {
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        return $this->db->count_all_results();
    }
    
    /**
     * Get distinct kelurahan by kecamatan
     */
    public function get_distinct_kelurahan($kecamatan) {
        $this->db->distinct();
        $this->db->select('kelurahan');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->where('kelurahan IS NOT NULL');
        $this->db->where('kelurahan !=', '');
        $this->db->order_by('kelurahan', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get distinct kategori obat by kecamatan
     */
    public function get_distinct_kategori_obat($kecamatan) {
        $this->db->distinct();
        $this->db->select('kategori_obat');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->where('kategori_obat IS NOT NULL');
        $this->db->where('kategori_obat !=', '');
        $this->db->order_by('kategori_obat', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get distinct jenis obat by kecamatan
     */
    public function get_distinct_jenis_obat($kecamatan) {
        $this->db->distinct();
        $this->db->select('jenis_obat');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->where('jenis_obat IS NOT NULL');
        $this->db->where('jenis_obat !=', '');
        $this->db->order_by('jenis_obat', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
}