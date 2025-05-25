<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alumno extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role') != 'Alumno') {
            redirect('login');
        }
        $this->load->model('Alumno_model');
    }
    public function dashboard() {
        $user_id = $this->session->userdata('user_id');
        $data['notas'] = $this->Alumno_model->get_notas($user_id);
        $data['asistencia'] = $this->Alumno_model->get_asistencia($user_id);
        $this->load->view('backend/alumno_dashboard', $data);
    }
}
