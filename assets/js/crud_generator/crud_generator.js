$(function () {
    $('.js-tooltip').tooltip()
})
$(document).on("change.SeleccionTipoInput", ".js-select-tipo-campo", function (e) {
    var $row_columna = $(this).parents(".js-contenedor-columna");
    if ($(this).val() === "select_fk") {
        var config = new ConfigSelectFk($row_columna);
        config.init();
        config.mostrar_modal();
        //mostrar_modal_slt_fk($row_columna);
    }
    if ($(this).val() === "select") {
        var config = new ConfigSelect($row_columna);
        config.init();
        config.mostrar_modal();
        //mostrar_modal_slt($contenedor);
    }
    e.stopPropagation();
});

$(document).on("click.EditarConfig", ".js-edit-config", function (e) {
    e.preventDefault();
    var $row_columna = $(this).parents(".js-contenedor-columna");
    var tipo_campo = $row_columna.find(".js-select-tipo-campo").val();
    if (tipo_campo === "select_fk") {
//        mostrar_modal_slt_fk($row_columna);
        var config = new ConfigSelectFk($row_columna);
        config.init();
        config.mostrar_modal();
    }
    if (tipo_campo === "select") {
        var config = new ConfigSelect($row_columna);
        config.init();
        config.mostrar_modal();
        //mostrar_modal_slt($contenedor);
    }
    e.stopPropagation();
});

$(document).on("click.BorrarConfig", ".js-delete-config", function (e) {
    e.preventDefault();
    var $contenedor = $(this).parents(".js-contenedor-columna");
    var nombre_columna = $.trim($contenedor.find(".js-nombre-columna").html());
    $("#config_" + nombre_columna).val('');
    $("#config_mostrar_" + nombre_columna).html('');
    $(this).hide();
    $contenedor.find(".js-edit-config").hide();
    e.stopPropagation();
});

$(document).on("click.ToggleHabilitarJoin", ".js-toggle-habilitar-join", function (e) {
    e.preventDefault();
    var columna = $(this).data("columna");
    var $td_join = $("#td-join-" + columna)
    var $slt_join_tabla = $td_join.find(".js-slt-tabla-join");
    var $ipt_alias_tabla_join = $td_join.find(".js-ipt-alias-tabla-join");
    var estado_actual = $slt_join_tabla.prop("disabled");
    $slt_join_tabla.prop("disabled", !estado_actual);
    $slt_join_tabla.prop("disabled", !estado_actual);
    $ipt_alias_tabla_join.prop("disabled", !estado_actual);
})

function mostrar_modal_slt_fk($contenedor) {

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

