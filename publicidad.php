<?php
//iniciamos una sesión
session_start();
$es_movil = '0';
if(preg_match('/(android|wap|phone|ipad)/i',strtolower($_SERVER['HTTP_USER_AGENT']))){
    $es_movil++;
}

//--------------------------------------------------------------------------------------------------------------------------
// VERSIÓN PARA TABLETS Y CELULARES  -------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------


if($es_movil>0){
	
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
		if($mail=="araceli@avantipictures.com")
		{
			$uid="8";
		}
//Averiguamos la sesion guardada para el usuario   
   	$sql_1="SELECT phpsessid, id FROM `usuarios` WHERE email='".$mail."'";
   
   	$resultw=mysql_fetch_array(mysql_query($sql_1), MYSQL_ASSOC);

//Si la sesión guardada es la sesión activa, entonces damos acceso a la lista y sus funciones
   
	if($resultw['phpsessid']==session_id()){ 

   
	//En caso de recibir actualizacion de ulguna empresa desde editar_empresa.php (hay que checar si es posible no volver a conectar a la db)(en caso de una actualización, encrementar el registro de actualizaciones)
	if($_POST['id']){
		
		 if (!($link=mysql_connect("localhost","elkinkon","4Hf3>6a*Fuk")))
	
		   {
		
			  echo "Error conectando a la base de datos.";
		
			  exit();
		
		   } 
	
	mysql_set_charset('utf8');
    
	if (!mysql_select_db("AVANTI_PICTURES",$link))

	   {
	
		  echo "Error seleccionando la base de datos.";
	
		  exit();
	
	   } 
	//Actualizamos los datos del registro 
	if($_POST['notas'] != date("d.m.Y")){$notas="".$_POST['notas']."<br/><hr/>";}else{$notas="";}
	$sql="UPDATE publicidad SET empresa='".$_POST['empresa']."' ,contacto='".$_POST['contacto']."' ,telefono='".$_POST['telefono']."' ,ext='".$_POST['ext']."' ,mail='".$_POST['mail']."' ,notas='".$notas."".$_POST['notas_pasadas']."' WHERE id=".$_POST['id']."";
		
	mysql_query($sql);
	 }
	 
//En caso de registrar una nueva empresa desde publicidad.php(incrementar el contador de nuevas emrpesas)
	if($_POST['nueva']=='1'){
		
		if (!($link=mysql_connect("localhost","elkinkon","4Hf3>6a*Fuk")))

		   {
		
			  echo "Error conectando a la base de datos.";
		
			  exit();
		
		   } 
		mysql_set_charset('utf8');
		
		if (!mysql_select_db("AVANTI_PICTURES",$link))

		   {
		
			  echo "Error seleccionando la base de datos.";
		
			  exit();
		
		   } 
	 	//Insertamos el nuevo registro
	 	$sql_b="INSERT INTO publicidad(empresa,contacto,telefono,ext, mail, notas,uid) values('".$_POST['empresa']."','".$_POST['contacto']."','".$_POST['telefono']."','".$_POST['ext']."','".$_POST['mail']."','".$_POST['notas']."','".$uid."')";

		mysql_query($sql_b);
						
	 }

 
	//Para desplegar la lista en caso de no que no se tenga una nueva o se tenga que actualizar alguna empresa
	//Averiguar si estas variables se pueden tomar de más arriba
	if($mail=="david@avantipictures.com")
		{
			$uid="3";
			$name="Rodrigo";
			$sql_b="SELECT id, empresa, prioridad, fecha FROM `publicidad` WHERE uid=3 OR uid=4 AND unpublish=0 ORDER BY prioridad DESC,fecha DESC ";

		
		}
	if($mail=="jose@avantipictures.com")
		{
			$uid="4";
			$name="José";
			$sql_b="SELECT id, empresa, contacto, telefono, ext, mail, notas, prioridad, fecha FROM `publicidad` WHERE uid=".$uid." AND unpublish=0 ORDER BY prioridad DESC,fecha DESC ";

		}
		
		if($mail=="araceli@avantipictures.com")
		{
			$uid="8";
			$name="Araceli";
			$sql_b="SELECT id, empresa, contacto, telefono, ext, mail, notas, prioridad, fecha FROM `publicidad` WHERE uid=".$uid." AND unpublish=0 ORDER BY prioridad DESC,fecha DESC ";

		}
	
  
//Se extraen sólo los registros asignados al usuario de la sesion y que no han sido despuplicados	

						$result=mysql_query($sql_b);
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
								<td onclick='color(".$cont.",".$row['id'].")'>".$cont."</td>
								<td id='".$row['empresa']."' style='padding:0px 5px;' >
									<a href='editar_empresa_publicidad.php?id=".$row['id']."&email=".urlencode($_GET['email'])."'>
										<div class='edit' style='height:150px;  vertical-align:middle;'>
											<span style='position:relative; top:35%; padding:10px;'>".$row['empresa']."</span>
										</div>
									</a>
								</td>
								
								
						</tr>");
							}
							
							
			if($mail=="yossy@avantipictures.com")
		{
			// $uid="4";
			$name="Yossy";
			//Se extraen sólo los registros asignados al usuario de la sesion y que no han sido despuplicados	
	$sql_b="SELECT id, empresa, contacto, telefono, ext, mail, notas FROM `publicidad` WHERE uid>=3 AND unpublish=0 ";

						$result=mysql_query($sql_b);
						$conjunto=array();
						$cont=0;

						while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
							$cont++;
							
							array_push($conjunto, "<td><a href=#>Editar</a></td><td id='".$cont."+probando'>".$row['empresa']."</td><td id=''>".$row['contacto']."</td><td id=''>".$row['telefono']."</td><td id=''>".$row['ext']."</td><td id=''>".$row['mail']."</td><td><div style='height:100px; overflow:auto;'>".$row['notas']."</div></td><td><button onclick='unpublish(".$row['id'].")'>Eliminar</button></td>");
							}
		}				
							
	?>
<!doctype html>
<html lang="es">
<head>
<meta http-equiv="content-type" content="text/html" charset="UTF-8">
<title><?php echo $name?> | Empresas 189</title>
  
<script>

function nueva_empresa(){ 
	alert(empresa.value);

	document.getElementById('agregar').submit();
}

function unpublish(id){ 
	alert(empresa.value);

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
		
			alert("El elemento "+xmlhttp.responseText+" ha sido despublicado.")
		
			}
		
		  }
		
		xmlhttp.open("POST","unpublish_publicidad.php?id="+id,true);
		
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		
		xmlhttp.send();
}


var xy=0;
var b=0;
function color(a,z){ 
	
	
	switch(xy){
		case 0: xy++; document.getElementById(a).style.backgroundColor='#F5A9A9'; db_color(z,"f5a9a9");
				b=a; 
		break;
		
		case 1: if(b==a){xy++; document.getElementById(a).style.backgroundColor='#0BB';db_color(z,"0BB");  }
				 else{xy=0; color(a,z);}
		break;
		case 2: if(b==a){xy++; document.getElementById(a).style.backgroundColor='#BB66BB';db_color(z,"BB66BB");}
				 else{xy=0; color(a,z);}
		break;
		case 3: if(b==a){xy++; document.getElementById(a).style.backgroundColor='#99ffff';db_color(z,"99ffff");}
				 else{xy=0;color(a,z);}
		break;
		case 4: if(b==a){xy++; document.getElementById(a).style.backgroundColor='#ffcc00';db_color(z,"ffcc00");}
				 else{xy=0;color(a,z);}
		break;
		case 5: if(b==a){xy++; document.getElementById(a).style.backgroundColor='#ff3333';db_color(z,"ff3333");}
				 else{xy=0;color(a,z);}
		break;
		
		case 6: if(b==a){xy++; document.getElementById(a).style.backgroundColor='#D8D8D8';db_color(z,"0");}
				 else{xy=0;color(a,z);}
		break;
		case 7: if(b==a){xy=0; document.getElementById(a).style.backgroundColor='#Fff';db_color(z,"0");}
				 else{xy=0;}
		break;
		
		}
	
	}
	

	
