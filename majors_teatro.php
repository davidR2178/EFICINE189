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
//Averiguamos el usuario a través del mail especificado en la pagina de entrada   
   $mail=urldecode($_GET['email']);
   
   if($mail=="david@avantipictures.com")
		{
			$uid="3";
		}
	
//Averiguamos la sesion guardada para el usuario   
   	$sql_1="SELECT phpsessid, id FROM `usuarios` WHERE email='".$mail."'";
   
   	$resultw=mysql_fetch_array(mysql_query($sql_1), MYSQL_ASSOC);

//Si la sesión guardada es la sesión activa, entonces damos acceso a la lista y sus funciones
   
	if($resultw['phpsessid']==session_id()){ 

   
	
 
	//Para desplegar la lista en caso de no que no se tenga una nueva o se tenga que actualizar alguna empresa
	//Averiguar si estas variables se pueden tomar de más arriba
	if($mail=="david@avantipictures.com")
		{
			$uid="3";
			$name="Rodrigo";
			
			$sql_b="SELECT DISTINCT `id_e` FROM `aportaciones`
ORDER BY `aportaciones`.`id_e`  ASC ";

		
		}

	
  
						//Se extraen los id de las empresas que han dado aportaciones segun el resultado de $result
						$result=mysql_query($sql_b);
						
						$conjunto=array();// Inicializamos un array que tendrá el total aportado de cada empresa como clave y su vizualizacion html como valor 
						$conjunto2=array(); //Inicializamos un array que contendrá los nombres de las empresas como clave y la cant total aportada como valor
						$efi_total=0; //Inicializamos una sumatoria para todo el dinero que se va registrando en nuestra DB
						$cont=0;
						
						//Para cada empresa hacer lo siguiente
						while ($rowz = mysql_fetch_array($result, MYSQL_ASSOC)) {
							
							$cont++;
							//Se extraen de 'publicidad' los datos de cada empresa que ha dado aportaciones segun el resultado de $result
							$sql_ide="SELECT id, empresa, prioridad FROM `publicidad` WHERE id=".$rowz['id_e']."";
							$resultz=mysql_query($sql_ide);
							//Se almacena el resultado de $resultz en el array asociativo $row
							$row = mysql_fetch_array($resultz, MYSQL_ASSOC);
							
							//Se extraen de 'aportaciones' las cantidades aportadas que cada empresa ha dado segun el resultado de $result
							$sql_aportacion="SELECT aportacion FROM `aportaciones` WHERE id_e=".$rowz['id_e']."";
							$result_aportacion=mysql_query($sql_aportacion);
							
							//Para cada aportacion segun $result_aportacion hacer lo siguinete
							while($row_aportacion=mysql_fetch_assoc($result_aportacion, MYSQL_ASSOC)){
								    //Hacer sumatoria de cada aportacion
									$total= $total + $row_aportacion['aportacion'];
									}
							//sumamos a $efi_total el total aportado de cada empresa	y damos formato al numero final	
							$efi_total=$efi_total + $total;
							$efi_total_final=money_format('%=-2#11.2n', $efi_total);
							//Vamos insertando registros en el array $conjunto2
							$conjunto2[$row['empresa']]=$total;
							//damos formato a la cantidad aportada por cada empresa desde 2006
							setlocale(LC_MONETARY, 'es_MX'); 
							$total_aportacion=money_format('%=-2#9.2n', $total);	
							
							if($cont%2==0)
								{$color="style='background-color:#fff;'";}
							else
								{$color="style='background-color:#D8D8D8;'";}; 
						
							// aqui se puede poner un query que obtenga de cada empresa o registro el numero de veces que aparece en la tabla de aportaciones, el problema es que ese dato no nos sirve de nada como html.
							
							//Insertamos los registros en el array $conjunto
							$conjunto[$total]="
							<tr id='".$cont."' ".$color.">
								<td onclick='color(".$cont.",".$row['id'].")'>".$cont."</td>
								
								<td id='".$row['empresa']."' style='padding:0px 5px;' >
									<a href='editar_empresa_publicidad.php?id=".$row['id']."&email=".urlencode($_GET['email'])."'>
										<div class='edit' style=' height:150px;  vertical-align:middle;'>
											<span style='position:relative; top:35%; padding:10px;'>".$row['empresa']."</span>
										</div>
									</a>
								</td>
								
								<td style='text-align:right; min-width:400px;' id=''>".$total_aportacion."</td>
								
						</tr>";
							$total=0;} //fin del while para rodrigo o jose
							
							arsort($conjunto2);
							//Ordenamos el array de acuerdo a la clave
							krsort($conjunto);
							
	
							
	?>
<!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html" charset="UTF-8">
<title><? echo $name?> | Empresas 189</title>
  
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
	
    <div id="confirmacion" style="position:fixed;  z-index:1000; top:0px; left:0px; right:0px; height:7%; background:#999; margin-bottom:80px;">
        
        <? if($uid==4){
			?>
        <button class="boton-superior"><a href="rodrigo.php?email=<? echo urlencode($_GET['email']);?>" target="_blank" >Rodrigo</a></button>
        <? } if($uid==3){
			?>
        <a href="jose.php?email=<? echo urlencode($_GET['email']);?>" target="_blank"  ><button class="boton-superior" style="cursor:pointer">Jos&eacute;</button></a>	
        <? }
		?>
        <a href="empresas226.php" target="_blank" ><button class="boton-superior" style="cursor:pointer">Lista 2</button>	</a>
        <a href="basura.php?email=<? echo urlencode($_GET['email']);?>" target="_blank" ><button class="boton-superior" style="cursor:pointer">Basura</button>	</a>
        <a href="/eficine" ><button class="boton-superior" style="cursor:pointer">Salir</button></a>
        <a href="#arriba" ><button class="boton-superior" style="cursor:pointer">Subir</button></a>
        
    </div>
    <a id="arriba"></a>  
    
   
    <div style="position:absolute; margin-top:42px;">
        <TABLE class="todas-empresas" border="0" style="position:relative; left:-4px; " >
            <thead>
            <TR>
            <th>#</th><th>Empresa</th> </tr></thead>
            <tbody>
			<? foreach($conjunto as $key=>$value)
					{	
						echo ($value);};
         ?></tbody>
        </TABLE>
       
   </div>
   <script>
   if(screen.width<940){document.getElementByClass("todas_empresas").style.fontSize="16px";};
   </script>
   </body>
   </html>
   
<? } 

