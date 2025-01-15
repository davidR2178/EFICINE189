<?php	
// Esta es la nueva funcion msqli que reemplaza a msql, para las funciones de base de datos.
$mysqli=new mysqli("localhost","root","root","AVANTI_PICTURES");

   if ($mysqli->connect_errno) {
    echo "Fallo al contenctar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
   $mysqli->set_charset("utf8");
   
   //En caso de registrar la aportacion de un nuevo contribuyente
   
   if($_POST['items_length']>0){
 
	   
	 	//Insertamos el nuevo registro
		
		for ($i = 0; $i < $_POST['items_length']; $i++) {
			$aportante="aportante".$i;
			$id_e="id".$i;
			
			$cantidad="cantidad".$i;
			
    				 	$sql_3="INSERT INTO aportaciones(id_p,id_e,aportacion) values(".$_GET['id'].",".$_POST[$id_e].",".$_POST[$cantidad].")";
						$mysqli->query($sql_3);

		} //fin del for
		
};//fin del if
 

   $sql_b="SELECT id, director, productor, erpip, pelicula, eficine, periodo, genero, notas, toptenc FROM `peliculas` WHERE id=".$_GET['id']."";
   
   $result=$mysqli->query($sql_b);
   $row = $result->fetch_array(MYSQLI_ASSOC);
   $mail=urldecode(($_GET['email']));

 	$sql_c="SELECT id, id_e, aportacion FROM `aportaciones` WHERE id_p=".$_GET['id']."";
 	$result_c=$mysqli->query($sql_c);
 
 	
 	
   	$sql_a="SELECT id,empresa FROM `publicidad` ORDER BY empresa ASC	";
   	$result_a=$mysqli->query($sql_a);
   	$row_a = $result_a->fetch_array(MYSQLI_ASSOC);
   
	$cont=1;
	$conjunto=array();

						while ($row_a = $result_a->fetch_array(MYSQLI_ASSOC)) {
							$cont++;
							array_push($conjunto,"<option   id='".$row_a['empresa']."' value='".$row_a['empresa']."' data-id='".$row_a['id']."' ><p>".$row_a['empresa']."</p></option>");
							//$sql_c="UPDATE contactos SET id_contacto=".$cont." WHERE id=".$row['id']."";
							// $mysqli->query($sql_c);
							
							}
 
	 
	 
	 
   $sql_productoras="SELECT id,productora FROM `productoras` ORDER BY productora ASC";
   $result_productoras=$mysqli->query($sql_productoras);
   //$row_productoras = $result_productoras->fetch_array(MYSQLI_ASSOC);
   
   $cont_productoras=0;
   $conjunto_productoras=array();

						while ($row_productoras=$result_productoras->fetch_array(MYSQLI_ASSOC)) {
							
							array_push($conjunto_productoras,"<option   id='".$row_productoras['productora']."' value='".$row_productoras['productora']."' data-id='".$row_productoras['id']."' ><p>".$row_productoras['productora']."</p></option>");
							$cont_productoras++;
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
<title><?php echo $row['pelicula']?></title>
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
<body  background="img/dark-triangles.png">
	
	<div style="width:100%; height:100%;  position:absolute ">
		<form action="proyectos_alta.php?email=<?php echo $mail;?>#<?php echo $row['pelicula'] ?>" method="post" id="edit" name="edit">
    		<div style="width:625px; height:100%; background:#FFFFFF; position:relative; margin:-10px auto; top:0px;">
   				<div style="width:625px; height:80px; background:#<?php if($row['genero']=="0") {echo 'd8d8d8';} else{echo $row['genero'];} ?>">
   					<input style="border:hidden; background:none; font-size: 26px; margin-top:25px; width:400px; margin-left:10px;" id="pelicula" name="pelicula" value='<?php echo $row['pelicula']?>' />
                  <input style="border:hidden; background:none; font-size: 14px;  width:200px; margin-left:10px;" id="genero" name="genero" value='<?php echo $row['genero']?>' />
                  <?php if($row['toptenc']==1){ echo '<div style="position:relative; float:right; top:-30px; right:10px; width:50px; height:50px; background:#00FF00;"><img src="img/topten.jpg"></div>';} ?>
                  

  				</div>
                <table>
                   <thead>
                   
                 
                   <th>Director</th><th>Productor</th><th>ERPIP</th><th>EFICINE</th><th>Periodo</th>
                   </thead>
                   <tbody>
                   <tr>
                
                    <td>
                    <input id="director" name="director" value='<?php echo $row['director']?>' />
                    </td>
                    <td>
                    <input id="productor" name="productor" value='<?php echo $row['productor']?>' />
                    </td>
                    <td>
                    <select  class="campos" id="erpip" name="erpip" size="1"  >
                    <option   id='<?php echo $row['erpip']?>' value='<?php echo $row['erpip']?>' data-id='<?php echo $row['id']?>' ><?php echo $row['erpip']?></option>
                    
            		<?php foreach($conjunto_productoras as $key=>$value)
					{	
						echo ($value);}
         ?>
        	</select>	
                    </td>
                    <td>
                    <input id="eficine" name="eficine" value='<?php echo $row['eficine']?>' />
                    </td>
                    <td>
                    <input id="periodo" name="periodo" value='<?php echo $row['periodo']?>' />
                    </td>
                    </tr>
                    
                    
                    </tbody>
                    </table>
                    <textarea id="notas" name="notas" value='' style="width:350px; height:100px; " ><?php echo date("d.m.Y") ?></textarea>
    				   <input type="hidden" id="notas_pasadas" name="notas_pasadas" value='<?php echo $row['notas']?><br/>'/>
    				
       			 <input type="hidden" id="id" name="id" value='<?php echo $row['id']?>' />
    <div id="notas_pasadas" style="width:420px; text-align:justify; position:relative; margin-top:30px;   min-height:200px; overflow:hidden;">
						<table class="todas-empresas">
                   		<thead>
                   			<th>Notas</th>
                   		</thead>
                   		<tbody>
								<tr>
                                <td>
										<?php echo $row['notas']?>
                                </td>
                             </tr>
                             </tbody>
                             </table>
                  </div>
    <button type="submit">Guardar</button>
   </form>
   				<div style="position:relative; margin:10px;">
                <div><table class="todas-empresas">
                   <thead>
                   <th>Contribuyente</th><th>Aportacion</th>
                   </thead>
                   <tbody>
                   <?php while ($row_c = $result_c->fetch_array(MYSQLI_ASSOC)) {
	 $sql_d="SELECT empresa FROM `publicidad` WHERE id=".$row_c['id_e']." ";
	 $result_d=$mysqli->query($sql_d);
	 $row_d = $result_d->fetch_array(MYSQLI_ASSOC);
	 ?>
     					
                        <tr>
                      <td><a href="/eficine/editar_empresa_publicidad.php?id=<?php echo $row_c['id_e']?>&email=<?php echo urlencode($_GET['email'])?>"><?php echo $row_d['empresa']?></a>
                   
                    </td>
                    <td><?php setlocale(LC_MONETARY, 'es_MX'); echo money_format('%=-2#8.2n', $row_c['aportacion'])?>
                    </td>
                   </tr>
                   
     <?php
	 
	 
	 }; ?></tbody>
      </table>
      <form  action="editar_pelicula.php?email=<?php echo urlencode($_GET['email']);?>&id=<?php echo $_GET['id']?>" method="post" name="agregar" id="agregar" enctype="application/x-www-form-urlencoded" >
        
        
        <div id="form-contribuyentes">
        	<div>
        		<label for="contribuyente">Contribuyentes</label>
        	</div>
        	<div id="tabla-elementos" style="position:relative; overflow:hidden; max-width:600px;">
        	</div>
       </div> 
        <div style="position:relative; padding-left:150px; height:35px; background:#FF99CC">
        	<select  class="campos" id="aportante" name="aportante" size="1"  >
            		<?php foreach($conjunto as $key=>$value)
					{	
						echo ($value);};
         ?>
        	</select>	
        
        	<label for="cantidad">Cantidad</label><input type="text" name="cantidad" id="cantidad" />
            
        	<button type="button" id="addd">Add</button>
       </div>  
        	<button type="submit" id="remitir">Agregar</button>
            
        
        <input type="hidden" name="email" id="email" value="<?php echo $mail;?>" /><br />
        <input type="hidden" name="id" id="id" value="<?php echo $_GET['id'];?>" /><br />
        <input type="hidden" name="nueva" id="nueva" value="1" /><br />
        <input type="hidden" name="items_length" id="items_length"/>
	</form>
                    </div>
   					
                   
   </div>
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
   
   
   