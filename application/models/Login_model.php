<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Login_model extends CI_Model { 
	
	function __construct()
    {
        parent::__construct();
    }

    function loginFunctionForAllUsers (){
        
        $email = html_escape($this->input->post('email'));			
        $password = html_escape($this->input->post('password'));	
        $credential = array('email' => $email, 'password' => sha1($password));	
  
        // DEBUG: Mostrar credenciales recibidas
        log_message('error', 'DEBUG LOGIN: Email: ' . $email . ' | Password: ' . $password);

        // Admin
        $query = $this->db->get_where('admin', $credential);
        log_message('error', 'DEBUG LOGIN: Consulta admin, filas: ' . $query->num_rows());
        if ($query->num_rows() > 0) {
            $row = $query->row();
  
            $this->session->set_userdata('login_type', 'admin');
            $this->session->set_userdata('admin_login', '1');
            $this->session->set_userdata('admin_id', $row->admin_id);
            $this->session->set_userdata('login_user_id', $row->admin_id);
            $this->session->set_userdata('name', $row->name);

            return  $this->db->set('login_status', ('1'))
                    ->where('admin_id', $this->session->userdata('admin_id'))
                    ->update('admin');
        }

        // Parent
        $query = $this->db->get_where('parent', $credential);
        log_message('error', 'DEBUG LOGIN: Consulta parent, filas: ' . $query->num_rows());
        if ($query->num_rows() > 0) {
            $row = $query->row();
  
            $this->session->set_userdata('login_type', 'parent');
            $this->session->set_userdata('parent_login', '1');
            $this->session->set_userdata('parent_id', $row->parent_id);
            $this->session->set_userdata('login_user_id', $row->parent_id);
            $this->session->set_userdata('name', $row->name);

            return  $this->db->set('login_status', ('1'))
                    ->where('parent_id', $this->session->userdata('parent_id'))
                    ->update('parent');
        }

        // Student
        $query = $this->db->get_where('student', $credential);
        log_message('error', 'DEBUG LOGIN: Consulta student, filas: ' . $query->num_rows());
        if ($query->num_rows() > 0) {
            $row = $query->row();
  
            $this->session->set_userdata('login_type', 'student');
            $this->session->set_userdata('student_login', '1');
            $this->session->set_userdata('student_id', $row->student_id);
            $this->session->set_userdata('login_user_id', $row->student_id);
            $this->session->set_userdata('name', $row->name);

            return  $this->db->set('login_status', ('1'))
                    ->where('student_id', $this->session->userdata('student_id'))
                    ->update('student');
        }

        // Teacher
        $query = $this->db->get_where('teacher', $credential);
        log_message('error', 'DEBUG LOGIN: Consulta teacher, filas: ' . $query->num_rows());
        if ($query->num_rows() > 0) {
            $row = $query->row();
  
            $this->session->set_userdata('login_type', 'teacher');
            $this->session->set_userdata('teacher_login', '1');
            $this->session->set_userdata('teacher_id', $row->teacher_id);
            $this->session->set_userdata('login_user_id', $row->teacher_id);
            $this->session->set_userdata('name', $row->name);

            return  $this->db->set('login_status', ('1'))
                    ->where('teacher_id', $this->session->userdata('teacher_id'))
                    ->update('teacher');
        }

        // Preceptor
        $query = $this->db->get_where('preceptor', $credential);
        log_message('error', 'DEBUG LOGIN: Consulta preceptor, filas: ' . $query->num_rows());
        if ($query->num_rows() > 0) {
            $row = $query->row();
  
            $this->session->set_userdata('login_type', 'preceptor');
            $this->session->set_userdata('preceptor_login', '1');
            $this->session->set_userdata('preceptor_id', $row->preceptor_id);
            $this->session->set_userdata('login_user_id', $row->preceptor_id);
            $this->session->set_userdata('name', $row->name);

            return  $this->db->set('login_status', ('1'))
                    ->where('preceptor_id', $this->session->userdata('preceptor_id'))
                    ->update('preceptor');
        }
        // Si no hay login válido
        log_message('error', 'DEBUG LOGIN: No se encontró usuario válido para las credenciales.');
        return false;
    }

    function logout_model_for_admin(){
        return  $this->db->set('login_status', ('0'))
                    ->where('admin_id', $this->session->userdata('admin_id'))
                    ->update('admin');
    }

    function logout_model_for_hrm(){
        return  $this->db->set('login_status', ('0'))
                    ->where('hrm_id', $this->session->userdata('hrm_id'))
                    ->update('hrm');
    }

    function logout_model_for_hostel(){
        return  $this->db->set('login_status', ('0'))
                    ->where('hostel_id', $this->session->userdata('hostel_id'))
                    ->update('hostel');
    }

    function logout_model_for_accountant(){
        return  $this->db->set('login_status', ('0'))
                    ->where('accountant_id', $this->session->userdata('accountant_id'))
                    ->update('accountant');
    }

    function logout_model_for_librarian(){
        return  $this->db->set('login_status', ('0'))
                    ->where('librarian_id', $this->session->userdata('librarian_id'))
                    ->update('librarian');
    }

    function logout_model_for_parent(){
        return  $this->db->set('login_status', ('0'))
                    ->where('parent_id', $this->session->userdata('parent_id'))
                    ->update('parent');
    }

    function logout_model_for_teacher(){
        return  $this->db->set('login_status', ('0'))
                    ->where('teacher_id', $this->session->userdata('teacher_id'))
                    ->update('teacher');
    }

    function logout_model_for_student(){
        return  $this->db->set('login_status', ('0'))
                    ->where('student_id', $this->session->userdata('student_id'))
                    ->update('student');
    }

    function logout_model_for_preceptor(){
        return  $this->db->set('login_status', ('0'))
                    ->where('preceptor_id', $this->session->userdata('preceptor_id'))
                    ->update('preceptor');
    }
 
 
 
 

 
 
}
