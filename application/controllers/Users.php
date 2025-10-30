<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model('M_users');
    }

    public function index()
    {
        $data = array(
            'judul' => "Petty Cash | Users",
            'rowusers' => $this->M_users->get()
        );

        $this->template->load('template', 'users', $data);
    }

    public function tambahusers()
    {
        $nama_user          = $this->input->post('namalengkapuser');
        $email_user         = $this->input->post('emailuser');
        $depaterment_user   = $this->input->post('departement_user');
        $sbu_user           = $this->input->post('sbu_user');
        $kantorcabang_user  = $this->input->post('kantorcabang');
        $password_user      = $this->input->post('passworduser');
        $level_user         = $this->input->post('leveluser');

        $data = array(
            'nama_user'     => $nama_user,
            'email_user'    => $email_user,
            'sbu'           => $depaterment_user,
            'sbu_unit'      => $sbu_user,
            'address_user'  => $kantorcabang_user,
            'password_user' => sha1($password_user),
            'level'         => $level_user,
            'profile_user'  => 'default.png',
        );


        $this->M_users->addUser('tb_users', $data);
        if ($this->db->affected_rows()) {
            $this->session->set_flashdata('alert_message', 'User Berhasil Ditambahkan');
            redirect('users');
        } else {
            $this->session->set_flashdata('alert_message', 'User Gagal Ditambahkan');
            redirect('users');
        }
    }

    public function editaksesuser()
    {
        $iduser = $this->input->post('editUserIdakses');
        $kantorcabang = $this->input->post('kantorcabanguser');
        $level = $this->input->post('editleveluser');

        $data = array(
            'address_user' => $kantorcabang,
            'level' => $level,
        );
        $this->M_users->Edituserakses($iduser, $data, 'tb_users');

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Akses user berhasil diubah.');
        } else {
            $this->session->set_flashdata('error', 'Tidak ada perubahan data atau gagal mengubah akses.');
        }

        redirect('users');
    }

    public function editpassworduser()
    {
        $iduser = $this->input->post('editUserId');
        $passworduser = $this->input->post('newPassword');

        // Edit data kapal dari table tb_user
        $data = array(
            'password_user' => sha1($passworduser),
        );

        $this->M_users->Edituser($iduser, $data, 'tb_users');
        if ($this->db->affected_rows()) {
            $this->session->set_flashdata('success', 'Data User Berhasil Diubah');
            redirect('users');
        } else {
            $this->session->set_flashdata('error', 'Data User Gagal Diubah');
            redirect('users');
        }
    }

    public function delete($id)
    {
        $this->M_users->deleteUser($id);
        $this->session->set_flashdata('success', 'User berhasil dihapus');
        redirect('users');
    }
}