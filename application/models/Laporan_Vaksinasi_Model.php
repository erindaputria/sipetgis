<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_vaksinasi_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

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
        $sql = "SELECT DISTINCT kecamatan FROM input_vaksinasi WHERE kecamatan IS NOT NULL AND kecamatan != '' AND kecamatan != 'Surabaya' ORDER BY kecamatan ASC";
        $query = $this->db->query($sql);
        
        if($query->num_rows() > 0) {
            $result = [];
            foreach($query->result() as $row) { 
                $result[] = (object)['kecamatan' => ucwords(strtolower($row->kecamatan))];
            }
            return $result;
        }
        
        $result = [];
        foreach($this->kecamatan_order as $kec) {
            $result[] = (object)['kecamatan' => $kec];
        }
        return $result;
    }

    public function get_tahun()
    {
        $sql = "SELECT DISTINCT YEAR(tanggal_vaksinasi) as tahun FROM input_vaksinasi WHERE tanggal_vaksinasi IS NOT NULL ORDER BY tahun DESC";
        $query = $this->db->query($sql);
        
        if($query->num_rows() > 0) {
            return $query->result();
        }
        
        $currentYear = date('Y');
        $result = [];
        for($i = $currentYear; $i >= $currentYear - 5; $i--) {
            $result[] = (object)['tahun' => $i];
        }
        return $result;
    }

    public function get_data_vaksinasi($tahun, $bulan, $kecamatan_filter = null, $jenis_vaksin = 'PMK')
    {
        if($jenis_vaksin == 'PMK' || $jenis_vaksin == 'LSD') {
            return $this->get_data_pmk_lsd($tahun, $bulan, $kecamatan_filter);
        } else {
            return $this->get_data_ndai($tahun, $bulan, $kecamatan_filter);
        }
    }
    
    public function get_data_pmk_lsd($tahun, $bulan, $kecamatan_filter = null)
    {
        $sql = "SELECT 
                    kecamatan,
                    COALESCE(SUM(CASE WHEN komoditas_ternak = 'Sapi Potong' THEN CAST(jumlah AS UNSIGNED) ELSE 0 END), 0) as sapi_potong,
                    COALESCE(SUM(CASE WHEN komoditas_ternak = 'Sapi Perah' THEN CAST(jumlah AS UNSIGNED) ELSE 0 END), 0) as sapi_perah,
                    COALESCE(SUM(CASE WHEN komoditas_ternak = 'Kambing' THEN CAST(jumlah AS UNSIGNED) ELSE 0 END), 0) as kambing,
                    COALESCE(SUM(CASE WHEN komoditas_ternak = 'Domba' THEN CAST(jumlah AS UNSIGNED) ELSE 0 END), 0) as domba
                FROM input_vaksinasi
                WHERE jenis_vaksinasi IN ('Vaksinasi PMK', 'PMK', 'Vaksinasi LSD', 'LSD')
                AND komoditas_ternak IN ('Sapi Potong', 'Sapi Perah', 'Kambing', 'Domba')";
        
        if($tahun && $tahun != '') {
            $sql .= " AND YEAR(tanggal_vaksinasi) = " . $this->db->escape($tahun);
        }
        
        if($bulan && $bulan != '') {
            $sql .= " AND MONTH(tanggal_vaksinasi) = " . $this->db->escape($bulan);
        }
        
        if($kecamatan_filter && $kecamatan_filter != 'semua' && $kecamatan_filter != 'Surabaya') {
            $sql .= " AND UPPER(kecamatan) = " . $this->db->escape(strtoupper($kecamatan_filter));
        }
        
        $sql .= " GROUP BY kecamatan ORDER BY kecamatan ASC";
        
        $query = $this->db->query($sql);
        $results = $query->result();
        
        // Normalisasi nama kecamatan
        foreach($results as $item) {
            $item->kecamatan = ucwords(strtolower($item->kecamatan));
            $item->sapi_potong = (int)$item->sapi_potong;
            $item->sapi_perah = (int)$item->sapi_perah;
            $item->kambing = (int)$item->kambing;
            $item->domba = (int)$item->domba;
        }
        
        return $results;
    }
    
    public function get_data_ndai($tahun, $bulan, $kecamatan_filter = null)
    {
        $sql = "SELECT 
                    kecamatan,
                    COALESCE(SUM(CASE WHEN komoditas_ternak IN ('Ayam', 'Ayam Buras', 'Ayam Ras Pedaging', 'Ayam Ras Petelur') THEN CAST(jumlah AS UNSIGNED) ELSE 0 END), 0) as ayam,
                    COALESCE(SUM(CASE WHEN komoditas_ternak = 'Itik' THEN CAST(jumlah AS UNSIGNED) ELSE 0 END), 0) as itik,
                    COALESCE(SUM(CASE WHEN komoditas_ternak = 'Angsa' THEN CAST(jumlah AS UNSIGNED) ELSE 0 END), 0) as angsa,
                    COALESCE(SUM(CASE WHEN komoditas_ternak = 'Kalkun' THEN CAST(jumlah AS UNSIGNED) ELSE 0 END), 0) as kalkun,
                    COALESCE(SUM(CASE WHEN komoditas_ternak = 'Burung' THEN CAST(jumlah AS UNSIGNED) ELSE 0 END), 0) as burung
                FROM input_vaksinasi
                WHERE jenis_vaksinasi IN ('Vaksinasi ND-AI', 'ND-AI')";
        
        if($tahun && $tahun != '') {
            $sql .= " AND YEAR(tanggal_vaksinasi) = " . $this->db->escape($tahun);
        }
        
        if($bulan && $bulan != '') {
            $sql .= " AND MONTH(tanggal_vaksinasi) = " . $this->db->escape($bulan);
        }
        
        if($kecamatan_filter && $kecamatan_filter != 'semua' && $kecamatan_filter != 'Surabaya') {
            $sql .= " AND UPPER(kecamatan) = " . $this->db->escape(strtoupper($kecamatan_filter));
        }
        
        $sql .= " GROUP BY kecamatan ORDER BY kecamatan ASC";
        
        $query = $this->db->query($sql);
        $dbResults = $query->result();
        
        $dataMap = [];
        foreach($dbResults as $item) {
            $kecamatanNormalized = ucwords(strtolower($item->kecamatan));
            $item->ayam = (int)$item->ayam;
            $item->itik = (int)$item->itik;
            $item->angsa = (int)$item->angsa;
            $item->kalkun = (int)$item->kalkun;
            $item->burung = (int)$item->burung;
            $dataMap[$kecamatanNormalized] = $item;
        }
        
        $kecamatanList = [];
        if($kecamatan_filter && $kecamatan_filter != 'semua' && $kecamatan_filter != 'Surabaya') {
            $kecamatanList = [ucwords(strtolower($kecamatan_filter))];
        } else {
            $kecamatanList = $this->kecamatan_order;
        }
        
        $results = [];
        foreach($kecamatanList as $kecamatan) {
            if(isset($dataMap[$kecamatan])) {
                $results[] = $dataMap[$kecamatan];
            } else {
                $emptyObj = new stdClass();
                $emptyObj->kecamatan = $kecamatan;
                $emptyObj->ayam = 0;
                $emptyObj->itik = 0;
                $emptyObj->angsa = 0;
                $emptyObj->kalkun = 0;
                $emptyObj->burung = 0;
                $results[] = $emptyObj;
            }
        }
        
        return $results;
    }
    
    public function get_total_vaksinasi($tahun, $bulan, $kecamatan_filter, $jenis_vaksin = 'PMK')
    {
        if($jenis_vaksin == 'PMK' || $jenis_vaksin == 'LSD') {
            return $this->get_total_pmk_lsd($tahun, $bulan, $kecamatan_filter);
        } else {
            return $this->get_total_ndai($tahun, $bulan, $kecamatan_filter);
        }
    }
    
    public function get_total_pmk_lsd($tahun, $bulan, $kecamatan_filter)
    {
        $data = $this->get_data_pmk_lsd($tahun, $bulan, $kecamatan_filter);
        
        $total_sapi_potong = 0;
        $total_sapi_perah = 0;
        $total_kambing = 0;
        $total_domba = 0;
        
        foreach($data as $row) {
            $total_sapi_potong += $row->sapi_potong;
            $total_sapi_perah += $row->sapi_perah;
            $total_kambing += $row->kambing;
            $total_domba += $row->domba;
        }
        
        return (object)[
            'sapi_potong' => $total_sapi_potong,
            'sapi_perah' => $total_sapi_perah,
            'kambing' => $total_kambing,
            'domba' => $total_domba
        ];
    }
    
    public function get_total_ndai($tahun, $bulan, $kecamatan_filter)
    {
        $data = $this->get_data_ndai($tahun, $bulan, $kecamatan_filter);
        
        $total_ayam = 0;
        $total_itik = 0;
        $total_angsa = 0;
        $total_kalkun = 0;
        $total_burung = 0;
        
        foreach($data as $row) {
            $total_ayam += $row->ayam;
            $total_itik += $row->itik;
            $total_angsa += $row->angsa;
            $total_kalkun += $row->kalkun;
            $total_burung += $row->burung;
        }
        
        return (object)[
            'ayam' => $total_ayam,
            'itik' => $total_itik,
            'angsa' => $total_angsa,
            'kalkun' => $total_kalkun,
            'burung' => $total_burung
        ];
    }
}
?>