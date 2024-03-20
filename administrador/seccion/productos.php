<?php include('../template/header.php'); ?>



<?php
function obtenerCampo($campo, $valorPredeterminado = '') {
    return isset($_POST[$campo]) ? $_POST[$campo] : $valorPredeterminado;
}

$textID = obtenerCampo('txtID');
$textnombre = obtenerCampo('txtnombre');
$textdescripcion = obtenerCampo('txtdescripcion');
$textprecio = obtenerCampo('txtprecio');
$textimagen = obtenerCampo('txtimagen', '');
$accion = obtenerCampo('accion', '');


include('../config/db.php');

switch ($accion) {

    case "Agregar":
        $sentenciaSQL = $conexion->prepare("INSERT INTO productos (Nombre, Descripcion, Precio, Imagen) VALUES (:nombre, :descripcion, :precio, :imagen);");
        $sentenciaSQL->bindParam(':nombre', $textnombre);
        $sentenciaSQL->bindParam(':descripcion', $textdescripcion);
        $sentenciaSQL->bindParam(':precio', $textprecio);
        $sentenciaSQL->bindParam(':imagen', $textimagen);

        $nombreArchivo = $_FILES['txtimagen']['name'];
        $tmpImagen = $_FILES['txtimagen']['tmp_name'];

        if ($tmpImagen != "") {
            move_uploaded_file($tmpImagen, "../../assets/images/" . $nombreArchivo);
        }

        $sentenciaSQL->execute();
        header("Location: productos.php");
        break;





        case "Modificar":
            // Obtener la imagen actual del producto
            $sentenciaSQL = $conexion->prepare("SELECT imagen FROM productos WHERE ID = :ID");
            $sentenciaSQL->bindParam(':ID', $textID);
            $sentenciaSQL->execute();
            $producto = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $imagen_anterior = $producto['imagen'];
        
            // Actualizar los datos del producto excepto la imagen
            $sentenciaSQL = $conexion->prepare("UPDATE productos SET nombre=:Nombre, descripcion=:Descripcion, precio=:Precio WHERE ID=:ID");
            $sentenciaSQL->bindParam(':Nombre', $textnombre);
            $sentenciaSQL->bindParam(':Descripcion', $textdescripcion);
            $sentenciaSQL->bindParam(':Precio', $textprecio);
            $sentenciaSQL->bindParam(':ID', $textID); 
            $sentenciaSQL->execute();
        
            // Si se proporciona una nueva imagen y es diferente a la imagen anterior
            if ($_FILES['txtimagen']['name'] != "" && $_FILES['txtimagen']['name'] != $imagen_anterior) {
                $nombreArchivo = $_FILES['txtimagen']['name'];
                $tmpImagen = $_FILES['txtimagen']['tmp_name'];
                move_uploaded_file($tmpImagen, "../../assets/images/" . $nombreArchivo);
        
                // Eliminar la imagen anterior si no es la imagen predeterminada
                if ($imagen_anterior != "imagen.jpg" && file_exists("../../assets/images/$imagen_anterior")) {
                    unlink("../../assets/images/$imagen_anterior");
                }
        
                // Actualizar la imagen del producto en la base de datos
                $sentenciaSQL = $conexion->prepare("UPDATE productos SET imagen=:Imagen WHERE ID=:ID");
                $sentenciaSQL->bindParam(':Imagen', $nombreArchivo);
                $sentenciaSQL->bindParam(':ID', $textID);
                $sentenciaSQL->execute();
            }
            header("Location: productos.php");
            break;
        
        



    case "Cancelar":

        header("Location: productos.php");
        
        break;

        case "Seleccionar":

            $sentenciaSQL = $conexion->prepare("SELECT * FROM productos WHERE ID=:ID");
            $sentenciaSQL->bindParam(':ID', $textID);
            $sentenciaSQL->execute();
        

            $producto = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
        

            if ($producto) {

                $textnombre = $producto['Nombre'];
                $textdescripcion = $producto['Descripcion'];
                $textprecio = $producto['Precio'];
                $textimagen = $producto['Imagen'];
            } else {
 
            }
            break;
        

    case "Borrar":
        $sentenciaSQL = $conexion->prepare("SELECT Imagen FROM productos WHERE ID=:ID");
        $sentenciaSQL->bindParam(':ID', $textID);
        $sentenciaSQL->execute();

        $productos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

        foreach ($productos as $producto) {
            $imagen = $producto['Imagen'];

            if (isset($imagen) && $imagen != "imagen.jpg") {

                $rutaImagen = "../../assets/images/$imagen";
                if (file_exists($rutaImagen)) {

                    if (unlink($rutaImagen)) {
                    } else {

                    }
                }
            }
        }



        $sentenciaSQL = $conexion->prepare("DELETE FROM productos WHERE ID=:ID;");
        $sentenciaSQL->bindParam(':ID', $textID);
        $sentenciaSQL->execute();

        

        header("Location: productos.php");
        break;
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM productos;");
$sentenciaSQL->execute();
$listaproductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);




