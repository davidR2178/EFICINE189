<?php	
// Esta es la nueva funcion msqli que reemplaza a msql, para las funciones de base de datos.
$mysqli=new mysqli("localhost","elkinkon","4Hf3>6a*Fuk","AVANTI_PICTURES");

   if ($mysqli->connect_errno) {
    echo "Fallo al contenctar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
   $mysqli->set_charset("utf8");
   
   $sql_b="SELECT id,id_contacto FROM `contactos`";
   
   $result=$mysqli->query($sql_b);
   
   $row = $result->fetch_array(MYSQLI_ASSOC);
   
   $cont=1;

						while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
							$cont++;
							$sql_c="UPDATE contactos SET id_contacto=".$cont." WHERE id=".$row['id']."";
							$mysqli->query($sql_c);
							
							}
?>