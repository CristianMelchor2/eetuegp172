<?php
// Incluir header
require_once 'includes/header.php';

// Verificar que el usuario esté logueado
requireLogin();

// Obtener el ciclo lectivo actual
$ciclo_lectivo = getCicloLectivo($conn);

// Obtener estadísticas para el dashboard
// Total de usuarios
$sql_usuarios = "SELECT COUNT(*) AS total FROM usuarios";
$result_usuarios = mysqli_query($conn, $sql_usuarios);
$row_usuarios = mysqli_fetch_assoc($result_usuarios);
$total_usuarios = $row_usuarios['total'];

// Total de materias
$sql_materias = "SELECT COUNT(*) AS total FROM materias";
$result_materias = mysqli_query($conn, $sql_materias);
$row_materias = mysqli_fetch_assoc($result_materias);
$total_materias = $row_materias['total'];

// Total de alumnos activos
$sql_alumnos = "SELECT COUNT(*) AS total FROM alumnos";
$sql_alumnos = "SELECT COUNT(*) AS total FROM usuarios WHERE rol_id = 'e46e582b-48d7-4cad-a993-d5dc7ce4f58c'";
$result_alumnos = mysqli_query($conn, $sql_alumnos);
$row_alumnos = 0;
if ($result_alumnos) {
    $row_alumnos = mysqli_fetch_assoc($result_alumnos);
    $total_alumnos = $row_alumnos['total'];
} else {
    $total_alumnos = 0;
}

// Porcentaje de asistencia del día (simulado para ejemplo)
$porcentaje_asistencia = 95.5;

// Materias con más inasistencias (simulado para ejemplo)
$materias_inasistencias = [
    ["nombre" => "Matemática", "porcentaje" => 92],
    ["nombre" => "Lengua y Literatura", "porcentaje" => 94],
    ["nombre" => "Historia", "porcentaje" => 89],
    ["nombre" => "Biología", "porcentaje" => 91],
    ["nombre" => "Física", "porcentaje" => 87]
];

// Datos para el gráfico de asistencia mensual (simulado para ejemplo)
$datos_asistencia_mensual = json_encode([
    ["mes" => "Mar", "asistencia" => 93.5],
    ["mes" => "Abr", "asistencia" => 91.8],
    ["mes" => "May", "asistencia" => 94.2],
    ["mes" => "Jun", "asistencia" => 92.7],
    ["mes" => "Jul", "asistencia" => 95.1]
]);

