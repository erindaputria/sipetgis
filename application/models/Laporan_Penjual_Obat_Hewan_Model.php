<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_penjual_obat_hewan_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_kecamatan()
    {
        // Ambil kecamatan unik dari database (hanya yang dagangan Obat)
        $sql = "SELECT DISTINCT kecamatan FROM penjual WHERE dagangan = 'Obat' AND kecamatan IS NOT NULL AND kecamatan != '' ORDER BY kecamatan ASC";
        $query = $this->db->query($sql);
        $result = $query->result();
        
        // Jika tidak ada data, gunakan daftar kecamatan default
        if(empty($result)) {
            $kecamatan_list = [
                'Asemrowo', 'Benowo', 'Bubutan', 'Bulak', 'Dukuh Pakis',
                'Gayungan', 'Genteng', 'Gubeng', 'Gunung Anyar', 'Jambangan',
                'Karangpilang', 'Kenjeran', 'Krembangan', 'Lakarsantri', 'Mulyorejo',
                'Pabean Cantian', 'Pakal', 'Rungkut', 'Sambikerep', 'Sawahan',
                'Semampir', 'Simokerto', 'Sukolilo', 'Sukomanunggal', 'Tambaksari',
                'Tandes', 'Tegalsari', 'Tenggilis Mejoyo', 'Wiyung', 'Wonocolo', 'Wonokromo'
            ];
            foreach($kecamatan_list as $kec) {
                $result[] = (object)['kecamatan' => $kec];
            }
        }
        
        return $result;
    }

    public function get_tahun()
    {
        // Ambil tahun unik dari database (hanya yang dagangan Obat)
        $sql = "SELECT DISTINCT YEAR(tanggal_input) as tahun FROM penjual WHERE dagangan = 'Obat' AND tanggal_input IS NOT NULL ORDER BY tahun DESC";
        $query = $this->db->query($sql);
        $result = $query->result();
        
        // Jika tidak ada data, gunakan tahun saat ini dan 5 tahun sebelumnya
        if(empty($result)) {
            $currentYear = date('Y');
            for($i = $currentYear; $i >= $currentYear - 5; $i--) {
                $result[] = (object)['tahun' => $i];
            }
        }
        
        return $result;
    }

    public function get_data_penjual_obat($tahun = null, $kecamatan_filter = null)
    {
        $this->db->select('*');
        $this->db->from('penjual');
        
        // HANYA YANG DAGANGAN OBAT
        $this->db->where('dagangan', 'Obat');
        
        // Filter berdasarkan tahun (dari tanggal_input)
        if($tahun && $tahun != 'all' && $tahun != '') {
            $this->db->where('YEAR(tanggal_input)', $tahun);
        }
        
        // Filter berdasarkan kecamatan
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $this->db->where('kecamatan', $kecamatan_filter);
        }
        
        $this->db->order_by('nama_toko', 'ASC');
        $query = $this->db->get();
        
        return $query->result();
    }
    
    public function get_total_penjual_obat($tahun = null, $kecamatan_filter = null)
    {
        $this->db->select('COUNT(*) as total_toko');
        $this->db->from('penjual');
        
        // HANYA YANG DAGANGAN OBAT
        $this->db->where('dagangan', 'Obat');
        
        // Filter berdasarkan tahun
        if($tahun && $tahun != 'all' && $tahun != '') {
            $this->db->where('YEAR(tanggal_input)', $tahun);
        }
        
        // Filter berdasarkan kecamatan
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $this->db->where('kecamatan', $kecamatan_filter);
        }
        
        $query = $this->db->get();
        $result = $query->row();
        
        return (object)[
            'total_toko' => $result->total_toko ?? 0
        ];
    }
}
?>