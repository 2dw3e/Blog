<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Zure post</title>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <!-- Custom styles for this template -->
    <link href="css/clean-blog.min.css" rel="stylesheet">
    <link href="css/nuestro.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-latest.js"></script>
  </head> 
    
  <body class="masthead" style="background-image: url('img/fondo.jpg')">
     
      <span class="ir-arriba"></span>
      <section>
      <?php
//AQUÍ ENTRE LAS SESSIONS, LAS COOKIES Y LAS VARIABLES SE HACE LA MAGIA Y OCURRE QUE FUNCIONA
ob_start();
$admin=false;
error_reporting(0);
$usuario = $_POST['nombre'];
$pass = $_POST['password'];
session_start();
$_SESSION['nick']=$usuario;
$_SESSION['pass']=$pass;
//setcookie('usuario',"", time() - (60), "/");
//setcookie('pass', "", time() - (60), "/");

setcookie('usuario', $usuario, time() + (900), "/");
setcookie('pass', $pass, time() + (900), "/");

$servername = "localhost";
$username = "id3313966_admin";
$password = "admin";

define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'id3313966_admin');
   define('DB_PASSWORD', 'admin');
   define('DB_DATABASE', 'id3313966_talde4');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    $conn = new PDO("mysql:host=$servername;dbname=id3313966_talde4", $username, $password);

//PARA BORRAR EL POST DEL BALIDATU (TU ZONA)
     if(isset($_POST['ezabatu'])){
        $id=$_POST['id'];
        $usuario = $_POST['nombre'];
        $pass = $_POST['password'];
        $conn -> beginTransaction();
        $conn -> exec("DELETE FROM `post` WHERE ID_Post='$id'");
        $conn -> commit();
        echo"<script>window.location='index.php'</script>";
    } 

//if(empty($_COOKIE['usuario']) || empty($_COOKIE['pass'])){
if(empty($usuario) || empty($pass)){
    setcookie('usuario',"", time() - (60), "/");
    setcookie('pass', "", time() - (60), "/");
    $_SESSION['nick']=null;
    unset($_SESSION['nick']);
    unset($_SESSION['pass']);
//SI NO HAS METIDO LOS DATOS, TE VAS AL ENLACE PARA QUE TE CREES UN USUARIO
    header("Location: crearusuario.php");
?>
<script>alert ('Sartu erabiltzailea eta pasahitza');</script>
<?php
exit();
   }else{
   $sql = "SELECT Nick FROM usuarios WHERE Nick='$usuario'AND pass='$pass'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $count = mysqli_num_rows($result);
//PARA DIFERENCIAR SI ERES ADMIN O NO
      if($count == 1) {
         $_SESSION['login_user'] = $usuario;
         
        $resultado = $conn->query("SELECT Administrador FROM usuarios WHERE Nick='$usuario'AND pass='$pass'");
        while ($registro = $resultado->fetch()) {
         if($registro['Administrador']!=1){
             $hidden="hidden";
         }else{
             $hidden="button"; 
             $admin=true;
         }
        }
         
      }else {
        ?>   
            <form method="POST" action="index.php">
                <script>alert('ERROR');</script>
                <?php echo  "Izena edo pasahitza txarto";
                unset($_SESSION['nick']);
                ?>   
            <input type="submit" class="btn btn-primary"value="Atzera"/>
        </form>
    <?php
    
        exit();
      }
   if (isset($_POST['ezabatue'])) {

    $izena = $_POST['izena'];
    
    try{
        $conn -> beginTransaction();
        echo $izena." ezabatuta";
        $conn -> exec("DELETE FROM `post` WHERE Nick='$izena'");
        $conn -> commit();
        echo"<script>window.location='index.php'</script>";
    }   catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
    }
}
?>
      <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
          <button class="navbar-toggler navbar-toggler-right boton" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                  <!-- el icono -->
            <i class="fa fa-bars"></i>
          </button>
              <!-- Crea el desplegable -->
          <div class="collapse navbar-collapse" id="navbarResponsive">
                <!-- quita los puntos -->
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="index.php">Hasiera</a>
              </li>
               <li id="reloj" class="nav-item">
                  <a id="hora" class="nav-link"></a>
              </li>
              <li class="nav-item">
                <form method="POST" action="borrar.php">
                    <input class="btn btn-danger" type="submit" value="Ezabatu erabiltzaileak" name="ezabatue" <?php echo $hidden ?>>
                </form>
              </li>
              <li class="nav-item">
                <form method="POST" action="crear.php">
