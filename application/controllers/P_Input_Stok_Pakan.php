<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Stok_Pakan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        
        // CEK SESSION LOGIN
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        
        $this->load->model('P_Input_Stok_Pakan_Model');
        $this->load->model('P_Input_Demplot_Model');
    }

    public function index() {
        $user_kecamatan = $this->session->userdata('kecamatan');
        $data['stok_pakan_data'] = $this->P_Input_Stok_Pakan_Model->get_stok_pakan_by_kecamatan($user_kecamatan);
        $data['demplot_list'] = $this->P_Input_Demplot_Model->get_demplot_by_kecamatan($user_kecamatan);
        $data['kel_list'] = $this->get_all_kelurahan();
        $data['user_kecamatan'] = $user_kecamatan;
        
        $this->load->view('petugas/p_input_stok_pakan', $data);
    }
    
    private function get_all_kelurahan() {
        return array(
            'Asemrowo' => array('Asemrowo', 'Genting Kalianak', 'Tambak Sarioso'),
            'Benowo' => array('Benowo', 'Kandangan', 'Romokalisari', 'Sememi', 'Tambak Osowilangun'),
            'Bubutan' => array('Alun-alun Contong', 'Bubutan', 'Gundih', 'Jepara', 'Tembok Dukuh'),
            'Bulak' => array('Bulak', 'Kedung Cowek', 'Kenjeran', 'Sukolilo Baru'),
            'Dukuh Pakis' => array('Dukuh Kupang', 'Dukuh Pakis', 'Gunung Sari', 'Pradah Kalikendal'),
            'Gayungan' => array('Dukuh Menanggal', 'Gayungan', 'Ketintang', 'Menanggal'),
            'Genteng' => array('Embong Kaliasin', 'Genteng', 'Kapasari', 'Ketabang', 'Peneleh'),
            'Gubeng' => array('Airlangga', 'Baratajaya', 'Gubeng', 'Kertajaya', 'Mojo'),
            'Gunung Anyar' => array('Gunung Anyar', 'Gunung Anyar Tambak', 'Rungkut Menanggal', 'Rungkut Tengah'),
            'Jambangan' => array('Jambangan', 'Karah', 'Kebonsari', 'Pagesangan'),
            'Karang Pilang' => array('Karang Pilang', 'Kebraon', 'Kedurus', 'Waru Gunung'),
            'Kenjeran' => array('Bulak Banteng', 'Tambak Wedi', 'Tanah Kali Kedinding', 'Sidotopo Wetan'),
            'Krembangan' => array('Dupak', 'Kemayoran', 'Krembangan Selatan', 'Krembangan Utara', 'Morokrembangan', 'Perak Barat'),
            'Lakarsantri' => array('Bangkingan', 'Jeruk', 'Lakarsantri', 'Lidah Kulon', 'Lidah Wetan', 'Sumur Welut'),
            'Mulyorejo' => array('Dukuh Sutorejo', 'Kalijudan', 'Kaliawan', 'Kejawan Putih Tambak', 'Manyar Sabrangan', 'Mulyorejo'),
            'Pabean Cantian' => array('Bongkaran', 'Krembangan Utara', 'Nyamplungan', 'Perak Timur', 'Perak Utara'),
            'Pakal' => array('Babat Jerawat', 'Pakal', 'Sumber Rejo'),
            'Rungkut' => array('Kali Rungkut', 'Kedung Baruk', 'Medokan Ayu', 'Penjaringan Sari', 'Rungkut Kidul', 'Wonorejo'),
            'Sambikerep' => array('Bringin', 'Lontar', 'Madya', 'Sambikerep'),
            'Sawahan' => array('Banyu Urip', 'Kupang Krajan', 'Pakis', 'Patemon', 'Putat Jaya', 'Sawahan'),
            'Semampir' => array('Ampel', 'Pegirian', 'Sidotopo', 'Ujung', 'Wonokusumo'),
            'Simokerto' => array('Kapasan', 'Simokerto', 'Simolawang', 'Tambak Rejo'),
            'Sukolilo' => array('Gebang Putih', 'Keputih', 'Klampis Ngasem', 'Medokan Semampir', 'Menur Pumpungan', 'Nginden Jangkungan', 'Semolowaru'),
            'Sukomanunggal' => array('Putat Gede', 'Simomulyo', 'Simomulyo Baru', 'Sukomanunggal', 'Tanjungsari'),
            'Tambaksari' => array('Gading', 'Kapas Madya', 'Pacar Kembang', 'Pacar Keling', 'Ploso', 'Rangkah', 'Tambaksari'),
            'Tandes' => array('Balongsari', 'Banjar Sugihan', 'Karang Poh', 'Manukan Kulon', 'Manukan Wetan', 'Tandes'),
            'Tegalsari' => array('Dr. Soetomo', 'Kedungdoro', 'Keputran', 'Tegalsari', 'Wonorejo'),
            'Tenggilis Mejoyo' => array('Kendangsari', 'Kutisari', 'Panjang Jiwo', 'Tenggilis Mejoyo'),
            'Wiyung' => array('Babat Jerawat', 'Balas Klumprik', 'Jajar Tunggal', 'Wiyung'),
            'Wonocolo' => array('Bendul Merisi', 'Jemur Wonosari', 'Margorejo', 'Sidosermo', 'Siwalankerto'),
            'Wonokromo' => array('Darmo', 'Jagir', 'Ngagel', 'Ngagel Rejo', 'Sawunggaling', 'Wonokromo')
        );
    }

    public function save() {
        // Set validation rules
        $this->form_validation->set_rules('id_demplot', 'Demplot', 'required|trim');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('jenis_pakan', 'Jenis Pakan', 'required|trim');
        $this->form_validation->set_rules('merk_pakan', 'Merk Pakan', 'required|trim');
        $this->form_validation->set_rules('stok_awal', 'Stok Awal', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('stok_masuk', 'Stok Masuk', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('stok_keluar', 'Stok Keluar', 'required|numeric|greater_than_equal_to[0]');

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status' => 'error',
                'message' => validation_errors()
            );
            echo json_encode($response);
            return;
        }

        // Hitung stok akhir
        $stok_awal = $this->input->post('stok_awal');
        $stok_masuk = $this->input->post('stok_masuk');
        $stok_keluar = $this->input->post('stok_keluar');
        $stok_akhir = $stok_awal + $stok_masuk - $stok_keluar;

        // Validasi stok akhir tidak boleh negatif
        if ($stok_akhir < 0) {
            $response = array(
                'status' => 'error',
                'message' => 'Stok akhir tidak boleh negatif. Periksa kembali stok keluar!'
            );
            echo json_encode($response);
            return;
        }

        // Siapkan data
        $data = array(
            'id_demplot' => $this->input->post('id_demplot'),
            'tanggal' => $this->input->post('tanggal'),
            'jenis_pakan' => $this->input->post('jenis_pakan'),
            'merk_pakan' => $this->input->post('merk_pakan'),
            'stok_awal' => $stok_awal,
            'stok_masuk' => $stok_masuk,
            'stok_keluar' => $stok_keluar,
            'stok_akhir' => $stok_akhir,
            'keterangan' => $this->input->post('keterangan')
        );

        // Simpan data
        $insert_id = $this->P_Input_Stok_Pakan_Model->save_stok_pakan($data);

        if ($insert_id) {
            $response = array(
                'status' => 'success',
                'message' => 'Data stok pakan berhasil disimpan'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Gagal menyimpan data stok pakan. Silakan cek kembali data Anda.'
            );
        }

        echo json_encode($response);
    }

    public function get_all_data() {
        $user_kecamatan = $this->session->userdata('kecamatan');
        $data = $this->P_Input_Stok_Pakan_Model->get_stok_pakan_by_kecamatan($user_kecamatan);
        echo json_encode($data);
    }

    public function get_by_periode() {
        $tahun = $this->input->post('tahun');
        $kecamatan = $this->session->userdata('kecamatan');
        
        if (!$tahun) {
            $tahun = date('Y');
        }
        
        $data = $this->P_Input_Stok_Pakan_Model->get_by_periode($tahun, $kecamatan);
        
        if (!empty($data)) {
            $response = array(
                'status' => 'success',
                'data' => $data
            );
        } else {
            $response = array(
                'status' => 'empty',
                'data' => [],
                'message' => 'Tidak ada data untuk tahun ' . $tahun . ' di kecamatan ' . $kecamatan
            );
        }
        
        echo json_encode($response);
    }

    public function delete($id) {
        $result = $this->P_Input_Stok_Pakan_Model->delete_stok_pakan($id);
        
        if ($result) {
            $response = array(
                'status' => 'success',
                'message' => 'Data berhasil dihapus'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Gagal menghapus data'
            );
        }
        
        echo json_encode($response);
    }

    public function get_demplot_by_id() {
        $id_demplot = $this->input->post('id_demplot');
        $data = $this->P_Input_Demplot_Model->get_demplot_by_id($id_demplot);
        
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(null);
        }
    }
}