<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_demplot_peternakan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->model('Laporan_demplot_peternakan_model');
        
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['demplot'] = $this->Laporan_demplot_peternakan_model->get_demplot();
        $data['tahun'] = $this->Laporan_demplot_peternakan_model->get_tahun();
        $data['kecamatan'] = $this->Laporan_demplot_peternakan_model->get_kecamatan();
        
        $this->load->view('laporan/laporan_demplot_peternakan', $data);
    }

    public function get_data()
    {
        $tahun = $this->input->post('tahun');
        $demplot = $this->input->post('demplot');
        $kecamatan = $this->input->post('kecamatan');
        
        $data = $this->Laporan_demplot_peternakan_model->get_data_demplot($tahun, $demplot, $kecamatan);
        $total = $this->Laporan_demplot_peternakan_model->get_total_demplot($tahun, $demplot, $kecamatan);
        
        echo json_encode(['data' => $data, 'total' => $total]);
    }
    
    public function export_excel()
    {
        $tahun = $this->input->get('tahun');
        $demplot = $this->input->get('demplot');
        $kecamatan = $this->input->get('kecamatan');
        
        $this->load->library('excel');
        
        $objPHPExcel = new PHPExcel();
        
        $objPHPExcel->getProperties()->setCreator("SIPETGIS")
                                     ->setLastModifiedBy("SIPETGIS")
                                     ->setTitle("Laporan Demplot Peternakan");
        
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        
        $titleText = 'DATA DEMPLOT PETERNAKAN';
        if($tahun && $tahun != 'semua' && $tahun != '') {
            $titleText .= ' TAHUN ' . $tahun;
        }
        
        $demplotText = ($demplot && $demplot != 'semua') ? $demplot : 'Seluruh Demplot';
        $kecamatanText = ($kecamatan && $kecamatan != 'semua') ? 'Kecamatan ' . $kecamatan : 'Seluruh Kecamatan';
        
        $sheet->setCellValue('A1', $titleText);
        $sheet->setCellValue('A2', $demplotText . ' - ' . $kecamatanText);
        
        $sheet->mergeCells('A1:J1');
        $sheet->mergeCells('A2:J2');
        
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $headers = ['No', 'Nama Demplot', 'Alamat', 'Kecamatan', 'Kelurahan', 'Luas (m²)', 'Jenis Hewan', 'Jumlah (ekor)', 'Stok Pakan', 'Keterangan'];
        $col = 'A';
        foreach($headers as $header) {
            $sheet->setCellValue($col . '4', $header);
            $sheet->getStyle($col . '4')->getFont()->setBold(true);
            $sheet->getStyle($col . '4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col . '4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $sheet->getStyle($col . '4')->getFill()->getStartColor()->setARGB('FFE0E0E0');
            $col++;
        }
        
        $results = $this->Laporan_demplot_peternakan_model->get_data_demplot($tahun, $demplot, $kecamatan);
        $total = $this->Laporan_demplot_peternakan_model->get_total_demplot($tahun, $demplot, $kecamatan);
        
        $row = 5;
        $no = 1;
        foreach($results as $item) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $item->nama_demplot);
            $sheet->setCellValue('C' . $row, $item->alamat);
            $sheet->setCellValue('D' . $row, $item->kecamatan);
            $sheet->setCellValue('E' . $row, $item->kelurahan);
            $sheet->setCellValue('F' . $row, $item->luas_m2);
            $sheet->setCellValue('G' . $row, $item->jenis_hewan);
            $sheet->setCellValue('H' . $row, $item->jumlah_hewan);
            $sheet->setCellValue('I' . $row, $item->stok_pakan);
            $sheet->setCellValue('J' . $row, $item->keterangan);
            $row++;
        }
        
        $sheet->setCellValue('A' . $row, '');
        $sheet->setCellValue('B' . $row, '');
        $sheet->setCellValue('C' . $row, '');
        $sheet->setCellValue('D' . $row, 'TOTAL');
        $sheet->setCellValue('E' . $row, '');
        $sheet->setCellValue('F' . $row, $total->total_luas . ' m²');
        $sheet->setCellValue('G' . $row, '');
        $sheet->setCellValue('H' . $row, $total->total_jumlah . ' ekor');
        $sheet->setCellValue('I' . $row, '');
        $sheet->setCellValue('J' . $row, $total->total_demplot . ' Demplot');
        
        $sheet->getStyle('D' . $row . ':J' . $row)->getFont()->setBold(true);
        $sheet->getStyle('D' . $row . ':J' . $row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $sheet->getStyle('D' . $row . ':J' . $row)->getFill()->getStartColor()->setARGB('FFE8F5E9');
        
        foreach(range('A', 'J') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        } 
        
        $filename = 'Laporan_demplot_peternakan.xls';
        if($tahun && $tahun != 'semua') {
            $filename = 'Laporan_demplot_peternakan_' . $tahun . '.xls';
        }
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
    
    public function detail_demplot($nama_demplot)
    {
        $tahun = $this->input->get('tahun');
        $data['nama_demplot'] = urldecode($nama_demplot);
        $data['tahun'] = $tahun;
        $data['details'] = $this->Laporan_demplot_peternakan_model->get_detail_demplot($nama_demplot, $tahun);
        
        $this->load->view('laporan/laporan_demplot_detail', $data);
    }
}
?>