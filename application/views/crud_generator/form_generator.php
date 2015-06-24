<?php
$tipos = array(
    "textarea" => "Textarea",
    "number" => "input-number",
    "text" => "input-text",
    "email" => "input-email",
    "hidden" => "input-hidden",
    "checkbox" => "checkbox",
    "select" => "select"
);
$tipos_campo = array("text" => "textarea", "varchar" => "text", "int" => "number", "char" => "text");
?>

<form action="/crud_generator/generar" method="POST">
    <label>Nombre Entidad</label>
    <input type="text" name="entidad" value="<?php echo $this->input->get("tabla"); ?>" /><br/>
    <label>Tabla</label>
    <input type="text" name="tabla" value="<?php echo $this->input->get("tabla"); ?>" readonly /><br/>

    <hr>
    <h3>Form</h3>
    <table border='1'>
        <tr>
            <td>Generar?</td>
            <td>Nombre</td>
            <td>Tipo</td>
            <td>PK</td>
            <td>Ordenar Por (default)</td>
        </tr>
        <?php
        foreach ($columnas as $oColumna):
            $columna = (array) $oColumna;
            $es_pk = (int) $columna["primary_key"] === 1;
            $field_type = $es_pk ? "hidden" : $tipos_campo[$columna["type"]];
            ?>
            <tr>
                <td><input type="checkbox" name='campos[<?php echo $columna["name"]; ?>][generar_input]' value='1' <?php echo $es_pk ? "checked readonly" : ""; ?> /></td>
                <td><?php echo $columna["name"]; ?></td>
                <td>
                    <select name='campos[<?php echo $columna["name"]; ?>][tipo_campo]'>
                        <?php foreach ($tipos as $value => $text): ?>
                            <?php echo option($value, $text, $field_type); ?>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="radio" value="<?php echo $columna["name"]; ?>" name="pk" <?php echo (int) $columna["primary_key"] === 1 ? "checked" : ""; ?> /></td>

            </tr>
        <?php endforeach; ?>
    </table>
    <hr>
    <h3>Listado</h3>
    <label>Ordenar por default en sentido:</label>
    <select name='en_sentido'>
        <option value='desc' selected>DESC</option>
        <option value='asc'>ASC</option>
    </select>
    <br />
    <br />
    <table border='1'>
        <tr>
            <td>Mostrar?</td>
            <td>Puede ordenar?</td>
            <td>Nombre</td>
            <td>Ordenar Por Default</td>
        </tr>
        <?php
        foreach ($columnas as $oColumna):
            $columna = (array) $oColumna;
            $es_pk = (int) $columna["primary_key"] === 1;
            $field_type = $es_pk ? "hidden" : $tipos_campo[$columna["type"]];
            ?>
            <tr>
                <td><input type="checkbox" name='campos[<?php echo $columna["name"]; ?>][mostrar_listado]' value='1' /></td>
                <td><input type="checkbox" name='campos[<?php echo $columna["name"]; ?>][puede_ordenar]' value='1' /></td>
                <td><?php echo $columna["name"]; ?></td>
                <td><input type="radio" value="<?php echo $columna["name"]; ?>" name="ordenar_por" <?php echo (int) $columna["primary_key"] === 1 ? "checked" : ""; ?> /></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <input type="submit" name="generar" value="Generar" >
</form>
