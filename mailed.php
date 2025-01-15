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

   

 if($_GET['id']&&!$_GET['papeleria']){
	 
	 	$sql="UPDATE publicidad SET mailed=1 WHERE id=".$_GET['id']."";
		mysql_query($sql);
		//echo $_GET['color'];
	 }
	 
if($_GET['papeleria']==1){
	 
	 	$sql="UPDATE prioridades SET papeleria='".$_GET['color']."' WHERE id=".$_GET['id']."";
		mysql_query($sql);
		echo $_GET['color'];
	 }

 
