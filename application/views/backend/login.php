<?php 
$system_name = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;
$system_title = $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EET UEGP Nº172 "DEOLINDO FELIPE BITTEL" - Ingreso</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            width: 100vw;
            font-family: 'Montserrat', Arial, sans-serif;
            background: url('uploads/login_bg.jpg') center center/cover no-repeat fixed, #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(255,255,255,0.82);
            z-index: 1;
        }
        .login-container {
            position: relative;
            z-index: 2;
            background: rgba(255,255,255,0.97);
            border-radius: 18px;
            box-shadow: 0 4px 32px rgba(0,0,0,0.10);
            padding: 40px 32px 32px 32px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .login-container img.logo {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            margin-bottom: 18px;
            box-shadow: 0 2px 12px rgba(33,150,243,0.10);
        }
        .login-container h1 {
            font-size: 1.5rem;
            color: #185a9d;
            margin-bottom: 8px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .login-container h2 {
            font-size: 1.1rem;
            color: #43cea2;
            margin-bottom: 18px;
            font-weight: 500;
        }
        .login-container form {
            margin-top: 18px;
        }
        .login-container input[type="text"],
        .login-container input[type="password"],
        .login-container input[type="email"] {
            width: 100%;
            padding: 12px 10px;
            margin-bottom: 14px;
            border: 1px solid #bfc9d1;
            border-radius: 6px;
            font-size: 1rem;
            background: #f8fafc;
        }
        .login-container button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%);
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .login-container button:hover {
            background: linear-gradient(90deg, #185a9d 0%, #43cea2 100%);
        }
        .login-container .footer {
            margin-top: 24px;
            color: #888;
            font-size: 0.95rem;
        }
        @media (max-width: 600px) {
            .login-container {
                padding: 24px 6px 18px 6px;
                max-width: 98vw;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="overlay"></div>
    <div class="login-container">
        <img src="<?php echo base_url('uploads/logo.png'); ?>" alt="Logo EET 172" class="logo">
        <h1>EET UEGP Nº172<br>"DEOLINDO FELIPE BITTEL"</h1>
        <h2>Sistema de Gestión Escolar</h2>
        <form method="post" action="<?php echo base_url('login/validate_login'); ?>">
            <input type="email" name="email" placeholder="Correo electrónico" required autofocus>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>
        <div class="footer">
            &copy; <?php echo date('Y'); ?> EET UEGP Nº172 "DEOLINDO FELIPE BITTEL"<br>
            <span style="font-size:0.9em;">Chaco, Argentina</span>
        </div>
    </div>
</body>
</html>
