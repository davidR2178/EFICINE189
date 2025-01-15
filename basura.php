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
			$uid="3";
		}
	if($mail=="jose@avantipictures.com")
		{
			$uid="4";
		}
//Averiguamos la sesion guardada para el usuario   
   	$sql_1="SELECT phpsessid, id FROM `usuarios` WHERE email='".$mail."'";
   
   	$resultw=mysql_fetch_array(mysql_query($sql_1), MYSQL_ASSOC);

//Si la sesión guardada es la sesión activa, entonces damos acceso a la lista y sus funciones
   
	if($resultw['phpsessid']==session_id()){ 







$sql="SELECT id, empresa, contacto, telefono, ext, mail, notas FROM `publicidad` WHERE unpublish=1 ";

						$result=mysql_query($sql);
						$conjunto=array();
						$cont=0;

						while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
							$cont++;
							
							array_push($conjunto, "<td><table><tr><td><button onclick=catalogar(3,".$row['id'].")>Rodrigo</button></td</tr><tr><td><button onclick=catalogar(4,".$row['id'].")>Chepe</button></td></tr><tr><td><button onclick=catalogar(5,".$row['id'].")>Yossy o Jack</button></td></tr><tr><td><button onclick=unpublish(".$row['id'].") >Unpublish</button></td></tr><tr><td><a href='editar_empresa_publicidad.php?id=".$row['id']."&email=".urlencode($_GET['email'])."'>Editar</a></td></tr></table></td><td id='".$cont."+probando'>".$row['empresa']."</td><td id=''>".$row['contacto']."</td><td id=''>".$row['telefono']."</td><td id=''>".$row['ext']."</td><td id=''>".$row['mail']."</td><td><div style='height:100px; overflow:auto;'>".$row['notas']."</div></td><td></td>");
							}
							
							
							
						



?>
<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">

<title>Basura | Empresas 189</title>

<script>
	function catalogar(uid,id){ 
		
		alert(uid+","+id);
		
			var xmlhttp;
		
		if (window.XMLHttpRequest)
		
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		
		  xmlhttp=new XMLHttpRequest();
		
		  }
		
		else
		
		  {// code for IE6, IE5
		
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		
		  }
		
		xmlhttp.onreadystatechange=function()
		
		  {
		
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		
			{
		
			alert("El elemento "+xmlhttp.responseText+" ha sido asignado a la lista del usuario.")
		
			}
		
		  }
		
		xmlhttp.open("GET","catalogar_registro.php?uid="+uid+"&id="+id,true);
		
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		
		xmlhttp.send();
}
</script>

</head>

<body>
<TABLE class="todas-empresas" border="1">
<thead>
<TR>
<th>ID</th><th>Editar</th><th>Empresa</th><th>Contacto</th><th>Telefono</th><th>Ext.</th><th>Mail</th><th>Notas</th><th>Unpublish</th>
</tr></thead><tbody>
<? foreach($conjunto as $key=>$value){echo ("<tr><td>".++$key."</td>".$value."</tr>");};
?></tbody>
   </TABLE>
   </body>
</html>
   
<?

}
else{echo "No puedes acceder sin credenciales";}
?>