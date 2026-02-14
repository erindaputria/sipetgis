<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_Kepemilikan_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        $this->db->select('
            k.id_komoditas,
            k.nama_komoditas,
            k.jenis_hewan as jenis_ternak,
            k.satuan,
            COUNT(kp.id_kepemilikan) as total_peternak,
            COALESCE(SUM(kp.jumlah_masuk) - SUM(kp.jumlah_keluar), 0) as total_ekor
        ');
        $this->db->from('komoditas k');
        $this->db->join('kepemilikan_ternak kp', 'k.id_komoditas = kp.id_komoditas', 'left');
        $this->db->group_by('k.id_komoditas');
        $this->db->order_by('k.nama_komoditas', 'asc');
        return $this->db->get()->result();
    }

    public function get_by_komoditas($id_komoditas) {
        $this->db->select('
            k.id_komoditas,
            k.nama_komoditas,
            k.jenis_hewan as jenis_ternak,
            k.satuan,
            COUNT(kp.id_kepemilikan) as total_peternak,
            COALESCE(SUM(kp.jumlah_masuk) - SUM(kp.jumlah_keluar), 0) as total_ekor
        ');
        $this->db->from('komoditas k');
        $this->db->join('kepemilikan_ternak kp', 'k.id_komoditas = kp.id_komoditas', 'left');
        
        if ($id_komoditas != 'all') {
            $this->db->where('k.id_komoditas', $id_komoditas);
        }
        
        $this->db->group_by('k.id_komoditas');
        $this->db->order_by('k.nama_komoditas', 'asc');
        return $this->db->get()->result();
    }

    public function get_komoditas() {
        $this->db->select('id_komoditas, nama_komoditas');
        $this->db->from('komoditas');
        $this->db->order_by('nama_komoditas', 'asc');
        return $this->db->get()->result();
    }

    public function get_komoditas_by_id($id_komoditas) {
        $this->db->select('*');
        $this->db->from('komoditas');
        $this->db->where('id_komoditas', $id_komoditas);
        return $this->db->get()->row();
    }

    public function get_detail_by_komoditas($id_komoditas) {
        $this->db->select('
            kp.*,
            pu.nama_peternak,
            pu.alamat,
            k.nama_komoditas
        ');
        $this->db->from('kepemilikan_ternak kp');
        $this->db->join('pelaku_usaha pu', 'kp.id_pelaku_usaha = pu.id_pelaku_usaha', 'left');
        $this->db->join('komoditas k', 'kp.id_komoditas = k.id_komoditas', 'left');
        $this->db->where('kp.id_komoditas', $id_komoditas);
        $this->db->order_by('kp.tanggal_transaksi', 'desc');
        return $this->db->get()->result();
    }
}
?>