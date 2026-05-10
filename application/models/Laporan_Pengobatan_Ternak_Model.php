<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_pengobatan_ternak_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
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

    // ========== METHOD REKAP BREAKDOWN (0-0-0 SEPERTI VAKSINASI) ==========
    
    public function get_rekap_breakdown($tahun = null, $kecamatan_filter = null, $jenis_hewan_filter = null)
    {
        $this->db->select('kecamatan, komoditas_ternak, COALESCE(SUM(jumlah), 0) as total');
        $this->db->from('input_pengobatan');
        $this->db->where('kecamatan IS NOT NULL');
        $this->db->where('kecamatan !=', '');
        
        if($tahun) {
            $this->db->where('YEAR(tanggal_pengobatan)', $tahun);
        }
        
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $this->db->where('kecamatan', $kecamatan_filter);
        }
        
        if($jenis_hewan_filter && $jenis_hewan_filter != 'semua') {
            $this->db->where('komoditas_ternak', $jenis_hewan_filter);
        }
        
        $this->db->group_by(['kecamatan', 'komoditas_ternak']);
        $query = $this->db->get();
        $results = $query->result();
        
        // Map data ke array
        $dataMap = [];
        foreach($results as $row) {
            $kec = ucwords(strtolower($row->kecamatan));
            $jenis = $row->komoditas_ternak;
            $dataMap[$kec][$jenis] = (int)$row->total;
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
                'sapi_potong' => isset($dataMap[$kec]['Sapi Potong']) ? $dataMap[$kec]['Sapi Potong'] : 0,
                'sapi_perah' => isset($dataMap[$kec]['Sapi Perah']) ? $dataMap[$kec]['Sapi Perah'] : 0,
                'kambing' => isset($dataMap[$kec]['Kambing']) ? $dataMap[$kec]['Kambing'] : 0,
                'domba' => isset($dataMap[$kec]['Domba']) ? $dataMap[$kec]['Domba'] : 0,
                'ayam' => isset($dataMap[$kec]['Ayam']) ? $dataMap[$kec]['Ayam'] : 0,
                'itik' => isset($dataMap[$kec]['Itik']) ? $dataMap[$kec]['Itik'] : 0,
                'kelinci' => isset($dataMap[$kec]['Kelinci']) ? $dataMap[$kec]['Kelinci'] : 0,
                'kucing' => isset($dataMap[$kec]['Kucing']) ? $dataMap[$kec]['Kucing'] : 0
            ];
            $result[] = $row;
        }
        
        return $result;
    }

    public function get_total_breakdown($tahun = null, $kecamatan_filter = null, $jenis_hewan_filter = null)
    {
        $data = $this->get_rekap_breakdown($tahun, $kecamatan_filter, $jenis_hewan_filter);
        
        $total = (object)[
            'sapi_potong' => 0,
            'sapi_perah' => 0,
            'kambing' => 0,
            'domba' => 0,
            'ayam' => 0,
            'itik' => 0,
            'kelinci' => 0,
            'kucing' => 0
        ];
        
        foreach($data as $row) {
            $total->sapi_potong += $row->sapi_potong;
            $total->sapi_perah += $row->sapi_perah;
            $total->kambing += $row->kambing;
            $total->domba += $row->domba;
            $total->ayam += $row->ayam;
            $total->itik += $row->itik;
            $total->kelinci += $row->kelinci;
            $total->kucing += $row->kucing;
        }
        
        return $total;
    }

    public function get_all_pengobatan()
    {
        $this->db->select('*');
        $this->db->from('input_pengobatan');
        $this->db->order_by('tanggal_pengobatan', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_rekap_per_jenis_hewan()
    {
        $this->db->select('komoditas_ternak as jenis_hewan, COUNT(*) as jumlah_kasus, COALESCE(SUM(jumlah), 0) as total_jumlah');
        $this->db->from('input_pengobatan');
        $this->db->where('komoditas_ternak IS NOT NULL');
        $this->db->where('komoditas_ternak !=', '');
        $this->db->group_by('komoditas_ternak');
        $this->db->order_by('total_jumlah', 'DESC');
        return $this->db->get()->result();
    }

    public function get_all_rekap_per_kecamatan()
    {
        $this->db->select('kecamatan, COUNT(*) as jumlah_kasus, COALESCE(SUM(jumlah), 0) as total_jumlah');
        $this->db->from('input_pengobatan');
        $this->db->where('kecamatan IS NOT NULL');
        $this->db->where('kecamatan !=', '');
        $this->db->group_by('kecamatan');
        $this->db->order_by('total_jumlah', 'DESC');
        return $this->db->get()->result();
    }

    public function get_detail_pengobatan($kecamatan, $jenis_hewan, $tahun = null)
    {
        $this->db->select('*');
        $this->db->from('input_pengobatan');
        $this->db->where('kecamatan', $kecamatan);
        $this->db->where('komoditas_ternak', $jenis_hewan);
        
        if($tahun) {
            $this->db->where('YEAR(tanggal_pengobatan)', $tahun);
        }
        
        $this->db->order_by('tanggal_pengobatan', 'DESC');
        $query = $this->db->get();
        
        return $query->result();
    }
}
?>