<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_stok_pakan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->model('Laporan_stok_pakan_model');
        
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['title'] = 'Laporan Stok Pakan';
        $data['demplot'] = $this->Laporan_stok_pakan_model->get_demplot();
        $data['tahun'] = $this->Laporan_stok_pakan_model->get_tahun();
        
        $this->load->view('laporan/laporan_stok_pakan', $data);
    }

    public function get_data()
    {
        $tahun = $this->input->post('tahun');
        $demplot = $this->input->post('demplot');
        
        // Log untuk debugging
        error_log("=== GET_DATA CALLED ===");
        error_log("Tahun: " . $tahun);
        error_log("Demplot: " . $demplot);
        
        $data = $this->Laporan_stok_pakan_model->get_data_stok_pakan($tahun, $demplot);
        $total = $this->Laporan_stok_pakan_model->get_total_stok_pakan($tahun, $demplot);
        
        error_log("Data count: " . count($data));
        
        $response = [
            'data' => $data,
            'total' => $total
        ];
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
    
    public function export_excel()
    {
        $tahun = $this->input->get('tahun');
        $demplot = $this->input->get('demplot');
        
        if(empty($tahun)) {
            $tahun = date('Y');
        }
        
        $results = $this->Laporan_stok_pakan_model->get_data_stok_pakan($tahun, $demplot);
        $total = $this->Laporan_stok_pakan_model->get_total_stok_pakan($tahun, $demplot);
        
        $this->load->library('excel');
        
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        
        $demplotText = ($demplot && $demplot != 'semua') ? $demplot : 'Seluruh Demplot';
        
        $sheet->setCellValue('A1', 'DATA DETAIL STOK PAKAN DEMPLOT PETERNAKAN TAHUN ' . $tahun);
        $sheet->setCellValue('A2', $demplotText);
        $sheet->mergeCells('A1:J1');
        $sheet->mergeCells('A2:J2');
        
        $headers = ['No', 'Tanggal', 'Nama Demplot', 'Jenis Pakan', 'Merk Pakan', 'Stok Awal (kg)', 'Stok Masuk (kg)', 'Stok Keluar (kg)', 'Stok Akhir (kg)', 'Keterangan'];
        $col = 'A';
        foreach($headers as $header) {
            $sheet->setCellValue($col . '4', $header);
            $sheet->getStyle($col . '4')->getFont()->setBold(true);
            $col++;
        }
        
        $row = 5;
        $no = 1;
        foreach($results as $item) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, date('d/m/Y', strtotime($item->tanggal)));
            $sheet->setCellValue('C' . $row, $item->nama_demplot ?? '-');
            $sheet->setCellValue('D' . $row, $item->jenis_pakan ?? '-');
            $sheet->setCellValue('E' . $row, $item->merk_pakan ?? '-');
            $sheet->setCellValue('F' . $row, $item->stok_awal ?? 0);
            $sheet->setCellValue('G' . $row, $item->stok_masuk ?? 0);
            $sheet->setCellValue('H' . $row, $item->stok_keluar ?? 0);
            $sheet->setCellValue('I' . $row, $item->stok_akhir ?? 0);
            $sheet->setCellValue('J' . $row, $item->keterangan ?? '-');
            $row++;
        }
        
        if(count($results) > 0) {
            $sheet->setCellValue('E' . $row, 'TOTAL');
            $sheet->setCellValue('F' . $row, $total->total_stok_awal);
            $sheet->setCellValue('G' . $row, $total->total_stok_masuk);
            $sheet->setCellValue('H' . $row, $total->total_stok_keluar);
            $sheet->setCellValue('I' . $row, $total->total_stok_akhir);
            $sheet->setCellValue('J' . $row, $total->total_transaksi . ' Transaksi');
        }
        
        foreach(range('A', 'J') as $columnID) { 
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        
        $filename = 'Laporan_stok_pakan_' . $tahun . '.xls';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
} 