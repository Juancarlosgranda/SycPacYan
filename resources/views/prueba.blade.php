<?php
//Creamos el archivo datos.txt
//ponemos tipo 'a' para añadir lineas sin borrar
$file=fopen("datos.txt","a") or die("Problemas");
  //vamos añadiendo el contenido
  fputs($file,"primera linea");
  fputs($file,'\n');
  fputs($file,"segunda linea");
  fputs($file,'\n');
  fputs($file,"tercera linea");
  fclose($file);

?>