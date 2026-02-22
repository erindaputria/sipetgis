<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Penjual_Pakan_Model extends CI_Model {
    
    protected $table = 'penjual_pakan';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function save_penjual_pakan($data) {
        return $this->db->insert($this->table, $data);
    }
    
    public function get_penjual_pakan_by_kecamatan($kecamatan) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result_array();
    }
    
    public function get_all_penjual_pakan($kecamatan = null) {
        $this->db->select('*');
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result_array();
    }
    
    public function get_by_periode($tahun, $kecamatan) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->where("YEAR(created_at)", $tahun);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result_array();
    }
    
    public function count_all($kecamatan = null) {
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        return $this->db->count_all_results();
    }
    
    public function count_surat_ijin($kecamatan = null, $status = 'Y') {
        $this->db->from($this->table);
        $this->db->where('surat_ijin', $status);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        return $this->db->count_all_results();
    }
    
    public function get_statistik_per_kelurahan($kecamatan = null) {
        $this->db->select('kelurahan, COUNT(*) as total_toko, SUM(CASE WHEN surat_ijin = "Y" THEN 1 ELSE 0 END) as berijin');
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $this->db->group_by('kelurahan');
        $this->db->order_by('total_toko', 'DESC');
        return $this->db->get()->result_array();
    }
}