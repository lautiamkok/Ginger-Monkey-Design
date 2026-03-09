<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

function set_fields_buttons() {
    return [
        Field::make('text', 'label', __('Label'))
            ->set_help_text('Set a label to this button. Meta ID: label.')
            ->set_width(100),

        Field::make('association', 'associate', __('Associate'))
            ->set_help_text('Set a link to this button to a local page. Meta ID: associate')
            ->set_max(1)
            ->set_types([
                [
                    'type' => 'post',
                    'post_type' => 'page',
                ],
            ]),

        Field::make('text', 'custom_link', __('Custom Link'))
            ->set_help_text('Set a custom link to this button. Meta ID: custom_link.')
            ->set_width(100),
    ];
}

function set_fields_video() {
    return [
        Field::make('select', 'size', __('Size'))
            ->set_help_text('Select a size to this video. Meta ID: size.')
            ->set_width(33.3)
            ->set_options([
                '1x1' => '1x1',
                '4x5' => '4x5',
                '9x16' => '9x16',
                '16x9' => '16x9',
            ]),

        Field::make('file', 'poster_id', __('Poster'))
            ->set_help_text('Set a cover image from the local Media Library. Meta ID: poster_id.')
            ->set_required(true)
            ->set_width(33.3)
            ->set_type(['image']),

        Field::make('file', 'video_id', __('Video'))
            ->set_help_text('Set the video from the local Media Library. Meta ID: video_id.')
            ->set_required(true)
            ->set_width(33.3)
            ->set_type(['video'])
    ];
}

function set_colour_categories() {
    return [
        '' => 'Select One',
        'raspberry' => 'Raspberry',
        'lime' => 'Lime',
        'blue' => 'Blue',
        'gray' => 'Gray',
    ];
}

// Post attributes metabox.
add_action('carbon_fields_register_fields', 'crb_attach_post_meta_home_attributes');
function crb_attach_post_meta_home_attributes() {
    Container::make('post_meta', __('Home Blocks'))
        ->where('post_id', 'IN', [get_option('page_on_front')])

        ->add_tab(__('Penny Videos'), [
            Field::make('complex', 'penny_videos', '')
                // ->set_layout('tabbed-horizontal')
                ->add_fields('',  set_fields_video())
        ])

        ->add_tab(__('About'), [
            Field::make('complex', 'about', '')
                ->set_layout('tabbed-horizontal')
                ->add_fields('',  [
                    Field::make('textarea', 'title', __('Title'))
                        ->set_help_text('Add a title to this block. Meta ID: title.')
                        // ->set_rows(2)
                        ->set_width(100),

                    Field::make('textarea', 'body', __('Body'))
                        ->set_help_text('Set a text to this block. Meta ID: body.')
                        // ->set_rows(3)
                        ->set_width(100),

                    Field::make('complex', 'assets', __('Assets'))
                        ->set_help_text('Add assets to this block. Meta ID: assets.')
                        ->set_layout('tabbed-horizontal')
                        ->set_max(2)
                        ->add_fields(add_crb_asset_fields(
                            type: 'image',
                            options: ['alt']
                        )),
                    
                    Field::make('complex', 'buttons', 'Buttons')
                        ->set_help_text('Set buttons to this block. Meta ID: buttons.')
                        ->set_layout('tabbed-horizontal')
                        ->set_max(1)
                        ->add_fields('', set_fields_buttons()),
                ])
        ])

        ->add_tab(__('Value'), [
            Field::make('complex', 'value', '')
                ->set_layout('tabbed-horizontal')
                ->add_fields('',  [
                    Field::make('textarea', 'title', __('Title'))
                        ->set_help_text('Add a title to this block. Meta ID: title.')
                        // ->set_rows(2)
                        ->set_width(100),

                    Field::make('textarea', 'body', __('Body'))
                        ->set_help_text('Set a text to this block. Meta ID: body.')
                        // ->set_rows(3)
                        ->set_width(100),

                    Field::make('complex', 'assets', __('Assets'))
                        ->set_help_text('Add assets to this block. Meta ID: assets.')
                        ->set_layout('tabbed-horizontal')
                        ->set_max(1)
                        ->add_fields(add_crb_asset_fields(
                            type: 'image',
                            options: ['alt']
                        )),
                    
                    Field::make('complex', 'buttons', 'Buttons')
                        ->set_help_text('Set buttons to this block. Meta ID: buttons.')
                        ->set_layout('tabbed-horizontal')
                        ->set_max(1)
                        ->add_fields('', set_fields_buttons()),
                ])
        ])


        ->add_tab(__('Carousels'), [
            Field::make('complex', 'carousels', '')
                ->set_layout('tabbed-horizontal')
                ->add_fields('',  [
                    Field::make('textarea', 'title', __('Title'))
                        ->set_help_text('Add a title to this block. Meta ID: title.')
                        // ->set_rows(2)
                        ->set_width(100),

                    Field::make('textarea', 'body', __('Body'))
                        ->set_help_text('Set a text to this block. Meta ID: body.')
                        // ->set_rows(3)
                        ->set_width(100),
                        
                    Field::make('association', 'associates', __(''))
                        ->set_help_text('Set associates to this carousel. Meta ID: associates.')
                        ->set_min(1)
                        ->set_types([
                            [
                                'type' => 'post',
                                'post_type' => 'product',
                            ],
                        ]),
                    
                    Field::make('complex', 'buttons', 'Buttons')
                        ->set_help_text('Set buttons to this block. Meta ID: buttons.')
                        ->set_layout('tabbed-horizontal')
                        ->set_max(1)
                        ->add_fields('', set_fields_buttons()),
                ])
        ])

        ->add_tab(__('Carousel Wine Groups'), [
            Field::make('complex', 'groups', '')
                ->set_layout('tabbed-horizontal')
                ->add_fields('',  [
                    Field::make( 'select', 'group', __( 'Group' ) )
                        ->set_help_text('Select an option to this block. Meta ID: group.')
                        ->set_options([
                            'red' => 'Red',
                            'white' => 'White',
                        ]),

                    Field::make('textarea', 'title', __('Title'))
                        ->set_help_text('Add a title to this block. Meta ID: title.')
                        // ->set_rows(2)
                        ->set_width(100),

                    Field::make('textarea', 'body', __('Body'))
                        ->set_help_text('Set a text to this block. Meta ID: body.')
                        // ->set_rows(3)
                        ->set_width(100),

                    Field::make('association', 'associates', __(''))
                        ->set_help_text('Set associates to this carousel. Meta ID: associates.')
                        ->set_min(1)
                        ->set_types([
                            [
                                'type' => 'post',
                                'post_type' => 'product',
                            ],
                        ]),

                    // Field::make('complex', 'assets', __('Assets'))
                    //     ->set_help_text('Add assets to this block. Meta ID: assets.')
                    //     ->set_layout('tabbed-horizontal')
                    //     // ->set_max(1)
                    //     ->add_fields(add_crb_asset_fields(
                    //         type: 'image',
                    //         options: ['alt']
                    //     )),
                    
                    Field::make('complex', 'buttons', 'Buttons')
                        ->set_help_text('Set buttons to this block. Meta ID: buttons.')
                        ->set_layout('tabbed-horizontal')
                        ->set_max(1)
                        ->add_fields('', set_fields_buttons()),
                ])
        ])
        ;
}
