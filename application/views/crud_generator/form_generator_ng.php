<style>
    .cortar{
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

</style>
<form action="/crud_generator/generar" method="POST" class="form form-horizontal" ng-controller="FormGeneratorController as FGCtrller" ng-init="FGCtrller.init('<?php echo $this->input->get("tabla"); ?>')" >
    <fieldset>
        <div class="form-group">
            <label>Nombre Entidad (controlador) </label>
            <input class="form-control" type="text" name="entidad" ng-model='FGCtrller.data.entidad'  /><br/>
        </div>
        <div class="form-group">
            <label>Tabla</label>
            <input class="form-control" type="text" name="tabla" ng-model='FGCtrller.data.tabla'  readonly /><br/>
        </div>
        <div class="form-group">
            <label>Sobrescribir archivos generados:</label>
            <select name="pisar_anterior">
                <option value="N" >NO</option>
                <option value="S" selected>S&Iacute;</option>
            </select>
        </div>
        <hr>
        <h3>Formulario Nuevo / Editar</h3>
        <br>
        <br>
        <div class="form-group">
            <table class="table table-hover table-striped table-bordered">
                <tr>
                    <th>
                        <input type="checkbox" ng-click='FGCtrller.toggle_generar_todo();' ng-model="FGCtrller.val_generar_todo" ng-checked="FGCtrller.val_generar_todo === 1" value="1" >
                        &iquest;Generar?
                    </th>
                    <th>Label</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Configuraciones</th>
                    <th>PK</th>
                </tr>
                <?php
                $columna = array("type" => "text");
                $es_pk = FALSE;
                //$es_pk = (int) $columna["primary_key"] === 1;
                $tipo_input_default = $es_pk ? "hidden" : element($relacion_input_tipo_columna, $columna["type"], "");
                //$destacar_tr = $es_pk ? " info " : "";
                ?>
                <tr  ng-repeat="columna in FGCtrller.data.columnas">
                    <td><input type="checkbox" class="js-chk-generar-campo" name='campos[{{columna.name}}][generar_input]' ng-model="columna.generar_input" ng-init="columna.generar_input = 0" value='1' /></td>
                    <td><input type='text' name='campos[{{columna.name}}][label]'  ng-model="columna.label" ng-init="columna.label = columna.name" /></td>
                    <td class="js-nombre-columna" >{{columna.name}}</td>
                    <td>
                        <select class="js-select-tipo-campo"
                                ng-change="FGCtrller.seleccionar_tipo_campo(columna)"
                                ng-model='columna.tipo_campo'
                                ng-init="columna.tipo_campo = (columna.primary_key === 1) ? 'hidden' : FGCtrller.relacion_input_tipo_columna[columna.type]"
                                name='campos[{{columna.name}}][tipo_campo]'>
                            <option value="">Seleccione...</option>
                            <option ng-repeat="(key, value) in FGCtrller.inputs_disponibles" value="{{key}}">{{value}}</option>
                        </select>
                    </td>
                    <td>
                        <code class="cortar" id="config_mostrar_{{columna.name}}"></code>
                        <a class="btn btn-xs btn-default js-edit-config" style="display:none;" href="javascript:void(0);"><?php echo glyphicon("edit"); ?></a>
                        <a class="btn btn-xs btn-danger js-delete-config" style="display:none;" href="javascript:void(0);"><?php echo glyphicon("trash"); ?></a>
                        <textarea style="display:none;" name="campos[{{columna.name}}][config]" id="config_{{columna.name}}" ng-model="columna.config" ></textarea>
                    </td>
                    <td><input type="radio" value="{{columna.name}}" name="pk" ng-checked="columna.primary_key === 1" ng-model="columna.primary_key" /></td>
                </tr>
            </table>
        </div>
        <hr>
        <h3>Listado</h3>
        <div class="form-group">
            <label>Ordenar por default en sentido:</label>
            <select  name='en_sentido'>
                <option value='desc' selected>DESC</option>
                <option value='asc'>ASC</option>
            </select>
        </div>
        <div class="form-group">
            <table class="table table-hover table-striped table-bordered">
                <tr>
                    <th>
                        <input type="checkbox" ng-click='FGCtrller.toggle_listar_todo();' ng-model="FGCtrller.val_listar_todo" ng-checked="FGCtrller.val_listar_todo === 1" value="1" >
                        &iquest;Mostrar?</th>
                    <th>Label</th>
                    <th>Nombre</th>
                    <th>
                        <input type="checkbox" ng-click='FGCtrller.togge_ordenar_todo();' ng-model="FGCtrller.val_ordenar_todo" ng-checked="FGCtrller.val_ordenar_todo === 1" value="1" >
                        &iquest;Puede ordenar?
                    </th>
                    <th>Ordenado Por Default</th>
                </tr>
                <tr  ng-repeat="columna in FGCtrller.data.columnas" ng-class="columna.primary_key === 1 ? 'info' : ''">
                    <td><input type="checkbox" class="js-chk-mostrar-campo" name='campos[{{columna.name}}][mostrar_listado]' ng-model="columna.mostrar_listado" ng-init="columna.mostrar_listado = 0" value='1' /></td>
                    <td><input type='text' name='campos[{{columna.name}}][label]' ng-model="columna.label_listado" ng-init="columna.label_listado = columna.name" /></td>
                    <td>{{columna.name}}</td>
                    <td><input type="checkbox" class="js-chk-ordenar-campo"  name='campos[{{columna.name}}][puede_ordenar]' value='1' ng-model="columna.ordenable" /></td>
                    <td><input type="radio" value="{{columna.name}}" name="ordenar_por" ng-checked="columna.primary_key === 1" /></td>
                </tr>

            </table>
        </div>

        <div class="form-group">
            <input type="submit" name="generar" class="btn btn-primary" value="Generar" >
        </div>
    </fieldset>
    <button type="button" class="btn btn-default" ng-click="FGCtrller.open()">Open me!</button>
    <button type="button" class="btn btn-default" ng-click="FGCtrller.open('lg')">Large modal</button>
    <button type="button" class="btn btn-default" ng-click="FGCtrller.open('sm')">Small modal</button>
    <script type="text/ng-template" id="myModalContent.html">
        <?php $this->load->view("/crud_generator/templates/config_select_fk", array("tablas" => $tablas)); ?>
    </script>
</form>

