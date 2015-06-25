<a href="/provincia/nuevo">Nuevo</a><br>
<table border="1">
    <tr>
<th>id_provincia</th>
<th>nombre</th>
<th>orden</th>
<th>activo</th>
<th>Editar</th>
</tr>

    <?php foreach($rows as $row): ?>
    <tr>
<td><?php echo element($row, 'id_provincia', ''); ?></td>
<td><?php echo element($row, 'nombre', ''); ?></td>
<td><?php echo element($row, 'orden', ''); ?></td>
<td><?php echo element($row, 'activo', ''); ?></td>
<td><a href='/provincia/editar/<?php echo element($row, 'id_provincia', 0); ?>'>Editar</a></td>
</tr>

    <?php endforeach; ?>
</table>
    <?php echo $paginador; ?>
