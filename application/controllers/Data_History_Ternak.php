<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_history_ternak extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Data_history_ternak_model');
        $this->load->database();
        
        if(!$this->session->userdata('logged_in')) {
            redirect('login'); 
        }
    }

    public function index()
    {
        $data['title'] = 'History Data Ternak';
        $this->load->view('admin/data/data_history_ternak', $data);
    }

    public function get_data()
    {
        $data = $this->Data_history_ternak_model->get_all_data();
        
        $result = [];
        $no = 1;
        
        if (!empty($data)) {
            foreach ($data as $row) {
                $result[] = [
                    'id' => $row->id,
                    'no' => $no++,
                    'nama_peternak' => htmlspecialchars($row->nama_peternak ?? '-'),
                    'komoditas' => htmlspecialchars($row->komoditas_ternak ?? '-'),
                    'jumlah_ternak' => number_format($row->jumlah ?? 0, 0, ',', '.') . ' Ekor',
                    'jumlah_ternak_value' => intval($row->jumlah ?? 0),
                    'tanggal_update' => $row->tanggal_input ? date('d-m-Y', strtotime($row->tanggal_input)) : '-',
                    'raw_latitude' => floatval($row->latitude ?? 0),
                    'raw_longitude' => floatval($row->longitude ?? 0),
                    'kecamatan' => htmlspecialchars($row->kecamatan ?? ''),
                    'kelurahan' => htmlspecialchars($row->kelurahan ?? ''),
                    'alamat' => htmlspecialchars($row->alamat ?? ''),
                    'telepon' => htmlspecialchars($row->telepon ?? ''),
                    'rt' => htmlspecialchars($row->rt ?? ''),
                    'rw' => htmlspecialchars($row->rw ?? ''),
                    'nama_petugas' => htmlspecialchars($row->nama_petugas ?? ''),
                ];
            }
        }
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $result]));
    }
    
    public function get_detail($id)
    {
        if (!$id || $id == 0) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'ID tidak valid']));
            return;
        }
        
        $data = $this->Data_history_ternak_model->get_detail_by_id($id);
        
        if ($data) {
            $result = [
                'success' => true,
                'data' => [[
                    'id' => $data->id,
                    'nama_peternak' => $data->nama_peternak ?? '',
                    'komoditas' => $data->komoditas_ternak ?? '',
                    'jumlah' => $data->jumlah ?? 0,
                    'kecamatan' => $data->kecamatan ?? '',
                    'kelurahan' => $data->kelurahan ?? '',
                    'alamat' => $data->alamat ?? '',
                    'rt' => $data->rt ?? '',
                    'rw' => $data->rw ?? '',
                    'latitude' => $data->latitude ?? '',
                    'longitude' => $data->longitude ?? '',
                    'telepon' => $data->telepon ?? '',
                    'nama_petugas' => $data->nama_petugas ?? '',
                    'tanggal_input' => $data->tanggal_input ?? ''
                ]]
            ];
        } else {
            $result = ['success' => false, 'message' => 'Data tidak ditemukan'];
        }
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }
    
    public function update($id)
    {
        $data = array(
            'nama_peternak' => $this->input->post('nama_peternak'),
            'komoditas_ternak' => $this->input->post('komoditas'),
            'jumlah' => $this->input->post('jumlah'),
            'kecamatan' => $this->input->post('kecamatan'),
            'kelurahan' => $this->input->post('kelurahan'),
            'alamat' => $this->input->post('alamat'),
            'rt' => $this->input->post('rt'),
            'rw' => $this->input->post('rw'),
            'latitude' => $this->input->post('latitude'),
            'longitude' => $this->input->post('longitude'),
            'telepon' => $this->input->post('telepon'),
            'nama_petugas' => $this->input->post('nama_petugas'),
            'tanggal_input' => $this->input->post('tanggal_input')
        );
        
        $result = $this->Data_history_ternak_model->update_data($id, $data);
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([ 
                'success' => $result,
                'message' => $result ? 'Data berhasil diupdate' : 'Gagal mengupdate data'
            ]));
    }
    
    public function delete($id)
    {
        $result = $this->Data_history_ternak_model->delete_data($id);
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['success' => $result]));
    }
}
?>  