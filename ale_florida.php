<?
//iniciamos una sesión
session_start();
$es_movil = '0';
if(preg_match('/(android|wap|phone|ipad)/i',strtolower($_SERVER['HTTP_USER_AGENT']))){
    $es_movil++;
}

//--------------------------------------------------------------------------------------------------------------------------
// VERSIÓN PARA TABLETS Y CELULARES  -------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------


if($es_movil>0){}

//--------------------------------------------------------------------------------------------------------------------------------------------------
// VERSIÓN DE ESCRITORIO -------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------


else{
    

//Nos conectamos a la base de datos 
//(hay que cambiar a la clase mysqli)
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
   

	if($mail=="ale@avantipictures.com")
		{
			$uid="10";
		}
//Averiguamos la sesion guardada para el usuario   
   	$sql_1="SELECT phpsessid, id FROM `usuarios` WHERE email='".$mail."'";
   
   	$resultw=mysql_fetch_array(mysql_query($sql_1), MYSQL_ASSOC);

//Si la sesión guardada es la sesión activa, entonces damos acceso a la lista y sus funciones
   
	if($resultw['phpsessid']==session_id()){ 
	
	
//----------------------------------------------------------------------------------------------------------------------
// Actualización desde editar_empresa_ale.php -----------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------

   
	//En caso de recibir actualizacion de ulguna empresa desde editar_empresa_ale.php (hay que checar si es posible no volver a conectar a la db)
	if($_POST['id']){
		
		
	  
//Actualizamos los datos del registro (a partir de aqui entra en accion las nuevas bases de datos)
	
	if($_POST['notas'] != date("d.m.Y")){$notas="".$_POST['notas']."<br/><hr/>";}else{$notas="";}
	
	//actualizar empresas 
	
	$sql_empresa="UPDATE empresas SET empresa='".$_POST['empresa']."' WHERE id=".$_POST['id']."";
	mysql_query($sql_empresa);
	
	//actualizar notas 
	
	$sql_notas="UPDATE notas SET ale_florida='".$notas."".$_POST['notas_pasadas']."' WHERE id=".$_POST['id']."";
	mysql_query($sql_notas);
	
	//actualizar contactos
	$sql_contactos="UPDATE contactos SET contacto='".$_POST['contacto']."', puesto='".$_POST['puesto']."',telefono='".$_POST['telefono']."', ext='".$_POST['ext']."', mail='".$_POST['mail']."' WHERE id_contacto=".$_POST['id_contacto']."";
	mysql_query($sql_contactos);
	
	 }

//----------------------------------------------------------------------------------------------------------------------
// Registro de una nueva empresa desde papeleria.php------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------

	 
//En caso de registrar una nueva empresa desde papeleria.php*****
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
	 	//Insertamos el nuevo registro (aqui tambien entran en accion las nuevas bases de datos, hay que ver de que manera optimizar tosas estas consultas ya que son muchas)
		
		//Insertamos el nombre de la empresa en empresas notese que el valor de id no va explciito ya que al ser este valor una columna y un indice primario en la base de datos con una condicion de AUTO_INCREMENT se asigna solo.
	 	$sql_empresa="INSERT INTO empresas(empresa,uid,papeleria) values('".$_POST['empresa']."','".$uid."',1)";

		mysql_query($sql_empresa);
		
		//Averiguamos el id con el que se registra la empresa, para poder asignar el contacto a esta empresa.
		$sql_id="SELECT id FROM `empresas` WHERE empresa='".$_POST['empresa']."'";
		$result_id=mysql_query($sql_id);
		$id=mysql_fetch_assoc($result_id);
		
		//Insetamos los datos de contacto para la empresa, utilizando el id de empresa recuperado con $sql_id
		$sql_contacto="INSERT INTO contactos(id,contacto,puesto,telefono,ext,mail,papeleria) values(".$id['id'].",'".$_POST['contacto']."','".$_POST['puesto']."','".$_POST['telefono']."','".$_POST['ext']."','".$_POST['mail']."',1)";

		mysql_query($sql_contacto);
		
		//Insertamos la prioridad para la empresa, utilizando el id de empresa recuperado con $sql_id
		$sql_prioridad="INSERT INTO prioridades(id) values(".$id['id'].")";

		mysql_query($sql_prioridad);
		
		//Insertamos las notas para la empresa, utilizando el id de empresa recuperado con $sql_id
		$sql_notas="INSERT INTO notas(id,papeleria) values(".$id['id'].",'".$_POST['notas']."')";

		mysql_query($sql_notas);
						
	 }


//----------------------------------------------------------------------------------------------------------------------
// Desplegar la lista----------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------

 
//Para desplegar la lista en caso de no que no se tenga una nueva o se tenga que actualizar alguna empresa
//Averiguar si estas variables se pueden tomar de más arriba
	
			$uid="10";
			$name="Ale";
		
	
  
//Se extraen sólo los registros asignados al usuario de la sesion y que no han sido despuplicados
//Aqui ya se extraen datos de las nuevas bases de datos	
	$sql_b="SELECT id, empresa FROM `empresas` WHERE ale_florida=1 ";

						$result=mysql_query($sql_b);
						$conjunto=array();
						$cont=0;

						while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
							$cont++;
							// En cada iteracion se extrae la prioridad de la empresa en turno
							$sql_prioridad="SELECT ale_florida FROM `prioridades` WHERE id=".$row['id']."";
							$result_prioridad=mysql_query($sql_prioridad);
							$row_prioridad=mysql_fetch_array($result_prioridad, MYSQL_ASSOC);
							
						if($row_prioridad['ale_florida']!='0'){$color="style='background-color:#".$row_prioridad['ale_florida'].";'";}
						
						else{	
						if($cont%2==0)
							{$color="style='background-color:#fff;'";}
						else
							{$color="style='background-color:#D8D8D8;'";}; 
						}
						// En cada iteracion se extran los contactos de la empresa en turno
							$sql_contactos_b="SELECT id_contacto,contacto,puesto,telefono,ext,mail FROM `contactos` WHERE id=".$row['id']." AND ale_florida=1";
							$result_contactos_b=mysql_query($sql_contactos_b);
							$row_contactos_b=mysql_fetch_array($result_contactos_b, MYSQL_ASSOC);
							
						// En cada iteracion se extran las notas de la lista papeleria de la empresa en turno
							$sql_notas="SELECT ale_florida FROM `notas` WHERE id=".$row['id']."";
							$result_notas=mysql_query($sql_notas);
							$row_notas=mysql_fetch_array($result_notas, MYSQL_ASSOC);
							
							array_push($conjunto, "
							<tr id='".$cont."' ".$color.">
								<td onclick='color(".$cont.",".$row['id'].")'>".$cont."</td>
								<td id=''>
								     <div style='margin-top:1px; width:20px; height:20px; background-color:#fff'></div>
								     <div style='margin-top:1px; width:20px; height:20px; background-color:#fff'></div>
								     <div style='margin-top:1px; width:20px; height:20px; background-color:#fff'></div>
								     <div style='margin-top:1px; width:20px; height:20px; background-color:#fff'></div>
							    </td>
								<td id='".$row['empresa']."' style='padding:0px 5px;;' >
									<a href='editar_empresa_ale.php?id=".$row['id']."&email=".urlencode($_GET['email'])."'>
										<div class='edit' style=' width:150px; height:100px;  vertical-align:middle;'>
											<span style='position:relative; top:40%;'>".$row['empresa']."</span>
										</div>
									</a>
								</td>
								
								<td id=''>".$row_contactos_b['contacto']."</td>
								<td id=''>".$row_contactos_b['puesto']."</td>
								<td id=''>".$row_contactos_b['telefono']."</td>
								<td id=''>".$row_contactos_b['ext']."</td>
								<td id=''>".$row_contactos_b['mail']."</td>
								
								
								<td>
									<div style='height:100px; overflow:auto;'>".$row_notas['ale_florida']."</div>
								</td>
								<td>
									<button onclick='unpublish(".$row['id'].")'>Eliminar</button>
								</td>
						</tr>");
							}
							
							
			if($mail=="yossy@avantipictures.com")
		{
			// $uid="4";
			$name="Yossy";
			//Se extraen sólo los registros asignados al usuario de la sesion y que no han sido despuplicados	
	$sql_b="SELECT id, empresa, contacto, telefono, ext, mail, notas, prioridad FROM `publicidad` WHERE uid>=3 AND unpublish=0 ";

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
								<td id='".$row['empresa']."' style='padding:0px 5px;;' >
									<a href='editar_empresa_publicidad.php?id=".$row['id']."&email=".urlencode($_GET['email'])."'>
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
								<td>
									<button onclick='unpublish(".$row['id'].")'>Eliminar</button>
								</td>
						</tr>");
							
							
							}
		}				
							
	?>
    
