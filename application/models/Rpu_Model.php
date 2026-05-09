<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rpu_model extends CI_Model {
    
    private $table = 'rpu';
    private $primary_key = 'pejagal';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_all() {
        $this->db->select('pejagal, latitude, longitude');
        $this->db->order_by('pejagal', 'ASC');
        $query = $this->db->get($this->table);
        return $query->result();
    }
    
    public function get_by_id($pejagal) {
        $this->db->where($this->primary_key, $pejagal);
        return $this->db->get($this->table)->row();
    }
    
    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }
    
    public function update($pejagal_lama, $data) {
        $this->db->where($this->primary_key, $pejagal_lama);
        return $this->db->update($this->table, $data);
    }
    
    public function delete($pejagal) {
        $this->db->where($this->primary_key, $pejagal);
        return $this->db->delete($this->table);
    }
    
    public function check_pejagal($pejagal) { 
        $this->db->where('pejagal', $pejagal);
        return $this->db->get($this->table)->row(); 
    }
    
    public function get_with_coordinates() {
        $this->db->where('latitude IS NOT NULL');
        $this->db->where('longitude IS NOT NULL'); 
        $this->db->where('latitude !=', '');
        $this->db->where('longitude !=', '');
        return $this->db->get($this->table)->result();
    }

    public function get_by_pejagal($pejagal)
{
    $this->db->where('pejagal', $pejagal);
    $query = $this->db->get($this->table);
    return $query->row();
}
}
?>