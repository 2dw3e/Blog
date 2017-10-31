<?php
$usuario = $_POST['nombre'];
$pass = $_POST['password'];

//setcookie('usuario',"", time() - (86400 * 30), "/"); // 86400 = 1 day
//setcookie('pass', "", time() - (86400 * 30), "/"); // 86400 = 1 day

setcookie('usuario', $usuario, time() + (86400 * 30), "/"); // 86400 = 1 day
setcookie('pass', $pass, time() + (86400 * 30), "/"); // 86400 = 1 day

$servername = "localhost";
$username = "id3313966_admin";
$password = "admin";

define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'id3313966_admin');
   define('DB_PASSWORD', 'admin');
   define('DB_DATABASE', 'id3313966_talde4');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

    $conn = new PDO("mysql:host=$servername;dbname=id3313966_talde4", $username, $password);

if(empty($usuario) || empty($pass)){
header("Location: index.php");
   }else{
   $sql = "SELECT Nick FROM usuarios WHERE Nick='$usuario'AND pass='$pass'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1) {
         $_SESSION['login_user'] = $usuario;
         
        $resultado = $conn->query("SELECT Administrador FROM usuarios WHERE Nick='$usuario'AND pass='$pass'");
        while ($registro = $resultado->fetch()) {
         if($registro['Administrador']==1){
             $hidden="button";
         }else{
             $hidden="hidden";
         }
        }
         
      }else {
        echo  "Izena edo pasahitza txarto";
        ?>   
            <form method="POST" action="index.php">
        		<input type="submit" class="btn btn-primary"value="Atzera"/>
    		</form>
		<?php
		
        exit();
      }
   
}
 
$resultado = $conn->query("SELECT * FROM usuarios WHERE Nick='$usuario'AND pass='$pass'");
while ($registro = $resultado->fetch()) {
        echo "Ongoietorri ";
		echo (utf8_encode($registro['Nick']."<br>"));
	}
?>


<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<title>Login</title></head>
<body>
    <div>
		<form method="POST" action="crear.php">
            <input type="hidden" name="nombre" value="<?php echo $usuario ?>"/>
            <input type="hidden" name="password" value="<?php echo $pass ?>"/>
    		<input type="submit" class="btn btn-primary"value="Sortu Posta"/>
		</form>
</div>

<div>

	<br><br><br>
		<center>Tus post
		
	<br><br><br>
	    <?php
	$resultado = $conn->query("SELECT * FROM post WHERE Nick='$usuario'");
    while ($registro = $resultado->fetch()) {
        $id=$registro['ID_Post'];
		echo (utf8_encode($registro['Titulo']."<br>"));
		echo (utf8_encode($registro['pContenido']."<br>"));
		echo (utf8_encode($registro['pFecha']."<br>"));
		echo (utf8_encode($registro['Nick']."<br>"));
		?>
		<form method="POST" action="index.php">
		    <input type="hidden" value ="<?php echo $id ?>" name="id">
            <input type="submit" value="Ezabatu" name="ezabatu" <?php echo $hidden ?>>
		</form>
		<?php
	echo"<br><br><br>";
	
	}
	?>
	</center>
</div>
</body>
</html>
