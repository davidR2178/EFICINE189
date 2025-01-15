<?php	
// Esta es la nueva funcion msqli que reemplaza a msql, para las funciones de base de datos.
$mysqli=new mysqli("localhost","elkinkon","4Hf3>6a*Fuk","AVANTI_PICTURES");

   if ($mysqli->connect_errno) {
    echo "Fallo al contenctar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
   $mysqli->set_charset("utf8");
   
//Preparamos la consulta principal para obtener los datos de las empresas con las que avanzamos en el dia 
		$sql_p="SELECT id, empresa, prioridad, fecha, notas FROM `publicidad` WHERE avances=CURDATE() ORDER BY prioridad DESC"; //Lista de los avances del dia de hoy
		//Realizamos la consulta(con la nueva funcion)   
   $result_p=$mysqli->query($sql_p);
		$conjunto_p=array();
		$conjunto="";
		$conjunto_p_bis=array();
		$cont_p=0;
//Organizamos la consulta en un array asociativo
		while ($row_p = $result_p->fetch_array(MYSQL_ASSOC)) {
			$cont_p++;
			if($row_p['prioridad']!='0'){
				$color="style='background-color:#".$row_p['prioridad']."; position:relative;  width:400px; height:30px; margin:2px;'";
			}
			else{	
				if($cont_p%2==0){
					$color="style='background-color:#fff; position:relative;  width:400px; height:30px; margin:2px;'";
				}
				else{
				$color="style='background-color:#D8D8D8; position:relative;  width:400px; height:30px; margin:2px;'";
				}; 
			}

			$conjunto=$conjunto + "
			<div g='".$row_p['id']."' title='".$row_p['empresa']."' id='listg_".$row_p['id']."' ".$color." >
				<a  target='_blank' href='editar_empresa_publicidad.php?id=".$row_p['id']."&email=".urlencode($_GET['email'])."&q=".$row_p['empresa']."'>
				<div style='position:relative;  width:400px; height:30px;'><span style='position:relative; top:40%;padding-left:10px;'>".$cont_p.".-".$row_p['empresa']."</span></div>
				
				</a>
				
				
				
		</div>";
		}
		
         
         
		$to = "david@gmaill.com";
$subject = "Asunto del email";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
 
$message = "
<html  lang='es'>
<head>
<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'>
	<meta http-equiv='content-type' content='text/html' charset='UTF-8'>
	<title>
		Empresas 189
    </title>
	
        <style> 
	html{ font-size:14px;}
	.nueva-empresa input{ height:20px;} .nueva-empresa td{ height:25px;} .todas-empresas td{ padding:5px; } .todas-empresas th{ background:#CCC;}  
	a:link{ text-decoration:none; color:#000 }
	.boton-superior{ position:relative; float:left; width:20%; height:50px; background-color:#CCFF33; color:#0000FF; border-width:thin; border-color:#FFFFFF}
	.boton-superior:hover{ background-color: #66CC00}
	.edit:hover{ background-color:#999999}	  
	</style>
</head>
<body>
<body background='img/dark-triangles.png'  style='font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif' bgcolor='#999999' >

	
		<div class='ui-widget-header' style='background:none; border:none; padding:0px;'>
         </div>
         </body>
</body>
</html>";
 
mail($to, $subject, $message, $headers);
		echo $conjunto;
		?>
        
 


