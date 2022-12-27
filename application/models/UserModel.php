<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends CI_Model
{
    function data()
    {
        return $this->db->get('user');
    }

    function simpan($table, $data)
    {
        $this->db->insert($table, $data);
    }

    function apikey()
    {
        $this->db->select('*');
        $this->db->from('api');
        return $this->db->get();
    }

    function edit($table, $data, $where)
    {
        $this->db->where('id_user', $where);
        $this->db->update($table, $data);
    }

    function hapus($table, $where)
    {
        $this->db->where('id_user', $where);
        $this->db->delete($table);
    }
}