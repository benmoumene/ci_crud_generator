$(document).on("change.SeleccionTipoInput", ".js-select-tipo-campo", function (e) {
    var $this = $(this);
    var $contenedor = $(this).parents(".js-contenedor-columna");
    if ($this.val() === "select_fk") {
        var $modal = $("#modal-config-select-fk");
        var $columna = $.trim($contenedor.find(".js-nombre-columna").html());
        $modal.find("#btn-guardar-cambios").on("click.GuardarConfig", function () {
            var dataFormArray = $("#form-config-select-fk").serializeArray();
            var dataConfig = {};
            $.each(dataFormArray, function () {
                dataConfig[this.name] = this.value;
            });
            var beautified_dataArray = JSON.stringify(dataConfig);
            $("#config_mostrar_" + $columna).html(ellipsis(beautified_dataArray));
            $("#config_" + $columna).val(beautified_dataArray);
            $contenedor.find(".js-edit-config").show();
            $contenedor.find(".js-delete-config").show();
            $modal.modal('hide');
        });
        $modal.modal();
    }
});

$(document).on("click.EditarConfig", ".js-edit-config", function (e) {
    e.preventDefault();
    var $this = $(this);
    var tipo_campo = $this.data("tipo-campo");

    var $contenedor = $(this).parents(".js-contenedor-columna");
    var $columna = $.trim($contenedor.find(".js-nombre-columna").html());
    var dataConfig = $contenedor.find("#config_" + $columna).html();
    console.log(dataConfig);
    console.info(JSON.parse(dataConfig));
    if (tipo_campo === "select_fk") {
        var $modal = $("#modal-config-select-fk");
    }
    $modal.modal();
});
