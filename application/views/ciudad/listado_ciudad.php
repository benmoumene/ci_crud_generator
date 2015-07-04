<div class="content-header">
    <div class="header-section">
        <h1>
            <strong>Entidad: ciudad</strong>
            <a class="btn btn-primary pull-right" href="/ciudad/nuevo">Nuevo</a><br>
        </h1>
    </div>
</div>
<div class="block full">
    <div class="table-responsive">
        <table id="general-table" class="table table-striped table-vcenter table-hover">
            <thead>
                <tr>
<th>id_ciudad</th>
<th>id_provincia</th>
<th>nombre</th>
<th>cod_postal</th>
<th>activo</th>
<th class='text-center'>Acciones</th>
</tr>

            </thead>
            <tbody>
                <?php foreach($rows as $row): ?>
                <tr>
<td><?php echo element($row, 'id_ciudad', ''); ?></td>
<td><?php echo element($row, 'id_provincia', ''); ?></td>
<td><?php echo element($row, 'nombre', ''); ?></td>
<td><?php echo element($row, 'cod_postal', ''); ?></td>
<td><?php echo element($row, 'activo', ''); ?></td>
<td class='text-center'><div class='btn-group'>     <a data-toggle='tooltip' title='editar' class='btn btn-xs btn-default' href='/ciudad/editar/<?php echo element($row, 'id_ciudad', 0); ?>'><?php echo glyphicon('edit'); ?></a>     <a href='javascript:void(0)' data-toggle='tooltip' title='eliminar' class='btn btn-xs btn-danger'><?php echo glyphicon('trash'); ?></a></div></td>
</tr>

                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8">
                        <div class="btn-group btn-group-sm pull-right">
                            <nav>
                                <ul class="pagination">
                                    <?php echo $paginador; ?>
                                </ul>
                            </nav>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

