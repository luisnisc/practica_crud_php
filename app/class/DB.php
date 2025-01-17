<?php
namespace App\Crud;

use mysqli;
use mysqli_sql_exception;
use mysqli_stmt;

class DB
{

   private $con;

   public function __construct()
   {
      $host=$_ENV['HOST'];
      $user=$_ENV['DB_USER'];
      $pass=$_ENV['PASSWORD'];
      $db=$_ENV['DATABASE'];
      try {
         $this->con=new mysqli($host, $user, $pass, $db);

      } catch (mysqli_sql_exception $e) {
         die ("Error accediendo a la base de datos " . $e->getMessage());
      }
   }



   /**
    * @param string $nombre
    * @param string $pass
    * @return bool
    * //Verifica si un usuario existe en la base de datos
    */
   public function validar_usuario(string $nombre, string  $pass):bool
   {
      // Verificar la conexión antes de ejecutar
      if (!$this->con) {
         return false;
      }

   }
/*
 * Este método tendría que investigar en el diccionario de datos
 * Devolverá qué campos de esta tabla son claves foráneas
 * */
   public function get_foraneas(string $tabla): array
   {
   }


   public function get_campos(string $table):array
   {
      $campos = [];
      if (!$this->con) {
         return false;
      }

         return $campos;

   }

   // Retorna un array con las filas de una tabla
   public function get_filas(string $sentencia):array
   {
      $filas=[];
      if (!$this->con) {
         return false;
      }

      return $filas;
   }

   //Borra una fila de una tabla dada su código
   //Retorna un mensaje diciendo si lo ha podido borrar o no
   public function borrar_fila(string $table,int $cod):string
   {
      if (!$this->con) {
         return "Error en la conexión";
      }

   }

   public function close()
   {
      $this->con->close();
   }

   // Añade una fila cuyos valores se pasan en un array.
   //Tengo el nombre de la tabla y el array ["nombre_Campo"=>"valor"]
   public function add_fila(string $tabla,array $campos){


      if (!$this->con) {
         return false;

      }

   }

   //Registra un usuario en la tabla usuarios y me pasan el nombre y el pass
   //El pass tiene que estar cifrado antes de insertar
   //Retorna un bool = true si ha ido bien o un mensaje si ha ocurrdio algún problema, como que el usuario ya existiese
   public function registrar_usuario($nombre, $pass): bool|string
   {
      if (!$this->con) {
         return false;
      }



   }

   //Verifica si un usuario existe o no
   private function existe_usuario(string $nombre):bool
   {

   }

   //Ejecuta una sentencia y retorna un mysql_stmt
   //La sentencia hay que paraemtrizarla
   //Recibo la sentencia con parámetros y un array indexado con los valores
   private function ejecuta_sentencia(string $sql, array $datos): mysqli_stmt
   {
      $stmt=$this->con->stmt_init();





      return $stmt;
   }

}

?>
