<? session_start();

	if (!($link=mysql_connect("localhost","elkinkon","4Hf3>6a*Fuk")))

   {

      echo "Error conectando a la base de datos.";

      exit();

   } 

    if (!mysql_select_db("AVANTI_PICTURES",$link))

   {

      echo "Error seleccionando la base de datos.";

      exit();

   } 

   

 if($_POST['id']){
	 
	 	$sql="UPDATE empresas226 SET id=".$_POST['id']." ,empresa='".$_POST['empresa']."' ,contacto='".$_POST['contacto']."' ,telefono='".$_POST['telefono']."' ,ext='".$_POST['ext']."' ,mail='".$_POST['mail']."' ,notas='".$_POST['notas']."' WHERE id=".$_POST['id']."";
		mysql_query($sql);
	 }

 




	
	$sql_b="SELECT id, empresa, contacto, telefono, ext, mail, notas FROM `publicidad` order by id desc ";

						$result=mysql_query($sql_b);
						$conjunto=array();
						$cont=0;

						while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
							$cont++;
							
							array_push($conjunto, "<td><a href='editar_empresa.php?id=".$row['id']."'>Editar</a></td><td id='".$cont."+probando'>".$row['empresa']."</td><td id=''>".$row['contacto']."</td><td id=''>".$row['telefono']."</td><td id=''>".$row['ext']."</td><td id=''>".$row['mail']."</td><td id=''>".$row['notas']."</td><td><button onclick=unpublish(".$row['id'].") >Unpublish</button></td>");
							}
						

	?>
    
<script>
function nueva_empresa(){ 
alert(empresa.value);

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

    document.getElementById("confirmacion").innerHTML=xmlhttp.responseText;

    }

  }

xmlhttp.open("POST","agregar_empresa.php",true);

xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

xmlhttp.send("empresa="+empresa.value+"&contacto="+contacto.value+"&telefono="+telefono.value+"&ext="+ext.value+"&mail="+mail.value+"&notas="+notas.value);
}
</script>
<script>
function unpublish(id){ 
alert(empresa.value);

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

    alert("El elemento "+xmlhttp.responseText+" ha sido despublicado.")

    }

  }

xmlhttp.open("POST","unpublish.php?id="+id,true);

xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

xmlhttp.send();
}
</script>
<div id="confirmacion"></div>







<label for="empresa">Nombre de la empresa</label>

<input type="text" name="empresa" id="empresa"/><br />

<label for="contacto">Contacto</label>

<input type="text" name="contacto" id="contacto" /><br />

<label for="telefono">Telefono</label>

<input type="text" name="telefono" id="telefono" /><br />

<label for="ext">Extension</label>

<input type="text" name="ext"  id="ext"/><br />

<label for="mail">Mail</label>

<input type="text" name="mail"  id="mail"/><br />

<label for="notas">Notas</label>

<input type="text" name="notas" id="notas" /><br />


<button onclick="nueva_empresa();" name="agregar_empresa" id="agregar_empresa" >Agregar a la base de datos</button>
<TABLE border="1">
<thead>
<TR>
<th>ID</th><th>Editar</th><th>Empresa</th><th>Contacto</th><th>Telefono</th><th>Ext.</th><th>Mail</th><th>Notas</th>
</tr>
<? foreach($conjunto as $key=>$value){echo ("<tr><td>".$key."</td>".$value."</tr>");};
?>
   </TABLE>

 <button><a href="/eficine" >Salir</a></button>