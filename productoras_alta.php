<?php	
//Averiguamos el usuario a través del mail especificado en la pagina de entrada   
   $mail=urldecode($_GET['email']);
   
   if($mail=="david@avantipictures.com"){
// Esta es la nueva funcion msqli que reemplaza a msql, para las funciones de base de datos.
$mysqli=new mysqli("localhost","root","root","AVANTI_PICTURES");

   if ($mysqli->connect_errno) {
    echo "Fallo al contenctar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

if($_POST['id']){
		
//En caso de recibir actualizacion, actualizamos los datos del registro 
		//Primero estos datos
		if($_POST['notas'] != date("d.m.Y")){$notas="".$_POST['notas']."<br/><hr/>";}else{$notas="";}
		$sql_update="UPDATE productoras SET productora='".$_POST['productora']."', notas='".$notas."".$_POST['notas_pasadas']."'  WHERE id=".$_POST['id']."";
		
		$mysqli->set_charset("utf8");
		$mysqli->query($sql_update);	
		
		
		
		}
		
//En caso de dar de alta un nuevo proyecto
if($_POST['efiyear']){ 
		
		$sql="INSERT INTO productoras(productora,notas) values('".$_POST['productora']."','')";
	$mysqli->set_charset("utf8");	

		$mysqli->query($sql);
	 printf("Errormessage: %s\n", $mysqli->error);
		//Extraemos el id recien creado para esta nueva pelicula de la tabla de peliculas
		$sql_2="SELECT id FROM `productoras` WHERE productora='".$_POST['productora']."'";	
		$result2=$mysqli->query($sql_2);
		$row2 = $result2->fetch_array(MYSQLI_ASSOC);
		
		}
		


$mysqli->set_charset("utf8");
   
//Extraemos los datos de todas las empreas registradas para ponerlas como opciones en el apartado de prospectos
$sql_a="SELECT id, productora FROM `productoras` ORDER BY productora DESC";
$result=$mysqli->query($sql_a);
	   echo("1intento".$mysqli->affected_rows);
	   printf("Errormessage1: %s\n", $mysqli->error);
	   
//$row = $result->fetch_array(MYSQLI_ASSOC);
   
$cont=1;
$conjunto=array();

						while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
							$cont++;
							array_push($conjunto,"<option   id='".$row['productora']."' value='".$row['productora']."' data-id='".$row['id']."' ><p>".$row['productora']."</p></option>");
							//$sql_c="UPDATE contactos SET id_contacto=".$cont." WHERE id=".$row['id']."";
							// $mysqli->query($sql_c);
							
							}
			
//Se extraen los registros de todas las productoras	
$sql_p="SELECT id, productora FROM `productoras` ORDER BY productora ASC";

						$result_p=$mysqli->query($sql_p);
	   echo("2intento".$mysqli->affected_rows);
	    printf("Errormessage2: %s\n", $mysqli->error);
						$conjunto_p=array();
						
						$conjunto_tt=array();
						$cont_p=0;
						$cont_cont=0;

						while ($row_p = $result_p->fetch_array(MYSQLI_ASSOC)) {
						
							if($cont_cont%2==0)
								{$color="#fff;";}
							else
								{$color="#D8D8D8;";}; 
						
							$sql_tt="SELECT id FROM `peliculas` WHERE erpip='".$row_p['productora']."'";
							
							$result_tt=$mysqli->query($sql_tt);
							
							//$row_tt = $result_tt->fetch_array(MYSQLI_ASSOC);
							$row_cnt = $result_tt->num_rows;
							//echo($row_p['productora']);
							array_push($conjunto_tt,array($row_p['id'],$row_cnt));
						
							
							array_push($conjunto_p, array($row_cnt, "
							
								
								<td id='".$row_p['productora']."' style='padding:0px 5px; background;".$color."' >
									<a href='editar_productora.php?id=".$row_p['id']."&email=".urlencode($_GET['email'])."'>
										<div class='edit' style=' width:350px; height:50px;  vertical-align:middle;'>
											<span style='position:relative; top:40%;'>".$row_p['productora']." (".$row_cnt.")</span>
										</div>
									</a>
								</td>
								
								
								
								
								<td>
									<button onclick='unpublish(".$row_p['id'].")'>Eliminar</button>
								</td>
						"));$cont_cont++;
							} arsort($conjunto_p);//array_values($conjunto_p);//echo(count($conjunto_tt));print_r($conjunto_tt);
?>
<!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html" charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>PRODUCTORAS</title>
<style> 
html{ font-size:12px;}
.nueva-empresa input{ height:20px;} .nueva-empresa td{ height:15px;} .todas-empresas td{ padding:5px; } .todas-empresas th{ background:#CCC;} .todas-empresas{ position:relative; width:620px; margin:0 auto} </style>
<style>
a:link{ text-decoration:none; color:#000 }
.boton-superior{ position:relative; float:left; width:20%; height:50px; background-color:#66FFFF; color:#0000FF; border-width:thin; border-color:#FFFFFF}
.boton-superior:hover{ background-color: #00CCCC}
.edit:hover{ background-color:#999999}
#form-element{ position:relative; width:400px; overflow:hidden; background:#FFF; padding:5px;}
#form-element div{ position:relative; width:150px; float:left; height:35px; }
#form-contribuyentes{ position:relative; max-width:650px; overflow:hidden; background:#FFf; padding:5PX;}
#form-contribuyentes div{ position:relative; min-width:150px; float:left; min-height:35px; background:#FFf;}

</style>

</head>

<body style="font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;" background="img/dark-triangles.png" >
<div style="width:625px;  background:#FFFFFF; position:relative; margin:-10px auto; top:0px;">

<div id="locate" style="position:fixed;  z-index:1000; top:0px;  height:35px; width:625px; margin:0 auto; background: #888 ; margin-bottom:80px;"> <span style="position:relative; float:right; color:#FFFFFF; margin:10px; margin-top:3px; font-size:24px">PRODUCTORAS</span> </div>

    <div id="confirmacion" style="position:fixed;  z-index:1000; top:35px; height:50px;width:625px; margin:0 auto;  background:#fff; margin-bottom:80px;">
        <a href="publicidad.php?email=<?php echo urlencode($_GET['email']);?>"  ><button class="boton-superior" style="cursor:pointer">Empresas</button>	</a>
        <a href="majors.php?email=<?php echo urlencode($_GET['email']);?>" ><button class="boton-superior" style="cursor:pointer">Aportantes</button></a>	
      
        <a href="proyectos_alta.php?email=<?php echo urlencode($_GET['email']);?>" target="_blank"  ><button class="boton-superior" style="cursor:pointer">Pel&iacute;culas</button></a>
        <a href="papeleria.php?email=<?php echo urlencode($_GET['email']);?>" target="_blank" ><button class="boton-superior" style="cursor:pointer">Alianzas</button>	</a>
          <a href="/eficine" ><button class="boton-superior" style="cursor:pointer">Salir</button></a>
    </div>
    
    <div style="position:relative; top:105px; background:#FFFFFF ">
	<form  action="productoras_alta.php?email=<?php echo urlencode($_GET['email']);?>" method="post" name="agregar" id="agregar" enctype="application/x-www-form-urlencoded" >
        
        <div id="form-element">
        	<div>
	        	<label for="productora">Nombre de la Productora</label>
        	</div>
        	<div>
        		<input type="text" name="productora" id="productora"/><br />
    	    </div>
       		 <div>
	        	<label for="efiyear">AÑO</label>
        	</div>
        	<div>
        		<input type="text" name="efiyear" id="efiyear" /><br />
               
        	</div>   
            
        	
       </div>
        
        	<button type="submit" id="remitir">Agregar</button>
            
        
        <input type="hidden" name="email" id="email" value="<?php echo $mail;?>" /><br />
        <input type="hidden" name="nueva" id="nueva" value="1" /><br />
        <input type="hidden" name="items_length" id="items_length"/>
	</form>
    </div>
  <div style="position:relative; margin-top:100px; width:650px; ">
        <TABLE class="todas-empresas" border="0" bordercolor="#CCCCCC" style="position:relative; left:-10px;" >
            <thead>
            <TR>
            <th>#</th><th>Pelicula</th><th>Eficine</th><th>Unpublish</th>
            </tr></thead>
            <tbody>
			<?php foreach($conjunto_p as $key=>$value)
					{	$cont_p++;
						echo ("<tr><td>".$cont_p."</td>".$value[1])."</tr>";}
						
         ?></tbody>
        </TABLE>
        <TABLE class="todas-empresas" border="0" bordercolor="#CCCCCC" style="position:relative; left:-10px;" >
        </TABLE>
       
   </div>  
</div>   
        																																					</body>
        
      
   </html>
   <?php };?>