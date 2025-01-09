<?php
namespace App\Crud;

class Plantilla
{
   const ADD =<<<FIN
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v6m3-3H9m4.06-7.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
</svg>
FIN;

   const BORRAR =<<<FIN
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
</svg>
FIN;

   public static function generar_tabla($campos, $filas)
   {
      $borrar = self::BORRAR;
      $add = self::ADD;
      $tabla=<<<FIN
<div class="overflow-x-auto px-4">
  <div class="max-w-[80vw] mx-auto">
    <table class="table table-xs table-pin-rows table-pin-cols w-auto">
    <thead>
   <tr>
FIN;

      foreach ($campos as $campo)
         $tabla.="<th>$campo</th>\n";

      $tabla.=<<<FIN
</tr>\n
   </thead>\n
   <tbody>\n
FIN;

      foreach ($filas as $fila) {
         $tabla.="<tr><form action='listado.php' method='post'>\n";

         foreach ($fila as $campo=> $valor) {
            $hidden="";
            if ($campo=="cod")
               $hidden="<input type='hidden' name='cod' value='$valor'>\n>";
            $tabla.="<td>$valor $hidden</td>\n";
         }

         $tabla.=<<<FIN
<td>
<button type="submit" name="del" class="btn-icon">
$borrar
</button>
</td>
<td>
<button type="submit" name="add" class="btn-icon">
$add
</button>
</td>

</form>
FIN;
         $tabla.=<<<FIN
<td></td>
FIN;
      }


      $tabla.="</tr>\n";
      $tabla.="</tbody>\n";
      $tabla.="</table>";
      return $tabla;
   }
}
?>
