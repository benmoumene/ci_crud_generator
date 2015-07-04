$(document).on("click.ToggleSelectAll", ".js-select-all", function (e) {
    e.preventDefault();
    var selector = $(this).data("selector");
    select_all(selector);
});