<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_history_data_ternak_model extends CI_Model {

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
        $sql = "SELECT DISTINCT kecamatan FROM input_jenis_usaha WHERE kecamatan IS NOT NULL AND kecamatan != '' ORDER BY kecamatan ASC";
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
        $sql = "SELECT DISTINCT YEAR(tanggal_input) as tahun FROM input_jenis_usaha WHERE tanggal_input IS NOT NULL ORDER BY tahun DESC";
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

    public function get_history_data($tahun, $bulan, $kecamatan_filter = null)
    {
        // Query untuk mendapatkan data dari input_jenis_usaha
        $sql = "SELECT 
                    iju.nik,
                    iju.nama_peternak,
                    iju.alamat,
                    iju.kecamatan,
                    iju.kelurahan,
                    iju.komoditas_ternak,
                    iju.jumlah,
                    IFNULL(iju.jenis_kelamin, 'L') as jenis_kelamin,
                    iju.tanggal_input
                FROM input_jenis_usaha iju
                WHERE 1=1";
        
        if($tahun && $tahun != '') {
            $sql .= " AND YEAR(iju.tanggal_input) = " . $this->db->escape($tahun);
        }
        
        if($bulan && $bulan != '') {
            $sql .= " AND MONTH(iju.tanggal_input) = " . $this->db->escape($bulan);
        }
        
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $sql .= " AND UPPER(iju.kecamatan) = " . $this->db->escape(strtoupper($kecamatan_filter));
        }
        
        $sql .= " ORDER BY iju.kecamatan ASC, iju.nama_peternak ASC, iju.tanggal_input DESC";
        
        $query = $this->db->query($sql);
        $results = $query->result();
        
        // Group data by NIK
        $peternak_data = [];
        
        foreach($results as $row) {
            $kecamatan = ucwords(strtolower($row->kecamatan));
            $komoditas = trim($row->komoditas_ternak);
            $jumlah = (int)$row->jumlah;
            $jenis_kelamin = strtoupper(trim($row->jenis_kelamin));
            
            // Inisialisasi peternak jika belum ada
            if(!isset($peternak_data[$row->nik])) {
                $peternak_data[$row->nik] = [
                    'nik' => $row->nik,
                    'nama_peternak' => $row->nama_peternak,
                    'alamat' => $row->alamat ?: '-',
                    'kecamatan' => $kecamatan,
                    'kelurahan' => $row->kelurahan ?: '-',
                    'tanggal_input' => $row->tanggal_input,
                    'komoditas' => []
                ];
            }
            
            // Inisialisasi komoditas jika belum ada
            if(!isset($peternak_data[$row->nik]['komoditas'][$komoditas])) {
                $peternak_data[$row->nik]['komoditas'][$komoditas] = [
                    'jantan' => 0,
                    'betina' => 0
                ];
            }
            
            // Tambahkan jumlah berdasarkan jenis kelamin
            // Jika jenis_kelamin NULL atau kosong, default ke Jantan
            if($jenis_kelamin == 'P' || $jenis_kelamin == 'PEREMPUAN' || $jenis_kelamin == 'FEMALE') {
                $peternak_data[$row->nik]['komoditas'][$komoditas]['betina'] += $jumlah;
            } else {
                // Default: L, LAKI-LAKI, MALE, NULL, atau apapun selain P
                $peternak_data[$row->nik]['komoditas'][$komoditas]['jantan'] += $jumlah;
            }
        }
        
        // Proses data untuk output
        $processed = [];
        foreach($peternak_data as $nik => $data) {
            $row_data = (object)[
                'nik' => $data['nik'],
                'nama_peternak' => $data['nama_peternak'],
                'alamat' => $data['alamat'],
                'kecamatan' => $data['kecamatan'],
                'kelurahan' => $data['kelurahan'],
                'tanggal_input' => $data['tanggal_input'],
                // Sapi Potong
                'sapi_potong_jantan' => $this->get_komoditas_value($data['komoditas'], 'Sapi Potong', 'jantan'),
                'sapi_potong_betina' => $this->get_komoditas_value($data['komoditas'], 'Sapi Potong', 'betina'),
                // Sapi Perah
                'sapi_perah_jantan' => $this->get_komoditas_value($data['komoditas'], 'Sapi Perah', 'jantan'),
                'sapi_perah_betina' => $this->get_komoditas_value($data['komoditas'], 'Sapi Perah', 'betina'),
                // Kambing
                'kambing_jantan' => $this->get_komoditas_value($data['komoditas'], 'Kambing', 'jantan'),
                'kambing_betina' => $this->get_komoditas_value($data['komoditas'], 'Kambing', 'betina'),
                // Domba
                'domba_jantan' => $this->get_komoditas_value($data['komoditas'], 'Domba', 'jantan'),
                'domba_betina' => $this->get_komoditas_value($data['komoditas'], 'Domba', 'betina'),
                // Kerbau
                'kerbau_jantan' => $this->get_komoditas_value($data['komoditas'], 'Kerbau', 'jantan'),
                'kerbau_betina' => $this->get_komoditas_value($data['komoditas'], 'Kerbau', 'betina'),
                // Kuda
                'kuda_jantan' => $this->get_komoditas_value($data['komoditas'], 'Kuda', 'jantan'),
                'kuda_betina' => $this->get_komoditas_value($data['komoditas'], 'Kuda', 'betina'),
                // Ayam
                'ayam_buras' => $this->get_total_komoditas($data['komoditas'], 'Ayam Buras'),
                'ayam_broiler' => $this->get_total_komoditas($data['komoditas'], 'Ayam Broiler') + $this->get_total_komoditas($data['komoditas'], 'Ayam Ras Pedaging'),
                'ayam_layer' => $this->get_total_komoditas($data['komoditas'], 'Ayam Layer') + $this->get_total_komoditas($data['komoditas'], 'Ayam Ras Petelur'),
                // Unggas Lainnya
                'itik' => $this->get_total_komoditas($data['komoditas'], 'Itik'),
                'angsa' => $this->get_total_komoditas($data['komoditas'], 'Angsa'),
                'kalkun' => $this->get_total_komoditas($data['komoditas'], 'Kalkun'),
                'burung' => $this->get_total_komoditas($data['komoditas'], 'Burung'),
                'lainnya' => 0
            ];
            
            $processed[] = $row_data;
        }
        
        return $processed;
    }
    
    private function get_komoditas_value($komoditas_data, $nama_komoditas, $jenis)
    {
        if(isset($komoditas_data[$nama_komoditas])) {
            return $komoditas_data[$nama_komoditas][$jenis];
        }
        return 0;
    }
    
    private function get_total_komoditas($komoditas_data, $nama_komoditas)
    {
        $total = 0;
        if(isset($komoditas_data[$nama_komoditas])) {
            $total = $komoditas_data[$nama_komoditas]['jantan'] + $komoditas_data[$nama_komoditas]['betina'];
        }
        return $total;
    }
    
    public function get_peternak_by_nik($nik)
    {
        $sql = "SELECT DISTINCT 
                    nik, nama_peternak, alamat, kecamatan, kelurahan
                FROM input_jenis_usaha 
                WHERE nik = " . $this->db->escape($nik) . "
                LIMIT 1";
        $query = $this->db->query($sql);
        
        if($query->num_rows() > 0) {
            return $query->row();
        }
        
        $sql2 = "SELECT nik, nama as nama_peternak, alamat, kecamatan, kelurahan 
                 FROM pelaku_usaha 
                 WHERE nik = " . $this->db->escape($nik);
        $query2 = $this->db->query($sql2);
        return $query2->row();
    }
    
    public function get_history_by_nik($nik)
    {
        $sql = "SELECT 
                    komoditas_ternak, 
                    jumlah, 
                    IFNULL(jenis_kelamin, 'L') as jenis_kelamin,
                    DATE_FORMAT(tanggal_input, '%d/%m/%Y') as tanggal,
                    tanggal_input as tanggal_full
                FROM input_jenis_usaha 
                WHERE nik = " . $this->db->escape($nik) . "
                ORDER BY tanggal_input DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }
}