<h1>Tablas de la base de datos</h1>
<table class="table table-striped">
    <tr>
        <th>Tabla</th>
        <th>Generar</th>
    </tr>
    <?php foreach ($tablas as $tabla): ?>
        <tr>
            <td><?php echo $tabla; ?></td>
            <td><a href="/crud_generator/generar_entidad/?tabla=<?php echo $tabla; ?>"><?php echo glyphicon("edit"); ?></a></td>
        </tr>
    <?php endforeach; ?>
</table>

