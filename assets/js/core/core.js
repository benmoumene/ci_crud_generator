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

