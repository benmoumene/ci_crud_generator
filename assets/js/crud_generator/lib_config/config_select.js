function ConfigSelect($row_columna) {
    this.$row_columna = $row_columna;
    this.$modal = null;
    this.$form_config = null;
    this.$div_contenedor_options = null;
    this.nombre_columna = '';
    this.options = [];
    this.init = function () {
        this.$modal = $("#modal-config-select");
        this.$form_config = $("#form-config-option");
        this.nombre_columna = $.trim(this.$row_columna.find(".js-nombre-columna").html());
        this.$div_contenedor_options = this.$modal.find("#contenedor-options-select");
        this.bind_events();
    };

    this.bind_events = function () {
        var that = this;
        this.$modal.one('hidden.bs.modal.configSelect', function () {
            that.reset_modal();
        });
        this.$modal.find(".js-btn-guardar-cambios").one("click.GuardarConfig", function (e) {
            var dataConfig = that.options;
            var beautified_dataArray = JSON.stringify(dataConfig);
            that.$row_columna.find("#config_mostrar_" + that.nombre_columna).html(ellipsis(beautified_dataArray));
            that.$row_columna.find("#config_" + that.nombre_columna).val(beautified_dataArray);
            that.$row_columna.find(".js-edit-config").show();
            that.$row_columna.find(".js-delete-config").show();
            that.$modal.modal('hide');
        });
        this.$modal.find("#btn-agregar-option")
                .off("click.AgregarOption")
                .on("click.AgregarOption", function (e) {
                    that._agregar_option(e);
                    e.stopPropagation();
                });
        this.$modal
                .off("click.EliminarOption")
                .on("click.EliminarOption", ".js-eliminar-option", function (e) {
                    e.preventDefault();
                    var index = $(this).data("index");
                    that.eliminar_option(index);
                    e.stopPropagation();
                });


    };
    this.eliminar_option = function (index) {
        this.options.splice(index, 1);
        this.$modal.find("#contenedor-option-" + index).remove();
    };
    this.render_options = function () {
        this.$div_contenedor_options.empty();
        if (this.options.length > 0) {
            this.options.sort(this._compare);
            var index;
            for (index in this.options) {
                var option = this.options[index];
                var tpl = this._get_option_tpl(index, option.value, option.text, option.selected);
                this.$div_contenedor_options.append(tpl);
            }
        }
    };
    this.reset_modal = function () {
        this.$form_config.find("#text_field").val('');
        this.$form_config.find("#value_field").val('');
        this.$form_config.find("#posicion").val('');
        this.$form_config.find("#selected").prop("checked", false);
        this.$div_contenedor_options.empty();
        this.options = [];
    };
    this.mostrar_modal = function () {
        this._cargar_data_guardada();
        this.render_options();
        this.$modal.modal();
    };
    this._cargar_data_guardada = function () {
        var dataConfig = this.$row_columna.find("#config_" + this.nombre_columna).val();
        if (dataConfig.length > 0) {
            var jsonDataConfig = JSON.parse(dataConfig);
            this.options = jsonDataConfig;
        }
    };
    this._get_option_tpl = function (index, value, text, selected) {
        var btn_borrar = '<a href="#" class="js-eliminar-option" data-index="' + index + '" ><span class="glyphicon glyphicon-trash"></span></a>';
        var html = '<div class="js-option-agregada option-agregada row" id="contenedor-option-' + index + '">\n\
                        <div class="col-md-12">\n\
                            <div class="col-sm-9 ' + (selected === true ? "option-selected" : "") + '">&lt;option value=<strong>"' + value + '"</strong> ' + (selected === true ? "<i>selected<i>" : "") + ' &gt; <strong>' + text + '</strong>&lt;option/&gt;</div>\n\
                            <div class="col-sm-3"> ' + btn_borrar + '</div>\n\
                        </div>\n\
                    </div>';
        return html;
    };
    this._compare = function (a, b) {
        if (a.posicion < b.posicion)
            return -1;
        else if (a.posicion > b.posicion)
            return 1;
        else
            return 0;
    };
    this._agregar_option = function (e) {
        var text_field = this.$form_config.find("#text_field").val();
        var value_field = this.$form_config.find("#value_field").val();
        var posicion = this.$form_config.find("#posicion").val();
        var selected = this.$form_config.find("#selected").prop("checked");

        var option = {
            'value': value_field,
            'text': text_field,
            'posicion': posicion,
            'selected': selected,
        };
        this.options.push(option);
        this.render_options();
        e.stopPropagation();
    };
}