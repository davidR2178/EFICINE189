<? 

	//iniciamos una sesión
session_start();

//Nos conectamos a la base de datos
if (!($link=mysql_connect("localhost","elkinkon","4Hf3>6a*Fuk")))

   {

      echo "Error conectando a la base de datos.";

      exit();

   } 
mysql_set_charset('utf8');
//Seleccionamos la base de datos
    if (!mysql_select_db("AVANTI_PICTURES",$link))

   {

      echo "Error seleccionando la base de datos.";

      exit();

   }

   

 if($_GET['lista']>0){
	 $id=substr($_GET['id'],6);
	 
	 	$sql="UPDATE publicidad SET lista=".$_GET['lista']." WHERE id=".$id."";
		mysql_query($sql);
		
	 }
	 

	if($_GET['lista']==0){
		$id=substr($_GET['id'],6);
	 	$sql="UPDATE publicidad SET lista=0 WHERE id=".(int)$id."";
		mysql_query($sql);
	

 }
