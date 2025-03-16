<?php
require __DIR__ . '/vendor/autoload.php';

session_start();

use Dotenv\Dotenv;
use App\Crud\DB;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = new DB();

if (isset($_POST['submit'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    switch ($_POST['submit']) {
        case 'Login':
            if ($db->validar_usuario($username, $password)) {
                $_SESSION['username'] = $username;
                header('Location: sitio.php');
            } else {
                $msj = "Usuario o contraseña incorrectos";
            }
            break;
        case 'Register':
            if ($_POST['password'] !== $_POST['password2']) {
                $msj = "Las contraseñas no coinciden";
                break;
            }
            if ($db->existe_usuario($username)) {
                $msj = "El usuario ya existe";
                break;
            }
            if ($db->registrar_usuario($username, $password)) {
                $msj = "Usuario registrado correctamente";
            } else {
                $msj = "Error al registrar el usuario";
            }
            break;
    }
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        .form-container {
            max-width: 400px;
            margin: 50px auto;
            background: #1e1e1e;
            border-radius: 8px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.5);
            overflow: hidden;
        }

        .form-header {
            display: flex;
            justify-content: space-around;
            background: #272727;
            padding: 10px;
        }

        .form-header button {
            background: transparent;
            border: none;
            color: #ccc;
            font-size: 16px;
            padding: 10px 20px;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .form-header button.active {
            color: #ff4081;
            border-bottom: 2px solid #ff4081;
        }

        .forms {
            position: relative;
            height: 250px;
            overflow: hidden;
        }

        .form-content {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            transition: transform 0.5s ease;
            padding: 20px;
        }
        #login-form {
            transform: translateX(0);
        }

        #register-form {
            transform: translateX(100%);
        }

        .form-content input[type="text"],
        .form-content input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #444;
            border-radius: 4px;
            background-color: #2c2c2c;
            color: #e0e0e0;
        }

        .form-content input[type="submit"] {
            width: 100%;
            background: #ff4081;
            border: none;
            padding: 10px;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .form-content input[type="submit"]:hover {
            background: #e03570;
        }
    </style>
</head>

<body>
    <?php
    if (isset($msj)) {
        echo "<div id='mensaje'><h1>$msj</h1></div>";
    }
    ?>
    <div class="form-container">
        <div class="form-header">
            <button id="btn-login" class="active">Login</button>
            <button id="btn-register">Register</button>
        </div>
        <div class="forms">
            <!-- Formulario de Login -->
            <form id="login-form" class="form-content" action="index.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" name="submit" value="Login">
            </form>
            <!-- Formulario de Registro -->
            <form id="register-form" class="form-content" action="index.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="password2" placeholder="Repeat Password" required>
                <input type="submit" name="submit" value="Register">
            </form>
        </div>
    </div>
    <script>
        const btnLogin = document.getElementById('btn-login');
        const btnRegister = document.getElementById('btn-register');
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');

        btnLogin.addEventListener('click', () => {
            btnLogin.classList.add('active');
            btnRegister.classList.remove('active');
            registerForm.style.transform = "translateX(100%)";
            loginForm.style.transform = "translateX(0)";
        });

        btnRegister.addEventListener('click', () => {
            btnRegister.classList.add('active');
            btnLogin.classList.remove('active');
            loginForm.style.transform = "translateX(-100%)";
            registerForm.style.transform = "translateX(0)";
        });
    </script>
    <script>
        setTimeout(function() {
            const mensaje = document.getElementById('mensaje');
            if (mensaje) {
                mensaje.style.display = 'none';
            }
        }, 3000);
    </script>
</body>

</html>