<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_Data_Tpu_Rpu extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        // Load library yang diperlukan
        $this->load->library('session');
        $this->load->model('Laporan_Data_Tpu_Rpu_Model');
        
        // Cek login
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['title'] = 'Laporan Data TPU/RPU';
        $data['kecamatan'] = $this->Laporan_Data_Tpu_Rpu_Model->get_kecamatan();
        $data['tahun'] = $this->Laporan_Data_Tpu_Rpu_Model->get_tahun();
        
        $this->load->view('laporan/laporan_data_tpu_rpu', $data);
    }

    public function get_data()
    {
        $tahun = $this->input->post('tahun');
        $kecamatan = $this->input->post('kecamatan');
        
        if(empty($tahun)) {
            $tahun = date('Y');
        }
        
        if(empty($kecamatan)) {
            $kecamatan = 'semua';
        }
        
        $data = $this->Laporan_Data_Tpu_Rpu_Model->get_data_tpu_rpu($tahun, $kecamatan);
        $total = $this->Laporan_Data_Tpu_Rpu_Model->get_total_tpu_rpu($tahun, $kecamatan);
        
        $response = [
            'status' => 'success',
            'data' => $data,
            'total' => $total,
            'tahun' => $tahun,
            'kecamatan' => $kecamatan
        ];
        
        echo json_encode($response);
    }
    
    // ============== METHOD EXPORT ==============
    
    public function export_csv()
    {
        $tahun = $this->input->get('tahun');
        $kecamatan = $this->input->get('kecamatan');
        
        if(empty($tahun)) {
            $tahun = date('Y');
        }
        
        if(empty($kecamatan)) {
            $kecamatan = 'semua';
        }
        
        $data = $this->Laporan_Data_Tpu_Rpu_Model->get_data_tpu_rpu($tahun, $kecamatan);
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="Laporan_TPU_RPU_' . $tahun . '.csv"');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, array('No', 'Kecamatan', 'Nama TPU/RPU', 'Perizinan', 'Alamat', 'Kelurahan', 'Penanggung Jawab', 'No Telepon', 'Ayam (Ekor)', 'Itik (Ekor)', 'Lainnya (Ekor)', 'Tersedia Juleha'));
        
        $no = 1;
        foreach($data as $row) {
            fputcsv($output, array(
                $no++,
                $row->kecamatan,
                $row->nama_tpu,
                $row->perizinan,
                $row->alamat,
                $row->kelurahan,
                $row->pj,
                $row->no_telp,
                $row->jumlah_pemotongan->ayam,
                $row->jumlah_pemotongan->itik,
                $row->jumlah_pemotongan->lainnya,
                $row->tersedia_juleha
            ));
        }
        
        fclose($output);
    }

    public function export_excel()
    {
        $tahun = $this->input->get('tahun');
        $kecamatan = $this->input->get('kecamatan');
        
        if(empty($tahun)) {
            $tahun = date('Y');
        }
        
        if(empty($kecamatan)) {
            $kecamatan = 'semua';
        }
        
        $data = $this->Laporan_Data_Tpu_Rpu_Model->get_data_tpu_rpu($tahun, $kecamatan);
        
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $sheet = $objPHPExcel->getActiveSheet();
        
        // Header
        $sheet->setCellValue('A1', 'LAPORAN DATA TPU/RPU TAHUN ' . $tahun);
        $sheet->mergeCells('A1:L1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        
        $sheet->setCellValue('A2', ($kecamatan && $kecamatan != 'semua') ? 'Kecamatan ' . $kecamatan : 'Seluruh Kecamatan');
        $sheet->mergeCells('A2:L2');
        
        $row = 4;
        $sheet->setCellValue('A' . $row, 'No');
        $sheet->setCellValue('B' . $row, 'Kecamatan');
        $sheet->setCellValue('C' . $row, 'Nama TPU/RPU');
        $sheet->setCellValue('D' . $row, 'Perizinan');
        $sheet->setCellValue('E' . $row, 'Alamat');
        $sheet->setCellValue('F' . $row, 'Kelurahan');
        $sheet->setCellValue('G' . $row, 'Penanggung Jawab');
        $sheet->setCellValue('H' . $row, 'No Telepon');
        $sheet->setCellValue('I' . $row, 'Ayam (Ekor)');
        $sheet->setCellValue('J' . $row, 'Itik (Ekor)');
        $sheet->setCellValue('K' . $row, 'Lainnya (Ekor)');
        $sheet->setCellValue('L' . $row, 'Tersedia Juleha');
        
        $row++;
        $no = 1;
        $totalAyam = 0;
        $totalItik = 0;
        $totalLainnya = 0;
        
        foreach($data as $item) {
            $ayam = $item->jumlah_pemotongan->ayam;
            $itik = $item->jumlah_pemotongan->itik;
            $lainnya = $item->jumlah_pemotongan->lainnya;
            
            $totalAyam += $ayam;
            $totalItik += $itik;
            $totalLainnya += $lainnya;
            
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $item->kecamatan);
            $sheet->setCellValue('C' . $row, $item->nama_tpu);
            $sheet->setCellValue('D' . $row, $item->perizinan);
            $sheet->setCellValue('E' . $row, $item->alamat);
            $sheet->setCellValue('F' . $row, $item->kelurahan);
            $sheet->setCellValue('G' . $row, $item->pj);
            $sheet->setCellValue('H' . $row, $item->no_telp);
            $sheet->setCellValue('I' . $row, $ayam);
            $sheet->setCellValue('J' . $row, $itik);
            $sheet->setCellValue('K' . $row, $lainnya);
            $sheet->setCellValue('L' . $row, $item->tersedia_juleha);
            $row++;
        }
        
        // Total row
        $sheet->setCellValue('A' . $row, '');
        $sheet->setCellValue('B' . $row, '');
        $sheet->setCellValue('C' . $row, '');
        $sheet->setCellValue('D' . $row, '');
        $sheet->setCellValue('E' . $row, '');
        $sheet->setCellValue('F' . $row, '');
        $sheet->setCellValue('G' . $row, '');
        $sheet->setCellValue('H' . $row, 'TOTAL');
        $sheet->setCellValue('I' . $row, $totalAyam);
        $sheet->setCellValue('J' . $row, $totalItik);
        $sheet->setCellValue('K' . $row, $totalLainnya);
        $sheet->setCellValue('L' . $row, count($data) . ' TPU/RPU');
        
        // Style total row
        $sheet->getStyle('H' . $row . ':L' . $row)->getFont()->setBold(true);
        $sheet->getStyle('H' . $row . ':L' . $row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $sheet->getStyle('H' . $row . ':L' . $row)->getFill()->getStartColor()->setARGB('FFE8F5E9');
        
        foreach(range('A', 'L') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        
        $filename = 'Laporan_TPU_RPU_' . $tahun . '.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function export_pdf()
    {
        $tahun = $this->input->get('tahun');
        $kecamatan = $this->input->get('kecamatan');
        
        if(empty($tahun)) {
            $tahun = date('Y');
        }
        
        if(empty($kecamatan)) {
            $kecamatan = 'semua';
        }
        
        $data = $this->Laporan_Data_Tpu_Rpu_Model->get_data_tpu_rpu($tahun, $kecamatan);
        
        // Load library PDF (pastikan sudah ada library TCPDF)
        $this->load->library('pdf');
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('SIPETGIS');
        $pdf->SetAuthor('SIPETGIS');
        $pdf->SetTitle('Laporan Data TPU/RPU');
        $pdf->SetSubject('Laporan Data TPU/RPU');
        $pdf->SetKeywords('TPU, RPU, Laporan');
        
        $pdf->SetHeaderData('', 0, 'LAPORAN DATA TPU/RPU TAHUN ' . $tahun, 'Kota Surabaya');
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->AddPage();
        
        $html = '<h2 align="center">DATA TPU / RPU KOTA SURABAYA TAHUN ' . $tahun . '</h2>';
        $html .= '<h4 align="center">' . (($kecamatan && $kecamatan != 'semua') ? 'Kecamatan ' . $kecamatan : 'Seluruh Kecamatan') . '</h4>';
        $html .= '<br>';
        $html .= '<table border="1" cellpadding="4" style="border-collapse: collapse;">
            <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Kecamatan</th>
                    <th>Nama TPU/RPU</th>
                    <th>Perizinan</th>
                    <th>Alamat</th>
                    <th>Kelurahan</th>
                    <th>PJ</th>
                    <th>No Telp</th>
                    <th>Ayam</th>
                    <th>Itik</th>
                    <th>Lainnya</th>
                    <th>Juleha</th>
                </tr>
            </thead>
            <tbody>';
        
        $no = 1;
        $totalAyam = 0;
        $totalItik = 0;
        $totalLainnya = 0;
        
        foreach($data as $item) {
            $ayam = $item->jumlah_pemotongan->ayam;
            $itik = $item->jumlah_pemotongan->itik;
            $lainnya = $item->jumlah_pemotongan->lainnya;
            
            $totalAyam += $ayam;
            $totalItik += $itik;
            $totalLainnya += $lainnya;
            
            $html .= '<tr>
                <td>' . $no++ . '</td>
                <td>' . $item->kecamatan . '</td>
                <td>' . $item->nama_tpu . '</td>
                <td>' . $item->perizinan . '</td>
                <td>' . $item->alamat . '</td>
                <td>' . $item->kelurahan . '</td>
                <td>' . $item->pj . '</td>
                <td>' . $item->no_telp . '</td>
                <td>' . $ayam . '</td>
                <td>' . $itik . '</td>
                <td>' . $lainnya . '</td>
                <td>' . $item->tersedia_juleha . '</td>
            </tr>';
        }
        
        $html .= '<tr style="background-color: #e8f5e9; font-weight: bold;">
            <td colspan="8" align="center"><strong>TOTAL</strong></td>
            <td><strong>' . $totalAyam . '</strong></td>
            <td><strong>' . $totalItik . '</strong></td>
            <td><strong>' . $totalLainnya . '</strong></td>
            <td><strong>' . count($data) . ' TPU/RPU</strong></td>
        </tr>';
        
        $html .= '</tbody>
            </table>';
        
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('Laporan_TPU_RPU_' . $tahun . '.pdf', 'D');
    }
}
?>