function db_color(id,color){ 
		
		
		
			
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
		
			
		
			}
		
		  }
		
		xmlhttp.open("GET","cambiar_color.php?id="+id+"&color="+color,true);
		
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		
		xmlhttp.send();
}
</script>
<style> 
html{ font-size:45px;}
.nueva-empresa input{ height:20px;} .nueva-empresa td{ height:25px;} .todas-empresas td{ padding:10px; } .todas-empresas th{ background:#CCC;}  </style>
<style>
a:link{ text-decoration:none; color:#000; font-size:45px; }
a:visited{ text-decoration:none; color:#000; font-size:45px; }
.boton-superior{ position:relative; float:left; width:20%; height:100px; background-color:#CCFF33; color:#0000FF; font-size:40px;}
.boton-superior:hover{ background-color: #66CC00}
.edit:hover{ background-color:#999999}
</style>
</head>

<body style="font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif">
	
    <div id="confirmacion" style="position:relative;  z-index:1000; top:0px; left:0px; right:0px; height:100px; background:#999; margin-bottom:0px;">
        
        <?php if($uid==4){
			?>
            <a href="papeleria.php?email=<?php echo urlencode($_GET['email']);?>" target="_blank" ><button class="boton-superior" style="cursor:pointer">Alianzas</button>	</a>
        <button class="boton-superior"><a href="rodrigo.php?email=<?php echo urlencode($_GET['email']);?>" target="_blank" >Rodrigo</a></button>
        <?php } if($uid==3 || $uid==8){
			?>
        
        <a href="majors.php?email=<?php echo urlencode($_GET['email']);?>"  ><button class="boton-superior" style="cursor:pointer">Aportantes</button>	</a>
        <a href="proyectos_alta.php?email=<?php echo urlencode($_GET['email']);?>" ><button class="boton-superior" style="cursor:pointer">Pel&iacute;culas</button></a>	
      
        <a href="papeleria.php?email=<?php echo urlencode($_GET['email']);?>" target="_blank" ><button class="boton-superior" style="cursor:pointer">Alianzas</button>	</a>
          <a href="/eficine" ><button class="boton-superior" style="cursor:pointer">Salir</button></a>
        
        <?php } else{
			?>
        <a href="jose.php?email=<?php echo urlencode($_GET['email']);?>" target="_blank"  ><button class="boton-superior" style="cursor:pointer">Jos&eacute;</button></a>	
        <?php }
		?>
<?php /*?>        <a href="basura.php?email=<? echo urlencode($_GET['email']);?>" target="_blank" ><button class="boton-superior" style="cursor:pointer">Basura</button>	</a>
<?php */?>        <a href="#arriba" ><button class="boton-superior" style="cursor:pointer">Subir</button></a>
        
    </div>
    <a id="arriba"></a>  
    
   
    <div style="position:relative; ">
        <TABLE class="todas-empresas" border="0" style="position:relative; left:-4px; " >
            <thead>
            <TR>
            <th>#</th><th>Empresa</th> </tr></thead>
            <tbody>
			<?php foreach($conjunto as $key=>$value)
					{	
						echo ($value);};
         ?></tbody>
        </TABLE>
       
</div>
   <script>
   if(screen.width<840){document.getElementByClass("todas_empresas").style.fontSize="24px";};
   </script>
</body>
   </html>
   
<?php } 

//En caso de que la sesion guardada no coincida con la sesión activa
	else{echo "".$mail." no puedes acceder sin credenciales <a href='/eficine'>Volver</a>"; }
   
   
		
}

//--------------------------------------------------------------------------------------------------------------------------------------------------
// VERSIÓN DE ESCRITORIO -------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------


else{
    

//Nos conectamos al servidor de base de datos
  $db_host = 'localhost';
  $db_user = 'root';
  $db_password = 'root';
  $db_db = 'AVANTI_PICTURES';
 
  $mysqli = new mysqli(
    $db_host,
    $db_user,
    $db_password,
    $db_db
  );
	
  if ($mysqli->connect_error) {
    echo 'Errno: '.$mysqli->connect_errno;
    echo '<br>';
    echo 'Error: '.$mysqli->connect_error;
    exit();
  }


   $mysqli->set_charset("utf8");
	
	
	//Averiguamos el usuario a través del mail especificado en la URL de la pagina de entrada   
   $mail=urldecode($_GET['email']);
   
   if($mail=="david@avantipictures.com"){
			$uid=3;
	}
	
	if($mail=="jose@avantipictures.com"){
			$uid=4;
	}
	
	if($mail=="araceli@avantipictures.com"){
			$uid=8;
	}
	
	//Averiguamos la sesion guardada para el usuario   
   	$sql_1="SELECT phpsessid, id FROM `usuarios` WHERE email='".$mail."'";
   
   	//$resultw=mysql_fetch_array(mysql_query($sql_1), MYSQL_ASSOC);
	
	$result_session=$mysqli->query($sql_1);
	
   		$resultw = $result_session->fetch_array(MYSQLI_ASSOC);

	//--------------------------------------------------------------------------------------------------------------------------------------------------
	//--Si la sesión guardada es la sesión activa, entonces damos acceso a las tablas de la base de datos y extraemos todos los datos requeridos--------
	//--------------------------------------------------------------------------------------------------------------------------------------------------
   
	if($resultw['phpsessid']==session_id()){ 
   
		//En caso de recibir actualizacion de ulguna empresa desde editar_empresa.php (hay que checar si es posible no volver a conectar a la db)
		if($_POST['id']){
		
			//Nos conectamos a la base de datos
	
			//Actualizamos los datos del registro
			//En caso de que haya una nueva nota. Si el contenido de la variables notas no es tan solo la fecha, entonces se actualiza el contenido de las notas en la bse de datos.
			 
			if($_POST['notas'] != date("d.m.Y")){
				$notas="".$_POST['notas']."<br/><hr/>";
				$sql="UPDATE publicidad SET avances=now(), fecha=now(), act=act + 1, empresa='".$_POST['empresa']."' ,contacto='".$_POST['contacto']."' ,telefono='".$_POST['telefono']."' ,ext='".$_POST['ext']."' ,mail='".$_POST['mail']."' ,notas='".$notas."".$_POST['notas_pasadas']."',giro='".$_POST['giro']."',recordatorio='".$_POST['datepicker']."',mapa='".$_POST['mapa']."' WHERE id=".$_POST['id']."";
			}
			//En caso de que no haya una nueva nota.Si el contenido de la variable notas es nada mas la fecha entonces la variable notas se pone vacia y las notas se actualizan solo con las ntas pasadas
			else{
				$notas="";
				$sql="UPDATE publicidad SET fecha=now(), act=act + 1, empresa='".$_POST['empresa']."' ,contacto='".$_POST['contacto']."' ,telefono='".$_POST['telefono']."' ,ext='".$_POST['ext']."' ,mail='".$_POST['mail']."' ,notas='".$notas."".$_POST['notas_pasadas']."',giro='".$_POST['giro']."',recordatorio='".$_POST['datepicker']."',mapa='".$_POST['mapa']."' WHERE id=".$_POST['id']."";
			}
			
		
			
			if(!$mysqli->query($sql)){printf("Errormessage: %s\n", $mysqli->error);}
			
		 }//Termina caso de recibir actualizacion de ulguna empresa desde editar_empresa.php (hay que checar si es posible no volver a conectar a la db)	 

	//En caso de registrar una nueva empresa desde publicidad.php
		if($_POST['nueva']=='1'){
		
			
			//Insertamos el nuevo registro
	 		$sql_b="INSERT INTO publicidad(empresa,contacto,telefono,ext, mail, notas,uid) values('".$_POST['empresa']."','".$_POST['contacto']."','".$_POST['telefono']."','".$_POST['ext']."','".$_POST['mail']."','".$_POST['notas']."','".$uid."')";
			
			$mysqli->query($sql_b);
			echo $mysqli->error;
		
						
	 	}//Termina caso de registrar una nueva empresa desde publicidad.php

		//Para desplegar las listas en caso de no que no se tenga una nueva o se tenga que actualizar alguna empresa
		if($mail=="david@avantipictures.com"){
				$uid="3";
				$name="Rodrigo";
				//encontrar que fecha fue el dia lunes de la semana actual para poder extraer las empresas que fueron contactadas durante la semana actual por una parte y por otra las de la semana anterior y manejar mejor el $sql_n y otro mas.
				//$thisweek=;
				$sql_b="SELECT id, empresa, prioridad, fecha FROM `publicidad` WHERE lista>=0 AND unpublish=0 AND uid>2  ORDER BY prioridad DESC,fecha DESC "; //Lista principal
				$sql_c="SELECT id, empresa, prioridad, fecha FROM `publicidad` WHERE lista=1 AND unpublish=0 AND uid>2  ORDER BY prioridad DESC,fecha DESC "; //Lista cuadro azul
				$sql_d="SELECT id, empresa, prioridad, fecha FROM `publicidad` WHERE today=CURRENT_DATE() LIMIT 20";												  //Lista triangulos
				$sql_e="SELECT id, empresa, prioridad, fecha FROM `publicidad` WHERE lista=2 AND unpublish=0 AND uid>2  ORDER BY prioridad DESC,fecha DESC "; //Lista cuadro rojo
				$sql_f="SELECT id, empresa, prioridad, fecha, recordatorio FROM `publicidad` WHERE fecha BETWEEN '2017-07-27' AND '2017-08-30' ORDER BY prioridad DESC "; //1er Grupo 
				$sql_g="SELECT id, empresa, prioridad, fecha FROM `publicidad` WHERE fecha=CURDATE() ORDER BY prioridad DESC"; //Lista de los actualizados en el dia actual
				$sql_h="SELECT id, empresa, prioridad, fecha FROM `publicidad` WHERE fecha=DATE_SUB(CURDATE(), INTERVAL 1 DAY) ORDER BY prioridad DESC"; //Lista de los actualizados del dia anterior
				$sql_i="SELECT id, empresa, prioridad, fecha FROM `publicidad` WHERE recordatorio=CURDATE()"; //Lista de los que tienen recordatorio para el dia de hoy
				$sql_j="SELECT id, empresa, prioridad, fecha FROM `publicidad` WHERE lista=3 AND unpublish=0 AND uid>2  ORDER BY prioridad DESC,fecha DESC "; //Lista cuadro rojo
				$sql_k="SELECT id, empresa, prioridad, fecha, recordatorio FROM `publicidad` WHERE fecha BETWEEN '2017-08-30' AND '2018-07-31' ORDER BY prioridad DESC "; //2º Grupo 
				$sql_l="SELECT id, empresa, prioridad, fecha FROM `publicidad` WHERE fecha=DATE_SUB(CURDATE(), INTERVAL 2 DAY)"; //Lista de los actualizados de antier
				$sql_m="SELECT id, empresa, prioridad, fecha FROM `publicidad` WHERE recordatorio=DATE_ADD(CURDATE(), INTERVAL 1 DAY)"; //Lista de los actualizados de antier
				$sql_n="SELECT id, empresa, prioridad, fecha FROM `publicidad` WHERE fecha BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE() ORDER BY prioridad DESC"; //Lista de los actualizados de antier. NO ESTA MUY BIEN ME GUSTARIA FUERA SOLO PARA LA SEMANA EN CURSO
				$sql_o="SELECT id, empresa, prioridad, fecha FROM `publicidad` WHERE fecha BETWEEN DATE_SUB(CURDATE(), INTERVAL 14 DAY) AND DATE_SUB(CURDATE(), INTERVAL 7 DAY) ORDER BY prioridad DESC"; //Lista de los actualizados de antier. NO ESTA MUY BIEN ME GUSTARIA FUERA SOLO PARA LA SEMANA EN CURSO
				$sql_u="SELECT id, empresa, prioridad, fecha FROM `publicidad` WHERE fecha BETWEEN DATE_SUB(CURDATE(), INTERVAL 21 DAY) AND DATE_SUB(CURDATE(), INTERVAL 14 DAY) ORDER BY prioridad DESC"; //Lista de los actualizados de antier. NO ESTA MUY BIEN ME GUSTARIA FUERA SOLO PARA LA SEMANA EN CURSO
				$sql_v="SELECT id, empresa, prioridad, fecha FROM `publicidad` WHERE fecha BETWEEN DATE_SUB(CURDATE(), INTERVAL 28 DAY) AND DATE_SUB(CURDATE(), INTERVAL 21 DAY) ORDER BY prioridad DESC"; //Lista de los actualizados de antier. NO ESTA MUY BIEN ME GUSTARIA FUERA SOLO PARA LA SEMANA EN CURSO
				$sql_w="SELECT id, empresa, prioridad, fecha FROM `publicidad` WHERE fecha BETWEEN DATE_SUB(CURDATE(), INTERVAL 35 DAY) AND DATE_SUB(CURDATE(), INTERVAL 28 DAY) ORDER BY prioridad DESC"; //Lista de los actualizados de antier. NO ESTA MUY BIEN ME GUSTARIA FUERA SOLO PARA LA SEMANA EN CURSO
				$sql_x="SELECT id, empresa, prioridad, fecha FROM `publicidad` WHERE fecha BETWEEN DATE_SUB(CURDATE(), INTERVAL 42 DAY) AND DATE_SUB(CURDATE(), INTERVAL 35 DAY) ORDER BY prioridad DESC"; //Lista de los actualizados de antier. NO ESTA MUY BIEN ME GUSTARIA FUERA SOLO PARA LA SEMANA EN CURSO
				$sql_p="SELECT id, empresa, prioridad, fecha FROM `publicidad` WHERE avances=CURDATE()"; //Lista de los avances del dia de hoy
				$sql_q="SELECT id, empresa, prioridad, fecha, recordatorio FROM `publicidad` WHERE fecha BETWEEN '2015-07-27' AND '2017-07-27' ORDER BY prioridad DESC "; //Los olvidados desde antes de julio 2017 
				$sql_r="SELECT id, empresa, prioridad, fecha, recordatorio FROM `publicidad` WHERE avances BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE() ORDER BY prioridad DESC "; //Los avances de la semana

				$sql_s="SELECT id, empresa, prioridad, fecha, recordatorio FROM `publicidad` WHERE fecha BETWEEN '2018-08-01' AND CURDATE() ORDER BY prioridad DESC "; //3º Grupo
				$sql_t="SELECT id, empresa, prioridad, fecha, recordatorio FROM `publicidad` WHERE mailed=1 ORDER BY prioridad DESC"; //maileds
		} 
		
		if($mail=="jose@avantipictures.com"){
			$uid="4";
			$name="José";
			$sql_b="SELECT id, empresa, contacto, telefono, ext, mail, notas, prioridad, fecha FROM `publicidad` WHERE uid=".$uid." AND unpublish=0 ORDER BY prioridad DESC,fecha DESC ";

		}
		
		if($mail=="araceli@avantipictures.com"){
			$uid="8";
			$name="Araceli";
			$sql_b="SELECT id, empresa, contacto, telefono, ext, mail, notas, prioridad, fecha FROM `publicidad` WHERE uid=".$uid." AND unpublish=0 ORDER BY prioridad DESC,fecha DESC ";

		}

	
  
		//Se extraen los registros de la lista principal asignados al usuario de la sesion y que no han sido despuplicados	
		
		
		
		$result=$mysqli->query($sql_b);
		$conjunto=array();
		$cont=0;

		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$cont++;
			if($row['prioridad']!='0'){
				$color="style='background-color:#".$row['prioridad']."; position:relative; width:421px; height:50px; margin:2px;'";
			}
			else{	
				if($cont%2==0){
					$color="style='background-color:#fff; position:relative; width:421px; height:50px; margin:2px;'";
				}
				else{
				$color="style='background-color:#D8D8D8; position:relative; width:421px; height:50px; margin:2px;'";
				}; 
			}

			array_push($conjunto, "
			<div class='drag' id='".$row['id']."' ".$color." >
			
				<div onclick='color(".$row['id'].",".$cont.")' style='position:relative; float:left; width:50px; height:50px;'>
					<span style='position:relative; top:40%;padding-left:10px;'>".$cont."
					</span>
				</div>
				
				<div id='".$row['empresa']."' style='padding:0px 5px;position:relative; float:left; ' >
					<a target='_blank' href='editar_empresa_publicidad.php?id=".$row['id']."&email=".urlencode($_GET['email'])."&q=".$row['empresa']."'>
						<div class='edit' style=' width:350px; height:50px;  '>
							<span style='position:relative; top:40%;'>".$row['empresa']."</span>
						</div>
					</a>
				</div>
				
				
				<!--<div style='position:relative; float:left; width:50px; height:50px;'>
					<button onclick='unpublish(".$row['id'].")' style='position:relative; float:left; width:50px; heigth:50px;top:40%; '>Eliminar</button>
				</div>-->
				
		</div>");
		}//terminan los registros de la lista principal asignados al usuario de la sesion y que no han sido despuplicados
								
	//Se extraen los registros de la lista del cuadro azul asignados al usuario de la sesion y que no han sido despuplicados
		$result_c=$mysqli->query($sql_c);
		$conjunto_c=array();
		$cont_c=0;

		while ($row_c = $result_c->fetch_array(MYSQLI_ASSOC)) {
			$cont_c++;
			if($row_c['prioridad']!='0'){
				$color="style='background-color:#".$row_c['prioridad']."; position:relative; float:left; width:50px; height:50px; margin:2px;'";
			}
			else{	
				if($cont_c%2==0){
					$color="style='background-color:#fff; position:relative; width:621px; height:50px; margin:2px;'";
				}
				else{
					$color="style='background-color:#D8D8D8; position:relative; width:621px; height:50px; margin:2px;'";
				}; 
			}

			array_push($conjunto_c, "
			<div title='".$row_c['empresa']."' class='drag' id='lista_".$row_c['id']."' ".$color." >
				<a ' target='_blank' href='editar_empresa_publicidad.php?id=".$row_c['id']."&email=".urlencode($_GET['email'])."&q=".$row_c['empresa']."'>
				<div style='position:relative; float:left; width:50px; height:50px;'><span style='position:relative; top:40%;padding-left:10px;'>".$cont_c."</span></div>
				
				</a>
				
				
				
		</div>");
		}//Terminan los registros de la lista del cuadro azul asignados al usuario de la sesion y que no han sido despuplicados
						
	//Se extraen los registros de la lista de aleatorios	
		$result_d=$mysqli->query($sql_d);
		$today=mysqli_num_rows($result_d);
		$conjunto_d=array();
		$cont_d=0;
		//En caso de que ya se hayan extraido los aleatorios del dia de hoy
		if($today>0){
			
			while ($row_d =  $result_d->fetch_array(MYSQLI_ASSOC)) {
				
					$cont_d++;

					if($cont_d%2==0){
						$color="style='position:relative; float:left; width:50px; height:50px; margin:10px;background:#888;'";
					}
					else{
						$color="style=' position:relative; float:left; width:50px; height:50px; margin:10px;background:#333;'";
					}; 
				

					array_push($conjunto_d, "
			<a  target='_blank' href='editar_empresa_publicidad.php?id=".$row_d['id']."&email=".urlencode($_GET['email'])."&q=".$row_d['empresa']."'><div class='drag' id='lista_".$row_d['id']."' ".$color." >".$cont_d."

		</div></a>");
								
			}
		}//termina el caso de que ya se hayan extraido los aleatorios del dia de hoy
						
	//En caso de que todavia no se hayan extraido los aleatorios del dia de hoy
		else{
			$sql_today="SELECT id, empresa, prioridad, fecha FROM `publicidad` ORDER BY RAND() LIMIT 20";
			

			$result_today=$mysqli->query($sql_today);
			while ($row_today =$result_today->fetch_array(MYSQLI_ASSOC)) {
				
				$cont_d++;
				
				if($row_today['prioridad']!='0'){
					$color="style='position:relative; float:left;  width:0px; height:0px; border-left: 25px solid transparent; border-right: 25px solid transparent; border-bottom: 50px solid #fff; margin:10px;'";
				}	
				
				else{	
					if($cont_d%2==0){
						$color="style='position:relative; float:left;width:0px; height:0px; border-left: 25px solid transparent; border-right: 25px solid transparent; border-bottom: 50px solid #fff;margin:10px;'";
					}
					else{
						$color="style=' position:relative; float:left;width:0px; height:0px; border-left: 25px solid transparent; border-right: 25px solid transparent; border-bottom: 50px solid #fff; margin:10px;'";
					}; 
				}
		
			
			array_push($conjunto_d, "
			<a  target='_blank' href='editar_empresa_publicidad.php?id=".$row_today['id']."&email=".urlencode($_GET['email'])."&q=".$row_today['empresa']."'>
			<div class='drag' id='lista_".$row_today['id']."' ".$color." >
			</div>
			</a>");
			
			$sql_today_registro="UPDATE publicidad SET today=now() WHERE id=".$row_today['id']."";
			$mysqli->query($sql_today_registro);
				
			
			}
		}//termina caso de que todavia no se hayan extraido los aleatorios del dia de hoy						
						
	//termina registros de la lista de aleatorios
						
	//Se extra la lista del primer drop here
		$result_e=$mysqli->query($sql_e);
		$conjunto_e=array();
		$cont_e=0;

		while ($row_e = $result_e->fetch_array(MYSQLI_ASSOC)) {
			$cont_e++;
			if($row_e['prioridad']!='0'){
				$color="style='background-color:#".$row_e['prioridad']."; position:relative; float:left;width:50px; height:50px; margin:2px;'";
			}
			else{	
					if($cont_e%2==0){
						$color="style='background-color:#fff; position:relative; width:50px; height:50px; margin:2px;'";
					}
					else{
						$color="style='background-color:#D8D8D8; position:relative; width:50px; height:50px; margin:2px;'";
					}; 
			}

			array_push($conjunto_e, "
			<div title='".$row_e['empresa']."' class='drag' id='lista_".$row_e['id']."' ".$color." >
				<a  target='_blank' href='editar_empresa_publicidad.php?id=".$row_e['id']."&email=".urlencode($_GET['email'])."&q=".$row_e['empresa']."'>
				<div style='position:relative; float:left; width:50px; height:50px;'><span style='position:relative; top:40%;padding-left:10px;'>".$cont_e."</span></div>
				
				</a>
				
				
				
		</div>");
		}//Termina lista del primer drop here
							
		//Se extra la lista del segundo drop here							
		$result_f=$mysqli->query($sql_f);
		$conjunto_f=array();
		$cont_f=0;

		while ($row_f = $result_f->fetch_array(MYSQLI_ASSOC)) {
			$cont_f++;
			
		
			if($row_f['prioridad']!='0'){
				$color="style='background-color:#".$row_f['prioridad']."; position:relative; float:left; width:50px; height:50px; margin:2px;'";
			}
			else{	
				if($cont_f%2==0){
					$color="style='background-color:#fff; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}
				else{
					$color="style='background-color:#D8D8D8; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}; 
			}

			array_push($conjunto_f, "
			<div g='".$row_f['id']."' title='".$row_f['empresa']."' class='drag actualizados' id='listd_".$row_f['id']."' ".$color." >
				<a  target='_blank' href='editar_empresa_publicidad.php?id=".$row_f['id']."&email=".urlencode($_GET['email'])."&q=".$row_f['empresa']."'>
					<div style='position:relative; float:left; width:50px; height:50px;'>
						<span style='position:relative; top:40%;padding-left:10px;'>".$cont_f."</span>
						
					</div>
				
				</a>		
		</div>");
		}//TErmina lista del segundo drop here
							
	//Lista de los actualizados en el dia actual							
		$result_g=$mysqli->query($sql_g);
		$conjunto_g=array();
		$cont_g=0;

		while ($row_g = $result_g->fetch_array(MYSQLI_ASSOC)) {
			$cont_g++;
			if($row_g['prioridad']!='0'){
				$color="style='background-color:#".$row_g['prioridad']."; position:relative; float:left; width:50px; height:50px; margin:2px;'";
			}
			else{	
				if($cont_g%2==0){
					$color="style='background-color:#fff; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}
				else{
					$color="style='background-color:#D8D8D8; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}; 
			}

			array_push($conjunto_g, "
			<div g='".$row_g['id']."' title='".$row_g['empresa']."' class='drag actualizados' id='listg_".$row_g['id']."' ".$color." >
				<a  target='_blank' href='editar_empresa_publicidad.php?id=".$row_g['id']."&email=".urlencode($_GET['email'])."&q=".$row_g['empresa']."'>
				<div style='position:relative; float:left; width:50px; height:50px;'><span style='position:relative; top:40%;padding-left:10px;'>".$cont_g."</span></div>
				
				</a>
		</div>");
		}//Termina Lista de los actualizados en el dia actual
							
	//Lista de los actualizados del dia anterior						
		$result_h=$mysqli->query($sql_h);
		$conjunto_h=array();
		$cont_h=0;

		while ($row_h =$result_h->fetch_array(MYSQLI_ASSOC)) {
			$cont_h++;
			if($row_h['prioridad']!='0'){
				$color="style='background-color:#".$row_h['prioridad']."; position:relative; float:left; width:50px; height:50px; margin:2px;'";
			}
			else{	
				if($cont_h%2==0){
					$color="style='background-color:#fff; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}
				else{
					$color="style='background-color:#D8D8D8; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}; 
			}

			array_push($conjunto_h, "
			<div g='".$row_h['id']."' title='".$row_h['empresa']."' class='drag actualizados' id='listg_".$row_h['id']."' ".$color." >
				<a  target='_blank' href='editar_empresa_publicidad.php?id=".$row_h['id']."&email=".urlencode($_GET['email'])."&q=".$row_h['empresa']."'>
				<div style='position:relative; float:left; width:50px; height:50px;'><span style='position:relative; top:40%;padding-left:10px;'>".$cont_h."</span></div>
				
				</a>
				
				
				
		</div>");
		}//Termina Lista de los actualizados del dia anterior
	
	
	//Lista de los actualizados de hace dos dias						
		$result_l=$mysqli->query($sql_l);
		$conjunto_l=array();
		$cont_l=0;

		while ($row_l = $result_l->fetch_array(MYSQLI_ASSOC)) {
			$cont_l++;
			if($row_l['prioridad']!='0'){
				$color="style='background-color:#".$row_l['prioridad']."; position:relative; float:left; width:50px; height:50px; margin:2px;'";
			}
			else{	
				if($cont_l%2==0){
					$color="style='background-color:#fff; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}
				else{
					$color="style='background-color:#D8D8D8; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}; 
			}

			array_push($conjunto_l, "
			<div g='".$row_l['id']."' title='".$row_l['empresa']."' class='drag actualizados' id='listg_".$row_l['id']."' ".$color." >
				<a  target='_blank' href='editar_empresa_publicidad.php?id=".$row_l['id']."&email=".urlencode($_GET['email'])."&q=".$row_l['empresa']."'>
				<div style='position:relative; float:left; width:50px; height:50px;'><span style='position:relative; top:40%;padding-left:10px;'>".$cont_l."</span></div>
				
				</a>
				
				
				
		</div>");
		}//Termina Lista de los actualizados de hace dos dias
		
		//Lista de los que deberan contactarse el dia de mañana						
		$result_m=$mysqli->query($sql_m);
		$conjunto_m=array();
		$cont_m=0;

		while ($row_m = $result_m->fetch_array(MYSQLI_ASSOC)) {
			$cont_m++;
			if($row_m['prioridad']!='0'){
				$color="style='background-color:#".$row_m['prioridad']."; position:relative; float:left; width:50px; height:50px; margin:2px;'";
			}
			else{	
				if($cont_m%2==0){
					$color="style='background-color:#fff; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}
				else{
					$color="style='background-color:#D8D8D8; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}; 
			}

			array_push($conjunto_m, "
			<div g='".$row_m['id']."' title='".$row_m['empresa']."' class='drag actualizados' id='listg_".$row_m['id']."' ".$color." >
				<a  target='_blank' href='editar_empresa_publicidad.php?id=".$row_m['id']."&email=".urlencode($_GET['email'])."&q=".$row_m['empresa']."'>
				<div style='position:relative; float:left; width:50px; height:50px;'><span style='position:relative; top:40%;padding-left:10px;'>".$cont_m."</span></div>
				
				</a>
				
				
				
		</div>");
		}
		//Termina Lista de los que deberan contactarse el dia de mañana


//Lista de los que se contactaron durante la semana						
		$result_n=$mysqli->query($sql_n);
		$conjunto_n=array();
		$cont_n=0;

		while ($row_n = $result_n->fetch_array(MYSQLI_ASSOC)) {
			$cont_n++;
			if($row_n['prioridad']!='0'){
				$color="style='background-color:#".$row_n['prioridad']."; position:relative; float:left; width:50px; height:50px; margin:2px;'";
			}
			else{	
				if($cont_n%2==0){
					$color="style='background-color:#fff; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}
				else{
					$color="style='background-color:#D8D8D8; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}; 
			}

			array_push($conjunto_n, "
			<div g='".$row_n['id']."' title='".$row_n['empresa']."' class='drag actualizados' id='listg_".$row_n['id']."' ".$color." >
				<a  target='_blank' href='editar_empresa_publicidad.php?id=".$row_n['id']."&email=".urlencode($_GET['email'])."&q=".$row_n['empresa']."'>
				<div style='position:relative; float:left; width:50px; height:50px;'><span style='position:relative; top:40%;padding-left:10px;'>".$cont_n."</span></div>
				
				</a>
				
				
				
		</div>");
		}
		//Lista de los que se contactaron durante la semana	

//Lista de los que se contactaron hace dos semanas						
		$result_o=$mysqli->query($sql_o);
		$conjunto_o=array();
		$cont_o=0;

		while ($row_o = $result_o->fetch_array(MYSQLI_ASSOC)) {
			$cont_o++;
			if($row_o['prioridad']!='0'){
				$color="style='background-color:#".$row_o['prioridad']."; position:relative; float:left; width:50px; height:50px; margin:2px;'";
			}
			else{	
				if($cont_o%2==0){
					$color="style='background-color:#fff; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}
				else{
					$color="style='background-color:#D8D8D8; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}; 
			}

			array_push($conjunto_o, "
			<div g='".$row_o['id']."' title='".$row_o['empresa']."' class='drag actualizados' id='listg_".$row_o['id']."' ".$color." >
				<a  target='_blank' href='editar_empresa_publicidad.php?id=".$row_o['id']."&email=".urlencode($_GET['email'])."&q=".$row_o['empresa']."'>
				<div style='position:relative; float:left; width:50px; height:50px;'><span style='position:relative; top:40%;padding-left:10px;'>".$cont_o."</span></div>
				
				</a>
				
				
				
		</div>");
		}
		//Lista de los que se contactaron hace dos semanas	
		
		//Lista de los que se contactaron hace tres semanas						
		$result_u=$mysqli->query($sql_o);;
		$conjunto_u=array();
		$cont_u=0;

		while ($row_u = $result_u->fetch_array(MYSQLI_ASSOC)) {
			$cont_u++;
			if($row_u['prioridad']!='0'){
				$color="style='background-color:#".$row_u['prioridad']."; position:relative; float:left; width:50px; height:50px; margin:2px;'";
			}
			else{	
				if($cont_u%2==0){
					$color="style='background-color:#fff; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}
				else{
					$color="style='background-color:#D8D8D8; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}; 
			}

			array_push($conjunto_u, "
			<div g='".$row_u['id']."' title='".$row_u['empresa']."' class='drag actualizados' id='listg_".$row_u['id']."' ".$color." >
				<a  target='_blank' href='editar_empresa_publicidad.php?id=".$row_u['id']."&email=".urlencode($_GET['email'])."&q=".$row_u['empresa']."'>
				<div style='position:relative; float:left; width:50px; height:50px;'><span style='position:relative; top:40%;padding-left:10px;'>".$cont_u."</span></div>
				
				</a>
				
				
				
		</div>");
		}
		//Lista de los que se contactaron hace tres semanas	
		
		//Lista de los que se contactaron hace cuatro semanas						
		$result_v=$mysqli->query($sql_v);
		$conjunto_v=array();
		$cont_v=0;

		while ($row_v = $result_v->fetch_array(MYSQLI_ASSOC)) {
			$cont_v++;
			if($row_v['prioridad']!='0'){
				$color="style='background-color:#".$row_v['prioridad']."; position:relative; float:left; width:50px; height:50px; margin:2px;'";
			}
			else{	
				if($cont_v%2==0){
					$color="style='background-color:#fff; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}
				else{
					$color="style='background-color:#D8D8D8; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}; 
			}

			array_push($conjunto_v, "
			<div g='".$row_v['id']."' title='".$row_v['empresa']."' class='drag actualizados' id='listg_".$row_v['id']."' ".$color." >
				<a  target='_blank' href='editar_empresa_publicidad.php?id=".$row_v['id']."&email=".urlencode($_GET['email'])."&q=".$row_v['empresa']."'>
				<div style='position:relative; float:left; width:50px; height:50px;'><span style='position:relative; top:40%;padding-left:10px;'>".$cont_v."</span></div>
				
				</a>
				
				
				
		</div>");
		}
		//Lista de los que se contactaron hace cuatro semanas	
		
		//Lista de los que se contactaron hace cinco semanas						
		$result_w=$mysqli->query($sql_w);
		$conjunto_w=array();
		$cont_w=0;

		while ($row_w = $result_w->fetch_array(MYSQLI_ASSOC)) {
			$cont_w++;
			if($row_w['prioridad']!='0'){
				$color="style='background-color:#".$row_w['prioridad']."; position:relative; float:left; width:50px; height:50px; margin:2px;'";
			}
			else{	
				if($cont_w%2==0){
					$color="style='background-color:#fff; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}
				else{
					$color="style='background-color:#D8D8D8; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}; 
			}

			array_push($conjunto_w, "
			<div g='".$row_w['id']."' title='".$row_w['empresa']."' class='drag actualizados' id='listg_".$row_w['id']."' ".$color." >
				<a  target='_blank' href='editar_empresa_publicidad.php?id=".$row_w['id']."&email=".urlencode($_GET['email'])."&q=".$row_w['empresa']."'>
				<div style='position:relative; float:left; width:50px; height:50px;'><span style='position:relative; top:40%;padding-left:10px;'>".$cont_w."</span></div>
				
				</a>
				
				
				
		</div>");
		}
		//Lista de los que se contactaron hace cinco semanas	
		//Lista de los que se contactaron hace seis semanas						
		$result_x=$mysqli->query($sql_x);
		$conjunto_x=array();
		$cont_x=0;

		while ($row_x = $result_x->fetch_array(MYSQLI_ASSOC)) {
			$cont_x++;
			if($row_x['prioridad']!='0'){
				$color="style='background-color:#".$row_x['prioridad']."; position:relative; float:left; width:50px; height:50px; margin:2px;'";
			}
			else{	
				if($cont_x%2==0){
					$color="style='background-color:#fff; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}
				else{
					$color="style='background-color:#D8D8D8; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}; 
			}

			array_push($conjunto_x, "
			<div g='".$row_x['id']."' title='".$row_x['empresa']."' class='drag actualizados' id='listg_".$row_x['id']."' ".$color." >
				<a  target='_blank' href='editar_empresa_publicidad.php?id=".$row_x['id']."&email=".urlencode($_GET['email'])."&q=".$row_x['empresa']."'>
				<div style='position:relative; float:left; width:50px; height:50px;'><span style='position:relative; top:40%;padding-left:10px;'>".$cont_x."</span></div>
				
				</a>
				
				
				
		</div>");
		}
		//Lista de los que se contactaron hace cinco semanas	
	
							
	//Lista de los que tienen recordatorio para el dia de hoy						
		$result_i=$mysqli->query($sql_i);
		$conjunto_i=array();
		$cont_i=0;

		while ($row_i = $result_i->fetch_array(MYSQLI_ASSOC)) {
			$cont_i++;
			if($row_i['prioridad']!='0'){
				$color="style='background-color:#".$row_i['prioridad']."; position:relative; float:left; width:50px; height:50px; margin:2px;'";
			}
			else{	
				if($cont_i%2==0){
					$color="style='background-color:#fff; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}
				else{
				$color="style='background-color:#D8D8D8; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}; 
			}

			array_push($conjunto_i, "
			<div g='".$row_i['id']."' title='".$row_i['empresa']."' class='drag actualizados' id='listg_".$row_i['id']."' ".$color." >
				<a  target='_blank' href='editar_empresa_publicidad.php?id=".$row_i['id']."&email=".urlencode($_GET['email'])."&q=".$row_i['empresa']."'>
				<div style='position:relative; float:left; width:50px; height:50px;'><span style='position:relative; top:40%;padding-left:10px;'>".$cont_i."</span></div>
				
				</a>
				
				
				
		</div>");
		}//Termina Lista de los que tienen recordatorio para el dia de hoy	

	//Lista del cuadro rojo ¿otra vez? Nota: averiguar qué es esto						
		$result_j=$mysqli->query($sql_j);
		$conjunto_j=array();
		$cont_j=0;

		while ($row_j = $result_j->fetch_array(MYSQLI_ASSOC)) {
			$cont_j++;
			if($row_j['prioridad']!='0'){
				$color="style='background-color:#".$row_j['prioridad']."; position:relative; float:left; width:50px; height:50px; margin:2px;'";
			}
			else{	
				if($cont_j%2==0){
					$color="style='background-color:#fff; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}
				else{
					$color="style='background-color:#D8D8D8; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}; 
			}

			array_push($conjunto_j, "
			<div g='".$row_j['id']."' title='".$row_j['empresa']."' class='drag actualizados' id='listj_".$row_j['id']."' ".$color." >
				<a  target='_blank' href='editar_empresa_publicidad.php?id=".$row_j['id']."&email=".urlencode($_GET['email'])."&q=".$row_j['empresa']."'>
				<div style='position:relative; float:left; width:50px; height:50px;'><span style='position:relative; top:40%;padding-left:10px;'>".$cont_j."</span></div>
				
				</a>
				
				
				
		</div>");
		}//Termina Lista del cuadro rojo ¿otra vez? Nota: averiguar qué es esto	

	//Lista del 2º Grupo 						
		$result_k=$mysqli->query($sql_k);
		$conjunto_k=array();
		$cont_k=0;

		while ($row_k = $result_k->fetch_array(MYSQLI_ASSOC)) {
			
			$cont_k++;
								
			if($row_k['prioridad']!='0'){
			
				$color="style='background-color:#".$row_k['prioridad']."; position:relative; float:left; width:50px; height:50px; margin:2px;'";
			}
			
			else{	
				if($cont_k%2==0)
					{
						$color="style='background-color:#fff; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}
				else
					{
						$color="style='background-color:#D8D8D8; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}; 
			}

				array_push($conjunto_k, "
				<div g='".$row_k['id']."' title='".$row_k['empresa']."' class='drag actualizados' id='listk_".$row_k['id']."' ".$color." >
					<a  target='_blank' href='editar_empresa_publicidad.php?id=".$row_k['id']."&email=".urlencode($_GET['email'])."&q=".$row_k['empresa']."'>
						<div style='position:relative; float:left; width:50px; height:50px;'>
							
							<span style='position:relative; top:40%;padding-left:10px;'>".$cont_k."</span>
							
						</div>
					
					</a>		
			</div>");
			
		}//Termina Lista del 2º Grupo
		
		//Lista del 3º Grupo 						
		$result_s=$mysqli->query($sql_s);
		$conjunto_s=array();
		$cont_s=0;

		while ($row_s = $result_s->fetch_array(MYSQLI_ASSOC)) {
			
			$cont_s++;
								
			if($row_s['prioridad']!='0'){
			
				$color="style='background-color:#".$row_s['prioridad']."; position:relative; float:left; width:50px; height:50px; margin:2px;'";
			}
			
			else{	
				if($cont_s%2==0)
					{
						$color="style='background-color:#fff; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}
				else
					{
						$color="style='background-color:#D8D8D8; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}; 
			}

				array_push($conjunto_s, "
				<div g='".$row_s['id']."' title='".$row_s['empresa']."' class='drag actualizados' id='listk_".$row_s['id']."' ".$color." >
					<a  target='_blank' href='editar_empresa_publicidad.php?id=".$row_s['id']."&email=".urlencode($_GET['email'])."&q=".$row_s['empresa']."'>
						<div style='position:relative; float:left; width:50px; height:50px;'>
							
							<span style='position:relative; top:40%;padding-left:10px;'>".$cont_s."</span>
							
						</div>
					
					</a>		
			</div>");
			
		}//Termina Lista del 3º Grupo
		
			//Lista de los avances del dia de hoy						
		$result_p=$mysqli->query($sql_p);
		$conjunto_p=array();
		$conjunto_p_bis=array();
		$cont_p=0;

		while ($row_p = $result_p->fetch_array(MYSQLI_ASSOC)) {
			$cont_p++;
			if($row_p['prioridad']!='0'){
				$color="style='background-color:#".$row_p['prioridad']."; position:relative; float:left; width:50px; height:50px; margin:2px;'";
			}
			else{	
				if($cont_p%2==0){
					$color="style='background-color:#fff; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}
				else{
				$color="style='background-color:#D8D8D8; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}; 
			}

			array_push($conjunto_p, "
			<div g='".$row_p['id']."' title='".$row_p['empresa']."' class='drag actualizados' id='listg_".$row_p['id']."' ".$color." >
				<a  target='_blank' href='editar_empresa_publicidad.php?id=".$row_p['id']."&email=".urlencode($_GET['email'])."&q=".$row_p['empresa']."'>
				<div style='position:relative; float:left; width:50px; height:50px;'><span style='position:relative; top:40%;padding-left:10px;'>".$cont_p."</span></div>
				
				</a>
				
				
				
		</div>");
		}//Termina Lista de los avances del dia de hoy	
		
//Los olviddos 						
		$result_q=$mysqli->query($sql_q);
		$conjunto_q=array();
		$cont_q=0;

		while ($row_q = $result_q->fetch_array(MYSQLI_ASSOC)) {
			
			$cont_q++;
								
			if($row_q['prioridad']!='0'){
			
				$color="style='background-color:#".$row_q['prioridad']."; position:relative; float:left; width:50px; height:50px; margin:2px;'";
			}
			
			else{	
				if($cont_q%2==0)
					{
						$color="style='background-color:#fff; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}
				else
					{
						$color="style='background-color:#D8D8D8; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}; 
			}

				array_push($conjunto_q, "
				<div g='".$row_q['id']."' title='".$row_q['empresa']."' class='drag actualizados' id='listk_".$row_q['id']."' ".$color." >
					<a  target='_blank' href='editar_empresa_publicidad.php?id=".$row_q['id']."&email=".urlencode($_GET['email'])."&q=".$row_q['empresa']."'>
						<div style='position:relative; float:left; width:50px; height:50px;'>
							
							<span style='position:relative; top:40%;padding-left:10px;'>".$cont_q."</span>
							
						</div>
					
					</a>		
			</div>");
			
		}//Termina Los olvidados
		
		
		//Los AVANCES DE LAS EMANA						
		$result_r=$mysqli->query($sql_r);
		$conjunto_r=array();
		$cont_r=0;

		while ($row_r = $result_r->fetch_array(MYSQLI_ASSOC)) {
			
			$cont_r++;
								
			if($row_r['prioridad']!='0'){
			
				$color="style='background-color:#".$row_r['prioridad']."; position:relative; float:left; width:50px; height:50px; margin:2px;'";
			}
			
			else{	
				if($cont_r%2==0)
					{
						$color="style='background-color:#fff; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}
				else
					{
						$color="style='background-color:#D8D8D8; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}; 
			}

				array_push($conjunto_r, "
				<div g='".$row_r['id']."' title='".$row_r['empresa']."' class='drag actualizados' id='listk_".$row_r['id']."' ".$color." >
					<a  target='_blank' href='editar_empresa_publicidad.php?id=".$row_r['id']."&email=".urlencode($_GET['email'])."&q=".$row_r['empresa']."'>
						<div style='position:relative; float:left; width:50px; height:50px;'>
							
							<span style='position:relative; top:40%;padding-left:10px;'>".$cont_r."</span>
							
						</div>
					
					</a>		
			</div>");
			
		}//Termina Los avances de la semana
		
		//Los maileds						
		$result_t=$mysqli->query($sql_t);
		$conjunto_t=array();
		$cont_t=0;

		while ($row_t =$result_t->fetch_array(MYSQLI_ASSOC)) {
			
			$cont_t++;
								
			if($row_t['prioridad']!='0'){
			
				$color="style='background-color:#".$row_t['prioridad']."; position:relative; float:left; width:50px; height:50px; margin:2px;'";
			}
			
			else{	
				if($cont_t%2==0)
					{
						$color="style='background-color:#fff; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}
				else
					{
						$color="style='background-color:#D8D8D8; position:relative; float:left; width:50px; height:50px; margin:2px;'";
				}; 
			}

				array_push($conjunto_t, "
				<div g='".$row_t['id']."' title='".$row_t['empresa']."' class='drag actualizados' id='listk_".$row_t['id']."' ".$color." >
					<a  target='_blank' href='editar_empresa_publicidad.php?id=".$row_t['id']."&email=".urlencode($_GET['email'])."&q=".$row_t['empresa']."'>
						<div style='position:relative; float:left; width:50px; height:50px;'>
							
							<span style='position:relative; top:40%;padding-left:10px;'>".$cont_t."</span>
							
						</div>
					
					</a>		
			</div>");
			
		}//Termina Los maileds
																
	//En caso de que el usuario sean Yossy o Jack					
		if($mail=="yossy@avantipictures.com"||$mail=="jack@avantipictures.com"){
			// $uid="4";
			if($mail=="yossy@avantipictures.com"){$name="Yossy";
			}
			else{
				$name="Jack";
			}
			//Se extraen sólo los registros asignados al usuario de la sesion y que no han sido despuplicados	
			$sql_b="SELECT id, empresa, contacto, telefono, ext, mail, notas, prioridad FROM `publicidad` WHERE uid>=3 AND unpublish=0 ";

			$result=$mysqli->query($sql_b);
			$conjunto=array();
			$cont=0;

			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$cont++;
				if($row['prioridad']!='0'){
					$color="style='background-color:#".$row['prioridad'].";'";
				}
				else{	
					if($cont%2==0){
						$color="style='background-color:#fff;'";
					}
					else{
						$color="style='background-color:#D8D8D8;'";
					}; 
				}

				array_push($conjunto, "
				<tr id='".$cont."' ".$color.">
					<td onclick='color(".$cont.",".$row['id'].")'>".$cont."</td>
					
					<td id='".$row['empresa']."' style='padding:0px 5px;;' >
						<a href='editar_empresa_publicidad.php?id=".$row['id']."&email=".urlencode($_GET['email'])."'>
							<div class='edit' style=' width:150px; height:50px;  vertical-align:middle;'>
								<span style='position:relative; top:40%;'>".$row['empresa']."</span>
							</div>
						</a>
					</td>
					<td id=''>".$row['contacto']."</td>
					<td id=''>".$row['telefono']."</td>
					<td id=''>".$row['ext']."</td>
					<td id=''>".$row['mail']."</td>
					<td>
						<div style='height:50px; overflow:auto;'>".$row['notas']."</div>
					</td>
					<td>
						<button onclick='unpublish(".$row['id'].")' >Eliminar</button>
					</td>
			</tr>");
				
				
			} //Fin del While
		}//Fin del if para yossy o jack
			
		//-------------------------------------------------------------------------------------------------------------------------------------------------			
		//---Termina la extraccion de datos----------------------------------------------------------------------------------------------------------------
		//-------------------------------------------------------------------------------------------------------------------------------------------------						
			?>
    
<!doctype html>
<html lang="es">
<head>
 	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="content-type" content="text/html" charset="UTF-8">
	<title>
		Empresas 189
    </title>
	<link rel="stylesheet" href="js/jquery-ui-1.12.1/jquery-ui.css">
    <script src="/eficine/js/jquery-3.2.1.min.js"></script>
	<script src="/eficine/js/jquery-ui-1.12.1/jquery-ui.js"></script>
	<script>
		var xy=0;
		var b=0;
		function nueva_empresa(){ 
			alert(empresa.value);
		
			document.getElementById('agregar').submit();
		}

		function unpublish(id){ 
			alert(empresa.value);		
			var xmlhttp;
		
				if (window.XMLHttpRequest){
					// code for IE7+, Firefox, Chrome, Opera, Safari
				
					xmlhttp=new XMLHttpRequest();
				
				}
				
				else{// code for IE6, IE5
				
				  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				
				}
				
				xmlhttp.onreadystatechange=function(){
				
					if (xmlhttp.readyState==4 && xmlhttp.status==200){
				
						alert("El elemento "+xmlhttp.responseText+" ha sido despublicado.")
				
					}
				
				}
				
				xmlhttp.open("POST","unpublish_publicidad.php?id="+id,true);
				
				xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				
				xmlhttp.send();
		}	
		
		function color(a,z){ 	
			switch(xy){
				case 0: xy++; document.getElementById(a).style.backgroundColor='#F5A9A9'; db_color(a,"f5a9a9");
						b=a; 
				break;
				
				case 1: if(b==a){xy++; document.getElementById(a).style.backgroundColor='#0BB';db_color(a,"0BB");  }
						 else{xy=0; color(a,z);}
				break;
				case 2: if(b==a){xy++; document.getElementById(a).style.backgroundColor='#BB66BB';db_color(a,"BB66BB");}
						 else{xy=0; color(a,z);}
				break;
				case 3: if(b==a){xy++; document.getElementById(a).style.backgroundColor='#99ffff';db_color(a,"99ffff");}
						 else{xy=0;color(a,z);}
				break;
				case 4: if(b==a){xy++; document.getElementById(a).style.backgroundColor='#ffcc00';db_color(a,"ffcc00");}
						 else{xy=0;color(a,z);}
				break;
				case 5: if(b==a){xy++; document.getElementById(a).style.backgroundColor='#ff3333';db_color(a,"ff3333");}
						 else{xy=0;color(a,z);}
				break;
				
				case 6: if(b==a){xy++; document.getElementById(a).style.backgroundColor='#82BA00';db_color(a,"82BA00");}
						 else{xy=0;color(a,z);}
				break;
				case 7: if(b==a){xy++; document.getElementById(a).style.backgroundColor='#FF9C33';db_color(a,"FF9C33");}
						 else{xy=0;color(a,z);}
				break;
				
				case 8: if(b==a){xy++; document.getElementById(a).style.backgroundColor='#E0FF33';db_color(a,"e0ff33");}
						 else{xy=0;color(a,z);}
				break;
				
				case 9: if(b==a){xy++; document.getElementById(a).style.backgroundColor='#FF337A';db_color(a,"FF337A");}
						 else{xy=0;color(a,z);}
				break;
				
				case 10: if(b==a){xy++; document.getElementById(a).style.backgroundColor='#D8D8D8';db_color(a,"0");}
						 else{xy=0;color(a,z);}
				break;
				case 11: if(b==a){xy=0; document.getElementById(a).style.backgroundColor='#Fff';db_color(a,"0");}
						 else{xy=0;}
				break;
				
				
				
				
				}	
		}

		function db_color(id,color){ 			
			var xmlhttp;
		
			if (window.XMLHttpRequest){
				// code for IE7+, Firefox, Chrome, Opera, Safari
		
		  		xmlhttp=new XMLHttpRequest();
		
		  	}
		
			else{
				// code for IE6, IE5
		
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		
			}
		
			xmlhttp.onreadystatechange=function()
		
		  {
		
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		
			{
		
			//alert("El elemento "+xmlhttp.status+" ha sido despublicado.")
		
			}
		
		  }
		
		xmlhttp.open("GET","cambiar_color.php?id="+id+"&color="+color,true);
		
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		
		xmlhttp.send();
		}

		function organizator(id,lista){	
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
			
				
			
				}
			
			  }
			
			xmlhttp.open("GET","organizator.php?id="+id+"&lista="+lista,true);
			
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			
			xmlhttp.send();
		};

  		$( function() {
	  			$( document ).tooltip({position: {
        
        		at: "right+10 top-5"}});
	  			// There's the gallery and the trash
    			var $droppable = $( "#droppable" );
				var $actualizados = $( "#actualizados" );
 
			$( "#accordion" ).accordion({
     			collapsible: true,
	   			heightStyle: "content"
    		});
			$( "#accordion2" ).accordion({
     			 collapsible: true,
	   			heightStyle: "content"
    		});
    		$( "#draggable" ).draggable();
	    	$( "#papelera" ).draggable();
			$( "#quotes" ).draggable();
			$( "#accordion" ).draggable();
			$( "#circulo" ).draggable();
			$( "#container" ).draggable();
			$( "#spotify" ).draggable();
			$( "#droppable" ).draggable();
			
			$("#actualizados").draggable();
			$( ".drag" ).draggable({ 
				revert:"invalid",
				helper:"clone",
				opacity:0.5,
				zIndex:3000
				
			});

	
			$( "#droppable" ).droppable({
			   classes: {
				"ui-droppable-hover": "ui-state-hover"
			  },
			  drop: function( event, ui ) {
				$( this )
				  .addClass( "ui-state-highlight" )
				  .find( "p" )
					.html( "Dropped!" );
					 deleteImage( ui.draggable,1 );
			  }
			});
			
			$( "#droppable2" ).droppable({
			   classes: {
				"ui-droppable-hover": "ui-state-hover"
			  },
			  drop: function( event, ui ) {
				$( this )
				  .addClass( "ui-state-highlight" )
				  .find( "p" )
					.html( "Dropped!" );
					 deleteImage( ui.draggable,0 );
			  }
			});
	
			$( "#draggable" ).droppable({
			   classes: {
				"ui-droppable-hover": "ui-state-hover"
			  },
			  drop: function( event, ui ) {
				$( this )
				  .addClass( "ui-state-highlight" )
				  .find( "p" )
					.html( "Dropped!" );
					 deleteImage( ui.draggable,2 );
			  }
			});
	
			$( "#principal" ).droppable({
			   accept: ".actualizados",
			  drop: function( event, ui ) {
				
					 deleteDIV( ui.draggable,0 );
			  }
			});
	
			$( "#papelera" ).droppable({
			   accept: ".actualizados",
			  drop: function( event, ui ) {
				
					 deleteDIV( ui.draggable,3 );
			  }
			});
	
			function deleteImage( $item,lista ) {
				
				alert($item.attr("id"));
				$item.fadeOut(function() {
					
					var $list = $( "ul", $droppable ).length ?
					$( "ul", $droppable ) :
					$( "<ul class='gallery ui-helper-reset'/>" ).appendTo( $droppable );
					$item
					.animate({ width: "60px" })
						.animate({ height: "60px" });
						$item.css("position","relative");
						
						
					organizator($item.attr("id"),lista);
					
					$item.appendTo( $list ).fadeIn(function() {
						
					 });
			   
			  });
			  
	  
		  
			};
			function deleteDIV( $item,lista ) {
				
				alert($item.attr("g"));
				
				$item.fadeOut(function() {
					
					
					organizator($item.attr("g"),lista);
					
					
			   
			  });
			  
			  
				  
			};
			
  		} );
	</script>
 	<style> 
	html{ font-size:14px;}
	.nueva-empresa input{ height:20px;} .nueva-empresa td{ height:25px;} .todas-empresas td{ padding:5px; } .todas-empresas th{ background:#CCC;}  
	a:link{ text-decoration:none; color:#000 }
	.boton-superior{ position:relative; float:left; width:20%; height:50px; background-color:#CCFF33; color:#0000FF; border-width:thin; border-color:#FFFFFF}
	.boton-superior:hover{ background-color: #66CC00}
	.edit:hover{ background-color:#999999}	  
	</style>
</head>

<body background="img/dark-triangles.png"  style="font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif" bgcolor="#999999" >

	
<div id="container" style="width:625px;  background:#FFFFFF; position:relative; margin:-10px auto; top:0px;">

	
    
   
   <script>
   if(screen.width<840){document.getElementByClass("todas_empresas").style.fontSize="24px";};
   </script>
   

</div> 
   
<!--Comienzan las tabs del lado izquierdo-->  

    <div id="accordion2" style="position:relative; margin-left:-10px;  width:442px;">
    
   <h3>Lista completa</h3>
    <div id="principal" style="width:442px; height:800px; border:none; padding:0px;   ">
        
			<?php foreach($conjunto as $key=>$value)
					{	
						echo ($value);};
         ?>
       
   </div>
   <h3>Papelera</h3>
    <div id="papelera" class="ui-widget-header" style="width:442px;background:none; border:none; padding:0px;   ">
        
			<?php foreach($conjunto_j as $key=>$value)
					{	
						echo ($value);};
         ?>
       
   </div>
   
   
    
    
        <h3>Tablero</h3>
        
   
    <div id="confirmacion" style="position:relative;  z-index:1000; top:35px; width:625px;  height:50px; background:#fff; margin-bottom:80px;">
        
        <?php if($uid==4){
			?>
            <a target='_blank' href="papeleria.php?email=<?php echo urlencode($_GET['email']);?>" target="_blank" ><button class="boton-superior" style="cursor:pointer">Alianzas</button>	</a>
        <button class="boton-superior"><a href="rodrigo.php?email=<?php echo urlencode($_GET['email']);?>" target="_blank" >Rodrigo</a></button>
        <?php } if($uid==3 || $uid==8){
			?>
        
        <a target='_blank' href="majors.php?email=<?php echo urlencode($_GET['email']);?>"  ><button class="boton-superior" style="cursor:pointer">Aportantes</button>	</a>
        <a target='_blank' href="proyectos_alta.php?email=<?php echo urlencode($_GET['email']);?>" ><button class="boton-superior" style="cursor:pointer">Pel&iacute;culas</button></a>	
      
        <a target='_blank' href="proyectos_alta_teatro.php?email=<?php echo urlencode($_GET['email']);?>" target="_blank"  ><button class="boton-superior" style="cursor:pointer">Teatro</button></a>
        <a target='_blank' href="papeleria.php?email=<?php echo urlencode($_GET['email']);?>" target="_blank" ><button class="boton-superior" style="cursor:pointer">Alianzas</button>	</a>
          <a href="/eficine" ><button class="boton-superior" style="cursor:pointer">Salir</button></a>
        
        <?php }
		else{
		?>
        <a target='_blank' href="empresas226.php" target="_blank" ><button class="boton-superior" style="cursor:pointer">Lista 2</button>	</a>
        <a  href="/eficine" ><button class="boton-superior" style="cursor:pointer">Salir</button></a>
        <a target='_blank' href="#arriba" ><button class="boton-superior" style="cursor:pointer">Subir</button></a>
        <?php }
		
		?>
        
    </div>
    
     
    <h3>Nueva empresa</h3>
    <div style="position:relative; top:85px; width:625px; z-index:1000; height:250px; background:#FFFFFF">
        <form style="position:relative; top:10px;"  action="/eficine/publicidad.php?email=<?php echo urlencode($_GET['email']);?>" method="post" name="agregar" id="agregar" enctype="application/x-www-form-urlencoded" >
        <table class="nueva-empresa">
        <tr>
        <td>
        <label for="empresa">Nombre de la empresa</label>
        </td>
        <td>
        <input type="text" name="empresa" id="empresa"/><br />
        </td>
        </tr>
        <tr>
        <td>
        <label for="contacto">Contacto</label>
        </td>
        <td>
        <input type="text" name="contacto" id="contacto" /><br />
        </td>
        </tr>
        <tr>
        <td>
        <label for="telefono">Tel&eacute;fono</label>
        </td>
        <td>
        <input type="text" name="telefono" id="telefono" /><br />
        </td>
        </tr>
        <tr>
        <td>
        <label for="ext">Extensi&oacute;n</label>
        </td>
        <td>
        <input type="number" name="ext"  id="ext"/><br />
        </td>
        </tr>
        <tr>
        <td>
        <label for="mail">Mail</label>
        </td>
        <td>
        <input type="text" name="mail"  id="mail"/><br />
        </td>
        </tr>
        <tr>
        <td>
        <label for="notas">Notas</label>
        </td>
        <td>
        <input type="text" name="notas" id="notas" /><br />
        </td>
        </tr>
        </table>
        <input type="hidden" name="email" id="email" value="<?php echo $mail;?>" /><br />
        <input type="hidden" name="nueva" id="nueva" value="1" /><br />
        </form>
    	<button onclick="nueva_empresa();" name="agregar_empresa" id="agregar_empresa" >Agregar a la base de datos</button>
        
        
       
    </div>
   
        <h3>Hoy</h3>
        <div class="ui-widget-header" style="background:none; border:none; padding:0px;">
        <?php foreach($conjunto_g as $key=>$value)
					{	
						echo ($value);};
         ?></div>
         <h3>Con recordatorio para hoy</h3>
        <div class="ui-widget-header" style="background:none; border:none; padding:0px;">
        <?php foreach($conjunto_i as $key=>$value)
					{	
						echo ($value);};
         ?>
      </div>
          <h3>Avances del dia de hoy</h3>
        <div class="ui-widget-header" style="background:none; border:none; padding:0px;">
        <?php foreach($conjunto_p as $key=>$value)
					{	
						echo ($value);};
         ?>
      </div>
        <h3>Ayer</h3>
        <div class="ui-widget-header"  style="background:none; border:none; padding:0px;">
        	 <?php foreach($conjunto_h as $key=>$value)
					{	
						echo ($value);};
         ?>
        </div>
        <h3>Antier</h3>
        <div class="ui-widget-header"  style="background:none; border:none; padding:0px;">
        	 <?php foreach($conjunto_l as $key=>$value)
					{	
						echo ($value);};
         ?>
        </div>

		<h3>Para mañana</h3>
        <div class="ui-widget-header"  style="background:none; border:none; padding:0px;">
        	 <?php foreach($conjunto_m as $key=>$value)
					{	
						echo ($value);};
         ?>
        </div>
        
        <h3>Semana actual</h3>
        <div class="ui-widget-header"  style="background:none; border:none; padding:0px;">
        	 <?php foreach($conjunto_n as $key=>$value)
					{	
						echo ($value);};
         ?>
        </div>
        
        <h3>Semana anterior</h3>
        <div class="ui-widget-header"  style="background:none; border:none; padding:0px;">
        	 <?php foreach($conjunto_o as $key=>$value)
					{	
						echo ($value);};
         ?>
        </div>
		
		<h3>Hace dos semanas</h3>
        <div class="ui-widget-header"  style="background:none; border:none; padding:0px;">
        	 <?php foreach($conjunto_u as $key=>$value)
					{	
						echo ($value);};
         ?>
        </div>
		
		<h3>Hace tres semanas</h3>
        <div class="ui-widget-header"  style="background:none; border:none; padding:0px;">
        	 <?php foreach($conjunto_v as $key=>$value)
					{	
						echo ($value);};
         ?>
        </div>
		
		<h3>Hace cuatro semanas</h3>
        <div class="ui-widget-header"  style="background:none; border:none; padding:0px;">
        	 <?php foreach($conjunto_w as $key=>$value)
					{	
						echo ($value);};
         ?>
        </div>
		
		<h3>Hace cinco semanas</h3>
        <div class="ui-widget-header"  style="background:none; border:none; padding:0px;">
        	 <?php foreach($conjunto_x as $key=>$value)
					{	
						echo ($value);};
         ?>
        </div>
        
        <h3 title="A partir de 1-Ago-2018">3º Grupo</h3>
    	<div id="actualizadoss" class="ui-widget-header" style="background:none; border:none; padding:0px;" >
  		
    <?php foreach($conjunto_s as $key=>$value)
					{	
						echo ($value);};
         ?>
		</div>
        
        <h3 title="A partir de 31-Ago-2017">2º Grupo</h3>
    	<div id="actualizadosk" class="ui-widget-header" style="background:none; border:none; padding:0px;" >
  		
    <?php foreach($conjunto_k as $key=>$value)
					{	
						echo ($value);};
         ?>
		</div>
        
        <h3  title="De 27-julio-2017 a 30-Ago-2017">1er Grupo</h3>
    	<div id="actualizados" class="ui-widget-header" style="background:none; border:none; padding:0px;" >
  		
    <?php foreach($conjunto_f as $key=>$value)
					{	
						echo ($value);};
         ?>
		</div>
        
        <h3>Aleatorios del d&iacute;a</h3>
        <div id="aleatorios"  style="background:none; border:none; padding:0px;">
  	
    <?php foreach($conjunto_d as $key=>$value)
					{	
						echo ($value);};
         ?>
	</div>
    
   
     <h3 title="Los olvidados">Los olvidados</h3>
    	<div id="losolvidados" class="ui-widget-header" style="background:none; border:none; padding:0px;" >
  		
    <?php foreach($conjunto_q as $key=>$value)
					{	
						echo ($value);};
         ?>
		</div>
        
         <h3 title="Avances de la semana">Avances de la semana</h3>
    	<div id="losolvidados2" class="ui-widget-header" style="background:none; border:none; padding:0px;" >
  		
    <?php foreach($conjunto_r as $key=>$value)
					{	
						echo ($value);};
         ?>
		</div>
        
         <h3 title="maileds">Maileds</h3>
    	<div id="maileds" class="ui-widget-header" style="background:none; border:none; padding:0px;" >
  		
    <?php foreach($conjunto_t as $key=>$value)
					{	
						echo ($value);};
         ?>
		</div>
        
    </div>
    

   <div id="draggable" class="ui-widget-header" style="position: fixed;  top:10px; right: 10px; min-height: 70px; border:none; padding:0px; background-color: none; ">
 		<h3 style="color: #000">Pura carnita</h3>
   	 <?php foreach($conjunto_e as $key=>$value)
					{	
						echo ($value);};
         ?> 
</div>
    
    
<?php /*?><div id="droppable" class="ui-widget-header" style="width:442px;min-height: 70px;border:none; padding:0px; background:#0f0;">
  		<h3>Drop here 2</h3>
    <? foreach($conjunto_c as $key=>$value)
					{	
						echo ($value);};
         ?>
	</div><?php */?>
	
   <div id="droppable2" class="ui-widget-header" style="width:200px;height:200px;background: #F40101">los mas </div>
</body>
   </html>
   
<?php 
} 

//En caso de que la sesion guardada no coincida con la sesión activa
else{header('Location:http://www.industriacreativa.com.mx/eficine/index.php');}

} ?>