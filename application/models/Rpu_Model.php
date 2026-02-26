<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rpu_Model extends CI_Model {
    
    private $table = 'rpu';
    private $primary_key = 'id';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_all() {
        $this->db->select('id, pejagal, latitude, longitude');
        $this->db->order_by('pejagal', 'ASC');
        return $this->db->get($this->table)->result();
    }
    
    public function get_by_id($id) {
        $this->db->where($this->primary_key, $id);
        return $this->db->get($this->table)->row();
    }
    
    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }
    
    public function update($id, $data) {
        $this->db->where($this->primary_key, $id);
        return $this->db->update($this->table, $data);
    }
    
    public function delete($id) {
        $this->db->where($this->primary_key, $id);
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
}