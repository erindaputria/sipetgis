<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_data_klinik_hewan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        // Load library yang diperlukan
        $this->load->library('session');
        $this->load->model('Laporan_data_klinik_hewan_model');
        
        // Cek login
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['title'] = 'Laporan Data Klinik Hewan';
        $data['kecamatan'] = $this->Laporan_data_klinik_hewan_model->get_kecamatan();
        $data['tahun'] = $this->Laporan_data_klinik_hewan_model->get_tahun();
        
        // Load semua data saat pertama kali halaman dibuka
        $data['data_klinik'] = $this->Laporan_data_klinik_hewan_model->get_data_klinik(null, null);
        $data['total'] = $this->Laporan_data_klinik_hewan_model->get_total_klinik(null, null);
        
        $this->load->view('laporan/laporan_data_klinik_hewan', $data);
    }

    public function get_data()
    {
        header('Content-Type: application/json');
        
        $tahun = $this->input->post('tahun');
        $kecamatan = $this->input->post('kecamatan');
        
        // Jika tahun kosong, ambil semua data
        if(empty($tahun)) {
            $tahun = null;
        }
        
        // Jika kecamatan kosong atau 'semua', ambil semua
        if($kecamatan == 'semua' || empty($kecamatan)) {
            $kecamatan = null;
        }
        
        $data = $this->Laporan_data_klinik_hewan_model->get_data_klinik($tahun, $kecamatan);
        $total = $this->Laporan_data_klinik_hewan_model->get_total_klinik($tahun, $kecamatan);
        
        $response = [
            'status' => 'success',
            'data' => $data,
            'total' => $total
        ];
        
        echo json_encode($response);
    }
    
    public function export_excel()
    {
        $tahun = $this->input->get('tahun');
        $kecamatan = $this->input->get('kecamatan');
        
        // Get data from database
        $results = $this->Laporan_data_klinik_hewan_model->get_data_klinik($tahun, $kecamatan);
        $total = $this->Laporan_data_klinik_hewan_model->get_total_klinik($tahun, $kecamatan);
        
        // Load PHPExcel library
        $this->load->library('excel');
        
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("SIPETGIS")
                                     ->setLastModifiedBy("SIPETGIS")
                                     ->setTitle("Laporan Data Klinik Hewan")
                                     ->setSubject("Laporan Data Klinik Hewan")
                                     ->setDescription("Laporan data klinik hewan Kota Surabaya");
        
        // Add header
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        
        $kecamatanText = ($kecamatan && $kecamatan != 'semua') ? 'Kecamatan ' . $kecamatan : 'Seluruh Kecamatan';
        $tahunText = ($tahun && $tahun != '') ? 'TAHUN ' . $tahun : 'SEMUA TAHUN';
        
        $sheet->setCellValue('A1', 'DATA KLINIK HEWAN KOTA SURABAYA');
        $sheet->setCellValue('A2', $kecamatanText . ' - ' . $tahunText);
        $sheet->setCellValue('A3', 'Tanggal Cetak: ' . date('d/m/Y H:i:s'));
        
        // Merge cells for title
        $sheet->mergeCells('A1:J1');
        $sheet->mergeCells('A2:J2');
        $sheet->mergeCells('A3:J3');
        
        // Style title
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        // Column headers
        $headers = ['No', 'Nama Klinik Hewan', 'NIB', 'Sertifikat Standar', 'Alamat', 'Kecamatan', 'Kelurahan', 'Jumlah Dokter Hewan', 'Nama Pemilik', 'No WA'];
        $col = 'A';
        foreach($headers as $header) {
            $sheet->setCellValue($col . '5', $header);
            $sheet->getStyle($col . '5')->getFont()->setBold(true);
            $sheet->getStyle($col . '5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col . '5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $sheet->getStyle($col . '5')->getFill()->getStartColor()->setARGB('FFE0E0E0');
            $col++;
        }
        
        // Add data
        $row = 6;
        $no = 1;
        foreach($results as $item) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $item->nama_klinik);
            $sheet->setCellValue('C' . $row, $item->nib);
            $sheet->setCellValue('D' . $row, $item->sertifikat_standar);
            $sheet->setCellValue('E' . $row, $item->alamat);
            $sheet->setCellValue('F' . $row, $item->kecamatan);
            $sheet->setCellValue('G' . $row, $item->kelurahan);
            $sheet->setCellValue('H' . $row, $item->jumlah_dokter);
            $sheet->setCellValue('I' . $row, $item->nama_pemilik);
            $sheet->setCellValue('J' . $row, $item->no_wa);
            $row++;
        }
        
        // Add total row
        $sheet->setCellValue('A' . $row, '');
        $sheet->setCellValue('B' . $row, '');
        $sheet->setCellValue('C' . $row, '');
        $sheet->setCellValue('D' . $row, '');
        $sheet->setCellValue('E' . $row, '');
        $sheet->setCellValue('F' . $row, '');
        $sheet->setCellValue('G' . $row, 'TOTAL');
        $sheet->setCellValue('H' . $row, $total->total_dokter . ' Dokter');
        $sheet->setCellValue('I' . $row, $total->total_klinik . ' Klinik');
        $sheet->setCellValue('J' . $row, '');
        
        // Style total row
        $sheet->getStyle('G' . $row . ':I' . $row)->getFont()->setBold(true);
        $sheet->getStyle('G' . $row . ':I' . $row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $sheet->getStyle('G' . $row . ':I' . $row)->getFill()->getStartColor()->setARGB('FFE8F5E9');
        
        // Auto size columns
        foreach(range('A', 'J') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        
        $filename = 'Laporan_data_klinik_hewan_' . date('Ymd_His') . '.xls';
         
        // Redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
}
?>