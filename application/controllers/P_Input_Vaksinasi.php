<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Vaksinasi extends CI_Controller {

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
        
        $this->load->model('P_Input_Vaksinasi_Model');
    }

    public function index() {
        $user_kecamatan = $this->session->userdata('kecamatan');
        $data['vaksinasi_data'] = $this->P_Input_Vaksinasi_Model->get_vaksinasi_by_kecamatan($user_kecamatan);
        $data['kel_list'] = $this->get_all_kelurahan();
        $data['user_kecamatan'] = $user_kecamatan;
        
        $this->load->view('petugas/p_input_vaksinasi', $data);
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
        // Validasi array data (multiple komoditas)
        $komoditas = $this->input->post('komoditas_ternak');
        $jenis = $this->input->post('jenis_vaksinasi');
        $dosis = $this->input->post('dosis');
        $jumlah = $this->input->post('jumlah');

        if (empty($komoditas) || !is_array($komoditas)) {
            $response = array(
                'status' => 'error',
                'message' => 'Data komoditas harus diisi minimal 1'
            );
            echo json_encode($response);
            return;
        }

        foreach ($komoditas as $index => $k) {
            if (empty($k)) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Jenis hewan baris ke-' . ($index + 1) . ' harus diisi'
                );
                echo json_encode($response);
                return;
            }
            
            if (empty($jenis[$index])) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Jenis vaksinasi baris ke-' . ($index + 1) . ' harus dipilih'
                );
                echo json_encode($response);
                return;
            }
            
            if (empty($dosis[$index])) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Dosis baris ke-' . ($index + 1) . ' harus dipilih'
                );
                echo json_encode($response);
                return;
            }
            
            if (empty($jumlah[$index]) || $jumlah[$index] < 1) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Jumlah baris ke-' . ($index + 1) . ' harus diisi (minimal 1)'
                );
                echo json_encode($response);
                return;
            }
        }

        // Upload foto
        $uploaded_file = null;
        $upload_path = './uploads/vaksinasi/';
        
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
        }

        if (isset($_FILES['foto_vaksinasi']) && $_FILES['foto_vaksinasi']['error'] != 4) {
            
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 5120;
            $config['encrypt_name'] = TRUE;
            
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('foto_vaksinasi')) {
                $upload_data = $this->upload->data();
                $uploaded_file = $upload_data['file_name'];
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

        // Simpan setiap baris komoditas sebagai record terpisah
        $success_count = 0;
        
        foreach ($komoditas as $index => $k) {
            $data = array(
                'nama_petugas' => $this->input->post('nama_petugas'),
                'nama_peternak' => $this->input->post('nama_peternak'),
                'nik' => $this->input->post('nik') ?: NULL,
                'tanggal_vaksinasi' => $this->input->post('tanggal_vaksinasi'),
                'alamat' => $this->input->post('alamat'),
                'keterangan' => $this->input->post('keterangan') ?: NULL,
                'bantuan_prov' => $this->input->post('bantuan_prov'),
                'kecamatan' => $this->session->userdata('kecamatan'),
                'kelurahan' => $this->input->post('kelurahan'),
                'rt' => $this->input->post('rt') ?: NULL,
                'rw' => $this->input->post('rw') ?: NULL,
                'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude'),
                'telp' => $this->input->post('telp') ?: NULL,
                'foto_vaksinasi' => $uploaded_file,
                'komoditas_ternak' => $k,
                'jenis_vaksinasi' => $jenis[$index],
                'dosis' => $dosis[$index],
                'jumlah' => $jumlah[$index]
            );
            
            if ($this->P_Input_Vaksinasi_Model->save_vaksinasi($data)) {
                $success_count++;
            }
        }

        if ($success_count > 0) {
            $foto_msg = $uploaded_file ? ' dan 1 foto' : '';
            $response = array(
                'status' => 'success',
                'message' => $success_count . ' data vaksinasi berhasil disimpan' . $foto_msg
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Gagal menyimpan data vaksinasi. Silakan cek kembali data Anda.'
            );
        }

        echo json_encode($response);
    }

    public function get_all_data() {
        $user_kecamatan = $this->session->userdata('kecamatan');
        $data = $this->P_Input_Vaksinasi_Model->get_vaksinasi_by_kecamatan($user_kecamatan);
        echo json_encode($data);
    }

    public function get_by_periode() {
        $tahun = $this->input->post('tahun');
        $kecamatan = $this->session->userdata('kecamatan');
        
        if (!$tahun) {
            $tahun = date('Y');
        }
        
        $data = $this->P_Input_Vaksinasi_Model->get_by_periode($tahun, $kecamatan);
        
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

    public function get_kelurahan_by_kecamatan() {
        $kecamatan = $this->input->post('kecamatan');
        $kel_list = $this->get_all_kelurahan();
        
        if (isset($kel_list[$kecamatan])) {
            echo json_encode($kel_list[$kecamatan]);
        } else {
            echo json_encode([]);
        }
    }
    
    public function cek_nik() {
        $nik = $this->input->post('nik');
        $kecamatan = $this->session->userdata('kecamatan');
        
        if (empty($nik)) {
            echo json_encode(['status' => 'empty']);
            return;
        } 
        
        $cek = $this->P_Input_Vaksinasi_Model->cek_nik_exists($nik, $kecamatan);
        
        if ($cek) {
            echo json_encode([
                'status' => 'exists',
                'message' => 'NIK ini sudah pernah digunakan sebanyak ' . $cek . ' kali di kecamatan ini'
            ]);
        } else {
            echo json_encode(['status' => 'new']);
        }
    }
}