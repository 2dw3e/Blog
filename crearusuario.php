<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <title>Erab. berria</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <!-- Custom styles for this template -->
    <link href="css/clean-blog.min.css" rel="stylesheet">
    <script src="js/nuestro.js"></script>
  </head>
    
  <body class="masthead" style="background-image: url('img/fondo.jpg')">
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

      <!-- Aqui van los input de usuario y contraseña -->

               <li id="reloj" class="nav-item">
                  <a id="hora" class="nav-link"></a>
              </li>

            </ul>
          </div>
        </div>
      </nav>

    <!-- Page Header -->
    <header class="masthead" style="background-image: url('img/contact-bg.jpg')">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="page-heading">
              <h1>Ongi etorri</h1>
              <span class="subheading">
                Sortu zure erabiltzailea <i class="fa fa-user-plus" aria-hidden="true"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </header>
    <?php
    if (isset($_POST['bidali'])) {

    $izena = $_POST['izena'];
    $pasahitza = $_POST['pasahitza'];
//PARA CREAR LOS USUARIOS
//SOLO HACE FALTA NOMBRE Y USUARIO, Y NO SE PUEDE REPETIR
    try{
        $conn -> beginTransaction();
        $conn -> exec("INSERT INTO usuarios ( Nick, pass) VALUES ('$izena', '$pasahitza')");
        $conn -> commit();
        echo"<script>window.location='index.php'</script>";
    }   catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
    }
   ?>

    <!-- Main Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto card">
          <p>Erabiltzaile berria sortzeko sartu izena eta pasahitza: </p>

          <form method="POST" action="crearusuario.php" name="sentMessage" id="contactForm" novalidate>
            <div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Izena</label>
                <input type="text" class="form-control" placeholder="Izena" name="izena" required data-validation-required-message="Mesedez sartu zure izena">
                <p class="help-block text-danger"></p>
              </div>
            </div>
            <div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Pasahitza</label>
                <input type="password" class="form-control" placeholder="Pasahitza" name="pasahitza" required data-validation-required-message="Mesedez sartu zure pasahitza">
                <p class="help-block text-danger"></p>
              </div>
            </div>
            <br>
            <div id="success"></div>
            <div class="form-group">
              <button type="submit" class="btn btn-secondary" name="bidali">Sortu</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <hr>

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
      </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/clean-blog.min.js"></script>

  </body>

</html>