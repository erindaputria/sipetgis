<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class K_Laporan_Kepala extends CI_Controller {

    public function index()
    {
        $this->kepemilikan_ternak();
    }

    public function kepemilikan_ternak()
    {
        $data['title'] = 'Laporan Kepemilikan Ternak';
        $this->load->view('kepala/laporan/laporan_kepemilikan_ternak', $data);
    }

    public function history_data_ternak()
    {
        $data['title'] = 'Laporan History Data Ternak';
        $this->load->view('kepala/laporan/laporan_history_data_ternak', $data);
    }

    public function vaksinasi()
    {
        $data['title'] = 'Laporan Vaksinasi';
        $this->load->view('kepala/laporan/laporan_vaksinasi', $data);
    }

    public function history_vaksinasi()
    {
        $data['title'] = 'Laporan History Data Vaksinasi';
        $this->load->view('kepala/laporan/laporan_history_data_vaksinasi', $data);
    }

    public function pengobatan_ternak()
    {
        $data['title'] = 'Laporan Pengobatan Ternak';
        $this->load->view('kepala/laporan/laporan_pengobatan_ternak', $data);
    }

    public function penjual_pakan()
    {
        $data['title'] = 'Laporan Penjual Pakan Ternak';
        $this->load->view('kepala/laporan/laporan_penjual_pakan_ternak', $data);
    }

    public function data_klinik_hewan()
    {
        $data['title'] = 'Laporan Data Klinik Hewan';
        $this->load->view('kepala/laporan/laporan_data_klinik_hewan', $data);
    }

    public function penjual_obat_hewan()
    {
        $data['title'] = 'Laporan Penjual Obat Hewan';
        $this->load->view('kepala/laporan/laporan_penjual_obat_hewan', $data);
    }

    public function data_tpu_rpu()
    {
        $data['title'] = 'Laporan Data TPU / RPU';
        $this->load->view('kepala/laporan/laporan_data_tpu_rpu', $data);
    }

    public function demplot_peternakan()
    {
        $data['title'] = 'Laporan Demplot Peternakan';
        $this->load->view('kepala/laporan/laporan_demplot_peternakan', $data);
    }

    public function stok_pakan()
    {
        $data['title'] = 'Laporan Stok Pakan';
        $this->load->view('kepala/laporan/laporan_stok_pakan', $data);
    }

   
}