<!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html" charset="UTF-8">
<title><? echo $name?> | Ale Florida	</title>
  
<script>

function nueva_empresa(){ 
	alert(empresa.value);

	document.getElementById('agregar').submit();
}

function unpublish(id){ 
	

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
		
		xmlhttp.open("POST","unpublish_papeleria.php?id="+id,true);
		
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		
		xmlhttp.send();
}

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
		case 4: if(b==a){xy++; document.getElementById(a).style.backgroundColor='#d8c1d7';db_color(z,"d8c1d7");}
				 else{xy=0;color(a,z);}
		break;
		case 5: if(b==a){xy++; document.getElementById(a).style.backgroundColor='#ff3333';db_color(z,"ff3333");}
				 else{xy=0;color(a,z);}
		break;
		
		case 6: if(b==a){xy++; document.getElementById(a).style.backgroundColor='#82BA00';db_color(z,"82BA00");}
				 else{xy=0;color(a,z);}
		break;
		
		case 7: if(b==a){xy++; document.getElementById(a).style.backgroundColor='#D8D8D8';db_color(z,"0");}
				 else{xy=0;color(a,z);}
		break;
		case 8: if(b==a){xy=0; document.getElementById(a).style.backgroundColor='#Fff';db_color(z,"0");}
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
		
		xmlhttp.open("GET","cambiar_color.php?id="+id+"&color="+color+"&papeleria="+1,true);
		
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		
		xmlhttp.send();
}
</script>
<style> 
html{ font-size:12px;}
.nueva-empresa input{ height:20px;} .nueva-empresa td{ height:25px;} .todas-empresas td{ padding:5px; } .todas-empresas th{ background:#CCC;}  </style>
<style>
a:link{ text-decoration:none; color:#000 }
.boton-superior{ position:relative; float:left; width:20%; height:50px; background-color: #FF99CC; color:#FFFFFF; border-width:thin; border-color:#FFFFFF}
.boton-superior:hover{ background-color: #66CC00}
.edit:hover{ background-color:#999999}
</style>
</head>

<body style="font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif">
	<div id="locate" style="position:fixed;  z-index:1000; top:0px; left:0px; right:0px; height:35px; background: #888 ; margin-bottom:80px;"> <span style="position:relative; float:right; color:#FFFFFF; margin:10px; margin-top:3px; font-size:24px">Ale Florida</span> </div>
    <div id="confirmacion" style="position:fixed;  z-index:1000; top:35px; left:0px; right:0px; height:50px; background:#999; margin-bottom:80px;">
        
                
        <a href="/eficine" ><button class="boton-superior" style="cursor:pointer">Salir</button></a>
        <a href="#arriba" ><button class="boton-superior" style="cursor:pointer">Subir</button></a>
        
    </div>
    <a id="arriba"></a>  
   <!-- <div style="position:absolute; top:105px; ">
    
        <form  action="papeleria.php?email=<? echo urlencode($_GET['email']);?>" method="post" name="agregar" id="agregar" enctype="application/x-www-form-urlencoded" >
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
        <tr>
        <td>
        <label for="pueseto">Puesto</label>
        </td>
        <td>
        <input type="text" name="puesto" id="puesto" /><br />
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
        <input type="text" name="ext"  id="ext"/><br />
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
        <input type="hidden" name="email" id="email" value="<? echo $mail;?>" /><br />
        <input type="hidden" name="nueva" id="nueva" value="1" /><br />
        </form>
    	<button onclick="nueva_empresa();" name="agregar_empresa" id="agregar_empresa" >Agregar a la base de datos</button>
       
    </div>-->
   
    <div style="position:absolute; margin-top:375px;">
        <TABLE class="todas-empresas" border="0" bordercolor="#CCCCCC" style="position:relative; left:-10px;" >
            <thead>
            <TR>
            <th>#</th><th>/</th><th>Empresa</th><th>Contacto</th><th>Puesto</th><th>Tel&eacute;fono</th><th>Ext.</th><th>Mail</th><th>Notas</th><th>Unpublish</th>
            </tr></thead>
            <tbody>
			<? foreach($conjunto as $key=>$value)
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
   
<? } 

//En caso de que la sesion guardada no coincida con la sesión activa
else{header('Location: http://www.avantipictures.com/eficine/index.php');}
}?>