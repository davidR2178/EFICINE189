<?php	
// Esta es la nueva funcion msqli que reemplaza a msql, para las funciones de base de datos.
$mysqli=new mysqli("localhost","elkinkon","4Hf3>6a*Fuk","AVANTI_PICTURES");

   if ($mysqli->connect_errno) {
    echo "Fallo al contenctar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
   $mysqli->set_charset("utf8");
   
// En caso de que la empresa sea dada de alta desde cualquier otra lista
	
		
	if($_POST['id_ale_florida']){
   		
		// Actualizamos el registro de la empresa para agregarla a la lista papeleria 	
		$sql="UPDATE empresas SET ale_florida=1 WHERE id=".$_POST['id_ale_florida']."";
   		$mysqli->query($sql);
   
	   // Inicializamos la prioridad de la empresa en 0
   		$sql_b="INSERT INTO prioridades(id, ale_florida) VALUES(".$_POST['id_ale_florida'].",0) ";
		$mysqli->query($sql_b);
		
		// Inicializamos un contacto para la empresa en blanco
   		$sql_contacto_init="INSERT INTO contactos(id, ale_florida) VALUES(".$_POST['id_ale_florida'].",1) ";
		$mysqli->query($sql_contacto_init);
		
		// Obtenemos el nombre de la empresa utilizando la variable id de la url   
   		$sql_c="SELECT empresa FROM `empresas` WHERE id=".$_POST['id_ale_florida']."";
  		$result=$mysqli->query($sql_c);
   		$row = $result->fetch_array(MYSQLI_ASSOC);
   
   		// Obtenemos la prioridad de la empresa utilizando la variable id de la url
   		$sql_d="SELECT ale_florida FROM `prioridades` WHERE id=".$_POST['id_ale_florida']."";
   		$result_d=$mysqli->query($sql_d);
   		$row_d = $result_d->fetch_array(MYSQLI_ASSOC);
		
		// Obtenemos la id_contact del contacto de la empresa utilizando la variable id de la url
   		$sql_contact="SELECT id_contacto FROM `contactos` WHERE id=".$_POST['id_ale_florida']." AND ale_florida=1";
   		$result_contact=$mysqli->query($sql_contact);
   		$row_contact = $result_contact->fetch_array(MYSQLI_ASSOC);
	}
	

// En caso de que la empresa ya exista en esta lista y haya que editarla
	
	else{
	
	// Obtenemos el nombre de la empresa utilizando la variable id de la url   
   $sql_c="SELECT empresa FROM `empresas` WHERE id=".$_GET['id']."";
   $result=$mysqli->query($sql_c);
   $row = $result->fetch_array(MYSQLI_ASSOC);
   
   // Obtenemos la prioridad de la empresa coorespondiente a la lista ale_florida utilizando la variable id de la url
   $sql_d="SELECT ale_florida FROM `prioridades` WHERE id=".$_GET['id']."";
   $result_d=$mysqli->query($sql_d);
   $row_d=$result_d->fetch_array(MYSQLI_ASSOC);
   
   // Obtenemos los contactos de la empresa correspondientes a la lista ale_florida utilizando la variable id de la url
   $sql_e="SELECT id_contacto, contacto, puesto, telefono, ext, mail FROM `contactos` WHERE id=".$_GET['id']." AND ale_florida=1";
   $result_e=$mysqli->query($sql_e);
   $row_e=$result_e->fetch_array(MYSQLI_ASSOC);
   
   // Obtenemos las notas de la empresa correspondientes a la lista ale_florida utilizando la variable id de la url
   $sql_f="SELECT ale_florida FROM `notas` WHERE id=".$_GET['id']."";
   $result_f=$mysqli->query($sql_f);
   $row_f=$result_f->fetch_array(MYSQLI_ASSOC);
	
	}
	
   $mail=urldecode(($_GET['email']));

 
 
$es_movil = '0';
if(preg_match('/(android|wap|phone|ipad)/i',strtolower($_SERVER['HTTP_USER_AGENT']))){
    $es_movil++;
}

//--------------------------------------------------------------------------------------------------------------------------
// VERSIÓN PARA TABLETS Y CELULARES  -------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------

if($es_movil>0){?> 
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
   <meta http-equiv="content-type" content="text/html" charset="UTF-8" >
  
</head>
<body bgcolor="#CCCCCC" style="font-size:45px; font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;">
	<div style="width:100%; height:100%; background:#CCCCCC; position:absolute; left:0px; top:0px; ">
		<form  id="edit" name="edit">
    		
   				<div style="position:absolute; width:100%; height:20%; background:#<? if($row['prioridad']=="0") {echo 'd8d8d8';} else{echo $row['prioridad'];} ?>">
   					<input style=" position:relative;border:hidden; background:none; font-size: 105px; margin-top:15px; width:80%; margin-left:10px; top:25px;" id="empresa" name="empresa" value='<? echo $row['empresa']?>' />
  				</div>
   				<div style="position:absolute; width:100%; height:10%; background:#ccc; top:15%;">
   	
                   <label style="position: relative; margin-left:10px; top:25px;">Contacto:</label>	
                    <input id="contacto" name="contacto" value='<? echo $row['contacto']?>' style=" position:relative; top:25px;border:hidden; background:none; font-size: 45px; margin-top:15px; width:600px; margin-left:10px;"  />
                    </div>
                    <div style="position:absolute; width:100%; height:10%;  background:#<? if($row['prioridad']=="0") {echo 'd8d8d8';} else{echo $row['prioridad'];} ?>; top:25%;">
                    <label style="position: relative; margin-left:10px; top:25px;">Tel:</label>
                    <input id="telefono" name="telefono" value='<? echo $row['telefono']?>' style="position:relative; top:25px; border:hidden; background:none; font-size: 45px; margin-top:15px; width:600px; margin-left:10px;" />
                    </div>
                    <div style="position:absolute; width:100%; height:10%; background:#ccc; top:35%;">
                    <label style="position: relative; margin-left:10px; top:25px;">Ext:</label>
                    <input id="ext" name="ext" value='<? echo $row['ext']?>' style="position:relative; top:25px; border:hidden; background:none; font-size: 45px; margin-top:15px; width:600px; margin-left:10px;" />
                    </div>
                    <div style="position:absolute; width:100%; height:10%;  background:#<? if($row['prioridad']=="0") {echo 'd8d8d8';} else{echo $row['prioridad'];} ?>; top:45%;">
                    <label style="position: relative; margin-left:10px; top:25px;">Mail:</label>
                    <input id="mail" name="mail" value='<? echo $row['mail']?>' style="position:relative; top:25px; border:hidden; background:none; font-size: 45px; margin-top:15px; width:600px; margin-left:10px;" />
                    </div>
                    
                    
     <div style="position:absolute; width:100%; height:10%; background:#ccc; top:55%;">               
    
    <input type="hidden" id="notas_pasadas" name="notas_pasadas" value='<? echo $row['notas']?><br/>'/>
    <input type="hidden" id="id" name="id" value='<? echo $row['id']?>' />
    <div id="notas_pasadas" style=" position:relative; top:25px; left:10px; width:95%; text-align:justify;   min-height:200px; overflow:hidden;"><? echo $row['notas']?></div>
   </form>
   </div>
  
     </div>
   
   </body>
   </html>
<? }


//--------------------------------------------------------------------------------------------------------------------------------------------------
// VERSIÓN DE ESCRITORIO -------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------


else{	 
	
	   ?>
<!--Estaria bien cambiarlo a HTML5-->       
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta http-equiv="content-type" content="text/html" charset="UTF-8">
   <?php /*?><script src="http://www.avantipictures.com/eficine/tinymce/tinymce.min.js"></script>
<script type="text/javascript">

    tinyMCE.init({

        mode : "exact",

        elements : "notas",

        theme : "modern",

        theme_advanced_buttons1:"bold,italic,underline,|,undo,redo,|,bullist,numlist",

        theme_advanced_buttons2:"",

        theme_advanced_buttons3:""

 

    });

</script>
<?php */?>

<script>
function papeleria(){
	if (confirm ("¿Desea que esta empresa aparezca también en la lista Papelería?")){
			alert ("La empresa ha sido dada de alta en la lista Papelería y será redireccionado.");
			document.getElementById("agregar_papeleria").submit();
			
	
	}
	else{alert ("Hello world")}
	}
</script>

</head>

<body bgcolor="#CCCCCC">

<?php /*?>Este form esta oculto y se encarga de mandar los datos de la empresa cuando la damos de alta en otra lista<?php */?>
	
    <form  action="editar_empresa_papeleria.php" method="post" name="agregar_papeleria" id="agregar_papeleria" enctype="application/x-www-form-urlencoded" >
    	 <input type="hidden" id="id_papeleria" name="id_papeleria" value='<? echo $row['id']?>' />
    </form>
	
    <div style="width:100%; height:100%; background:#CCCCCC; position:absolute ">

<?php /*?>	Este form envia los datos que actualizan los registros de la empresa en la lista que corresponde a la ficha<?php */?>
        
      <form action="ale_florida.php?email=<? echo $mail;?>#<? echo $row['empresa'] ?>" method="post" id="edit" name="edit">
        
    		<div id="ficha" style="width:625px; height:100%; background:#FFFFFF; position:relative; margin:-10px auto; top:0px;">
           
           <div id="titulo" style="width:625px; height:30px; background: #333333">
           	<span style="position:absolute; float:left; color:#FFFFFF; margin:10px; margin-top:3px; font-size:24px">Ale Florida</span> 
           </div>
   				
        	<div id="cabecera" style="width:625px; height:80px; background:#<? if($row_d['ale_florida']=="0") {echo 'd8d8d8';} else{echo $row_d['papeleria'];} ?>">
   					
          	<input id="empresa" name="empresa" value='<? echo $row['empresa']?>'  style="border:hidden; background:none; font-size: 26px; margin-top:25px; width:400px; margin-left:10px;" />
                  
                  <?php /*?>Este conjunto de enlaces se genera dinamicamente, queda por definir en qué forma.<?php */?>
                  
          
                  	<div style="position:relative; float:right; width:30px; height:30px; background:#FFFFFF; margin-top:25px; margin-right:10px"></div>
                  	
                  <div style="position:relative; float:right; width:30px; height:30px; background:#FFFFFF; margin-top:25px; margin-right:10px"></div> 
                  <div style="position:relative; float:right; width:30px; height:30px; background:#FFFFFF; margin-top:25px; margin-right:10px"></div> 
                  <div style="position:relative; float:right; width:30px; height:30px; background:#FFFFFF; margin-top:25px; margin-right:10px"></div> 

  				</div>
                
   				<div id="datos_ficha" style="position:relative; margin:10px;">
   	
                   <table style="position:relative; margin-bottom:30px;">
                   	<thead>
                   		<th>Contacto</th><th>Puesto</th>
                   	</thead>
                   	
                   	<tbody>
                   		<tr>
                            <td>
                            <input id="contacto" name="contacto" value='<? echo $row_e['contacto']; ?>' />
                            </td>
                            <td>
                            <input id="puesto" name="puesto" value='<? echo $row_e['puesto']; ?>' />
                            </td>
                         </tr>
                         <tr>
                         <thead>
                         <th>T&eacute;lefono</th><th>Ext</th>
                         </thead>
                            <td>
                            <input id="telefono" name="telefono" value='<? echo $row_e['telefono']; ?>' />
                            </td>
                            <td>
                            <input id="ext" name="ext" value='<? echo $row_e['ext']; ?>' />
                            </td>
                         </tr>
                         <thead>
                         <th>Mail</th>
                         </thead>
                         <tr>
                            <td>
                            <input id="mail" name="mail" value='<? echo $row_e['mail']; ?>' />
                            </td>
                        </tr>
                        
                    
                    </tbody>
                  </table>
                  
            <textarea id="notas" name="notas" value='' style="width:400px; height:100px;" ><? echo date("d.m.Y") ?></textarea>
        <input type="hidden" id="notas_pasadas" name="notas_pasadas" value='<? echo $row_f['ale_florida']?>'/>
        <input type="hidden" id="id_contacto" name="id_contacto" value='<? if($_POST['id_papeleria']){echo $row_contact['id_contacto'];} else{ echo $row_e['id_contacto'];}?>'/>
        <input type="hidden" id="id" name="id" value='<? if($_POST['id_papeleria']){echo $_POST['id_papeleria'];} else{echo $_GET['id'];}?>' />
            <div id="notas_pasadas" style="width:600px; text-align:justify;   min-height:200px; overflow:hidden;"><? echo $row_f['ale_florida']?></div>
            
        <button type="submit">Guardar</button>
   
   </form>
   </div>
   </div>
   </div>
   
</body>
</html>
   
   
   <? }?>