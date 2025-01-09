<?php
namespace App\Crud;

use mysqli;
use mysqli_sql_exception;

class DB
{

   private $con;

   public function __construct()
   {
      $host=$_ENV['HOST'];
      $user=$_ENV['USER'];
      $pass=$_ENV['PASSWORD'];
      $db=$_ENV['DATABASE'];

      try {
         $this->con=new mysqli($host, $user, $pass, $db);

      } catch (mysqli_sql_exception $e) {
         die ("Error accediendo a la base de datos " . $e->getMessage());
      }
   }

   public function validar_usuario($nombre, $pass)
   {
      // Verificar la conexión antes de ejecutar
      if (!$this->con) {
         return false;
      }

      // Inicializamos la sentencia
      $stmt=$this->con->prepare("SELECT * FROM usuarios WHERE nombre = ? AND password = ?");
      if (!$stmt) {
         die("Error al preparar la sentencia: " . $this->con->error);
      }

      // Asociar parámetros
      $stmt->bind_param('ss', $nombre, $pass);

      // Ejecutar la sentencia
      $stmt->execute();

      // Obtener los resultados
      $result=$stmt->get_result();

      // Verificar si hay filas
      if ($result->num_rows > 0) {

         return true;
      } else {

         return false;
      }

      // Cerrar la sentencia y conexión (buena práctica)
      $stmt->close();

   }

   public function registrar_usuario($nombre, $pass)
   {
      if (!$this->con) {
         return false;
      }
      $stmt=$this->con->prepare("INSERT INTO usuarios (nombre, password) VALUES (?, ?)");
      $stmt->bind_param('ss', $nombre, $pass);
      $stmt->execute();
      return $stmt->affected_rows > 0 ? true : false;
      $stmt->close();


   }

   public function obtener_campos($table)
   {
      if (!$this->con) {
         return false;
      }
      $stmt=$this->con->prepare("DESCRIBE $table");
      $stmt->execute();
      $result=$stmt->get_result();
      if ($result->num_rows > 0) {
         foreach ($result as $row) {
            $campos[]=$row['Field'];

         }
         return $campos;
      }
   }

   public function obtener_filas($table)
   {
      if (!$this->con) {

      }
      $stmt=$this->con->prepare("select * from $table");
      $stmt->execute();
      $result=$stmt->get_result();
      if ($result->num_rows > 0) {
         foreach ($result as $row) {
            $filas[]=$row;

         }
      }
      return $filas;
   }

   public function borrar_fila($table, $cod)
   {
      if (!$this->con) {
         return false;
      }
try{
      $stmt=$this->con->prepare("DELETE FROM $table WHERE cod = ?");
      $stmt->bind_param('s', $cod);
      $stmt->execute();
      return $stmt->affected_rows > 0 ? true : false;
   }
      catch(mysqli_sql_exception $e){
         return false;
      }
   }
}

?>
