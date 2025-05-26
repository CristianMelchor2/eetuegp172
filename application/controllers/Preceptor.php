<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Preceptor extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Alumno_model');
        // Puedes cargar modelos, helpers, etc. aquí si lo necesitas
    }

    public function dashboard() {
        $this->load->database();
        // Solo mostrar cursos con alumnos asignados
        $classes = $this->db->query('SELECT c.* FROM class c WHERE EXISTS (SELECT 1 FROM student s WHERE s.class_id = c.class_id)')->result_array();

        $students = [];
        $attendance = [];
        $stats = [];
        $all_students = [];
        $attendance_exists = false;
        if ($this->input->get('class_id')) {
            $class_id = $this->input->get('class_id');
            $date = $this->input->get('fecha') ?: date('Y-m-d');

            $students = $this->db->get_where('student', ['class_id' => $class_id])->result_array();

            // Obtener los IDs de los estudiantes en el curso
            $student_ids = array_column($students, 'student_id');

            $attendance_exists = false;
            if (!empty($student_ids)) {
                 // Verificar si ya existe asistencia para esta fecha y cualquiera de los alumnos del curso
                $this->db->where_in('student_id', $student_ids);
                $this->db->where('date', $date);
                $existing_attendance = $this->db->get('attendance')->row();
                if ($existing_attendance) {
                    $attendance_exists = true;
                }
            }


            // Attendance for selected date
            $attendance = [];
            foreach ($students as $student) {
                $att = $this->db->get_where('attendance', ['student_id' => $student['student_id'], 'date' => $date])->row_array();
                $attendance[$student['student_id']] = $att ? $att['status'] : 0;
            }
            // Statistics: attendance % and grade average
            $stats = [];
            foreach ($students as $student) {
                $stats[$student['student_id']]['attendance'] = $this->Alumno_model->get_asistencia($student['student_id']);
                $notas = $this->Alumno_model->get_notas($student['student_id']);
                $avg = 0; $count = 0;
                foreach ($notas as $nota) { $avg += $nota->mark_obtained; $count++; }
                $stats[$student['student_id']]['grade_avg'] = $count ? round($avg/$count,2) : 0;
            }
        } else {
             $students = [];
             $attendance = [];
             $stats = [];
             $attendance_exists = false; // Asegurarse de que sea false si no hay curso seleccionado
        }
        // Para la pestaña de fichas de alumnos
        $all_students = $this->db->query('SELECT * FROM student')->result_array();
        $this->load->view('backend/preceptor_dashboard', compact('classes', 'students', 'attendance', 'stats', 'all_students', 'attendance_exists'));
    }

    // Handle attendance submission
    public function save_attendance() {
        $this->load->database();
        $class_id = $this->input->post('class_id');
        $date = $this->input->post('fecha');
        $students = $this->db->get_where('student', ['class_id' => $class_id])->result_array();
        foreach ($students as $student) {
            $status = $this->input->post('status_' . $student['student_id']);
            $data = [
                'student_id' => $student['student_id'],
                'date' => $date,
                'status' => $status
            ];
            $exists = $this->db->get_where('attendance', ['student_id' => $student['student_id'], 'date' => $date])->row();
            if ($exists) {
                $this->db->where(['student_id' => $student['student_id'], 'date' => $date])->update('attendance', ['status' => $status]);
            } else {
                $this->db->insert('attendance', $data);
            }
        }
        redirect('preceptor/dashboard?class_id=' . $class_id . '&fecha=' . $date);
    }

    // Student CRUD actions (add, edit, delete)
    public function add_student() {
        $this->load->model('Student_model');
        $this->Student_model->createNewStudent();
        redirect('preceptor/dashboard');
}
    public function edit_student($student_id) {
        $this->load->model('Student_model');
        $this->Student_model->updateNewStudent($student_id);
        redirect('preceptor/dashboard');
    public function delete_student($student_id) {
        $this->load->model('Student_model');
        $this->Student_model->deleteNewStudent($student_id);
        redirect('preceptor/dashboard');
    }

    public function get_students_by_class($class_id) {
        $this->load->model('Alumno_model');
        $students = $this->Alumno_model->get_students_by_class($class_id);
        header('Content-Type: application/json');
        echo json_encode($students);
    }

    public function get_student_data($student_id) {
        $this->load->model('Alumno_model');
        $student_data = $this->Alumno_model->get_student_data($student_id);
        header('Content-Type: application/json');
        echo json_encode($student_data);
    }
}

