<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_demplot_peternakan_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_kecamatan()
    {
        $query = $this->db->select('kecamatan')
                          ->distinct()
                          ->from('input_demplot')
                          ->where('kecamatan IS NOT NULL')
                          ->where('kecamatan !=', '')
                          ->order_by('kecamatan', 'ASC')
                          ->get();
        
        $result = [];
        foreach($query->result() as $row) {
            $result[] = (object)['kecamatan' => $row->kecamatan];
        }
        return $result;
    }

    public function get_demplot()
    {
        $query = $this->db->select('nama_demplot')
                          ->distinct()
                          ->from('input_demplot')
                          ->where('nama_demplot IS NOT NULL')
                          ->where('nama_demplot !=', '')
                          ->order_by('nama_demplot', 'ASC')
                          ->get();
        
        $result = [];
        foreach($query->result() as $row) {
            $result[] = (object)['nama_demplot' => $row->nama_demplot];
        }
        return $result;
    }

    public function get_tahun()
    {
        $query = $this->db->select('YEAR(created_at) as tahun')
                          ->distinct()
                          ->from('input_demplot')
                          ->where('created_at IS NOT NULL')
                          ->order_by('tahun', 'DESC')
                          ->get();
        
        $result = [];
        foreach($query->result() as $row) {
            if($row->tahun) {
                $result[] = (object)['tahun' => $row->tahun];
            }
        }
        
        if(empty($result)) {
            $currentYear = date('Y');
            for($i = $currentYear; $i >= $currentYear - 5; $i--) {
                $result[] = (object)['tahun' => $i];
            }
        }
        
        return $result;
    }

    public function get_data_demplot($tahun = null, $demplot_filter = null, $kecamatan_filter = null)
    {
        $this->db->from('input_demplot');
        
        // Jika tahun ada dan tidak 'semua' dan tidak kosong
        if($tahun && $tahun != '' && $tahun != null && $tahun != 'semua') {
            $this->db->where('YEAR(created_at)', $tahun);
        }
        
        if($demplot_filter && $demplot_filter != 'semua' && $demplot_filter != '') {
            $this->db->where('nama_demplot', $demplot_filter);
        }
        
        if($kecamatan_filter && $kecamatan_filter != 'semua' && $kecamatan_filter != '') {
            $this->db->where('kecamatan', $kecamatan_filter);
        }
        
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        
        return $query->result();
    }
    
    public function get_total_demplot($tahun, $demplot_filter, $kecamatan_filter)
    {
        $data = $this->get_data_demplot($tahun, $demplot_filter, $kecamatan_filter);
        
        $total_demplot = count($data);
        $total_luas = 0;
        $total_jumlah = 0;
        
        foreach($data as $row) {
            $total_luas += (float)$row->luas_m2;
            $total_jumlah += (int)$row->jumlah_hewan;
        } 
        
        return (object)[
            'total_demplot' => $total_demplot,
            'total_luas' => $total_luas,
            'total_jumlah' => $total_jumlah
        ];
    }
    
    public function get_detail_demplot($nama_demplot, $tahun = null)
    {
        $this->db->from('input_demplot');
        $this->db->where('nama_demplot', $nama_demplot);
        
        if($tahun && $tahun != '' && $tahun != null && $tahun != 'semua') {
            $this->db->where('YEAR(created_at)', $tahun);
        }
        
        $query = $this->db->get();
        return $query->result();
    }

    // ==================== METHOD UNTUK SEMUA DATA (TANPA FILTER) ====================
    public function get_all_data_demplot()
    {
        // Gunakan tabel yang BENAR: input_demplot (bukan demplot)
        $this->db->select('*');
        $this->db->from('input_demplot'); // <-- PERBAIKAN: ganti 'demplot' menjadi 'input_demplot'
        $this->db->order_by('nama_demplot', 'ASC');
        return $this->db->get()->result();
    }
}
?>