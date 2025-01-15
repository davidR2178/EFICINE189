<?php	
// Esta es la nueva funcion msqli que reemplaza a msql, para las funciones de base de datos.
$mysqli=new mysqli("localhost","root","root","AVANTI_PICTURES");

   if ($mysqli->connect_errno) {
    echo "Fallo al contenctar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
   $mysqli->set_charset("utf8");
   
//Preparamos la consulta principal para obtener los datos de la empresa(especificada en el GET)
   $sql_b="SELECT id, empresa, contacto, telefono, ext, mail, notas, prioridad, papeleria, giro, ale_florida, recordatorio, mapa FROM `publicidad` WHERE id=".$_GET['id']."";
//Realizamos la consulta(con la nueva funcion)   
   $result=$mysqli->query($sql_b);
//Organizamos la consulta en un array asociativo
   $row = $result->fetch_array(MYSQLI_ASSOC);
   
//Preparamos una consulta que arroje las aportaciones que la empresa ha hecho en ediciones anteriores del EFICINE
 $sql_c="SELECT id, id_p, aportacion FROM `aportaciones` WHERE id_e=".$_GET['id']."";
 
//Realizamos la consulta con la nueva funcion
 $result_c=$mysqli->query($sql_c);

 
 //Preparamos una consulta que arroje las aportaciones que la empresa ha hecho en ediciones anteriores del EFICINE
 $sql_e="SELECT id, id_o, aportacion FROM `aportaciones_teatro` WHERE id_e=".$_GET['id']."";
//Realizamos la consulta con la nueva funcion
 $result_e=$mysqli->query($sql_e);
 
//Preparamos una consulta que arroje los contactos de la empresa(especificada en el GET)
//$sql_d="SELECT id_contacto, nombre, puesto, departamento, telefono, ext, mail FROM `contactos` WHERE id=".$_GET['id']."";
//Realizamos la consulta con la nueva funcion
// $result_d=$mysqli->query($sql_d); 
 
 
 $mail=urldecode(($_GET['email']));
 
	 


$formateador = new NumberFormatter( 'es_MX', NumberFormatter::DECIMAL );




 
	   ?>

		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

		<html xmlns="http://www.w3.org/1999/xhtml">

		<head>
   		
      		<meta http-equiv="content-type" content="text/html" charset="UTF-8">
   
				<script>
					function ale_florida(){
						
						if (confirm ("¿Desea que esta empresa aparezca también en la lista de Alejandra Florida?")){
							alert ("La empresa ha sido dada de alta en la lista de Alejandra Florida y será redireccionado.");
							<!--Enviamos o posteamos la forma que tiene el id=agregar_ale, que está en la linea +-143 -->
							document.getElementById("agregar_ale_florida").submit();
							}
						else{alert ("Hello world")}
						
						}
				</script>
                <script src="/eficine/js/jquery-3.2.1.min.js"></script>
					<script src="/eficine/js/jquery-ui-1.12.1/jquery-ui.js"></script>
   				 <script>  $( function() { 
					 $( "#datepicker" ).datepicker({
					 	dateFormat: "yy-mm-dd"
					 }
					 ); 
				 
				 } );
				 
				 
				 function mailed(id){ 
		
		
		alert("hello");
			
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
		
		xmlhttp.open("GET","mailed.php?id="+id,true);
		
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		
		xmlhttp.send();
}
 				 </script>
				<style> 
					html{ font-size:14px; font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif; color:#FFFFFF}
					.nueva-empresa input{ height:20px;} .nueva-empresa td{ height:25px;} .todas-empresas td{ padding:5px; } .todas-empresas th{ background:#CCC;}  
          			a:link{ text-decoration:none; color:#fff }
					.boton-superior{ position:relative; float:left; width:20%; height:50px; background-color:#CCFF33; color:#0000FF; border-width:thin; border-color:#FFFFFF}
					.boton-superior:hover{ background-color: #66CC00}
					.edit:hover{ background-color:#999999}
				</style>
                
                <title><?php echo $row['empresa'] ?></title>
		</head>
        
		<body background="img/dark-triangles.png">
        
			<!--Esta es la forma que agrega una empresa que esta en la lista principal a otra lista, en este caso a la lista de Alejandra.-->
           <!--Hay que checar que onda con el email del GET-->
           <form  action="editar_empresa_ale.php?email=<?php echo urlencode($_GET['email']);?>" method="post" name="agregar_ale_florida" id="agregar_ale_florida" enctype="application/x-www-form-urlencoded" >
         		<input type="hidden" id="id_ale_florida" name="id_ale_florida" value='<?php echo $row['id']?>' />     
    		</form>
 			<!--Fin de la forma-->
                       
			<div style="width:100%; height:100%;  position:absolute ">
				<form action="publicidad.php?email=<?php echo $mail;?>#<?php echo $row['empresa'] ?>" method="post" id="edit" name="edit">
    				
              		<div style="width:625px; height:100%; background:none; position:relative; margin:-10px auto; top:0px;">
   						<div style="width:625px; height:80px; background:#<?php if($row['prioridad']=="0") {echo 'd8d8d8';} else{echo $row['prioridad'];} ?>; opacity:0.8">
   							<input style="border:hidden; background:none; font-size: 26px; margin-top:20px; width:400px; margin-left:10px;" id="empresa" name="empresa" value='<?php echo $row['empresa']?>' />
                         <input style="border:hidden; background:none; font-size: 14px;  width:200px; margin-left:10px;" id="giro" name="giro" value='<?php echo $row['giro']?>' />
                        	
                         <!--Este es el boton para agregar la empresa a otra lista, en este caso se agrega a la lista de papeleria que hace tiempo usaria Chepe-->
                         <!--Al presionarlo llamamos a la funcion alejandra(); que está en la linea 106-->
                 			<a href='<?php if($row['ale_florida']=="0"){echo 'javascript:ale_florida();';} else {echo "nd";} ?>' title="Agragar a la lsita de Alejandra Florida" >
                  			<div style="position:relative; float:right; width:30px; height:30px; background:#FFFFFF; margin-left:400px; margin-top:-35px; margin-right:10px">
                            	</div>
                  		</a>	
                  		
	
  					</div>
   					
                  <div style="position:relative; margin:10px;">
   					
                   <table>
                   <thead>
                   <th>Contacto</th><th>Tel&eacute;fono</th><th>Ext</th><th>Mail</th>
                   </thead>
                   <tbody>
                   <tr>
                
                    <td>
                    <input id="contacto" name="contacto" value='<?php echo $row['contacto']?>' />
                    </td>
                    <td>
                    <input id="telefono" name="telefono" value='<?php echo $row['telefono']?>' />
                    </td>
                    <td>
                    <input id="ext" name="ext" value='<?php echo $row['ext']?>' />
                    </td>
                    <td>
                    <input id="mail" name="mail" value='<?php echo $row['mail']?>' />
                    </td>
                    <td onclick="mailed(<?php echo $row['id']?>);">Mailed
                    </td>
                    </tr>
                    
                    
                    </tbody>
                    </table>
   					<textarea id="notas" name="notas" value='' style="width:350px; height:100px; " ><?php echo date("d.m.Y") ?></textarea>
    				<input type="hidden" id="notas_pasadas" name="notas_pasadas" value='<?php echo $row['notas']?><br/>'/>
    				<input type="hidden" id="id" name="id" value='<?php echo $row['id']?>' />
                    <div style=" position:absolute; left:360px; top:35px;">
                    <p>Memo: <input type="text" id="datepicker" name="datepicker" value="<?php echo $row['recordatorio']?>" ></p>

                    </div>
                                        <a href="tel:<?php echo $row['telefono']?>">Call Us</a>



    					<div style="position:relative; margin-top:30px;">
                        <table class="todas-empresas">
                   		<thead style="color:#000000">
                   			<th>Pelicula</th><th>Año</th><th>Aportacion</th><th>EERPIP</th>
                   		</thead>
                   		<tbody>
                  				<?php $empresas_hermanas=array();
										$row_x=array();
								//para cada aportacion de la empresa
										while ($row_c = $result_c->fetch_array(MYSQLI_ASSOC)) {
 										//extrae el nombre de la pelicula y el periodo de aprbacion 
										$sql_d="SELECT pelicula, eficine,erpip FROM `peliculas` WHERE id=".$row_c['id_p']." ORDER BY 'eficine' DESC";
	 									$result_d=$mysqli->query($sql_d);
										$row_d = $result_d->fetch_array(MYSQLI_ASSOC);
										$sql_p="SELECT id FROM `productoras` WHERE productora='".$row_d['erpip']."'";
										$result_p=$mysqli->query($sql_p);
										$row_p = $result_p->fetch_array(MYSQLI_ASSOC);
										//extrae los id de las empresas aportantes de la pelicula analizada en esta iteracion
										$sql_x="SELECT id_e FROM `aportaciones` WHERE id_p=".$row_c['id_p']." ";
	 									$result_x=$mysqli->query($sql_x);
										
										while($row_x = $result_x->fetch_array(MYSQLI_ASSOC)){
										
										array_push($empresas_hermanas, $row_x['id_e']);}
											
									 ?>
     						
                            <tr>
                   			<td style=" max-width:250px;"><a href="/eficine/editar_pelicula.php?id=<?php echo $row_c['id_p']?> &email=<? echo urlencode($_GET['email'])?>"><?php echo $row_d['pelicula']?></a>
                   			</td>
                   			<td><?php echo $row_d['eficine']?>
                    			</td>
                    			<td style="text-align:right"><?php echo $formateador->format($row_c['aportacion']) . PHP_EOL; ?>
                    			</td>
                                <td><a href='editar_productora.php?id="<?php echo ($row_p['id'])?>"&email="<? echo ($mail)?>"'>
										<?php echo ($row_d['erpip'])?>
										
									</a>
                    			</td>
                   		</tr>
     					<?php };?>
						
                        </tbody>
      					</table>
                    </div>
                      
                    <div style="position:relative; margin-top:30px;">
                        <table class="todas-empresas">
                   		<thead style="color:#000000">
                   			<th>Obra</th><th>Año</th><th>Aportacion</th>
                   		</thead>
                   		<tbody>
                  				<?php while ($row_e = $result_e->fetch_array(MYSQLI_ASSOC)) {
										$sql_d="SELECT obra, eficine FROM `teatro` WHERE id=".$row_e['id_o']." ORDER BY 'eficine' DESC";
	 									$result_d=$mysqli->query($sql_d);
										$row_d = $result_d->fetch_array(MYSQLI_ASSOC);
									 ?>
     						
                            <tr>
                   			<td><a href="/eficine/editar_obra.php?id=<?php echo $row_e['id_o']?> &email=<?php echo urlencode($_GET['email'])?>"><?php echo $row_d['obra']?></a>
                   			</td>
                   			<td><?php echo $row_d['eficine']?>
                    			</td>
                    			<td style="text-align:right"><?php echo $formateador->format($row_e['aportacion']) . PHP_EOL;?>
                    			</td>
                   		</tr>
     					<?php }; ?>
                        </tbody>
      					</table>
                    </div>
                    <div style="position:relative; margin-top:30px; ">
                    <table class="todas-empresas">
                   		<thead style="color:#000000">
                   			<th>#</th><th>Aportante</th>
                   		</thead>
                   		<tbody>
                    <?php $empresas_hermanas_o=array_unique($empresas_hermanas);
						$empresas_hermanas_o=array_values($empresas_hermanas_o);
						//$row_dandy=$empresas_hermanas_o->fetch_array(MYSQLI_NUM);
						//var_dump($empresas_hermanas_o);
							$numeral=1;
							$empresas_nombre=array();
							$final=count($empresas_hermanas_o)-1;
							$row_bbc=array();
							while($numeral<=$final){
								//extrae el nombre de la pelicula y el periodo de aprbacion 
										$sql_z="SELECT empresa FROM `publicidad` WHERE id=".$empresas_hermanas_o[$numeral]." ORDER BY 'id' DESC";
	 									$result_z=$mysqli->query($sql_z);
										$row_z = $result_z->fetch_array(MYSQLI_ASSOC);
										array_push($empresas_nombre,$row_z['empresa']);
										?>
										<tr><td><?php echo $numeral;?></td><td><a href="editar_empresa_publicidad.php?id=<?php echo $empresas_hermanas_o[$numeral];?>&email=<?php echo $_GET['email']?>" target="_blank"><?php echo $row_z['empresa'].""?></a></td></tr>
										<?php
								$numeral++;};
						?></tbody>
      					</table>
                    </div>
    				<div id="notas_pasadas" style="width:420px; text-align:justify; position:relative; margin-top:30px;   min-height:200px; overflow:hidden;">
						<table class="todas-empresas">
                   		<thead style="color:#000000">
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
                  <div class="notas_pasadas">
                  <input id="mapa" name="mapa" value='<?php echo $row['mapa']?>' />
                  </div>
                  <div style=" position:relative; width:625px; height:450px; background:none; margin-top:10px; margin-bottom:10px;">
   <?php echo $row['mapa']?>
  </div>
                  <div class="notas_pasadas" style="width:420px; text-align:justify; position:relative; margin-top:00px;   min-height:200px; overflow:hidden;">
						<table class="todas-empresas">
                   		<thead style="color:#000000">
                   			<th>Empresas similares</th><th>+</th>
                   		</thead>
                   		<tbody>
								<tr>
                                <td>
										<script>
  (function() {
    var cx = '014136475211653302009:yiq11hramas';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
<gcse:search></gcse:search>


                                </td>
                             </tr>
                             </tbody>
                             </table>
                  </div>
   
    
    <button type="submit">Guardar</button>
   </form>
   </div>
   
   </div>
   
     </div>
   
   </body>
   </html>
   
   
   <? 