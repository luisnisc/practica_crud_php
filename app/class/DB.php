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
      if (!$this->con) {
         return false;
      }
      $sql = "SELECT password FROM usuarios WHERE nombre=?";
      $stmt = $this->con->stmt_init();
      $stmt->prepare($sql);
      $stmt->bind_param("s", $nombre);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows === 0) {
         $stmt->close();
         return false;
      }
      $stmt->bind_result($hash);
      $stmt->fetch();
      $stmt->close();
      return password_verify($pass, $hash);
   }
/*
 * Este método tendría que investigar en el diccionario de datos
 * Devolverá qué campos de esta tabla son claves foráneas
 * */
public function get_foraneas(string $tabla): array
{
    $foraneas = [];
    if ($tabla === 'producto') {
        $sql = "SELECT cod, nombre FROM familia ORDER BY nombre";
        $result = mysqli_query($this->con, $sql);
        if ($result) {
            $familias = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $familias[$row['cod']] = $row['nombre'];
            }
            $foraneas['familia'] = $familias;
        }
    }
    return $foraneas;
}


   public function get_campos(string $table): array
   {
      $campos = [];
      if (!$this->con) {
         return false;
      }
      $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME=? ORDER BY ORDINAL_POSITION";
      $stmt = $this->con->stmt_init();
      $stmt->prepare($sql);
      $stmt->bind_param("s", $table);
      $stmt->execute();
      $stmt->bind_result($column_name);
      while ($stmt->fetch()) {
         $campos[] = $column_name;
      }
      $stmt->close();
      
      return $campos;
   }

   // Retorna un array con las filas de una tabla
   public function get_filas(string $sentencia):array
{
   $filas = [];
   if (!$this->con) {
      return [];
   }
   $sentencia = "SELECT * FROM $sentencia";
   $result = mysqli_query($this->con, $sentencia);
   if($result){
      while($row = mysqli_fetch_assoc($result)){
         $filas[] = $row;
      }
   }
   return $filas;
}

   //Borra una fila de una tabla dada su código
   //Retorna un mensaje diciendo si lo ha podido borrar o no
   public function borrar_fila(string $table,int $cod):string
   {
      if (!$this->con) {
         return "Error en la conexión";
      }else{
         $sql="DELETE FROM $table WHERE cod=?";
         $stmt=$this->con->stmt_init();
         $stmt->prepare($sql);
         $stmt->bind_param("i",$cod);
         $stmt->execute();
         $stmt->close();
         return "Fila borrada";
      }

   }

   public function close()
   {
      $this->con->close();
   }

   // Añade una fila cuyos valores se pasan en un array.
   //Tengo el nombre de la tabla y el array ["nombre_Campo"=>"valor"]
   public function add_fila(string $tabla, array $campos)
   {
      if (!$this->con) {
         return false;
      }
      
      if (empty($campos)) {
         return "No se proporcionaron datos para insertar";
      }

      // Extraer nombres y valores
      $nombres = array_keys($campos);
      $valores = array_values($campos);

      // Crear la parte de los campos y placeholders
      $camposList = implode(', ', $nombres);
      $placeholders = implode(', ', array_fill(0, count($valores), '?'));

      // Consulta dinámica
      $sql = "INSERT INTO $tabla ($camposList) VALUES ($placeholders)";
      
      $stmt = $this->con->prepare($sql);
      if(!$stmt) {
         return $this->con->error;
      }

      // Crear la cadena de tipos, asumiendo que todos los valores son strings
      $types = str_repeat('s', count($valores));

      // Pasar los parámetros por referencia
      $stmt->bind_param($types, ...$valores);
      $stmt->execute();
      $stmt->close();

      return "Fila agregada";
   }

   //Registra un usuario en la tabla usuarios y me pasan el nombre y el pass
   //El pass tiene que estar cifrado antes de insertar
   //Retorna un bool = true si ha ido bien o un mensaje si ha ocurrdio algún problema, como que el usuario ya existiese
   public function registrar_usuario($nombre, $pass): bool|string
   {
      if (!$this->con) {
         return false;
      }else{
         $hash = password_hash($pass, PASSWORD_DEFAULT);
         if ($this->existe_usuario($nombre)) {
            return "El usuario ya existe";
         }else{
            $sql="INSERT INTO usuarios (nombre, password) VALUES (?,?)";
            $stmt=$this->con->stmt_init();
            $stmt->prepare($sql);
            $stmt->bind_param("ss",$nombre,$hash);
            $stmt->execute();
            $stmt->close();
            return true;
         }
      }



   }

   //Verifica si un usuario existe o no
   public function existe_usuario(string $nombre):bool
   {
      $sql="SELECT * FROM usuarios WHERE nombre=?";
      $stmt=$this->con->stmt_init();
      $stmt->prepare($sql);
      $stmt->bind_param("s",$nombre);
      $stmt->execute();
      $stmt->store_result();
      $num=$stmt->num_rows;
      $stmt->close();
      return $num>0;

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
