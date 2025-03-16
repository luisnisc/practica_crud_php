<?php

require __DIR__ . '/vendor/autoload.php';
session_start();

use Dotenv\Dotenv;
use App\Crud\DB;
use App\Crud\Plantilla;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = new DB();
$tabla = $_SESSION['tabla'] ?? '';

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
} else if ($tabla == '') {
    header('Location: sitio.php');
}
$username = $_SESSION['username'];
$tabla = $_SESSION['tabla'];
$campos = $db->get_campos($tabla);
$filas = $db->get_filas($tabla);
$foraneas = $db->get_foraneas($tabla);
$html = Plantilla::get_tabla($campos, $filas);

if (isset($_POST['submit'])) {
    switch ($_POST['submit']) {
        case 'Logout':
            session_destroy();
            header('Location: index.php');
            break;
        case 'Volver':
            $_SESSION['tabla'] = '';
            header('Location: sitio.php');
            exit;
        case 'Agregar':
            header('Location: add.php');
            exit;
        case 'Borrar':
            $cod = $_POST['cod'] ?? '';
            $db->borrar_fila($tabla, (int)$cod);
            header('Location: listado.php');
            exit;
    }
}


?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <h1>Listado del contenido de tablas</h1>
    <h2>Conectado como: <?= $username ?></h2>
    <h2>Tabla: <?= $tabla ?></h2>
    <form action="listado.php" method="post">
        <input class="btn btn - logout" type="submit" value="Logout" name="submit">
        <input type="submit" value="Volver" name="submit">
        <input type="submit" value="Agregar" name="submit">
    </form>
    <?php
    if (isset($html)) {
        echo $html;
    }

    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Confirmación para el borrado
      document.querySelectorAll('.delete-button').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
          e.preventDefault();
          var form = this.closest('form');
          Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            background: '#1e1e1e',
            color: '#e0e0e0',
            showCancelButton: true,
            confirmButtonColor: '#ff4081',
            cancelButtonColor: '#272727',
            confirmButtonText: 'Sí, borrar',
            cancelButtonText: 'Cancelar'
          }).then(function(result) {
            if (result.isConfirmed) {
              // Forzar el envío del formulario usando la función nativa
              HTMLFormElement.prototype.submit.call(form);
            }
          });
        });
      });

      // Alerta de éxito para agregar una fila
      const params = new URLSearchParams(window.location.search);
      if (params.get('success') === 'add') {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'success',
          title: 'La fila se añadió correctamente',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          background: '#1e1e1e',
          color: '#e0e0e0'
        });
      }
    });
    </script>
</body>

</html>