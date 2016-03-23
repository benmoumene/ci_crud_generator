function ConfigSelectFk($row_columna) {
    this.$row_columna = $row_columna;
    this.$modal = null;
    this.$form_config = null;
    this.$div_contenedor_options = null;
    this.nombre_columna = '';
    this.init = function () {
        this.$modal = $("#modal-config-select-fk");
        this.$form_config = $("#form-config-select-fk");
        this.nombre_columna = $.trim(this.$row_columna.find(".js-nombre-columna").html());
        this.bind_events();
    };

    this.bind_events = function () {
        var that = this;
        this.$modal.one('hidden.bs.modal.configSelectFk', function () {
            that.reset_modal();
        });
        this.$modal.find("#btn-guardar-cambios").one("click.GuardarConfig", function () {
            var dataFormArray = that.$form_config.serializeArray();
            var dataConfig = {};
            $.each(dataFormArray, function () {
                dataConfig[this.name] = this.value;
            });
            var beautified_dataArray = JSON.stringify(dataConfig);
            that.$row_columna.find("#config_mostrar_" + that.nombre_columna).html(ellipsis(beautified_dataArray));
            that.$row_columna.find("#config_" + that.nombre_columna).val(beautified_dataArray);
            that.$row_columna.find(".js-edit-config").show();
            that.$row_columna.find(".js-delete-config").show();
            that.$modal.modal('hide');
        });
        this.$modal.find("#table_fk").one("change.CambiarTablaFk", function () {
            var tabla = $(this).val();
            if (typeof (tabla) !== "undefined" && tabla !== "") {
                that._cargar_columnas_tabla_fk(tabla);
            }
        });
    };

    this.mostrar_modal = function () {
        this._cargar_data_guardada();
        this.$modal.modal();
    };

    this.reset_modal = function () {
        $("#value_field").empty();
        $("#text_field").empty();
        this.$form_config[0].reset();
    };
    this._cargar_columnas_tabla_fk = function (tabla) {
        var tabla_fk = tabla;
        $.ajax({
            url: '/crud_generator/ajax_get_columnas_tabla',
            type: 'POST',
            dataType: 'json',
            async: false,
            data: {
                'tabla': tabla_fk
            },
            success: function (rta) {
                if (rta.columnas.length > 0) {
                    fill_select('#value_field', rta.columnas);
                    fill_select('#text_field', rta.columnas);
                }
            }
        });
    }
    this._cargar_data_guardada = function () {
        var dataConfig = this.$row_columna.find("#config_" + this.nombre_columna).val();
        if (dataConfig.length > 0) {
            var jsonDataConfig = JSON.parse(dataConfig);
            //console.log(jsonDataConfig["table_fk"]);
            this._cargar_columnas_tabla_fk(jsonDataConfig["table_fk"]);
            for (var id_elemento in jsonDataConfig) {
                var value = jsonDataConfig[id_elemento];
                this.$form_config.find("#" + id_elemento).val(value);
            }

        }
    };
}