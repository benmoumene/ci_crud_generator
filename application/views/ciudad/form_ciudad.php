<div class="col-md-5">
    <form action="/ciudad/guardar" method="POST" class="form-vertical">
        <div class='form-group'>
<input type='hidden' class='form-control' name='inputs[id_ciudad]' value='<?php echo element($data,'id_ciudad',''); ?>' id='id_ciudad'  />
</div>
<div class='form-group'>
<label>id_provincia:</label><br/>
<?php 
$config_id_provincia = array(
'table' => 'provincia',
'value_field' => 'id_provincia',
'text_field' => 'nombre',
'where' => 'activo = "S"',
);
$rows = options_select_fk($config_id_provincia);
?>

<select name='inputs[id_provincia]' id=''>
<?php 
echo option(0,'Seleccione...',element($data, 'id_provincia', 0));
foreach($rows as $row) { 
     echo option($row['value'],$row['text'],element($data, 'id_provincia', 0));
} ?> 
</select>

</div>
<div class='form-group'>
<label>nombre:</label><br/>
<input type='text' class='form-control' name='inputs[nombre]' value='<?php echo element($data,'nombre',''); ?>' id='nombre'  />
</div>
<div class='form-group'>
<label>cod_postal:</label><br/>
<input type='text' class='form-control' name='inputs[cod_postal]' value='<?php echo element($data,'cod_postal',''); ?>' id='cod_postal'  />
</div>
<div class='form-group'>
<label>activo:</label><br/>
<input type='text' class='form-control' name='inputs[activo]' value='<?php echo element($data,'activo',''); ?>' id='activo'  />
</div>

        <div class="form-group text-center">
            <input type='submit' class="btn btn-primary" name='guardar' value='Guardar' />
        </div>
    </form>
</div>