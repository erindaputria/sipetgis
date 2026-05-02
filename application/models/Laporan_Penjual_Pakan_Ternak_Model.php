<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_penjual_pakan_ternak_model extends CI_Model {

    protected $table = 'penjual'; // Gunakan nama tabel yang benar
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    } 

    // Daftar kecamatan urutan tetap
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
        // Get distinct kecamatan from penjual table
        $this->db->distinct();
        $this->db->select('kecamatan');
        $this->db->from($this->table);
        $this->db->order_by('kecamatan', 'ASC');
        $query = $this->db->get();
        
        $result = $query->result();
         
        // If no data, return default list
        if(empty($result)) {
            $kecamatan_list = $this->kecamatan_order;
            $result = [];
            foreach($kecamatan_list as $kec) {
                $result[] = (object)['kecamatan' => $kec];
            }
        }
        
        return $result;
    }

    public function get_tahun()
    {
        // Get distinct years from created_at
        $this->db->distinct();
        $this->db->select('YEAR(created_at) as tahun');
        $this->db->from($this->table);
        $this->db->order_by('tahun', 'DESC');
        $query = $this->db->get();
        
        $result = $query->result();
        
        // If no data, return default years
        if(empty($result)) {
            $currentYear = date('Y');
            $result = [];
            for($i = $currentYear; $i >= $currentYear - 5; $i--) {
                $result[] = (object)['tahun' => $i];
            }
        }
        
        return $result;
    }

    public function get_data_penjual_pakan($tahun, $kecamatan_filter = null)
    {
        $this->db->select('
            id_penjual,
            nama_toko,
            nama_pemilik,
            nik,
            nama_petugas,
            tanggal_input,
            keterangan,
            nib,
            alamat,
            kecamatan,
            kelurahan,
            rt,
            rw,
            latitude,
            longitude,
            telp,
            dagangan,
            kategori_obat,
            jenis_obat,
            foto_toko,
            surat_ijin,
            obat_hewan,
            created_at
        ');
        $this->db->from($this->table);
        
        // Filter by year
        if($tahun && $tahun != '') {
            $this->db->where('YEAR(created_at)', $tahun);
        }
        
        // Filter by kecamatan
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $this->db->where('kecamatan', $kecamatan_filter);
        }
        
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        
        return $query->result();
    }
    
    public function get_total_penjual_pakan($tahun, $kecamatan_filter)
    {
        $this->db->from($this->table);
        
        // Filter by year
        if($tahun && $tahun != '') {
            $this->db->where('YEAR(created_at)', $tahun);
        }
        
        // Filter by kecamatan
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $this->db->where('kecamatan', $kecamatan_filter);
        }
        
        $total_usaha = $this->db->count_all_results();
        
        return (object)[
            'total_usaha' => $total_usaha
        ];
    }

    // ========== METHOD REKAP PER KECAMATAN ==========

    public function get_rekap_per_kecamatan($tahun = null, $kecamatan_filter = null)
    {
        $this->db->select('kecamatan, COUNT(*) as jumlah_usaha');
        $this->db->from($this->table);
        
        if($tahun && $tahun != '') {
            $this->db->where('YEAR(created_at)', $tahun);
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
            $dataMap[$kec] = (int)$row->jumlah_usaha;
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
                'jumlah_usaha' => isset($dataMap[$kec]) ? $dataMap[$kec] : 0
            ];
            $result[] = $row;
        }
        
        return $result;
    }

    public function get_total_rekap($tahun = null, $kecamatan_filter = null)
    {
        $data = $this->get_rekap_per_kecamatan($tahun, $kecamatan_filter);
        
        $total = (object)[
            'jumlah_usaha' => 0
        ];
        
        foreach($data as $row) {
            $total->jumlah_usaha += $row->jumlah_usaha;
        }
        
        return $total;
    }

    // ========== METHOD UNTUK SEMUA DATA (TANPA FILTER) ==========
    
    public function get_all_data_penjual_pakan()
    {
        $this->db->select('
            id_penjual,
            nama_toko,
            nama_pemilik,
            nik,
            nama_petugas,
            tanggal_input,
            keterangan,
            nib,
            alamat,
            kecamatan,
            kelurahan,
            rt,
            rw,
            latitude,
            longitude,
            telp,
            dagangan,
            kategori_obat,
            jenis_obat,
            foto_toko,
            surat_ijin,
            obat_hewan,
            created_at
        ');
        $this->db->from($this->table);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        
        return $query->result();
    }

    public function get_all_rekap_per_kecamatan()
    {
        return $this->get_rekap_per_kecamatan(null, null);
    }

    public function get_all_total_rekap()
    {
        return $this->get_total_rekap(null, null);
    }

    public function get_detail_by_kecamatan($kecamatan, $tahun = null)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        
        if($tahun && $tahun != '') {
            $this->db->where('YEAR(created_at)', $tahun);
        }
        
        $this->db->order_by('nama_toko', 'ASC');
        return $this->db->get()->result();
    }
}
?>