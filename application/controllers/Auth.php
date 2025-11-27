<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function login()
    {
        check_already_login();
        $this->load->view('login');
    }

    public function process()
    {
        $post = $this->input->post(null, TRUE);
        if (isset($post['login'])) {
            $this->load->model('M_users');
            $query = $this->M_users->login($post);

            if ($query->num_rows() > 0) {
                $row = $query->row();

                $allowed_admin = ['super_admin', 'direktur_finance', 'development', 'finance_bmg', 'finance_bdp', 'finance_bsgroup'];

                if ($row->level == 'user') {
                    $address = strtolower($row->address_user);
                    switch ($address) {
                        case 'jakarta':
                            $redirect_url = site_url('Dashboard_cab/dashboard_jkt');
                            break;
                        case 'balikpapan':
                            $redirect_url = site_url('Dashboard_cab/dashboard_balikpapan');
                            break;
                        case 'karimun':
                            $redirect_url = site_url('Dashboard_cab/dashboard_karimun');
                            break;
                        case 'galang':
                            $redirect_url = site_url('Dashboard_cab/dashboard_galang');
                            break;
                        case 'sekupang':
                            $redirect_url = site_url('Dashboard_cab/dashboard_sekupang_bbm');
                            break;
                    }
                } elseif (in_array($row->level, $allowed_admin)) {
                    $redirect_url = site_url('dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Anda tidak memiliki akses.');
                    redirect('auth/login');
                    return;
                }

                $this->session->set_userdata([
                    'id_user' => $row->id_user,
                    'level' => $row->level,
                    'address_user' => $row->address_user
                ]);

                redirect($redirect_url);
            } else {
                $this->session->set_flashdata('error', 'Login gagal, email atau password salah');
                redirect('auth/login');
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}