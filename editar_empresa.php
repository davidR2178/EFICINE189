<?php	 	 
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
   $sql_b="SELECT id, empresa, contacto, telefono, ext, mail, notas FROM `empresas226` WHERE id=".$_GET['id']."";
   
   $result=mysql_query($sql_b);
   $row = mysql_fetch_array($result, MYSQL_ASSOC);?>
   <h1><? echo $row['empresa'] ?> </h1>
   <form action="empresas226.php" method="post" id="edit" name="edit">
   <table>
   <thead>
   <th>id</th><th>empresa</th><th>contacto</th><th>telefono</th><th>ext</th><th>mail</th>
   </thead>
   <tbody>
   <tr>
   <td>
   	<input id="id" name="id" value='<? echo $row['id']?>' />
    </td>
    <td>
    <input id="empresa" name="empresa" value='<? echo $row['empresa']?>' />
    </td>
    <td>
    <input id="contacto" name="contacto" value='<? echo $row['contacto']?>' />
	</td>
    <td>
    <input id="telefono" name="telefono" value='<? echo $row['telefono']?>' />
	</td>
    <td>
    <input id="ext" name="ext" value='<? echo $row['ext']?>' />
	</td>
    <td>
    <input id="mail" name="mail" value='<? echo $row['mail']?>' />
	</td>
    </tr>
    
    
   
    </tbody>
    </table>
    <textarea id="notas" name="notas" value='' style="width:400px; height:200px;" ><? echo $row['notas']?></textarea>
    <button type="submit">Guardar</button>
   </form>
   
   
   
   
   
   