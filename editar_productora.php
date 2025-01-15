<?php	
// Esta es la nueva funcion msqli que reemplaza a msql, para las funciones de base de datos.
$mysqli=new mysqli("localhost","root","root","AVANTI_PICTURES");

   if ($mysqli->connect_errno) {
    echo "Fallo al contenctar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
   $mysqli->set_charset("utf8");
   
   //En caso de registrar la posible aportacion de un contribuyente
   
   if($_POST['items_length']>0){
 
$mysqli->set_charset("utf8");
	 	//Insertamos el nuevo registro
	 	
		
		
		
		
		for ($i = 0; $i < $_POST['items_length']; $i++) {
			$aportante="aportante".$i;
			$id_e="id".$i;
			
			$cantidad="cantidad".$i;
			
    				 	$sql_3="INSERT INTO prospectos(id_p,id_e,aportacion) values(".$_GET['id'].",".$_POST[$id_e].",".$_POST[$cantidad].")";
						$mysqli->query($sql_3);

}
		
};
 

   $sql_b="SELECT id, productora, notas FROM `productoras` WHERE id=".$_GET['id']."";
   
   $result=$mysqli->query($sql_b);
   $row = $result->fetch_array(MYSQLI_ASSOC);
   $mail=urldecode(($_GET['email']));
   
   
   
//
 
   $sql_a="SELECT id, productora FROM `productoras` ORDER BY productora ASC	";
   $result_a=$mysqli->query($sql_a);
   $row_a = $result_a->fetch_array(MYSQLI_ASSOC);
   
   $sql_c="SELECT id, pelicula, eficine FROM `peliculas` WHERE erpip='".$row['productora']."' ORDER BY eficine ASC";
 $result_c=$mysqli->query($sql_c);
 
 $mysqli->set_charset("utf8");
//   
   $cont=1;
   $contb=1;
   $contc=1;
   $conjunto=array();
   $conjunto_aportantes=array();

						while ($row_a = $result_a->fetch_array(MYSQLI_ASSOC)) {
							$cont++;
							array_push($conjunto,"<option   id='".$row_a['productora']."' value='".$row_a['productora']."' data-id='".$row_a['id']."' ><p>".$row_a['productora']."</p></option>");
							//$sql_c="UPDATE contactos SET id_contacto=".$cont." WHERE id=".$row['id']."";
							// $mysqli->query($sql_c);
							
							}
							
	
   $conjunto_proyectos=array();
    $conjunto_peliculas=array();
	 $conjunto_aportantes=array();
						//Abrimos un ciclo de iteraciones para cada pelicula de las que la productora ha hecho
						while ($row_c = $result_c->fetch_array(MYSQLI_ASSOC)) {
							//Con cada iteracion vamos construyendo el table de las peliculas de la productora
							array_push($conjunto_proyectos,"<tr   id='".$row_c['pelicula']."' value='".$row_c['pelicula']."' data-id='".$row_c['id']."' ><td>".$contc."</td><td><a href='editar_pelicula.php?id=".$row_c['id']."&email=".urlencode($_GET['email'])."'>".$row_c['pelicula']."</a></td><td>".$row_c['eficine']."</td></tr>");
							$contc++;
							array_push($conjunto_peliculas,$row_c['id']);
							//Para la pelicula correspondiente a la iteracion actual buscamos los aportantes
							
							}
							
						foreach($conjunto_peliculas as $value){					
							$sql_aportantes="SELECT id_e FROM `aportaciones` WHERE id_p='".$value."' ORDER BY id_e ASC";
							$result_aportantes=$mysqli->query($sql_aportantes);
							//Cada aportante lo vamos adjuntando al conjunto de los aportantes
							while($row_aportantes = $result_aportantes->fetch_array(MYSQLI_ASSOC)){
										
										array_push($conjunto_aportantes, $row_aportantes['id_e']);
											
							}
						};
	 
							$conjunto_aportantes_ordenado=array_unique($conjunto_aportantes); 
							
							 $empresas_hermanas=array();
										$row_hermanas=array();
										$cont_empresas=1;
								//para cada aportacion de la empresa
										foreach($conjunto_aportantes_ordenado as $value) {
 										//extrae el nombre de la pelicula y el periodo de aprbacion 
										
										$sql_x="SELECT id, empresa FROM `publicidad` WHERE id=".$value."";
	 									$result_x=$mysqli->query($sql_x);
										
										while($row_x = $result_x->fetch_array(MYSQLI_ASSOC)){
										
											array_push($empresas_hermanas, '<tr><td>'.$cont_empresas.'</td><td><a href="editar_empresa_publicidad.php?id='.$row_x['id'].'&mail='.urlencode($_GET['email']).'">'.$row_x['empresa'].' </a></td></tr> ');}$cont_empresas++;
										
										}
									
									 

//--------------------------------------------------------------------------------------------------------------------------------------------------
// VERSIÓN DE ESCRITORIO -------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------


	 
	   ?>
<!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html" charset="UTF-8">
<title><?php echo $row['productora']?></title>
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
<body background="img/dark-triangles.png"  style="font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif" bgcolor="#999999" >
	
	<div style="width:100%; height:100%; background:none; position:absolute ">
		<form action="productoras_alta.php?email=<?php echo $mail;?>#<?php echo $row['productora'] ?>" method="post" id="edit" name="edit">
    		<div style="width:625px; height:100%; background:#FFFFFF; position:relative; margin:-10px auto; top:0px;">
   				<div style="width:625px; height:80px; background:#<?php if($row['genero']=="0") {echo 'd8d8d8';} else{echo '999';} ?>">
   					<input style="border:hidden; background:none; font-size: 26px; margin-top:25px; width:400px; margin-left:10px;" id="productora" name="productora" value='<?php echo $row['productora']?>' />
                    <input style="border:hidden; background:none; font-size: 14px;  width:200px; margin-left:10px;" id="genero" name="genero" value='<?php echo $row['genero']?>' />
                  

  				</div>
                
                    <textarea  id="notas" name="notas" value='' style="width:350px; height:100px;margin-left:10px;margin-top:10px; " ><?php echo date("d.m.Y") ?></textarea>
                    <div style="margin-left:10px;">
                    	<table class="todas-empresas">
                   <thead>
                   <th>#</th><th>Aportante</th>
                   </thead>
                   <tbody>
					<?php foreach($empresas_hermanas as $key=>$value)
					{	
						echo ($value);};?></tbody>
                             </table>
                     </div>
    				   <input type="hidden" id="notas_pasadas" name="notas_pasadas" value='<?php echo $row['notas']?><br/>'/>
    				
       			 <input type="hidden" id="id" name="id" value='<?php echo $row['id']?>' />
    <div id="notas_pasadas" style="width:420px; text-align:justify; position:relative; margin-top:30px;   min-height:200px; overflow:hidden;">
						<table class="todas-empresas" style="margin-left:10px;">
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
    <button style="margin-left:10px;" type="submit">Guardar</button>
   </form>
   				<div style="position:relative; margin:10px;">
                <div><table class="todas-empresas">
                   <thead>
                   <th>#</th><th>Pelicula</th><th>EFICINE</th>
                   </thead>
                   <tbody><?php foreach($conjunto_proyectos as $key=>$value)
					{	
						echo ($value);};
         ?>
                   
     	</tbody>
      </table>
    
                    </div>
   					
                   
   </div>
   </div>
     </div>
   
   </body>
   
   
  
   </html>
   
   
   