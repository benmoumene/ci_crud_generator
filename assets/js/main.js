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