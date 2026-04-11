<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_History_Data_Ternak extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->model('Laporan_History_Data_Ternak_Model');
        
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['title'] = 'Laporan History Data Ternak';
        $data['kecamatan'] = $this->Laporan_History_Data_Ternak_Model->get_kecamatan();
        $data['tahun'] = $this->Laporan_History_Data_Ternak_Model->get_tahun();
        $data['bulan'] = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        
        $this->load->view('laporan/laporan_history_data_ternak', $data);
    }

    public function get_data()
    {
        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');
        $kecamatan = $this->input->post('kecamatan');
        
        $data = $this->Laporan_History_Data_Ternak_Model->get_history_data($tahun, $bulan, $kecamatan);
        
        $response = [
            'data' => $data,
            'total' => count($data)
        ];
        
        echo json_encode($response);
    }
    
    public function detail_peternak($nik)
    {
        $data['peternak'] = $this->Laporan_History_Data_Ternak_Model->get_peternak_by_nik($nik);
        $data['history'] = $this->Laporan_History_Data_Ternak_Model->get_history_by_nik($nik);
        $this->load->view('laporan/detail_history_peternak', $data);
    }

    public function get_all_data()
{
    // Ambil semua data tanpa filter tahun dan bulan
    $data = $this->Laporan_History_Data_Ternak_Model->get_history_data(null, null, null);
    
    $response = [
        'data' => $data,
        'total' => count($data)
    ];
    
    echo json_encode($response);
}
}