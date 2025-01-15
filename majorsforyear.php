<?php
//iniciamos una sesión
session_start();
// Esta es la nueva funcion msqli que reemplaza a msql, para las funciones de base de datos.
$mysqli=new mysqli("localhost","root","root","AVANTI_PICTURES");

   if ($mysqli->connect_errno) {
    echo "Fallo al contenctar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
//Averiguamos el usuario a través del mail especificado en la pagina de entrada   
$mail=urldecode($_GET['email']);   
if($mail=="david@avantipictures.com"){
	$uid="3";
}	
//Averiguamos la sesion guardada para el usuario   
$sql_1="SELECT phpsessid, id FROM `usuarios` WHERE email='".$mail."'";
$resultw=$mysqli->query($sql_1);
echo($mysqli->affected_rows);echo($mysqli->affected_rows);
$row_w = $resultw->fetch_array(MYSQLI_ASSOC);
//Si la sesión guardada es la sesión activa, entonces damos acceso a la lista y sus funciones
if($row_w['phpsessid']==session_id()){ 
	
	//Para desplegar la lista en caso de no que no se tenga una nueva o se tenga que actualizar alguna empresa
	//Averiguar si estas variables se pueden tomar de más arriba
	if($mail=="david@avantipictures.com")
		{
			$uid="3";
			$name="Rodrigo";
//---------------------------------------------------------------------------------------------------------------------------------------------							

			//Este query especifica los id de las peliculas en el año especificado en el GET
			$sql_b="SELECT id FROM `peliculas` WHERE eficine='".$_GET['year']."'";	
		
		}
	  
						//Se extraen los id de las peliculas que han sido apoyadas en el año especificado en el GET segun eñ query $sql_b
						$result=$mysqli->query($sql_b);
						
//---------------------------------------------------------------------------------------------------------------------------------------------							
//Se incializan todos los arrays o conjuntos que cçnecesitaremos para organizar la informacion
						
						$conjunto=array();// Inicializamos un array que tendrá el total aportado de cada empresa como clave y su vizualizacion html como valor 
						$conjuntob=array();// Inicializamos un array que tendrá el total aportado de cada empresa como clave y su vizualizacion html como valor 
						$conjunto2=array();// Inicializamos un array que almacenará los ID de la empresas que aportaron en el año solicitado 
						$conjunto3=array();// Inicializamos un array que almacenará los id de las peliculas del año solicitado
						$conjunto4=array();
						$conjunto_all=array();// Inicializamos un array que almacenará los ID de todas las empreseas que han aportado desde el inicio 
						$conjunto_all_ordenado=array();// Inicializamos un array que tendrá el total aportado de cada empresa como clave y su vizualizacion html como valor 
						$conjunto_excluido=array();// Inicializamos un array que tendrá el total aportado de cada empresa como clave y su vizualizacion html como valor 
//---------------------------------------------------------------------------------------------------------------------------------------------							
						
						$cont=0;
						$contb=0;
						
//---------------------------------------------------------------------------------------------------------------------------------------------							
						
						//ya tenemos las pelis apoyadas durante el año seleccionado
						//necesitamos extrar los id de las empresas que apoyaron a esa pelis
						//Para cada pelicula del $result hacer lo siguiente:
	
						while ($rowz = $result->fetch_array(MYSQLI_ASSOC)) {																				
							//Se extraen de 'aportaciones' los id_e de las empresas que aportaron a la pelicula que se esta procesando y se ordenan de manera ascendente
							$sql_aportacion="SELECT id_e, id_p FROM `aportaciones` WHERE id_p=".$rowz['id']." ORDER BY id_e DESC";
							$result_aportacion=$mysqli->query($sql_aportacion);							
							//Se almacena el resultado de $result_aportacion en el array asociativo $rowd
							while ($rowd = $result_aportacion->fetch_array(MYSQLI_ASSOC)){
							//en el array $conjunto2, inicializado arriba y afuera de este while, almacenamos los id_e de la empresa que aporto a la pelicula actual del año solicitado
								array_push($conjunto2,$rowd['id_e']);
							}							
							//Por tanto, $conjunto2 contiene todos los id_e de las empresas que aportaron en el año solicitado, en bruto.
							//Podemos solicitar los id_e de todas las empresas que han aportado y almacenar los datos en otro array (como en majors.php), pero hay que hacerlo afuera de este while.
																																									
							//aqui almacenamos los id de las peliculas del año solicitado
							array_push($conjunto3,$rowz['id']);														
						}//fin del while que extrae el conjunto de empresas que aportaron a las pelicualas del año solicitado en el GET
							
						//	
						$conjunto2_ordenado=array_unique($conjunto2); // esto sirve para depurar el conjunto y no se repitan los valores
						sort($conjunto2_ordenado);//uan vez depurado se ordena el array de menor a mayor, este array finalmente hasta aqui contiene los id_e de las empresas que apoyaron durtante el año seleccionado
						$conjunto3_ordenado=array_unique($conjunto3); // esto sirve para depurar el conjunto y no se repitan los valores
						sort($conjunto3_ordenado);
//---------------------------------------------------------------------------------------------------------------------------------------------							
							
						//Se extraen los id_e de todas las empresas que han aportado
						$sql_all="SELECT DISTINCT id_e FROM `aportaciones` ORDER BY `id_e` DESC	";
						$result_all=$mysqli->query($sql_all);
																										
						while ($row_all = $result_all->fetch_array(MYSQLI_ASSOC)) {
								//aqui almacenadmos los id_e de todas las empresas que han aportado
								array_push($conjunto_all,$row_all['id_e']);		
							}
						//ordenamos el array de menor a mayor
						sort($conjunto_all);
						
						// los valores se almacenan en $conjunto_all_ordenado								
							$conjunto_all_ordenado=array_values($conjunto_all);
							$r=count($conjunto_all_ordenado);
							
						// quitar de $conjunto_all todas las empresas de $conjunto2
						// para cada registro del array $conjunto2_ordenado... haz lo siguiente
						foreach($conjunto2_ordenado as $value){
							//revisa cada empresa de las que han dado dinero, itera cada registro del array $conjunto_all_ordenado[
							for($i=0; $i<=$r; $i++){
								//si llegan a coincidir los valores
								if($conjunto_all_ordenado[$i]==$value){
									//quita tal registro
									unset($conjunto_all_ordenado[$i]);
									//array_push($conjunto_excluido,$conjunto_all_ordenado[$i]);
									$conjunto_all_ordenado=array_values($conjunto_all_ordenado);
									break;
									//nos esta arrojando un PHP NOTICE, me parece que tiene que ver con que se elimina un registro del array, es decir se elimina una key. Por lo que en la siguientes iteraciones está haciendo falta esa key. No sé de que manera se pueda solucionar. Lo solucioné con array_values.
								}			
							};		
						}
						
						
//---------------------------------------------------------------------------------------------------------------------------------------------							
							
							foreach($conjunto_all_ordenado as &$valor){
								    //Se extraen de 'publicidad' los datos de cada empresa que ha dado aportaciones segun el resultado de $result_aportacion
									$contb++;
									$sql_ide_not="SELECT id, empresa, prioridad FROM `publicidad` WHERE id=".$valor." ORDER BY prioridad DESC";
									$result_not=$mysqli->query($sql_ide_not);
									//Se almacena el resultado de $resultz en el array asociativo $row
									$row_not = $result_not->fetch_array(MYSQLI_ASSOC);
									if($row_not['prioridad']!='0'){
										$color="style='background-color:#".$row_not['prioridad']."; position:relative; width:625px; height:50px; margin:2px;'";
									}
									else{	
										if($cont%2==0){
											$color="style='background-color:#fff; position:relative; width:625px; height:50px; margin:2px;'";
										}
										else{
											$color="style='background-color:#D8D8D8; position:relative; width:625px; height:50px; margin:2px;'";
										}; 
									}
									//Insertamos los registros en el array $conjunto
									array_push($conjuntob,"
										<tr id='".$contb."' ".$color.">
											<td onclick='color(".$contb.",".$row_not['id'].")'>".$contb."</td>
								
											<td id='".$row_not['empresa']."' style='padding:0px 5px; width=300px;' >
												<a href='editar_empresa_publicidad.php?id=".$row_not['id']."&email=".urlencode($_GET['email'])."'>
													<div class='edit' style=' width:350px; height:50px;  vertical-align:middle;'>
														<span style='position:relative; top:40%;'>".$row_not['empresa']."</span>
													</div>
												</a>
											</td>
											<td></td>																
										</tr>");
								
									$totalb=0;
									
							}//fin del foreach
							//---------------------------------------------------------------------------------------------------------------------------------------------							

							
							$resultadod = array_unique($conjunto2_ordenado);//no se porqué he tenido que volvera depurar este array
						

							//Para cada empresa que aporto durante este año, hacer lo siguiente
							foreach($resultadod as &$valor){
								    //Se extraen de 'publicidad' los datos de cada empresa que ha dado aportaciones segun el resultado de $result_aportacion
									$cont++;
									$sql_ide="SELECT id, empresa, prioridad, fecha FROM `publicidad` WHERE id=".$valor."  ORDER BY prioridad DESC";
									$resultz=$mysqli->query($sql_ide);
								
									//Aqui deberian poder extraerse las aportaciones de  esta empresa durante el año y sumarlas, pero no se puede porque la tabla de aportaciones no incluye el año de la aportacion
									//Es posible. En la actual iteracion del foreach tengo el id_e, podria meter un while para que en base al id_e en curso, siento que no se puede, tendrian que ser dos veces porque es posible que un id_e haya apoyado varias id_p
									
								
									//Se almacena el resultado de $resultz en el array asociativo $row
									$row = $resultz->fetch_array(MYSQLI_ASSOC);
									if($row['prioridad']!='0'){
										$color="style='background-color:#".$row['prioridad']."; position:relative; width:625px; height:50px; margin:2px;'";
									}
									else{	
										if($cont%2==0){
											$color="style='background-color:#fff; position:relative; width:625px; height:50px; margin:2px;'";
										}
										else{
											$color="style='background-color:#D8D8D8; position:relative; width:625px; height:50px; margin:2px;'";
										}; 
									}					
									//Insertamos los registros en el array $conjunto
									array_push($conjunto,"
										<tr id='".$cont."' ".$color.">
											<td onclick='color(".$cont.",".$row['id'].")'>".$cont."</td>
											
											<td id='".$row['empresa']."' style='padding:0px 5px; width=300px;' >
												<a href='editar_empresa_publicidad.php?id=".$row['id']."&email=".urlencode($_GET['email'])."'>
													<div class='edit' style=' width:350px; height:50px;  vertical-align:middle;'>
														<span style='position:relative; top:40%;'>".$row['empresa']."</span>
													</div>
												</a>
											</td>
											<td></td>
											
											
									</tr>"
									);
						
							$total=0;
							} //fin del while para rodrigo o jose
							
							sort($conjunto, SORT_NATURAL);
							
	
	?>
<!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html" charset="UTF-8">
<title>APORTANTES <?php echo $_GET['year']?></title>
  
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
<body background="img/dark-triangles.png"  style="font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif; background-color:#999999">
    <div style="width:625px; height:100%; background:#FFFFFF; position:relative; margin:-10px auto; top:0px;">
    <?php $var=json_encode($conjunto2);  ?>
        <div id="locate" style="position:fixed;  z-index:1000; top:0px;  height:35px; width:625px; margin:0 auto; background: #888 ; margin-bottom:80px;"> 
            <span style="position:relative; float:right; color:#FFFFFF; margin:10px; margin-top:3px; font-size:24px">Contribuyentes <?php echo $_GET['year'] ?></span> 
        </div>
        <div id="confirmacion" style="position:fixed;  z-index:1000; top:35px; height:100px;width:625px; margin:0 auto;  background:#fff; margin-bottom:80px;">        
            <a href="publicidad.php?email=<?php echo urlencode($_GET['email']);?>"  ><button class="boton-superior" style="cursor:pointer">Empresas</button>	</a>
            <a href="proyectos_alta.php?email=<?php echo urlencode($_GET['email']);?>" ><button class="boton-superior" style="cursor:pointer">Pel&iacute;culas</button></a>	
            <a href="jose.php?email=<?php echo urlencode($_GET['email']);?>" target="_blank"  ><button class="boton-superior" style="cursor:pointer">Jos&eacute;</button></a>
            <a href="papeleria.php?email=<?php echo urlencode($_GET['email']);?>" target="_blank" ><button class="boton-superior" style="cursor:pointer">Alianzas</button>	</a>
            <a href="/eficine" ><button class="boton-superior" style="cursor:pointer">Salir</button></a>
            <a href="majorsforyear.php?email=<?php echo urlencode($_GET['email']);?>&year=2019"   ><button class="boton-superior" style="cursor:pointer">2019</button></a>
            <a href="majorsforyear.php?email=<?php echo urlencode($_GET['email']);?>&year=2018"  ><button class="boton-superior" style="cursor:pointer">2018</button></a>
            <a href="majorsforyear.php?email=<?php echo urlencode($_GET['email']);?>&year=2017"  ><button class="boton-superior" style="cursor:pointer">2017</button></a>
            <a href="majorsforyear.php?email=<?php echo urlencode($_GET['email']);?>&year=2016"  ><button class="boton-superior" style="cursor:pointer">2016</button></a>
            <a href="majorsforyear.php?email=<?php echo urlencode($_GET['email']);?>&year=2015"  ><button class="boton-superior" style="cursor:pointer">2015</button></a>        
        </div>
        <a id="arriba"></a>      
        <div style="position:relative; margin-top:145px; width:650px; ">
            <TABLE class="todas-empresas" border="0" bordercolor="#CCCCCC" style="position:relative; left:-10px;" >
                <thead>
                    <TR>
                        <th>#</th><th style="min-width:350px; ">Empresa</th><th style="min-width:150px; ">Aportaciones totales</th>
                    </tr>
               </thead>
                <tbody>
                    <?php foreach($conjunto as $key=>$value)
                     {	
                          echo ($value);
                        };?>         	
             </tbody>
            </TABLE>
           <br><br>
           <TABLE class="todas-empresas" border="0" bordercolor="#CCCCCC" style="position:relative; left:-10px;" >
                <thead>
                <TR style="background:#CCFF33; height:50px;">
                        <th>#</th><th style="min-width:350px; ">Empresa</th><th style="min-width:150px; ">Aportaciones totales</th>
                    </tr>
               </thead>
                <tbody>
                <?php foreach($conjuntob as $key=>$value)
                        {	
                            echo ($value);
                    };?>         	
               </tbody>
            </TABLE>
       </div>	<?php print_r($conjunto_excluido);?>
       <script>
       if(screen.width<840){document.getElementByClass("todas_empresas").style.fontSize="24px";};
       </script>
       <?php 	var_dump($conjunto3_ordenado);?>
    </div>
</body>
</html>   
<?php }
//En caso de que la sesion guardada no coincida con la sesión activa
else{header('Location:http://www.avantipictures.com/eficine/index.php');}
?>