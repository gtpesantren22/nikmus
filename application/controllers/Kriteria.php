<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kriteria extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('KritModel', 'model');
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

        $this->tahun = '2023/2024';
    }

    public function index()
    {
        $data['judul'] = 'kriteria';
        $data['data'] = $this->model->data()->result();
        $data['user'] = $this->Auth_model->current_user();
        $data['tahun'] = $this->tahun;

        $this->load->view('head', $data);
        $this->load->view('krit', $data);
        $this->load->view('foot');
    }

    public function add()
    {
        $data1 = $this->db->query("SELECT max(substring(kode_kriteria, 6)) as maxKode FROM kriteria ")->row();
        $kodeBarang = $data1->maxKode == null ? '0000' : $data1->maxKode;
        $noUrut = (int) substr($kodeBarang, 0, 4);
        $noUrut++;
        $char = "KRT";
        $kodeBarang = $char . sprintf("%04s", $noUrut);
        $kode = htmlspecialchars($kodeBarang);

        $data = [
            'kode_kriteria' => $kode,
            'status' => $this->input->post('status', true),
            'ybs' => $this->input->post('ybs', true),
            'jenis' => $this->input->post('jenis', true),
            'nominal' => rmRp($this->input->post('nominal', true)),
            'tahun' => $this->tahun
        ];

        $this->model->simpan('kriteria', $data);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Data Berhasil Ditambahkan');
            redirect('kriteria');
        } else {
            $this->session->set_flashdata('error', 'Tambah Data Gagal');
            redirect('kriteria');
        }
    }

    public function edit()
    {
        $where = $this->input->post('kode_kriteria', true);
        $data = [
            'nama' => $this->input->post('nama', true),
            'nominal' => rmRp($this->input->post('nominal', true))
        ];

        $this->model->edit('kriteria', $data, $where);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Update Data Berhasil ');
            redirect('kriteria');
        } else {
            $this->session->set_flashdata('error', 'Edit Data Gagal');
            redirect('kriteria');
        }
    }

    public function del($kode)
    {
        $this->model->hapus('kriteria', $kode);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Hapus Data Berhasil ');
            redirect('kriteria');
        } else {
            $this->session->set_flashdata('error', 'Hapus Data Gagal');
            redirect('kriteria');
        }
    }
}
