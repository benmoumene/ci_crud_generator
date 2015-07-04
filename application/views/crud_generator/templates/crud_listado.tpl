<div class="content-header">
    <div class="header-section">
        <h1>
            <strong>Entidad: {nombre_controlador}</strong>
            <a class="btn btn-primary pull-right" href="/{nombre_controlador}/nuevo">Nuevo</a><br>
        </h1>
    </div>
</div>
<div class="block full">
    <div class="table-responsive">
        <table id="general-table" class="table table-striped table-vcenter table-hover">
            <thead>
                {cabecera}
            </thead>
            <tbody>
                <?php foreach($rows as $row): ?>
                {fila}
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

