<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class K_laporan_kepala_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get tahun dari rentang 2022 - 2026 (FIXED, tidak tergantung database)
     */
    public function get_tahun_range() {
        $tahun_list = [];
        for ($tahun = 2022; $tahun <= 2026; $tahun++) {
            $tahun_list[] = (object)['tahun' => (string)$tahun];
        }
        return $tahun_list;
    }
    
    /**
     * Get tahun dari tabel tertentu (alternatif jika ingin dari database)
     */
    public function get_tahun_from_table($table, $date_column = 'tanggal_data') {
        // Tetap return range 2022-2026
        return $this->get_tahun_range();
    }
    
    /**
     * Get kecamatan dari tabel
     */
    public function get_kecamatan_from_table($table) {
        if (!$this->db->table_exists($table)) {
            return $this->get_dummy_kecamatan();
        }
        
        $query = $this->db->query("SELECT DISTINCT kecamatan FROM $table ORDER BY kecamatan");
        $result = $query->result();
        
        return !empty($result) ? $result : $this->get_dummy_kecamatan();
    }
    
    /**
     * Get data dengan filter (untuk AJAX)
     */
    public function get_data_with_filter($table, $filter = [], $date_column = 'tanggal_data') {
        $this->db->select('*');
        $this->db->from($table);
        
        if (!empty($filter['tahun'])) {
            $this->db->where("YEAR($date_column)", $filter['tahun']);
        }
        if (!empty($filter['bulan'])) {
            $this->db->where("MONTH($date_column)", $filter['bulan']);
        }
        if (!empty($filter['kecamatan']) && $filter['kecamatan'] != 'semua') {
            $this->db->where('kecamatan', $filter['kecamatan']);
        }
        
        $this->db->order_by('kecamatan', 'ASC');
        
        return $this->db->get()->result();
    }
    
    /**
     * Get semua kecamatan Surabaya (31 kecamatan)
     */
    public function get_all_kecamatan() {
        return [
            'Asemrowo', 'Benowo', 'Bubutan', 'Bulak', 'Dukuh Pakis',
            'Gayungan', 'Genteng', 'Gubeng', 'Gunung Anyar', 'Jambangan',
            'Karangpilang', 'Kenjeran', 'Krembangan', 'Lakarsantri', 'Mulyorejo',
            'Pabean Cantian', 'Pakal', 'Rungkut', 'Sambikerep', 'Sawahan',
            'Semampir', 'Simokerto', 'Sukolilo', 'Sukomanunggal', 'Tambaksari',
            'Tandes', 'Tegalsari', 'Tenggilis Mejoyo', 'Wiyung', 'Wonocolo', 'Wonokromo'
        ];
    }
    
    /**
     * Get semua bulan
     */
    public function get_all_bulan() {
        return [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
    }
    
    /**
     * Dummy kecamatan jika tabel kosong
     */
    private function get_dummy_kecamatan() {
        $kecamatan_list = $this->get_all_kecamatan();
        $result = [];
        foreach ($kecamatan_list as $k) {
            $result[] = (object)['kecamatan' => $k];
        }
        return $result;
    }
}