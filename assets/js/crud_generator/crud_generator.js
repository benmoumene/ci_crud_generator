$(document).on("change.SeleccionTipoInput", ".js-select-tipo-campo", function (e) {
    if ($(this).val() === "select_fk") {
        var $contenedor = $(this).parents(".js-contenedor-columna");
        mostrar_modal($contenedor);
    }

});

$(document).on("click.EditarConfig", ".js-edit-config", function (e) {
    e.preventDefault();
    var $contenedor = $(this).parents(".js-contenedor-columna");
    mostrar_modal($contenedor);
});

$(document).on("click.BorrarConfig", ".js-delete-config", function (e) {
    e.preventDefault();
    var $contenedor = $(this).parents(".js-contenedor-columna");
    var nombre_columna = $.trim($contenedor.find(".js-nombre-columna").html());
    $("#config_" + nombre_columna).val('');
    $("#config_mostrar_" + nombre_columna).html('');
    $(this).hide();
    $contenedor.find(".js-edit-config").hide();

});


$(document).on('change.CambiarTablaFk', "#table_fk", function (e) {
    var tabla = $(this).val();
    if (typeof (tabla) !== "undefined" && tabla !== "") {
        cargar_columnas_tabla_fk(tabla);
    }
})
function mostrar_modal($contenedor) {

    cargar_data_select_fk($contenedor);
    var $modal = $("#modal-config-select-fk");
    var $form_config = $("#form-config-select-fk");
    var nombre_columna = $.trim($contenedor.find(".js-nombre-columna").html());
    $modal.find("#btn-guardar-cambios").one("click.GuardarConfig", function () {
        var dataFormArray = $form_config.serializeArray();
        var dataConfig = {};
        $.each(dataFormArray, function () {
            dataConfig[this.name] = this.value;
        });
        var beautified_dataArray = JSON.stringify(dataConfig);
        $("#config_mostrar_" + nombre_columna).html(ellipsis(beautified_dataArray));
        $("#config_" + nombre_columna).val(beautified_dataArray);
        $contenedor.find(".js-edit-config").show();
        $contenedor.find(".js-delete-config").show();
        $form_config[0].reset();
        $modal.modal('hide');
    });
    $modal.modal();
    $modal.on('hidden.bs.modal', function () {
        $form_config[0].reset();
    });

}

function cargar_data_select_fk($contenedor) {
    var nombre_columna = $.trim($contenedor.find(".js-nombre-columna").html());
    var dataConfig = $contenedor.find("#config_" + nombre_columna).val();
    if (dataConfig.length > 0) {
        var jsonDataConfig = JSON.parse(dataConfig);
        for (var id_elemento in jsonDataConfig) {
            var value = jsonDataConfig[id_elemento];
            $("#" + id_elemento).val(value);
        }
    } else {
        $("#value_field").empty();
        $("#text_field").empty();
    }

}

function cargar_columnas_tabla_fk(tabla) {
    var tabla_fk = tabla;
    $.ajax({
        url: '/crud_generator/ajax_get_columnas_tabla',
        type: 'POST',
        dataType: 'json',
        data: {
            'tabla': tabla_fk
        },
        success: function (rta) {
            fill_select('#value_field', rta.columnas);
            fill_select('#text_field', rta.columnas);
        }
    });
}