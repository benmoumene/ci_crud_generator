<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="iso-8859-1">
        <title>CRUD Generator</title>
        <!-- Custom -->
        <link rel="stylesheet" href="<?php echo asset_url(); ?>/css/crud_generator/crud_generator.css" />
    </head>
    <body >
        <div class="container">

            <?php
            if (isset($contenido)) {
                echo $contenido;
            }
            ?>
        </div>
        <script src="/assets/js/core/jquery-1.11.0.min.js"></script>
        <!-- JS locales -->
        <script src="<?php echo asset_url(); ?>/js/core/core.js"></script>
        <script src="<?php echo asset_url(); ?>/js/main.js"></script>
        <div id='script_container'></div>

    </body>
</html>
