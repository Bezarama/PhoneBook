$(function () {
    $('[data-toggle="tooltip"]').tooltip();
})

$(function () {

    if (jQuery.fn.inputmask) {
        // let mask = "+7 (999) 999-99-99"; //РФ
        $('[data-mask]').inputmask({
            // mask: [mask],
            keepStatic: true
        });
    }

});
