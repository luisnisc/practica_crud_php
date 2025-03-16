<?php
require_once 'vendor/autoload.php';
use App\Crud\DB;
use App\Crud\Plantilla;

$tabla = $_SESSION['tabla'] ?? '';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$db = new DB();

session_start();
if(!isset($_SESSION['username'])){
    header('Location: index.php');
}else if(!isset($_SESSION['tabla']) || $_SESSION['tabla'] == ''){
    header('Location: sitio.php');
}
$username = $_SESSION['username'];
$tabla = $_SESSION['tabla'];
$campos = $db->get_campos($tabla);
$foraneas = $db->get_foraneas($tabla);

$html = Plantilla::get_formulario($campos, $foraneas, $db);

if(isset($_POST['submit'])){
    switch($_POST['submit']){
        case 'Agregar':
            $valores = [];
            foreach ($campos as $campo) {
                if (isset($_POST[$campo])) {
                    $valores[$campo] = $_POST[$campo];
                }
            }
            $db->add_fila($tabla, $valores);
            header('Location: listado.php?success=add');
            break;
        case 'Cancelar':
            header('Location: listado.php');
            break;
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
</head>
<body>

<h1>Añadir registro a la tabla:<?= $tabla ?></h1>

<?= $html ?>
</body>
</html>
