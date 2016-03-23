$(document).on("change.SeleccionTipoInput", ".js-select-tipo-campo", function (e) {
    var $row_columna = $(this).parents(".js-contenedor-columna");
    if ($(this).val() === "select_fk") {
        mostrar_modal_slt_fk($row_columna);
    }
    if ($(this).val() === "select") {
        console.info('disparado');
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
        mostrar_modal_slt_fk($row_columna);
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


$(document).on('change.CambiarTablaFk', "#table_fk", function (e) {
    var tabla = $(this).val();
    if (typeof (tabla) !== "undefined" && tabla !== "") {
        cargar_columnas_tabla_fk(tabla);
    }
});

/**
 function mostrar_modal_slt($contenedor) {
 var $modal = $("#modal-config-select");
 var $form_config = $("#form-config-option");
 var $div_contenedor_options = $modal.find("#contenedor-options-select");
 var nombre_columna = $.trim($contenedor.find(".js-nombre-columna").html());
 var options = [];
 var cargar_data_guardada = function () {
 var dataConfig = $contenedor.find("#config_" + nombre_columna).val();
 if (dataConfig.length > 0) {
 console.info(dataConfig);
 var jsonDataConfig = JSON.parse(dataConfig);
 options = jsonDataConfig;
 console.log(options);
 }
 }
 var compare = function (a, b) {
 if (a.posicion < b.posicion)
 return -1;
 else if (a.posicion > b.posicion)
 return 1;
 else
 return 0;
 };
 var eliminar_option = function (index) {
 console.table(options);
 options.splice(index, 1);
 console.table(options);
 $("#contenedor-option-" + index).remove();
 }
 var render_options = function () {
 $div_contenedor_options.empty();
 if (options.length > 0) {
 options.sort(compare);
 var index;
 for (index in options) {
 var option = options[index];
 var tpl = get_option_tpl(index, option.value, option.text, option.selected);
 $div_contenedor_options.append(tpl);
 }
 }
 };
 var get_option_tpl = function (index, value, text, selected) {
 var btn_borrar = '<a href="#" class="js-eliminar-option" data-index="' + index + '" ><span class="glyphicon glyphicon-trash"></span></a>';
 var html = '<div class="js-option-agregada option-agregada row" id="contenedor-option-' + index + '">\n\
 <div class="col-md-12">\n\
 <div class="col-sm-9">&lt;option value=<strong>"' + value + '"</strong> &gt; <strong>' + text + '</strong> ' + (selected ? "selected" : "") + '&lt;option/&gt;</div>\n\
 <div class="col-sm-3"> ' + btn_borrar + '</div>\n\
 </div>\n\
 </div>';
 return html;
 }
 var reset_modal = function () {
 $form_config.find("#text_field").val('');
 $form_config.find("#value_field").val('');
 $form_config.find("#posicion").val('');
 $form_config.find("#selected").prop("checked", false);
 $div_contenedor_options.empty();
 options = [];
 };
 cargar_data_guardada();
 render_options();
 $modal.on("click.EliminarOption", ".js-eliminar-option", function () {
 var index = $(this).data("index");
 eliminar_option(index);
 });
 $modal.find("#btn-agregar-option").on("click.AgregarOption", function (e) {
 var text_field = $form_config.find("#text_field").val();
 var value_field = $form_config.find("#value_field").val();
 var posicion = $form_config.find("#posicion").val();
 var selected = $form_config.find("#selected").val();

 var option = {'value': value_field, 'text': text_field, 'posicion': posicion, 'selected': selected === 1};
 options.push(option);
 render_options()
 });
 $modal.find(".js-btn-guardar-cambios").one("click.GuardarConfig", function () {
 var dataConfig = options;
 var beautified_dataArray = JSON.stringify(dataConfig);
 $("#config_mostrar_" + nombre_columna).html(ellipsis(beautified_dataArray));
 $("#config_" + nombre_columna).val(beautified_dataArray);
 $contenedor.find(".js-edit-config").show();
 $contenedor.find(".js-delete-config").show();
 reset_modal();
 $modal.modal('hide');
 });
 $modal.modal();
 $modal.on('hidden.bs.modal', reset_modal);

 }
 */

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