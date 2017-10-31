<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="utf-8">
  </head>
  
<?php
 $servername = "localhost";
 $username = "id3313966_admin";
 $password = "admin";
     $conn = new PDO("mysql:host=$servername;dbname=id3313966_talde4", $username, $password);
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     
if (isset($_POST['bidali'])) {

    $izena = $_POST['izena'];
    $pasahitza = $_POST['pasahitza'];
    
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

    <div>
        <form method="POST" action="crearusuario.php">
            <input type="text" name="izena" placeholder="Izena" /><br>
            <input type="text" name="pasahitza" placeholder="Pasahitza"/><br>
            <button type="submit" name="bidali">Sortu</button>
        </form>
    </div>
  </body>
</html>