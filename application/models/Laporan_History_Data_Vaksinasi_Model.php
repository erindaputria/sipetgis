<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_history_data_vaksinasi_model extends CI_Model {

    protected $table = 'input_vaksinasi';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_kecamatan()
    {
        $this->db->distinct();
        $this->db->select('kecamatan');
        $this->db->from($this->table);
        $this->db->where('kecamatan IS NOT NULL');
        $this->db->where('kecamatan !=', '');
        $this->db->order_by('kecamatan', 'ASC');
        $query = $this->db->get();
        
        $result = $query->result();
        
        if(empty($result)) {
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
        }
        
        return $result;
    }

    public function get_tahun()
    {
        $this->db->distinct();
        $this->db->select("YEAR(tanggal_vaksinasi) as tahun");
        $this->db->from($this->table);
        $this->db->where('tanggal_vaksinasi IS NOT NULL');
        $this->db->order_by('tahun', 'DESC');
        $query = $this->db->get();
        
        $result = $query->result();
        
        if(empty($result)) {
            $currentYear = date('Y');
            $result = [];
            for($i = $currentYear; $i >= $currentYear - 5; $i--) {
                $result[] = (object)['tahun' => $i];
            }
        }
        
        return $result;
    }

    public function get_jenis_vaksin()
    {
        $this->db->distinct();
        $this->db->select('jenis_vaksinasi');
        $this->db->from($this->table);
        $this->db->where('jenis_vaksinasi IS NOT NULL');
        $this->db->where('jenis_vaksinasi !=', '');
        $this->db->order_by('jenis_vaksinasi', 'ASC');
        $query = $this->db->get();
        
        $result = $query->result();
        
        if(empty($result)) {
            $result = [
                (object)['jenis_vaksinasi' => 'PMK'],
                (object)['jenis_vaksinasi' => 'LSD'],
                (object)['jenis_vaksinasi' => 'ND-AI']
            ];
        }
        
        return $result;
    }

    public function get_jenis_hewan()
    {
        $this->db->distinct();
        $this->db->select('komoditas_ternak as jenis_hewan');
        $this->db->from($this->table);
        $this->db->where('komoditas_ternak IS NOT NULL');
        $this->db->where('komoditas_ternak !=', '');
        $this->db->order_by('komoditas_ternak', 'ASC');
        $query = $this->db->get();
        
        return $query->result();
    }

    public function get_history_data($tahun, $kecamatan_filter = null, $jenis_vaksin_filter = null, $jenis_hewan_filter = null)
    {
        $this->db->select('
            id_vaksinasi,
            tanggal_vaksinasi,
            nama_petugas,
            nama_peternak,
            nik,
            alamat,
            kecamatan,
            kelurahan,
            komoditas_ternak as jenis_hewan,
            jenis_vaksinasi,
            dosis,
            jumlah
        ');
        $this->db->from($this->table);
        
        if($tahun && $tahun != '') {
            $this->db->where("YEAR(tanggal_vaksinasi)", $tahun);
        }
        
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $this->db->where('kecamatan', $kecamatan_filter);
        }
        
        if($jenis_vaksin_filter && $jenis_vaksin_filter != 'semua') {
            if($jenis_vaksin_filter == 'PMK') {
                $this->db->like('jenis_vaksinasi', 'PMK', 'both');
            } elseif($jenis_vaksin_filter == 'LSD') {
                $this->db->like('jenis_vaksinasi', 'LSD', 'both');
            } elseif($jenis_vaksin_filter == 'ND-AI') {
                $this->db->like('jenis_vaksinasi', 'ND-AI', 'both');
            }
        }
        
        if($jenis_hewan_filter && $jenis_hewan_filter != 'semua') {
            $this->db->where('komoditas_ternak', $jenis_hewan_filter);
        }
        
        $this->db->order_by('tanggal_vaksinasi', 'DESC');
        $query = $this->db->get();
        
        $results = $query->result();
        
        $formatted_data = [];
        foreach($results as $item) {
            $tanggal = '-';
            if($item->tanggal_vaksinasi && $item->tanggal_vaksinasi != '0000-00-00') {
                $tanggal = date('d/m/Y', strtotime($item->tanggal_vaksinasi));
            }
            
            $formatted_data[] = (object)[
                'tanggal' => $tanggal,
                'petugas' => $item->nama_petugas ?: '-',
                'peternak' => $item->nama_peternak ?: '-',
                'nik' => $item->nik ?: '-',
                'alamat' => $item->alamat ?: '-',
                'kecamatan' => $item->kecamatan ?: '-',
                'kelurahan' => $item->kelurahan ?: '-',
                'jenis_hewan' => $item->jenis_hewan ?: '-',
                'jenis_vaksinasi' => $item->jenis_vaksinasi ?: '-',
                'dosis' => $item->dosis ?: '-',
                'jumlah' => $item->jumlah ? (int)$item->jumlah : 0
            ];
        }
        
        return $formatted_data;
    }
    
    public function get_total_dosis($tahun, $kecamatan_filter = null, $jenis_vaksin_filter = null, $jenis_hewan_filter = null)
    {
        $this->db->select('SUM(jumlah) as total_dosis');
        $this->db->from($this->table);
        
        if($tahun && $tahun != '') {
            $this->db->where("YEAR(tanggal_vaksinasi)", $tahun);
        }
        
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $this->db->where('kecamatan', $kecamatan_filter);
        }
        
        if($jenis_vaksin_filter && $jenis_vaksin_filter != 'semua') {
            if($jenis_vaksin_filter == 'PMK') {
                $this->db->like('jenis_vaksinasi', 'PMK', 'both');
            } elseif($jenis_vaksin_filter == 'LSD') {
                $this->db->like('jenis_vaksinasi', 'LSD', 'both');
            } elseif($jenis_vaksin_filter == 'ND-AI') {
                $this->db->like('jenis_vaksinasi', 'ND-AI', 'both');
            }
        }
        
        if($jenis_hewan_filter && $jenis_hewan_filter != 'semua') {
            $this->db->where('komoditas_ternak', $jenis_hewan_filter);
        }
        
        $query = $this->db->get();
        $result = $query->row();
        
        return $result->total_dosis ? (int)$result->total_dosis : 0;
    }

    public function get_all_history_data()
    {
        $this->db->select('
            id_vaksinasi,
            tanggal_vaksinasi,
            nama_petugas,
            nama_peternak,
            nik,
            alamat,
            kecamatan,
            kelurahan,
            komoditas_ternak as jenis_hewan,
            jenis_vaksinasi,
            dosis,
            jumlah
        ');
        $this->db->from($this->table);
        $this->db->order_by('tanggal_vaksinasi', 'DESC');
        $query = $this->db->get();
        
        $results = $query->result();
        
        $formatted_data = [];
        foreach($results as $item) {
            $tanggal = '-';
            if($item->tanggal_vaksinasi && $item->tanggal_vaksinasi != '0000-00-00') {
                $tanggal = date('d/m/Y', strtotime($item->tanggal_vaksinasi));
            }
            
            $formatted_data[] = (object)[
                'tanggal' => $tanggal,
                'petugas' => $item->nama_petugas ?: '-',
                'peternak' => $item->nama_peternak ?: '-',
                'nik' => $item->nik ?: '-',
                'alamat' => $item->alamat ?: '-',
                'kecamatan' => $item->kecamatan ?: '-',
                'kelurahan' => $item->kelurahan ?: '-',
                'jenis_hewan' => $item->jenis_hewan ?: '-',
                'jenis_vaksinasi' => $item->jenis_vaksinasi ?: '-',
                'dosis' => $item->dosis ?: '-',
                'jumlah' => $item->jumlah ? (int)$item->jumlah : 0
            ];
        }
        
        return $formatted_data;
    }

    public function get_all_total_dosis()
    {
        $this->db->select('SUM(jumlah) as total');
        $this->db->from($this->table);
        $result = $this->db->get()->row();
        return $result->total ?? 0;
    }
}
?>