<?php

class Login extends CI_Controller {
    function GagalLogin($PesanGagal){
        $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible" role="alert">
                                                    '.$PesanGagal.'
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>'
        );
        redirect("");
    }

    public function index(){
        if($this->session->userdata('id_user') == null){
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('LoginAs', 'Login As', 'required');
            if($this->form_validation->run() == false){
                $this->load->view('login');
            }else{
                //Ambil dulu dia login sebagai apa?
                $login_as = $this->input->post("LoginAs");
                if($login_as == "Dosen"){
                    $auth = $this->model_auth->cek_login_dosen();
                }else if($login_as == "Reviewer"){
                    $this->GagalLogin("Belum Bisa Kak!");
                }else if($login_as == "Validator"){
                    $this->GagalLogin("Belum Bisa Kak!");
                }else if($login_as == "Admin"){
                    $auth = $this->model_auth->cek_login_admin();
                }

                if(empty($auth)){
                    $this->GagalLogin("NIDN/Username/Email yang anda masukkan tidak terdaftar pada sistem!");
                }

				$password = $this->input->post('password');

                if($login_as == "Dosen"){
                    if($auth->Password !== $password){
                        $this->GagalLogin("Password yang anda masukkan salah!");
                    }else{
                        $this->session->set_userdata("id_user", $auth->Id);
                        $this->session->set_userdata("nama_dosen", $auth->NmDosen);
                        $this->session->set_userdata("NIDN", $auth->NIDN);
                        $this->session->set_userdata("role_user", "1");
                        redirect("dosen");
                    }
                }else if($login_as == "Reviewer"){

                }else if($login_as == "Validator"){

                }else if($login_as == "Admin"){
                    if($auth->password !== $password){
                        $this->GagalLogin("Password yang anda masukkan salah!");
                    }else{
                        $this->session->set_userdata('id_user', $auth->id);
                        $this->session->set_userdata('nama_admin', $auth->nama_admin);
                        $this->session->set_userdata("role_user", "0");
                        redirect("admin");
                    }
                }
            }
        }else{
            if($this->session->userdata("role_user") == "0"){
                redirect("admin");
            }else if($this->session->userdata("role_user") == "1"){
                redirect("dosen");
            }else{
                $userdata = array('id_user', 'nama_admin');
                $this->session->unset_userdata($userdata);
                $this->session->sess_destroy(); //To Actually destroy the session
                $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert">
                                                            Anda telah berhasil keluar!
                                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        </div>'
                            );
                redirect('');
            }
        }
    }

    public function logout(){
        $userdata = array('id_user', 'nama_admin', 'role_user', 'NIDN');
        $this->session->unset_userdata($userdata);
        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert">
                                                    Anda telah berhasil keluar!
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>'
                                    );
        redirect('');
    }
}

?>