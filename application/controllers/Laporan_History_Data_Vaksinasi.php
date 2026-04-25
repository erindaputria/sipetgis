<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_history_data_vaksinasi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        // Load library yang diperlukan
        $this->load->library('session');
        $this->load->model('Laporan_history_data_vaksinasi_model');
        
        // Cek login
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['title'] = 'Laporan History Data Vaksinasi';
        $data['kecamatan'] = $this->Laporan_history_data_vaksinasi_model->get_kecamatan();
        $data['tahun'] = $this->Laporan_history_data_vaksinasi_model->get_tahun();
        
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
            'status' => 'success',
            'data' => $data,
            'total_dosis' => $total_dosis,
            'jenis_vaksin' => $jenis_vaksin,
            'tahun' => $tahun,
            'count' => count($data)
        ];
        
        echo json_encode($response);
    }
    
    public function export_excel()
    {
        $tahun = $this->input->get('tahun');
        $kecamatan = $this->input->get('kecamatan');
        $jenis_vaksin = $this->input->get('jenis_vaksin');
        $jenis_hewan = $this->input->get('jenis_hewan');
        
        // Jika tahun kosong, gunakan tahun default
        if(empty($tahun)) {
            $tahun = date('Y');
        }
        
        // Load PHPExcel library
        $this->load->library('excel');
        
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("SIPETGIS")
                                     ->setLastModifiedBy("SIPETGIS")
                                     ->setTitle("Laporan History Data Vaksinasi")
                                     ->setSubject("Laporan History Data Vaksinasi")
                                     ->setDescription("Laporan history data vaksinasi ternak Kota Surabaya");
        
        // Add header
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        
        $kecamatanText = ($kecamatan && $kecamatan != 'semua') ? 'Kecamatan ' . $kecamatan : 'Seluruh Kecamatan';
        $jenisHewanText = ($jenis_hewan && $jenis_hewan != 'semua') ? ' - Jenis Hewan: ' . $jenis_hewan : '';
        $jenisVaksinText = ($jenis_vaksin && $jenis_vaksin != 'semua') ? $jenis_vaksin : 'Semua Jenis Vaksin';
        
        $sheet->setCellValue('A1', 'REKAP DATA VAKSIN ' . $jenisVaksinText . ' TAHUN ' . $tahun);
        $sheet->setCellValue('A2', 'Kota Surabaya - ' . $kecamatanText . $jenisHewanText);
        
        // Merge cells for title
        $sheet->mergeCells('A1:J1');
        $sheet->mergeCells('A2:J2');
        
        // Style title
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        // Column headers
        $headers = ['No', 'Tanggal', 'Nama Petugas', 'Nama Peternak', 'NIK', 'Alamat', 'Kecamatan', 'Kelurahan', 'Jenis Hewan', 'Dosis (Jumlah)'];
        $col = 'A';
        foreach($headers as $header) {
            $sheet->setCellValue($col . '4', $header);
            $sheet->getStyle($col . '4')->getFont()->setBold(true);
            $sheet->getStyle($col . '4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col . '4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $sheet->getStyle($col . '4')->getFill()->getStartColor()->setARGB('FFE0E0E0');
            $col++;
        }
        
        // Get data
        $results = $this->Laporan_history_data_vaksinasi_model->get_history_data($tahun, $kecamatan, $jenis_vaksin, $jenis_hewan);
        $total_dosis = $this->Laporan_history_data_vaksinasi_model->get_total_dosis($tahun, $kecamatan, $jenis_vaksin, $jenis_hewan);
        
        // Add data
        $row = 5;
        $no = 1;
        foreach($results as $item) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $item->tanggal);
            $sheet->setCellValue('C' . $row, $item->petugas);
            $sheet->setCellValue('D' . $row, $item->peternak);
            $sheet->setCellValue('E' . $row, $item->nik);
            $sheet->setCellValue('F' . $row, $item->alamat);
            $sheet->setCellValue('G' . $row, $item->kecamatan);
            $sheet->setCellValue('H' . $row, $item->kelurahan);
            $sheet->setCellValue('I' . $row, $item->jenis_hewan);
            $sheet->setCellValue('J' . $row, $item->jumlah);
            $row++;
        }
        
        // Add total row
        $sheet->setCellValue('A' . $row, '');
        $sheet->setCellValue('B' . $row, '');
        $sheet->setCellValue('C' . $row, '');
        $sheet->setCellValue('D' . $row, '');
        $sheet->setCellValue('E' . $row, '');
        $sheet->setCellValue('F' . $row, '');
        $sheet->setCellValue('G' . $row, '');
        $sheet->setCellValue('H' . $row, 'TOTAL');
        $sheet->setCellValue('I' . $row, '');
        $sheet->setCellValue('J' . $row, $total_dosis);
        
        // Style total row
        $sheet->getStyle('H' . $row . ':J' . $row)->getFont()->setBold(true);
        $sheet->getStyle('H' . $row . ':J' . $row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $sheet->getStyle('H' . $row . ':J' . $row)->getFill()->getStartColor()->setARGB('FFE8F5E9');
        
        // Auto size columns
        foreach(range('A', 'J') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        
        $filename = 'Laporan_history_data_vaksinasi_' . ($jenis_vaksin != 'semua' ? $jenis_vaksin : 'Semua') . '_' . $tahun . '.xls';
        
        // Redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
}