<?php
require "./vendor/autoload.php";

use App\Crud\DB;


$db = new DB();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario con Tailwind CSS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
<div class="w-full max-w-sm bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-semibold text-gray-700 text-center mb-4">Formulario</h2>
    <form action="#" method="POST">
        <!-- Campo Nombre -->
        <div class="mb-4">
            <label for="nombre" class="block text-sm font-medium text-gray-600">Nombre</label>
            <input type="text" id="nombre" name="nombre"
                   class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                   placeholder="Introduce tu nombre">
        </div>

        <!-- Campo Contraseña -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-600">Contraseña</label>
            <input type="password" id="password" name="password"
                   class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                   placeholder="Introduce tu contraseña">
        </div>

        <!-- Botón Enviar -->
        <div class="flex flex-row justify-around">
            <input type="submit"
                    class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                value= "Login" name="submit" />
            <input type="submit"
                    class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                value= "Register" name="submit" />
            </input>

        </div>
    </form>
</div>
</body>
</html>
