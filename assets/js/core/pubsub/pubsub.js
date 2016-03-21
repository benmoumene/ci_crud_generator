/*
 * Patr�n pub sub implementado para poder llamar m�s de un callback en el parent
 * desde un dialog (iframe)
 * @example

 * Ejemplo implementado en suplemento_edit.js (parent), documentos_seleccionados.js (parent), documento_search.js (child)
 * En los parents, debe suscribirse s�lo una vez (subscribeOnce) dado que sino al levantar el dialog nuevamente �ste se cierre
 * el evento se ejecutar� nuevamente.
 * Adem�s debe suscribirse s�lo en el evento click del bot�n que abre el Dialog. Si se suscribe al cargarse el archivo, cada vez que se cierre
 * el Dialog (aunque haya sido disparado por otro bot�n) se ejecutar� el c�digo definido.
 *
 *   En suplemento_edit.js:
 *           $.subscribeOnce('documento/select', function(e, documentoInfo) {
 *           //c�digo
 });
 En documentos_seleccionados.js:
 *           $.subscribeOnce('documento/select', function(e, documentoInfo) {
 *           //c�digo
 });
 * En el dialog o ventana child:
 * window.parent.$.publish('documento/select', documentoInfo);

 *
 * Author: Kurtis Kemple
 * Email:  kkemple@pixafy.com
 * Date:   02-10-2013 (MM/DD/YYYY)
 *
 * Documentaci�n: http://www.pixafy.com/blog/2013/02/pubsub-with-jquery/
 * C�digo Ejemplo: http://jsbin.com/uxakut/2/edit
 */
//protect our jQuery from conflicts by aliasing it with the $ symbol
//cache the window and document objects
;
(function($, window, document) {
    "use strict";

    //call our pubsub function so it is available immediately
    initPubSub();

    function initPubSub() {

        //create our instance of jQuery
        var o = $({});

        //link our jquery functions to our sudo function names
        $.each({
            //associate our keys and values to iterate through
            trigger: 'publish',
            on: 'subscribe',
            one: 'subscribeOnce',
            off: 'unsubscribe'

        }, function(key, val) {

            //attach our new function to the jQuery object using the array notation
            $[val] = function() {

                //when new function is called, call original function and pass any arguments along
                o[key].apply(o, arguments);

            };

        });

    }

//undefined passed in but not assigned to retain a true "undefined"
})(jQuery, window, document, undefined);