// Datos para el gráfico de promedio de notas por materia (simulado para ejemplo)
$datos_promedio_materias = json_encode([
    ["materia" => "Matemática", "promedio" => 7.5],
    ["materia" => "Lengua", "promedio" => 8.2],
    ["materia" => "Historia", "promedio" => 7.9],
    ["materia" => "Biología", "promedio" => 7.7],
    ["materia" => "Física", "promedio" => 6.8],
    ["materia" => "Química", "promedio" => 7.3]
]);
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Dashboard</h1>
        <div class="d-flex align-items-center">
            <span class="me-2">Ciclo Lectivo:</span>
            <span class="badge bg-primary"><?php echo $ciclo_lectivo; ?></span>
        </div>
    </div>

    <!-- KPIs -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="dashboard-card">
                <div class="dashboard-card-title">
                    <i class="fas fa-users me-2"></i> Usuarios Activos
                </div>
                <div class="dashboard-card-value">
                    <?php echo $total_usuarios; ?>
                </div>
                <div class="text-muted small">+2.5% respecto al mes anterior</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="dashboard-card">
                <div class="dashboard-card-title">
                    <i class="fas fa-book me-2"></i> Materias Asignadas
                </div>
                <div class="dashboard-card-value">
                    <?php echo $total_materias; ?>
                </div>
                <div class="text-muted small">100% completado</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="dashboard-card">
                <div class="dashboard-card-title">
                    <i class="fas fa-clipboard-check me-2"></i> Asistencia del Día
                </div>
                <div class="dashboard-card-value">
                    <?php echo $porcentaje_asistencia; ?>%
                </div>
                <div class="text-muted small">+1.2% respecto a ayer</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="dashboard-card">
                <div class="dashboard-card-title">
                    <i class="fas fa-graduation-cap me-2"></i> Alumnos Activos
                </div>
                <div class="dashboard-card-value">
                    <?php echo $total_alumnos > 0 ? $total_alumnos : 'N/D'; ?>
                </div>
                <div class="text-muted small">Status actualizado</div>
            </div>
        </div>
    </div>

    <!-- Tabs para diferentes vistas -->
    <ul class="nav nav-tabs mb-4" id="dashboardTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true">General</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="asistencias-tab" data-bs-toggle="tab" data-bs-target="#asistencias" type="button" role="tab" aria-controls="asistencias" aria-selected="false">Asistencias</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="evaluaciones-tab" data-bs-toggle="tab" data-bs-target="#evaluaciones" type="button" role="tab" aria-controls="evaluaciones" aria-selected="false">Evaluaciones</button>
        </li>
    </ul>

    <div class="tab-content" id="dashboardTabsContent">
        <!-- Tab General -->
        <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
            <div class="row">
                <!-- Gráfico de asistencia mensual -->
                <div class="col-lg-8 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Asistencia Mensual</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="chartAsistenciaMensual" height="250"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Lista de materias con más inasistencias -->
                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Materias con más inasistencias</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <?php foreach ($materias_inasistencias as $materia): ?>
                                <div class="list-group-item border-0 px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span><?php echo $materia['nombre']; ?></span>
                                        <span class="badge bg-<?php echo getPercentageClass($materia['porcentaje']); ?>"><?php echo $materia['porcentaje']; ?>%</span>
                                    </div>
                                    <div class="progress mt-1" style="height: 5px;">
                                        <div class="progress-bar bg-<?php echo getPercentageClass($materia['porcentaje']); ?>" role="progressbar" style="width: <?php echo $materia['porcentaje']; ?>%" aria-valuenow="<?php echo $materia['porcentaje']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Promedio de notas por materia -->
                <div class="col-lg-8 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Promedio por materias</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="chartPromedioMaterias" height="250"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Alertas -->
                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Alertas</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning" role="alert">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                                    </div>
                                    <div>
                                        <h6 class="alert-heading mb-1">Documentos faltantes</h6>
                                        <p class="mb-0">3 docentes no han presentado planificaciones anuales.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-danger" role="alert">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-exclamation-circle fa-2x"></i>
                                    </div>
                                    <div>
                                        <h6 class="alert-heading mb-1">Certificados vencidos</h6>
                                        <p class="mb-0">2 certificados médicos están próximos a vencer.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-info" role="alert">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-info-circle fa-2x"></i>
                                    </div>
                                    <div>
                                        <h6 class="alert-heading mb-1">Notas pendientes</h6>
                                        <p class="mb-0">El curso 3°B tiene evaluaciones pendientes de carga.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Asistencias -->
        <div class="tab-pane fade" id="asistencias" role="tabpanel" aria-labelledby="asistencias-tab">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Asistencia por curso</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartAsistenciaCursos" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Tab Evaluaciones -->
        <div class="tab-pane fade" id="evaluaciones" role="tabpanel" aria-labelledby="evaluaciones-tab">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Promedio por curso</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartPromedioCursos" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos para gráficos
    const datosAsistenciaMensual = <?php echo $datos_asistencia_mensual; ?>;
    const datosPromedioMaterias = <?php echo $datos_promedio_materias; ?>;

    // Gráfico de asistencia mensual
    const ctxAsistencia = document.getElementById('chartAsistenciaMensual').getContext('2d');
    new Chart(ctxAsistencia, {
        type: 'line',
        data: {
            labels: datosAsistenciaMensual.map(item => item.mes),
            datasets: [{
                label: 'Asistencia (%)',
                data: datosAsistenciaMensual.map(item => item.asistencia),
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 2,
                tension: 0.3
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: false,
                    min: 85,
                    max: 100
                }
            }
        }
    });

    // Gráfico de promedio por materias
    const ctxPromedio = document.getElementById('chartPromedioMaterias').getContext('2d');
    new Chart(ctxPromedio, {
        type: 'bar',
        data: {
            labels: datosPromedioMaterias.map(item => item.materia),
            datasets: [{
                label: 'Promedio',
                data: datosPromedioMaterias.map(item => item.promedio),
                backgroundColor: [
                    'rgba(59, 130, 246, 0.7)',
                    'rgba(16, 185, 129, 0.7)',
                    'rgba(245, 158, 11, 0.7)',
                    'rgba(139, 92, 246, 0.7)',
                    'rgba(244, 63, 94, 0.7)',
                    'rgba(45, 212, 191, 0.7)'
                ]
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: false,
                    min: 4,
                    max: 10
                }
            }
        }
    });

    // Gráfico de asistencia por cursos (Tab Asistencias)
    const ctxAsistenciaCursos = document.getElementById('chartAsistenciaCursos').getContext('2d');
    new Chart(ctxAsistenciaCursos, {
        type: 'bar',
        data: {
            labels: ['1°A', '1°B', '2°A', '2°B', '3°A', '3°B', '4°A', '4°B', '5°A', '5°B'],
            datasets: [{
                label: 'Asistencia (%)',
                data: [92, 88, 95, 90, 91, 89, 94, 93, 90, 87],
                backgroundColor: 'rgba(59, 130, 246, 0.7)'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: false,
                    min: 80,
                    max: 100
                }
            }
        }
    });

    // Gráfico de promedio por cursos (Tab Evaluaciones)
    const ctxPromedioCursos = document.getElementById('chartPromedioCursos').getContext('2d');
    new Chart(ctxPromedioCursos, {
        type: 'bar',
        data: {
            labels: ['1°A', '1°B', '2°A', '2°B', '3°A', '3°B', '4°A', '4°B', '5°A', '5°B'],
            datasets: [{
                label: 'Promedio',
                data: [7.8, 7.3, 8.1, 7.5, 7.9, 7.2, 8.3, 7.7, 8.0, 7.4],
                backgroundColor: 'rgba(16, 185, 129, 0.7)'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: false,
                    min: 4,
                    max: 10
                }
            }
        }
    });
});
</script>

<?php
// Incluir footer
require_once 'includes/footer.php';
?>
