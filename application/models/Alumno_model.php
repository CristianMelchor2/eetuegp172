<?php
class Alumno_model extends CI_Model {
    public function get_notas($user_id) {
        // Usar la tabla 'mark' y el campo 'student_id'
        return $this->db->get_where('mark', array('student_id' => $user_id))->result();
    }
    public function get_asistencia($user_id) {
        // Usar la tabla 'attendance' y el campo 'student_id'
        $total = $this->db->where('student_id', $user_id)->from('attendance')->count_all_results();
        $presentes = $this->db->where(array('student_id' => $user_id, 'status' => 1))->from('attendance')->count_all_results();
        $porcentaje = $total > 0 ? ($presentes / $total) * 100 : 0;
        return $porcentaje;
    }

    public function get_students_by_class($class_id) {
        $this->db->where('class_id', $class_id);
        return $this->db->get('student')->result_array();
    }

    public function get_student_data($student_id) {
        $this->db->where('student_id', $student_id);
        return $this->db->get('student')->row_array();
    }
}
