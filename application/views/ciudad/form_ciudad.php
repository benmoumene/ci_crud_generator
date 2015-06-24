<form action="/ciudad/guardar" method="POST">
    <div>
<input type='hidden' name='inputs[id_ciudad]' value='<?php echo get_value($data,'id_ciudad',0); ?>' />
</div>

    <input type='submit' name='guardar' value='Guardar' />
</form>