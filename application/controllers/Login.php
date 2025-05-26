  <?php if (!defined('BASEPATH'))exit('No direct script access allowed');


  class Login extends CI_Controller {

      function __construct() {
          parent::__construct();

      $this->load->database();
      $this->load->library('session');
      }

      //***************** The function below redirects to logged in user area
      public function index() {

          if ($this->session->userdata('admin_login')== 1) redirect (base_url(). 'admin/dashboard');
          if ($this->session->userdata('hrm_login')== 1) redirect (base_url(). 'hrm/dashboard'); 
          if ($this->session->userdata('hostel_login')== 1) redirect (base_url(). 'hostel/dashboard');
          if ($this->session->userdata('accountant_login')== 1) redirect (base_url(). 'accountant/dashboard');
          if ($this->session->userdata('librarian_login')== 1) redirect (base_url(). 'librarian/dashboard'); 
          if ($this->session->userdata('teacher_login')== 1) redirect (base_url(). 'teacher/dashboard');   
          if ($this->session->userdata('parent_login')== 1) redirect (base_url(). 'parent/dashboard'); 
          if ($this->session->userdata('student_login')== 1) redirect (base_url(). 'student/dashboard');
          if ($this->session->userdata('preceptor_login')== 1) redirect (base_url(). 'preceptor/dashboard');
          $this->load->view('backend/login');
      }
    //***************** / The function below redirects to logged in user area

    //********************************** the function below validating user login request 
      function validate_login() {
        try {
          $login_check_model = $this->login_model->loginFunctionForAllUsers();
          $login_user = $this->session->userdata('login_type');
          if(!$login_check_model){
            $this->session->set_flashdata('error_message', get_phrase('Wrong email or password'));
            redirect(base_url() . 'login', 'refresh');
          }
          if($login_user == 'admin') {
            $this->session->set_flashdata('flash_message', get_phrase('Successfully Login'));
            redirect(base_url() . 'admin/dashboard', 'refresh');
          }
          if($login_user == 'hrm') {
            $this->session->set_flashdata('flash_message', get_phrase('Successfully Login'));
            redirect(base_url() . 'hrm/dashboard', 'refresh');
          }
          if($login_user == 'hostel') {
            $this->session->set_flashdata('flash_message', get_phrase('Successfully Login'));
            redirect(base_url() . 'hostel/dashboard', 'refresh');
          }
          if($login_user == 'accountant') {
            $this->session->set_flashdata('flash_message', get_phrase('Successfully Login'));
            redirect(base_url() . 'accountant/dashboard', 'refresh');
          }
          if($login_user == 'librarian') {
            $this->session->set_flashdata('flash_message', get_phrase('Successfully Login'));
            redirect(base_url() . 'librarian/dashboard', 'refresh');
          }
          if($login_user == 'parent') {
            $this->session->set_flashdata('flash_message', get_phrase('Successfully Login'));
            redirect(base_url() . 'parents/dashboard', 'refresh');
          }
          if($login_user == 'student') {
            $this->session->set_flashdata('flash_message', get_phrase('Successfully Login'));
            redirect(base_url() . 'student/dashboard', 'refresh');
          }
          if($login_user == 'teacher') {
            $this->session->set_flashdata('flash_message', get_phrase('Successfully Login'));
            redirect(base_url() . 'teacher/dashboard', 'refresh');
          }
          if($login_user == 'preceptor') {
            $this->session->set_flashdata('flash_message', get_phrase('Successfully Login'));
            redirect(base_url() . 'preceptor/dashboard', 'refresh');
          }
        } catch (Throwable $e) {
          // Manejo de error inesperado
          log_message('error', 'Login error: ' . $e->getMessage());
          $this->session->set_flashdata('error_message', 'Ocurrió un error inesperado. Intenta nuevamente.');
          redirect(base_url() . 'login', 'refresh');
        }
      }


      function logout(){
        $login_user = $this->session->userdata('login_type');
        if($login_user == 'admin'){
            $this->login_model->logout_model_for_admin();
        }
        if($login_user == 'hrm'){
          $this->login_model->logout_model_for_hrm();
        }
        if($login_user == 'hostel'){
          $this->login_model->logout_model_for_hostel();
        }
        if($login_user == 'accountant'){
          $this->login_model->logout_model_for_accountant();
        }
        if($login_user == 'librarian'){
          $this->login_model->logout_model_for_librarian();
        }
        if($login_user == 'parent'){
          $this->login_model->logout_model_for_parent();
        }
        if($login_user == 'student'){
          $this->login_model->logout_model_for_student();
        }
        if($login_user == 'teacher'){
          $this->login_model->logout_model_for_teacher();
        }
        if($login_user == 'preceptor'){
          $this->login_model->logout_model_for_preceptor();
        }
        $this->session->sess_destroy();
        redirect('login', 'refresh');

      }


      
  }
