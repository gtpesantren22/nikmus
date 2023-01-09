<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Verval extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('PengajuanModel', 'model');
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
		$data['judul'] = 'verval';
		$data['data'] = $this->model->verval()->result();
		$data['user'] = $this->Auth_model->current_user();

		$this->load->view('head', $data);
		$this->load->view('verval', $data);
		$this->load->view('foot');
	}

	public function setujui($kode)
	{
		$data['judul'] = 'verval';
		$data['data'] = $this->model->getBy('pengajuan', 'kode_pengajuan', $kode)->row();
		$data['user'] = $this->Auth_model->current_user();

		$this->load->view('head', $data);
		$this->load->view('verval_edit', $data);
		$this->load->view('foot');
	}

	public function setujui_add()
	{
		$kode = $this->input->post('kode_pengajuan', true);
		$data = [
			'nom_kriteria' => rmRp($this->input->post('nom_kriteria', true)),
			'transport' => rmRp($this->input->post('transport', true)),
			'sopir' => rmRp($this->input->post('sopir', true)),
			'status' => 'disetujui'
		];
		$data4 = [
			'kode_pengajuan' => $kode,
			'status' => 'Pengajuan',
			'ket' => 'Pengajuan disetujui oleh Accounting',
			'oleh' => 'Accounting',
			'at' => date('Y-m-d H:i')
		];
		$key = $this->model->getBy('api', 'nama', 'Bendahara')->row();
		$dtpj = $this->model->getBy('pengajuan', 'kode_pengajuan', $kode)->row();
		$pesan = '*INFORMASI PERSETUJUAN NIKMUS*
Pengajuan Baru 

Kode : ' . $dtpj->kode_pengajuan . '
Nama : ' . $dtpj->nama . '
Kriteria : ' . $dtpj->kriteria . '
Daerah : ' . $dtpj->daerah . '
Nominal : ' . rupiah($dtpj->nom_kriteria + $dtpj->sopir + $dtpj->transport) . '

Selanjutnya Silahkan menghubungi Admin Pencairan. 
Terimakasih';
		$this->model->simpan('history', $data4);
		$this->model->edit('pengajuan', $data, $kode);
		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('ok', 'Pengajuan Disetujui. Silahkan menghubungi admin pencairan untuk pencairan pengajuan!');
			kirim_person($key->nama_key, '085234223306', $pesan);
			kirim_person($key->nama_key, '082338631044', $pesan);
			// kirim_person($key->nama_key, '085236924510', $pesan);
			redirect('verval');
		} else {
			$this->session->set_flashdata('error', 'Persetujuan Data Gagal');
			redirect('verval');
		}
	}

	public function tolak()
	{
		$kode = $this->input->post('kode', true);
		$data = ['status' => 'ditolak'];
		$data4 = [
			'kode_pengajuan' => $kode,
			'status' => 'Pengajuan',
			'ket' => 'Pengajuan ditolak oleh Accounting dengan catatan : ',
			'oleh' => 'Accounting',
			'at' => date('Y-m-d H:i')
		];
		$key = $this->model->getBy('api', 'nama', 'Bendahara')->row();
		$dtpj = $this->model->getBy('pengajuan', 'kode_pengajuan', $kode)->row();
		$pesan = '*INFORMASI PENOLAKAN PENGAJUAN NIKMUS*
Pengajuan Baru 

Kode : ' . $dtpj->kode_pengajuan . '
Nama : ' . $dtpj->nama . '
Kriteria : ' . $dtpj->kriteria . '
Daerah : ' . $dtpj->daerah . '

Pengajuan ditolak dengan catatan :
*' . $this->input->post('catatan', true) . '*
Terimakasih';
		$this->model->simpan('history', $data4);
		$this->model->edit('pengajuan', $data, $kode);
		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('ok', 'Pengajuan Ditolak');
			// kirim_person($key->nama_key, '085236924510', $pesan);
			kirim_person($key->nama_key, '085234223306', $pesan);
			redirect('verval');
		} else {
			$this->session->set_flashdata('error', 'Persetujuan Data Gagal');
			redirect('verval');
		}
	}
}