window.$ = window.jQuery = require('jquery');
require('bootstrap');
require('datatables.net-bs4');
require('datatables.net-buttons-bs4');
window.coreui = require("@coreui/coreui");

// Select2
$(document).ready(function () {
    $.fn.modal.Constructor.prototype.enforceFocus = function () { };

    $('.select2').select2({
        theme: "bootstrap"
    });
});

// auto close alert
// .alert-auto-hide
$(document).ready(function () {
    window.setTimeout(function () {
        $(".alert-auto-hide").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 3000);

    // Auto Focus select2
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
});    