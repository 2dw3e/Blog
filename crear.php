<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="utf-8">
  
            <script type="text/javascript">
        
                function zenbatu() {
                    document.forms[0].karaktere.value=document.forms[0].contenido.value.length+1;
                }
            
                function limite(maxluzera){
                    if(document.forms[0].contenido.value.length>=maxluzera)
                        return false;
                    else
                        return true;
                }
            
             </script>
        
  </head>
  
<?php
 $servername = "localhost";
 $username = "id3313966_admin";
 $password = "admin";
    echo "Usuario: ".$_COOKIE['usuario']." ";
     $conn = new PDO("mysql:host=$servername;dbname=id3313966_talde4", $username, $password);
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
echo $hoy = date("j F Y, g:i a"); 
     
if (isset($_POST['bidali'])) {

    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $hoy = date("j F Y, g:i a");
    $usuario=$_COOKIE['usuario'];
    
    try{
        $conn -> beginTransaction();
        $conn -> exec("INSERT INTO post ( Titulo, pContenido, pFecha, Nick) VALUES ('$titulo', '$contenido', '$hoy', '$usuario')");
        $conn -> commit();
        echo"<script>window.location='index.php'</script>";
    }   catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
        //TENEMOS QUE PROBAR LO DEL INDEX, PARA QUE SE REDIRIJA, Y QUITAR EL LOGIN UNA VEZ LOGEADO (HIDDEN)
   // header("Location: crear.php");
    }

   ?>



<div>
    <form method="POST" action="crear.php">
        <input type="hidden" name="maxluzera" size="4" value="20000"><br>
        <input type="text" name="titulo" placeholder="Titulo"/><br>
        <input type="hidden" name="<?php $usuario ?>" value="<?php echo $usuario ?>"/>
        <input type="hidden" name="<?php echo $pass ?>" value="<?php echo $pass ?>"/>
        <textarea maxlength="" rows="10" cols="30" name="contenido" placeholder="Contenido"
        onkeypress="return limite(forms[0].maxluzera.value)"onkeydown="zenbatu()"></textarea><br>
        Karaktere: <input type="text" name="karaktere" size="4"><br>
        <button type="submit" name="bidali">Gorde</button>
    </form>

</div>



  </body>
</html>