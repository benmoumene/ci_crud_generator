<table border="1">
    <tr>
        <td>ID</td>
        <td>Nombre</td>
    </tr>
    <?php foreach ($registros as $registro): ?>
        <tr>
            <td><?php echo $registro["id_provincia"]; ?></td>
            <td><?php echo $registro["nombre"]; ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php echo $paginador; ?>