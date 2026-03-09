<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Post attributes metabox.
add_action('carbon_fields_register_fields', 'crb_attach_about_meta_attributes');
function crb_attach_about_meta_attributes() {
    Container::make('post_meta', __('About Blocks'))
        ->where('post_template', '=', 'tmp-about.php')

        ->add_tab(__('Our Stories'), [
            Field::make('complex', 'our_stories', '')
                ->set_layout('tabbed-horizontal')
                ->set_max(1)
                ->add_fields('',  [

                    Field::make('textarea', 'title', __('Title'))
                        ->set_help_text('Add a title to this block. Meta ID: title.')
                        // ->set_rows(2)
                        ->set_width(100),

                    // Field::make('textarea', 'subtitle', __('Subtitle'))
                    //     ->set_help_text('Add a subtitle to this block. Meta ID: subtitle.')
                    //     // ->set_rows(2)
                    //     ->set_width(100),

                    // Field::make('textarea', 'body', __('Body'))
                    //     ->set_help_text('Set a text to this block. Meta ID: body.')
                    //     ->set_rows(3)
                    //     ->set_width(100),

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


                    Field::make('complex', 'assets', __('Assets'))
                        ->set_help_text('Add assets to this block. Meta ID: assets.')
                        ->set_layout('tabbed-vertical')
                        ->set_max(5)
                        ->add_fields(add_crb_asset_fields(
                            type: 'image',
                            options: ['alt']
                        )),
                ])
        ])

        ->add_tab(__('Our Values'), [
            Field::make('complex', 'our_values', '')
                ->set_layout('tabbed-horizontal')
                ->set_max(1)
                ->add_fields('',  [
                    Field::make('textarea', 'title', __('Title'))
                        ->set_help_text('Add a title to this block. Meta ID: title.')
                        // ->set_rows(2)
                        ->set_width(100),

                    Field::make('textarea', 'body', __('Body'))
                        ->set_help_text('Set a text to this block. Meta ID: body.')
                        // ->set_rows(3)
                        ->set_width(100),

                    Field::make('complex', 'values', __('Values'))
                        ->set_help_text('Add assets to this block. Meta ID: assets.')
                        ->set_layout('tabbed-horizontal')
                        ->add_fields('', [
                            Field::make('text', 'title', __('Title'))
                                ->set_help_text('Add a title to this block. Meta ID: title.')
                                // ->set_rows(2)
                                ->set_width(100),

                            Field::make('textarea', 'body', __('Body'))
                                ->set_help_text('Set a text to this block. Meta ID: body.')
                                // ->set_rows(3)
                                ->set_width(100),

                        ]),
                    
                    Field::make('complex', 'buttons', 'Buttons')
                        ->set_help_text('Set buttons to this block. Meta ID: buttons.')
                        ->set_layout('tabbed-horizontal')
                        ->set_max(1)
                        ->add_fields('', set_fields_buttons()),
                ])
        ])
        ;
}
