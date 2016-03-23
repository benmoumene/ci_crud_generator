<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="iso-8859-1">
        <title>CRUD Generator</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <!-- Custom -->
        <link rel="stylesheet" href="<?php echo asset_url(); ?>/css/crud_generator/crud_generator.css" />
    </head>
    <body >
        <div class="container"  ng-app="CrudGenerator">

            <?php
            if (isset($contenido)) {
                echo $contenido;
            }
            ?>
        </div>

        <!--
        está para probar con angular js
        <script src="/assets/librerias/angular/angular.min.js" type="text/javascript"></script>
                <script src="/assets/librerias/angular/ui-bootstrap-custom-tpls-1.2.5.min.js" type="text/javascript"></script>
                <script src="/assets/js/controllers/FormGeneratorController.js" type="text/javascript"></script>-->

        <script src="/assets/js/core/jquery-1.11.0.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <!-- JS locales -->
        <script src="<?php echo asset_url(); ?>/js/core/core.js"></script>
        <script src="<?php echo asset_url(); ?>/js/core/pubsub/pubsub.js"></script>
        <script src="<?php echo asset_url(); ?>/js/main.js"></script>
        <script src="<?php echo asset_url(); ?>/js/crud_generator/crud_generator.js"></script>
        <script src="<?php echo asset_url(); ?>/js/crud_generator/lib_config/config_select.js" type="text/javascript"></script>
        <script src="<?php echo asset_url(); ?>/js/crud_generator/lib_config/config_select_fk.js" type="text/javascript"></script>
        <div id='script_container'></div>

    </body>
</html>


