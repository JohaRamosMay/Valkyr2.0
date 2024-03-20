<?php include('template/header.php'); ?>


<div class="col-md-12">

    <div class="jumbotron">
        <h1 class="display-3">Bienvenido <?php echo  $nombreUsuario; ?></h1>
        <hr class="my-2">
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="seccion/productos.php" role="button">Administrar catálogo</a>
        </p>
    </div>

</div>

<?php include('template/footer.php'); ?>