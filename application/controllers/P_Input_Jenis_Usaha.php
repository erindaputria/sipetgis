<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Jenis_Usaha extends CI_Controller {

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
        
        $this->load->model('P_Input_Jenis_Usaha_Model');
    }

    public function index() {
        $user_kecamatan = $this->session->userdata('kecamatan');
        $data['jenis_usaha_data'] = $this->P_Input_Jenis_Usaha_Model->get_jenis_usaha_by_kecamatan($user_kecamatan);
        $data['kel_list'] = $this->get_all_kelurahan();
        $data['user_kecamatan'] = $user_kecamatan;
        
        $this->load->view('petugas/p_input_jenis_usaha', $data);
    }
    
    private function get_all_kelurahan() {
        return array(
            'Asemrowo' => array('Asemrowo', 'Genting Kalianak', 'Tambak Sarioso'),
            'Benowo' => array('Benowo', 'Kandangan', 'Romokalisari', 'Sememi', 'Tambak Osowilangun'),
            'Bubutan' => array('Alun-alun Contong', 'Bubutan', 'Gundih', 'Jepara', 'Tembok Dukuh'),
            'Bulak' => array('Bulak', 'Kedungcowek', 'Kenjeran', 'Sukolilo'),
            'Dukuh Pakis' => array('Dukuh Kupang', 'Dukuh Pakis', 'Gunung Sari', 'Pradah Kalikendal'),
            'Gayungan' => array('Dukuh Menanggal', 'Gayungan', 'Ketintang', 'Menanggal'),
            'Genteng' => array('Embong Kaliasin', 'Genteng', 'Kapasari', 'Ketabang', 'Peneleh'),
            'Gubeng' => array('Airlangga', 'Baratajaya', 'Gubeng', 'Kertajaya', 'Mojo', 'Pucang Sewu'),
            'Gunung Anyar' => array('Gunung Anyar', 'Gunung Anyar Tambak', 'Rungkut Menanggal', 'Rungkut Tengah'),
            'Jambangan' => array('Jambangan', 'Karah', 'Kebon Sari', 'Pagesangan'),
            'Karang Pilang' => array('Karang Pilang', 'Kebraon', 'Kedurus', 'Warugunung'),
            'Kenjeran' => array('Bulak Banteng', 'Tambak Wedi', 'Tanah Kali Kedinding'),
            'Krembangan' => array('Dupak', 'Krembangan Selatan', 'Krembangan Utara', 'Morokrembangan', 'Perak Barat'),
            'Lakarsantri' => array('Bangkingan', 'Jeruk', 'Lakarsantri', 'Lidah Kulon', 'Lidah Wetan', 'Sumur Welut'),
            'Mulyorejo' => array('Dukuh Sutorejo', 'Kalijudan', 'Kalisari', 'Kejawan Putih Tambak', 'Manyar Sabrangan', 'Mulyorejo'),
            'Pabean Cantian' => array('Bongkaran', 'Krembangan Utara', 'Nyamplungan', 'Perak Timur', 'Perak Utara'),
            'Pakal' => array('Babatan', 'Benowo', 'Pakal', 'Sumberrejo'),
            'Rungkut' => array('Kedung Baruk', 'Medokan Ayu', 'Penjaringan Sari', 'Rungkut Kidul', 'Rungkut Tengah'),
            'Sambikerep' => array('Bringin', 'Lontar', 'Madya', 'Sambikerep'),
            'Sawahan' => array('Banyu Urip', 'Kupang Krajan', 'Pakis', 'Putat Jaya', 'Sawahan'),
            'Semampir' => array('Ampel', 'Pegirian', 'Sidotopo', 'Ujung', 'Wonokusumo'),
            'Simokerto' => array('Kapasan', 'Simokerto', 'Tambak Rejo'),
            'Sukolilo' => array('Gebang Putih', 'Keputih', 'Klampis Ngasem', 'Menur Pumpungan', 'Nginden Jangkungan', 'Semolowaru'),
            'Sukomanunggal' => array('Putat Gede', 'Simomulyo', 'Simomulyo Baru', 'Sukomanunggal', 'Tanjungsari'),
            'Tambaksari' => array('Gading', 'Kapas Madya', 'Pacar Keling', 'Pacar Kembang', 'Ploso', 'Rangkah', 'Tambaksari'),
            'Tandes' => array('Balongsari', 'Banjar Sugihan', 'Karangan', 'Manukan Kulon', 'Manukan Wetan', 'Tandes'),
            'Tegalsari' => array('Dr. Soetomo', 'Kedungdoro', 'Keputran', 'Tegalsari', 'Wonorejo'),
            'Tenggilis Mejoyo' => array('Kendangsari', 'Kutisari', 'Panjang Jiwo', 'Tenggilis Mejoyo'),
            'Wiyung' => array('Babadan', 'Balas Klumprik', 'Jajar Tunggal', 'Wiyung'),
            'Wonocolo' => array('Bendul Merisi', 'Jemur Wonosari', 'Margorejo', 'Sidosermo', 'Siwalankerto'),
            'Wonokromo' => array('Darmo', 'Jagir', 'Ngagel', 'Ngagel Rejo', 'Sawunggaling', 'Wonokromo')
        );
    }

    public function save() {
        header('Content-Type: application/json');
        
        // Validasi form dasar
        $this->form_validation->set_rules('nama_peternak', 'Nama Peternak', 'required|trim');
        $this->form_validation->set_rules('nama_petugas', 'Nama Petugas', 'required|trim');
        $this->form_validation->set_rules('tanggal_input', 'Tanggal Input', 'required');
        $this->form_validation->set_rules('kelurahan', 'Kelurahan', 'required|trim');
        $this->form_validation->set_rules('latitude', 'Latitude', 'required|trim');
        $this->form_validation->set_rules('longitude', 'Longitude', 'required|trim');

        // Validasi NIK jika diisi
        $nik = $this->input->post('nik');
        if (!empty($nik)) {
            $this->form_validation->set_rules('nik', 'NIK', 'trim|exact_length[16]|numeric');
        }

        // Validasi Telepon jika diisi
        $telepon = $this->input->post('telepon');
        if (!empty($telepon)) {
            $this->form_validation->set_rules('telepon', 'Telepon', 'trim|max_length[15]|numeric');
        }

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array(
                'status' => 'error',
                'message' => validation_errors()
            ));
            return;
        }

        // Ambil data array dari form
        $jenis_usaha = $this->input->post('jenis_usaha');
        $komoditas_ternak = $this->input->post('komoditas_ternak');
        $jumlah = $this->input->post('jumlah');

        // Validasi array harus ada dan tidak kosong
        if (empty($jenis_usaha) || !is_array($jenis_usaha)) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Data jenis usaha tidak valid'
            ));
            return;
        }

        if (empty($komoditas_ternak) || !is_array($komoditas_ternak)) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Data komoditas ternak tidak valid'
            ));
            return;
        }

        if (empty($jumlah) || !is_array($jumlah)) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Data jumlah tidak valid'
            ));
            return;
        }

        // Validasi jumlah baris harus sama
        $total_rows = count($jenis_usaha);
        if ($total_rows != count($komoditas_ternak) || $total_rows != count($jumlah)) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Data tidak konsisten.'
            ));
            return;
        }

        // Validasi setiap baris
        for ($i = 0; $i < $total_rows; $i++) {
            if (empty($jenis_usaha[$i])) {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Jenis usaha baris ke-' . ($i + 1) . ' harus diisi'
                ));
                return;
            }
            
            if (empty($komoditas_ternak[$i])) {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Komoditas ternak baris ke-' . ($i + 1) . ' harus diisi'
                ));
                return;
            }
            
            if (!isset($jumlah[$i]) || $jumlah[$i] === '' || $jumlah[$i] < 0) {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Jumlah baris ke-' . ($i + 1) . ' harus diisi dengan angka valid'
                ));
                return;
            }
        }

        // Upload foto
        $uploaded_file = null;
        $upload_path = './uploads/jenis_usaha/';
        
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
        }

        if (isset($_FILES['foto_usaha']) && $_FILES['foto_usaha']['error'] != 4) {
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 5120;
            $config['encrypt_name'] = TRUE;
            
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('foto_usaha')) {
                $upload_data = $this->upload->data();
                $uploaded_file = $upload_data['file_name'];
            } else {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Gagal upload foto: ' . strip_tags($this->upload->display_errors())
                ));
                return;
            }
        }

        // Ambil data dari form
        $kecamatan_user = $this->session->userdata('kecamatan');
        $nik_val = $this->input->post('nik');
        $telepon_val = $this->input->post('telepon');
        $keterangan_val = $this->input->post('keterangan');
        $rt_val = $this->input->post('rt');
        $rw_val = $this->input->post('rw');
        $alamat_val = $this->input->post('alamat');
        
        $nama_peternak = $this->input->post('nama_peternak');
        $nama_petugas = $this->input->post('nama_petugas');
        $tanggal_input = $this->input->post('tanggal_input');
        $kelurahan = $this->input->post('kelurahan');
        $latitude = $this->input->post('latitude');
        $longitude = $this->input->post('longitude');

        // Simpan setiap baris data
        $success_count = 0;
        
        // Mulai transaksi
        $this->db->trans_begin();

        for ($i = 0; $i < $total_rows; $i++) {
            // PASTIKAN JUMLAH TIDAK BERUBAH
            $jumlah_value = (int)$jumlah[$i];
            
            $data = array(
                'nama_petugas' => $nama_petugas,
                'nama_peternak' => $nama_peternak,
                'nik' => !empty($nik_val) ? $nik_val : null,
                'telepon' => !empty($telepon_val) ? $telepon_val : null,
                'tanggal_input' => $tanggal_input,
                'keterangan' => !empty($keterangan_val) ? $keterangan_val : null,
                'kecamatan' => $kecamatan_user,
                'kelurahan' => $kelurahan,
                'rt' => !empty($rt_val) ? $rt_val : null,
                'rw' => !empty($rw_val) ? $rw_val : null,
                'alamat' => !empty($alamat_val) ? $alamat_val : null,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'foto_usaha' => $uploaded_file,
                'jenis_usaha' => $jenis_usaha[$i],
                'komoditas_ternak' => $komoditas_ternak[$i],
                'jumlah' => $jumlah_value  // PASTIKAN TIDAK BERUBAH
            );
            
            if ($this->P_Input_Jenis_Usaha_Model->save_jenis_usaha($data)) {
                $success_count++;
            }
        }

        if ($this->db->trans_status() === FALSE || $success_count != $total_rows) {
            $this->db->trans_rollback();
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Gagal menyimpan data. Hanya ' . $success_count . ' dari ' . $total_rows . ' data yang tersimpan.'
            ));
        } else {
            $this->db->trans_commit();
            $foto_msg = $uploaded_file ? ' dan 1 foto' : '';
            echo json_encode(array(
                'status' => 'success',
                'message' => $success_count . ' data berhasil disimpan' . $foto_msg
            ));
        }
    }

    public function get_all_data() {
        $user_kecamatan = $this->session->userdata('kecamatan');
        $data = $this->P_Input_Jenis_Usaha_Model->get_jenis_usaha_by_kecamatan($user_kecamatan);
        echo json_encode($data);
    }

    public function get_by_periode() {
        $tahun = $this->input->post('tahun');
        $kecamatan = $this->session->userdata('kecamatan');
        
        if (!$tahun) {
            $tahun = date('Y');
        } 
        
        $data = $this->P_Input_Jenis_Usaha_Model->get_by_periode($tahun, $kecamatan);
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
?>