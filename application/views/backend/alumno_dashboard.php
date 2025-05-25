<!DOCTYPE html>
<html>
<head>
    <title>Panel del Alumno</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <style>
        body {
            background: #f8f9fa;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', Arial, sans-serif;
        }
        .mobile-container {
            max-width: 480px;
            margin: 0 auto;
            background: #fff;
            min-height: 100vh;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-radius: 0 0 16px 16px;
            padding-bottom: 32px;
        }
        .header {
            background: #27ae60;
            color: #fff;
            padding: 24px 16px 16px 16px;
            border-radius: 0 0 24px 24px;
            text-align: center;
            font-size: 2.2rem;
            font-weight: 600;
            letter-spacing: 1px;
        }
        .section-title {
            font-size: 1.5rem;
            margin: 24px 0 12px 0;
            color: #222;
            font-weight: 500;
            padding-left: 16px;
        }
        .grades-table {
            width: 92%;
            margin: 0 auto 24px auto;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            background: #fafbfc;
        }
        .grades-table th, .grades-table td {
            padding: 14px 8px;
            text-align: center;
            font-size: 1.2rem;
        }
        .grades-table th {
            background: #e9ecef;
            color: #333;
        }
        .grades-table tr:nth-child(even) {
            background: #f4f6f8;
        }
        .asistencia-alert {
            margin: 0 auto 24px auto;
            width: 92%;
            font-size: 1.2rem;
            border-radius: 10px;
            padding: 18px 12px;
            text-align: center;
            font-weight: 500;
        }
        .asistencia-rojo {
            background: #e74c3c;
            color: #fff;
        }
        .asistencia-amarillo {
            background: #f1c40f;
            color: #fff;
        }
        .asistencia-verde {
            background: #27ae60;
            color: #fff;
        }
        @media (max-width: 600px) {
            .mobile-container {
                border-radius: 0;
                box-shadow: none;
            }
            .header {
                font-size: 1.5rem;
                padding: 18px 8px 10px 8px;
            }
            .section-title {
                font-size: 1.1rem;
                padding-left: 8px;
            }
            .grades-table th, .grades-table td {
                font-size: 1rem;
                padding: 10px 4px;
            }
            .asistencia-alert {
                font-size: 1rem;
                padding: 12px 6px;
            }
        }
        .btn-salir {
            display: block;
            width: 92%;
            margin: 32px auto 0 auto;
            background: #e74c3c;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 16px 0;
            font-size: 1.3rem;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            box-shadow: 0 2px 6px rgba(0,0,0,0.07);
            transition: background 0.2s;
        }
        .btn-salir:active {
            background: #c0392b;
        }
    </style>
</head>
<body>
    <div class="mobile-container">
        <div class="header">¡Hola Alumno!</div>
        <div class="section-title">Notas</div>
        <table class="grades-table">
            <tr>
                <th>1º Cuatrimestre</th>
                <th>2º Cuatrimestre</th>
                <th>Recup. Diciembre</th>
                <th>Recup. Marzo</th>
            </tr>
            <?php foreach ($notas as $nota): ?>
            <tr>
                <td><?php echo $nota->cuatrimestre1; ?></td>
                <td><?php echo $nota->cuatrimestre2; ?></td>
                <td><?php echo $nota->recuperatorio_diciembre; ?></td>
                <td><?php echo $nota->recuperatorio_marzo; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <div class="section-title">Asistencia</div>
        <?php
            $clase = '';
            $mensaje = '';
            if ($asistencia < 70) {
                $clase = 'asistencia-alert asistencia-rojo';
                $mensaje = 'En riesgo de quedar libre. Hable con el preceptor a la brevedad.';
            } elseif ($asistencia < 85) {
                $clase = 'asistencia-alert asistencia-amarillo';
                $mensaje = 'Está en el límite, cuide sus faltas.';
            } else {
                $clase = 'asistencia-alert asistencia-verde';
                $mensaje = '¡Excelente asistencia! Felicitaciones.';
            }
        ?>
        <div class="<?php echo $clase; ?>">
            Asistencia: <?php echo round($asistencia, 2); ?>%<br>
            <?php echo $mensaje; ?>
        </div>
        <a href="<?php echo base_url('login/logout'); ?>" class="btn-salir">Salir</a>
    </div>
</body>
</html>
