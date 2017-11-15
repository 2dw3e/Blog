<!DOCTYPE html>
<html lang="en">

  <head>

    <title>Talde4</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <!-- Custom styles for this template -->
    <link href="css/clean-blog.min.css" rel="stylesheet">
    <link href="css/nuestro.css" rel="stylesheet">
    </head>
  <body class="masthead" style="background-image: url('img/fondo.jpg')">
  <?php
  session_start();
  error_reporting(0);
  //PARA CONECTAR CON LA BD
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
     if(isset($_POST['ezabatu'])){
        $v=$_POST['id'];
        $conn -> beginTransaction();
        $conn -> exec("DELETE FROM `post` WHERE ID_Post='$v'");
        $conn -> commit();
    } 
//OCULTAR CIERTOS BOTONES
    $log=false;
    $hid='';
      if($log==true){
          $hid='hidden';
      }  
//VACÍA LA SESSIÓN
    if(isset($_POST['logout'])){
	    unset($_SESSION['nick']);
	    unset($_SESSION['pass']);
	}
//PARA AÑADIR COMETARIOS
    if( isset($_POST['komen']) && $_SESSION['nick']!=null){
        try{
            $idkom=$_POST['komen'];
            $contenido=$_POST['komentar'];
            $hoy = date("j F Y, g:i a");
            $nick=$_SESSION['nick'];
            
            $conn -> beginTransaction();
            $conn -> exec("INSERT INTO comentarios ( cContenido, cFecha, Nick, ID_Post) VALUES ('$contenido', '$hoy', '$nick','$idkom') ");
            $conn -> commit();
            echo"<script>window.location='index.php'</script>";
            
        } catch (Exception $e) {
                echo 'Excepción capturada: ',  $e->getMessage(), "\n";
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
              <li class="nav-item busca">
                <form method="post">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <a class="nav-item"> » </a>
                    <input name="key" type="text" id="key" size="10" onkeyup="buscar(this.value)"/>
               </form>
              </li>
              <li class="nav-item">
                  <?php
//SI ESTÁS LOGEADO, ESTO NO TE APARECE
                    if($_SESSION['nick']==null){
                        ?>
                        <a class="nav-link" href="crearusuario.php">Erregistratu</a>
                        <?php
                    } 
                  ?>
              </li>
               <li class="nav-item">
                <li id="reloj" class="nav-item">
                  <a id="hora" class="nav-link"></a>
                </li>
                <?php
//SI ESTÁS LOGEADO, ESTO NO TE APARECE
                    if($_SESSION['nick']==null){
                ?>
                <form method="POST" action="Balidatu.php" <?php echo $hid?>>
                	<input type="text" name="nombre" placeholder="Erabiltzailea" />
                	<input type="password" name="password" placeholder="Pasahitza" />
                	<button type="submit" class="btn btn-secondary">Logeatu
                	<i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                	</button>
                </form>
                 </li>
                <?php 
                    }else{
                        ?>
                        <li class="nav-item">
                    <form method="POST" action="Balidatu.php" <?php echo $hid?>>
                    	<button type="submit" class="btn btn-secondary">Zure gunea
                    	<i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                    	</button>
<!-- PARA LLEVARTE LOS DATOS DEL USUARIO -->
                        <input type="hidden" name="nombre" value="<?php echo $_SESSION['nick'] ?>"/>
                    	<input type="hidden" name="password" value="<?php echo $_SESSION['pass'] ?>"/>
                    </form>
                    </li>
                    <li class="nav-item">
                    <form method="POST" action="index.php" <?php echo $hid?>>
                    	<button type="submit" class="btn btn-danger" name="logout">Logout
                    	<i class="fa fa-power-off" aria-hidden="true"></i>
                    	</button>
                    	<?php 
                    	setcookie('usuario',"", time() - (60), "/");
                        setcookie('pass', "", time() - (60), "/");
                    	?>
                    </form>
                    </li>
                <?php 
                    }
                ?>
            </ul>
          </div>
        </div>
      </nav>
       

    <!-- Page Header -->
    <header class="masthead" style="background-image: url('img/home-bg.jpg')">
      <div class="container">
        <div class="row">
              <!-- las columnas que coge -->
          <div class="col-lg-8 col-md-10 mx-auto">
                <!-- estilo -->
            <div class="site-heading">
              <h1>Talde 4<i class="fa fa-ravelry" aria-hidden="true"></i></h1>
              <span class="subheading">Blog baten bloga</span>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto card" >
          <div class="post-preview" id="tabla">
              
        <?php
//PARA SACAR LOS POST EN DESCENDENTE
            $resultado = $conn->query("SELECT * FROM post ORDER BY ID_Post DESC");
             while ($registro = $resultado->fetch()) {
                // $kont=0;
                $id=$registro['ID_Post'];
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


            <hr>
            
          <div class="card my-4">
              
              <?php
//SI ESTÁS LOGEADO, PUEDES ESCRIBIR UN COMENTARIO
                    if($_SESSION['nick']!=null){
                ?>
                <h5 class="card-header">Komentario bat utzi:</h5>
                <div class="card-body">
                  <form method="POST" action="">
                    <div class="form-group">
                      <textarea class="form-control" rows="1" name="komentar" placeholder="Komentatu"></textarea>
                    </div>
                    <button type="submit" value="<?php echo $id?>" class="btn btn-primary" name="komen">Bidali</button>
                  </form>
                </div>
                
                
        <?php 
    }
//PARA SACAR TODOS LOS COMENTARIOS DE CADA POST
            $coment = $conn->query("SELECT * FROM comentarios WHERE ID_Post='$id'");
             while ($regis = $coment->fetch()) {
                $idcoment=$regis['ID_Comentario'];
		    ?>
             <!-- Single Comment -->
          <div class="col-lg-11 col-md-1 mx-auto">
            <div class="media-body">
              <h5 class="mt-0">
              <?php
	           echo $regis['Nick'];
              ?> komentatu du
              </h5>
               <?php
	           echo $regis['cContenido']."<br>";
              ?>
              <cite class="post-meta"><?php echo $regis['cFecha']; ?></cite>
              <hr>
            </div>
            
          </div>
          <?php } ?>
          </div>
          <hr>
        <?php }	?>
          </div>
        </div>
      </div>
    </div>
<!-- EL BOTÓN QUE TE ENVÍA ARRIBA -->
    <input id="pinchable" type="button" class="btn btn-outline-secondary" value="Iragarki" />
    <script>document.getElementById("pinchable").onmouseover = muestraMensaje;</script>

    <!-- Footer -->
    <footer>
        <div class="container">
          <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
              <ul class="list-inline text-center">
                <li class="list-inline-item">
                  <a href="https://twitter.com/official_php?lang=es"target="_blank">
                    <span class="fa-stack fa-lg">
                      <i class="fa fa-circle fa-stack-2x"></i>
                      <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                    </span>
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="http://php.net/"target="_blank">
                    <span class="fa-stack fa-lg">
                      <i class="fa fa-circle fa-stack-2x"></i>
                      <i class="fa fa-circle fa-stack-1x fa-inverse"></i>
                    </span>
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="https://github.com/2dw3e/Blog"target="_blank">
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

    <!-- Custom scripts for this template -->
    <script src="js/clean-blog.min.js"></script>
    <!-- JavaScript -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<!-- EL SCRIPT SE PONE SIEMPRE ABAJO, SI NO, DA PROBLEMAS -->
	    <script src="js/nuestro.js"></script>
	  </body>

</html>