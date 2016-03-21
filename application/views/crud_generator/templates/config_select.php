<!-- Modal -->
<div class="modal fade" id="modal-config-select" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Configuraciones para el Select</h4>
            </div>
            <div class="modal-body">
                <form id="form-config-option" class="form-inline">
                    <div class="form-group">
                        <label>Value</label><br>
                        <input type="text" class="form-control" name="value_field" id="value_field" />
                    </div>
                    <div class="form-group">
                        <label>Text</label><br>
                        <input type="text" class="form-control" name="text_field" id="text_field" />
                    </div>
                    <div class="form-group">
                        <label>Posicion</label><br>
                        <input type="number" placeholder="1" class="form-control" name="posicion" id="posicion" />
                    </div>
                    <div class="checkbox"><br>
                        <label>
                            <input type="checkbox" value="1" name="selected" id="selected" /> Selected
                        </label>
                    </div>
                    <div class="form-group pull-right"><br>
                        <button class="btn btn-sm btn-success " id="btn-agregar-option" type="button"><?php echo glyphicon("plus"); ?></button>
                    </div>
                </form>
                <div id="contenedor-options-select">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn-guardar-cambios">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>