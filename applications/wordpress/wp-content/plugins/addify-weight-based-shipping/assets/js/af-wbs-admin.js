var show_shipping_methods_with_shipping_zone = php_var.show_shipping_methods_with_shipping_zone;

jQuery(document).ready(function ($) {


    $(document).on('click', '.af-wbs-remove-group-btn', function (event) {
        event.preventDefault();
        let remove_class = $(this).data('remove_class');
        $(this).closest('.' + remove_class).remove();
        afwbs_pricing_table();
        and_or_icon_show_hide();

    });
    afwbs_pricing_table();
    function afwbs_pricing_table() {
        if ($('.afwbs-pricing-table tbody').find('tr').length) {
            $('.afwbs-pricing-table').show();
            $('#af-wbs-tabs').show();

        } else {
            $('.afwbs-pricing-table').hide();
            $('#af-wbs-tabs').hide();

        }
    }

    and_or_icon_show_hide();

    function and_or_icon_show_hide() {

        $('.af-wbs-div-conditions-group').each(function () {

            if (!$(this).nextAll('.af-wbs-div-conditions-group').length) {
                $(this).find('.af-wbs-group-seperator').hide();
            } else {
                $(this).find('.af-wbs-group-seperator').show();
            }

            $(this).find('.af-wbs-condition-wrap').each(function () {

                if (!$(this).nextAll('.af-wbs-condition-wrap').length) {
                    $(this).find('fieldset.and').hide();
                } else {
                    $(this).find('fieldset.and').show();
                }

            });
        });

    }
    if (jQuery('.wc-shipping-zone-method-rows').length) {

        for (let index = 0; index < 10; index++) {

            setTimeout(function () {

                // remove_class_from_edit_link();


            }, index * 1000);
        }

    }
    function remove_class_from_edit_link() {

        jQuery('a.wc-shipping-zone-method-settings').each(function () {

            if (jQuery(this).hasClass('wc-shipping-zone-method-settings')) {

                jQuery(this).removeClass('wc-shipping-zone-method-settings');
            }

        });
    }
    $(document).on('click', '.button-af-wbs-add-group', function (event) {
        event.preventDefault();

        let abs_number = $('.abs-number').length + 1;
        let new_group = php_var.new_group;

        new_group = new_group.replace('abs_number', abs_number);

        let set_group_id = $('.af-wbs-div-conditions-group').length + 1;

        new_html = af_wbs_repalce_place_holder(new_group, 1, set_group_id);

        $('.af-wbs-div-conditions-wrapper').append(new_html);
        af_wbs_live_search();
        af_wbs_condition_type_select(set_group_id, 1);
        and_or_icon_show_hide();

    });

    function af_wbs_repalce_place_holder(html = '', set_condition_id = 1, set_group_id = 1) {


        if (!html) {
            return html;
        }
        html = html.replace(/set_condition_id/g, set_condition_id);
        html = html.replace(/set_group_id/g, set_group_id);

        html = html.replace(/{{set_group_id}}/g, set_group_id);
        html = html.replace(/{{set_condition_id}}/g, set_condition_id);
        // console.log(html);
        return html;
    }

    $(document).on('click', '.af-wbs-add-group-condition', function (event) {
        event.preventDefault();

        var set_group_id = $(this).data('group_id');
        var set_condition_id = $(this).closest('.af-wbs-div-conditions-group').find('.af-wbs-condition-wrap').last().data('condition_id') ? parseInt($(this).closest('.af-wbs-div-conditions-group').find('.af-wbs-condition-wrap').last().data('condition_id')) + 1 : 1;

        let new_html = php_var.new_condition;

        new_html = af_wbs_repalce_place_holder(new_html, set_condition_id, set_group_id);


        $(this).closest('.af-wbs-div-conditions-group').find('.af-wbs-conditions-wrap').append(new_html);

        for (let index = 1; index < 5; index++) {


            setTimeout(() => {
                af_wbs_condition_type_select(set_condition_id, set_group_id);

            }, 1000 * index);

        }

        af_wbs_live_search();
        // af_wbs_condition_type_select();
        and_or_icon_show_hide();

    });

    function af_wbs_condition_type_select(conditionId = "", groupId = "") {

        $('.af-wbs-condition-wrap').each(function () {

            let condition_id = $(this).data('condition_id');
            let group_id = $(this).data('group_id');

            if (conditionId == condition_id && group_id == groupId) {
                let group_id = $(this).data('group_id');

                let selected_option = $(this).find('.af-wbs-condition-type-select option:selected');

                let option_value = selected_option.val();

                // console.log('option_value => ' + option_value);

                let field_type = selected_option.data('field_type');
                let disabled = selected_option.data('disabled');

                // console.log('field_type => ' + field_type);

                let select_field_type = selected_option.data('select_field_type');

                // console.log('select_field_type => ' + select_field_type);

                let search_type = $(this).find('.af-wbs-condition-value').data('search_type');

                // console.log('search_type => ' + search_type);

                // console.log(field_type + '=====' + search_type);

                if (select_field_type != search_type) {
                    // console.log('not equal');

                    let new_html = php_var[select_field_type];

                    // console.log(select_field_type);
                    // console.log(new_html);
                    // console.log(php_var);

                    new_html = af_wbs_repalce_place_holder(new_html, condition_id, group_id);

                    $(this).find('.af-wbs-condition-div').html(new_html);

                }
                af_wbs_condition_operator(conditionId, groupId);
                af_wbs_live_search();
                and_or_icon_show_hide();
            }


        });
    }

    let af_wbs_all_operator = php_var.af_wbs_all_operator;

    for (let index = 1; index < 5; index++) {

        setTimeout(function () {
            $('.af-wbs-condition-wrap').each(function () {
                af_wbs_condition_operator($(this).data('condition_id'), $(this).data('group_id'));

            });
        }, 1000 * index);


    }

    function af_wbs_condition_operator(conditionId = '', groupId = '') {
        $('.af-wbs-condition-wrap').each(function () {

            var condition_id = $(this).data('condition_id');
            var group_id = $(this).data('group_id');



            if (condition_id == conditionId && group_id == groupId) {

                let operator = $(this).find('.af-wbs-condition-operator').data('operator');
                let selected_option = $(this).find('.af-wbs-condition-type-select option:selected');
                let disabled = selected_option.data('disabled');

                disabled = disabled.split(',');

                let current_div = $(this);
                current_div.find('.af-wbs-condition-operator-select option').each(function () {

                    $(this).remove();
                });

                $.each(af_wbs_all_operator, function (index, value) {

                    if (jQuery.inArray(index, disabled) === -1) {

                        let selected_or_not = operator == index ? 'selected' : '';
                        current_div.find('select.af-wbs-condition-operator-select').append('<option value="' + index + '" ' + selected_or_not + '>' + value + '</option>');

                    }

                });
            }


        });
    }

    jQuery(document).on('change', '.af-wbs-condition-type-select', function () {
        condition_id = $(this).data('condition_id');
        group_id = $(this).data('group_id');

        af_wbs_condition_type_select(condition_id, group_id);
    });


    $(document).on('click', '.af-wbs-tabs ul li.af-wbs-pricing-li', function (event) {
        event.preventDefault();
        $('.af-wbs-tabs ul li').removeClass('ui-tab ui-tabs-active ui-state-active');
        $(this).addClass('ui-tab ui-tabs-active ui-state-active');
        shipping_prices();
    });
    $(document).on('click', '.af-wbs-publish-draft-post', function (event) {
        event.preventDefault();

        let current_a_tag = $(this);

        if ($(this).data('set_status') && $(this).closest('tr').data('post_id')) {

            jQuery.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'af_wbs_update_post_status',
                    post_id: $(this).closest('tr').data('post_id'),
                    set_status: $(this).data('set_status'),
                    nonce: php_var.nonce,
                },
                success: function (response) {

                    if (response.data['success']) {

                        // if (response.data['new_tr']) {

                        //     jQuery('.af-wbs-custom-shipping').remove();

                        //     let show_shipping_methods_with_shipping_zone = response.data['new_tr'];

                        //     append_shipping_methods_with_shipping_zone();

                        // } else {
                        window.location.reload(true);
                        // }
                    }

                }
            });

        }
    });
    shipping_prices();
    function shipping_prices() {
        let active_div = $('.af-wbs-tabs ul li.ui-state-active').data('additional_class');
        if (active_div) {

            $('.af-wbs-tabs-content').hide();
            $('#' + active_div).show();
        }
    }
    // $(document).on('click', '.af-wbs-add-new-price-conditions', function () {
    //     let array_key = $(this).closest('div.af-wbs-tabs-content').attr('id');

    //     if (php_var[array_key]) {

    //         let new_html = php_var[array_key];

    //         let set_condition_id = $(this).closest('div.af-wbs-tabs-content').find('table tbody tr').last().data('condition_id') ? parseInt($(this).closest('div.af-wbs-tabs-content').find('table tbody tr').last().data('condition_id')) + 1 : 1;

    //         new_html = af_wbs_repalce_place_holder(new_html, set_condition_id);

    //         $(this).closest('div.af-wbs-tabs-content').find('table tbody').append(new_html);

    //     }
    //     afwbs_pricing_table();
    //     af_wbs_selection_type();
    //     af_wbs_live_search();
    // });


    $(document).on('click', '.af-wbs-add-new-price-conditions', function () {
        let array_key = $(this).closest('div.af-wbs-metabox-fields').find('div.af-wbs-tabs-content').attr('id');

        if (php_var[array_key]) {

            let new_html = php_var[array_key];

            let set_condition_id = $(this).closest('div.af-wbs-metabox-fields').find('div.af-wbs-tabs-content table tbody tr').last().data('condition_id')
                ? parseInt($(this).closest('div.af-wbs-metabox-fields').find('div.af-wbs-tabs-content table tbody tr').last().data('condition_id')) + 1
                : 1;

            new_html = af_wbs_repalce_place_holder(new_html, set_condition_id);

            $(this).closest('div.af-wbs-metabox-fields').find('div.af-wbs-tabs-content table tbody').append(new_html);
        }

        // Call additional functions
        afwbs_pricing_table();
        af_wbs_selection_type();
        af_wbs_live_search();
    });


    jQuery(document).ready(function ($) {

        jQuery('.af-wbs-live-search-for').select2(
            {
                ajax: {
                    url: ajaxurl, // AJAX URL is predefined in WordPress admin.
                    dataType: 'json',
                    type: 'POST',
                    delay: 20, // Delay in ms while typing when to perform a AJAX search.
                    data: function (params) {
                        return {
                            q: params.term, // search query
                            action: 'af_wbs_live_search', // AJAX action for admin-ajax.php.//aftaxsearchUsers(is function name which isused in adminn file)
                            nonce: php_var.nonce, // AJAX nonce for admin-ajax.php.
                            search_type: $(this).data('search_type'),
                        };
                    },
                    processResults: function (data) {
                        var options = [];
                        if (data) {
                            // data is the array of arrays, and each of them contains ID and the Label of the option.
                            $.each(
                                data, function (index, text) {
                                    // do not forget that "index" is just auto incremented value.
                                    options.push({ id: text[0], text: text[1] });
                                }
                            );
                        }
                        return {
                            results: options
                        };
                    },
                    cache: true
                },
                // multiple: true,
                // placeholder: 'Choose Products',
                minimumInputLength: 3 // the minimum of symbols to input before perform a search.
            });
    });
    function af_wbs_live_search() {
        jQuery('.af-wbs-live-search-for').select2(
            {
                ajax: {
                    url: ajaxurl, // AJAX URL is predefined in WordPress admin.
                    dataType: 'json',
                    type: 'POST',
                    delay: 20, // Delay in ms while typing when to perform a AJAX search.
                    data: function (params) {
                        return {
                            q: params.term, // search query
                            action: 'af_wbs_live_search', // AJAX action for admin-ajax.php.//aftaxsearchUsers(is function name which isused in adminn file)
                            nonce: php_var.nonce, // AJAX nonce for admin-ajax.php.
                            search_type: $(this).data('search_type'),
                        };
                    },
                    processResults: function (data) {
                        var options = [];
                        if (data) {
                            // data is the array of arrays, and each of them contains ID and the Label of the option.
                            $.each(
                                data, function (index, text) {
                                    // do not forget that "index" is just auto incremented value.
                                    options.push({ id: text[0], text: text[1] });
                                }
                            );
                        }
                        return {
                            results: options
                        };
                    },
                    cache: true
                },
                // multiple: true,
                // placeholder: 'Choose Products',
                // minimumInputLength: 3 // the minimum of symbols to input before perform a search.
            });
    }

    if (jQuery('tbody.wc-shipping-zone-method-rows').length) {



    }

    setInterval(append_shipping_methods_with_shipping_zone, 1000);


    function append_shipping_methods_with_shipping_zone() {


        if (!jQuery('tbody.wc-shipping-zone-method-rows').find('tr.af-wbs-custom-shipping').length) {
            jQuery('tbody.wc-shipping-zone-method-rows').append(show_shipping_methods_with_shipping_zone);
        }

    }
    //update code latest update

    jQuery(document).ready(function ($) {
        $('.af_wbs_enable_row').insertBefore($('.form-table:first tr:first'));
        shippingDetails = php_var.af_wbs_get_shipping_method_type;

        setInterval(function () {
            $('.wc-shipping-zone-method-rows tr:not(.af-wbs-custom-shipping)').each(function () {
                var $row = $(this);
                var instanceId = $row.data('id');

                var shippingMethod = shippingDetails.find(function (detail) {
                    return detail.instance_id == instanceId;
                });

                // if (shippingMethod && shippingMethod.method_type !== 'free_shipping') {
                var actionsDiv = $row.find('.wc-shipping-zone-actions div');

                if (!actionsDiv.find('.edit-weight-base-settings').length) {
                    var existingEditHref = $row.find('.wc-shipping-zone-action-edit').attr('href');
                    var customAction = '<a href="' + existingEditHref + '" class="edit-weight-base-settings">Weight Base Rates</a> | ';
                    actionsDiv.prepend(customAction);
                }
                // }

                // // Check for enabled_weight_base_shipping and apply additional logic
                // if (shippingMethod && shippingMethod.enabled_weight_base_shipping === 'yes' && shippingMethod.method_type !== 'free_shipping') {
                //     $row.find('a.wc-shipping-zone-method-settings').each(function () {
                //         if ($(this).hasClass('wc-shipping-zone-method-settings')) {
                //             $(this).removeClass('wc-shipping-zone-method-settings');
                //         }
                //     });
                // }
            });
        }, 1000);
    });




    $('.af_wbs_enable_weight_based_shipping').change(function () {
        if ($(this).is(':checked')) {
            $('.af-wbs-disable-weight-based-shipping').show();
            $('.af_wbs_enable_row').siblings('tr').show();

        } else {
            $('.af-wbs-disable-weight-based-shipping').hide();
            $('.af_wbs_enable_row').siblings('tr').hide();

        }
    });

    setTimeout(function () {
        if (!$('.af_wbs_enable_weight_based_shipping').is(':checked')) {
            $('.af-wbs-disable-weight-based-shipping').hide();
            $('.af_wbs_enable_row').siblings('tr').hide();

        }

    }, 100);





    $(document).on('click', '.af-delete-shipping-post', function (event) {
        if ($(this).data('post_id')) {
            event.preventDefault();

            let current_btn = $(this);

            jQuery.ajax({

                url: ajaxurl,

                type: 'POST',

                data: {

                    action: 'af_delete_shipping_post',
                    post_id: $(this).data('post_id'),
                    nonce: php_var.nonce,

                },
                success: function (response) {


                    if (response.data['new_tr']) {

                        jQuery('.af-wbs-custom-shipping').remove();

                        let show_shipping_methods_with_shipping_zone = response.data['new_tr'];

                        append_shipping_methods_with_shipping_zone();

                    } else {
                        window.location.reload(true);
                    }
                }
            });
        }
    });

    $(document).on('change', 'select.af-wbs-selection-type', function () {
        af_wbs_selection_type($(this));
    });
    af_wbs_selection_type();
    function af_wbs_selection_type(current_btn = false) {

        if (current_btn) {
            let select_value = current_btn.val();

            if (current_btn.closest('tr.af-wbs-tab-pricing-weight-tr').length && select_value) {


                current_btn.closest('tr.af-wbs-tab-pricing-weight-tr').find('.af-wbs-pricing-select').each(function () {
                    $(this).hide('fast');
                });
                current_btn.closest('tr').find('.af-wbs-pricing-' + select_value).show('slow');

            }
        } else {

            $('select.af-wbs-selection-type').each(function () {
                let select_value = $(this).val();
                if ($(this).closest('tr.af-wbs-tab-pricing-weight-tr').length && select_value) {


                    $(this).closest('tr.af-wbs-tab-pricing-weight-tr').find('.af-wbs-pricing-select').each(function () {
                        $(this).hide('fast');
                    });
                    $(this).closest('tr').find('.af-wbs-pricing-' + select_value).show('slow');

                }
            });
        }


    }
});