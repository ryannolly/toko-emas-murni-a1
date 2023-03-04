<?php

class Login extends CI_Controller {
    function GagalLogin($PesanGagal){
        $this->session->set_flashdata('pesan','<div style="color:#000" class="alert alert-danger alert-dismissible" role="alert">
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
            if($this->form_validation->run() == false){
                $this->load->view('login');
            }else{
                $auth = $this->model_auth->cek_login_admin();

                if(empty($auth)){
                    $this->GagalLogin("Username tersebut tidak terdaftar pada sistem!");
                }

				$password = $this->input->post('password');
                
                if($auth->password !== $password){
                    $this->GagalLogin("Password yang anda masukkan salah!");
                }else{
                    $this->session->set_userdata("id", $auth->id);
                    $this->session->set_userdata("username", $auth->username);
                    $this->session->set_userdata("password", $auth->password);
                    $this->session->set_userdata("role_user", "0");
                    $this->session->set_userdata("GroupAdminID", $auth->GroupAdminID);
                    $this->session->set_userdata("barang_kasir", array());
                    redirect("adm/dashboard/");
                }
            }
        }else{
            if($this->session->userdata("role_user") == "0"){
                redirect("adm/dashboard/");
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