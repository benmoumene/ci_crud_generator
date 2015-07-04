<form action="/crud_generator/generar" method="POST" class="form form-horizontal">
    <fieldset>
        <div class="form-group">
            <label>Nombre Entidad (controlador)</label>
            <input class="form-control" type="text" name="entidad" value="<?php echo $this->input->get("tabla"); ?>" /><br/>
        </div>
        <div class="form-group">
            <label>Tabla</label>
            <input class="form-control" type="text" name="tabla" value="<?php echo $this->input->get("tabla"); ?>" readonly /><br/>
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
        <a href="javascript:void(0);" data-selector=".js-chk-generar-campo" class="js-select-all" >Seleccionar todo </a>
        <br>
        <div class="form-group">
            <table class="table table-hover table-striped table-bordered">
                <tr>
                    <th>&iquest;Generar?</th>
                    <th>Label</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Configuraciones</th>
                    <th>PK</th>
                </tr>
                <?php
                foreach ($columnas as $oColumna):
                    $columna = (array) $oColumna;
                    $es_pk = (int) $columna["primary_key"] === 1;
                    $tipo_input_default = $es_pk ? "hidden" : element($relacion_input_tipo_columna, $columna["type"]);
                    $destacar_tr = $es_pk ? " info " : "";
                    ?>
                    <tr class="js-contenedor-columna <?php echo $destacar_tr; ?>">
                        <td><input type="checkbox" class="js-chk-generar-campo" name='campos[<?php echo $columna["name"]; ?>][generar_input]' value='1' <?php echo $es_pk ? "checked readonly" : ""; ?> /></td>
                        <td><input type='text' name='campos[<?php echo $columna["name"]; ?>][label]' value='<?php echo $columna["name"]; ?>' /></td>
                        <td class="js-nombre-columna"><?php echo $columna["name"]; ?></td>
                        <td>
                            <select class="js-select-tipo-campo" name='campos[<?php echo $columna["name"]; ?>][tipo_campo]'>
                                <?php foreach ($inputs_disponibles as $value => $text): ?>
                                    <?php echo option($value, $text, $tipo_input_default); ?>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><code><textarea style="white-space: pre; font-family: monospace;" class="" name="campos[<?php echo $columna["name"]; ?>][config]" id="config_<?php echo $columna["name"]; ?>">&nbsp;</textarea></code></td>
                        <td><input type="radio" value="<?php echo $columna["name"]; ?>" name="pk" <?php echo $es_pk ? "checked" : ""; ?> /></td>
                    </tr>
                <?php endforeach; ?>
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
                    <th><a href="javascript:void(0);" data-selector=".js-chk-mostrar-campo" class="js-select-all" ><?php echo glyphicon("check"); ?></a>&iquest;Mostrar?</th>
                    <th>Label</th>
                    <th>Nombre</th>
                    <th><a href="javascript:void(0);" data-selector=".js-chk-ordenar-campo" class="js-select-all" ><?php echo glyphicon("check"); ?></a>&iquest;Puede ordenar?</th>
                    <th>Ordenado Por Default</th>
                </tr>
                <?php
                foreach ($columnas as $oColumna):
                    $columna = (array) $oColumna;
                    $es_pk = (int) $columna["primary_key"] === 1;
                    $destacar_tr = $es_pk ? "class='info'" : "";
                    ?>
                    <tr <?php echo $destacar_tr; ?>>
                        <td><input type="checkbox" class="js-chk-mostrar-campo" name='campos[<?php echo $columna["name"]; ?>][mostrar_listado]' value='1' /></td>
                        <td><input type='text' name='campos[<?php echo $columna["name"]; ?>][label]' value='<?php echo $columna["name"]; ?>' /></td>
                        <td><?php echo $columna["name"]; ?></td>
                        <td><input type="checkbox" class="js-chk-ordenar-campo"  name='campos[<?php echo $columna["name"]; ?>][puede_ordenar]' value='1' /></td>
                        <td><input type="radio" value="<?php echo $columna["name"]; ?>" name="ordenar_por" <?php echo $es_pk ? "checked" : ""; ?> /></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="form-group">
            <input type="submit" name="generar" class="btn btn-primary" value="Generar" >
        </div>
    </fieldset>
</form>
<?php $this->load->view("/crud_generator/templates/config_select_fk"); ?>