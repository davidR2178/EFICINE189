<?php
//Iniciamos la session al cargar la pagina por primera vez
session_start();
//Nos conectamos al servidor de base de datos
  $db_host = 'localhost';
  $db_user = 'root';
  $db_password = 'root';
  $db_db = 'AVANTI_PICTURES';
 
  $mysqli = new mysqli(
    $db_host,
    $db_user,
    $db_password,
    $db_db
  );
	
  if ($mysqli->connect_error) {
    echo 'Errno: '.$mysqli->connect_errno;
    echo '<br>';
    echo 'Error: '.$mysqli->connect_error;
    exit();
  }


//Actualizamos el ID de la sessión para el usuario actual
$sql="UPDATE usuarios SET phpsessid='xxx' WHERE phpsessid='".session_id()."'";

$mysqli->query($sql);



//Terminamos la session, asi el usuario deberá identificarse  para acceder a las listas.
session_destroy(); 

 //En caso de que el usuario se haya identificado, procedemos a validar sus credenciales
if($_POST['email'] || $_POST['contraseña']){
				//En caso de que las credenciales no hayan sido ingresadas en los campos, el sistema lo expulsa a cualquier lugar
				if($_POST['email'] =="email" || $_POST['contraseña']=="contraseña"){header('Location: http://atirodefuego.org');exit;}
				//Aqui validamos el password
			   $sql="SELECT password FROM `usuarios` WHERE email='".$_POST['email']."'";
			   $result=$mysqli->query($sql);
	
   		$row = $result->fetch_array(MYSQLI_ASSOC);
   
			   
					  
							if (crypt($_POST['contrasena'], $row['password']) === $row['password']) {
									//En caso de tener el password correcto, iniciamos nuevamente la session
									session_start();
									$_SESSION['id']=session_id();
									//Actualizamos la session en la DB
									$sql2="UPDATE usuarios SET phpsessid='".$_SESSION['id']."' WHERE email='".$_POST['email']."'";
									$mail=urlencode($_POST['email']);
									$mysqli->query($sql2);
								
									//Y redirigimos al usuario a la pagina de la lista
									
									header('Location: http://localhost:8888/eficine/publicidad.php?email='.$mail.'');
									
									exit;
							
							
						}
					//En caso de que alguna de ls credenciales ingresadas en los campos esté mal	
					else{header('Location: http://localhost:8888/eficine/test.php');exit;}
}
else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>AVANTI PICTURES | EFICINE</title>

<script>

function clean(el){ if(el==1){document.getElementById("email").value="";document.getElementById("email").onclick="";document.getElementById("email").style.color="#000"};
if(el==2){document.getElementById("contraseña").value="";document.getElementById("contraseña").type="password";document.getElementById("contraseña").style.color="#000"}};
function login(){ alert(document.getElementById("contraseña").value);document.getElementById("form").submit()};
</script>
<style>
.forms{ margin:3px;}
</style>
</head>
<body background="img/dark-triangles.png">
<div id="login" style="position:absolute; width:100%; height:100%">
	<div id="login_div" style="position:relative; width:312px; height:120px; margin:15% auto; background: #666666">
            	<form action="/eficine/test.php" method="post" id="form" name="form"  enctype="application/x-www-form-urlencoded">
                				<div>
                            	<input class="forms" id="email" name="email" size="20"  value=" email" onclick="clean(1);" style="width:300px; height:30px;"/>
                          </div>
                          <div>
                            	<input type=""  class="forms" id="contraseña" name="contrasena"  size="20" value=" contraseña" onclick="clean(2);" onfocus="clean(2);" style="width:300px; height:30px;"/>
                          </div>
                          <div>
                            	<button id="entrar" class="forms" type="submit" style="background:#CCFF33; width:305px; height:32px; f ">
                                Entrar
                                	
                                </button>
                         </div>
                    
                </form>
                </div>
            </div>
            <script>
			if(screen.width<840){document.getElementById("login_div").style.width="70%";
			document.getElementById("login_div").style.height="630px";
									document.getElementById("entrar").style.width="100%";
									document.getElementById("entrar").style.height="200px";
									document.getElementById("email").style.width="100%";
									document.getElementById("email").style.height="200px";
									document.getElementById("email").style.fontSize="50px";
									document.getElementById("contraseña").style.width="100%";
									document.getElementById("contraseña").style.height="200px";
									document.getElementById("contraseña").style.fontSize="50px";
									document.getElementById("entrar").style.fontSize="50px";
									
									};
			</script>
            </body>
            </html>
            
<?php
}
?>