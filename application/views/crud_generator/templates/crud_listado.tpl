<div class="content-header">
    <div class="header-section">
        <h1>
            <strong>Entidad: {nombre_controlador}</strong>
            <a class="btn btn-primary pull-right" href="/{nombre_controlador}/nuevo">Nuevo</a><br>
        </h1>
    </div>
</div>
<div class="block full">
    <div class="row">
        <div id="filter-panel" class="filter-panel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-inline" action="/{nombre_controlador}/listar" method="GET" role="form">
                        <div class="input-group">
                            <div class="input-group-addon">Estado</div>
                            <select class="form-control">
                                <?php echo option(0, "Todos",0); ?>
                            </select>
                        </div> <!-- form group [rows] -->
                        <div class="input-group">
                            <div class="input-group-addon">Codigo</div>
                            <input type="text" class="form-control input-sm" value="" name="filtros[codigo]">
                        </div><!-- form group [search] -->

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <?php echo glyphicon("search"); ?> Buscar
                            </button>
                            <a href="/{nombre_controlador}/listar" class="btn btn-default"><?php echo glyphicon("trash"); ?> Limpiar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="block full">
    <?php if (empty($rows)): ?>
    <p class="lead"><strong class="text-danger"></strong> No se han encontrado remitos</p>
    <div style="border-top: 1px solid black;"></div>
    <?php else: ?>
    <div class="table-responsive">

        <span class="lead">
            Se han encontrado <strong class="text-danger">
                <?php echo $cant_registros; ?></strong> remitos
        </span>
        <span class="help-block pull-right">Mostrando <?php echo $RPP; ?> remitos por p&aacute;gina</span>
        <div style="border-top: 1px solid black;"></div>
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
    <?php endif; ?>
</div>

