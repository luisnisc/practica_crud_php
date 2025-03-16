<?php
session_start();
if(!isset($_SESSION['username'])){
    header('Location: index.php');
}

$username = $_SESSION['username'] ?? '';

if(isset($_POST['submit'])){
switch($_POST['submit']){
    case 'Logout':
        session_destroy();
        header('Location: index.php');
        break;
    case 'Productos':
        $_SESSION['tabla'] = 'producto';
        header('Location: listado.php');
        break;
    case 'Tiendas':
        $_SESSION['tabla'] = 'tienda';
        header('Location: listado.php');
        break;
    case 'Usuarios':
        $_SESSION['tabla'] = 'usuarios';
        header('Location: listado.php');
        break;
    case 'Stock':
        $_SESSION['tabla'] = 'stock';
        header('Location: listado.php');
        break;
}

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF - 8">
    <meta name="viewport" content="width=device - width, initial - scale=1.0">
    <title>Admin Panel</title>

<link rel="stylesheet" href="estilos.css">
</head>
<body>
<h1>Admin Panel</h1>
<div>
    <form action="sitio.php" method="post">
        <div >
            Conectado como <?= $username ?>  
        </div>
        <hr/>
        <input class="btn btn - logout" type="submit" value="Logout" name="submit">
        <input class="btn btn - create" type="submit" value="Productos" name="submit">
        <input class="btn btn - edit" type="submit" value="Tiendas" name="submit">
        <input class="btn btn - delete" type="submit" value="Usuarios" name="submit">
        <input class="btn btn - create" type="submit" value="Stock" name="submit">

    </form>

</div>
<div id="content">
    <p>Selecciona una opción para gestionar los elementos de la tienda.</p>
</div>
</body>
</html>
