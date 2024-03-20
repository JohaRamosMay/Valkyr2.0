<?php include("template/header.php"); ?>


<?php include("administrador/config/db.php");
function obtenerListaProductos($conexion, $buscar = null)
{
    $query = "SELECT * FROM productos";
    $params = array();

    if ($buscar !== null) {
        $query .= " WHERE Nombre LIKE :buscar OR Descripcion LIKE :buscar";
        $params[':buscar'] = '%' . $buscar . '%';
    }

    $sentenciaSQL = $conexion->prepare($query);
    $sentenciaSQL->execute($params);

    return $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
}

$listaproductos = obtenerListaProductos($conexion, $_GET['buscar'] ?? null);

if (empty($listaproductos) && isset($_GET['buscar'])) {
    $listaproductos = obtenerListaProductos($conexion);
}
?>

<!--Productos-->

<section data-bs-version="5.1" class="features4 cid-u7wHZvYzwn" id="features04-m">

    <div class="container-fluid">
        <div class="mbr-section-head mb-5">
            <h4 class="mbr-section-title mbr-fonts-style align-left mb-0 display-2">
                <strong>Descubre nuestro catálogo</strong>
            </h4>
        </div>
        <br>
        <form action="" method="GET" class="col-12 col-md-6 col-lg-3 mx-auto">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Buscar productos" name="buscar">
                <button class="btn btn-primary display-4" type="submit" style="margin-left: 10px;">Buscar</button>
            </div>
        </form>
        <br>
        <br>

        <div class="row">
            <?php foreach ($listaproductos as $producto) { ?>
                <div class="item features-image col-12 col-md-6 col-lg-3">
                    <div class="item-wrapper">
                        <div class="item-img">
                            <img src="./assets/images/<?php echo $producto['Imagen']; ?>" width="100" alt="">
                        </div>
                        <div class="item-content">
                            <h5 class="item-title mbr-fonts-style display-5">
                                <strong><?php echo $producto['Nombre']; ?></strong>
                            </h5>
                            <h5 class="item-subtitle mbr-fonts-style display-5">
                                <strong><?php echo $producto['Precio']; ?></strong>
                            </h5>
                            <p class="mbr-text mbr-fonts-style display-7">
                                <?php echo $producto['Descripcion']; ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<?php include("template/footer.php"); ?>