<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_Pengobatan_Ternak extends CI_Controller {

    public function __construct()
    { 
        parent::__construct();
        
        $this->load->library('session');
        $this->load->model('Laporan_Pengobatan_Ternak_Model');
        
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['title'] = 'Laporan Pengobatan Ternak';
        $data['kecamatan'] = $this->Laporan_Pengobatan_Ternak_Model->get_kecamatan();
        $data['tahun'] = $this->Laporan_Pengobatan_Ternak_Model->get_tahun();
        
        $this->load->view('laporan/laporan_pengobatan_ternak', $data);
    }

    public function get_data()
    {
        $tahun = $this->input->post('tahun');
        $kecamatan = $this->input->post('kecamatan');
        $jenis_hewan = $this->input->post('jenis_hewan');
        
        $data = $this->Laporan_Pengobatan_Ternak_Model->get_data_pengobatan($tahun, $kecamatan, $jenis_hewan);
        $rekap_jenis = $this->Laporan_Pengobatan_Ternak_Model->get_rekap_per_jenis_hewan($tahun, $kecamatan);
        $rekap_kecamatan = $this->Laporan_Pengobatan_Ternak_Model->get_rekap_per_kecamatan($tahun, $jenis_hewan);
        
        $response = [
            'data' => $data,
            'rekap_jenis' => $rekap_jenis,
            'rekap_kecamatan' => $rekap_kecamatan
        ];
        
        echo json_encode($response);
    }
    
    public function export_excel()
    {
        $tahun = $this->input->get('tahun');
        $kecamatan = $this->input->get('kecamatan');
        $jenis_hewan = $this->input->get('jenis_hewan');
        
        if(empty($tahun)) {
            $tahun = date('Y');
        }
        
        $this->load->library('excel');
        
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("SIPETGIS")
                                     ->setLastModifiedBy("SIPETGIS")
                                     ->setTitle("Laporan Pengobatan Ternak")
                                     ->setSubject("Laporan Pengobatan Ternak");
        
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        
        $kecamatanText = ($kecamatan && $kecamatan != 'semua') ? 'Kecamatan ' . $kecamatan : 'Seluruh Kecamatan';
        $jenisText = ($jenis_hewan && $jenis_hewan != 'semua') ? ' - Jenis Hewan: ' . $jenis_hewan : '';
        
        $sheet->setCellValue('A1', 'REKAP DATA PENGOBATAN TERNAK TAHUN ' . $tahun);
        $sheet->setCellValue('A2', 'Kota Surabaya - ' . $kecamatanText . $jenisText);
        
        $sheet->mergeCells('A1:L1');
        $sheet->mergeCells('A2:L2');
        
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $headers = ['No', 'Tanggal', 'Nama Petugas', 'Nama Peternak', 'NIK', 'Alamat', 'Kecamatan', 'Kelurahan', 'Jenis Hewan', 'Gejala Klinis', 'Jenis Pengobatan', 'Jumlah'];
        $col = 'A';
        foreach($headers as $header) {
            $sheet->setCellValue($col . '4', $header);
            $sheet->getStyle($col . '4')->getFont()->setBold(true);
            $sheet->getStyle($col . '4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col . '4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $sheet->getStyle($col . '4')->getFill()->getStartColor()->setARGB('FFE0E0E0');
            $col++;
        }
        
        $results = $this->Laporan_Pengobatan_Ternak_Model->get_data_pengobatan($tahun, $kecamatan, $jenis_hewan);
        
        $row = 5;
        $no = 1;
        foreach($results as $item) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $item->tanggal_pengobatan ? date('d/m/Y', strtotime($item->tanggal_pengobatan)) : '-');
            $sheet->setCellValue('C' . $row, $item->nama_petugas ?? '-');
            $sheet->setCellValue('D' . $row, $item->nama_peternak ?? '-');
            $sheet->setCellValue('E' . $row, $item->nik ?? '-');
            $sheet->setCellValue('F' . $row, $item->alamat ?? '-');
            $sheet->setCellValue('G' . $row, $item->kecamatan ?? '-');
            $sheet->setCellValue('H' . $row, $item->kelurahan ?? '-');
            $sheet->setCellValue('I' . $row, $item->komoditas_ternak ?? '-');
            $sheet->setCellValue('J' . $row, $item->gejala_klinis ?? '-');
            $sheet->setCellValue('K' . $row, $item->jenis_pengobatan ?? '-');
            $sheet->setCellValue('L' . $row, $item->jumlah ?? 0);
            $row++;
        }
        
        $total = $this->Laporan_Pengobatan_Ternak_Model->get_total_pengobatan($tahun, $kecamatan, $jenis_hewan);
        
        $sheet->setCellValue('A' . $row, '');
        $sheet->setCellValue('B' . $row, '');
        $sheet->setCellValue('C' . $row, '');
        $sheet->setCellValue('D' . $row, '');
        $sheet->setCellValue('E' . $row, '');
        $sheet->setCellValue('F' . $row, '');
        $sheet->setCellValue('G' . $row, '');
        $sheet->setCellValue('H' . $row, '');
        $sheet->setCellValue('I' . $row, '');
        $sheet->setCellValue('J' . $row, '');
        $sheet->setCellValue('K' . $row, 'TOTAL JUMLAH');
        $sheet->setCellValue('L' . $row, $total->jumlah);
        
        $sheet->getStyle('K' . $row . ':L' . $row)->getFont()->setBold(true);
        $sheet->getStyle('K' . $row . ':L' . $row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $sheet->getStyle('K' . $row . ':L' . $row)->getFill()->getStartColor()->setARGB('FFE8F5E9');
        
        foreach(range('A', 'L') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        
        $filename = 'Laporan_Pengobatan_Ternak_' . $tahun . '.xls';
        
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
    
    public function export_csv()
    {
        $tahun = $this->input->get('tahun');
        $kecamatan = $this->input->get('kecamatan');
        $jenis_hewan = $this->input->get('jenis_hewan');
        
        if(empty($tahun)) {
            $tahun = date('Y');
        }
        
        $results = $this->Laporan_Pengobatan_Ternak_Model->get_data_pengobatan($tahun, $kecamatan, $jenis_hewan);
        
        $filename = 'Laporan_Pengobatan_Ternak_' . $tahun . '.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, ['No', 'Tanggal', 'Nama Petugas', 'Nama Peternak', 'NIK', 'Alamat', 'Kecamatan', 'Kelurahan', 'Jenis Hewan', 'Gejala Klinis', 'Jenis Pengobatan', 'Jumlah']);
        
        $no = 1;
        foreach($results as $item) {
            fputcsv($output, [
                $no++,
                $item->tanggal_pengobatan ? date('d/m/Y', strtotime($item->tanggal_pengobatan)) : '-',
                $item->nama_petugas ?? '-',
                $item->nama_peternak ?? '-',
                $item->nik ?? '-',
                $item->alamat ?? '-',
                $item->kecamatan ?? '-',
                $item->kelurahan ?? '-',
                $item->komoditas_ternak ?? '-',
                $item->gejala_klinis ?? '-',
                $item->jenis_pengobatan ?? '-',
                $item->jumlah ?? 0
            ]);
        }
        
        fclose($output);
    }
    
    public function export_pdf()
    {
        $tahun = $this->input->get('tahun');
        $kecamatan = $this->input->get('kecamatan');
        $jenis_hewan = $this->input->get('jenis_hewan');
        
        if(empty($tahun)) {
            $tahun = date('Y');
        }
        
        $this->load->library('pdf');
        
        $kecamatanText = ($kecamatan && $kecamatan != 'semua') ? 'Kecamatan ' . $kecamatan : 'Seluruh Kecamatan';
        $jenisText = ($jenis_hewan && $jenis_hewan != 'semua') ? ' - Jenis Hewan: ' . $jenis_hewan : '';
        
        $data['title'] = 'Laporan Pengobatan Ternak';
        $data['subtitle'] = 'Kota Surabaya - ' . $kecamatanText . $jenisText;
        $data['tahun'] = $tahun;
        $data['results'] = $this->Laporan_Pengobatan_Ternak_Model->get_data_pengobatan($tahun, $kecamatan, $jenis_hewan);
        $data['total'] = $this->Laporan_Pengobatan_Ternak_Model->get_total_pengobatan($tahun, $kecamatan, $jenis_hewan);
        
        $html = $this->load->view('laporan/laporan_pengobatan_pdf', $data, true);
        
        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->render();
        $this->pdf->stream('Laporan_Pengobatan_Ternak_' . $tahun . '.pdf', array('Attachment' => 0));
    }

    public function get_all_data()
{
    $this->db->select('*');
    $this->db->from('input_pengobatan');
    $this->db->order_by('tanggal_pengobatan', 'DESC');
    $query = $this->db->get();
    $data = $query->result();
    
    // Rekap per jenis hewan (semua data)
    $this->db->select('komoditas_ternak as jenis_hewan, COUNT(*) as jumlah_kasus, COALESCE(SUM(jumlah), 0) as total_jumlah');
    $this->db->from('input_pengobatan');
    $this->db->where('komoditas_ternak IS NOT NULL');
    $this->db->where('komoditas_ternak !=', '');
    $this->db->group_by('komoditas_ternak');
    $this->db->order_by('total_jumlah', 'DESC');
    $rekap_jenis = $this->db->get()->result();
    
    // Rekap per kecamatan (semua data)
    $this->db->select('kecamatan, COUNT(*) as jumlah_kasus, COALESCE(SUM(jumlah), 0) as total_jumlah');
    $this->db->from('input_pengobatan');
    $this->db->where('kecamatan IS NOT NULL');
    $this->db->where('kecamatan !=', '');
    $this->db->group_by('kecamatan');
    $this->db->order_by('total_jumlah', 'DESC');
    $rekap_kecamatan = $this->db->get()->result();
    
    $response = [
        'data' => $data,
        'rekap_jenis' => $rekap_jenis,
        'rekap_kecamatan' => $rekap_kecamatan
    ];
    
    echo json_encode($response);
}
}
?>