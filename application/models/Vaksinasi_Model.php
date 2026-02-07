<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vaksinasi_Model extends CI_Model {
    
    private $table = 'vaksinasi';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_all() {
        $this->db->order_by('id_vaksin', 'ASC');
        return $this->db->get($this->table)->result();
    }
    
    public function get_by_id($id) {
        $this->db->where('id_vaksin', $id);
        return $this->db->get($this->table)->row();
    }
    
    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }
    
    public function update($id, $data) {
        $this->db->where('id_vaksin', $id);
        return $this->db->update($this->table, $data);
    }
    
    public function delete($id) {
        $this->db->where('id_vaksin', $id);
        return $this->db->delete($this->table);
    }
    
    public function count_all() {
        return $this->db->count_all($this->table);
    }
}