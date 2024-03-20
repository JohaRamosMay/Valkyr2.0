<?php 
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Hash de la contraseña almacenada en la base de datos
    $hash_password_guardado = password_hash('12345', PASSWORD_DEFAULT);

    $hash_password_usuario = ($usuario == 'valkyriafundas') ? $hash_password_guardado : null;

    if ($hash_password_usuario && password_verify($password, $hash_password_usuario)) {
        // Inicio de sesión exitoso
        $_SESSION['usuario'] = 'ok';
        $_SESSION['nombreUsuario'] = 'valkyriafundas';
        header("Location:inicio.php");
        exit();
    } else {
        $mensaje = "Error: El usuario o contraseña son incorrectos";
    }
}
?>



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador del sitio web</title>
</head>
<body>
<!doctype html>
<html lang="en">
  <head>
    <title>Administrador</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      
  <div class="container">
    <div class="row">

<div class="col-md-4">
    
</div>

    <div class="col-md-4">
<br><br><br>        
            <div class="card">
            
                <div class="card-header">
                    Iniciar sesión
                </div>
                <div class="card-body">

                <?php if (isset($mensaje)) {?>

                <div class="alert alert-danger" role="alert">
                    <?php echo $mensaje; ?>
                </div>

              <?php }?>
                <form method="POST" >
                   <div class = "form-group">
                   <label >Usuario</label>
                   <input type="text" class="form-control" name="usuario" placeholder="Escribe tu usuario">
                   </div>

                   <div class="form-group">
                   <label >Contraseña:</label>
                   <input type="password" class="form-control" name="password" placeholder="Escribe tu contraseña">
                   </div>
                   <button type="submit" class="btn btn-primary">Entrar al administrador</button>
                   </form>
                   
                    
                </div>
            </div>
            
        </div>
        
    </div>
  </div>
  </body>
</html>


    
</body>
</html>