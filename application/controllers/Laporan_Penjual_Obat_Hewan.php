<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_Penjual_Obat_Hewan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->model('Laporan_Penjual_Obat_Hewan_Model');
        
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['title'] = 'Laporan Penjual Obat Hewan';
        $data['kecamatan'] = $this->Laporan_Penjual_Obat_Hewan_Model->get_kecamatan();
        $data['tahun'] = $this->Laporan_Penjual_Obat_Hewan_Model->get_tahun();
        
        $this->load->view('laporan/laporan_penjual_obat_hewan', $data);
    }

    public function get_all_data()
    {
        $data = $this->Laporan_Penjual_Obat_Hewan_Model->get_data_penjual_obat('all', 'semua');
        $total = $this->Laporan_Penjual_Obat_Hewan_Model->get_total_penjual_obat('all', 'semua');
        
        $response = [
            'data' => $data,
            'total' => $total
        ];
        
        echo json_encode($response);
    }

    public function get_data()
    {
        $tahun = $this->input->post('tahun');
        $kecamatan = $this->input->post('kecamatan');
        
        $data = $this->Laporan_Penjual_Obat_Hewan_Model->get_data_penjual_obat($tahun, $kecamatan);
        $total = $this->Laporan_Penjual_Obat_Hewan_Model->get_total_penjual_obat($tahun, $kecamatan);
        
        $response = [
            'data' => $data,
            'total' => $total
        ];
        
        echo json_encode($response);
    }
    
    public function get_data_by_kecamatan()
    {
        $kecamatan = $this->input->post('kecamatan');
        
        $data = $this->Laporan_Penjual_Obat_Hewan_Model->get_data_penjual_obat('all', $kecamatan);
        $total = $this->Laporan_Penjual_Obat_Hewan_Model->get_total_penjual_obat('all', $kecamatan);
        
        $response = [
            'data' => $data,
            'total' => $total
        ];
        
        echo json_encode($response);
    }
    
    public function export_excel()
    {
        $tahun = $this->input->get('tahun');
        $kecamatan = $this->input->get('kecamatan');
        
        if(empty($tahun) || $tahun == 'all') {
            $tahun = 'Semua Data';
            $tahunFilter = 'all';
        } else {
            $tahunFilter = $tahun;
            $tahun = 'Tahun ' . $tahun;
        }
        
        $this->load->library('excel');
        
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("SIPETGIS")
                                     ->setLastModifiedBy("SIPETGIS")
                                     ->setTitle("Laporan Penjual Obat Hewan")
                                     ->setSubject("Laporan Penjual Obat Hewan");
        
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        
        $kecamatanText = ($kecamatan && $kecamatan != 'semua') ? 'Kecamatan ' . $kecamatan : 'Seluruh Kecamatan';
        
        $sheet->setCellValue('A1', 'DATA PENJUAL OBAT HEWAN KOTA SURABAYA');
        $sheet->setCellValue('A2', $tahun . ' - ' . $kecamatanText);
        
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');
        
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $headers = ['No', 'Nama Toko', 'Nama Pemilik', 'NIB', 'Alamat', 'Kecamatan', 'Kelurahan', 'Dagangan', 'No Telepon'];
        $col = 'A';
        foreach($headers as $header) {
            $sheet->setCellValue($col . '4', $header);
            $sheet->getStyle($col . '4')->getFont()->setBold(true);
            $sheet->getStyle($col . '4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col . '4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $sheet->getStyle($col . '4')->getFill()->getStartColor()->setARGB('FFE0E0E0');
            $col++;
        }
        
        $results = $this->Laporan_Penjual_Obat_Hewan_Model->get_data_penjual_obat($tahunFilter, $kecamatan);
        $total = $this->Laporan_Penjual_Obat_Hewan_Model->get_total_penjual_obat($tahunFilter, $kecamatan);
        
        $row = 5;
        $no = 1;
        foreach($results as $item) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $item->nama_toko ?? '-');
            $sheet->setCellValue('C' . $row, $item->nama_pemilik ?? '-');
            $sheet->setCellValue('D' . $row, $item->nib ?? '-');
            $sheet->setCellValue('E' . $row, $item->alamat ?? '-');
            $sheet->setCellValue('F' . $row, $item->kecamatan ?? '-');
            $sheet->setCellValue('G' . $row, $item->kelurahan ?? '-');
            $sheet->setCellValue('H' . $row, $item->dagangan ?? '-');
            $sheet->setCellValue('I' . $row, $item->telp ?? '-');
            $row++;
        }
        
        $sheet->setCellValue('A' . $row, '');
        $sheet->setCellValue('B' . $row, '');
        $sheet->setCellValue('C' . $row, '');
        $sheet->setCellValue('D' . $row, '');
        $sheet->setCellValue('E' . $row, '');
        $sheet->setCellValue('F' . $row, '');
        $sheet->setCellValue('G' . $row, '');
        $sheet->setCellValue('H' . $row, 'TOTAL TOKO');
        $sheet->setCellValue('I' . $row, $total->total_toko . ' Toko');
        
        $sheet->getStyle('H' . $row . ':I' . $row)->getFont()->setBold(true);
        $sheet->getStyle('H' . $row . ':I' . $row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $sheet->getStyle('H' . $row . ':I' . $row)->getFill()->getStartColor()->setARGB('FFE8F5E9');
        
        foreach(range('A', 'I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        
        $filename = 'Laporan_Penjual_Obat_Hewan_' . date('Ymd') . '.xls';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
}
?>