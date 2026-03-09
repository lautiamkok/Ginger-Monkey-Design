<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Post attributes metabox.
add_action('carbon_fields_register_fields', 'crb_attach_post_meta_attributes');
function crb_attach_post_meta_attributes() {

    // Container::make('post_meta', __('Related Products'))
    //     ->where('post_id', 'NOT IN', [get_option('page_on_front')])
    //     ->where('post_type', 'NOT IN', ['product'])
    //     // ->set_context( 'side' )
        
    //     ->add_fields([
    //         Field::make('complex', 'related_products', '')
    //             ->set_layout('tabbed-horizontal')
    //             ->add_fields('',  [
    //                 Field::make('textarea', 'title', __('Title'))
    //                     ->set_help_text('Add a title to this block. Meta ID: title.')
    //                     ->set_width(100),

    //                 Field::make('rich_text', 'body', __('Body'))
    //                     ->set_help_text('Set a text to this block. Meta ID: body.')
    //                     ->set_rows(3)
    //                     ->set_width(100)
    //                     ->set_settings([
    //                         'media_buttons' => false,
    //                         'tinymce' => [
    //                           'toolbar1' => 'bold,italic,bullist,link',
    //                         ],
    //                         // 'tinymce' => false,
    //                     ]),

    //                 Field::make('association', 'associates', __(''))
    //                     ->set_help_text('Set associates to this carousel. Meta ID: associates.')
    //                     ->set_min(1)
    //                     ->set_types([
    //                         [
    //                             'type' => 'post',
    //                             'post_type' => 'product',
    //                         ],
    //                     ]),
    //             ])
    //     ])
    //     ;

    // https://docs.carbonfields.net/learn/containers/post-meta.html
    Container::make('post_meta', __('Cover Image'))
        ->where('post_id', 'NOT IN', [get_option('page_on_front')])
        ->set_context('side')
        ->set_priority('low')

        ->add_fields([
            Field::make('file', 'cover_id', __(''))
                ->set_help_text('Set an image from the local Media Library. Meta ID: cover_id.')
                // ->set_required(true)
                ->set_width(100)
                ->set_type(['image']),

            Field::make('text', 'cover_alt', __('Alternative (Alt) Text'))
                ->set_help_text('Set an alt text alt to this asset. Meta ID: cover_alt.')
                ->set_width(100),
        ])
    ;

    Container::make('post_meta', __('Wine Group'))
        ->where('post_type', 'IN', ['product'])
        ->set_context('side')
        ->set_priority('high')

        ->add_fields([
            Field::make( 'select', 'group', __( '' ) )
                ->set_help_text('Select a wine group to this product. Meta ID: group.')
                ->set_options([
                    '' => 'Select One',
                    'red' => 'Red',
                    'white' => 'White',
                ]),
        ])
    ;

    Container::make('post_meta', __('Post Attributes'))
        ->where('post_id', 'NOT IN', [get_option('page_on_front')])
        ->where('post_type', 'NOT IN', ['product'])
        // ->set_context( 'side' )
        
        ->add_tab(__('H2'), [
            Field::make('textarea', 'h2', __(''))
                ->set_help_text('Set a H2 to this post. Meta ID: h2.')
                ->set_width(100),
        ])

        ->add_tab(__('Introduction'), [
            Field::make('textarea', 'introduction', __(''))
                ->set_help_text('Set an introduction to this post. Meta ID: introduction.')
                ->set_width(100),
        ])

        ->add_tab(__('Parallax Assets'), [
            Field::make('complex', 'assets', __(''))
                ->set_help_text('Add assets to this block. Meta ID: assets.')
                ->set_layout('tabbed-horizontal')
                ->set_max(1)
                ->add_fields(add_crb_asset_fields(
                    type: 'image',
                    options: ['alt']
                )),
        ])

        // ->add_tab(__('Assets'), [
        //     Field::make('complex', 'assets', '')
        //         ->set_help_text('Attach local assets to this post. Meta ID: assets.')
        //         ->set_layout('tabbed-vertical')
        //         ->add_fields(add_crb_asset_fields(
        //             type: 'image',
        //             options: ['alt']
        //        )),
        // ])

        // ->add_tab(__('Buttons'), [
        //     Field::make('complex', 'buttons', '')
        //         ->set_help_text('Set buttons to this post. Meta ID: buttons.')
        //         ->set_layout('tabbed-horizontal')
        //         ->set_max(1)
        //         ->add_fields('', set_fields_buttons()),
        // ])

        // ->add_tab(__('Stockists'), [
        //     Field::make('complex', 'stockists', '')
        //         ->set_layout('tabbed-horizontal')
        //         ->add_fields('',  [
        //             Field::make('text', 'title', __('Title'))
        //                 ->set_help_text('Add a title to this block. Meta ID: title.')
        //                 ->set_width(100),

        //             Field::make('textarea', 'subtitle', __('Subtitle'))
        //                 ->set_help_text('Add a subtitle to this block. Meta ID: subtitle.')
        //                 // ->set_rows(2)
        //                 ->set_width(100),

        //             // Field::make('textarea', 'body', __('Body'))
        //             //     ->set_help_text('Set a text to this block. Meta ID: body.')
        //             //     ->set_rows(3)
        //             //     ->set_width(100),

        //             Field::make('rich_text', 'body', __('Body'))
        //                 ->set_help_text('Set a text to this block. Meta ID: body.')
        //                 ->set_rows(3)
        //                 ->set_width(100)
        //                 ->set_settings([
        //                     'media_buttons' => false,
        //                     'tinymce' => [
        //                       'toolbar1' => 'bold,italic,bullist,link',
        //                     ],
        //                     // 'tinymce' => false,
        //                 ]),

        //             Field::make('complex', 'assets', __('Assets'))
        //                 ->set_help_text('Add assets to this block. Meta ID: assets.')
        //                 ->set_layout('tabbed-vertical')
        //                 ->set_max(5)
        //                 ->add_fields(add_crb_asset_fields(
        //                     type: 'image',
        //                     options: ['alt']
        //                 )),
                    
        //             Field::make('complex', 'buttons', 'Buttons')
        //                 ->set_help_text('Set buttons to this block. Meta ID: buttons.')
        //                 ->set_layout('tabbed-horizontal')
        //                 ->set_max(1)
        //                 ->add_fields('', set_fields_buttons()),
        //         ])
        // ])

        // ->add_tab(__('Related products'), [
        //     Field::make('complex', 'related_products', '')
        //         ->set_layout('tabbed-horizontal')
        //         ->add_fields('',  [
        //             Field::make('textarea', 'title', __('Title'))
        //                 ->set_help_text('Add a title to this block. Meta ID: title.')
        //                 ->set_width(100),

        //             Field::make('rich_text', 'body', __('Body'))
        //                 ->set_help_text('Set a text to this block. Meta ID: body.')
        //                 ->set_rows(3)
        //                 ->set_width(100)
        //                 ->set_settings([
        //                     'media_buttons' => false,
        //                     'tinymce' => [
        //                       'toolbar1' => 'bold,italic,bullist,link',
        //                     ],
        //                     // 'tinymce' => false,
        //                 ]),

        //             Field::make('association', 'associates', __(''))
        //                 ->set_help_text('Set associates to this carousel. Meta ID: associates.')
        //                 ->set_min(1)
        //                 ->set_types([
        //                     [
        //                         'type' => 'post',
        //                         'post_type' => 'product',
        //                     ],
        //                 ]),
        //         ])
        // ])

        // ->add_tab(__('Colour Category'), [
        //     Field::make('select', 'colour_category', '')
        //         ->set_help_text('Select a colour category to this post. Meta ID: colour_category.')
        //         ->set_width(100)
        //         ->set_options(set_colour_categories()),
        // ])

        ->add_tab(__('Databases'), [
            Field::make('complex', 'databases', '')
                ->set_help_text('Attach standalone databases such as SQLite databases to this post. Meta ID: databases.')
                ->set_layout('tabbed-horizontal')
                ->add_fields([
                    Field::make('file', 'id', __('File'))
                        ->set_help_text('Set a file to this database. Meta ID: id.')
                        ->set_width(20)
                        // ->set_value_type('url')
                        ,

                    Field::make('text', 'slug', __('Slug'))
                        ->set_help_text('Set a slug to this database. Meta ID: slug.')
                        ->set_width(100),

                    Field::make('text', 'title', __('Title'))
                        ->set_help_text('Set a title to this database. Meta ID: title.')
                        ->set_width(100),
                ]),
        ])
        ;
}
