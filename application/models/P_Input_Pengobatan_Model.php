<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Pengobatan_Model extends CI_Model {
    
    protected $table = 'input_pengobatan';
    protected $table_detail = 'input_pengobatan_detail';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Save pengobatan with multiple details (commodities)
     */
    public function save_pengobatan_with_details($master_data, $detail_data) {
        // Start transaction
        $this->db->trans_start();
        
        try {
            // Insert master data
            $this->db->insert($this->table, $master_data);
            $master_id = $this->db->insert_id();
            
            if (!$master_id) {
                throw new Exception('Gagal menyimpan data master');
            }
            
            // Insert detail data
            if (!empty($detail_data)) {
                foreach ($detail_data as &$detail) {
                    $detail['id_obat'] = $master_id;
                }
                
                $this->db->insert_batch($this->table_detail, $detail_data);
                
                if ($this->db->affected_rows() != count($detail_data)) {
                    throw new Exception('Gagal menyimpan data detail');
                }
            }
            
            // Commit transaction
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                return false;
            }
            
            return $master_id;
            
        } catch (Exception $e) {
            log_message('error', 'Error saving pengobatan: ' . $e->getMessage());
            $this->db->trans_rollback();
            return false;
        }
    }
    
    /**
     * Get pengobatan with details by kecamatan
     */
    public function get_pengobatan_by_kecamatan($kecamatan) {
        // Get all master data
        $this->db->select('*');
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $this->db->order_by('tanggal_pengobatan', 'DESC');
        $masters = $this->db->get()->result_array();
        
        // Get details for each master
        foreach ($masters as &$master) {
            $this->db->select('*');
            $this->db->from($this->table_detail);
            $this->db->where('id_obat', $master['id_obat']);
            $details = $this->db->get()->result_array();
            $master['details'] = $details;
        }
        
        return $masters;
    }
    
    /**
     * Get all pengobatan
     */
    public function get_all_pengobatan() {
        return $this->get_pengobatan_by_kecamatan(null);
    }
    
    /**
     * Get pengobatan for table (limited to 10)
     */
    public function get_pengobatan_for_table() {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('tanggal_pengobatan', 'DESC');
        $this->db->limit(10);
        $masters = $this->db->get()->result_array();
        
        foreach ($masters as &$master) {
            $this->db->select('*');
            $this->db->from($this->table_detail);
            $this->db->where('id_obat', $master['id_obat']);
            $details = $this->db->get()->result_array();
            $master['details'] = $details;
        }
        
        return $masters;
    }
    
    /**
     * Get all for datatable
     */
    public function get_all_for_datatable($kecamatan = null) {
        return $this->get_pengobatan_by_kecamatan($kecamatan);
    }
    
    /**
     * Get pengobatan by ID
     */
    public function get_pengobatan_by_id($id) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id_obat', $id);
        $master = $this->db->get()->row_array();
        
        if ($master) {
            $this->db->select('*');
            $this->db->from($this->table_detail);
            $this->db->where('id_obat', $id);
            $details = $this->db->get()->result_array();
            $master['details'] = $details;
        }
        
        return $master;
    }
    
    /**
     * Save pengobatan (single - backward compatibility)
     */
    public function save_pengobatan($data) {
        // Untuk backward compatibility, konversi ke format baru jika ada komoditas_ternak
        if (isset($data['komoditas_ternak']) && !isset($data['details'])) {
            $master_data = $data;
            unset($master_data['komoditas_ternak']);
            unset($master_data['jenis_pengobatan']);
            unset($master_data['jumlah']);
            
            $detail_data = array(
                array(
                    'komoditas_ternak' => $data['komoditas_ternak'],
                    'jenis_pengobatan' => $data['jenis_pengobatan'],
                    'jumlah' => $data['jumlah']
                )
            );
            
            return $this->save_pengobatan_with_details($master_data, $detail_data);
        }
        
        // Kalau tidak ada komoditas_ternak, insert biasa
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    /**
     * Update pengobatan
     */
    public function update_pengobatan($id, $data) {
        $this->db->where('id_obat', $id);
        return $this->db->update($this->table, $data);
    }
    
    /**
     * Delete pengobatan
     */
    public function delete_pengobatan($id) {
        // Get foto path before delete
        $this->db->select('foto_pengobatan');
        $this->db->from($this->table);
        $this->db->where('id_obat', $id);
        $result = $this->db->get()->row_array();
        
        if ($result && !empty($result['foto_pengobatan'])) {
            $fotos = explode(',', $result['foto_pengobatan']);
            foreach ($fotos as $foto) {
                $file_path = './uploads/pengobatan/' . $foto;
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
        }
        
        // Detail akan kehapus otomatis karena ON DELETE CASCADE
        $this->db->where('id_obat', $id);
        return $this->db->delete($this->table);
    }
    
    /**
     * Get by komoditas
     */
    public function get_by_komoditas($komoditas, $kecamatan = null) {
        $this->db->select('p.*, d.komoditas_ternak, d.jenis_pengobatan, d.jumlah');
        $this->db->from($this->table . ' p');
        $this->db->join($this->table_detail . ' d', 'p.id_obat = d.id_obat');
        $this->db->where('d.komoditas_ternak', $komoditas);
        if ($kecamatan) {
            $this->db->where('p.kecamatan', $kecamatan);
        }
        $this->db->order_by('p.tanggal_pengobatan', 'DESC');
        $query = $this->db->get();
        
        // Group by master
        $result = array();
        foreach ($query->result_array() as $row) {
            $id = $row['id_obat'];
            if (!isset($result[$id])) {
                $result[$id] = array(
                    'id_obat' => $row['id_obat'],
                    'nama_petugas' => $row['nama_petugas'],
                    'nama_peternak' => $row['nama_peternak'],
                    'nik' => $row['nik'],
                    'tanggal_pengobatan' => $row['tanggal_pengobatan'],
                    'keterangan' => $row['keterangan'],
                    'bantuan_prov' => $row['bantuan_prov'],
                    'kecamatan' => $row['kecamatan'],
                    'kelurahan' => $row['kelurahan'],
                    'rt' => $row['rt'],
                    'rw' => $row['rw'],
                    'latitude' => $row['latitude'],
                    'longitude' => $row['longitude'],
                    'telp' => $row['telp'],
                    'foto_pengobatan' => $row['foto_pengobatan'],
                    'details' => array()
                );
            }
            $result[$id]['details'][] = array(
                'komoditas_ternak' => $row['komoditas_ternak'],
                'jenis_pengobatan' => $row['jenis_pengobatan'],
                'jumlah' => $row['jumlah']
            );
        }
        
        return array_values($result);
    }
    
    /**
     * Get by kelurahan
     */
    public function get_by_kelurahan($kelurahan, $kecamatan = null) {
        $this->db->select('p.*, d.komoditas_ternak, d.jenis_pengobatan, d.jumlah');
        $this->db->from($this->table . ' p');
        $this->db->join($this->table_detail . ' d', 'p.id_obat = d.id_obat');
        $this->db->where('p.kelurahan', $kelurahan);
        if ($kecamatan) {
            $this->db->where('p.kecamatan', $kecamatan);
        }
        $this->db->order_by('p.tanggal_pengobatan', 'DESC');
        $query = $this->db->get();
        
        // Group by master
        $result = array();
        foreach ($query->result_array() as $row) {
            $id = $row['id_obat'];
            if (!isset($result[$id])) {
                $result[$id] = array(
                    'id_obat' => $row['id_obat'],
                    'nama_petugas' => $row['nama_petugas'],
                    'nama_peternak' => $row['nama_peternak'],
                    'nik' => $row['nik'],
                    'tanggal_pengobatan' => $row['tanggal_pengobatan'],
                    'keterangan' => $row['keterangan'],
                    'bantuan_prov' => $row['bantuan_prov'],
                    'kecamatan' => $row['kecamatan'],
                    'kelurahan' => $row['kelurahan'],
                    'rt' => $row['rt'],
                    'rw' => $row['rw'],
                    'latitude' => $row['latitude'],
                    'longitude' => $row['longitude'],
                    'telp' => $row['telp'],
                    'foto_pengobatan' => $row['foto_pengobatan'],
                    'details' => array()
                );
            }
            $result[$id]['details'][] = array(
                'komoditas_ternak' => $row['komoditas_ternak'],
                'jenis_pengobatan' => $row['jenis_pengobatan'],
                'jumlah' => $row['jumlah']
            );
        }
        
        return array_values($result);
    }
    
    /**
     * Get by periode
     */
    public function get_by_periode($tahun, $kecamatan = null) {
        $this->db->select('p.*, d.komoditas_ternak, d.jenis_pengobatan, d.jumlah');
        $this->db->from($this->table . ' p');
        $this->db->join($this->table_detail . ' d', 'p.id_obat = d.id_obat');
        $this->db->where("YEAR(p.tanggal_pengobatan)", $tahun);
        if ($kecamatan) {
            $this->db->where('p.kecamatan', $kecamatan);
        }
        $this->db->order_by('p.tanggal_pengobatan', 'DESC');
        $query = $this->db->get();
        
        // Group by master
        $result = array();
        foreach ($query->result_array() as $row) {
            $id = $row['id_obat'];
            if (!isset($result[$id])) {
                $result[$id] = array(
                    'id_obat' => $row['id_obat'],
                    'nama_petugas' => $row['nama_petugas'],
                    'nama_peternak' => $row['nama_peternak'],
                    'nik' => $row['nik'],
                    'tanggal_pengobatan' => $row['tanggal_pengobatan'],
                    'keterangan' => $row['keterangan'],
                    'bantuan_prov' => $row['bantuan_prov'],
                    'kecamatan' => $row['kecamatan'],
                    'kelurahan' => $row['kelurahan'],
                    'rt' => $row['rt'],
                    'rw' => $row['rw'],
                    'latitude' => $row['latitude'],
                    'longitude' => $row['longitude'],
                    'telp' => $row['telp'],
                    'foto_pengobatan' => $row['foto_pengobatan'],
                    'details' => array()
                );
            }
            $result[$id]['details'][] = array(
                'komoditas_ternak' => $row['komoditas_ternak'],
                'jenis_pengobatan' => $row['jenis_pengobatan'],
                'jumlah' => $row['jumlah']
            );
        }
        
        return array_values($result);
    }
    
    /**
     * Get by date range
     */
    public function get_by_date_range($start_date, $end_date, $kecamatan = null) {
        $this->db->select('p.*, d.komoditas_ternak, d.jenis_pengobatan, d.jumlah');
        $this->db->from($this->table . ' p');
        $this->db->join($this->table_detail . ' d', 'p.id_obat = d.id_obat');
        $this->db->where('p.tanggal_pengobatan >=', $start_date);
        $this->db->where('p.tanggal_pengobatan <=', $end_date);
        if ($kecamatan) {
            $this->db->where('p.kecamatan', $kecamatan);
        }
        $this->db->order_by('p.tanggal_pengobatan', 'DESC');
        $query = $this->db->get();
        
        // Group by master
        $result = array();
        foreach ($query->result_array() as $row) {
            $id = $row['id_obat'];
            if (!isset($result[$id])) {
                $result[$id] = array(
                    'id_obat' => $row['id_obat'],
                    'nama_petugas' => $row['nama_petugas'],
                    'nama_peternak' => $row['nama_peternak'],
                    'nik' => $row['nik'],
                    'tanggal_pengobatan' => $row['tanggal_pengobatan'],
                    'keterangan' => $row['keterangan'],
                    'bantuan_prov' => $row['bantuan_prov'],
                    'kecamatan' => $row['kecamatan'],
                    'kelurahan' => $row['kelurahan'],
                    'rt' => $row['rt'],
                    'rw' => $row['rw'],
                    'latitude' => $row['latitude'],
                    'longitude' => $row['longitude'],
                    'telp' => $row['telp'],
                    'foto_pengobatan' => $row['foto_pengobatan'],
                    'details' => array()
                );
            }
            $result[$id]['details'][] = array(
                'komoditas_ternak' => $row['komoditas_ternak'],
                'jenis_pengobatan' => $row['jenis_pengobatan'],
                'jumlah' => $row['jumlah']
            );
        }
        
        return array_values($result);
    }
    
    /**
     * Get with coordinates
     */
    public function get_with_coordinates($kecamatan = null) {
        $this->db->select('p.*, d.komoditas_ternak, d.jenis_pengobatan, d.jumlah');
        $this->db->from($this->table . ' p');
        $this->db->join($this->table_detail . ' d', 'p.id_obat = d.id_obat');
        $this->db->where('p.latitude IS NOT NULL');
        $this->db->where('p.latitude !=', '');
        $this->db->where('p.longitude IS NOT NULL');
        $this->db->where('p.longitude !=', '');
        if ($kecamatan) {
            $this->db->where('p.kecamatan', $kecamatan);
        }
        $this->db->order_by('p.tanggal_pengobatan', 'DESC');
        $query = $this->db->get();
        
        // Group by master
        $result = array();
        foreach ($query->result_array() as $row) {
            $id = $row['id_obat'];
            if (!isset($result[$id])) {
                $result[$id] = array(
                    'id_obat' => $row['id_obat'],
                    'nama_petugas' => $row['nama_petugas'],
                    'nama_peternak' => $row['nama_peternak'],
                    'nik' => $row['nik'],
                    'tanggal_pengobatan' => $row['tanggal_pengobatan'],
                    'keterangan' => $row['keterangan'],
                    'bantuan_prov' => $row['bantuan_prov'],
                    'kecamatan' => $row['kecamatan'],
                    'kelurahan' => $row['kelurahan'],
                    'rt' => $row['rt'],
                    'rw' => $row['rw'],
                    'latitude' => $row['latitude'],
                    'longitude' => $row['longitude'],
                    'telp' => $row['telp'],
                    'foto_pengobatan' => $row['foto_pengobatan'],
                    'details' => array()
                );
            }
            $result[$id]['details'][] = array(
                'komoditas_ternak' => $row['komoditas_ternak'],
                'jenis_pengobatan' => $row['jenis_pengobatan'],
                'jumlah' => $row['jumlah']
            );
        }
        
        return array_values($result);
    }
    
    /**
     * Count all
     */
    public function count_all($kecamatan = null) {
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        return $this->db->count_all_results($this->table);
    }
    
    /**
     * Sum jumlah from details
     */
    public function sum_jumlah($kecamatan = null) {
        $this->db->select('SUM(d.jumlah) as total');
        $this->db->from($this->table . ' p');
        $this->db->join($this->table_detail . ' d', 'p.id_obat = d.id_obat');
        if ($kecamatan) {
            $this->db->where('p.kecamatan', $kecamatan);
        }
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['total'] ?? 0;
    }
    
    /**
     * Count unique peternak
     */
    public function count_unique_peternak($kecamatan = null) {
        $this->db->select('COUNT(DISTINCT nama_peternak) as total');
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['total'] ?? 0;
    }
    
    /**
     * Count unique kelurahan
     */
    public function count_unique_kelurahan($kecamatan = null) {
        $this->db->select('COUNT(DISTINCT kelurahan) as total');
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['total'] ?? 0;
    }
    
    /**
     * Get kelurahan list
     */
    public function get_kelurahan_list($kecamatan = null) {
        $this->db->select('DISTINCT kelurahan');
        $this->db->from($this->table); 
        $this->db->where('kelurahan IS NOT NULL');
        $this->db->where('kelurahan !=', '');
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $this->db->order_by('kelurahan', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Get statistik per bulan
     */
    public function get_statistik_per_bulan($tahun = null, $kecamatan = null) {
        $tahun = $tahun ?: date('Y');
        
        $this->db->select("MONTH(p.tanggal_pengobatan) as bulan, COUNT(DISTINCT p.id_obat) as total_kasus, SUM(d.jumlah) as total_ternak");
        $this->db->from($this->table . ' p');
        $this->db->join($this->table_detail . ' d', 'p.id_obat = d.id_obat');
        $this->db->where("YEAR(p.tanggal_pengobatan)", $tahun);
        if ($kecamatan) {
            $this->db->where('p.kecamatan', $kecamatan);
        }
        $this->db->group_by("MONTH(p.tanggal_pengobatan)");
        $this->db->order_by("bulan", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Get statistik per komoditas
     */
    public function get_statistik_per_komoditas($kecamatan = null) {
        $this->db->select("d.komoditas_ternak, COUNT(DISTINCT p.id_obat) as total_kasus, SUM(d.jumlah) as total_ternak");
        $this->db->from($this->table . ' p');
        $this->db->join($this->table_detail . ' d', 'p.id_obat = d.id_obat');
        if ($kecamatan) {
            $this->db->where('p.kecamatan', $kecamatan);
        }
        $this->db->group_by("d.komoditas_ternak");
        $this->db->order_by("total_kasus", "DESC");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Get statistik per kelurahan
     */
    public function get_statistik_per_kelurahan($kecamatan = null) {
        $this->db->select('p.kelurahan, COUNT(DISTINCT p.id_obat) as total_kasus, SUM(d.jumlah) as total_ternak');
        $this->db->from($this->table . ' p');
        $this->db->join($this->table_detail . ' d', 'p.id_obat = d.id_obat');
        if ($kecamatan) {
            $this->db->where('p.kecamatan', $kecamatan);
        }
        $this->db->group_by('p.kelurahan');
        $this->db->order_by('total_kasus', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
}