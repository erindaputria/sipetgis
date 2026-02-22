<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peta_Sebaran_Model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Get all kecamatan
    public function get_all_kecamatan()
    {
        return $this->db->get('kecamatan')->result_array();
    }

    // CEK TABEL
    public function table_exists($table_name)
    {
        return $this->db->table_exists($table_name);
    }

    // CEK KOLOM
    public function column_exists($table_name, $column_name)
    {
        if (!$this->db->table_exists($table_name)) {
            return false;
        }
        $fields = $this->db->field_data($table_name);
        foreach ($fields as $field) {
            if ($field->name == $column_name) {
                return true;
            }
        }
        return false;
    }

    // PENGOBATAN
    public function get_all_pengobatan()
    {
        $this->db->select('pengobatan.*');
        $this->db->from('pengobatan');
        
        // Cek apakah ada kolom id_kecamatan langsung di tabel pengobatan
        if ($this->column_exists('pengobatan', 'id_kecamatan')) {
            $this->db->select('pengobatan.id_kecamatan');
        }
        
        // Join dengan kecamatan jika ada
        if ($this->table_exists('kecamatan')) {
            // Cek apakah pengobatan punya id_kecamatan
            if ($this->column_exists('pengobatan', 'id_kecamatan')) {
                $this->db->select('kecamatan.nama_kecamatan');
                $this->db->join('kecamatan', 'kecamatan.id = pengobatan.id_kecamatan', 'left');
            }
        }
        
        return $this->db->get()->result_array();
    }

    public function get_filtered_pengobatan($kecamatan = [], $tgl_mulai = null, $tgl_selesai = null)
    {
        $this->db->select('pengobatan.*');
        $this->db->from('pengobatan');
        
        // Filter berdasarkan kecamatan jika ada kolom id_kecamatan
        if (!empty($kecamatan) && $this->column_exists('pengobatan', 'id_kecamatan')) {
            $this->db->where_in('pengobatan.id_kecamatan', $kecamatan);
        }
        
        // Join dengan kecamatan
        if ($this->table_exists('kecamatan') && $this->column_exists('pengobatan', 'id_kecamatan')) {
            $this->db->select('kecamatan.nama_kecamatan');
            $this->db->join('kecamatan', 'kecamatan.id = pengobatan.id_kecamatan', 'left');
        }
        
        // Filter tanggal
        if ($tgl_mulai && $tgl_selesai && $this->column_exists('pengobatan', 'tanggal_pengobatan')) {
            $this->db->where('pengobatan.tanggal_pengobatan >=', $tgl_mulai);
            $this->db->where('pengobatan.tanggal_pengobatan <=', $tgl_selesai);
        }
        
        return $this->db->get()->result_array();
    }

    public function get_detail_pengobatan($id)
    {
        $this->db->select('pengobatan.*');
        $this->db->from('pengobatan');
        
        // Join dengan kecamatan
        if ($this->table_exists('kecamatan') && $this->column_exists('pengobatan', 'id_kecamatan')) {
            $this->db->select('kecamatan.nama_kecamatan');
            $this->db->join('kecamatan', 'kecamatan.id = pengobatan.id_kecamatan', 'left');
        }
        
        // Join dengan obat
        if ($this->table_exists('obat') && $this->column_exists('pengobatan', 'id_obat')) {
            $this->db->select('obat.nama_obat, obat.dosis');
            $this->db->join('obat', 'obat.id = pengobatan.id_obat', 'left');
        }
        
        $this->db->where('pengobatan.id', $id);
        return $this->db->get()->row_array();
    }

    // VAKSINASI
    public function get_all_vaksinasi()
    {
        // Cek tabel vaksinasi mana yang ada
        $vaksin_table = null;
        if ($this->table_exists('data_vaksinasi')) {
            $vaksin_table = 'data_vaksinasi';
        } elseif ($this->table_exists('vaksinasi')) {
            $vaksin_table = 'vaksinasi';
        } else {
            return [];
        }
        
        $this->db->select($vaksin_table . '.*');
        $this->db->from($vaksin_table);
        
        // Cek apakah ada kolom id_kecamatan
        if ($this->column_exists($vaksin_table, 'id_kecamatan')) {
            $this->db->select($vaksin_table . '.id_kecamatan');
        }
        
        // Join dengan kecamatan
        if ($this->table_exists('kecamatan') && $this->column_exists($vaksin_table, 'id_kecamatan')) {
            $this->db->select('kecamatan.nama_kecamatan');
            $this->db->join('kecamatan', 'kecamatan.id = ' . $vaksin_table . '.id_kecamatan', 'left');
        }
        
        return $this->db->get()->result_array();
    }

    public function get_filtered_vaksinasi($kecamatan = [], $tgl_mulai = null, $tgl_selesai = null)
    {
        // Cek tabel vaksinasi mana yang ada
        $vaksin_table = null;
        if ($this->table_exists('data_vaksinasi')) {
            $vaksin_table = 'data_vaksinasi';
        } elseif ($this->table_exists('vaksinasi')) {
            $vaksin_table = 'vaksinasi';
        } else {
            return [];
        }
        
        $this->db->select($vaksin_table . '.*');
        $this->db->from($vaksin_table);
        
        // Filter kecamatan
        if (!empty($kecamatan) && $this->column_exists($vaksin_table, 'id_kecamatan')) {
            $this->db->where_in($vaksin_table . '.id_kecamatan', $kecamatan);
        }
        
        // Join dengan kecamatan
        if ($this->table_exists('kecamatan') && $this->column_exists($vaksin_table, 'id_kecamatan')) {
            $this->db->select('kecamatan.nama_kecamatan');
            $this->db->join('kecamatan', 'kecamatan.id = ' . $vaksin_table . '.id_kecamatan', 'left');
        }
        
        // Filter tanggal
        if ($tgl_mulai && $tgl_selesai) {
            $field_tanggal = $this->column_exists($vaksin_table, 'tanggal_vaksinasi') ? 'tanggal_vaksinasi' : 'tanggal';
            if ($this->column_exists($vaksin_table, $field_tanggal)) {
                $this->db->where($vaksin_table . '.' . $field_tanggal . ' >=', $tgl_mulai);
                $this->db->where($vaksin_table . '.' . $field_tanggal . ' <=', $tgl_selesai);
            }
        }
        
        return $this->db->get()->result_array();
    }

    public function get_detail_vaksinasi($id)
    {
        // Cek tabel vaksinasi mana yang ada
        $vaksin_table = null;
        if ($this->table_exists('data_vaksinasi')) {
            $vaksin_table = 'data_vaksinasi';
        } elseif ($this->table_exists('vaksinasi')) {
            $vaksin_table = 'vaksinasi';
        } else {
            return null;
        }
        
        $this->db->select($vaksin_table . '.*');
        $this->db->from($vaksin_table);
        
        // Join dengan kecamatan
        if ($this->table_exists('kecamatan') && $this->column_exists($vaksin_table, 'id_kecamatan')) {
            $this->db->select('kecamatan.nama_kecamatan');
            $this->db->join('kecamatan', 'kecamatan.id = ' . $vaksin_table . '.id_kecamatan', 'left');
        }
        
        // Join dengan vaksin
        if ($this->table_exists('vaksin') && $this->column_exists($vaksin_table, 'id_vaksin')) {
            $this->db->select('vaksin.nama_vaksin');
            $this->db->join('vaksin', 'vaksin.id = ' . $vaksin_table . '.id_vaksin', 'left');
        }
        
        $this->db->where($vaksin_table . '.id', $id);
        return $this->db->get()->row_array();
    }

    // PELAKU USAHA
    public function get_all_pelaku_usaha()
    {
        $this->db->select('pelaku_usaha.*');
        $this->db->from('pelaku_usaha');
        
        // Join dengan kecamatan
        if ($this->table_exists('kecamatan') && $this->column_exists('pelaku_usaha', 'id_kecamatan')) {
            $this->db->select('kecamatan.nama_kecamatan');
            $this->db->join('kecamatan', 'kecamatan.id = pelaku_usaha.id_kecamatan', 'left');
        }
        
        return $this->db->get()->result_array();
    }

    public function get_filtered_pelaku_usaha($kecamatan = [])
    {
        $this->db->select('pelaku_usaha.*');
        $this->db->from('pelaku_usaha');
        
        // Filter kecamatan
        if (!empty($kecamatan) && $this->column_exists('pelaku_usaha', 'id_kecamatan')) {
            $this->db->where_in('pelaku_usaha.id_kecamatan', $kecamatan);
        }
        
        // Join dengan kecamatan
        if ($this->table_exists('kecamatan') && $this->column_exists('pelaku_usaha', 'id_kecamatan')) {
            $this->db->select('kecamatan.nama_kecamatan');
            $this->db->join('kecamatan', 'kecamatan.id = pelaku_usaha.id_kecamatan', 'left');
        }
        
        return $this->db->get()->result_array();
    }

    public function get_detail_pelaku_usaha($id)
    {
        $this->db->select('pelaku_usaha.*');
        $this->db->from('pelaku_usaha');
        
        // Join dengan kecamatan
        if ($this->table_exists('kecamatan') && $this->column_exists('pelaku_usaha', 'id_kecamatan')) {
            $this->db->select('kecamatan.nama_kecamatan');
            $this->db->join('kecamatan', 'kecamatan.id = pelaku_usaha.id_kecamatan', 'left');
        }
        
        $this->db->where('pelaku_usaha.id', $id);
        return $this->db->get()->row_array();
    }

    // PENJUAL PAKAN
    public function get_all_penjual_pakan()
    {
        $this->db->select('data_penjual_pakan.*');
        $this->db->from('data_penjual_pakan');
        
        // Join dengan kecamatan
        if ($this->table_exists('kecamatan') && $this->column_exists('data_penjual_pakan', 'id_kecamatan')) {
            $this->db->select('kecamatan.nama_kecamatan');
            $this->db->join('kecamatan', 'kecamatan.id = data_penjual_pakan.id_kecamatan', 'left');
        }
        
        return $this->db->get()->result_array();
    }

    public function get_filtered_penjual_pakan($kecamatan = [])
    {
        $this->db->select('data_penjual_pakan.*');
        $this->db->from('data_penjual_pakan');
        
        // Filter kecamatan
        if (!empty($kecamatan) && $this->column_exists('data_penjual_pakan', 'id_kecamatan')) {
            $this->db->where_in('data_penjual_pakan.id_kecamatan', $kecamatan);
        }
        
        // Join dengan kecamatan
        if ($this->table_exists('kecamatan') && $this->column_exists('data_penjual_pakan', 'id_kecamatan')) {
            $this->db->select('kecamatan.nama_kecamatan');
            $this->db->join('kecamatan', 'kecamatan.id = data_penjual_pakan.id_kecamatan', 'left');
        }
        
        return $this->db->get()->result_array();
    }

    public function get_detail_penjual_pakan($id)
    {
        $this->db->select('data_penjual_pakan.*');
        $this->db->from('data_penjual_pakan');
        
        // Join dengan kecamatan
        if ($this->table_exists('kecamatan') && $this->column_exists('data_penjual_pakan', 'id_kecamatan')) {
            $this->db->select('kecamatan.nama_kecamatan');
            $this->db->join('kecamatan', 'kecamatan.id = data_penjual_pakan.id_kecamatan', 'left');
        }
        
        $this->db->where('data_penjual_pakan.id', $id);
        return $this->db->get()->row_array();
    }

    // KLINIK HEWAN
    public function get_all_klinik_hewan()
    {
        $this->db->select('data_klinik.*');
        $this->db->from('data_klinik');
        
        // Join dengan kecamatan
        if ($this->table_exists('kecamatan') && $this->column_exists('data_klinik', 'id_kecamatan')) {
            $this->db->select('kecamatan.nama_kecamatan');
            $this->db->join('kecamatan', 'kecamatan.id = data_klinik.id_kecamatan', 'left');
        }
        
        return $this->db->get()->result_array();
    }

    public function get_filtered_klinik_hewan($kecamatan = [])
    {
        $this->db->select('data_klinik.*');
        $this->db->from('data_klinik');
        
        // Filter kecamatan
        if (!empty($kecamatan) && $this->column_exists('data_klinik', 'id_kecamatan')) {
            $this->db->where_in('data_klinik.id_kecamatan', $kecamatan);
        }
        
        // Join dengan kecamatan
        if ($this->table_exists('kecamatan') && $this->column_exists('data_klinik', 'id_kecamatan')) {
            $this->db->select('kecamatan.nama_kecamatan');
            $this->db->join('kecamatan', 'kecamatan.id = data_klinik.id_kecamatan', 'left');
        }
        
        return $this->db->get()->result_array();
    }

    public function get_detail_klinik_hewan($id)
    {
        $this->db->select('data_klinik.*');
        $this->db->from('data_klinik');
        
        // Join dengan kecamatan
        if ($this->table_exists('kecamatan') && $this->column_exists('data_klinik', 'id_kecamatan')) {
            $this->db->select('kecamatan.nama_kecamatan');
            $this->db->join('kecamatan', 'kecamatan.id = data_klinik.id_kecamatan', 'left');
        }
        
        $this->db->where('data_klinik.id', $id);
        return $this->db->get()->row_array();
    }

    // PENJUAL OBAT
    public function get_all_penjual_obat()
    {
        $this->db->select('data_penjual_obat.*');
        $this->db->from('data_penjual_obat');
        
        // Join dengan kecamatan
        if ($this->table_exists('kecamatan') && $this->column_exists('data_penjual_obat', 'id_kecamatan')) {
            $this->db->select('kecamatan.nama_kecamatan');
            $this->db->join('kecamatan', 'kecamatan.id = data_penjual_obat.id_kecamatan', 'left');
        }
        
        return $this->db->get()->result_array();
    }

    public function get_filtered_penjual_obat($kecamatan = [])
    {
        $this->db->select('data_penjual_obat.*');
        $this->db->from('data_penjual_obat');
        
        // Filter kecamatan
        if (!empty($kecamatan) && $this->column_exists('data_penjual_obat', 'id_kecamatan')) {
            $this->db->where_in('data_penjual_obat.id_kecamatan', $kecamatan);
        }
        
        // Join dengan kecamatan
        if ($this->table_exists('kecamatan') && $this->column_exists('data_penjual_obat', 'id_kecamatan')) {
            $this->db->select('kecamatan.nama_kecamatan');
            $this->db->join('kecamatan', 'kecamatan.id = data_penjual_obat.id_kecamatan', 'left');
        }
        
        return $this->db->get()->result_array();
    }

    public function get_detail_penjual_obat($id)
    {
        $this->db->select('data_penjual_obat.*');
        $this->db->from('data_penjual_obat');
        
        // Join dengan kecamatan
        if ($this->table_exists('kecamatan') && $this->column_exists('data_penjual_obat', 'id_kecamatan')) {
            $this->db->select('kecamatan.nama_kecamatan');
            $this->db->join('kecamatan', 'kecamatan.id = data_penjual_obat.id_kecamatan', 'left');
        }
        
        $this->db->where('data_penjual_obat.id', $id);
        return $this->db->get()->row_array();
    }

    // Fungsi untuk debug struktur tabel
    public function get_table_structure($table_name)
    {
        if (!$this->db->table_exists($table_name)) {
            return "Tabel $table_name tidak ditemukan";
        }
        return $this->db->field_data($table_name);
    }
}