<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_vaksinasi_model extends CI_Model {
    
    protected $table = 'input_vaksinasi';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_all_vaksinasi()
    {
        $this->db->select('
            jenis_vaksinasi, 
            YEAR(tanggal_vaksinasi) as tahun,
            SUM(jumlah) as total_jumlah 
        ');
        $this->db->from($this->table);
        $this->db->group_by(['jenis_vaksinasi', 'YEAR(tanggal_vaksinasi)']);
        $this->db->order_by('tahun', 'DESC');
        $this->db->order_by('jenis_vaksinasi', 'ASC');
        
        $query = $this->db->get();
        $results = $query->result();
        
        $formatted = [];
        $no = 1;
        foreach($results as $row) {
            $formatted[] = [
                'no' => $no++,
                'nama_kegiatan' => $row->jenis_vaksinasi,
                'tahun' => $row->tahun,
                'jumlah_ternak' => $row->total_jumlah,
                'jenis_vaksinasi' => $row->jenis_vaksinasi
            ];
        }
        
        return $formatted;
    }
    
    public function get_detail_vaksinasi($jenis_vaksin, $tahun)
    {
        $this->db->select('
            id_vaksinasi,
            nama_peternak,
            komoditas_ternak,
            kecamatan,
            kelurahan,
            jumlah,
            tanggal_vaksinasi
        ');
        $this->db->from($this->table);
        $this->db->where('jenis_vaksinasi', $jenis_vaksin);
        $this->db->where("YEAR(tanggal_vaksinasi)", $tahun);
        $this->db->order_by('tanggal_vaksinasi', 'DESC');
        
        $query = $this->db->get();
        $results = $query->result();
        
        $formatted = [];
        $no = 1;
        foreach($results as $row) {
            $formatted[] = [
                'no' => $no++,
                'nama_peternak' => $row->nama_peternak,
                'komoditas_ternak' => $row->komoditas_ternak,
                'kecamatan' => $row->kecamatan . ' / ' . $row->kelurahan,
                'jumlah' => $row->jumlah,
                'tanggal_vaksinasi' => date('d-m-Y', strtotime($row->tanggal_vaksinasi))
            ];
        }
        
        return $formatted;
    }
    
    public function get_vaksinasi_by_komoditas($komoditas)
{
    // Jika komoditas 'all', tampilkan semua data
    if ($komoditas == 'all' || empty($komoditas)) {
        return $this->get_all_vaksinasi();
    }
    
    // Query: filter langsung berdasarkan komoditas_ternak
    $this->db->select('
        jenis_vaksinasi, 
        YEAR(tanggal_vaksinasi) as tahun,
        SUM(jumlah) as total_jumlah
    ');
    $this->db->from($this->table);
    $this->db->where('komoditas_ternak', $komoditas);
    $this->db->group_by(['jenis_vaksinasi', 'YEAR(tanggal_vaksinasi)']);
    $this->db->order_by('tahun', 'DESC');
    $this->db->order_by('jenis_vaksinasi', 'ASC');
    
    $query = $this->db->get();
    $results = $query->result();
    
    $formatted = [];
    $no = 1;
    foreach($results as $row) {
        $formatted[] = [
            'no' => $no++,
            'nama_kegiatan' => $row->jenis_vaksinasi,
            'tahun' => $row->tahun,
            'jumlah_ternak' => $row->total_jumlah,
            'jenis_vaksinasi' => $row->jenis_vaksinasi,
            'komoditas_filter' => $komoditas
        ];
    }
    
    return $formatted;
}
    
    public function get_distinct_komoditas()
    {
        $this->db->distinct();
        $this->db->select('komoditas_ternak');
        $this->db->from($this->table);
        $this->db->where('komoditas_ternak IS NOT NULL');
        $this->db->where('komoditas_ternak !=', '');
        $this->db->order_by('komoditas_ternak', 'ASC');
        
        $query = $this->db->get();
        return $query->result();
    }
}