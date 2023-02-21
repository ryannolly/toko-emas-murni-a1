<?php 

class Model_auth extends CI_Model {
    public function cek_login_admin(){
        $email = set_value('email');

        $result = $this->db->where('email', $email)
                           ->limit(1)
                           ->get('ms_user');
        if($result->num_rows() > 0){
            return $result->row();
        }else{
            return array();
        }
    }

    public function cek_login_dosen(){
        $nidn   = set_value('email');

        $result = $this->db->where("NIDN", $nidn)
                           ->limit(1)
                           ->get('ms_data_dosen');
        
        if($result->num_rows() > 0){
            return $result->row();
        }else{
            return array();
        }
    }
}

?>