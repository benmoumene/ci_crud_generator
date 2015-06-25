<form action="/ciudad/guardar" method="POST">
    <div>
<input type='hidden' name='inputs[id_ciudad]' value='<?php echo element($data,'id_ciudad',0); ?>' />
</div>
<div>
<label>id_provincia:</label><br/>
<input type='number' name='inputs[id_provincia]' value='<?php echo element($data,'id_provincia',''); ?>' />
</div>
<div>
<label>nombre:</label><br/>
<input type='text' name='inputs[nombre]' value='<?php echo element($data,'nombre',''); ?>' />
</div>
<div>
<label>cod_postal:</label><br/>
<input type='text' name='inputs[cod_postal]' value='<?php echo element($data,'cod_postal',''); ?>' />
</div>
<div>
<label>activo:</label><br/>
<input type='text' name='inputs[activo]' value='<?php echo element($data,'activo',''); ?>' />
</div>

    <input type='submit' name='guardar' value='Guardar' />
</form>