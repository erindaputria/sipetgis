<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_stok_pakan_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_demplot()
    {
        // Ambil dari tabel input_demplot
        $query = $this->db->select('id_demplot, nama_demplot')
            ->from('input_demplot')
            ->where('nama_demplot IS NOT NULL')
            ->where('nama_demplot !=', '')
            ->order_by('nama_demplot', 'ASC')
            ->get();
        
        if($query->num_rows() > 0) {
            return $query->result();
        }
        
        return [];
    }

    public function get_tahun()
    {
        // Ambil tahun dari input_stok_pakan
        $query = $this->db->select('DISTINCT YEAR(tanggal) as tahun')
            ->from('input_stok_pakan')
            ->where('tanggal IS NOT NULL')
            ->order_by('tahun', 'DESC')
            ->get();
        
        if($query->num_rows() > 0) {
            return $query->result();
        }
        
        return [];
    }

    public function get_data_stok_pakan($tahun, $demplot_filter = null)
    {
        // Query dengan JOIN ke input_demplot
        $this->db->select('
            sp.id_stok,
            sp.tanggal,
            sp.id_demplot,
            d.nama_demplot,
            sp.jenis_pakan,
            sp.merk_pakan,
            sp.stok_awal,
            sp.stok_masuk,
            sp.stok_keluar,
            sp.stok_akhir,
            sp.keterangan
        ');
        $this->db->from('input_stok_pakan sp');
        $this->db->join('input_demplot d', 'd.id_demplot = sp.id_demplot', 'left');
        
        if($tahun && $tahun != '') {
            $this->db->where('YEAR(sp.tanggal)', $tahun);
        }
        
        if($demplot_filter && $demplot_filter != 'semua' && $demplot_filter != '') {
            $this->db->where('sp.id_demplot', $demplot_filter);
        }
        
        $this->db->order_by('sp.tanggal', 'ASC');
        $this->db->order_by('d.nama_demplot', 'ASC');
        
        $query = $this->db->get();
        
        if($query->num_rows() > 0) {
            $result = $query->result();
            // Handle NULL nama_demplot
            foreach($result as $row) {
                if(empty($row->nama_demplot)) {
                    $row->nama_demplot = '-';
                }
            }
            return $result;
        }
        
        return [];
    }
    
    public function get_total_stok_pakan($tahun, $demplot_filter)
    {
        $data = $this->get_data_stok_pakan($tahun, $demplot_filter);
        
        $total_stok_awal = 0;
        $total_stok_masuk = 0;
        $total_stok_keluar = 0;
        $total_stok_akhir = 0;
        
        foreach($data as $row) {
            $total_stok_awal += (int)$row->stok_awal;
            $total_stok_masuk += (int)$row->stok_masuk; 
            $total_stok_keluar += (int)$row->stok_keluar;
            $total_stok_akhir += (int)$row->stok_akhir;
        }
        
        return (object)[
            'total_stok_awal' => $total_stok_awal,
            'total_stok_masuk' => $total_stok_masuk,
            'total_stok_keluar' => $total_stok_keluar,
            'total_stok_akhir' => $total_stok_akhir, 
            'total_transaksi' => count($data)
        ];
    }

    // ==================== METHOD UNTUK SEMUA DATA (TANPA FILTER) ====================
    public function get_all_data_stok_pakan()
    {
        // PERBAIKAN: Gunakan tabel yang BENAR: input_stok_pakan
        $this->db->select('
            sp.id_stok,
            sp.tanggal,
            sp.id_demplot,
            d.nama_demplot,
            sp.jenis_pakan,
            sp.merk_pakan,
            sp.stok_awal,
            sp.stok_masuk,
            sp.stok_keluar,
            sp.stok_akhir,
            sp.keterangan
        ');
        $this->db->from('input_stok_pakan sp');
        $this->db->join('input_demplot d', 'd.id_demplot = sp.id_demplot', 'left');
        $this->db->order_by('sp.tanggal', 'DESC');
        $this->db->order_by('d.nama_demplot', 'ASC');
        
        $query = $this->db->get();
        
        if($query->num_rows() > 0) {
            $result = $query->result();
            // Handle NULL nama_demplot
            foreach($result as $row) {
                if(empty($row->nama_demplot)) {
                    $row->nama_demplot = '-';
                }
            }
            return $result;
        }
        
        return [];
    }

    public function get_all_total_stok_pakan()
    {
        $data = $this->get_all_data_stok_pakan();
        
        $total_stok_awal = 0;
        $total_stok_masuk = 0;
        $total_stok_keluar = 0;
        $total_stok_akhir = 0;
        
        foreach($data as $row) {
            $total_stok_awal += (int)$row->stok_awal;
            $total_stok_masuk += (int)$row->stok_masuk;
            $total_stok_keluar += (int)$row->stok_keluar;
            $total_stok_akhir += (int)$row->stok_akhir;
        }
        
        return (object)[
            'total_stok_awal' => $total_stok_awal,
            'total_stok_masuk' => $total_stok_masuk,
            'total_stok_keluar' => $total_stok_keluar,
            'total_stok_akhir' => $total_stok_akhir,
            'total_transaksi' => count($data)
        ];
    }
}
?>