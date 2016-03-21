$(document).on("change.SeleccionTipoInput", ".js-select-tipo-campo", function (e) {
    var $contenedor = $(this).parents(".js-contenedor-columna");
    if ($(this).val() === "select_fk") {
        mostrar_modal_slt_fk($contenedor);
    }
    if ($(this).val() === "select") {
        mostrar_modal_slt($contenedor);
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
});

function mostrar_modal_slt($contenedor) {
    var $modal = $("#modal-config-select");
    var $form_config = $("#form-config-option");
    var $div_contenedor_options = $modal.find("#contenedor-options-select");
    var nombre_columna = $.trim($contenedor.find(".js-nombre-columna").html());
    var options = [];
    var compare = function (a, b) {
        if (a.posicion < b.posicion)
            return -1;
        else if (a.posicion > b.posicion)
            return 1;
        else
            return 0;
    };
    var render_options = function () {
        options.sort(compare);
        $div_contenedor_options.empty();
        var index;
        for (index in options) {
            var option = options[index];
            var tpl = get_option_tpl(option.value, option.text, option.selected);
            $div_contenedor_options.append(tpl);
        }
    };
    var get_option_tpl = function (value, text, selected) {
        var btn_editar = '<a href="">Editar</a>';
        var btn_borrar = '<a href="">Borrar</a>';
        var html = '<div> Value: ' + value + ' , Text:' + text + ', selected: ' + selected + btn_editar + btn_borrar + ' </div>';
        return html;
    }
    $modal.find("#btn-agregar-option").on("click.AgregarOption", function (e) {
        var text_field = $form_config.find("#text_field").val();
        var value_field = $form_config.find("#value_field").val();
        var posicion = $form_config.find("#posicion").val();
        var selected = $form_config.find("#selected").val();

        var option = {'value': value_field, 'text': text_field, 'posicion': posicion, 'selected': selected === 1};
        options.push(option);
        render_options()
    });
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