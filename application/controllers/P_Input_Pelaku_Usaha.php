<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_input_pelaku_usaha extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->library('upload');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url', 'file')); 
        
        // Check session login
        if (!$this->session->userdata('logged_in')) {
            redirect('login'); 
        }
        
        $this->load->model('P_input_pelaku_usaha_model');
    }

    public function index() {
        $user_kecamatan = $this->session->userdata('kecamatan') ?: 'Benowo';
        
        // Check if there's a year parameter
        $tahun = $this->input->get('tahun');
        if ($tahun && $tahun != 'all') {
            $data['pelaku_usaha_data'] = $this->P_input_pelaku_usaha_model->get_by_periode($tahun, $user_kecamatan);
        } else {
            $data['pelaku_usaha_data'] = $this->P_input_pelaku_usaha_model->get_pelaku_usaha_by_kecamatan($user_kecamatan);
        }
        
        $data['kel_list'] = $this->get_all_kelurahan();
        $data['user_kecamatan'] = $user_kecamatan;
        
        $this->load->view('petugas/p_input_pelaku_usaha', $data);
    }
    
    private function get_all_kelurahan() {
        return array(
            'BENOWO' => array('Benowo', 'Kandangan', 'Romokalisari', 'Sememi', 'Tambak Osowilangun'),
            'ASEMROWO' => array('Asemrowo', 'Genting Kalianak', 'Tambak Sarioso'),
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
        // Enable error reporting
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        header('Content-Type: application/json');
        
        // Debug log
        error_log("=== SAVE METHOD STARTED ===");
        error_log("POST: " . print_r($this->input->post(), true));
        error_log("FILES: " . print_r($_FILES, true));
        
        try {
            // Set validation rules
            $this->form_validation->set_rules('nama', 'Nama Pelaku Usaha', 'required|trim|min_length[3]|max_length[255]');
            $this->form_validation->set_rules('nik', 'NIK', 'required|trim|exact_length[16]|numeric');
            $this->form_validation->set_rules('telepon', 'Telepon', 'trim|min_length[10]|max_length[15]|numeric');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
            $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required|trim');
            $this->form_validation->set_rules('kelurahan', 'Kelurahan', 'required|trim');
            $this->form_validation->set_rules('latitude', 'Latitude', 'required|trim');
            $this->form_validation->set_rules('longitude', 'Longitude', 'required|trim');
            $this->form_validation->set_rules('nama_petugas', 'Nama Petugas', 'required|trim|min_length[3]|max_length[100]');

            if ($this->form_validation->run() == FALSE) {
                $errors = validation_errors();
                error_log("Validation errors: " . $errors);
                echo json_encode(array(
                    'status' => 'error',
                    'message' => strip_tags($errors)
                ));
                return;
            }

            // Check if NIK already exists
            $nik = $this->input->post('nik');
            error_log("Checking NIK: " . $nik);
            
            $existing = $this->P_input_pelaku_usaha_model->check_nik($nik);
            
            if ($existing) {
                error_log("NIK already exists for: " . $existing['nama']);
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'NIK ' . $nik . ' sudah terdaftar atas nama ' . $existing['nama']
                ));
                return;
            }

            // Handle photo upload
            $foto_name = NULL;
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                error_log("Processing photo upload");
                
                $upload_path = FCPATH . 'uploads/pelaku_usaha/';
                error_log("Upload path: " . $upload_path);
                
                if (!is_dir($upload_path)) {
                    mkdir($upload_path, 0777, TRUE);
                    error_log("Created directory: " . $upload_path);
                }

                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = 5120;
                $config['encrypt_name'] = TRUE;
                
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('foto')) {
                    $upload_data = $this->upload->data();
                    $foto_name = $upload_data['file_name'];
                    error_log("Photo uploaded: " . $foto_name);
                } else {
                    $error = $this->upload->display_errors();
                    error_log("Upload error: " . $error);
                    echo json_encode(array(
                        'status' => 'error',
                        'message' => 'Gagal upload foto: ' . strip_tags($error)
                    ));
                    return;
                }
            } else {
                error_log("No photo to upload");
            }

            // Ambil nama petugas dari input form
            $nama_petugas = $this->input->post('nama_petugas');
            error_log("Petugas name from form: " . $nama_petugas);

            // Prepare data
            $data = array(
                'nama' => $this->input->post('nama'),
                'nik' => $nik,
                'telepon' => $this->input->post('telepon') ?: NULL,
                'alamat' => $this->input->post('alamat'),
                'nama_petugas' => $nama_petugas,
                'tanggal_input' => date('Y-m-d'),
                'kecamatan' => $this->input->post('kecamatan'),
                'kelurahan' => $this->input->post('kelurahan'),
                'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude'),
                'foto' => $foto_name
            );
            
            error_log("Data to save: " . print_r($data, true));

            $result = $this->P_input_pelaku_usaha_model->save_pelaku_usaha($data);
            
            if ($result) {
                $foto_msg = $foto_name ? ' dan 1 foto' : '';
                echo json_encode(array(
                    'status' => 'success',
                    'message' => 'Data pelaku usaha berhasil disimpan' . $foto_msg
                ));
            } else {
                $db_error = $this->db->error();
                error_log("Database error: " . print_r($db_error, true));
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Gagal menyimpan data: ' . $db_error['message']
                ));
            }
            
        } catch (Exception $e) {
            error_log("Exception: " . $e->getMessage());
            error_log("Trace: " . $e->getTraceAsString());
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ));
        }
    }

    public function get_all_data() {
        $user_kecamatan = $this->session->userdata('kecamatan') ?: 'Benowo';
        $data = $this->P_input_pelaku_usaha_model->get_pelaku_usaha_by_kecamatan($user_kecamatan);
        echo json_encode($data);
    }

    public function get_by_periode() {
        $tahun = $this->input->post('tahun');
        $kecamatan = $this->session->userdata('kecamatan') ?: 'Benowo';
        
        if (!$tahun) {
            $tahun = date('Y');
        }
        
        $data = $this->P_input_pelaku_usaha_model->get_by_periode($tahun, $kecamatan);
        
        if (!empty($data)) {
            echo json_encode(array(
                'status' => 'success',
                'data' => $data
            ));
        } else {
            echo json_encode(array(
                'status' => 'empty',
                'data' => [],
                'message' => 'Tidak ada data untuk tahun ' . $tahun
            ));
        }
    }

    public function get_kelurahan_by_kecamatan() {
        // Set header JSON
        $this->output->set_content_type('application/json');
        
        // Get CSRF hash
        $this->security->get_csrf_hash();
        
        $kecamatan = $this->input->post('kecamatan');
        // Convert to uppercase for matching with array keys
        $kecamatan = strtoupper(trim($kecamatan));
        
        $kel_list = $this->get_all_kelurahan();
        
        if (isset($kel_list[$kecamatan])) {
            echo json_encode($kel_list[$kecamatan]);
        } else {
            echo json_encode([]);
        }
    }

    public function check_nik() {
        $nik = $this->input->post('nik');
        $existing = $this->P_input_pelaku_usaha_model->check_nik($nik);
        
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
?>