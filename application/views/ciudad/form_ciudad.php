<form action="/ciudad/guardar" method="POST">
    <div>
<input type='hidden' name='id_ciudad' value='<?php echo element($data,'id_ciudad',''); ?>' id='id_ciudad'  />
</div>
<div>
<label>provincia:</label><br/>
<input type='number' name='id_provincia' value='<?php echo element($data,'id_provincia',''); ?>' id='id_provincia'  />
</div>
<div>
<label>nombre:</label><br/>
<input type='email' name='nombre' value='<?php echo element($data,'nombre',''); ?>' id='nombre'  />
</div>
<div>
<label>cod postal:</label><br/>
<textarea name='cod_postal' id=''><?php echo element($data, 'cod_postal', ''); ?></textarea>
</div>
<div>
<label>activo:</label><br/>
<input type='checkbox' name='activo' value='<?php echo element($data,'activo',''); ?>' id='activo'  />
</div>

    <input type='submit' name='guardar' value='Guardar' />
</form>