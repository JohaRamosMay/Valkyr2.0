<?php include("template/header.php"); ?>

<?php include("administrador/config/db.php");

$sentenciaSQL = $conexion->prepare("SELECT * FROM productos;");
$sentenciaSQL->execute();
$listaproductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>
<!--Productos-->

<section data-bs-version="5.1" class="features4 cid-u7wHZvYzwn" id="features04-m">


    <div class="container">
        <div class="mbr-section-head mb-5">
            <h4 class="mbr-section-title mbr-fonts-style align-left mb-0 display-2">
                <strong>Nuestros productos</strong>
            </h4>


        </div>
        <div class="row">
            <?php foreach ($listaproductos as $producto) { ?>
                <div class="item features-image col-12 col-md-6 col-lg-4">
                    <div class="item-wrapper">
                        <div class="item-img">
                            <img src="./assets/images/<?php echo $producto['Imagen']; ?>" width="100" alt="">
                        </div>
                        <div class="item-content">
                            <h5 class="item-title mbr-fonts-style display-5">
                                <strong><?php echo $producto['Nombre']; ?></strong>
                            </h5>
                            <h6 class="item-subtitle mbr-fonts-style display-7">
                                <strong><?php echo $producto['Precio']; ?></strong>
                            </h6>
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