<!-- PARA ESCRIBIR POST -->
                    <input type="hidden" name="nombre" value="<?php echo $usuario ?>"/>
                    <input class="btn btn-secondary" type="submit" value="Sortu Post" name="post">
                </form>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      





    <header class="masthead" style="background-image: url('img/contact-bg.jpg')">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto ">
            <div class="page-heading">
              <h1>Zure profila<i class="fa fa-ravelry" aria-hidden="true"></i></h1>
              <span class="subheading">
                <?php echo $_SESSION['nick']=$usuario; ?> ,hemen daude zure postak.
              </span>
            </div>
          </div>
        </div>
      </div>
    </header>



    <!-- Page Header -->
<?php
if($admin==true){
?>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto card">
            <div class="post-preview" id="fondo">
                <h1>Post guztiak</h1>
        <?php
  $resultadoT = $conn->query("SELECT * FROM post ORDER BY pFecha DESC");
 while ($saca = $resultadoT->fetch()) {
     $ide=$saca['ID_Post'];
		?>
		<a class="not-active">
              <h2 class="post-title">
                <?php echo $saca['Titulo']."<br>";?>
              </h2>
              <h3 class="post-subtitle">
               <?php
               echo $saca['pContenido']."<br>";
               ?>
              </h3>
            </a>
            <p class="post-meta">Posted by
              <?php
	           echo $saca['Nick']."<br>";
              ?>
              on <?php echo $saca['pFecha']."<br>"; ?>
            </p>
       
    <form method="POST" action="Balidatu.php">
        <input type="hidden" value ="<?php echo $ide ?>" name="id">
            <input type="hidden" value ="<?php echo $usuario ?>" name="nombre">
            <input type="hidden" value ="<?php echo $pass ?>" name="password">
        <input type="submit" class="btn btn-secondary" value="Ezabatu" name="ezabatu">
    </form>
    <hr>
            <?php
          }
          ?>
             </div>
          </div>
        </div>
      </div>
<?php
    }else{
?>



    <!-- Main Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto card">
            <div class="post-preview" id="fondo">
        <?php
  $resultado = $conn->query("SELECT * FROM post WHERE Nick='$usuario' ORDER BY pFecha DESC");
 while ($registro = $resultado->fetch()) {
     $ide=$registro['ID_Post'];
		?>
		<a class="not-active">
              <h2 class="post-title">
                <?php echo $registro['Titulo']."<br>";?>
              </h2>
              <h3 class="post-subtitle">
               <?php
               echo $registro['pContenido']."<br>";
               ?>
              </h3>
            </a>
            <p class="post-meta">Posted by
              <?php
	           echo $registro['Nick']."<br>";
              ?>
              on <?php echo $registro['pFecha']."<br>"; ?>
            </p>
       
    <form method="POST" action="Balidatu.php">
        <input type="hidden" value ="<?php echo $ide ?>" name="id">
            <input type="hidden" value ="<?php echo $usuario ?>" name="nombre">
            <input type="hidden" value ="<?php echo $pass ?>" name="password">
        <input type="submit" class="btn btn-secondary" value="Ezabatu" name="ezabatu">
    </form>
    <hr>
            <?php
          }
          ?>
             </div>
          </div>
        </div>
      </div>
    <hr>
         <?php
             }
          ?>
    <!-- Footer -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <ul class="list-inline text-center">
              <li class="list-inline-item">
                <a href="https://twitter.com/ionicframework?lang=es"target="_blank">
                  <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="http://ionicframework.com/"target="_blank">
                  <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-circle fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="https://github.com/ionic-team/ionic"target="_blank">
                  <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-github fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
            </ul>
            <p class="copyright text-muted">Copyright &copy; Eric Salinas & Andrea Fernandez <i class="fa fa-ravelry" aria-hidden="true"></i> 2017</p>
          </div>
        </div>
      </div>
      <a class="go-top balidatu btn-primary" href="#"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/clean-blog.min.js"></script>
   <?php
          ob_end_flush();
          ?>
    </section>
        <!-- JavaScript -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="js/nuestro.js"></script>
  </body>
</html>