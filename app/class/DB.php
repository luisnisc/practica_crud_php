<?php
namespace App\Crud;

use mysqli;
use mysqli_sql_exception;

class DB
{

   private $con;

   public function __construct()
   {
      /*Usa $_ENV para acceder a los valores del fichero .env */
      $host=$_ENV['HOST'];
      // ....

   }

}

?>
