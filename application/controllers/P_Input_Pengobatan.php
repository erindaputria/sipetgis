<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_input_pengobatan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->library('upload');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url', 'file'));
        
        if (!$this->session->userdata('logged_in')) { 
            redirect('login');
        } 
        
        $this->load->model('P_input_pengobatan_model');
    }

    public function index() {
        $user_kecamatan = $this->session->userdata('kecamatan');
        $data['pengobatan_data'] = $this->P_input_pengobatan_model->get_pengobatan_by_kecamatan($user_kecamatan);
        $data['kel_list'] = $this->get_all_kelurahan();
        $data['user_kecamatan'] = $user_kecamatan;
        
        $this->load->view('petugas/p_input_pengobatan', $data);
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
        $this->form_validation->set_rules('nama_peternak', 'Nama Peternak', 'required|trim');
        $this->form_validation->set_rules('nama_petugas', 'Nama Petugas', 'required|trim');
        $this->form_validation->set_rules('tanggal_pengobatan', 'Tanggal Pengobatan', 'required');
        $this->form_validation->set_rules('bantuan_prov', 'Bantuan Provinsi', 'required|trim');
        $this->form_validation->set_rules('kelurahan', 'Kelurahan', 'required|trim');
        $this->form_validation->set_rules('latitude', 'Latitude', 'required|trim');
        $this->form_validation->set_rules('longitude', 'Longitude', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status' => 'error',
                'message' => validation_errors()
            );
            echo json_encode($response);
            return;
        }

        // Validasi array data (multiple komoditas)
        $komoditas = $this->input->post('komoditas_ternak');
        $gejala_klinis = $this->input->post('gejala_klinis');
        $jenis = $this->input->post('jenis_pengobatan');
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
                    'message' => 'Komoditas ternak baris ke-' . ($index + 1) . ' harus diisi'
                );
                echo json_encode($response);
                return;
            }
            
            if (empty($gejala_klinis[$index])) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Gejala klinis/diagnosa baris ke-' . ($index + 1) . ' harus diisi'
                );
                echo json_encode($response);
                return;
            }
             
            if (empty($jenis[$index])) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Jenis pengobatan baris ke-' . ($index + 1) . ' harus dipilih'
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

        // MULTIPLE FILE UPLOAD - MANUAL METHOD (tanpa library upload)
        $uploaded_files = array();
        $upload_path = './uploads/pengobatan/';
        
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
        }
        
        // Cek apakah ada file yang diupload
        if (isset($_FILES['foto_pengobatan']) && !empty($_FILES['foto_pengobatan']['name'][0])) {
            $files = $_FILES['foto_pengobatan'];
            $file_count = count($files['name']);
            
            // Batasi maksimal 5 file
            $file_count = min($file_count, 5);
            
            for ($i = 0; $i < $file_count; $i++) {
                if ($files['error'][$i] == 0) {
                    $file_name = $files['name'][$i];
                    $file_tmp = $files['tmp_name'][$i];
                    $file_size = $files['size'][$i];
                    $file_type = $files['type'][$i];
                    
                    // Validasi tipe file
                    $allowed_types = array('image/jpeg', 'image/jpg', 'image/png');
                    if (!in_array($file_type, $allowed_types)) {
                        $response = array(
                            'status' => 'error',
                            'message' => 'File ' . $file_name . ' harus format JPG atau PNG'
                        );
                        echo json_encode($response);
                        return;
                    }
                    
                    // Validasi ukuran file (max 5MB)
                    if ($file_size > 5 * 1024 * 1024) {
                        $response = array(
                            'status' => 'error',
                            'message' => 'File ' . $file_name . ' melebihi 5MB'
                        );
                        echo json_encode($response);
                        return;
                    }
                    
                    // Generate nama file unik
                    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                    $new_name = time() . '_' . uniqid() . '.' . $ext;
                    $destination = $upload_path . $new_name;
                    
                    // Upload file
                    if (move_uploaded_file($file_tmp, $destination)) {
                        $uploaded_files[] = $new_name;
                    } else {
                        $response = array(
                            'status' => 'error',
                            'message' => 'Gagal upload file: ' . $file_name
                        );
                        echo json_encode($response);
                        return;
                    }
                } else if ($files['error'][$i] != 4) {
                    $response = array(
                        'status' => 'error',
                        'message' => 'Error pada file: ' . $files['name'][$i]
                    );
                    echo json_encode($response);
                    return;
                }
            }
        }
        
        // Konversi array foto ke string (comma separated)
        $foto_string = !empty($uploaded_files) ? implode(',', $uploaded_files) : null;

        // Siapkan data dasar
        $nik_val = $this->input->post('nik');
        $telp_val = $this->input->post('telp');
        $keterangan_val = $this->input->post('keterangan');
        $alamat_val = $this->input->post('alamat');
        $rt_val = $this->input->post('rt');
        $rw_val = $this->input->post('rw');
        
        $base_data = array(
            'nama_petugas' => $this->input->post('nama_petugas'),
            'nama_peternak' => $this->input->post('nama_peternak'),
            'nik' => (!empty($nik_val)) ? $nik_val : NULL,
            'tanggal_pengobatan' => $this->input->post('tanggal_pengobatan'),
            'keterangan' => (!empty($keterangan_val)) ? $keterangan_val : NULL,
            'bantuan_prov' => $this->input->post('bantuan_prov'),
            'kecamatan' => $this->session->userdata('kecamatan'),
            'kelurahan' => $this->input->post('kelurahan'),
            'alamat' => (!empty($alamat_val)) ? $alamat_val : NULL,
            'rt' => (!empty($rt_val)) ? $rt_val : NULL,
            'rw' => (!empty($rw_val)) ? $rw_val : NULL,
            'latitude' => $this->input->post('latitude'),
            'longitude' => $this->input->post('longitude'),
            'telp' => (!empty($telp_val)) ? $telp_val : NULL,
            'foto_pengobatan' => $foto_string
        );

        // Buat array data untuk multiple rows
        $data_array = array();
        
        foreach ($komoditas as $index => $k) {
            $data_row = $base_data;
            $data_row['komoditas_ternak'] = $k;
            $data_row['gejala_klinis'] = $gejala_klinis[$index];
            $data_row['jenis_pengobatan'] = $jenis[$index];
            $data_row['jumlah'] = $jumlah[$index];
            
            $data_array[] = $data_row;
        }

        // Simpan multiple data
        $success_count = $this->P_input_pengobatan_model->save_multiple_pengobatan($data_array);

        if ($success_count > 0) {
            $foto_msg = !empty($uploaded_files) ? count($uploaded_files) . ' foto berhasil diupload' : 'tanpa foto';
            $response = array(
                'status' => 'success',
                'message' => $success_count . ' data pengobatan berhasil disimpan dengan ' . $foto_msg
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Gagal menyimpan data pengobatan. Silakan cek kembali data Anda.'
            );
        }

        echo json_encode($response);
    }

    public function get_all_data() {
        $user_kecamatan = $this->session->userdata('kecamatan');
        $data = $this->P_input_pengobatan_model->get_pengobatan_by_kecamatan($user_kecamatan);
        echo json_encode($data);
    }

    public function get_by_periode() {
        $tahun = $this->input->post('tahun');
        $kecamatan = $this->session->userdata('kecamatan');
        
        if (!$tahun) {
            $tahun = date('Y');
        }
        
        $data = $this->P_input_pengobatan_model->get_by_periode($tahun, $kecamatan);
        
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
        $result = $this->P_input_pengobatan_model->delete_pengobatan($id);
        
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
        
        $cek = $this->P_input_pengobatan_model->cek_nik_exists($nik, $kecamatan);
        
        if ($cek) {
            echo json_encode([
                'status' => 'exists',
                'message' => 'NIK ini sudah pernah digunakan sebanyak ' . $cek . ' kali di kecamatan ini'
            ]);
        } else {
            echo json_encode(['status' => 'new']);
        }
    }
    
    public function cek_telp() {
        $telp = $this->input->post('telp');
        $kecamatan = $this->session->userdata('kecamatan');
        
        if (empty($telp)) {
            echo json_encode(['status' => 'empty']);
            return;
        }
        
        $cek = $this->P_input_pengobatan_model->cek_telp_exists($telp, $kecamatan);
        
        if ($cek) { 
            echo json_encode([
                'status' => 'exists',
                'message' => 'Nomor telepon ini sudah pernah digunakan sebanyak ' . $cek . ' kali di kecamatan ini'
            ]);
        } else {
            echo json_encode(['status' => 'new']);
        }
    }
}
?>