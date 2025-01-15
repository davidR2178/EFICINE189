<?php	
// Esta es la nueva funcion msqli que reemplaza a msql, para las funciones de base de datos.
$mysqli=new mysqli("localhost","elkinkon","4Hf3>6a*Fuk","AVANTI_PICTURES");

   if ($mysqli->connect_errno) {
    echo "Fallo al contenctar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
   $mysqli->set_charset("utf8");
   
   //En caso de registrar la aportacion de un nuevo contribuyente
   
   if($_POST['items_length']>0){
 
$mysqli->set_charset("utf8");
	 	//Insertamos el nuevo registro del contribuyente aportante
	 	
		
		
		
		
		for ($i = 0; $i < $_POST['items_length']; $i++) {
			$aportante="aportante".$i;
			$id_e="id".$i;
			
			$cantidad="cantidad".$i;
			
    				 	$sql_3="INSERT INTO aportaciones_teatro(id_o,id_e,aportacion) values(".$_GET['id'].",".$_POST[$id_e].",".$_POST[$cantidad].")";
						$mysqli->query($sql_3);

}
		
};
 
//Extraemos los datos de todas la obras registradas en la tabla teatro
   $sql_b="SELECT id, director, obra, eficine, periodo, genero, notas FROM `teatro` WHERE id=".$_GET['id']."";
   
   $result=$mysqli->query($sql_b);
   $row = $result->fetch_array(MYSQLI_ASSOC);
   $mail=urldecode(($_GET['email']));
//Extraemos los datos de todas las aportaciones echas a cada obra
 $sql_c="SELECT id, id_e, aportacion FROM `aportaciones_teatro` WHERE id_o=".$_GET['id']."";
 $result_c=$mysqli->query($sql_c);
 
 //Extraemos la lista de empresas 
 $mysqli->set_charset("utf8");
   $sql_a="SELECT id,empresa FROM `publicidad` ORDER BY empresa ASC	";
   $result_a=$mysqli->query($sql_a);
   $row_a = $result_a->fetch_array(MYSQLI_ASSOC);
   
   $cont=1;
   $conjunto=array();

						while ($row_a = mysqli_fetch_array($result_a, MYSQL_ASSOC)) {
							$cont++;
							array_push($conjunto,"<option   id='".$row_a['empresa']."' value='".$row_a['empresa']."' data-id='".$row_a['id']."' ><p>".$row_a['empresa']."</p></option>");
							//$sql_c="UPDATE contactos SET id_contacto=".$cont." WHERE id=".$row['id']."";
							// $mysqli->query($sql_c);
							
							}
 
	 


//--------------------------------------------------------------------------------------------------------------------------------------------------
// VERSIÓN DE ESCRITORIO -------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------


	 
	   ?>
<!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html" charset="UTF-8">
<title><? echo $name?>EDITOR | OBRAS </title>
<style> 
html{ font-size:14px; font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif}
.nueva-empresa input{ height:20px;} .nueva-empresa td{ height:15px;} .todas-empresas td{ padding:5px; } .todas-empresas th{ background:#CCC;}  </style>
<style>
a:link{ text-decoration:none; color:#000 }
.boton-superior{ position:relative; float:left; width:20%; height:50px; background-color:#CCFF33; color:#0000FF; border-width:thin; border-color:#FFFFFF}
.boton-superior:hover{ background-color: #66CC00}
.edit:hover{ background-color:#999999}
#form-element{ position:relative; width:400px; overflow:hidden; background:#FFFF00;}
#form-element div{ position:relative; width:150px; float:left; height:35px; }
#form-contribuyentes{ position:relative; min-width:800px; overflow:hidden; background:#FF0000;}
#form-contribuyentes div{ position:relative; min-width:150px; float:left; min-height:35px; background:#FFf6ff;}

</style>

<head>
   <meta http-equiv="content-type" content="text/html" charset="UTF-8">
   

</head>
	
<body bgcolor="#CCCCCC">
	
	<div style="width:100%; height:100%; background:#CCCCCC; position:absolute ">
    	
         
      
		<div style="width:625px; height:1000px; background:#FFFFFF; position:relative; margin:-10px auto; top:0px;">
			<form action="proyectos_alta_teatro.php?email=<? echo $mail;?>#<? echo $row['obra'] ?>" method="post" id="edit" name="edit">
   				<div style="width:625px; height:80px; background:#<? if($row['genero']=="0") {echo 'd8d8d8';} else{echo $row['genero'];} ?>">
   					<input style="border:hidden; background:none; font-size: 26px; margin-top:25px; width:400px; margin-left:10px;" id="obra" name="obra" value='<? echo $row['obra']?>' />
                  <input style="border:hidden; background:none; font-size: 14px;  width:200px; margin-left:10px;" id="genero" name="genero" value='<? echo $row['genero']?>' />
				</div>
            <table>
                   <thead>
                   	<th>Director</th><th>Productor</th><th>EFICINE</th><th>Periodo</th>
                   </thead>
                   <tbody>
                       <tr>
                    
                            <td>
                            <input id="director" name="director" value='<? echo $row['director']?>' />
                            </td>
                            <td>
                            <input id="productor" name="productor" value='<? echo $row['productor']?>' />
                            </td>
                            <td>
                            <input id="eficine" name="eficine" value='<? echo $row['eficine']?>' />
                            </td>
                            <td>
                            <input id="periodo" name="periodo" value='<? echo $row['periodo']?>' />
                            </td>
                        </tr>
                    
                    
                    </tbody>
               </table>
                   <textarea id="notas" name="notas" value='' style="width:350px; height:100px; " ><? echo date("d.m.Y") ?></textarea>
    				 <input type="hidden" id="notas_pasadas" name="notas_pasadas" value='<? echo $row['notas']?><br/>'/>
    				
       				 <input type="hidden" id="id" name="id" value='<? echo $row['id']?>' />
    			<div id="notas_pasadas" style="width:420px; text-align:justify; position:relative; margin-top:30px;   min-height:200px; overflow:hidden;">
						<table class="todas-empresas">
                   		<thead>
                   			<th>Notas</th>
                   		</thead>
                   		<tbody>
								<tr>
                                <td>
										<? echo $row['notas']?>
                                </td>
                             </tr>
                         </tbody>
                      </table>
             </div>
             
    <button type="submit">Guardar</button>
   </form>
   				<div style="position:relative; width:625px; height:200px; background-color:#00FF00; margin:10px;">
              		
                    <div style="background:#CC00FF">
                    <table class="todas-empresas">
                        <thead>
                            <th>Contribuyente</th><th>Aportacion</th>
                        </thead>
                        <tbody>

                       <? //Este while, extrae el nombre de la empresa que ha hecho una aportacion 
					   		while ($row_c = $result_c->fetch_array(MYSQLI_ASSOC)) {
								 $sql_d="SELECT empresa FROM `publicidad` WHERE id=".$row_c['id_e']." ";
								 $result_d=$mysqli->query($sql_d);
								 $row_d = $result_d->fetch_array(MYSQLI_ASSOC);
 				        ?>
                            
                            <tr>
                                <td>
                                		<a href="http://www.avantipictures.com/eficine/editar_empresa_publicidad.php?id=<? echo $row_c['id_e']?>&email=<? echo urlencode($_GET['email'])?>"><? echo $row_d['empresa']?></a>
                       
                               </td>
                                <td><? setlocale(LC_MONETARY, 'es_MX'); echo money_format('%=-2#8.2n', $row_c['aportacion'])?>
                               </td>
                            </tr>
                       
        				 <? };// Fin del while
						 ?>
                         </tbody>
      					</table>
                        
                  </div>
                  
                  
				</div>
             <div style="position:relative; width:625px; height:200px; background-color:#FF0000; z-index:1000">
      				<form  action="editar_obra.php?email=<? echo urlencode($_GET['email']);?>&id=<? echo $_GET['id']?>" method="post" name="agregar" id="agregar" enctype="application/x-www-form-urlencoded" >
        				<div id="form-contribuyentes">
        					<div>
        						<label for="contribuyente">Contribuyentes</label>
        					</div>
        					<div id="tabla-elementos" style="position:relative; overflow:hidden; max-width:600px;">
        					</div>
       					</div> 
        				<div style="position:relative; padding-left:150px; height:35px; background:#FF99CC">
        					<select  class="campos" id="aportante" name="aportante" size="1"  >
								<? foreach($conjunto as $key=>$value)
                                {	
                                    echo ($value);}; ?>
        					</select>	
        
	        				<label for="cantidad">Cantidad
             				</label>
              				<input type="text" name="cantidad" id="cantidad" />
            
        					<button type="button" id="addd" >Add</button>
       					</div>  
        				<button type="submit" id="remitir">Agregar</button>
            
        
                    <input type="hidden" name="email" id="email" value="<? echo $mail;?>" /><br />
                    <input type="hidden" name="id" id="id" value="<? echo $_GET['id'];?>" /><br />
                    <input type="hidden" name="nueva" id="nueva" value="1" /><br />
                    <input type="hidden" name="items_length" id="items_length"/>
					</form>
      </div>    
      		             
		</div>
        
        
	</div>
    
       <script>
		
var btnAgregar = document.getElementById('addd');


var tablaElementos = document.getElementById('tabla-elementos');

var txtAportante = document.getElementById('aportante');
var txtCantidad = document.getElementById('cantidad');
var items_length= document.getElementById('items_length');
var datos = [];
var no_aportante=0; //Al cargar la pagina, la variable se incializa en cero y se incrementa una unidad cada vez que llamamos a la función Agregar_aportante o myFunction();


			
function myFunction(){
	alert("hello");
	no_aportante++; //Incrementamos la variable. No recuerdo para qué
	
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
//Llama a la funcion que agrega las aportaciones a un array u objeto JSON
btnAgregar.addEventListener("click", myFunction);
</script>
 
    
</body>
   
   
 
</html>
   
   
   