?>



<h1>Productos</h1>

<div class="col-md-4">

    <div class="card">
        <div class="card-header">
            Datos de la categoria
        </div>

        <div class="card-body">

            <form method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="txtID">ID</label>
                    <input type="text" required readonly class="form-control" value="<?php echo $textID; ?>" name="txtID" id="txtID" placeholder="ID">
                </div>

                <div class="form-group">
                    <label for="txtnombre">Titulo</label>
                    <input type="text" required class="form-control" value="<?php echo $textnombre; ?>" name="txtnombre" id="txtnombre" placeholder="Titulo">
                </div>

                <div class="form-group">
                    <label for="txtdescripcion">Descripcion</label>
                    <input type="text"  class="form-control" value="<?php echo $textdescripcion; ?>" name="txtdescripcion" id="txtdescripcion" placeholder="Descripcion">
                </div>

                <div class="form-group">
                    <label for="txtprecio">Precio</label>
                    <input type="text"  class="form-control" value="<?php echo $textprecio; ?>" name="txtprecio" id="txtprecio" placeholder="Precio">
                </div>

                <div class="form-group">
                    <label for="textimagen">Imagen</label>

                    <?php if ($textimagen != "") { ?>
                        <p><?php echo $textimagen; ?></p>

                        <img class="img-thumbnail rounded" src="../../assets/images/<?php echo $textimagen; ?>" width="50" alt="Imagen seleccionada">

                    <?php } ?>

                    <input type="file" require class="form-control" name="txtimagen" id="txtimagen" placeholder="Imagen">
                </div>

                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?php echo ($accion=="Seleccionar"?"disabled":"")?> value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" <?php echo ($accion!="Seleccionar"?"disabled":"")?> value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" <?php echo ($accion!="Seleccionar"?"disabled":"")?> value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>
            </form>
        </div>

    </div>




</div>

<div class="col-md-8">

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Descripcion</th>
                <th>Precio</th>
                <th>imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listaproductos as $producto) {  ?>
                <tr>
                    <td><?php echo $producto['ID']; ?></td>
                    <td><?php echo $producto['Nombre']; ?></td>
                    <td><?php echo $producto['Descripcion']; ?></td>
                    <td><?php echo $producto['Precio']; ?></td>




                    <td><?php echo $producto['Imagen']; ?>
                        <img class="img-thumbnail rounded" src="../../assets/images/<?php echo $producto['Imagen']; ?>" width="50" alt="">
                    </td>


                    <td>

                        <form method="POST">

                            <input type="hidden" name="txtID" id=" txtID" value="<?php echo $producto['ID']; ?>" />

                            <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary" />

                            <input type="submit" name="accion" value="Borrar" class="btn btn-danger" />


                        </form>


                    </td>


                </tr>
            <?php } ?>

        </tbody>
    </table>

</div>



<?php include('../template/footer.php'); ?>