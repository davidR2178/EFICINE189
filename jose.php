<?

//iniciamos una sesión
session_start();

//Nos conectamos a la base de datos
if (!($link=mysql_connect("localhost","elkinkon","4Hf3>6a*Fuk")))

   {

      echo "Error conectando a la base de datos.";

      exit();

   } 

mysql_set_charset('utf8');

//Seleccionamos la base de datos
    if (!mysql_select_db("AVANTI_PICTURES",$link))

   {

      echo "Error seleccionando la base de datos.";

      exit();

   }
   
//Averiguamos el usuario a través del mail especificado en la pagina de entrada   
   $mail=urldecode($_GET['email']);
   
   if($mail=="david@avantipictures.com")
		{
			$uid="4";
		}
	if($mail=="jose@avantipictures.com")
		{
			$uid="3";
		}
//Averiguamos la sesion guardada para el usuario   
   	$sql_1="SELECT phpsessid, id FROM `usuarios` WHERE email='".$mail."'";
   
   	$resultw=mysql_fetch_array(mysql_query($sql_1), MYSQL_ASSOC);

//Si la sesión guardada es la sesión activa, entonces damos acceso a la lista y sus funciones
   
	if($resultw['phpsessid']==session_id()){ 








							
							$sql="SELECT id, empresa, contacto, telefono, ext, mail, notas, prioridad FROM `publicidad` WHERE uid=".$uid." AND unpublish=0  ";
						$result=mysql_query($sql);
						$conjunto=array();
						$cont=0;

						while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
							$cont++;
							
							if($row['prioridad']!='0'){$color="style='background-color:#".$row['prioridad'].";'";}
						else{	
						if($cont%2==0)
							{$color="style='background-color:#fff;'";}
						else
							{$color="style='background-color:#D8D8D8;'";}; 
						}
	
							array_push($conjunto, "
							<tr id='".$cont."' ".$color.">
								<td>".$cont."</td>
								<td id='".$row['empresa']."' style='padding:0px 5px;;' >
									<a>
										<div class='edit' style=' width:150px; height:100px;  vertical-align:middle;'>
											<span style='position:relative; top:40%;'>".$row['empresa']."</span>
										</div>
									</a>
								</td>
								<td id=''>".$row['contacto']."</td>
								<td id=''>".$row['telefono']."</td>
								<td id=''>".$row['ext']."</td>
								<td id=''>".$row['mail']."</td>
								<td>
									<div style='height:100px; overflow:auto;'>".$row['notas']."</div>
								</td>
								
						</tr>");
							}
							
							
							


?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Jos&eacute; | Empresas 189</title>
</head>

<body>
<TABLE class="todas-empresas" border="1">
<thead>
<TR>
<th>ID</th><th>Empresa</th><th>Contacto</th><th>Telefono</th><th>Ext.</th><th>Mail</th><th>Notas</th>
</tr></thead><tbody>
<? foreach($conjunto as $key=>$value){echo ($value);};
?></tbody>
   </TABLE>
   </body>
</html>
   
<?

}else{echo "No puedes acceder sin credenciales";}
?>