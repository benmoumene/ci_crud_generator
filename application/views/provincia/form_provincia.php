<form action="/provincia/guardar" method="POST">
    <div>
<input type='hidden' name='inputs[id_provincia]' value='<?php echo element($data,'id_provincia',0); ?>' />
</div>
<div>
<label>nombre:</label><br/>
<input type='text' name='inputs[nombre]' value='<?php echo element($data,'nombre',''); ?>' />
</div>
<div>
<label>orden:</label><br/>
<input type='number' name='inputs[orden]' value='<?php echo element($data,'orden',''); ?>' />
</div>
<div>
<label>activo:</label><br/>
<input type='text' name='inputs[activo]' value='<?php echo element($data,'activo',''); ?>' />
</div>

    <input type='submit' name='guardar' value='Guardar' />
</form>