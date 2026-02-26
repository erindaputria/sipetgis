<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Pelaku_Usaha extends CI_Controller {

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
        
        $this->load->model('P_Input_Pelaku_Usaha_Model');
    }

    public function index() {
        $user_kecamatan = $this->session->userdata('kecamatan') ?: 'Benowo';
        $data['pelaku_usaha_data'] = $this->P_Input_Pelaku_Usaha_Model->get_pelaku_usaha_by_kecamatan($user_kecamatan);
        $data['kel_list'] = $this->get_all_kelurahan();
        $data['user_kecamatan'] = $user_kecamatan;
        
        $this->load->view('petugas/p_input_pelaku_usaha', $data);
    }
    
    private function get_all_kelurahan() {
        return array(
            'ASEMROWO' => array('Asemrowo', 'Genting Kalianak', 'Tambak Sarioso'),
            'BENOWO' => array('Benowo', 'Kandangan', 'Romokalisari', 'Sememi', 'Tambak Osowilangun'),
            'BUBUTAN' => array('Bubutan', 'Alun-alun Contong', 'Gundih', 'Jepara', 'Tembok Dukuh'),
            'BULAK' => array('Bulak', 'Kedung Cowek', 'Kenjeran', 'Sukolilo Baru'),
            'DUKUH PAKIS' => array('Dukuh Pakis', 'Dukuh Kupang', 'Gunung Sari', 'Pradah Kalikendal'),
            'GAYUNGAN' => array('Gayungan', 'Dukuh Menanggal', 'Ketintang', 'Menanggal'),
            'GENTENG' => array('Genteng', 'Embong Kaliasin', 'Kapasari', 'Ketabang', 'Peneleh'),
            'GUBENG' => array('Gubeng', 'Airlangga', 'Barata Jaya', 'Gubeng', 'Kertajaya', 'Mojo'),
            'GUNUNG ANYAR' => array('Gunung Anyar', 'Gunung Anyar Tambak', 'Rungkut Menanggal', 'Rungkut Tengah'),
            'JAMBANGAN' => array('Jambangan', 'Jambangan', 'Karah', 'Kebonsari', 'Pagesangan'),
            'KARANG PILANG' => array('Karang Pilang', 'Karang Pilang', 'Kebraon', 'Kedurus', 'Warugunung'),
            'KENJERAN' => array('Kenjeran', 'Bulak Banteng', 'Tambak Wedi', 'Tanah Kali Kedinding'),
            'KREMBANGAN' => array('Krembangan', 'Dupak', 'Krembangan Selatan', 'Krembangan Utara', 'Morokrembangan', 'Perak Barat'),
            'LAKARSANTRI' => array('Lakarsantri', 'Bangkingan', 'Jeruk', 'Lakarsantri', 'Lidah Kulon', 'Lidah Wetan', 'Sumur Welut'),
            'MULYOREJO' => array('Mulyorejo', 'Dukuh Sutorejo', 'Kalijudan', 'Kalisari', 'Kejawan Putih Tambak', 'Manyar Sabrangan', 'Mulyorejo'),
            'PABEAN CANTIAN' => array('Pabean Cantian', 'Bongkaran', 'Krembangan Selatan', 'Nyamplungan', 'Perak Timur', 'Perak Utara'),
            'PAKAL' => array('Pakal', 'Babat Jerawat', 'Benowo', 'Pakal', 'Sumber Rejo', 'Tambak Dono'),
            'RUNGKUT' => array('Rungkut', 'Kali Rungkut', 'Kedung Baruk', 'Medokan Ayu', 'Penjaringansari', 'Rungkut Kidul', 'Rungkut Tengah'),
            'SAMBIKEREP' => array('Sambikerep', 'Bringin', 'Lontar', 'Made', 'Sambikerep'),
            'SAWAHAN' => array('Sawahan', 'Banyu Urip', 'Kupang Krajan', 'Pakis', 'Patemon', 'Putat Jaya', 'Sawahan'),
            'SEMAMPIR' => array('Semampir', 'Ampel', 'Pegirian', 'Sidotopo', 'Ujung', 'Wonokusumo'),
            'SIMOKERTO' => array('Simokerto', 'Kapasan', 'Simokerto', 'Tambakrejo', 'Sidodadi'),
            'SUKOLILO' => array('Sukolilo', 'Keputih', 'Gebang Putih', 'Klampis Ngasem', 'Medokan Semampir', 'Menur Pumpungan', 'Nginden Jangkungan', 'Semolowaru'),
            'SUKOMANUNGGAL' => array('Sukomanunggal', 'Putat Gede', 'Simomulyo', 'Sukomanunggal', 'Tanjungsari', 'Sonokwijenan'),
            'TAMBAKSARI' => array('Tambaksari', 'Gading', 'Kapas Madya', 'Pacarkeling', 'Pacarkembang', 'Ploso', 'Rangkah', 'Tambaksari'),
            'TANDES' => array('Tandes', 'Balongsari', 'Banjar Sugihan', 'Karang Poh', 'Manukan Kulon', 'Manukan Wetan', 'Tandes'),
            'TEGALSARI' => array('Tegalsari', 'Dr. Soetomo', 'Kedungdoro', 'Keputran', 'Tegalsari', 'Wonorejo'),
            'TENGGILIS MEJOYO' => array('Tenggilis Mejoyo', 'Kendangsari', 'Kutisari', 'Panjang Jiwo', 'Tenggilis Mejoyo'),
            'WIYUNG' => array('Wiyung', 'Babatan', 'Balas Klumprik', 'Jajar Tunggal', 'Wiyung'),
            'WONOCOLO' => array('Wonocolo', 'Bendul Merisi', 'Jemur Wonosari', 'Margorejo', 'Sidosermo', 'Siwalankerto'),
            'WONOKROMO' => array('Wonokromo', 'Darmo', 'Jagir', 'Ngagel', 'Ngagel Rejo', 'Sawunggaling', 'Wonokromo')
        );
    }

    public function save() {
        // Set response header
        header('Content-Type: application/json');
        
        // Set validation rules
        $this->form_validation->set_rules('nama', 'Nama Pelaku Usaha', 'required|trim|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim|exact_length[16]|numeric');
        $this->form_validation->set_rules('telepon', 'Telepon', 'trim|min_length[10]|max_length[15]|numeric');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required|trim');
        $this->form_validation->set_rules('kelurahan', 'Kelurahan', 'required|trim');
        $this->form_validation->set_rules('jenis_usaha', 'Jenis Usaha', 'required|trim');
        $this->form_validation->set_rules('latitude', 'Latitude', 'required|trim|numeric');
        $this->form_validation->set_rules('longitude', 'Longitude', 'required|trim|numeric');
        $this->form_validation->set_rules('status', 'Status', 'trim');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array(
                'status' => 'error',
                'message' => validation_errors()
            ));
            return;
        }

        // Cek NIK sudah terdaftar atau belum
        $nik = $this->input->post('nik');
        $existing = $this->P_Input_Pelaku_Usaha_Model->check_nik($nik);
        
        if ($existing) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'NIK ' . $nik . ' sudah terdaftar atas nama ' . $existing['nama']
            ));
            return;
        }

        // Upload foto
        $uploaded_files = array();
        $upload_path = './uploads/pelaku_usaha/';
        
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
        }

        $foto_name = NULL;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] != 4) {
            
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 5120; // 5MB
            $config['encrypt_name'] = TRUE;
            
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('foto')) {
                $upload_data = $this->upload->data();
                $foto_name = $upload_data['file_name'];
            } else {
                $error = $this->upload->display_errors();
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Gagal upload foto: ' . strip_tags($error)
                ));
                return;
            }
        }

        // Data sesuai dengan struktur tabel pelaku_usaha
        $data = array(
            'nama' => $this->input->post('nama'),
            'nik' => $nik,
            'telepon' => $this->input->post('telepon') ?: NULL,
            'alamat' => $this->input->post('alamat'),
            'kecamatan' => $this->input->post('kecamatan'),
            'kelurahan' => $this->input->post('kelurahan'),
            'jenis_usaha' => $this->input->post('jenis_usaha'),
            'latitude' => $this->input->post('latitude'),
            'longitude' => $this->input->post('longitude'),
            'foto' => $foto_name,
            'status' => $this->input->post('status') ?: 'Aktif',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        if ($this->P_Input_Pelaku_Usaha_Model->save_pelaku_usaha($data)) {
            $foto_msg = $foto_name ? ' dan 1 foto' : ' (tanpa foto)';
            echo json_encode(array(
                'status' => 'success',
                'message' => 'Data pelaku usaha berhasil disimpan' . $foto_msg
            ));
        } else {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Gagal menyimpan data pelaku usaha'
            ));
        }
    }

    public function get_all_data() {
        $user_kecamatan = $this->session->userdata('kecamatan') ?: 'Benowo';
        $data = $this->P_Input_Pelaku_Usaha_Model->get_pelaku_usaha_by_kecamatan($user_kecamatan);
        echo json_encode($data);
    }

    public function get_by_periode() {
        $tahun = $this->input->post('tahun');
        $kecamatan = $this->session->userdata('kecamatan') ?: 'Benowo';
        
        if (!$tahun) {
            $tahun = date('Y');
        }
        
        $data = $this->P_Input_Pelaku_Usaha_Model->get_by_periode($tahun, $kecamatan);
        
        if (!empty($data)) {
            echo json_encode(array(
                'status' => 'success',
                'data' => $data
            ));
        } else {
            echo json_encode(array(
                'status' => 'empty',
                'data' => [],
                'message' => 'Tidak ada data untuk tahun ' . $tahun . ' di kecamatan ' . $kecamatan
            ));
        }
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
    
    public function check_nik() {
        $nik = $this->input->post('nik');
        $existing = $this->P_Input_Pelaku_Usaha_Model->check_nik($nik);
        
        if ($existing) {
            echo json_encode(array(
                'status' => 'exist',
                'message' => 'NIK sudah terdaftar atas nama ' . $existing['nama']
            ));
        } else {
            echo json_encode(array(
                'status' => 'available',
                'message' => 'NIK tersedia'
            ));
        }
    }
}