<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengajuan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('PengajuanModel', 'model');
        $this->load->model('Auth_model');
        $this->tahun = $this->session->userdata('tahun');

        $user = $this->Auth_model->current_user();
        if (!$this->Auth_model->current_user()) {
            redirect('login/logout');
        } elseif ($user->level != 'account' && $user->level != 'humas') {
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
        $data['judul'] = 'data';
        $data['data'] = $this->model->data($this->tahun)->result();
        $data['user'] = $this->Auth_model->current_user();
        $data['tahun'] = $this->tahun;

        $this->load->view('head', $data);
        $this->load->view('pengajuan', $data);
        $this->load->view('foot');
    }

    public function add()
    {
        $data['judul'] = 'data';
        $data['krit'] = $this->model->krit()->result();
        $data['daerah'] = $this->model->daerah()->result();
        $data['user'] = $this->Auth_model->current_user();
        $data['tahun'] = $this->tahun;

        $this->load->view('head', $data);
        $this->load->view('pengajuan_add', $data);
        $this->load->view('foot');
    }

    public function edit($kode)
    {
        $data['judul'] = 'pengajuan';
        $data['data'] = $this->model->getBy('pengajuan', 'kode_pengajuan', $kode)->row();
        $data['krit'] = $this->model->krit()->result();
        $data['daerah'] = $this->model->daerah()->result();
        $data['user'] = $this->Auth_model->current_user();
        $data['tahun'] = $this->tahun;

        $this->load->view('head', $data);
        $this->load->view('pengajuan_edit', $data);
        $this->load->view('foot');
    }

    public function saveAdd()
    {
        $data1 = $this->db->query("SELECT max(substring(kode_pengajuan, 6)) as maxKode FROM pengajuan ")->row();
        $kodeBarang = $data1->maxKode == null ? '0000' : $data1->maxKode;
        $noUrut = (int) substr($kodeBarang, 0, 4);
        $noUrut++;
        $char = "NKMS";
        $kodeBarang = $char . sprintf("%04s", $noUrut);
        $kode = htmlspecialchars($kodeBarang);

        // $transport = $this->model->getBy('transport', 'kode_transport', $this->input->post('transport', true))->row();
        // $kriteria = $this->model->getBy('kriteria', 'kode_kriteria', $this->input->post('kriteria', true))->row();

        $data = [
            'kode_pengajuan' => $kode,
            'nama' => $this->input->post('nama', true),
            'kriteria' => $this->input->post('kriteria', true),
            // 'nom_kriteria' => $kriteria->nominal,
            'daerah' => $this->input->post('daerah', true),
            // 'transport' => $transport->nominal,
            // 'sopir' => $transport->sopir,
            'tgl_jalan' => $this->input->post('tgl_jalan', true),
            'tahun' => $this->tahun,
            'status' => 'belum',
            'created' => date('Y-m-d H:i')
        ];
        $data4 = [
            'kode_pengajuan' => $kode,
            'status' => 'Pengajuan',
            'ket' => 'Buat Pengajuan Baru',
            'oleh' => 'Humas Pesantren',
            'at' => date('Y-m-d H:i')
        ];

        $this->model->simpan('pengajuan', $data);
        $this->model->simpan('history', $data4);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Data Berhasil Ditambahkan');
            redirect('pengajuan');
        } else {
            $this->session->set_flashdata('error', 'Tambah Data Gagal');
            redirect('pengajuan');
        }
    }

    public function editAct()
    {
        $where = $this->input->post('kode_pengajuan', true);
        $transport = $this->model->getBy('transport', 'kode_transport', $this->input->post('transport', true))->row();
        $kriteria = $this->model->getBy('kriteria', 'kode_kriteria', $this->input->post('kriteria', true))->row();

        $data = [
            'nama' => $this->input->post('nama', true),
            'kriteria' => $kriteria->nama,
            'nom_kriteria' => $kriteria->nominal,
            'daerah' => $transport->daerah,
            'transport' => $transport->nominal,
            'sopir' => $transport->sopir,
            'tgl_jalan' => $this->input->post('tgl_jalan', true)
        ];

        $this->model->edit('pengajuan', $data, $where);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Data Berhasil Diperbarui');
            redirect('pengajuan');
        } else {
            $this->session->set_flashdata('error', 'Perbaruan Data Gagal');
            redirect('pengajuan');
        }
    }

    public function ajukan($kode)
    {
        $data = ['status' => 'proses'];
        $data4 = [
            'kode_pengajuan' => $kode,
            'status' => 'Pengajuan',
            'ket' => 'Pengajuan Nikmus Diajukan kepada Accounting',
            'oleh' => 'Humas Pesantren',
            'at' => date('Y-m-d H:i')
        ];
        $dtpj = $this->model->getBy('pengajuan', 'kode_pengajuan', $kode)->row();
        $key = $this->model->getBy('api', 'nama', 'Bendahara')->row();
        $pesan = '*INFORMASI PENGAJUAN NIKMUS*
Pengajuan Baru 

Kode : ' . $dtpj->kode_pengajuan . '
Nama : ' . $dtpj->nama . '
Kriteria : ' . $dtpj->kriteria . '
Daerah : ' . $dtpj->daerah . '

Mohon Accounting untuk segera mengeceknya
Terimakasih';

        $this->model->edit('pengajuan', $data, $kode);
        $this->model->simpan('history', $data4);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Pengajuan Berhasil. Silahkan menunggu verval dari accounting!');
            kirim_person($key->nama_key, '082302301003', $pesan);
            // kirim_person($key->nama_key, '085236924510', $pesan);
            redirect('pengajuan');
        } else {
            $this->session->set_flashdata('error', 'Hapus Data Gagal');
            redirect('pengajuan');
        }
    }

    public function del($kode)
    {
        $this->model->hapus('pengajuan', $kode);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Hapus Data Berhasil ');
            redirect('pengajuan');
        } else {
            $this->session->set_flashdata('error', 'Hapus Data Gagal');
            redirect('pengajuan');
        }
    }
}
