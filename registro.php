<?

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

if($_POST['email']){   
$hashed_password = crypt($_POST['contrasena']);

$sql="INSERT INTO usuarios (email, password) VALUES ('".$_POST['email']."' ,'".$hashed_password."')";

	
		mysql_query($sql);
		echo "registro exitoso";
		} 
		else{?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>AVANTI PICTURES | USUARIOS-REGISTRO</title>
<script>
function clean(el){ if(el==1){document.getElementById("email").value="";document.getElementById("email").onclick="";document.getElementById("email").style.color="#000"};
if(el==2){document.getElementById("contraseña").value="";document.getElementById("contraseña").type="password";document.getElementById("contraseña").style.color="#000"}};
function login(){ alert(document.getElementById("contraseña").value);document.getElementById("form").submit()};
</script>

<div id="login">
            	<form action="http://www.avantipictures.com/eficine/registro.php" method="post" id="form" name="form"  enctype="application/x-www-form-urlencoded">
                	<table>
                    	<tr>
                        	
                        	<td>
                            	<input class="forms" id="email" name="email" size="20"  value="email" onclick="clean(1);"/>
                            </td>
                            <td>
                            	<input type=""  class="forms" id="contraseña" name="contrasena"  size="20" value="contraseña" onclick="clean(2);" onfocus="clean(2);" />
                            </td>
                            <td>
                            	<button id="entrar" type="submit" style="background: #354F67">
                                Entrar
                                	
                                </button>
                            </td>
                        </tr>
                        </table>
                    
                </form>
            </div><? } ?>