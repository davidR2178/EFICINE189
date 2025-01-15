<?php 

	//iniciamos una sesión
session_start();

//Nos conectamos a la base de datos

$mysqli=new mysqli("localhost","root","root","corimain_AVANTI_PICTURES");
	
	if ($mysqli->connect_errno) {
    echo "Fallo al contenctar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		
			}
		$mysqli->set_charset("utf8");



   

 if($_GET['id']&&!$_GET['papeleria']){
	 
	 	$sql="UPDATE publicidad SET prioridad='".$_GET['color']."' WHERE id=".$_GET['id']."";
	 $mysqli->query($sql);
		
		echo $_GET['color'];
	 }
	 
if($_GET['papeleria']==1){
	 
	 	$sql="UPDATE prioridades SET papeleria='".$_GET['color']."' WHERE id=".$_GET['id']."";
		$mysqli->query($sql);
		echo $_GET['color'];
	 }

 
