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

   

 if($_GET['id']){
	 
	 	$sql="UPDATE empresas SET papeleria=2 WHERE id=".$_GET['id']."";
		mysql_query($sql);
	 }

 
echo $_GET['id'];