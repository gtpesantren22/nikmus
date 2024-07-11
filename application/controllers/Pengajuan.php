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
        $data['user'] = $this->Auth_model->current_user();
        $data['data'] = $this->model->data($this->tahun, $data['user']->lembaga)->result();
        $data['tahun'] = $this->tahun;

        $this->load->view('head', $data);
        $this->load->view('pengajuan', $data);
        $this->load->view('foot');
    }

    public function add()
    {
        $data['user'] = $this->Auth_model->current_user();
        $lm = $data['user']->lembaga;
        $cek = $this->db->query("SELECT spj.kode_pengajuan FROM spj JOIN pengajuan ON spj.kode_pengajuan=pengajuan.kode_pengajuan WHERE pengajuan.lembaga = '$lm' AND spj.status != 'selesai' ")->num_rows();
        if ($cek > 0) {
            $this->session->set_flashdata('error', 'Maaf. Ada SPJ yang belum selesai');
            redirect('pengajuan');
        }
        $data['judul'] = 'data';
        $data['krit'] = $this->model->krit()->result();
        $data['daerah'] = $this->model->daerah()->result();
        $data['tahun'] = $this->tahun;
        $data['jenis'] = $this->model->getByGroup('kriteria', 'tahun', $this->tahun, 'jenis')->result();

        $this->load->view('head', $data);
        $this->load->view('pengajuan_add', $data);
        $this->load->view('foot');
    }

    public function getKrit()
    {
        $jenis = $this->input->post('jenis', true);
        $data = $this->model->getBy2('kriteria', 'tahun', $this->tahun, 'jenis', $jenis)->result();

        foreach ($data as $hasil) {
            echo '<div class="radio"><label><input type="radio" name="kodeKrit" value="' . $hasil->kode_kriteria . '"><span class="label label-success">'  . $hasil->status . '</span><br><span class="label label-warning">'  . $hasil->jenis . '</span>|<span class="label label-danger">'  . $hasil->ybs . '</span></label></div>';
            // echo 'jhasil';
        }
        // echo json_encode($data);
    }

    public function edit($kode)
    {
        $data['judul'] = 'pengajuan';
        $data['data'] = $this->model->getBy('pengajuan', 'kode_pengajuan', $kode)->row();
        $data['krit'] = $this->model->krit()->result();
        $data['daerah'] = $this->model->daerah()->result();
        $data['user'] = $this->Auth_model->current_user();
        $data['tahun'] = $this->tahun;
        $data['jenis'] = $this->model->getByGroup('kriteria', 'tahun', $this->tahun, 'jenis')->result();
        $data['kritPilih'] = $this->model->getBy('kriteria', 'kode_kriteria', $data['data']->kode_kriteria)->row();

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

        $transport = $this->model->getBy('transport', 'kode_transport', $this->input->post('daerah', true))->row();
        $kriteria = $this->model->getBy('kriteria', 'kode_kriteria', $this->input->post('kodeKrit', true))->row();

        $data = [
            'kode_pengajuan' => $kode,
            'nama' => $this->input->post('nama', true),
            'kriteria' => $this->input->post('kriteria', true),
            'kode_kriteria' => $kriteria->kode_kriteria,
            'nom_kriteria' => $kriteria->nominal,
            'daerah' => $this->input->post('daerah', true),
            'transport' => $transport->nominal,
            'sopir' => $transport->sopir,
            'tgl_jalan' => $this->input->post('tgl_jalan', true),
            'tahun' => $this->tahun,
            'status' => 'belum',
            'lembaga' => $this->input->post('lembaga', true),
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
        // $kriteria = $this->model->getBy('kriteria', 'kode_kriteria', $this->input->post('kriteria', true))->row();

        if ($this->input->post('kodeKrit', true)) {
            $kriteria = $this->model->getBy('kriteria', 'kode_kriteria', $this->input->post('kodeKrit', true))->row();
            $data = [
                'nama' => $this->input->post('nama', true),
                'kriteria' => $this->input->post('kriteria', true),
                'kode_kriteria' => $kriteria->kode_kriteria,
                'nom_kriteria' => $kriteria->nominal,
                'daerah' => $transport->daerah,
                'transport' => $transport->nominal,
                'sopir' => $transport->sopir,
                'tgl_jalan' => $this->input->post('tgl_jalan', true)
            ];
        } else {
            $data = [
                'kriteria' => $this->input->post('kriteria', true),
                'nama' => $this->input->post('nama', true),
                'daerah' => $transport->daerah,
                'transport' => $transport->nominal,
                'sopir' => $transport->sopir,
                'tgl_jalan' => $this->input->post('tgl_jalan', true)
            ];
        }

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
        $drh = $this->model->getBy('transport', 'kode_transport', $dtpj->daerah)->row();
        $pesan = '*INFORMASI PENGAJUAN NIKMUS*
Pengajuan Baru 

Kode : ' . $dtpj->kode_pengajuan . '
Nama : ' . $dtpj->nama . '
Lembaga : ' . $dtpj->lembaga . '
Ket : ' . $dtpj->kriteria . '
Daerah : ' . $drh->daerah . '

Dimohon kepada Humas Pesantren untuk segera mengeceknya
Terimakasih';

        $this->model->edit('pengajuan', $data, $kode);
        $this->model->simpan('history', $data4);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Pengajuan Berhasil. Silahkan menunggu verval dari accounting!');
            kirim_group($key->nama_key, '120363279501347686@g.us', $pesan);
            kirim_person($key->nama_key, '085236924510', $pesan);
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
