<?php	
//Averiguamos el usuario a través del mail especificado en la pagina de entrada   
   $mail=urldecode($_GET['email']);
   
   if($mail=="david@avantipictures.com"){
// Esta es la nueva funcion msqli que reemplaza a msql, para las funciones de base de datos.
$mysqli=new mysqli("localhost","elkinkon","4Hf3>6a*Fuk","AVANTI_PICTURES");

   if ($mysqli->connect_errno) {
    echo "Fallo al contenctar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

if($_POST['id']){
		
//En caso de recibir actualizacion, actualizamos los datos del registro 
		//Primero estos datos
		if($_POST['notas'] != date("d.m.Y")){$notas="".$_POST['notas']."<br/><hr/>";}else{$notas="";}
		$sql_update="UPDATE teatro SET obra='".$_POST['obra']."',director='".$_POST['director']."' ,eficine='".$_POST['eficine']."' ,periodo='".$_POST['periodo']."' ,genero='".$_POST['genero']."',notas='".$notas."".$_POST['notas_pasadas']."'  WHERE id=".$_POST['id']."";
		
		$mysqli->set_charset("utf8");
		$mysqli->query($sql_update);	
		
		
		
		}
		
//En caso de dar de alta un nuevo proyecto
if($_POST['efiyear']){ 
		
		$sql="INSERT INTO teatro(obra,eficine,periodo,genero) values('".$_POST['obra']."','".$_POST['efiyear']."','".$_POST['periodo']."','0')";
	$mysqli->set_charset("utf8");	

		$mysqli->query($sql);
		}
		
//Registrar las aportaciones hechas para esta pelicula
if($_POST['items_length']>0){
	
	$mysqli->set_charset("utf8");	
	 
	
		
	//Extraemos el id recien creado para esta nueva pelicula de la tabla de teatro
		$sql_2="SELECT id FROM `teatro` WHERE obra='".$_POST['obra']."'";	
		$result2=$mysqli->query($sql_2);
		$row2 = $result2->fetch_array(MYSQLI_ASSOC);
		
		
		//Insertamos cada aportacion de la pelicula que hayamos ingresado al darla de alta
		for ($i = 0; $i < $_POST['items_length']; $i++) {
			$aportante="aportante".$i;
			$id_e="id".$i;
			$cantidad="cantidad".$i;
			
    				 	$sql_3="INSERT INTO aportaciones_teatro(id_o,id_e,aportacion) values(".$row2['id'].",".$id_e.",".$cantidad.")";
						
						$mysqli->query($sql_3);

			}
		
};

$mysqli->set_charset("utf8");
   
//Extraemos los datos de todas las empreas registradas para ponerlas como opciones en el apartado de aportaciones
$sql_a="SELECT id,empresa FROM `publicidad` ORDER BY empresa ASC	";
$result=$mysqli->query($sql_a);
$row = $result->fetch_array(MYSQLI_ASSOC);
   
$cont=1;
$conjunto=array();

						while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
							$cont++;
							array_push($conjunto,"<option   id='".$row['empresa']."' value='".$row['empresa']."' data-id='".$row['id']."' ><p>".$row['empresa']."</p></option>");
							//$sql_c="UPDATE contactos SET id_contacto=".$cont." WHERE id=".$row['id']."";
							// $mysqli->query($sql_c);
							
							}
			
//Se extraen los registros de todas las peliculas	
$sql_p="SELECT id, obra, eficine, genero FROM `teatro` ORDER BY `eficine` DESC ";

						$result_p=$mysqli->query($sql_p);
						$conjunto_p=array();
						$cont_p=0;

						while ($row_p = mysqli_fetch_array($result_p, MYSQL_ASSOC)) {
							$cont_p++;
						if($row_p['genero']!='0'){$color="style='background-color:#".$row['genero'].";'";}
						else{	
						if($cont_p%2==0)
							{$color="style='background-color:#fff;'";}
						else
							{$color="style='background-color:#D8D8D8;'";}; 
						}
	
							array_push($conjunto_p, "
							<tr id='".$cont_p."' ".$color.">
								<td onclick='color(".$cont_p.",".$row_p['id'].")'>".$cont_p."</td>
								
								<td id='".$row_p['obra']."' style='padding:0px 5px;;' >
									<a href='editar_obra.php?id=".$row_p['id']."&email=".urlencode($_GET['email'])."'>
										<div class='edit' style=' width:350px; height:50px;  vertical-align:middle;'>
											<span style='position:relative; top:40%;'>".$row_p['obra']."</span>
										</div>
									</a>
								</td>
								
								<td id=''>".$row_p['eficine']."</td>
								
								
								<td>
									<button onclick='unpublish(".$row_p['id'].")'>Eliminar</button>
								</td>
						</tr>");
							}
?>
<!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html" charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title><? echo $name?> EFIICINE 189|TEATRO </title>
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

<body style="font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; background:#CCCCCC">
<div style="width:625px; height:100%; background:#FFFFFF; position:relative; margin:-10px auto; top:0px;">

<div id="locate" style="position:fixed;  z-index:1000; top:0px;  height:35px; width:625px; margin:0 auto; background: #888 ; margin-bottom:80px;"> <span style="position:relative; float:right; color:#FFFFFF; margin:10px; margin-top:3px; font-size:24px">Teatro</span> </div>

    <div id="confirmacion" style="position:fixed;  z-index:1000; top:35px; height:50px;width:625px; margin:0 auto;  background:#fff; margin-bottom:80px;">
        <a href="publicidad.php?email=<? echo urlencode($_GET['email']);?>"  ><button class="boton-superior" style="cursor:pointer">Empresas</button>	</a>
        <a href="majors.php?email=<? echo urlencode($_GET['email']);?>" ><button class="boton-superior" style="cursor:pointer">Aportantes</button></a>	
      
        <a href="majors_teatro.php?email=<? echo urlencode($_GET['email']);?>" target="_blank"  ><button class="boton-superior" style="cursor:pointer">A. Teatro</button></a>
        <a href="papeleria.php?email=<? echo urlencode($_GET['email']);?>" target="_blank" ><button class="boton-superior" style="cursor:pointer">Alianzas</button>	</a>
          <a href="/eficine" ><button class="boton-superior" style="cursor:pointer">Salir</button></a>
    </div>
    
    <div style="position:relative; top:105px; background:#FFFFFF ">
	<form  action="proyectos_alta_teatro.php?email=<? echo urlencode($_GET['email']);?>" method="post" name="agregar" id="agregar" enctype="application/x-www-form-urlencoded" >
        
        <div id="form-element">
        	<div>
	        	<label for="obra">Nombre de la obra</label>
        	</div>
        	<div>
        		<input type="text" name="obra" id="obra"/><br />
    	    </div>
       		 <div>
        		<label for="efiyear">Año de aprobaci&oacute;n</label>
        	</div>
        	<div>
        		<input type="text" name="efiyear" id="efiyear" /><br />
               
        	</div>   
            <div>
        		<label for="periodo">Periodo</label>
        	</div>
        	<div>
        		<select type="text" name="periodo" id="periodo"  size="1">
                <option>Marzo</option>
                <option>Agosto</option>
                </select><br />
               
        	</div>        
       </div>
        <div id="form-contribuyentes">
        	<div>
        		<label for="contribuyente">Contribuyentes</label>
        	</div>
        	<div id="tabla-elementos" style="position:relative; overflow:hidden; max-width:600px;">
        	</div>
       </div> 
        <div style="position:relative; padding-left:150px; height:35px; background:#FFf">
        	<select  class="campos" id="aportante" name="aportante" size="1"  >
            		<? foreach($conjunto as $key=>$value)
					{	
						echo ($value);};
         ?>
        	</select>	
        
        	<label for="cantidad">Cantidad</label><input type="text" name="cantidad" id="cantidad" />
            
        	<button type="button" id="addd">Add</button>
       </div>  
        	<button type="submit" id="remitir">Agregar</button>
            
        
        <input type="hidden" name="email" id="email" value="<? echo $mail;?>" /><br />
        <input type="hidden" name="nueva" id="nueva" value="1" /><br />
        <input type="hidden" name="items_length" id="items_length"/>
	</form>
    </div>
  <div style="position:relative; margin-top:100px; width:650px; ">
        <TABLE class="todas-empresas" border="0" bordercolor="#CCCCCC" style="position:relative; left:-10px;" >
            <thead>
            <TR>
            <th>#</th><th>Obra</th><th>Eficine</th><th>Unpublish</th>
            </tr></thead>
            <tbody>
			<? foreach($conjunto_p as $key=>$value)
					{	
						echo ($value);};
         ?></tbody>
        </TABLE>
       
   </div>  
   </div>   
        																																					</body>
        
        <script>
		
var btnAgregar = document.getElementById('addd');


var tablaElementos = document.getElementById('tabla-elementos');

var txtAportante = document.getElementById('aportante');
var txtCantidad = document.getElementById('cantidad');
var items_length= document.getElementById('items_length');
var datos = [];
var no_aportante=0;

function lamamada(name){
			var id=document.getElementById(name).getAttribute('data-id');
			alert(id);
			};
			
function myFunction(){
	
	no_aportante++;
	
	var aportante = txtAportante.value || '';
    var cantidad = txtCantidad.value || ''; 
	
	 if (!aportante || !aportante.trim().length) {
        alert('debe ingresar un aportante');
        return;
    }
    
    if (!cantidad || !cantidad.trim().length) {
        alert('debe ingresar una cantidad');
        return;
    }
	
	txtAportante.value = '';
    txtCantidad.value = '';

    txtAportante.focus();
	
	
	// JSON

    var item = {
        aportante: aportante.trim(),
        cantidad: cantidad.trim()
        
    };
	
	
	datos.push(item);
	while (tablaElementos.childElementCount > 0) {
        tablaElementos.removeChild(tablaElementos.firstElementChild);
    }

    for (var i = 0; i < datos.length; i++) {

        var elemento = datos[i];
		var namx=elemento.aportante;
		
		var div = document.createElement('div');
		var div2=document.createElement('div');
		var input = document.createElement('input');
		var input2 = document.createElement('input');
		var input3 = document.createElement('input');
		
        var span1 = document.createElement('span');
        var span2 = document.createElement('span');

		input.type="hidden";
		input.name="aportante"+i;
		input.id=input.name;
		input.value=elemento.aportante;
		
		input2.type="hidden";
		input2.name="cantidad"+i;
		input2.id=input2.name;
		input2.value=elemento.cantidad;
		
		input3.type="hidden";
		input3.name="id"+i;
		input3.id=input3.name;
		input3.value=document.getElementById(namx).getAttribute("data-id");
				
		div.style.width="440px";
		div.style.backgroundColor="#ff0f0f";
       div.appendChild(span1);
		div.appendChild(input);
     
		div2.style.width="150px";
		div2.style.backgroundColor="#00ff00";
		div2.appendChild(span2);
		div2.appendChild(input2);
		div2.appendChild(input3);
		
       span1.textContent = elemento.aportante;
       span2.textContent = elemento.cantidad;

       tablaElementos.appendChild(div);
		tablaElementos.appendChild(div2);
		 
	}
	
	items_length.value=datos.length;

<!--	document.getElementById('agregar').submit();
-->
}
btnAgregar.addEventListener('click', myFunction);
</script>	
   </html>
   <? };?>