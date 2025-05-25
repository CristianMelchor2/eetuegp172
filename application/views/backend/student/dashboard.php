<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Panel de Notas y Asistencia para el Estudiante (estética nativa Play Store) -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="EET 172">
    <meta name="author" content="EET 172">
    <link rel="icon" sizes="16x16" href="<?php echo base_url('uploads/logo.png'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <style>
        body {
            background: #f5f6fa;
            margin: 0;
            font-family: 'Poppins', Arial, sans-serif;
        }
        .appbar {
            background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%);
            color: #fff;
            padding: 18px 24px;
            font-size: 1.7rem;
            font-weight: 600;
            letter-spacing: 1px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            border-radius: 0 0 18px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .main-container {
            max-width: 420px;
            margin: 32px auto;
            padding: 0 8px 32px 8px;
        }
        .card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            margin-bottom: 28px;
            padding: 24px 18px 18px 18px;
        }
        .card h3 {
            margin-top: 0;
            font-size: 1.3rem;
            color: #185a9d;
            font-weight: 600;
            margin-bottom: 18px;
        }
        .notas-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 1.05rem;
        }
        .notas-table th, .notas-table td {
            padding: 10px 6px;
            text-align: center;
        }
        .notas-table th {
            background: #f1f6fb;
            color: #185a9d;
            font-weight: 500;
        }
        .notas-table tr {
            border-radius: 12px;
        }
        .notas-table tr:nth-child(even) {
            background: #f8fafc;
        }
        .asistencia-block {
            margin-top: 10px;
            padding: 18px 12px;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 500;
            box-shadow: 0 1px 6px rgba(33,150,243,0.07);
        }
        .asistencia-rojo { background: #e74c3c; color: #fff; }
        .asistencia-amarillo { background: #f1c40f; color: #fff; }
        .asistencia-verde { background: #27ae60; color: #fff; }
        @media (max-width: 600px) {
            body {
                font-size: 0.98rem;
            }
            .main-container {
                max-width: 100vw;
                margin: 0;
                padding: 0 0 24px 0;
            }
            .card {
                padding: 8px 2px 8px 2px;
                margin-bottom: 14px;
                border-radius: 10px;
                box-shadow: 0 1px 6px rgba(0,0,0,0.06);
            }
            .card h3 {
                font-size: 1.05rem;
                margin-bottom: 10px;
            }
            .notas-table {
                font-size: 0.93rem;
                display: block;
                overflow-x: auto;
                width: 100%;
                min-width: 350px;
            }
            .notas-table th, .notas-table td {
                padding: 6px 2px;
                font-size: 0.93rem;
                word-break: break-word;
            }
            .notas-table th {
                font-size: 0.95rem;
            }
            .notas-table tr, .notas-table th, .notas-table td {
                white-space: nowrap;
            }
            .appbar {
                font-size: 1rem;
                padding: 10px 4px;
                border-radius: 0 0 10px 10px;
            }
            .asistencia-block {
                font-size: 0.98rem;
                padding: 12px 6px;
            }
        }
    </style>
</head>
<body>
    <div class="appbar">
        <span>Panel del Estudiante</span>
    </div>
    <div class="main-container">
        <div class="card">
            <h3>Notas</h3>
            <table class="notas-table">
                <tr>
                    <th>Materia</th>
                    <th>Nota primer cuatrimestre</th>
                    <th>Nota segundo cuatrimestre</th>
                    <th>Recup. Diciembre</th>
                    <th>Recup. Marzo</th>
                </tr>
                <?php
                // --- LIMPIEZA: Elimino mensajes DEBUG visibles en producción ---
                $student_id = $this->session->userdata('student_id');
                $CI =& get_instance();
                $CI->load->model('crud_model');
                $student = $CI->db->get_where('student', array('student_id' => $student_id))->row();
                $class_id = $student ? $student->class_id : null;
                $materias = $class_id ? $CI->crud_model->get_subjects_by_class($class_id) : array();
                // Obtener todas las notas del alumno indexadas por subject_id
                $notas = array();
                if ($student_id) {
                    $notas_db = $CI->db->get_where('mark', array('student_id' => $student_id))->result();
                    foreach ($notas_db as $nota) {
                        $notas[$nota->subject_id] = $nota;
                    }
                }
                if (!$student_id) {
                    echo '<tr><td colspan="5">Error: No se encontró el ID del estudiante en la sesión.</td></tr>';
                } elseif ($materias) {
                    foreach ($materias as $materia):
                        $nota = isset($notas[$materia['subject_id']]) ? $notas[$materia['subject_id']] : null;
                ?>
                <tr>
                    <td><?php echo $materia['name']; ?></td>
                    <td><?php echo $nota && isset($nota->nota_1c) ? $nota->nota_1c : '-'; ?></td>
                    <td><?php echo $nota && isset($nota->nota_2c) ? $nota->nota_2c : '-'; ?></td>
                    <td><?php echo $nota && isset($nota->labuno) ? $nota->labuno : '-'; ?></td>
                    <td><?php echo $nota && isset($nota->labdos) ? $nota->labdos : '-'; ?></td>
                </tr>
                <?php endforeach;
                } else {
                    echo '<tr><td colspan="5">No hay materias registradas para tu curso.</td></tr>';
                }
                ?>
            </table>
        </div>
        <div class="card">
            <h3>Asistencia</h3>
            <?php
                $total = $student_id ? $this->db->where('student_id', $student_id)->from('attendance')->count_all_results() : 0;
                $presentes = $student_id ? $this->db->where(array('student_id' => $student_id, 'status' => 1))->from('attendance')->count_all_results() : 0;
                $asistencia = $total > 0 ? ($presentes / $total) * 100 : 0;
                $clase = '';
                $mensaje = '';
                if ($asistencia < 70) {
                    $clase = 'asistencia-block asistencia-rojo';
                    $mensaje = 'En riesgo de quedar libre. Hable con el preceptor a la brevedad.';
                } elseif ($asistencia < 85) {
                    $clase = 'asistencia-block asistencia-amarillo';
                    $mensaje = 'Está en el límite, cuide sus faltas.';
                } else {
                    $clase = 'asistencia-block asistencia-verde';
                    $mensaje = '¡Excelente asistencia! Felicitaciones.';
                }
            ?>
            <div class="<?php echo $clase; ?>">
                Asistencia: <?php echo round($asistencia, 2); ?>%<br>
                <?php echo $mensaje; ?>
            </div>
        </div>
    </div>
</body>
</html>