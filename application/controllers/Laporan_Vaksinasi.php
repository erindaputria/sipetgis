<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_Vaksinasi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->model('Laporan_Vaksinasi_Model');
        
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['title'] = 'Laporan Vaksinasi Ternak';
        $data['kecamatan'] = $this->Laporan_Vaksinasi_Model->get_kecamatan();
        $data['tahun'] = $this->Laporan_Vaksinasi_Model->get_tahun();
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
        
        $data = $this->Laporan_Vaksinasi_Model->get_data_vaksinasi($tahun, $bulan, $kecamatan, $jenis_vaksin);
        $total = $this->Laporan_Vaksinasi_Model->get_total_vaksinasi($tahun, $bulan, $kecamatan, $jenis_vaksin);
        
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
    
    public function export_excel()
    {
        $tahun = $this->input->get('tahun');
        $bulan = $this->input->get('bulan');
        $kecamatan = $this->input->get('kecamatan');
        $jenis_vaksin = $this->input->get('jenis_vaksin');
        
        if(empty($tahun)) {
            $tahun = date('Y');
        }
        
        $this->load->library('excel');
        
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        
        $bulanNama = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        
        $bulanText = ($bulan && $bulan != '') ? $bulanNama[$bulan] : 'Semua Bulan';
        $kecamatanText = ($kecamatan && $kecamatan != 'semua') ? 'Kecamatan ' . $kecamatan : 'Seluruh Kecamatan';
        
        if($jenis_vaksin == 'PMK' || $jenis_vaksin == 'LSD') {
            $data = $this->Laporan_Vaksinasi_Model->get_data_pmk_lsd($tahun, $bulan, $kecamatan);
            $total = $this->Laporan_Vaksinasi_Model->get_total_pmk_lsd($tahun, $bulan, $kecamatan);
            
            $sheet->setCellValue('A1', 'REKAP DATA VAKSIN ' . $jenis_vaksin . ' TAHUN ' . $tahun);
            $sheet->mergeCells('A1:F1');
            $sheet->setCellValue('A2', 'Kota Surabaya - ' . $kecamatanText);
            $sheet->mergeCells('A2:F2');
            $sheet->setCellValue('A3', 'Periode: ' . $bulanText);
            $sheet->mergeCells('A3:F3');
            
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $headers = ['No', 'Kecamatan', 'Sapi Potong', 'Sapi Perah', 'Kambing', 'Domba'];
            $col = 'A';
            foreach($headers as $header) {
                $sheet->setCellValue($col . '5', $header);
                $sheet->getStyle($col . '5')->getFont()->setBold(true);
                $sheet->getStyle($col . '5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($col . '5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $sheet->getStyle($col . '5')->getFill()->getStartColor()->setARGB('FFE0E0E0');
                $col++;
            }
            
            $row = 6;
            $no = 1;
            foreach($data as $item) {
                $sheet->setCellValue('A' . $row, $no++);
                $sheet->setCellValue('B' . $row, $item->kecamatan);
                $sheet->setCellValue('C' . $row, $item->sapi_potong);
                $sheet->setCellValue('D' . $row, $item->sapi_perah);
                $sheet->setCellValue('E' . $row, $item->kambing);
                $sheet->setCellValue('F' . $row, $item->domba);
                $row++;
            }
            
            $sheet->setCellValue('A' . $row, '');
            $sheet->setCellValue('B' . $row, 'TOTAL');
            $sheet->setCellValue('C' . $row, $total->sapi_potong);
            $sheet->setCellValue('D' . $row, $total->sapi_perah);
            $sheet->setCellValue('E' . $row, $total->kambing);
            $sheet->setCellValue('F' . $row, $total->domba);
            
            $sheet->getStyle('B' . $row . ':F' . $row)->getFont()->setBold(true);
            $sheet->getStyle('B' . $row . ':F' . $row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $sheet->getStyle('B' . $row . ':F' . $row)->getFill()->getStartColor()->setARGB('FFE8F5E9');
            
            foreach(range('A', 'F') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }
            
            $filename = 'Laporan_Vaksinasi_' . $jenis_vaksin . '_' . $tahun . '.xls';
            
        } else {
            $data = $this->Laporan_Vaksinasi_Model->get_data_ndai($tahun, $bulan, $kecamatan);
            $total = $this->Laporan_Vaksinasi_Model->get_total_ndai($tahun, $bulan, $kecamatan);
            
            $sheet->setCellValue('A1', 'REKAP DATA VAKSIN ND-AI TAHUN ' . $tahun);
            $sheet->mergeCells('A1:G1');
            $sheet->setCellValue('A2', 'Kota Surabaya - ' . $kecamatanText);
            $sheet->mergeCells('A2:G2');
            $sheet->setCellValue('A3', 'Periode: ' . $bulanText);
            $sheet->mergeCells('A3:G3');
            
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $headers = ['No', 'Kecamatan', 'Ayam', 'Itik', 'Angsa', 'Kalkun', 'Burung'];
            $col = 'A';
            foreach($headers as $header) {
                $sheet->setCellValue($col . '5', $header);
                $sheet->getStyle($col . '5')->getFont()->setBold(true);
                $sheet->getStyle($col . '5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($col . '5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $sheet->getStyle($col . '5')->getFill()->getStartColor()->setARGB('FFE0E0E0');
                $col++;
            }
            
            $row = 6;
            $no = 1;
            foreach($data as $item) {
                $sheet->setCellValue('A' . $row, $no++);
                $sheet->setCellValue('B' . $row, $item->kecamatan);
                $sheet->setCellValue('C' . $row, $item->ayam);
                $sheet->setCellValue('D' . $row, $item->itik);
                $sheet->setCellValue('E' . $row, $item->angsa);
                $sheet->setCellValue('F' . $row, $item->kalkun);
                $sheet->setCellValue('G' . $row, $item->burung);
                $row++;
            }
            
            $sheet->setCellValue('A' . $row, '');
            $sheet->setCellValue('B' . $row, 'TOTAL');
            $sheet->setCellValue('C' . $row, $total->ayam);
            $sheet->setCellValue('D' . $row, $total->itik);
            $sheet->setCellValue('E' . $row, $total->angsa);
            $sheet->setCellValue('F' . $row, $total->kalkun);
            $sheet->setCellValue('G' . $row, $total->burung);
            
            $sheet->getStyle('B' . $row . ':G' . $row)->getFont()->setBold(true);
            $sheet->getStyle('B' . $row . ':G' . $row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $sheet->getStyle('B' . $row . ':G' . $row)->getFill()->getStartColor()->setARGB('FFE8F5E9');
            
            foreach(range('A', 'G') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }
            
            $filename = 'Laporan_Vaksinasi_ND_AI_' . $tahun . '.xls';
        }
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
    
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
        
        // Header
        fputcsv($output, ['REKAP DATA VAKSIN ' . $jenis_vaksin . ' TAHUN ' . $tahun]);
        fputcsv($output, ['Kota Surabaya - ' . $kecamatanText]);
        fputcsv($output, ['Periode: ' . $bulanText]);
        fputcsv($output, []);
        
        if($jenis_vaksin == 'PMK' || $jenis_vaksin == 'LSD') {
            $data = $this->Laporan_Vaksinasi_Model->get_data_pmk_lsd($tahun, $bulan, $kecamatan);
            $total = $this->Laporan_Vaksinasi_Model->get_total_pmk_lsd($tahun, $bulan, $kecamatan);
            
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
            $data = $this->Laporan_Vaksinasi_Model->get_data_ndai($tahun, $bulan, $kecamatan);
            $total = $this->Laporan_Vaksinasi_Model->get_total_ndai($tahun, $bulan, $kecamatan);
            
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
    
    public function export_pdf()
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
        
        $this->load->library('pdf');
        
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        $pdf->SetCreator('SIPETGIS');
        $pdf->SetAuthor('DKPP Surabaya');
        $pdf->SetTitle('Laporan Vaksinasi ' . $jenis_vaksin . ' Tahun ' . $tahun);
        
        $pdf->SetHeaderData('', 0, 'Laporan Vaksinasi Ternak', 'DKPP Kota Surabaya');
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        
        $pdf->AddPage();
        
        $html = '<h2 style="text-align: center;">REKAP DATA VAKSIN ' . $jenis_vaksin . ' TAHUN ' . $tahun . '</h2>';
        $html .= '<p style="text-align: center;">Kota Surabaya - ' . $kecamatanText . '</p>';
        $html .= '<p style="text-align: center;">Periode: ' . $bulanText . '</p>';
        
        if($jenis_vaksin == 'PMK' || $jenis_vaksin == 'LSD') {
            $data = $this->Laporan_Vaksinasi_Model->get_data_pmk_lsd($tahun, $bulan, $kecamatan);
            $total = $this->Laporan_Vaksinasi_Model->get_total_pmk_lsd($tahun, $bulan, $kecamatan);
            
            $html .= '<table border="1" cellpadding="5" style="width:100%; border-collapse:collapse;">';
            $html .= '<thead>
                        <tr style="background-color:#e0e0e0;">
                            <th style="text-align:center;">No</th>
                            <th style="text-align:center;">Kecamatan</th>
                            <th style="text-align:center;">Sapi Potong</th>
                            <th style="text-align:center;">Sapi Perah</th>
                            <th style="text-align:center;">Kambing</th>
                            <th style="text-align:center;">Domba</th>
                        </tr>
                      </thead><tbody>';
            
            $no = 1;
            foreach($data as $item) {
                $html .= '<tr>
                            <td style="text-align:center;">' . $no++ . '</td>
                            <td>' . $item->kecamatan . '</td>
                            <td style="text-align:right;">' . number_format($item->sapi_potong, 0, ',', '.') . '</td>
                            <td style="text-align:right;">' . number_format($item->sapi_perah, 0, ',', '.') . '</td>
                            <td style="text-align:right;">' . number_format($item->kambing, 0, ',', '.') . '</td>
                            <td style="text-align:right;">' . number_format($item->domba, 0, ',', '.') . '</td>
                          </tr>';
            }
            
            $html .= '<tr style="background-color:#e8f5e9; font-weight:bold;">
                        <td colspan="2" style="text-align:center;">TOTAL KESELURUHAN</td>
                        <td style="text-align:right;">' . number_format($total->sapi_potong, 0, ',', '.') . '</td>
                        <td style="text-align:right;">' . number_format($total->sapi_perah, 0, ',', '.') . '</td>
                        <td style="text-align:right;">' . number_format($total->kambing, 0, ',', '.') . '</td>
                        <td style="text-align:right;">' . number_format($total->domba, 0, ',', '.') . '</td>
                      </tr>';
            $html .= '</tbody></table>';
            
        } else {
            $data = $this->Laporan_Vaksinasi_Model->get_data_ndai($tahun, $bulan, $kecamatan);
            $total = $this->Laporan_Vaksinasi_Model->get_total_ndai($tahun, $bulan, $kecamatan);
            
            $html .= '<table border="1" cellpadding="5" style="width:100%; border-collapse:collapse;">';
            $html .= '<thead>
                        <tr style="background-color:#e0e0e0;">
                            <th style="text-align:center;">No</th>
                            <th style="text-align:center;">Kecamatan</th>
                            <th style="text-align:center;">Ayam</th>
                            <th style="text-align:center;">Itik</th>
                            <th style="text-align:center;">Angsa</th>
                            <th style="text-align:center;">Kalkun</th>
                            <th style="text-align:center;">Burung</th>
                        </tr>
                      </thead><tbody>';
            
            $no = 1;
            foreach($data as $item) {
                $html .= '<tr>
                            <td style="text-align:center;">' . $no++ . '</td>
                            <td>' . $item->kecamatan . '</td>
                            <td style="text-align:right;">' . number_format($item->ayam, 0, ',', '.') . '</td>
                            <td style="text-align:right;">' . number_format($item->itik, 0, ',', '.') . '</td>
                            <td style="text-align:right;">' . number_format($item->angsa, 0, ',', '.') . '</td>
                            <td style="text-align:right;">' . number_format($item->kalkun, 0, ',', '.') . '</td>
                            <td style="text-align:right;">' . number_format($item->burung, 0, ',', '.') . '</td>
                          </tr>';
            }
            
            $html .= '<tr style="background-color:#e8f5e9; font-weight:bold;">
                        <td colspan="2" style="text-align:center;">TOTAL KESELURUHAN</td>
                        <td style="text-align:right;">' . number_format($total->ayam, 0, ',', '.') . '</td>
                        <td style="text-align:right;">' . number_format($total->itik, 0, ',', '.') . '</td>
                        <td style="text-align:right;">' . number_format($total->angsa, 0, ',', '.') . '</td>
                        <td style="text-align:right;">' . number_format($total->kalkun, 0, ',', '.') . '</td>
                        <td style="text-align:right;">' . number_format($total->burung, 0, ',', '.') . '</td>
                      </tr>';
            $html .= '</tbody></table>';
        }
        
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('Laporan_Vaksinasi_' . $jenis_vaksin . '_' . $tahun . '.pdf', 'D');
    }
}