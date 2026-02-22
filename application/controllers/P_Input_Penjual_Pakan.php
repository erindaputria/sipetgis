<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Penjual_Pakan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->library('upload');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url', 'file'));
        
        // CEK SESSION LOGIN
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        
        $this->load->model('P_Input_Penjual_Pakan_Model');
    }

    public function index() {
        $user_kecamatan = $this->session->userdata('kecamatan');
        $data['penjual_pakan_data'] = $this->P_Input_Penjual_Pakan_Model->get_penjual_pakan_by_kecamatan($user_kecamatan);
        $data['kel_list'] = $this->get_all_kelurahan();
        $data['user_kecamatan'] = $user_kecamatan;
        
        $this->load->view('petugas/p_input_penjual_pakan', $data);
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
        header('Content-Type: application/json');
        
        // Set validation rules
        $this->form_validation->set_rules('nama_toko', 'Nama Toko', 'required|trim');
        $this->form_validation->set_rules('pemilik', 'Nama Pemilik', 'required|trim');
        $this->form_validation->set_rules('nama_petugas', 'Nama Petugas', 'required|trim');
        $this->form_validation->set_rules('tanggal_input', 'Tanggal Input', 'required');
        $this->form_validation->set_rules('kelurahan', 'Kelurahan', 'required|trim');
        $this->form_validation->set_rules('latitude', 'Latitude', 'required|trim');
        $this->form_validation->set_rules('longitude', 'Longitude', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            return;
        }

        // Upload foto
        $foto_name = '';
        $upload_path = './uploads/penjual_pakan/';
        
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
        }

        if (isset($_FILES['foto_toko']) && $_FILES['foto_toko']['error'] != 4) {
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 5120;
            $config['encrypt_name'] = TRUE;
            
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('foto_toko')) {
                $upload_data = $this->upload->data();
                $foto_name = $upload_data['file_name'];
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal upload foto: ' . strip_tags($this->upload->display_errors())]);
                return;
            }
        }

        // Siapkan data
        $data = array(
            'nama_toko' => $this->input->post('nama_toko'),
            'keterangan' => $this->input->post('keterangan') ?: null,
            'kecamatan' => $this->session->userdata('kecamatan'),
            'kelurahan' => $this->input->post('kelurahan'),
            'rt' => $this->input->post('rt') ?: null,
            'rw' => $this->input->post('rw') ?: null,
            'latitude' => $this->input->post('latitude'),
            'longitude' => $this->input->post('longitude'),
            'telp' => $this->input->post('telp') ?: null,
            'foto_toko' => $foto_name ?: null,
            'surat_ijin' => $this->input->post('surat_ijin') ?: 'N',
            'created_at' => date('Y-m-d H:i:s')
        );

        // Simpan ke database
        if ($this->P_Input_Penjual_Pakan_Model->save_penjual_pakan($data)) {
            echo json_encode(['status' => 'success', 'message' => 'Data penjual pakan berhasil disimpan']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data']);
        }
    }

    public function get_all_data() {
        $user_kecamatan = $this->session->userdata('kecamatan');
        $data = $this->P_Input_Penjual_Pakan_Model->get_penjual_pakan_by_kecamatan($user_kecamatan);
        echo json_encode($data);
    }

    public function get_by_periode() {
        $tahun = $this->input->post('tahun');
        $kecamatan = $this->session->userdata('kecamatan');
        $data = $this->P_Input_Penjual_Pakan_Model->get_by_periode($tahun ?: date('Y'), $kecamatan);
        echo json_encode($data);
    }

    public function get_kelurahan_by_kecamatan() {
        $kecamatan = $this->input->post('kecamatan');
        $kel_list = $this->get_all_kelurahan();
        
        if (isset($kel_list[$kecamatan])) {
            echo json_encode($kel_list[$kecamatan]);
        } else {
            echo json_encode([]);
        }
    }
}