<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_vaksinasi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->model('Laporan_vaksinasi_model');
        
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index() 
    {
        $data['title'] = 'Laporan Vaksinasi Ternak';
        $data['kecamatan'] = $this->Laporan_vaksinasi_model->get_kecamatan();
        $data['tahun'] = $this->Laporan_vaksinasi_model->get_tahun();
        $data['bulan'] = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember' 
        ];
        
        $this->load->view('laporan/laporan_vaksinasi', $data);
    }

    public function get_data()
    {
        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');
        $kecamatan = $this->input->post('kecamatan');
        $jenis_vaksin = $this->input->post('jenis_vaksin');
        
        $data = $this->Laporan_vaksinasi_model->get_data_vaksinasi($tahun, $bulan, $kecamatan, $jenis_vaksin);
        $total = $this->Laporan_vaksinasi_model->get_total_vaksinasi($tahun, $bulan, $kecamatan, $jenis_vaksin);
        
        $response = [
            'data' => $data,
            'total' => $total,
            'jenis_vaksin' => $jenis_vaksin
        ];
        
        echo json_encode($response);
    }
    
    public function detail_kecamatan($kecamatan, $jenis_ternak = null)
    {
        $data['kecamatan'] = urldecode($kecamatan);
        $data['jenis_ternak'] = $jenis_ternak;
        $data['tahun'] = $this->input->get('tahun');
        $data['bulan'] = $this->input->get('bulan');
        $data['list_bulan'] = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        
        $this->load->view('laporan/detail_vaksinasi_kecamatan', $data);
    }
    
    // ==================== EXPORT EXCEL (TANPA LIBRARY) ====================
    public function export_excel()
    {
        $tahun = $this->input->get('tahun');
        $bulan = $this->input->get('bulan');
        $kecamatan = $this->input->get('kecamatan');
        $jenis_vaksin = $this->input->get('jenis_vaksin');
        
        if(empty($tahun)) {
            $tahun = date('Y');
        }
        
        $bulanNama = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        
        $bulanText = ($bulan && $bulan != '') ? $bulanNama[$bulan] : 'Semua Bulan';
        $kecamatanText = ($kecamatan && $kecamatan != 'semua') ? 'Kecamatan ' . $kecamatan : 'Seluruh Kecamatan';
        
        // Header untuk download file Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Laporan_Vaksinasi_' . $jenis_vaksin . '_' . $tahun . '.xls"');
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
        echo '<td colspan="' . ($jenis_vaksin == 'PMK' || $jenis_vaksin == 'LSD' ? '6' : '7') . '" align="center"><b>REKAP DATA VAKSIN ' . $jenis_vaksin . ' TAHUN ' . $tahun . '</b></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td colspan="' . ($jenis_vaksin == 'PMK' || $jenis_vaksin == 'LSD' ? '6' : '7') . '" align="center">Kota Surabaya - ' . $kecamatanText . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td colspan="' . ($jenis_vaksin == 'PMK' || $jenis_vaksin == 'LSD' ? '6' : '7') . '" align="center">Periode: ' . $bulanText . '</td>';
        echo '</tr>';
        echo '<tr><td colspan="' . ($jenis_vaksin == 'PMK' || $jenis_vaksin == 'LSD' ? '6' : '7') . '">&nbsp;</td></tr>';
        
        if($jenis_vaksin == 'PMK' || $jenis_vaksin == 'LSD') {
            $data = $this->Laporan_vaksinasi_model->get_data_pmk_lsd($tahun, $bulan, $kecamatan);
            $total = $this->Laporan_vaksinasi_model->get_total_pmk_lsd($tahun, $bulan, $kecamatan);
            
            // Header Tabel
            echo '<tr>';
            echo '<th>No</th>';
            echo '<th>Kecamatan</th>';
            echo '<th>Sapi Potong</th>';
            echo '<th>Sapi Perah</th>';
            echo '<th>Kambing</th>';
            echo '<th>Domba</th>';
            echo '</tr>';
            
            // Data
            $no = 1;
            foreach($data as $item) {
                echo '<tr>';
                echo '<td align="center">' . $no++ . '</td>';
                echo '<td align="left">' . $item->kecamatan . '</td>';
                echo '<td align="right">' . number_format((int)$item->sapi_potong, 0, ',', '.') . '</td>';
                echo '<td align="right">' . number_format((int)$item->sapi_perah, 0, ',', '.') . '</td>';
                echo '<td align="right">' . number_format((int)$item->kambing, 0, ',', '.') . '</td>';
                echo '<td align="right">' . number_format((int)$item->domba, 0, ',', '.') . '</td>';
                echo '</tr>';
            }
            
            // Total
            echo '<tr class="total-row">';
            echo '<td colspan="2" align="center"><b>TOTAL KESELURUHAN</b></td>';
            echo '<td align="right"><b>' . number_format((int)$total->sapi_potong, 0, ',', '.') . '</b></td>';
            echo '<td align="right"><b>' . number_format((int)$total->sapi_perah, 0, ',', '.') . '</b></td>';
            echo '<td align="right"><b>' . number_format((int)$total->kambing, 0, ',', '.') . '</b></td>';
            echo '<td align="right"><b>' . number_format((int)$total->domba, 0, ',', '.') . '</b></td>';
            echo '</tr>';
            
        } else {
            $data = $this->Laporan_vaksinasi_model->get_data_ndai($tahun, $bulan, $kecamatan);
            $total = $this->Laporan_vaksinasi_model->get_total_ndai($tahun, $bulan, $kecamatan);
            
            // Header Tabel
            echo '<tr>';
            echo '<th>No</th>';
            echo '<th>Kecamatan</th>';
            echo '<th>Ayam</th>';
            echo '<th>Itik</th>';
            echo '<th>Angsa</th>';
            echo '<th>Kalkun</th>';
            echo '<th>Burung</th>';
            echo '</table>';
            
            // Data
            $no = 1;
            foreach($data as $item) {
                echo '<tr>';
                echo '<td align="center">' . $no++ . '</td>';
                echo '<td align="left">' . $item->kecamatan . '</td>';
                echo '<td align="right">' . number_format((int)$item->ayam, 0, ',', '.') . '</td>';
                echo '<td align="right">' . number_format((int)$item->itik, 0, ',', '.') . '</td>';
                echo '<td align="right">' . number_format((int)$item->angsa, 0, ',', '.') . '</td>';
                echo '<td align="right">' . number_format((int)$item->kalkun, 0, ',', '.') . '</td>';
                echo '<td align="right">' . number_format((int)$item->burung, 0, ',', '.') . '</td>';
                echo '</tr>';
            }
            
            // Total
            echo '<tr class="total-row">';
            echo '<td colspan="2" align="center"><b>TOTAL KESELURUHAN</b></td>';
            echo '<td align="right"><b>' . number_format((int)$total->ayam, 0, ',', '.') . '</b></td>';
            echo '<td align="right"><b>' . number_format((int)$total->itik, 0, ',', '.') . '</b></td>';
            echo '<td align="right"><b>' . number_format((int)$total->angsa, 0, ',', '.') . '</b></td>';
            echo '<td align="right"><b>' . number_format((int)$total->kalkun, 0, ',', '.') . '</b></td>';
            echo '<td align="right"><b>' . number_format((int)$total->burung, 0, ',', '.') . '</b></td>';
            echo '</tr>';
        }
        
        echo '</table>';
        echo '</body>';
        echo '</html>';
        
        exit;
    }
    
    // Export CSV (opsional, bisa dikomen juga)
    public function export_csv()
    {
        $tahun = $this->input->get('tahun');
        $bulan = $this->input->get('bulan');
        $kecamatan = $this->input->get('kecamatan');
        $jenis_vaksin = $this->input->get('jenis_vaksin');
        
        if(empty($tahun)) {
            $tahun = date('Y');
        }
        
        $bulanNama = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        
        $bulanText = ($bulan && $bulan != '') ? $bulanNama[$bulan] : 'Semua Bulan';
        $kecamatanText = ($kecamatan && $kecamatan != 'semua') ? 'Kecamatan ' . $kecamatan : 'Seluruh Kecamatan';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Laporan_Vaksinasi_' . $jenis_vaksin . '_' . $tahun . '.csv');
        
        $output = fopen('php://output', 'w');
        
        fputcsv($output, ['REKAP DATA VAKSIN ' . $jenis_vaksin . ' TAHUN ' . $tahun]);
        fputcsv($output, ['Kota Surabaya - ' . $kecamatanText]);
        fputcsv($output, ['Periode: ' . $bulanText]);
        fputcsv($output, []);
        
        if($jenis_vaksin == 'PMK' || $jenis_vaksin == 'LSD') {
            $data = $this->Laporan_vaksinasi_model->get_data_pmk_lsd($tahun, $bulan, $kecamatan);
            $total = $this->Laporan_vaksinasi_model->get_total_pmk_lsd($tahun, $bulan, $kecamatan);
            
            fputcsv($output, ['No', 'Kecamatan', 'Sapi Potong', 'Sapi Perah', 'Kambing', 'Domba']);
            
            $no = 1;
            foreach($data as $item) {
                fputcsv($output, [
                    $no++,
                    $item->kecamatan,
                    $item->sapi_potong,
                    $item->sapi_perah,
                    $item->kambing,
                    $item->domba
                ]);
            }
            
            fputcsv($output, ['', 'TOTAL', $total->sapi_potong, $total->sapi_perah, $total->kambing, $total->domba]);
            
        } else {
            $data = $this->Laporan_vaksinasi_model->get_data_ndai($tahun, $bulan, $kecamatan);
            $total = $this->Laporan_vaksinasi_model->get_total_ndai($tahun, $bulan, $kecamatan);
            
            fputcsv($output, ['No', 'Kecamatan', 'Ayam', 'Itik', 'Angsa', 'Kalkun', 'Burung']);
            
            $no = 1;
            foreach($data as $item) {
                fputcsv($output, [
                    $no++,
                    $item->kecamatan,
                    $item->ayam,
                    $item->itik,
                    $item->angsa,
                    $item->kalkun,
                    $item->burung
                ]);
            }
            
            fputcsv($output, ['', 'TOTAL', $total->ayam, $total->itik, $total->angsa, $total->kalkun, $total->burung]);
        }
        
        fclose($output);
    }
}
?>