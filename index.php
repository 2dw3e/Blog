<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>

  <p id="hora"></p>
 <script type="text/javascript">
 //reloj digital
    var n = setInterval(starts(),1000)
    function starts() {
    var data = new Date();
    var h = data.getHours();
    var m = data.getMinutes();
    var s = data.getSeconds();
    // add a zero in front of numbers<10
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById("hora").innerHTML = h + ":" + m + ":" + s;
    var t = setTimeout(function(){ starts() }, 500);
}
function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}
</script>
<div>
		<form method="POST" action="Balidatu.php">
			<input type="text" name="nombre" placeholder="Erabiltzailea" />
			<input type="password" name="password" placeholder="Pasahitza" />
			<button type="submit" class="btn btn-primary">Login</button>
		</form>
		<form method="POST" action="crearusuario.php">
			<button type="submit" class="btn btn-primary">Sign In</button>
		</form>
</div>
  <?php
  //para conectar con la BD
    $servername = "localhost";
    $username = "id3313966_admin";
    $password = "admin";
    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=id3313966_talde4", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }
        
       //PARA BORRAR EL POST DEL BALIDATU
     if(isset($_POST['id'])){
        $v=$_POST['id'];
        $conn -> beginTransaction();
        $conn -> exec("DELETE FROM `post` WHERE ID_Post='$v'");
        $conn -> commit();
    } 
        
   ?>

   
   <center>
	    <?php
	$resultado = $conn->query("SELECT * FROM post");
	$coment = $conn->query("SELECT * FROM comentarios join post WHERE comentarios.ID_Post = post.ID_Post");
    while ($registro = $resultado->fetch()) {
        //saca los post y sus comentarios
        $kont=0;
		echo (utf8_encode($registro['Titulo']."<br>"));
		echo (utf8_encode($registro['pContenido']."<br>"));
		echo (utf8_encode($registro['pFecha']."<br>"));
		echo (utf8_encode($registro['Nick']."<br>"));
        while ($cont = $coment->fetch()) {
            echo (utf8_encode($cont['cContenido']."<br>"));
            echo (utf8_encode($cont['cFecha']."<br>"));
            $kont++;
        }
        echo "Comentarios: ",$kont,"<br>";
        echo "<br><br><br><br>";
	}
	?>
	</center>
	<input id="pinchable" type="button" value="Anuncio" />
	<script>
    function muestraMensaje() {
      alert('Bebe Coca-Cola');
    }
    document.getElementById("pinchable").onmouseover = muestraMensaje;
</script>
  </body>
</html>