jQuery(document).ready(function ($) {


    $(document).on('click', '.shipping_method', trigget_checkout);

    trigget_checkout();

    function trigget_checkout() {

        jQuery(document.body).trigger('update_checkout');

        jQuery('body').trigger('update_checkout');
        $(document.body).trigger('updated_shipping_method');

    }

});