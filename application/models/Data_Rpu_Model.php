<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_rpu_model extends CI_Model {
    
    protected $table = 'input_rpu';
    protected $table_komoditas = 'input_rpu_komoditas';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
     
    /** 
     * Get all RPU data with komoditas list
     */
    public function get_all_rpu() {
        $this->db->select("r.*, 
            GROUP_CONCAT(
                CONCAT(k.komoditas, ': ', k.jumlah_ekor, ' ekor (', k.berat_kg, ' kg)') 
                SEPARATOR ' | '
            ) as komoditas_list,
            COALESCE(SUM(k.jumlah_ekor), 0) as total_ekor,
            COALESCE(SUM(k.berat_kg), 0) as total_berat");
        $this->db->from($this->table . ' r');
        $this->db->join($this->table_komoditas . ' k', 'r.id = k.input_rpu_id', 'left');
        $this->db->group_by('r.id');
        $this->db->order_by('r.tanggal_rpu', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get RPU by ID with komoditas
     */
    public function get_rpu_by_id($id) {
        $this->db->select('r.*');
        $this->db->from($this->table . ' r');
        $this->db->where('r.id', $id);
        $rpu = $this->db->get()->row();
        
        if ($rpu) {
            // Get komoditas
            $this->db->select('*');
            $this->db->from($this->table_komoditas);
            $this->db->where('input_rpu_id', $id);
            $rpu->komoditas = $this->db->get()->result();
        }
        
        return $rpu;
    }
    
    /**
     * Get RPU by periode (range tanggal)
     */
    public function get_by_periode($start_date, $end_date) {
        $this->db->select("r.*, 
            GROUP_CONCAT(
                CONCAT(k.komoditas, ': ', k.jumlah_ekor, ' ekor (', k.berat_kg, ' kg)') 
                SEPARATOR ' | '
            ) as komoditas_list,
            COALESCE(SUM(k.jumlah_ekor), 0) as total_ekor,
            COALESCE(SUM(k.berat_kg), 0) as total_berat");
        $this->db->from($this->table . ' r');
        $this->db->join($this->table_komoditas . ' k', 'r.id = k.input_rpu_id', 'left');
        $this->db->where('r.tanggal_rpu >=', $start_date);
        $this->db->where('r.tanggal_rpu <=', $end_date);
        $this->db->group_by('r.id');
        $this->db->order_by('r.tanggal_rpu', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get RPU by kecamatan
     */
    public function get_by_kecamatan($kecamatan) {
        $this->db->select("r.*, 
            GROUP_CONCAT(
                CONCAT(k.komoditas, ': ', k.jumlah_ekor, ' ekor (', k.berat_kg, ' kg)') 
                SEPARATOR ' | '
            ) as komoditas_list,
            COALESCE(SUM(k.jumlah_ekor), 0) as total_ekor,
            COALESCE(SUM(k.berat_kg), 0) as total_berat");
        $this->db->from($this->table . ' r');
        $this->db->join($this->table_komoditas . ' k', 'r.id = k.input_rpu_id', 'left');
        $this->db->where('r.kecamatan', $kecamatan);
        $this->db->group_by('r.id');
        $this->db->order_by('r.tanggal_rpu', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Count all RPU data
     */
    public function count_all() {
        return $this->db->count_all($this->table);
    }

    /**
     * Sum total ekor
     */
    public function sum_total_ekor() {
        $this->db->select('COALESCE(SUM(jumlah_ekor), 0) as total');
        $this->db->from($this->table_komoditas);
        $result = $this->db->get()->row();
        return $result->total ? (int)$result->total : 0;
    }
    
    /**
     * Sum total berat
     */
    public function sum_total_berat() {
        $this->db->select('COALESCE(SUM(berat_kg), 0) as total');
        $this->db->from($this->table_komoditas);
        $result = $this->db->get()->row();
        return $result->total ? (float)$result->total : 0;
    }
    
    /**
     * Get distinct komoditas
     */
    public function get_distinct_komoditas() {
        $this->db->distinct();
        $this->db->select('komoditas');
        $this->db->from($this->table_komoditas);
        $this->db->where('komoditas IS NOT NULL');
        $this->db->where('komoditas !=', '');
        $this->db->order_by('komoditas', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get distinct pejagal
     */
    public function get_distinct_pejagal() {
        $this->db->distinct();
        $this->db->select('pejagal');
        $this->db->from($this->table);
        $this->db->where('pejagal IS NOT NULL');
        $this->db->where('pejagal !=', '');
        $this->db->order_by('pejagal', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get distinct kecamatan
     */
    public function get_distinct_kecamatan() {
        $this->db->distinct();
        $this->db->select('kecamatan');
        $this->db->from($this->table);
        $this->db->where('kecamatan IS NOT NULL');
        $this->db->where('kecamatan !=', '');
        $this->db->order_by('kecamatan', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Delete RPU (cascade delete komoditas otomatis karena foreign key)
     */
    public function delete_rpu($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
    
    /**
     * Get statistik per bulan
     */
    public function get_statistik_per_bulan($tahun) {
        $this->db->select("MONTH(r.tanggal_rpu) as bulan, 
            COUNT(DISTINCT r.id) as total_kegiatan, 
            COALESCE(SUM(k.jumlah_ekor), 0) as total_ekor, 
            COALESCE(SUM(k.berat_kg), 0) as total_berat");
        $this->db->from($this->table . ' r');
        $this->db->join($this->table_komoditas . ' k', 'r.id = k.input_rpu_id', 'left');
        $this->db->where("YEAR(r.tanggal_rpu)", $tahun);
        $this->db->group_by("MONTH(r.tanggal_rpu)");
        $this->db->order_by("bulan", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Get statistik per kecamatan
     */
    public function get_statistik_per_kecamatan() {
        $this->db->select('r.kecamatan, 
            COUNT(DISTINCT r.id) as total_kegiatan, 
            COALESCE(SUM(k.jumlah_ekor), 0) as total_ekor, 
            COALESCE(SUM(k.berat_kg), 0) as total_berat');
        $this->db->from($this->table . ' r');
        $this->db->join($this->table_komoditas . ' k', 'r.id = k.input_rpu_id', 'left');
        $this->db->group_by('r.kecamatan');
        $this->db->order_by('total_kegiatan', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Get statistik per pejagal
     */
    public function get_statistik_per_pejagal() {
        $this->db->select('r.pejagal, 
            COUNT(DISTINCT r.id) as total_kegiatan, 
            COALESCE(SUM(k.jumlah_ekor), 0) as total_ekor, 
            COALESCE(SUM(k.berat_kg), 0) as total_berat');
        $this->db->from($this->table . ' r');
        $this->db->join($this->table_komoditas . ' k', 'r.id = k.input_rpu_id', 'left');
        $this->db->group_by('r.pejagal');
        $this->db->order_by('total_kegiatan', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
 * Update RPU data
 */
public function update_rpu($id, $data)
{
    $this->db->where('id', $id);
    return $this->db->update($this->table, $data);
}
}
?>