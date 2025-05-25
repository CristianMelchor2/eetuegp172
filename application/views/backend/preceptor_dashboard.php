<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Preceptor</title>
    <!-- Enlace a la CDN de Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Mantener Bootstrap JS para modales -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="min-h-screen bg-gray-50 p-4 md:p-8">
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Panel del Preceptor</h1>
    <!-- Botón Cerrar sesión adaptado a Tailwind -->
    <a href="<?php echo base_url('login/logout/preceptor'); ?>" class="bg-red-100 text-red-600 px-4 py-2 rounded-md hover:bg-red-200 text-sm md:text-base">
      Cerrar sesión
    </a>
  </div>

  <!-- Tabs adaptados a Tailwind -->
  <div class="flex flex-wrap gap-2 mb-6 text-sm md:text-base" id="tab-buttons">
    <button class="tab-button bg-blue-600 text-white px-4 py-2 rounded-md" data-tab="asistencia">Asistencia Diaria</button>
    <button class="tab-button bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300" data-tab="estadisticas">Estadísticas</button>
    <button class="tab-button bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300" data-tab="alumnos">Fichas de Alumnos</button>
  </div>

  <!-- Contenido de las pestañas -->
  <div id="tab-content">
    <!-- Sección Asistencia Diaria (adaptada a Tailwind) -->
    <div id="asistencia" class="tab-pane bg-white p-6 rounded-xl shadow-md">
      <h2 class="text-xl font-semibold mb-4 text-gray-700">Tomar Asistencia</h2>
      <!-- Formulario de búsqueda de alumnos (adaptado a Tailwind) -->
      <form class="grid gap-4 md:grid-cols-3 mb-6" method="get" action="<?php echo base_url('preceptor/dashboard'); ?>">
        <div>
          <label class="block text-sm text-gray-600 mb-1">Curso</label>
          <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="class_id" required>
            <option value="">Seleccione</option>
            <?php foreach($classes as $cl): ?>
            <option value="<?php echo $cl['class_id']; ?>" <?php if(isset($_GET['class_id']) && $_GET['class_id']==$cl['class_id']) echo 'selected'; ?>><?php echo $cl['name']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div>
          <label class="block text-sm text-gray-600 mb-1">Fecha</label>
          <input type="date" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="fecha" value="<?php echo isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d'); ?>">
        </div>
        <div class="flex items-end">
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 w-full">Buscar Alumnos</button>
        </div>
      </form>

      <?php if(!empty($students)): ?>
      <?php if(isset($attendance_exists) && $attendance_exists): ?>
          <div class="mt-4 text-yellow-800 bg-yellow-100 px-4 py-2 rounded-md text-sm">
              Ya existe asistencia cargada para este curso en esta fecha. Al guardar, se modificarán los datos existentes.
          </div>
      <?php endif; ?>
      <!-- Interfaz de asistencia (adaptada a Tailwind) -->
      <div id="attendance-interface" class="bg-white p-6 mt-6 rounded-xl shadow-md text-center">
          <h3 id="student-name" class="text-lg md:text-xl font-medium text-gray-800 mb-4"></h3>
          <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4 text-sm md:text-base">
              <button class="attendance-btn bg-green-100 hover:bg-green-200 text-green-700 font-semibold py-2 rounded-md" data-status="1">P (Presente)</button>
              <button class="attendance-btn bg-red-100 hover:bg-red-200 text-red-700 font-semibold py-2 rounded-md" data-status="2">A (Ausente)</button>
              <button class="attendance-btn bg-yellow-100 hover:bg-yellow-200 text-yellow-700 font-semibold py-2 rounded-md" data-status="3">J (Justificado)</button>
              <button class="attendance-btn bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold py-2 rounded-md" data-status="4">T (Tardanza)</button>
           </div>
           <div class="flex justify-between gap-4">
               <button class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 w-1/2" id="prev-student">Anterior</button>
               <button class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 w-1/2" id="next-student">Siguiente</button>
           </div>
           <div class="mt-4">
               <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 w-full" id="save-attendance" style="display: none;">Confirmar y Guardar</button>
               <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 w-full mt-2" id="cancel-attendance">Cancelar</button>
           </div>
        </div>

        <form id="attendance-form" method="post" action="<?php echo base_url('preceptor/save_attendance'); ?>" style="display: none;">
            <input type="hidden" name="class_id" value="<?php echo $_GET['class_id']; ?>">
            <input type="hidden" name="fecha" value="<?php echo $_GET['fecha']; ?>">
            <div id="attendance-inputs">
                <?php foreach($students as $stu): ?>
                    <input type="hidden" name="status_<?php echo $stu['student_id']; ?>" id="status_<?php echo $stu['student_id']; ?>" value="<?php echo isset($attendance[$stu['student_id']]) ? $attendance[$stu['student_id']] : 0; ?>">
                <?php endforeach; ?>
            </div>
        </form>

        <?php endif; ?>
    </div>

    <!-- Sección Estadísticas (adaptada a Tailwind) -->
    <div id="estadisticas" class="tab-pane fade bg-white p-6 rounded-xl shadow-md hidden">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Porcentajes de Asistencia y Calificaciones</h2>
        <form class="grid gap-4 md:grid-cols-3 mb-6" method="get" action="<?php echo base_url('preceptor/dashboard'); ?>#estadisticas">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Curso</label>
                <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="class_id" required>
                    <option value="">Seleccione</option>
                    <?php foreach($classes as $cl): ?>
                    <option value="<?php echo $cl['class_id']; ?>" <?php if(isset($_GET['class_id']) && $_GET['class_id']==$cl['class_id']) echo 'selected'; ?>><?php echo $cl['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 w-full">Ver Estadísticas</button>
            </div>
        </form>
        <?php if(!empty($students)): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-md">
                <thead>
                    <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Alumno</th>
                        <th class="py-3 px-6 text-left">Asistencia (%)</th>
                        <th class="py-3 px-6 text-left">Promedio</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                <?php foreach($students as $stu): ?>
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap"><?php echo $stu['name']; ?></td>
                    <td class="py-3 px-6 text-left"><?php echo isset($stats[$stu['student_id']]['attendance']) ? round($stats[$stu['student_id']]['attendance'],1) : '0'; ?>%</td>
                    <td class="py-3 px-6 text-left"><?php echo isset($stats[$stu['student_id']]['grade_avg']) ? $stats[$stu['student_id']]['grade_avg'] : '0'; ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php elseif(isset($_GET['class_id'])): ?>
            <div class="alert alert-warning">No hay alumnos en este curso.</div>
        <?php endif; ?>
    </div>

    <!-- Sección Fichas de Alumnos (nuevo flujo con Tailwind) -->
    <div id="alumnos" class="tab-pane fade bg-white p-6 rounded-xl shadow-md hidden">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Fichas de Alumnos</h2>

        <!-- Formulario para seleccionar Curso y Alumno -->
        <div class="grid gap-4 md:grid-cols-3 mb-6">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Curso</label>
                <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="select-course-ficha" required>
                    <option value="">Seleccione un curso</option>
                    <?php foreach($classes as $cl): ?>
                    <option value="<?php echo $cl['class_id']; ?>"><?php echo $cl['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Alumno</label>
                <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="select-student-ficha" required disabled>
                    <option value="">Seleccione un alumno</option>
                </select>
            </div>
            <div class="flex items-end">
                 <button class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 w-full" data-bs-toggle="modal" data-bs-target="#addAlumnoModal">Agregar Nuevo Alumno</button>
            </div>
        </div>

        <!-- Contenedor para mostrar la ficha del alumno seleccionado -->
        <div id="ficha-alumno-container" class="bg-white p-6 mt-6 rounded-xl shadow-md hidden">
            <h3 class="text-lg md:text-xl font-medium text-gray-800 mb-4">Editar Alumno</h3>
            <form id="edit-student-form" method="post" action="" enctype="multipart/form-data">
                <!-- Los campos del formulario se llenarán con JavaScript -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Nombre</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="name" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Fecha de Nacimiento</label>
                      <input type="date" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="birthday" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Edad</label>
                      <input type="number" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="age" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Lugar de Nacimiento</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="place_birth" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Sexo</label>
                      <select class="form-select w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="sex">
                        <option value="male">Masculino</option>
                        <option value="female">Femenino</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Lengua Materna</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="m_tongue" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Religión</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="religion" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Grupo Sanguíneo</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="blood_group" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Dirección</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="address" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Ciudad</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="city" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Provincia/Estado</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="state" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Nacionalidad</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="nationality" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Teléfono</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="phone" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Correo Electrónico</label>
                      <input type="email" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="email" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Escuela Primaria Asistida</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="ps_attended" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Dirección Escuela Primaria</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="ps_address" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Propósito Escuela Primaria</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="ps_purpose" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Clase de Estudio</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="class_study" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Fecha de Egreso</label>
                      <input type="date" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="date_of_leaving" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Fecha de Admisión</label>
                      <input type="date" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="am_date" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Certificado de Traslado</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="tran_cert" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Certificado de Nacimiento</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="dob_cert" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Nota de Ingreso</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="mark_join" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Historial Físico</label>
                      <textarea class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="physical_h"></textarea>
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">ID de Curso</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="class_id" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">ID de Sección</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="section_id" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">ID de Padre/Tutor</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="parent_id" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">ID de Transporte</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="transport_id" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">ID de Dormitorio</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="dormitory_id" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">ID de Casa</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="house_id" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">ID de Categoría de Estudiante</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="student_category_id" value="">
                    </div>
                    <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">ID de Club</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="club_id" value="">
                    </div>
                     <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Número de Lista</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="roll" value="">
                    </div>
                     <div class="mb-3">
                      <label class="block text-sm text-gray-600 mb-1">Sesión</label>
                      <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="session" value="">
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
  </div>

</div>

<!-- Modal Agregar Alumno (adaptado a Tailwind) -->
<div class="modal fade" id="addAlumnoModal" tabindex="-1" aria-labelledby="addAlumnoModalLabel" aria-hidden="true">
  <div class="modal-dialog relative w-auto my-6 mx-auto max-w-3xl">
    <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
      <form method="post" action="<?php echo base_url('preceptor/add_student'); ?>" enctype="multipart/form-data">
      <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
        <h5 class="text-xl font-medium leading-normal text-gray-800" id="addAlumnoModalLabel">Agregar Alumno</h5>
        <button type="button" class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body relative p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="mb-3">
          <label class="block text-sm text-gray-600 mb-1">Nombre</label>
          <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="name" required>
        </div>
        <div class="mb-3">
          <label class="block text-sm text-gray-600 mb-1">Curso</label>
          <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="class_id" required>
        </div>
        <div class="mb-3">
          <label class="block text-sm text-gray-600 mb-1">DNI</label>
          <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="dni">
        </div>
        <div class="mb-3">
          <label class="block text-sm text-gray-600 mb-1">Dirección</label>
          <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="address">
        </div>
        <div class="mb-3">
          <label class="block text-sm text-gray-600 mb-1">Teléfono</label>
          <input type="text" class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="phone">
        </div>
        <div class="mb-3">
          <label class="block text-sm text-gray-600 mb-1">Observaciones</label>
          <textarea class="form-control w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="observaciones"></textarea>
        </div>
      </div>
      <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
        <button type="button" class="px-6 py-2.5 bg-gray-200 text-gray-700 font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-300 hover:shadow-lg focus:bg-gray-300 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-400 active:shadow-lg transition duration-150 ease-in-out" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ml-1">Agregar Alumno</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
    console.log("Script loaded");

    // Script para manejar las pestañas manualmente con Tailwind
    function showTab(tabId) {
        console.log("Showing tab:", tabId);
        // Ocultar todos los contenidos de pestaña
        document.querySelectorAll('#tab-content .tab-pane').forEach(tabContent => {
            tabContent.classList.add('hidden');
        });

        // Mostrar el contenido de la pestaña seleccionada
        const selectedTab = document.getElementById(tabId);
        if (selectedTab) {
            selectedTab.classList.remove('hidden');
        }

        // Actualizar el estado activo de los botones de pestaña
        document.querySelectorAll('#tab-buttons .tab-button').forEach(button => {
            button.classList.remove('bg-blue-600', 'text-white');
            button.classList.add('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
        });
        const activeButton = document.querySelector(`#tab-buttons .tab-button[data-tab="${tabId}"]`);
        if (activeButton) {
            activeButton.classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
            activeButton.classList.add('bg-blue-600', 'text-white');
        }
    }

    // Asignar event listeners a los botones de pestaña
    document.querySelectorAll('#tab-buttons .tab-button').forEach(button => {
        button.addEventListener('click', function() {
            const tabId = this.dataset.tab;
            showTab(tabId);
        });
    });

    // Mostrar la pestaña activa al cargar la página
    document.addEventListener('DOMContentLoaded', () => {
        console.log("DOM fully loaded");
        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get('tab') || 'asistencia';
        showTab(activeTab);

        // Script de asistencia existente (solo si hay alumnos)
        <?php if(!empty($students)): ?>
            const students = <?php echo json_encode($students); ?>;
            const initialAttendance = <?php echo json_encode(isset($attendance) ? $attendance : []); ?>;
            let currentStudentIndex = 0;
            const attendanceData = {};

            // Initialize attendanceData with existing data or default to 0
            students.forEach(student => {
                attendanceData[student.student_id] = initialAttendance[student.student_id] || 0;
            });

            function displayStudent(index) {
                if (index >= 0 && index < students.length) {
                    currentStudentIndex = index;
                    const student = students[currentStudentIndex];
                    document.getElementById('student-name').innerText = student.name;

                    // Highlight selected status button using Tailwind classes
                    document.querySelectorAll('.attendance-btn').forEach(button => {
                        button.classList.remove('border-2', 'border-blue-500'); // Remove active style
                        if (parseInt(button.dataset.status) === attendanceData[student.student_id]) {
                            button.classList.add('border-2', 'border-blue-500'); // Add active style
                        }
                    });

                    // Show/hide navigation buttons
                    document.getElementById('prev-student').style.visibility = currentStudentIndex === 0 ? 'hidden' : 'visible';
                    document.getElementById('next-student').style.visibility = currentStudentIndex === students.length - 1 ? 'hidden' : 'visible';

                    document.getElementById('save-attendance').style.display = currentStudentIndex === students.length - 1 ? 'block' : 'none';

                }
            }

            document.querySelectorAll('.attendance-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const status = parseInt(this.dataset.status);
                    const student = students[currentStudentIndex];
                    attendanceData[student.student_id] = status;

                    // Update the hidden input value
                    document.getElementById('status_' + student.student_id).value = status;

                    // Highlight the selected button and remove highlight from others using Tailwind classes
                    document.querySelectorAll('.attendance-btn').forEach(btn => {
                        btn.classList.remove('border-2', 'border-blue-500');
                    });
                    this.classList.add('border-2', 'border-blue-500');


                    // Move to the next student automatically after a short delay
                    setTimeout(() => {
                        if (currentStudentIndex < students.length - 1) {
                            displayStudent(currentStudentIndex + 1);
                        } else {
                             // If it's the last student, ensure the save button is visible
                            document.getElementById('save-attendance').style.display = 'block';
                        }
                    }, 300); // Pequeño retraso para ver el estado seleccionado
                });
            });

            document.getElementById('prev-student').addEventListener('click', function() {
                displayStudent(currentStudentIndex - 1);
            });

            document.getElementById('next-student').addEventListener('click', function() {
                displayStudent(currentStudentIndex + 1);
            });

             document.getElementById('save-attendance').addEventListener('click', function() {
                document.getElementById('attendance-form').submit();
            });

            document.getElementById('cancel-attendance').addEventListener('click', function() {
                window.location.href = '<?php echo base_url('preceptor/dashboard'); ?>'; // Redirect or close modal
            });


            // Initial display for attendance interface
            if (students && students.length > 0) {
                displayStudent(0);
            }
        <?php endif; ?>

        // Script para la sección Fichas de Alumnos
        const selectCourseFicha = document.getElementById('select-course-ficha');
        const selectStudentFicha = document.getElementById('select-student-ficha');
        const fichaAlumnoContainer = document.getElementById('ficha-alumno-container');
        const editStudentForm = document.getElementById('edit-student-form');

        // Event listener para el cambio de curso
        selectCourseFicha.addEventListener('change', function() {
            const classId = this.value;
            selectStudentFicha.innerHTML = '<option value="">Cargando alumnos...</option>';
            selectStudentFicha.disabled = true;
            fichaAlumnoContainer.classList.add('hidden'); // Ocultar ficha al cambiar de curso

            if (classId) {
                // Realizar solicitud AJAX para obtener alumnos por curso
                fetch(`<?php echo base_url('preceptor/get_students_by_class'); ?>/${classId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        selectStudentFicha.innerHTML = '<option value="">Seleccione un alumno</option>';
                        if (data.length > 0) {
                            data.forEach(student => {
                                const option = document.createElement('option');
                                option.value = student.student_id;
                                option.textContent = student.name;
                                selectStudentFicha.appendChild(option);
                            });
                            selectStudentFicha.disabled = false;
                        } else {
                            selectStudentFicha.innerHTML = '<option value="">No hay alumnos en este curso</option>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching students:', error);
                        selectStudentFicha.innerHTML = '<option value="">Error al cargar alumnos</option>';
                        selectStudentFicha.disabled = true;
                    });
            } else {
                selectStudentFicha.innerHTML = '<option value="">Seleccione un alumno</option>';
                selectStudentFicha.disabled = true;
            }
        });

        // Event listener para el cambio de alumno
        selectStudentFicha.addEventListener('change', function() {
            const studentId = this.value;
            if (studentId) {
                // Realizar solicitud AJAX para obtener datos del alumno
                fetch(`<?php echo base_url('preceptor/get_student_data'); ?>/${studentId}`)
                    .then(response => {
                         if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data) {
                            // Llenar el formulario con los datos del alumno
                            editStudentForm.action = `<?php echo base_url('preceptor/edit_student'); ?>/${studentId}`;
                            for (const key in data) {
                                if (editStudentForm.elements[key]) {
                                    editStudentForm.elements[key].value = data[key];
                                }
                            }
                            fichaAlumnoContainer.classList.remove('hidden'); // Mostrar la ficha
                        } else {
                            console.error('No se encontraron datos para el alumno:', studentId);
                            fichaAlumnoContainer.classList.add('hidden'); // Ocultar ficha si no hay datos
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching student data:', error);
                        fichaAlumnoContainer.classList.add('hidden'); // Ocultar ficha en caso de error
                    });
            } else {
                fichaAlumnoContainer.classList.add('hidden'); // Ocultar ficha si no se selecciona alumno
            }
        });
    });

</script>

</body>
</html>
