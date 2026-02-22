<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Klinik_Hewan extends CI_Controller {

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
        
        $this->load->model('P_Input_Klinik_Hewan_Model');
    }

    public function index() {
        $user_kecamatan = $this->session->userdata('kecamatan');
        $data['klinik_data'] = $this->P_Input_Klinik_Hewan_Model->get_klinik_by_kecamatan($user_kecamatan);
        $data['kel_list'] = $this->get_all_kelurahan();
        $data['user_kecamatan'] = $user_kecamatan;
        
        $this->load->view('petugas/p_input_klinik_hewan', $data);
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
        $this->form_validation->set_rules('nama_klinik', 'Nama Klinik', 'required|trim');
        $this->form_validation->set_rules('kelurahan', 'Kelurahan', 'required|trim');
        $this->form_validation->set_rules('latitude', 'Latitude', 'required|trim');
        $this->form_validation->set_rules('longitude', 'Longitude', 'required|trim');
        $this->form_validation->set_rules('jumlah_dokter', 'Jumlah Dokter', 'numeric');
        $this->form_validation->set_rules('jenis_layanan', 'Jenis Layanan', 'required|trim');
        $this->form_validation->set_rules('surat_ijin', 'Surat Ijin', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status' => 'error',
                'message' => validation_errors()
            );
            echo json_encode($response);
            return;
        }

        // Upload foto klinik
        $foto_name = null;
        $upload_path = './uploads/klinik_hewan/';
        
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
        }

        if (isset($_FILES['foto_klinik']) && $_FILES['foto_klinik']['error'] != 4) {
            
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 5120; // 5MB
            $config['encrypt_name'] = TRUE;
            
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('foto_klinik')) {
                $upload_data = $this->upload->data();
                $foto_name = $upload_data['file_name'];
            } else {
                $error = $this->upload->display_errors();
                $response = array(
                    'status' => 'error',
                    'message' => 'Gagal upload foto: ' . strip_tags($error)
                );
                echo json_encode($response);
                return;
            }
        }

        // Data untuk disimpan
        $data = array(
            'nama_klinik' => $this->input->post('nama_klinik'),
            'keterangan' => $this->input->post('keterangan'),
            'kecamatan' => $this->session->userdata('kecamatan'),
            'kelurahan' => $this->input->post('kelurahan'),
            'rt' => $this->input->post('rt'),
            'rw' => $this->input->post('rw'),
            'latitude' => $this->input->post('latitude'),
            'longitude' => $this->input->post('longitude'),
            'telp' => $this->input->post('telp'),
            'jumlah_dokter' => $this->input->post('jumlah_dokter'),
            'jenis_layanan' => $this->input->post('jenis_layanan'),
            'foto_klinik' => $foto_name,
            'surat_ijin' => $this->input->post('surat_ijin'),
            'created_at' => date('Y-m-d H:i:s')
        );

        if ($this->P_Input_Klinik_Hewan_Model->save_klinik($data)) {
            $foto_msg = $foto_name ? ' dan 1 foto' : ' (tanpa foto)';
            $response = array(
                'status' => 'success',
                'message' => 'Data klinik hewan berhasil disimpan' . $foto_msg
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Gagal menyimpan data klinik hewan. Silakan cek kembali data Anda.'
            );
        }

        echo json_encode($response);
    }

    public function get_all_data() {
        $user_kecamatan = $this->session->userdata('kecamatan');
        $data = $this->P_Input_Klinik_Hewan_Model->get_klinik_by_kecamatan($user_kecamatan);
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