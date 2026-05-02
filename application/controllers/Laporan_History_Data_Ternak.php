<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_history_data_ternak extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->model('Laporan_history_data_ternak_model');
        
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index() 
    {
        $data['title'] = 'Laporan History Data Ternak';
        $data['kecamatan'] = $this->Laporan_history_data_ternak_model->get_kecamatan();
        $data['tahun'] = $this->Laporan_history_data_ternak_model->get_tahun();
        $data['bulan'] = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        
        $this->load->view('laporan/laporan_history_data_ternak', $data);
    }

    public function get_data()
    {
        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');
        $kecamatan = $this->input->post('kecamatan');
        
        $data = $this->Laporan_history_data_ternak_model->get_history_data($tahun, $bulan, $kecamatan);
        
        $response = [
            'data' => $data,
            'total' => count($data)
        ];
        
        echo json_encode($response);
    }
    
    public function detail_peternak($nik)
    {
        $data['peternak'] = $this->Laporan_history_data_ternak_model->get_peternak_by_nik($nik);
        $data['history'] = $this->Laporan_history_data_ternak_model->get_history_by_nik($nik);
        $this->load->view('laporan/detail_history_peternak', $data);
    }

    public function get_all_data()
    {
        // Ambil semua data tanpa filter tahun dan bulan
        $data = $this->Laporan_history_data_ternak_model->get_history_data(null, null, null);
        
        $response = [
            'data' => $data,
            'total' => count($data)
        ];
        
        echo json_encode($response);
    }
    
    // ==================== EXPORT EXCEL (TANPA LIBRARY) ====================
    public function export_excel()
    {
        $tahun = $this->input->get('tahun');
        $bulan = $this->input->get('bulan');
        $kecamatan = $this->input->get('kecamatan');
        
        // Ambil data
        $data = $this->Laporan_history_data_ternak_model->get_history_data($tahun, $bulan, $kecamatan);
        
        // Format judul
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
        header('Content-Disposition: attachment; filename="Laporan_History_Data_Ternak_' . $tahun . '_' . $bulan . '.xls"');
        header('Cache-Control: max-age=0');
        
        // Mulai output HTML sebagai Excel
        echo '<html>';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<style>';
        echo 'td, th { border: 1px solid #000; padding: 6px; }';
        echo 'th { background-color: #f2f2f2; }';
        echo '</style>';
        echo '</head>';
        echo '<body>';
        
        echo '<table border="1" cellpadding="5" cellspacing="0">';
        
        // Judul Laporan
        echo '<tr>';
        echo '<td colspan="11" align="center"><b>DATA PETERNAK DAN POPULASI TERNAK</b></td>';
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
        echo '<th>Tanggal Input</th>';
        echo '<th>NIK</th>';
        echo '<th>Nama Peternak</th>';
        echo '<th>Alamat</th>';
        echo '<th>Kecamatan</th>';
        echo '<th>Kelurahan</th>';
        echo '<th>Jenis Hewan</th>';
        echo '<th>Jantan</th>';
        echo '<th>Betina</th>';
        echo '<th>Total</th>';
        echo '</tr>';
        
        // Flatten data for Excel
        $flattenedData = [];
        $no = 1;
        
        foreach($data as $peternak) {
            $hewanList = [
                ['nama' => 'Sapi Potong', 'jantan' => $peternak->sapi_potong_jantan ?? 0, 'betina' => $peternak->sapi_potong_betina ?? 0, 'total' => null],
                ['nama' => 'Sapi Perah', 'jantan' => $peternak->sapi_perah_jantan ?? 0, 'betina' => $peternak->sapi_perah_betina ?? 0, 'total' => null],
                ['nama' => 'Kambing', 'jantan' => $peternak->kambing_jantan ?? 0, 'betina' => $peternak->kambing_betina ?? 0, 'total' => null],
                ['nama' => 'Domba', 'jantan' => $peternak->domba_jantan ?? 0, 'betina' => $peternak->domba_betina ?? 0, 'total' => null],
                ['nama' => 'Kerbau', 'jantan' => $peternak->kerbau_jantan ?? 0, 'betina' => $peternak->kerbau_betina ?? 0, 'total' => null],
                ['nama' => 'Kuda', 'jantan' => $peternak->kuda_jantan ?? 0, 'betina' => $peternak->kuda_betina ?? 0, 'total' => null],
                ['nama' => 'Ayam Buras', 'jantan' => 0, 'betina' => 0, 'total' => $peternak->ayam_buras ?? 0],
                ['nama' => 'Ayam Broiler', 'jantan' => 0, 'betina' => 0, 'total' => $peternak->ayam_broiler ?? 0],
                ['nama' => 'Ayam Layer', 'jantan' => 0, 'betina' => 0, 'total' => $peternak->ayam_layer ?? 0],
                ['nama' => 'Itik', 'jantan' => 0, 'betina' => 0, 'total' => $peternak->itik ?? 0],
                ['nama' => 'Angsa', 'jantan' => 0, 'betina' => 0, 'total' => $peternak->angsa ?? 0],
                ['nama' => 'Kalkun', 'jantan' => 0, 'betina' => 0, 'total' => $peternak->kalkun ?? 0],
                ['nama' => 'Burung', 'jantan' => 0, 'betina' => 0, 'total' => $peternak->burung ?? 0]
            ];
            
            // Filter hewan yang memiliki nilai > 0
            $activeHewan = array_filter($hewanList, function($hewan) {
                if($hewan['total'] !== null) {
                    return $hewan['total'] > 0;
                } else {
                    return ($hewan['jantan'] > 0 || $hewan['betina'] > 0);
                }
            });
            
            if(empty($activeHewan)) {
                $activeHewan = [['nama' => '-', 'jantan' => 0, 'betina' => 0, 'total' => 0]];
            }
            
            $tanggal = $peternak->tanggal_input ? date('d/m/Y', strtotime($peternak->tanggal_input)) : '-';
            
            foreach($activeHewan as $hewan) {
                $totalHewan = ($hewan['total'] !== null) ? $hewan['total'] : ($hewan['jantan'] + $hewan['betina']);
                
                $flattenedData[] = [
                    'no' => $no++,
                    'tanggal' => $tanggal,
                    'nik' => $peternak->nik ?? '-',
                    'nama_peternak' => $peternak->nama_peternak ?? '-',
                    'alamat' => $peternak->alamat ?? '-',
                    'kecamatan' => $peternak->kecamatan ?? '-',
                    'kelurahan' => $peternak->kelurahan ?? '-',
                    'jenis_hewan' => $hewan['nama'],
                    'jantan' => ($hewan['total'] !== null) ? 0 : $hewan['jantan'],
                    'betina' => ($hewan['total'] !== null) ? 0 : $hewan['betina'],
                    'total' => $totalHewan
                ];
            }
        }
        
        // Output data ke Excel
        foreach($flattenedData as $row) {
            echo '<tr>';
            echo '<td align="center">' . $row['no'] . '</td>';
            echo '<td align="center">' . $row['tanggal'] . '</td>';
            echo '<td align="left">' . $row['nik'] . '</td>';
            echo '<td align="left">' . $row['nama_peternak'] . '</td>';
            echo '<td align="left">' . $row['alamat'] . '</td>';
            echo '<td align="left">' . $row['kecamatan'] . '</td>';
            echo '<td align="left">' . $row['kelurahan'] . '</td>';
            echo '<td align="left">' . $row['jenis_hewan'] . '</td>';
            echo '<td align="right">' . number_format($row['jantan'], 0, ',', '.') . '</td>';
            echo '<td align="right">' . number_format($row['betina'], 0, ',', '.') . '</td>';
            echo '<td align="right">' . number_format($row['total'], 0, ',', '.') . '</td>';
            echo '</tr>';
        }
        
        echo '</table>';
        echo '</body>';
        echo '</html>';
        
        exit;
    }
}
?>