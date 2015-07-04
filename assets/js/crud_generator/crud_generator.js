$(document).on("change.SeleccionTipoInput", ".js-select-tipo-campo", function (e) {
    var $this = $(this);
    var $contenedor = $(this).parents(".js-contenedor-columna");
    if ($this.val() === "select_fk") {
        var $modal = $("#modal-config-select-fk");
        var $columna = $.trim($contenedor.find(".js-nombre-columna").html());
        $modal.find("#btn-guardar-cambios").on("click.GuardarConfig", function () {
            var data = $("#form-config-select-fk").serializeArray();
            var beautified_data = JSON.stringify(data, null, 2);
            $("#config_" + $columna).val(beautified_data).show();
            $modal.modal('hide');
        });
        $modal.modal();
    }
});