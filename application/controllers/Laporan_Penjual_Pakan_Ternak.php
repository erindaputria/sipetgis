<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_Penjual_Pakan_Ternak extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        // Load library yang diperlukan
        $this->load->library('session');
        $this->load->model('Laporan_Penjual_Pakan_Ternak_Model');
        
        // Cek login
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['title'] = 'Laporan Penjual Pakan Ternak';
        $data['kecamatan'] = $this->Laporan_Penjual_Pakan_Ternak_Model->get_kecamatan();
        $data['tahun'] = $this->Laporan_Penjual_Pakan_Ternak_Model->get_tahun();
        
        $this->load->view('laporan/laporan_penjual_pakan_ternak', $data);
    }

    public function get_data()
    {
        $tahun = $this->input->post('tahun');
        $kecamatan = $this->input->post('kecamatan');
        
        $data = $this->Laporan_Penjual_Pakan_Ternak_Model->get_data_penjual_pakan($tahun, $kecamatan);
        $total = $this->Laporan_Penjual_Pakan_Ternak_Model->get_total_penjual_pakan($tahun, $kecamatan);
        
        $response = [
            'data' => $data,
            'total' => $total
        ];
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    public function export_excel()
    {
        $tahun = $this->input->get('tahun');
        $kecamatan = $this->input->get('kecamatan');
        
        // Jika tahun kosong, gunakan tahun default
        if(empty($tahun)) {
            $tahun = date('Y');
        }
        
        // Get data from database
        $results = $this->Laporan_Penjual_Pakan_Ternak_Model->get_data_penjual_pakan($tahun, $kecamatan);
        $total = $this->Laporan_Penjual_Pakan_Ternak_Model->get_total_penjual_pakan($tahun, $kecamatan);
        
        // Load PHPExcel library
        $this->load->library('excel');
        
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("SIPETGIS")
                                     ->setLastModifiedBy("SIPETGIS")
                                     ->setTitle("Laporan Penjual Pakan Ternak")
                                     ->setSubject("Laporan Penjual Pakan Ternak")
                                     ->setDescription("Laporan penjual pakan ternak Kota Surabaya");
        
        // Add header
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        
        $kecamatanText = ($kecamatan && $kecamatan != 'semua') ? 'Kecamatan ' . $kecamatan : 'Seluruh Kecamatan';
        
        $sheet->setCellValue('A1', 'DATA PENJUAL PAKAN TERNAK TAHUN ' . $tahun);
        $sheet->setCellValue('A2', 'Kota Surabaya - ' . $kecamatanText);
        
        // Merge cells for title
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');
        
        // Style title
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        // Column headers
        $headers = ['No', 'Nama Toko/Perusahaan', 'NIB/SIUP', 'Alamat', 'Kecamatan', 'Kelurahan', 'Nama Pemilik', 'No WA', 'Obat Hewan'];
        $col = 'A';
        foreach($headers as $header) {
            $sheet->setCellValue($col . '4', $header);
            $sheet->getStyle($col . '4')->getFont()->setBold(true);
            $sheet->getStyle($col . '4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col . '4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $sheet->getStyle($col . '4')->getFill()->getStartColor()->setARGB('FFE0E0E0');
            $col++;
        }
        
        // Add data
        $row = 5;
        $no = 1;
        foreach($results as $item) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $item->nama_toko);
            $sheet->setCellValue('C' . $row, $item->nib);
            $sheet->setCellValue('D' . $row, $item->alamat);
            $sheet->setCellValue('E' . $row, $item->kecamatan);
            $sheet->setCellValue('F' . $row, $item->kelurahan);
            $sheet->setCellValue('G' . $row, $item->nama_pemilik);
            $sheet->setCellValue('H' . $row, $item->telp);
            $sheet->setCellValue('I' . $row, ($item->obat_hewan == 'Y') ? 'Ya' : 'Tidak');
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
        $sheet->setCellValue('H' . $row, 'TOTAL USAHA');
        $sheet->setCellValue('I' . $row, $total->total_usaha . ' Usaha');
        
        // Style total row
        $sheet->getStyle('H' . $row . ':I' . $row)->getFont()->setBold(true);
        $sheet->getStyle('H' . $row . ':I' . $row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $sheet->getStyle('H' . $row . ':I' . $row)->getFill()->getStartColor()->setARGB('FFE8F5E9');
        
        // Auto size columns
        foreach(range('A', 'I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        } 
        
        $filename = 'Laporan_Penjual_Pakan_Ternak_' . $tahun . '.xls';
        
        // Redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
}