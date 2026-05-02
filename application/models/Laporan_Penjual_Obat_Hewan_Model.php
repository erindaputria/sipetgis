<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_penjual_obat_hewan_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    // Daftar kecamatan urutan tetap (31 kecamatan)
    private $kecamatan_order = [
        'Asemrowo', 'Krembangan', 'Pabean Cantian', 'Semampir', 'Bulak',
        'Kenjeran', 'Simokerto', 'Tambaksari', 'Mulyorejo', 'Sukolilo',
        'Gubeng', 'Rungkut', 'Gunung Anyar', 'Tenggilis Mejoyo', 'Wonocolo',
        'Benowo', 'Pakal', 'Sambikerep', 'Tandes', 'Sukomanunggal',
        'Lakarsantri', 'Wiyung', 'Sawahan', 'Dukuh Pakis', 'Karangpilang',
        'Gayungan', 'Jambangan', 'Wonokromo', 'Tegalsari', 'Genteng', 'Bubutan'
    ];

    public function get_kecamatan()
    {
        // Ambil kecamatan unik dari database (hanya yang dagangan Obat)
        $sql = "SELECT DISTINCT kecamatan FROM penjual WHERE dagangan = 'Obat' AND kecamatan IS NOT NULL AND kecamatan != '' ORDER BY kecamatan ASC";
        $query = $this->db->query($sql);
        $result = $query->result();
         
        // Jika tidak ada data, gunakan daftar kecamatan default
        if(empty($result)) {
            $kecamatan_list = $this->kecamatan_order;
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

    // ========== METHOD REKAP PER KECAMATAN (0-0-0) ==========

    /**
     * Get rekap jumlah penjual obat per kecamatan
     */
    public function get_rekap_per_kecamatan($tahun = null, $kecamatan_filter = null)
    {
        $this->db->select('kecamatan, COUNT(*) as jumlah_toko');
        $this->db->from('penjual');
        
        // HANYA YANG DAGANGAN OBAT
        $this->db->where('dagangan', 'Obat');
        
        if($tahun && $tahun != 'all' && $tahun != '') {
            $this->db->where('YEAR(tanggal_input)', $tahun);
        }
        
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $this->db->where('kecamatan', $kecamatan_filter);
        }
        
        $this->db->group_by('kecamatan');
        $query = $this->db->get();
        $results = $query->result();
        
        // Map data ke array
        $dataMap = [];
        foreach($results as $row) {
            $kec = ucwords(strtolower($row->kecamatan));
            $dataMap[$kec] = (int)$row->jumlah_toko;
        }
        
        // Tentukan kecamatan yang ditampilkan
        $kecamatanList = [];
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $kecamatanList = [ucwords(strtolower($kecamatan_filter))];
        } else {
            $kecamatanList = $this->kecamatan_order;
        }
        
        // Build hasil
        $result = [];
        foreach($kecamatanList as $kec) {
            $row = (object)[
                'kecamatan' => $kec,
                'jumlah_toko' => isset($dataMap[$kec]) ? $dataMap[$kec] : 0
            ];
            $result[] = $row;
        }
        
        return $result;
    }

    /**
     * Get total rekap per kecamatan
     */
    public function get_total_rekap($tahun = null, $kecamatan_filter = null)
    {
        $data = $this->get_rekap_per_kecamatan($tahun, $kecamatan_filter);
        
        $total = (object)[
            'jumlah_toko' => 0
        ];
        
        foreach($data as $row) {
            $total->jumlah_toko += $row->jumlah_toko;
        }
        
        return $total;
    }

    /**
     * Get all data tanpa filter (untuk load awal)
     */
    public function get_all_data_penjual_obat()
    {
        return $this->get_data_penjual_obat('all', 'semua');
    }

    /**
     * Get all rekap per kecamatan (tanpa filter tahun)
     */
    public function get_all_rekap_per_kecamatan()
    {
        return $this->get_rekap_per_kecamatan(null, null);
    }

    /**
     * Get all total rekap (tanpa filter tahun)
     */
    public function get_all_total_rekap()
    {
        return $this->get_total_rekap(null, null);
    }
}
?>