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
        // PERBAIKAN: Ubah dari POST menjadi GET
        $tahun = $this->input->get('tahun');
        $bulan = $this->input->get('bulan');
        $kecamatan = $this->input->get('kecamatan');
        $jenis_data = $this->input->get('jenis_data');
        
        if($jenis_data == 'peternak') {
            $data = $this->Laporan_kepemilikan_ternak_model->get_data_peternak($tahun, $bulan, $kecamatan);
        } else {
            $data = $this->Laporan_kepemilikan_ternak_model->get_data_populasi($tahun, $bulan, $kecamatan);
        }
        
        $total = $this->Laporan_kepemilikan_ternak_model->get_total_data($tahun, $bulan, $kecamatan, $jenis_data);
        
        $response = [
            'data' => $data,
            'total' => $total,
            'jenis_data' => $jenis_data
        ];
        
        echo json_encode($response);
    }
    
    public function export_pdf()
    {
        $tahun = $this->input->get('tahun');
        $bulan = $this->input->get('bulan');
        $kecamatan = $this->input->get('kecamatan');
        $jenis_data = $this->input->get('jenis_data');
        
        if($jenis_data == 'peternak') {
            $data = $this->Laporan_kepemilikan_ternak_model->get_data_peternak($tahun, $bulan, $kecamatan);
        } else {
            $data = $this->Laporan_kepemilikan_ternak_model->get_data_populasi($tahun, $bulan, $kecamatan);
        }
        
        $total = $this->Laporan_kepemilikan_ternak_model->get_total_data($tahun, $bulan, $kecamatan, $jenis_data);
        
        $bulanNama = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        
        $jenisDataText = $jenis_data == 'peternak' ? 'PETERNAK' : 'POPULASI TERNAK';
        $bulanText = ($bulan && $bulan != '') ? $bulanNama[$bulan] : 'Semua Bulan';
        $kecamatanText = ($kecamatan && $kecamatan != 'semua') ? 'Kecamatan ' . $kecamatan : 'Seluruh Kecamatan';
        
        // Load DOMPDF
        $this->load->library('pdf');
        
        $html = '<!DOCTYPE html>
        <html>
        <head>
            <title>Laporan Kepemilikan Ternak</title>
            <style>
                body { font-family: Arial, sans-serif; }
                .header { text-align: center; margin-bottom: 20px; }
                .header h2 { margin: 0; }
                .header p { margin: 5px 0; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #000; padding: 8px; text-align: center; }
                th { background-color: #f2f2f2; font-weight: bold; }
                .kecamatan-cell { text-align: left; }
                .total-row { background-color: #e8f5e9; font-weight: bold; }
                .footer { margin-top: 30px; text-align: right; }
            </style>
        </head>
        <body>
            <div class="header">
                <h2>REKAP DATA JUMLAH ' . $jenisDataText . '</h2>
                <p>Kota Surabaya - ' . $kecamatanText . '</p>
                <p>Periode: ' . $bulanText . ' ' . $tahun . '</p>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kecamatan</th>
                        <th>Sapi Potong</th>
                        <th>Sapi Perah</th>
                        <th>Kambing</th>
                        <th>Domba</th>
                        <th>Ayam</th>
                        <th>Itik</th>
                        <th>Angsa</th>
                        <th>Kalkun</th>
                        <th>Burung</th>
                    </tr>
                </thead>
                <tbody>';
        
        $no = 1;
        foreach($data as $item) {
            $html .= '<tr>
                        <td>' . $no++ . '</td>
                        <td class="kecamatan-cell">' . $item->kecamatan . '</td>
                        <td>' . number_format($item->sapi_potong, 0, ',', '.') . '</td>
                        <td>' . number_format($item->sapi_perah, 0, ',', '.') . '</td>
                        <td>' . number_format($item->kambing, 0, ',', '.') . '</td>
                        <td>' . number_format($item->domba, 0, ',', '.') . '</td>
                        <td>' . number_format($item->ayam, 0, ',', '.') . '</td>
                        <td>' . number_format($item->itik, 0, ',', '.') . '</td>
                        <td>' . number_format($item->angsa, 0, ',', '.') . '</td>
                        <td>' . number_format($item->kalkun, 0, ',', '.') . '</td>
                        <td>' . number_format($item->burung, 0, ',', '.') . '</td>
                     </tr>';
        }
        
        // Baris TOTAL
        $html .= '<tr class="total-row">
                    <td colspan="2" style="text-align: center;"><strong>TOTAL KESELURUHAN</strong></td>
                    <td><strong>' . number_format($total->sapi_potong, 0, ',', '.') . '</strong></td>
                    <td><strong>' . number_format($total->sapi_perah, 0, ',', '.') . '</strong></td>
                    <td><strong>' . number_format($total->kambing, 0, ',', '.') . '</strong></td>
                    <td><strong>' . number_format($total->domba, 0, ',', '.') . '</strong></td>
                    <td><strong>' . number_format($total->ayam, 0, ',', '.') . '</strong></td>
                    <td><strong>' . number_format($total->itik, 0, ',', '.') . '</strong></td>
                    <td><strong>' . number_format($total->angsa, 0, ',', '.') . '</strong></td>
                    <td><strong>' . number_format($total->kalkun, 0, ',', '.') . '</strong></td>
                    <td><strong>' . number_format($total->burung, 0, ',', '.') . '</strong></td>
                  </tr>';
        
        $html .= '</tbody>
            </table>
        </body>
        </html>';
        
        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->render();
        
        $filename = 'Laporan_kepemilikan_ternak_' . $jenisDataText . '_' . ($bulanText != 'Semua Bulan' ? $bulanText . '_' : '') . $tahun . '.pdf';
        $this->pdf->stream($filename, array('Attachment' => 0));
    }
}