//En caso de que la sesion guardada no coincida con la sesión activa
else{echo "".$mail." no puedes acceder sin credenciales <a href='/eficine'>Volver</a>"; }
   
   
}

//--------------------------------------------------------------------------------------------------------------------------------------------------
// VERSIÓN DE ESCRITORIO -------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------


else{
    

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
	
//Averiguamos la sesion guardada para el usuario   
   	$sql_1="SELECT phpsessid, id FROM `usuarios` WHERE email='".$mail."'";
   
   	$resultw=mysql_fetch_array(mysql_query($sql_1), MYSQL_ASSOC);

//Si la sesión guardada es la sesión activa, entonces damos acceso a la lista y sus funciones
   
	if($resultw['phpsessid']==session_id()){ 

   
	
 
	//Para desplegar la lista en caso de no que no se tenga una nueva o se tenga que actualizar alguna empresa
	//Averiguar si estas variables se pueden tomar de más arriba
	if($mail=="david@avantipictures.com")
		{
			$uid="3";
			$name="Rodrigo";
			
			$sql_b="SELECT DISTINCT `id_e` FROM `aportaciones_teatro`
ORDER BY `aportaciones_teatro`.`id_e`  ASC ";

		
		}

	
  
						//Se extraen de 'aportaciones' los id_e de las empresas que han dado aportaciones, el DISTINCT evita que el id_e se repita, ya que una misma empresa ha dado varias aportaciones y por lo tanto tiene varios registros en la tabla
						$result=mysql_query($sql_b);
						
						$conjunto=array();// Inicializamos un array que tendrá el total aportado de cada empresa como clave y su vizualizacion html como valor 
						$conjunto2=array(); //Inicializamos un array que contendrá los nombres de las empresas como clave y la cant total aportada como valor
						$efi_total=0; //Inicializamos una sumatoria para todo el dinero que se va registrando en nuestra DB
						
						$rowf=array();
						
						$cont=0;
						
						//Para cada empresa hacer lo siguiente
						while ($rowz = mysql_fetch_array($result, MYSQL_ASSOC)) {
							
							$cont++;
							//Se extraen de 'publicidad' los datos de la empresa que ha dado aportaciones segun el resultado de $result
							$sql_ide="SELECT id, empresa, prioridad FROM `publicidad` WHERE id=".$rowz['id_e']."";
							$resultz=mysql_query($sql_ide);
							//Se almacena el resultado de $resultz en el array asociativo $row
							$row = mysql_fetch_array($resultz, MYSQL_ASSOC);
							//Esta es otra forma de lamaenar los datos en un array
							array_push($rowf,$row['empresa']);
							
							//Se extraen de 'aportaciones' las cantidades aportadas que cada empresa ha dado segun el resultado de $result
							$sql_aportacion="SELECT aportacion FROM `aportaciones_teatro` WHERE id_e=".$rowz['id_e']."";
							$result_aportacion=mysql_query($sql_aportacion);
							
							//Para cada aportacion segun $result_aportacion hacer lo siguinete
							while($row_aportacion=mysql_fetch_assoc($result_aportacion, MYSQL_ASSOC)){
								    //Hacer sumatoria de cada aportacion
									$total= $total + $row_aportacion['aportacion'];
									}
							//sumamos a $efi_total el total aportado de cada empresa	y damos formato al numero final	
							$efi_total=$efi_total + $total;
							$efi_total_final=money_format('%=-2#11.2n', $efi_total);
							//Vamos insertando registros en el array $conjunto2
							$conjunto2[$row['empresa']]=$total;
							//damos formato a la cantidad aportada por cada empresa desde 2006
							setlocale(LC_MONETARY, 'es_MX'); 
							$total_aportacion=money_format('%=-2#9.2n', $total);	
							
							if($cont%2==0)
								{$color="style='background-color:#fff;'";}
							else
								{$color="style='background-color:#D8D8D8;'";}; 
						
							// aqui se puede poner un query que obtenga de cada empresa o registro el numero de veces que aparece en la tabla de aportaciones, el problema es que ese dato no nos sirve de nada como html.
							
							//Insertamos los registros en el array $conjunto
							$conjunto[$total]="
							
								
								<td id='".$row['empresa']."' style='padding:0px 5px; width=300px;' >
									<a href='editar_empresa_publicidad.php?id=".$row['id']."&email=".urlencode($_GET['email'])."'>
										<div class='edit' style=' width:350px; height:50px;  vertical-align:middle;'>
											<span style='position:relative; top:40%;'>".$row['empresa']."</span>
										</div>
									</a>
								</td>
							
								<td style='text-align:right; min-width:100px;' id=''>".$total_aportacion."</td>";
								
							$total=0;} //fin del while para rodrigo o jose
							
							arsort($conjunto2);
							//Ordenamos el array de acuerdo a la clave
							krsort($conjunto);
							$num=0;
							
	
	?>
<!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html" charset="UTF-8">
<title><? echo $name?> | A. Teatro</title>
  
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
		case 4: if(b==a){xy++; document.getElementById(a).style.backgroundColor='#ffcc00';db_color(z,"ffcc00");}
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
		
		xmlhttp.open("GET","cambiar_color.php?id="+id+"&color="+color,true);
		
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		
		xmlhttp.send();
}
</script>
<style> 
html{ font-size:12px; }
.nueva-empresa input{ height:20px;} .nueva-empresa td{ height:25px;} .todas-empresas td{ padding:5px; } .todas-empresas{ position:relative; width:620px; margin:0 auto} </style>
<style>
a:link{ text-decoration:none; color:#000 }
.boton-superior{ position:relative; float:left; width:20%; height:50px; background-color:#CCFF33; color:#0000FF; border-width:thin; border-color:#FFFFFF}
.boton-superior:hover{ background-color: #66CC00}
.edit:hover{ background-color:#999999}
#form-element{ position:relative; width:400px; overflow:hidden; background:#FFF; padding:5px;}
#form-element div{ position:relative; width:150px; float:left; height:35px; }
#form-contribuyentes{ position:relative; max-width:650px; overflow:hidden; background:#FFf; padding:5PX;}
#form-contribuyentes div{ position:relative; min-width:150px; float:left; min-height:35px; background:#FFf;}
</style>
</head>

<body style="font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif; background-color:#999999">

<div style="width:625px; height:100%; background:#FFFFFF; position:relative; margin:-10px auto; top:0px;">
<? $var=json_encode($conjunto2);  ?>
<div id="locate" style="position:fixed;  z-index:1000; top:0px;  height:35px; width:625px; margin:0 auto; background: #888 ; margin-bottom:80px;"> 
	<span style="position:relative; float:right; color:#FFFFFF; margin:10px; margin-top:3px; font-size:24px">Contribuyentes Teatro</span> 
</div>
    <div id="confirmacion" style="position:fixed;  z-index:1000; top:35px; height:100px;width:625px; margin:0 auto;  background:#fff; margin-bottom:80px;">
        
        <a href="publicidad.php?email=<? echo urlencode($_GET['email']);?>"  ><button class="boton-superior" style="cursor:pointer">Empresas</button>	</a>
        <a href="proyectos_alta.php?email=<? echo urlencode($_GET['email']);?>" ><button class="boton-superior" style="cursor:pointer">Pel&iacute;culas</button></a>	
      
        <a href="proyectos_alta_teatro.php?email=<? echo urlencode($_GET['email']);?>" target="_blank"  ><button class="boton-superior" style="cursor:pointer">Obras</button></a>
        <a href="papeleria.php?email=<? echo urlencode($_GET['email']);?>" target="_blank" ><button class="boton-superior" style="cursor:pointer">Alianzas</button>	</a>
          <a href="/eficine" ><button class="boton-superior" style="cursor:pointer">Salir</button></a>
        <a href="majorsforyear_teatro.php?email=<? echo urlencode($_GET['email']);?>&year=2018"   ><button class="boton-superior" style="cursor:pointer">2018</button></a>
        <a href="majorsforyear_teatro.php?email=<? echo urlencode($_GET['email']);?>&year=2017"  ><button class="boton-superior" style="cursor:pointer">2017</button></a>
        <a href="majorsforyear_teatro.php?email=<? echo urlencode($_GET['email']);?>&year=2016"  ><button class="boton-superior" style="cursor:pointer">2016</button></a>
        <a href="majorsforyear_teatro.php?email=<? echo urlencode($_GET['email']);?>&year=2015"  ><button class="boton-superior" style="cursor:pointer">2015</button></a>
        <a href="majorsforyear_teatro.php?email=<? echo urlencode($_GET['email']);?>&year=2014"  ><button class="boton-superior" style="cursor:pointer">2014</button></a>
    </div>
    <a id="arriba"></a>  
    
     <div style="position:relative; margin-top:145px; width:650px; ">
        <TABLE class="todas-empresas" border="0" bordercolor="#CCCCCC" style="position:relative; left:-10px;" >
            <thead>
            <TR>
            <th>#</th><th style="min-width:350px; ">Empresa</th><th style="min-width:150px; ">Aportaciones totales</th>
            </tr></thead>
            <tbody>
			<? foreach($conjunto as $key=>$value)
					{	$num++;
						echo ('<tr><td>'.$num.'</td>'.$value.'</tr>');};
         ?>
         	<tr style='padding:0px 5px; width=300px;'><td  style='padding:0px 5px; width=300px;'></td><td >Aportacion total</td><td style='text-align:right; min-width:100px;'><? echo $efi_total_final?></td>
            </tr>
         </tbody>
        </TABLE>
       
   </div>
   <script>
   if(screen.width<840){document.getElementByClass("todas_empresas").style.fontSize="24px";};
   </script>
   </div>
   </body>
   </html>
   
<? } 

//En caso de que la sesion guardada no coincida con la sesión activa
else{header('Location:http://www.avantipictures.com/eficine/index.php');}

}?>