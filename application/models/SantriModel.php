<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SantriModel extends CI_Model
{
    function baru()
    {
        $this->db->where('ket', 'baru');
        $this->db->from('tb_santri');
        return $this->db->get();
    }

    function lama()
    {
        $this->db->where('ket', 'lama');
        $this->db->from('tb_santri');
        return $this->db->get();
    }

    function santriNis($nis)
    {
        $this->db->where('nis', $nis);
        $this->db->from('tb_santri');
        return $this->db->get();
    }

    function agama()
    {
        $this->db->from('agama');
        return $this->db->get();
    }

    function edit($table, $data, $where)
    {
        $this->db->where('nis', $where);
        $this->db->update($table, $data);
    }

    function pend()
    {
        $this->db->select('*');
        $this->db->from('pend');
        return $this->db->get();
    }

    function pkj()
    {
        $this->db->select('*');
        $this->db->from('pkj');
        return $this->db->get();
    }

    function hasil()
    {
        $this->db->select('*');
        $this->db->from('hasil');
        return $this->db->get();
    }

    function getprov()
    {
        $this->db->order_by('nama', 'ASC');
        return $this->db->from('provinsi')->get()->result();
    }

    function getKab($id_provinsi)
    {
        $this->db->where('id_prov', $id_provinsi);
        $this->db->order_by('nama', 'ASC');
        return $this->db->from('kabupaten')->get()->result();
    }
    function getKec($id_kab)
    {
        $this->db->where('id_kab', $id_kab);
        $this->db->order_by('nama', 'ASC');
        return $this->db->from('kecamatan')->get()->result();
    }
    function getKel($id_kec)
    {
        $this->db->where('id_kec', $id_kec);
        $this->db->order_by('nama', 'ASC');
        return $this->db->from('kelurahan')->get()->result();
    }

    function getSkl($npsn)
    {
        $this->db->where('npsn', $npsn);
        $this->db->from('sekolah');
        return $this->db->get()->row();
    }

    function baruLmb($lmb)
    {
        $this->db->where('lembaga', $lmb);
        $this->db->where('ket', 'baru');
        $this->db->from('tb_santri');
        return $this->db->get();
    }

    function apikey()
    {
        $this->db->select('*');
        $this->db->from('api');
        return $this->db->get();
    }
}