<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_pengobatan_ternak_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    } 

    public function get_kecamatan()
    {
        $kecamatan_list = [
            'Asemrowo', 'Benowo', 'Bubutan', 'Bulak', 'Dukuh Pakis',
            'Gayungan', 'Genteng', 'Gubeng', 'Gunung Anyar', 'Jambangan',
            'Karangpilang', 'Kenjeran', 'Krembangan', 'Lakarsantri', 'Mulyorejo',
            'Pabean Cantian', 'Pakal', 'Rungkut', 'Sambikerep', 'Sawahan',
            'Semampir', 'Simokerto', 'Sukolilo', 'Sukomanunggal', 'Tambaksari',
            'Tandes', 'Tegalsari', 'Tenggilis Mejoyo', 'Wiyung', 'Wonocolo', 'Wonokromo'
        ];
        
        $result = [];
        foreach($kecamatan_list as $kec) {
            $result[] = (object)['kecamatan' => $kec];
        }
        return $result;
    }

    public function get_tahun()
    {
        $this->db->select('DISTINCT YEAR(tanggal_pengobatan) as tahun');
        $this->db->from('input_pengobatan');
        $this->db->where('tanggal_pengobatan IS NOT NULL');
        $this->db->order_by('tahun', 'DESC');
        $query = $this->db->get();
        
        $result = $query->result();
        
        if(empty($result)) {
            $currentYear = date('Y');
            for($i = $currentYear; $i >= $currentYear - 5; $i--) {
                $result[] = (object)['tahun' => $i];
            }
        }
        
        return $result;
    }

    public function get_data_pengobatan($tahun, $kecamatan_filter = null, $jenis_hewan_filter = null)
    {
        $this->db->select('*');
        $this->db->from('input_pengobatan');
        $this->db->where('YEAR(tanggal_pengobatan)', $tahun);
        
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $this->db->where('kecamatan', $kecamatan_filter);
        }
        
        if($jenis_hewan_filter && $jenis_hewan_filter != 'semua') {
            $this->db->where('komoditas_ternak', $jenis_hewan_filter);
        }
        
        $this->db->order_by('tanggal_pengobatan', 'DESC');
        $query = $this->db->get();
        
        return $query->result();
    }
    
    public function get_total_pengobatan($tahun, $kecamatan_filter = null, $jenis_hewan_filter = null)
    {
        $this->db->select('COALESCE(SUM(jumlah), 0) as total_jumlah');
        $this->db->from('input_pengobatan');
        $this->db->where('YEAR(tanggal_pengobatan)', $tahun);
        
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $this->db->where('kecamatan', $kecamatan_filter);
        }
        
        if($jenis_hewan_filter && $jenis_hewan_filter != 'semua') {
            $this->db->where('komoditas_ternak', $jenis_hewan_filter);
        }
        
        $query = $this->db->get();
        $result = $query->row();
        
        return (object)[
            'jumlah' => $result->total_jumlah ? $result->total_jumlah : 0
        ];
    }
    
    public function get_rekap_per_jenis_hewan($tahun, $kecamatan_filter = null)
    {
        $this->db->select('komoditas_ternak as jenis_hewan, COUNT(*) as jumlah_kasus, COALESCE(SUM(jumlah), 0) as total_jumlah');
        $this->db->from('input_pengobatan');
        $this->db->where('YEAR(tanggal_pengobatan)', $tahun);
        $this->db->where('komoditas_ternak IS NOT NULL');
        $this->db->where('komoditas_ternak !=', '');
        
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $this->db->where('kecamatan', $kecamatan_filter);
        }
        
        $this->db->group_by('komoditas_ternak');
        $this->db->order_by('total_jumlah', 'DESC');
        $query = $this->db->get();
        
        return $query->result();
    }
    
    public function get_rekap_per_kecamatan($tahun, $jenis_hewan_filter = null)
    {
        $this->db->select('kecamatan, COUNT(*) as jumlah_kasus, COALESCE(SUM(jumlah), 0) as total_jumlah');
        $this->db->from('input_pengobatan');
        $this->db->where('YEAR(tanggal_pengobatan)', $tahun);
        $this->db->where('kecamatan IS NOT NULL');
        $this->db->where('kecamatan !=', '');
        
        if($jenis_hewan_filter && $jenis_hewan_filter != 'semua') {
            $this->db->where('komoditas_ternak', $jenis_hewan_filter);
        }
        
        $this->db->group_by('kecamatan');
        $this->db->order_by('total_jumlah', 'DESC');
        $query = $this->db->get();
        
        return $query->result();
    }
}
?>