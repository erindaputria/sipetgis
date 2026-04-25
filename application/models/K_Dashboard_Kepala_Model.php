<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class K_dashboard_kepala_model extends CI_Model {
    
    private $table_input_jenis_usaha = 'input_jenis_usaha';
    private $table_input_vaksinasi = 'input_vaksinasi';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Count total pelaku usaha (unique berdasarkan NIK)
     */ 
    public function count_pelaku_usaha() {
        $this->db->select('COUNT(DISTINCT nik) as total');
        $query = $this->db->get($this->table_input_jenis_usaha);
        $result = $query->row();
        return (int)($result->total ?? 0);
    }
    
    /**
     * Count total jenis ternak/komoditas (unique)
     */
    public function count_jenis_usaha() {
        $this->db->select('COUNT(DISTINCT komoditas_ternak) as total');
        $query = $this->db->get($this->table_input_jenis_usaha);
        $result = $query->row();
        return (int)($result->total ?? 0);
    }
    
    /**
     * Get statistik per kecamatan (5 kecamatan teratas)
     */
    public function get_statistik_per_kecamatan() {
        // Ambil 5 kecamatan dengan jumlah peternak terbanyak
        $this->db->select('kecamatan, COUNT(DISTINCT nik) as jumlah_peternak');
        $this->db->group_by('kecamatan');
        $this->db->order_by('jumlah_peternak', 'DESC');
        $this->db->limit(5);
        $top_kecamatan_query = $this->db->get($this->table_input_jenis_usaha);
        $top_kecamatan = $top_kecamatan_query->result();
        
        $result = [];
        
        foreach ($top_kecamatan as $kec) {
            $row = $this->get_kecamatan_statistik($kec->kecamatan);
            if ($row) {
                $result[] = $row;
            }
        }
        
        return $result;
    }
    
    /**
     * Get statistik untuk satu kecamatan
     */
    public function get_kecamatan_statistik($kecamatan) {
        // Get all komoditas data for this kecamatan
        $this->db->select('komoditas_ternak, SUM(jumlah) as total_jumlah');
        $this->db->where('kecamatan', $kecamatan);
        $this->db->group_by('komoditas_ternak');
        $query = $this->db->get($this->table_input_jenis_usaha);
        $komoditas_data = $query->result();
        
        // Count unique peternak in this kecamatan
        $this->db->select('COUNT(DISTINCT nik) as jumlah_peternak');
        $this->db->where('kecamatan', $kecamatan);
        $peternak_query = $this->db->get($this->table_input_jenis_usaha);
        $jumlah_peternak = (int)($peternak_query->row()->jumlah_peternak ?? 0);
        
        if ($jumlah_peternak == 0 && empty($komoditas_data)) {
            return null;
        }
        
        // Initialize all komoditas with 0
        $komoditas = [
            'Sapi Potong' => 0,
            'Sapi Perah' => 0,
            'Kambing' => 0,
            'Domba' => 0,
            'Ayam Buras' => 0,
            'Ayam Broiler' => 0,
            'Ayam Layer' => 0,
            'Itik' => 0,
            'Angsa' => 0,
            'Kalkun' => 0,
            'Burung' => 0,
            'Kerbau' => 0,
            'Kuda' => 0
        ];
        
        // Fill with actual data
        foreach ($komoditas_data as $kd) {
            $komoditas_name = trim($kd->komoditas_ternak);
            if (isset($komoditas[$komoditas_name])) {
                $komoditas[$komoditas_name] = (int)$kd->total_jumlah;
            }
        }
        
        // Generate jenis ternak string (komoditas yang memiliki jumlah > 0)
        $jenis_ternak_array = [];
        foreach ($komoditas as $key => $value) {
            if ($value > 0) {
                $jenis_ternak_array[] = $key;
            }
        }
        $jenis_ternak = implode(', ', $jenis_ternak_array);
        
        return (object)[
            'kecamatan' => $kecamatan,
            'jumlah_peternak' => $jumlah_peternak,
            'jenis_ternak' => $jenis_ternak ?: '-',
            'Sapi Potong' => $komoditas['Sapi Potong'],
            'Sapi Perah' => $komoditas['Sapi Perah'],
            'Kambing' => $komoditas['Kambing'],
            'Domba' => $komoditas['Domba'],
            'Ayam Buras' => $komoditas['Ayam Buras'],
            'Ayam Broiler' => $komoditas['Ayam Broiler'],
            'Ayam Layer' => $komoditas['Ayam Layer'],
            'Itik' => $komoditas['Itik'],
            'Angsa' => $komoditas['Angsa'],
            'Kalkun' => $komoditas['Kalkun'],
            'Burung' => $komoditas['Burung'],
            'Kerbau' => $komoditas['Kerbau'],
            'Kuda' => $komoditas['Kuda']
        ];
    }
    
    /**
     * Get all kecamatan list (31 Kecamatan Surabaya)
     */
    public function get_all_kecamatan() {
        return [
            'Karang Pilang', 'Jambangan', 'Gayungan', 'Wonocolo', 'Tenggilis Mejoyo',
            'Gunung Anyar', 'Rungkut', 'Sukolilo', 'Mulyorejo', 'Gubeng',
            'Wonokromo', 'Dukuh Pakis', 'Wiyung', 'Lakarsantri', 'Sambikerep',
            'Tandes', 'Sukomanunggal', 'Sawahan', 'Tegalsari', 'Genteng',
            'Bubutan', 'Krembangan', 'Semampir', 'Kenjeran', 'Bulak',
            'Tambaksari', 'Simokerto', 'Pabean Cantian', 'Kandangan', 'Benowo', 'Pakal'
        ];
    }
    
    /**
     * Get total per komoditas (untuk footer/total keseluruhan)
     */
    public function get_total_per_komoditas() {
        $this->db->select('komoditas_ternak, SUM(jumlah) as total');
        $this->db->group_by('komoditas_ternak');
        $query = $this->db->get($this->table_input_jenis_usaha);
        $result = $query->result();
        
        $totals = [
            'Sapi Potong' => 0,
            'Sapi Perah' => 0,
            'Kambing' => 0,
            'Domba' => 0,
            'Ayam Buras' => 0,
            'Ayam Broiler' => 0,
            'Ayam Layer' => 0,
            'Itik' => 0,
            'Angsa' => 0,
            'Kalkun' => 0,
            'Burung' => 0,
            'Kerbau' => 0,
            'Kuda' => 0
        ];
        
        foreach ($result as $row) {
            $komoditas_name = trim($row->komoditas_ternak);
            if (isset($totals[$komoditas_name])) {
                $totals[$komoditas_name] = (int)$row->total;
            }
        }
        
        return $totals;
    }
    
    /**
     * Get total peternak keseluruhan
     */
    public function get_total_peternak() {
        $this->db->select('COUNT(DISTINCT nik) as total');
        $query = $this->db->get($this->table_input_jenis_usaha);
        return (int)($query->row()->total ?? 0);
    }
    
    /**
     * Get statistik vaksinasi per jenis vaksin
     */
    public function get_statistik_vaksinasi() {
        $this->db->select('jenis_vaksinasi, SUM(jumlah) as total_jumlah');
        $this->db->group_by('jenis_vaksinasi');
        $query = $this->db->get($this->table_input_vaksinasi);
        $result = $query->result();
        
        $vaksinasi = [
            'PMK' => 0,
            'ND/AI' => 0,
            'LSD' => 0
        ];
        
        foreach ($result as $row) {
            $jenis = trim($row->jenis_vaksinasi);
            if ($jenis == 'PMK' || $jenis == 'Penyakit Mulut dan Kuku') {
                $vaksinasi['PMK'] = (int)$row->total_jumlah;
            } elseif ($jenis == 'ND/AI' || $jenis == 'Newcastle Disease/Avian Influenza') {
                $vaksinasi['ND/AI'] = (int)$row->total_jumlah;
            } elseif ($jenis == 'LSD' || $jenis == 'Lumpy Skin Disease') {
                $vaksinasi['LSD'] = (int)$row->total_jumlah;
            }
        }
        
        return $vaksinasi;
    }
    
    /**
     * Get total vaksinasi PMK
     */
    public function get_total_vaksinasi_pmk() {
        $this->db->select('SUM(jumlah) as total');
        $this->db->group_start();
        $this->db->like('jenis_vaksinasi', 'PMK', 'both');
        $this->db->or_like('jenis_vaksinasi', 'Penyakit Mulut', 'both');
        $this->db->group_end();
        $query = $this->db->get($this->table_input_vaksinasi);
        $result = $query->row();
        return (int)($result->total ?? 0);
    }

    /**
     * Get total vaksinasi ND/AI
     */
    public function get_total_vaksinasi_ndai() {
        $this->db->select('SUM(jumlah) as total');
        $this->db->group_start();
        $this->db->like('jenis_vaksinasi', 'ND-AI', 'both');
        $this->db->or_like('jenis_vaksinasi', 'Newcastle', 'both');
        $this->db->group_end();
        $query = $this->db->get($this->table_input_vaksinasi);
        $result = $query->row();
        return (int)($result->total ?? 0);
    }

    /**
     * Get total vaksinasi LSD
     */
    public function get_total_vaksinasi_lsd() {
        $this->db->select('SUM(jumlah) as total');
        $this->db->group_start();
        $this->db->like('jenis_vaksinasi', 'LSD', 'both');
        $this->db->or_like('jenis_vaksinasi', 'Lumpy', 'both');
        $this->db->group_end();
        $query = $this->db->get($this->table_input_vaksinasi);
        $result = $query->row();
        return (int)($result->total ?? 0);
    }
    
    /**
     * Get persentase vaksinasi
     */
    public function get_persentase_vaksinasi($jenis) {
        $target = [
            'PMK' => 100000,
            'ND/AI' => 100000,
            'LSD' => 100000
        ];
        
        $total = 0;
        if ($jenis == 'PMK') {
            $total = $this->get_total_vaksinasi_pmk();
        } elseif ($jenis == 'ND/AI') {
            $total = $this->get_total_vaksinasi_ndai();
        } elseif ($jenis == 'LSD') {
            $total = $this->get_total_vaksinasi_lsd();
        }
        
        if ($target[$jenis] > 0) {
            return round(($total / $target[$jenis]) * 100);
        }
        return 0;
    }
    
    /**
     * Get data pelaku usaha per kecamatan (untuk modal detail)
     */
    public function get_pelaku_usaha_per_kecamatan() {
        $this->db->select('kecamatan, COUNT(DISTINCT nik) as jumlah_pelaku');
        $this->db->group_by('kecamatan');
        $this->db->order_by('kecamatan', 'ASC');
        $query = $this->db->get($this->table_input_jenis_usaha);
        $result = $query->result();
        
        $all_kecamatan = $this->get_all_kecamatan();
        
        $data_map = [];
        foreach ($result as $row) {
            $data_map[$row->kecamatan] = $row->jumlah_pelaku;
        }
        
        $final_result = [];
        $no = 1;
        foreach ($all_kecamatan as $kecamatan) {
            $final_result[] = (object)[
                'no' => $no++,
                'kecamatan' => $kecamatan,
                'pelaku_usaha' => isset($data_map[$kecamatan]) ? (int)$data_map[$kecamatan] : 0
            ];
        }
        
        return $final_result;
    }
    
    /**
     * Get total pelaku usaha seluruh kecamatan
     */
    public function get_total_pelaku_usaha_all() {
        $this->db->select('COUNT(DISTINCT nik) as total');
        $query = $this->db->get($this->table_input_jenis_usaha);
        $result = $query->row();
        return (int)($result->total ?? 0);
    }
    
    /**
     * Get data detail pelaku usaha per kecamatan (untuk modal 31 kecamatan lengkap)
     */
    public function get_detail_pelaku_usaha_per_kecamatan() {
        $this->db->select('kecamatan, COUNT(DISTINCT nik) as jumlah_pelaku');
        $this->db->group_by('kecamatan');
        $this->db->order_by('kecamatan', 'ASC');
        $query = $this->db->get($this->table_input_jenis_usaha);
        $result = $query->result();
        
        $all_kecamatan = $this->get_all_kecamatan();
        
        $data_map = [];
        foreach ($result as $row) {
            $data_map[$row->kecamatan] = $row->jumlah_pelaku;
        }
        
        $final_result = [];
        $no = 1;
        foreach ($all_kecamatan as $kecamatan) {
            $jenis_ternak = $this->get_jenis_ternak_by_kecamatan($kecamatan);
            
            $final_result[] = (object)[
                'no' => $no++,
                'kecamatan' => $kecamatan,
                'pelaku_usaha' => isset($data_map[$kecamatan]) ? (int)$data_map[$kecamatan] : 0,
                'jenis_ternak' => $jenis_ternak
            ];
        }
        
        return $final_result;
    }
    
    /**
     * Get jenis ternak berdasarkan kecamatan
     */
    public function get_jenis_ternak_by_kecamatan($kecamatan) {
        $this->db->distinct();
        $this->db->select('komoditas_ternak');
        $this->db->where('kecamatan', $kecamatan);
        $query = $this->db->get($this->table_input_jenis_usaha);
        $result = $query->result();
        
        $jenis_ternak = [];
        foreach ($result as $row) {
            if (!empty($row->komoditas_ternak)) {
                $jenis_ternak[] = $row->komoditas_ternak;
            }
        }
        
        return !empty($jenis_ternak) ? implode(', ', $jenis_ternak) : '-';
    }

    /**
     * Get data untuk chart (31 kecamatan dengan jumlah pelaku usaha)
     */
    public function get_data_for_chart() {
        $all_kecamatan = $this->get_all_kecamatan();
        
        $this->db->select('kecamatan, COUNT(DISTINCT nik) as jumlah_pelaku');
        $this->db->group_by('kecamatan');
        $query = $this->db->get($this->table_input_jenis_usaha);
        $result = $query->result();
        
        $data_map = [];
        foreach ($result as $row) {
            $data_map[$row->kecamatan] = (int)$row->jumlah_pelaku;
        }
        
        $labels = [];
        $data = [];
        
        foreach ($all_kecamatan as $kecamatan) {
            $labels[] = $kecamatan;
            $data[] = isset($data_map[$kecamatan]) ? $data_map[$kecamatan] : 0;
        }
        
        return (object)[
            'labels' => $labels,
            'data' => $data
        ];
    }

    /**
     * Get total klinik hewan
     */
    public function get_total_klinik_hewan() {
        if (!$this->db->table_exists('input_klinik_hewan')) {
            return 0;
        }
        return $this->db->count_all('input_klinik_hewan');
    }

    /**
     * Get total penjual obat hewan
     */
    public function get_total_penjual_obat() {
        if (!$this->db->table_exists('penjual')) {
            return 0;
        }
        $this->db->select('COUNT(id_penjual) as total');
        $this->db->where('dagangan', 'Obat');
        $query = $this->db->get('penjual');
        $result = $query->row();
        return (int)($result->total ?? 0);
    }

    /**
     * Get total penjual pakan
     */
    public function get_total_penjual_pakan() {
        if (!$this->db->table_exists('penjual')) {
            return 0;
        }
        $this->db->select('COUNT(id_penjual) as total');
        $this->db->where('dagangan', 'Pakan');
        $query = $this->db->get('penjual');
        $result = $query->row();
        return (int)($result->total ?? 0);
    }

    /**
     * Get data klinik hewan per kecamatan
     */
    public function get_klinik_hewan_per_kecamatan() {
        if (!$this->db->table_exists('input_klinik_hewan')) {
            return [];
        }
        
        $fields = $this->db->list_fields('input_klinik_hewan');
        if (!in_array('kecamatan', $fields)) {
            return [];
        }
        
        $this->db->select('kecamatan, COUNT(*) as jumlah');
        $this->db->group_by('kecamatan');
        $query = $this->db->get('input_klinik_hewan');
        $result = $query->result();
        
        $data = [];
        foreach ($result as $row) {
            $data[$row->kecamatan] = (int)$row->jumlah;
        }
        return $data;
    }

    /**
     * Get data penjual obat per kecamatan
     */
    public function get_penjual_obat_per_kecamatan() {
        if (!$this->db->table_exists('penjual')) {
            return [];
        }
        
        $fields = $this->db->list_fields('penjual');
        if (!in_array('kecamatan', $fields)) {
            return [];
        }
        
        $this->db->select('kecamatan, COUNT(*) as jumlah');
        $this->db->where('dagangan', 'Obat');
        $this->db->group_by('kecamatan');
        $query = $this->db->get('penjual');
        $result = $query->result();
        
        $data = [];
        foreach ($result as $row) {
            $data[$row->kecamatan] = (int)$row->jumlah;
        }
        return $data;
    }

    /**
     * Get data penjual pakan per kecamatan
     */
    public function get_penjual_pakan_per_kecamatan() {
        if (!$this->db->table_exists('penjual')) {
            return [];
        }
        
        $fields = $this->db->list_fields('penjual');
        if (!in_array('kecamatan', $fields)) {
            return [];
        }
        
        $this->db->select('kecamatan, COUNT(*) as jumlah');
        $this->db->where('dagangan', 'Pakan');
        $this->db->group_by('kecamatan');
        $query = $this->db->get('penjual');
        $result = $query->result();
        
        $data = [];
        foreach ($result as $row) {
            $data[$row->kecamatan] = (int)$row->jumlah;
        }
        return $data;
    }

    /**
     * Get data vaksinasi per kecamatan (detail)
     */
    public function get_vaksinasi_per_kecamatan_detail() {
        if (!$this->db->table_exists('input_vaksinasi')) {
            return [];
        }
        
        $fields = $this->db->list_fields('input_vaksinasi');
        if (!in_array('kecamatan', $fields)) {
            return [];
        }
        
        $this->db->select('kecamatan, jenis_vaksinasi, SUM(jumlah) as total');
        $this->db->group_by(array('kecamatan', 'jenis_vaksinasi'));
        $query = $this->db->get('input_vaksinasi');
        $result = $query->result();
        
        $data = [];
        foreach ($result as $row) {
            if (!isset($data[$row->kecamatan])) {
                $data[$row->kecamatan] = array('PMK' => 0, 'ND-AI' => 0, 'LSD' => 0);
            }
            $jenis = strtolower($row->jenis_vaksinasi);
            if (strpos($jenis, 'pmk') !== false || strpos($jenis, 'mulut') !== false) {
                $data[$row->kecamatan]['PMK'] = (int)$row->total;
            } elseif (strpos($jenis, 'nd') !== false || strpos($jenis, 'newcastle') !== false) {
                $data[$row->kecamatan]['ND-AI'] = (int)$row->total;
            } elseif (strpos($jenis, 'lsd') !== false || strpos($jenis, 'lumpy') !== false) {
                $data[$row->kecamatan]['LSD'] = (int)$row->total;
            }
        }
        return $data;
    }

    /**
     * Get total RPU/TPU per kecamatan
     */
    public function get_rpu_tpu_per_kecamatan() {
        if (!$this->db->table_exists('rpu_tpu')) {
            return [];
        }
        
        $fields = $this->db->list_fields('rpu_tpu');
        if (!in_array('kecamatan', $fields)) {
            return [];
        }
        
        $this->db->select('kecamatan, COUNT(*) as jumlah');
        $this->db->group_by('kecamatan');
        $query = $this->db->get('rpu_tpu');
        $result = $query->result();
        
        $data = [];
        foreach ($result as $row) {
            $data[$row->kecamatan] = (int)$row->jumlah;
        }
        return $data;
    }

        /**
     * Get total RPU/TPU
     */
    public function get_total_rpu_tpu() {
        // Cek apakah tabel rpu_tpu ada
        if (!$this->db->table_exists('rpu_tpu')) {
            return 5; // Return default value jika tabel tidak ada
        }
        
        $total = $this->db->count_all('rpu_tpu');
        return $total > 0 ? $total : 5; // Return 5 jika tidak ada data (opsional)
    }
}
?>