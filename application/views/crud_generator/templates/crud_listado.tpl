<div class="content-header">
    <div class="header-section">
        <h1>
            <strong>Parametros:</strong> Adicionales
        </h1>
    </div>
</div>
<div class="block full">
    <div class="block-title">
        <h2>Adicionales</h2>
    </div>
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

