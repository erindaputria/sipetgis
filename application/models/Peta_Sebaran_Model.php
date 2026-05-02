<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peta_sebaran_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Get all kecamatan
    public function get_all_kecamatan()
    {
        $kecamatan = $this->db->get('kecamatan')->result_array();
        if (empty($kecamatan)) {
            $kecamatan = [
                ['id' => 1, 'nama_kecamatan' => 'Asemrowo'],
                ['id' => 2, 'nama_kecamatan' => 'Benowo'],
                ['id' => 3, 'nama_kecamatan' => 'Bubutan'],
                ['id' => 4, 'nama_kecamatan' => 'Bulak'],
                ['id' => 5, 'nama_kecamatan' => 'Dukuh Pakis'],
                ['id' => 6, 'nama_kecamatan' => 'Gayungan'],
                ['id' => 7, 'nama_kecamatan' => 'Genteng'],
                ['id' => 8, 'nama_kecamatan' => 'Gubeng'],
                ['id' => 9, 'nama_kecamatan' => 'Gununganyar'],
                ['id' => 10, 'nama_kecamatan' => 'Jambangan'],
                ['id' => 11, 'nama_kecamatan' => 'Karangpilang'],
                ['id' => 12, 'nama_kecamatan' => 'Kenjeran'],
                ['id' => 13, 'nama_kecamatan' => 'Krembangan'],
                ['id' => 14, 'nama_kecamatan' => 'Lakarsantri'],
                ['id' => 15, 'nama_kecamatan' => 'Mulyorejo'],
                ['id' => 16, 'nama_kecamatan' => 'Pabean Cantian'],
                ['id' => 17, 'nama_kecamatan' => 'Pakal'],
                ['id' => 18, 'nama_kecamatan' => 'Rungkut'],
                ['id' => 19, 'nama_kecamatan' => 'Sambikerep'],
                ['id' => 20, 'nama_kecamatan' => 'Sawahan'],
                ['id' => 21, 'nama_kecamatan' => 'Semampir'],
                ['id' => 22, 'nama_kecamatan' => 'Simokerto'],
                ['id' => 23, 'nama_kecamatan' => 'Sukolilo'],
                ['id' => 24, 'nama_kecamatan' => 'Sukomanunggal'],
                ['id' => 25, 'nama_kecamatan' => 'Tambaksari'],
                ['id' => 26, 'nama_kecamatan' => 'Tandes'],
                ['id' => 27, 'nama_kecamatan' => 'Tegalsari'],
                ['id' => 28, 'nama_kecamatan' => 'Tenggilis Mejoyo'],
                ['id' => 29, 'nama_kecamatan' => 'Wiyung'],
                ['id' => 30, 'nama_kecamatan' => 'Wonocolo'],
                ['id' => 31, 'nama_kecamatan' => 'Wonokromo']
            ];
        }
        return $kecamatan;
    }

    // ============================================
    // PENGOBATAN
    // ============================================
    
    public function get_filtered_pengobatan($kecamatan = [], $tgl_mulai = null, $tgl_selesai = null)
    {
        $this->db->select('*');
        $this->db->from('input_pengobatan');
        
        if (!empty($kecamatan) && is_array($kecamatan)) {
            $this->db->group_start();
            foreach ($kecamatan as $kec) {
                $this->db->or_like('kecamatan', $kec, 'both');
            }
            $this->db->group_end();
        }
        
        if ($tgl_mulai && $tgl_selesai) {
            $this->db->where('tanggal_pengobatan >=', $tgl_mulai);
            $this->db->where('tanggal_pengobatan <=', $tgl_selesai);
        }
        
        $this->db->order_by('tanggal_pengobatan', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_detail_pengobatan($id)
    {
        return $this->db->get_where('input_pengobatan', ['id' => $id])->row_array();
    }

    // ============================================
    // VAKSINASI
    // ============================================

    public function get_filtered_vaksinasi($kecamatan = [], $tgl_mulai = null, $tgl_selesai = null)
    {
        $this->db->select('*');
        $this->db->from('input_vaksinasi');
        
        if (!empty($kecamatan) && is_array($kecamatan)) {
            $this->db->group_start();
            foreach ($kecamatan as $kec) {
                $this->db->or_like('kecamatan', $kec, 'both');
            }
            $this->db->group_end();
        }
        
        if ($tgl_mulai && $tgl_selesai) {
            $this->db->where('tanggal_vaksinasi >=', $tgl_mulai);
            $this->db->where('tanggal_vaksinasi <=', $tgl_selesai);
        }
        
        $this->db->order_by('tanggal_vaksinasi', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_detail_vaksinasi($id)
    {
        return $this->db->get_where('input_vaksinasi', ['id_vaksinasi' => $id])->row_array();
    }

    // ============================================
    // PELAKU USAHA
    // ============================================

    public function get_filtered_pelaku_usaha($kecamatan = [])
    {
        $this->db->select('*');
        $this->db->from('pelaku_usaha');
        
        if (!empty($kecamatan) && is_array($kecamatan)) {
            $this->db->group_start();
            foreach ($kecamatan as $kec) {
                $this->db->or_like('kecamatan', $kec, 'both');
            }
            $this->db->group_end();
        }
        
        $this->db->order_by('tanggal_input', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_detail_pelaku_usaha($id)
    {
        return $this->db->get_where('pelaku_usaha', ['id' => $id])->row_array();
    }

    // ============================================
    // PENJUAL PAKAN
    // ============================================

    public function get_filtered_penjual_pakan($kecamatan = [])
    {
        $this->db->select('*');
        $this->db->from('penjual');
        $this->db->where('dagangan', 'Pakan');
        
        if (!empty($kecamatan) && is_array($kecamatan)) {
            $this->db->group_start();
            foreach ($kecamatan as $kec) {
                $this->db->or_like('kecamatan', $kec, 'both');
            }
            $this->db->group_end();
        }
        
        $this->db->order_by('tanggal_input', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_detail_penjual_pakan($id)
    {
        return $this->db->get_where('penjual', ['id_penjual' => $id, 'dagangan' => 'Pakan'])->row_array();
    }

    // ============================================
    // PENJUAL OBAT
    // ============================================

    public function get_filtered_penjual_obat($kecamatan = [])
    {
        $this->db->select('*');
        $this->db->from('penjual');
        $this->db->where('dagangan', 'Obat');
        
        if (!empty($kecamatan) && is_array($kecamatan)) {
            $this->db->group_start();
            foreach ($kecamatan as $kec) {
                $this->db->or_like('kecamatan', $kec, 'both');
            }
            $this->db->group_end();
        }
        
        $this->db->order_by('tanggal_input', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_detail_penjual_obat($id)
    {
        return $this->db->get_where('penjual', ['id_penjual' => $id, 'dagangan' => 'Obat'])->row_array();
    }

    // ============================================
    // KLINIK HEWAN
    // ============================================

    public function get_filtered_klinik_hewan($kecamatan = [])
    {
        $this->db->select('*');
        $this->db->from('input_klinik_hewan');
        
        if (!empty($kecamatan) && is_array($kecamatan)) {
            $this->db->group_start();
            foreach ($kecamatan as $kec) {
                $this->db->or_like('kecamatan', $kec, 'both');
            }
            $this->db->group_end();
        }
        
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_detail_klinik_hewan($id)
    {
        return $this->db->get_where('input_klinik_hewan', ['id' => $id])->row_array();
    }

    // ============================================
    // RPU
    // ============================================

    public function get_filtered_rpu($kecamatan = [], $tgl_mulai = null, $tgl_selesai = null)
    {
        $this->db->select('*');
        $this->db->from('input_rpu');
        
        if (!empty($kecamatan) && is_array($kecamatan)) {
            $this->db->group_start();
            foreach ($kecamatan as $kec) {
                $this->db->or_like('kecamatan', $kec, 'both');
            }
            $this->db->group_end();
        }
        
        if ($tgl_mulai && $tgl_selesai) {
            $this->db->where('tanggal_rpu >=', $tgl_mulai);
            $this->db->where('tanggal_rpu <=', $tgl_selesai);
        }
        
        $this->db->order_by('tanggal_rpu', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_detail_rpu($id)
    {
        return $this->db->get_where('input_rpu', ['id' => $id])->row_array();
    }

    // ============================================
    // PEMOTONGAN UNGGAS
    // ============================================

    public function get_filtered_pemotongan_unggas($kecamatan = [], $tgl_mulai = null, $tgl_selesai = null)
    {
        $this->db->select('input_pemotongan_unggas.*, input_rpu.kecamatan as kecamatan_rpu, input_rpu.nama_rpu, input_rpu.latitude, input_rpu.longitude');
        $this->db->from('input_pemotongan_unggas');
        $this->db->join('input_rpu', 'input_rpu.id = input_pemotongan_unggas.id_rpu', 'left');
        
        if (!empty($kecamatan) && is_array($kecamatan)) {
            $this->db->group_start();
            foreach ($kecamatan as $kec) {
                $this->db->or_like('input_rpu.kecamatan', $kec, 'both');
            }
            $this->db->group_end();
        }
        
        if ($tgl_mulai && $tgl_selesai) {
            $this->db->where('input_pemotongan_unggas.tanggal >=', $tgl_mulai);
            $this->db->where('input_pemotongan_unggas.tanggal <=', $tgl_selesai);
        }
        
        $this->db->order_by('input_pemotongan_unggas.tanggal', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_detail_pemotongan_unggas($id)
    {
        $this->db->select('input_pemotongan_unggas.*, input_rpu.kecamatan as kecamatan_rpu, input_rpu.nama_rpu');
        $this->db->from('input_pemotongan_unggas');
        $this->db->join('input_rpu', 'input_rpu.id = input_pemotongan_unggas.id_rpu', 'left');
        $this->db->where('input_pemotongan_unggas.id_pemotongan', $id);
        return $this->db->get()->row_array();
    }

    // ============================================
    // DEMPLOT
    // ============================================

    public function get_filtered_demplot($kecamatan = [])
    {
        $this->db->select('*');
        $this->db->from('input_demplot');
        
        if (!empty($kecamatan) && is_array($kecamatan)) {
            $this->db->group_start();
            foreach ($kecamatan as $kec) {
                $this->db->or_like('kecamatan', $kec, 'both');
            }
            $this->db->group_end();
        }
        
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_detail_demplot($id)
    {
        return $this->db->get_where('input_demplot', ['id_demplot' => $id])->row_array();
    }
}
?>