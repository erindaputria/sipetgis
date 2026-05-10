<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_history_data_vaksinasi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->model('Laporan_history_data_vaksinasi_model');
        
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
 
    public function index() 
    {
        $data['title'] = 'Laporan History Data Vaksinasi';
        $data['kecamatan'] = $this->Laporan_history_data_vaksinasi_model->get_kecamatan();
        $data['tahun'] = $this->Laporan_history_data_vaksinasi_model->get_tahun();
        $data['jenis_vaksin'] = $this->Laporan_history_data_vaksinasi_model->get_jenis_vaksin();
        $data['jenis_hewan'] = $this->Laporan_history_data_vaksinasi_model->get_jenis_hewan();
        
        $this->load->view('laporan/laporan_history_data_vaksinasi', $data);
    }

    public function get_data()
    {
        $tahun = $this->input->post('tahun');
        $kecamatan = $this->input->post('kecamatan');
        $jenis_vaksin = $this->input->post('jenis_vaksin');
        $jenis_hewan = $this->input->post('jenis_hewan');
        
        $data = $this->Laporan_history_data_vaksinasi_model->get_history_data($tahun, $kecamatan, $jenis_vaksin, $jenis_hewan);
        $total_dosis = $this->Laporan_history_data_vaksinasi_model->get_total_dosis($tahun, $kecamatan, $jenis_vaksin, $jenis_hewan);
        
        $response = [
            'data' => $data,
            'total_dosis' => $total_dosis,
            'total' => count($data)
        ];
        
        echo json_encode($response);
    }
    
    public function get_all_data()
    {
        $data = $this->Laporan_history_data_vaksinasi_model->get_all_history_data();
        $total_dosis = $this->Laporan_history_data_vaksinasi_model->get_all_total_dosis();
        
        $response = [
            'data' => $data,
            'total_dosis' => $total_dosis,
            'total' => count($data)
        ];
        
        echo json_encode($response);
    }
    
    // ==================== EXPORT EXCEL (QUERY LANGSUNG) ====================
    public function export_excel()
    {
        $tahun = $this->input->get('tahun');
        $kecamatan = $this->input->get('kecamatan');
        $jenis_vaksin = $this->input->get('jenis_vaksin');
        $jenis_hewan = $this->input->get('jenis_hewan');
        
        // Query langsung di Controller (tidak ganggu Model)
        if($tahun == 'all' || empty($tahun)) {
            $sql = "SELECT 
                        tanggal_vaksinasi,
                        nama_petugas,
                        nama_peternak,
                        nik,
                        alamat,
                        kecamatan,
                        kelurahan,
                        komoditas_ternak as jenis_hewan,
                        jumlah,
                        jenis_vaksinasi
                    FROM input_vaksinasi
                    ORDER BY tanggal_vaksinasi DESC";
            $query = $this->db->query($sql);
            $data = $query->result();
        } else {
            $sql = "SELECT 
                        tanggal_vaksinasi,
                        nama_petugas,
                        nama_peternak,
                        nik,
                        alamat,
                        kecamatan,
                        kelurahan,
                        komoditas_ternak as jenis_hewan,
                        jumlah,
                        jenis_vaksinasi
                    FROM input_vaksinasi
                    WHERE YEAR(tanggal_vaksinasi) = ?";
            $params = [$tahun];
            
            if($kecamatan && $kecamatan != 'semua') {
                $sql .= " AND kecamatan = ?";
                $params[] = $kecamatan;
            }
            
            if($jenis_vaksin && $jenis_vaksin != 'semua') {
                if($jenis_vaksin == 'PMK') {
                    $sql .= " AND jenis_vaksinasi LIKE ?";
                    $params[] = '%PMK%';
                } elseif($jenis_vaksin == 'LSD') {
                    $sql .= " AND jenis_vaksinasi LIKE ?";
                    $params[] = '%LSD%';
                } elseif($jenis_vaksin == 'ND-AI') {
                    $sql .= " AND (jenis_vaksinasi LIKE ? OR jenis_vaksinasi LIKE ?)";
                    $params[] = '%ND%';
                    $params[] = '%AI%';
                }
            }
            
            if($jenis_hewan && $jenis_hewan != 'semua') {
                $sql .= " AND komoditas_ternak = ?";
                $params[] = $jenis_hewan;
            }
            
            $sql .= " ORDER BY tanggal_vaksinasi DESC";
            $query = $this->db->query($sql, $params);
            $data = $query->result();
        }
        
        // Format judul
        $kecamatanText = ($kecamatan && $kecamatan != 'semua') ? 'Kecamatan ' . $kecamatan : 'Seluruh Kecamatan';
        $jenisVaksinText = ($jenis_vaksin && $jenis_vaksin != 'semua') ? $jenis_vaksin : 'Semua Jenis Vaksin';
        $jenisHewanText = ($jenis_hewan && $jenis_hewan != 'semua') ? ' - Jenis Hewan: ' . $jenis_hewan : '';
        $tahunText = ($tahun && $tahun != 'all') ? $tahun : 'Semua Tahun';
        
        // Header Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Laporan_History_Vaksinasi_' . $tahunText . '.xls"');
        header('Cache-Control: max-age=0');
        
        echo '<html><head><meta charset="UTF-8">';
        echo '<style>';
        echo 'td, th { border: 1px solid #000; padding: 6px; }';
        echo 'th { background-color: #f2f2f2; }';
        echo '.total-row { background-color: #e8f5e9; }';
        echo '</style>';
        echo '</head><body>';
        
        echo '<table border="1" cellpadding="5" cellspacing="0">';
        
        // Judul Laporan
        echo '<tr>';
        echo '<td colspan="10" align="center"><b>LAPORAN HISTORY DATA VAKSINASI</b></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td colspan="10" align="center">Kota Surabaya - ' . $kecamatanText . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td colspan="10" align="center">Jenis Vaksin: ' . $jenisVaksinText . $jenisHewanText . ' | Tahun: ' . $tahunText . '</td>';
        echo '</tr>';
        echo '<tr><td colspan="10">&nbsp;</td></tr>';
        
        // Header Tabel
        echo '<tr>';
        echo '<th>No</th>';
        echo '<th>Tanggal Vaksinasi</th>';
        echo '<th>Petugas</th>';
        echo '<th>Nama Peternak</th>';
        echo '<th>NIK</th>';
        echo '<th>Alamat</th>';
        echo '<th>Kecamatan</th>';
        echo '<th>Kelurahan</th>';
        echo '<th>Jenis Hewan</th>';
        echo '<th>Jumlah Dosis</th>';
        echo '</tr>';
        
        // Data
        $no = 1;
        $totalDosis = 0;
        
        foreach($data as $row) {
            $tanggal = !empty($row->tanggal_vaksinasi) ? date('d/m/Y', strtotime($row->tanggal_vaksinasi)) : '-';
            
            echo '<tr>';
            echo '<td align="center">' . $no++ . '</td>';
            echo '<td align="center">' . $tanggal . '</td>';
            echo '<td align="left">' . ($row->nama_petugas ?? '-') . '</td>';
            echo '<td align="left">' . ($row->nama_peternak ?? '-') . '</td>';
            echo '<td align="left">' . ($row->nik ?? '-') . '</td>';
            echo '<td align="left">' . ($row->alamat ?? '-') . '</td>';
            echo '<td align="left">' . ($row->kecamatan ?? '-') . '</td>';
            echo '<td align="left">' . ($row->kelurahan ?? '-') . '</td>';
            echo '<td align="left">' . ($row->jenis_hewan ?? '-') . '</td>';
            echo '<td align="right">' . number_format($row->jumlah, 0, ',', '.') . '</td>';
            echo '</tr>';
            $totalDosis += $row->jumlah;
        }
        
        // Total
        echo '<tr class="total-row">';
        echo '<td colspan="9" align="center"><b>TOTAL KESELURUHAN</b></td>';
        echo '<td align="right"><b>' . number_format($totalDosis, 0, ',', '.') . '</b></td>';
        echo '</tr>';
        
        echo '</table>';
        echo '</body></html>';
        
        exit;
    }
}
?>