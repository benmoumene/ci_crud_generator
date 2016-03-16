<div class="col-md-5">
    <a href="/{nombre_controlador}/listar" class="btn btn-default pull-right">Volver al listado</a>
    <form action="/{nombre_controlador}/guardar" method="POST" class="form-vertical">
        {inputs_form}
        <div class="form-group text-center">
            <input type='reset' class="btn btn-default pull-left" name='guardar' value='Cancelar' />
            <input type='submit' class="btn btn-primary" name='guardar_volver' value='Guardar y volver' />
            <input type='submit' class="btn btn-success pull-right" name='guardar' value='Guardar' />

        </div>
    </form>
</div>