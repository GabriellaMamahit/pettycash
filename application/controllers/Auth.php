<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function login()
    {
        check_already_login();
        $this->load->view('login');
    }

    // public function process()
    // {
    //     $post = $this->input->post(null, TRUE);
    //     if (isset($post['login'])) {
    //         $this->load->model('M_users');
    //         $query = $this->M_users->login($post);
    //         if ($query->num_rows() > 0) {
    //             $row = $query->row();
    //             $params = array(
    //                 'id_user' => $row->id_user,
    //                 'level' => $row->level,
    //                 'address_user' => $row->address_user
    //             );
    //             $this->session->set_userdata($params);

    //             $allowed_admin = ['super_admin', 'direktur_finance', 'development', 'finance_bmg', 'finance_bdp', 'finance_bsgroup'];

    //             // logika redirect
    //             if ($row->level == 'user') {
    //                 $address = strtolower($row->address_user); // biar aman
    //                 switch ($address) {
    //                     case 'jakarta':
    //                         $redirect_url = site_url('Dashboard_cab/dashboard_jkt');
    //                         break;
    //                     case 'balikpapan':
    //                         $redirect_url = site_url('Dashboard_cab/dashboard_balikpapan');
    //                         break;
    //                     case 'karimun':
    //                         $redirect_url = site_url('Dashboard_cab/dashboard_karimun');
    //                         break;
    //                     case 'galang':
    //                         $redirect_url = site_url('Dashboard_cab/dashboard_galang');
    //                         break;
    //                     case 'sekupang':
    //                         $redirect_url = site_url('Dashboard_cab/dashboard_sekupang_bbm');
    //                         break;
    //                     default:
    //                         $redirect_url = site_url('dashboard'); // fallback
    //                         break;
    //                 }
    //             }
    //             // else {
    //             //     // role selain user masuk ke dashboard utama
    //             //     $redirect_url = site_url('dashboard');
    //             // }
    //             elseif (in_array($row->level, $allowed_admin)) {
    //                 // level admin/finance tertentu masuk ke dashboard utama
    //                 $redirect_url = site_url('dashboard');
    //             } else {
    //                 // level lain tidak boleh login, logout langsung
    //                 $this->session->sess_destroy();
    //                 $this->session->set_flashdata('error', 'Anda tidak memiliki akses.');
    //                 redirect('auth/login');
    //                 return; // hentikan eksekusi lebih lanjut
    //             }

    //             redirect($redirect_url);
    //         } else {
    //             // hanya simpan error
    //             $this->session->set_flashdata('error', 'Login gagal, email atau password salah');
    //             redirect('auth/login');
    //         }
    //     }
    // }

    public function process()
    {
        $post = $this->input->post(null, TRUE);
        if (isset($post['login'])) {
            $this->load->model('M_users');
            $query = $this->M_users->login($post);

            if ($query->num_rows() > 0) {
                $row = $query->row();

                // Level admin/finance yang diperbolehkan akses dashboard utama
                $allowed_admin = ['super_admin', 'direktur_finance', 'development', 'finance_bmg', 'finance_bdp', 'finance_bsgroup'];

                // Tentukan redirect URL dan validasi akses
                if ($row->level == 'user') {
                    // user diarahkan ke dashboard cabang
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
                            // default:
                            //     $redirect_url = site_url('dashboard'); // fallback
                            //     break;
                    }
                } elseif (in_array($row->level, $allowed_admin)) {
                    // level admin/finance tertentu masuk ke dashboard utama
                    $redirect_url = site_url('dashboard');
                } else {
                    // level lain tidak boleh login
                    // $this->session->sess_destroy();
                    $this->session->set_flashdata('error', 'Anda tidak memiliki akses.');
                    redirect('auth/login');
                    return; // hentikan eksekusi
                }

                // Set session hanya jika login valid
                $this->session->set_userdata([
                    'id_user' => $row->id_user,
                    'level' => $row->level,
                    'address_user' => $row->address_user
                ]);

                redirect($redirect_url);
            } else {
                // login gagal
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

    // public function process()
    // {
    //     $post = $this->input->post(null, TRUE);
    //     if (isset($post['login'])) {
    //         $this->load->model('M_users');
    //         $query = $this->M_users->login($post);
    //         if ($query->num_rows() > 0) {
    //             $row = $query->row();
    //             $params = array(
    //                 'id_user' => $row->id_user,
    //                 'level' => $row->level,
    //                 'address_user' => $row->address_user
    //             );
    //             $this->session->set_userdata($params);
    //             echo "<script>
    //                     alert('Selamat, login berhasil');
    //                     window.location='" . site_url('dashboard') . "';
    //                 </script>";
    //         } else {
    //             echo "<script>
    //                     alert('login gagal');
    //                     window.location='" . site_url('auth/login') . "';
    //                 </script>";
    //         }
    //     }
    // }

    // public function logout()
    // {
    //     $params = array('id_user', 'level', 'address_user');
    //     $this->session->unset_userdata($params);
    //     redirect('auth/login');
    // }
}