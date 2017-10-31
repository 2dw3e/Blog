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
    
    try{
        $conn -> beginTransaction();
        echo $izena." ezabatuta";
        $conn -> exec("DELETE FROM `usuarios` WHERE Nick='$izena'");
        $conn -> commit();
        echo"<script>window.location='index.php'</script>";
    }   catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
    }
   ?>

    <div>
        <form method="POST" action="borrar.php">
            Sartu azabatu nahi duzun erabiltzailea
            <input type="text" name="izena" placeholder="Izena" /><br>
            <button type="submit" name="bidali">Ezabatu</button>
        </form>
    </div>
  </body>
</html>