<table border="1">
    <tr><th>id_provincia</th><th>nombre</th><th>cod_postal</th><th>activo</th></tr>
    <?php foreach ($rows as $row): ?>
        <tr>
            <td><?php echo get_value($row, 'id_provincia', ''); ?></td><td><?php echo get_value($row, 'nombre', ''); ?></td><td><?php echo get_value($row, 'cod_postal', ''); ?></td><td><?php echo get_value($row, 'activo', ''); ?></td></tr>
    <?php endforeach; ?>
</table>
<?php echo $paginador; ?>
