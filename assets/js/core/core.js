;
(function ($, window, document) {
    $(document).ready(function () {
        var $body = $("body");
//        $body.find("[data-plugins]").each(function (element) {
//            var plugins = eval($(this).data("plugins"));
//            for (var index in plugins) {
//                var plugin = plugins[index];
//                console.info(plugin);
//                var b = using(plugin);
//                console.log(b);
//            }
//        });
        $body.find("[data-jsfiles]").each(function (element) {
            var files = eval($(this).data("jsfiles"));
            //console.log(files);
            //var $head = $("#script_container");
            var $head = document.getElementsByTagName("head")[0];
            for (var index in files) {
                //console.log(files[index]);
                var script = document.createElement("script");
                script.src = "/assets/js/" + files[index];
                // Use any selector
                $head.appendChild(script);
            }
        });
    });

})(jQuery, window, document);


/**
 * Rellena un select con options
 * @param {string} El id del select que hay que llenar
 * @param {array} data
 * @returns {void}
 */
function fill_select(selectorSelect, data) {
    //console.log(typeof id_select);
    var select = $(selectorSelect);
    select.empty();
    if (data.length > 0) {
        for (var index in data) {
            var opt = data[index];
            select.append('<option value="' + opt.value + '">' + opt.text + '</option>')
        }
    }
}

/**
 * Aplica la funcionalidad de "seleccionar/deseleccionar todo" a un link
 * @param {string} selector El selector jQuery de los checkbox que se van a checkear/descheckear
 * @returns {void}
 */
function select_all(selector) {
    $(selector).each(function (e) {
        var checkBoxes = $(selector);
        checkBoxes.prop("checked", !checkBoxes.prop("checked"));
    })
}


function ellipsis(string, max_caracteres) {
    if (typeof (max_caracteres) === "undefined" || max_caracteres * 1 === 0) {
        max_caracteres = 50;
    }
    if (string.length > max_caracteres)
        return string.substring(0, max_caracteres) + '...';
    else
        return string;
}