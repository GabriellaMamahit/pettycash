<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_users extends CI_Model
{
    public function login($post)
    {
        $this->db->select('*');
        $this->db->from('tb_users');
        $this->db->where('email_user', $post['email']);
        $this->db->where('password_user', sha1($post['password'])); // Tambahkan ini
        return $this->db->get();
    }

    public function get($id = null)
    {
        $this->db->from('tb_users');
        if ($id != null) {
            $this->db->where('id_user', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function addUser($table, $data)
    {
        $insert = $this->db->insert($table, $data);
        return $data;
    }

    public function Edituserakses($iduser, $data, $table)
    {
        $this->db->where('id_user', $iduser);
        $this->db->update($table, $data);
    }

    public function Edituser($iduser, $data, $table)
    {
        $this->db->where('id_user', $iduser);
        $this->db->update($table, $data);
    }

    public function deleteUser($id)
    {
        $this->db->where('id_user', $id);
        $this->db->delete('tb_users');
    }
}