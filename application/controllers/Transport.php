<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transport extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('TransModel', 'model');
        $this->load->model('Auth_model');

        $user = $this->Auth_model->current_user();
        if (!$this->Auth_model->current_user()) {
            redirect('login/logout');
        } elseif ($user->level != 'account') {
            echo "
            <script>
            alert('Maaf. Data tidak dapat megakses halaman ini');
            window.location = '" . base_url('welcome') . "';
            </script>
            ";
        }
    }

    public function index()
    {
        $data['judul'] = 'transport';
        $data['data'] = $this->model->data()->result();
        $data['user'] = $this->Auth_model->current_user();

        $this->load->view('head', $data);
        $this->load->view('trans', $data);
        $this->load->view('foot');
    }

    public function add()
    {
        $data1 = $this->db->query("SELECT max(substring(kode_transport, 6)) as maxKode FROM transport ")->row();
        $kodeBarang = $data1->maxKode == null ? '0000' : $data1->maxKode;
        $noUrut = (int) substr($kodeBarang, 0, 4);
        $noUrut++;
        $char = "TRANS";
        $kodeBarang = $char . sprintf("%04s", $noUrut);
        $kode = htmlspecialchars($kodeBarang);

        $data = [
            'kode_transport' => $kode,
            'daerah' => $this->input->post('daerah', true),
            'nominal' => rmRp($this->input->post('nominal', true)),
            'sopir' => rmRp($this->input->post('sopir', true)),
            'tahun' => '2022/2023'
        ];

        $this->model->simpan('transport', $data);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Data Berhasil Ditambahkan');
            redirect('transport');
        } else {
            $this->session->set_flashdata('error', 'Tambah Data Gagal');
            redirect('transport');
        }
    }

    public function edit()
    {
        $where = $this->input->post('kode_transport', true);
        $data = [
            'daerah' => $this->input->post('daerah', true),
            'nominal' => rmRp($this->input->post('nominal', true)),
            'sopir' => rmRp($this->input->post('sopir', true))
        ];

        $this->model->edit('transport', $data, $where);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Update Data Berhasil ');
            redirect('transport');
        } else {
            $this->session->set_flashdata('error', 'Edit Data Gagal');
            redirect('transport');
        }
    }

    public function del($kode)
    {
        $this->model->hapus('transport', $kode);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Hapus Data Berhasil ');
            redirect('transport');
        } else {
            $this->session->set_flashdata('error', 'Hapus Data Gagal');
            redirect('transport');
        }
    }
}