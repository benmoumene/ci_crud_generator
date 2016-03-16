<!-- Modal -->
<div class="modal fade" id="modal-config-select-fk" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Configuraciones para el Select</h4>
            </div>
            <div class="modal-body">
                <form id="form-config-select-fk" class="form">
                    <div class="form-group">
                        <label>Nombre Tabla Fuente</label>
<!--                        <input type="text" class="form-control" name="table" id="table" />-->
                        <select class="form-control" name="table_fk" id="table_fk">
                            <?php echo option('', 'Seleccione una tabla'); ?>
                            <?php foreach ($tablas as $tabla_fk): ?>
                                <?php echo option($tabla_fk, $tabla_fk); ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nombre Campo "value"</label>
<!--                        <input type="text" class="form-control" name="value_field" id="value_field" />-->
                        <select class="form-control" name="value_field" id="value_field" >
                            <option value="">Seleccione una tabla</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nombre Campo "text"</label>
<!--                        <input type="text" class="form-control" name="text_field" id="text_field" />-->
                        <select class="form-control" name="text_field" id="text_field" >
                            <option value="">Seleccione una tabla</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Condici&oacute;n "where"</label>
                        <input type="text" class="form-control" name="where" id="where" />
                    </div>
                    <div class="form-group">
                        <label>Query personalizada</label>
                        <textarea class="form-control" name="query" id="query"></textarea>
                    </div>
            </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn-guardar-cambios">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>