<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Post attributes metabox.
add_action('carbon_fields_register_fields', 'crb_attach_shop_meta_attributes');
function crb_attach_shop_meta_attributes() {
    // Get the post id by slug.
    $post = get_page_by_path('shop', OBJECT, 'page');

    Container::make('post_meta', __('Shop Blocks'))
        ->where('post_template', '=', 'tmp-shop.php')
        ->or_where('post_id', '=', $post->ID)

        ->add_tab(__('Notes'), [
            Field::make('complex', 'notes', '')
                ->set_layout('tabbed-horizontal')
                ->add_fields('',  [
                    // Field::make('textarea', 'title', __('Title'))
                    //     ->set_help_text('Add a title to this block. Meta ID: title.')
                    //     ->set_rows(2)
                    //     ->set_width(100),

                    Field::make('textarea', 'body', __(''))
                        ->set_help_text('Set a text to this block. Meta ID: body.')
                        ->set_rows(3)
                        ->set_width(100),
                ])
        ])

        // ->add_tab(__('Products'), [
        //     Field::make('association', 'products', __(''))
        //     ->set_help_text('Set a product to this page. Meta ID: products')
        //     ->set_max(1)
        //     ->set_types([
        //         [
        //             'type' => 'post',
        //             'post_type' => 'product',
        //         ],
        //     ]),
        // ])
        ;
}
