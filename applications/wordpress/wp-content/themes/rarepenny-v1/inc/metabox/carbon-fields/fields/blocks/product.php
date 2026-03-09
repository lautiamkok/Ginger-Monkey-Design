<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Contents metabox.
add_action('carbon_fields_register_fields', 'crb_attach_post_meta_Product_attributes');
function crb_attach_post_meta_Product_attributes() {
    
    Container::make('post_meta', __('Product Attributes'))
        ->where('post_type', 'IN', ['product'])

        ->add_tab(__('Tasting Notes'), [
            Field::make('complex', 'tasting_notes', '')
                ->set_layout('tabbed-horizontal')
                ->add_fields('',  [
                    Field::make('text', 'title', __('Title'))
                        ->set_help_text('Add a title to this block. Meta ID: title.')
                        ->set_width(100),

                    Field::make('rich_text', 'body', __('Body'))
                        ->set_help_text('Set a text to this block. Meta ID: body.')
                        ->set_rows(3)
                        ->set_width(100)
                        ->set_settings([
                            'media_buttons' => false,
                            'tinymce' => [
                              'toolbar1' => 'bold,italic,bullist,link',
                            ]
                        ]),
                ])
        ])


        ->add_tab(__('Related products'), [
            Field::make('complex', 'related_products', '')
                ->set_layout('tabbed-horizontal')
                ->add_fields('',  [
                    Field::make('textarea', 'title', __('Title'))
                        ->set_help_text('Add a title to this block. Meta ID: title.')
                        ->set_width(100),

                    Field::make('rich_text', 'body', __('Body'))
                        ->set_help_text('Set a text to this block. Meta ID: body.')
                        ->set_rows(3)
                        ->set_width(100)
                        ->set_settings([
                            'media_buttons' => false,
                            'tinymce' => [
                              'toolbar1' => 'bold,italic,bullist,link',
                            ],
                            // 'tinymce' => false,
                        ]),

                    Field::make('association', 'associates', __(''))
                        ->set_help_text('Set associates to this carousel. Meta ID: associates.')
                        ->set_min(1)
                        ->set_types([
                            [
                                'type' => 'post',
                                'post_type' => 'product',
                            ],
                        ]),
                ])
        ])

        ->add_tab(__('Parent Posts'), [
            Field::make('association', 'parents', __(''))
                ->set_help_text('Set parent posts to this product. Meta ID: parents.')
                ->set_min(1)
                ->set_types([
                    [
                        'type'      => 'post',
                        'post_type' => 'page',
                    ],
                ]),
        ])

        // ->add_tab(__('Group'), [
        //    Field::make( 'select', 'group', __( '' ) )
        //         ->set_help_text('Select an option to this block. Meta ID: group.')
        //         ->set_options([
        //             'red' => 'Red',
        //             'white' => 'White',
        //         ]),
        // ])
    ;

    // Container::make('post_meta', __('Product Highlights'))
    //     ->where('post_type', 'IN', ['product'])
    //     // ->set_context('side')
    //     // ->set_priority('normal')

    //     ->add_fields([
    //         Field::make('rich_text', 'highlights', __(''))
    //             ->set_help_text('Set a text to this block. Meta ID: highlights.')
    //             ->set_width(100)
    //             ->set_settings([
    //                 'media_buttons' => false,
    //                 'tinymce' => [
    //                   'toolbar1' => 'bold,italic,bullist,link',
    //                 ],
    //                 // 'tinymce' => false,
    //             ]),
    //     ])
    // ;
}
