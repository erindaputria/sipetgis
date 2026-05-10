<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_kepemilikan_ternak extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->model('Laporan_kepemilikan_ternak_model');
        
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        } 
    }

    public function index()
    {
        $data['title'] = 'Laporan Kepemilikan Ternak';
        $data['kecamatan'] = $this->Laporan_kepemilikan_ternak_model->get_kecamatan();
        $data['tahun'] = $this->Laporan_kepemilikan_ternak_model->get_tahun();
        $data['bulan'] = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September', 
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ]; 
        
        $this->load->view('laporan/laporan_kepemilikan_ternak', $data);
    }

    public function get_data()
    {
        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');
        $kecamatan = $this->input->post('kecamatan');
        $jenis_data = $this->input->post('jenis_data');
        
        try {
            if($jenis_data == 'peternak') {
                $data = $this->Laporan_kepemilikan_ternak_model->get_data_peternak($tahun, $bulan, $kecamatan);
            } else {
                $data = $this->Laporan_kepemilikan_ternak_model->get_data_populasi($tahun, $bulan, $kecamatan);
            }
            
            $total = $this->Laporan_kepemilikan_ternak_model->get_total_data($tahun, $bulan, $kecamatan, $jenis_data);
            
            $response = [
                'status' => 'success',
                'data' => $data,
                'total' => $total,
                'jenis_data' => $jenis_data
            ];
            
            echo json_encode($response);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => [],
                'total' => null
            ]);
        }
    }
    
    public function detail_kecamatan($kecamatan, $jenis_ternak)
    {
        $kecamatan = urldecode($kecamatan);
        $jenis_ternak = urldecode($jenis_ternak);
        $tahun = $this->input->get('tahun');
        $bulan = $this->input->get('bulan');
        
        $komoditas_map = [
            'Sapi Potong' => 'Sapi Potong',
            'SapiPerah' => 'Sapi Perah',
            'Kambing' => 'Kambing',
            'Domba' => 'Domba',
            'Ayam' => 'Ayam',
            'Itik' => 'Itik',
            'Angsa' => 'Angsa',
            'Kalkun' => 'Kalkun',
            'Burung' => 'Burung'
        ];
        
        $komoditas = isset($komoditas_map[$jenis_ternak]) ? $komoditas_map[$jenis_ternak] : $jenis_ternak;
        
        $data['kecamatan'] = $kecamatan;
        $data['jenis_ternak'] = $komoditas;
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        
        $this->db->select('*');
        $this->db->from('input_jenis_usaha');
        $this->db->where('kecamatan', $kecamatan);
        $this->db->where('komoditas_ternak', $komoditas);
        if($tahun) {
            $this->db->where('YEAR(tanggal_input)', $tahun);
        }
        if($bulan) {
            $this->db->where('MONTH(tanggal_input)', $bulan);
        }
        $data['details'] = $this->db->get()->result();
        
        $this->load->view('laporan/detail_kepemilikan_kecamatan', $data);
    }
    
    // ==================== EXPORT EXCEL ====================
    public function export_excel()
    {
        $tahun = $this->input->get('tahun');
        $bulan = $this->input->get('bulan');
        $kecamatan = $this->input->get('kecamatan');
        $jenis_data = $this->input->get('jenis_data');
        
        // Ambil data
        if($jenis_data == 'peternak') {
            $data = $this->Laporan_kepemilikan_ternak_model->get_data_peternak($tahun, $bulan, $kecamatan);
        } else {
            $data = $this->Laporan_kepemilikan_ternak_model->get_data_populasi($tahun, $bulan, $kecamatan);
        }
        
        $total = $this->Laporan_kepemilikan_ternak_model->get_total_data($tahun, $bulan, $kecamatan, $jenis_data);
        
        // Format judul
        $bulanNama = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        
        $jenisDataText = $jenis_data == 'peternak' ? 'PETERNAK' : 'POPULASI TERNAK';
        $bulanText = ($bulan && $bulan != '') ? $bulanNama[$bulan] : 'Semua Bulan';
        $kecamatanText = ($kecamatan && $kecamatan != 'semua') ? 'Kecamatan ' . ucwords(strtolower($kecamatan)) : 'Seluruh Kecamatan';
        
        // Header untuk download file Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Laporan_Kepemilikan_Ternak_' . $jenisDataText . '_' . $tahun . '.xls"');
        header('Cache-Control: max-age=0');
        
        // Mulai output HTML sebagai Excel
        echo '<html>';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<style>';
        echo 'td, th { border: 1px solid #000; padding: 6px; }';
        echo 'th { background-color: #f2f2f2; }';
        echo '.total-row { background-color: #e8f5e9; font-weight: bold; }';
        echo '</style>';
        echo '</head>';
        echo '<body>';
        
        echo '<table border="1" cellpadding="5" cellspacing="0">';
        
        // Judul Laporan
        echo '<tr>';
        echo '<td colspan="11" align="center"><b>REKAP DATA JUMLAH ' . $jenisDataText . '</b></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td colspan="11" align="center">Kota Surabaya - ' . $kecamatanText . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td colspan="11" align="center">Periode: ' . $bulanText . ' ' . $tahun . '</td>';
        echo '</tr>';
        echo '<tr><td colspan="11">&nbsp;</td></tr>';
        
        // Header Tabel
        echo '<tr>';
        echo '<th>No</th>';
        echo '<th>Kecamatan</th>';
        echo '<th>Sapi Potong</th>';
        echo '<th>Sapi Perah</th>';
        echo '<th>Kambing</th>';
        echo '<th>Domba</th>';
        echo '<th>Ayam</th>';
        echo '<th>Itik</th>';
        echo '<th>Angsa</th>';
        echo '<th>Kalkun</th>';
        echo '<th>Burung</th>';
        echo '</tr>';
        
        // Data per kecamatan
        $no = 1;
        foreach($data as $item) {
            echo '<tr>';
            echo '<td align="center">' . $no++ . '</td>';
            echo '<td align="left">' . $item->kecamatan . '</td>';
            echo '<td align="right">' . number_format((int)$item->sapi_potong, 0, ',', '.') . '</td>';
            echo '<td align="right">' . number_format((int)$item->sapi_perah, 0, ',', '.') . '</td>';
            echo '<td align="right">' . number_format((int)$item->kambing, 0, ',', '.') . '</td>';
            echo '<td align="right">' . number_format((int)$item->domba, 0, ',', '.') . '</td>';
            echo '<td align="right">' . number_format((int)$item->ayam, 0, ',', '.') . '</td>';
            echo '<td align="right">' . number_format((int)$item->itik, 0, ',', '.') . '</td>';
            echo '<td align="right">' . number_format((int)$item->angsa, 0, ',', '.') . '</td>';
            echo '<td align="right">' . number_format((int)$item->kalkun, 0, ',', '.') . '</td>';
            echo '<td align="right">' . number_format((int)$item->burung, 0, ',', '.') . '</td>';
            echo '</tr>';
        }
        
        // Total Keseluruhan
        echo '<tr class="total-row">';
        echo '<td colspan="2" align="center"><b>TOTAL KESELURUHAN</b></td>';
        echo '<td align="right"><b>' . number_format((int)$total->sapi_potong, 0, ',', '.') . '</b></td>';
        echo '<td align="right"><b>' . number_format((int)$total->sapi_perah, 0, ',', '.') . '</b></td>';
        echo '<td align="right"><b>' . number_format((int)$total->kambing, 0, ',', '.') . '</b></td>';
        echo '<td align="right"><b>' . number_format((int)$total->domba, 0, ',', '.') . '</b></td>';
        echo '<td align="right"><b>' . number_format((int)$total->ayam, 0, ',', '.') . '</b></td>';
        echo '<td align="right"><b>' . number_format((int)$total->itik, 0, ',', '.') . '</b></td>';
        echo '<td align="right"><b>' . number_format((int)$total->angsa, 0, ',', '.') . '</b></td>';
        echo '<td align="right"><b>' . number_format((int)$total->kalkun, 0, ',', '.') . '</b></td>';
        echo '<td align="right"><b>' . number_format((int)$total->burung, 0, ',', '.') . '</b></td>';
        echo '</tr>';
        
        echo '</table>';
        echo '</body>';
        echo '</html>';
        
        exit;
    }
}
?>