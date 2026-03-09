<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Post attributes metabox.
add_action('carbon_fields_register_fields', 'crb_attach_faq_meta_attributes');
function crb_attach_faq_meta_attributes() {
    Container::make('post_meta', __('FAQ Blocks'))
        ->where('post_template', '=', 'tmp-faq.php')

        ->add_tab(__('FAQs'), [
            Field::make('complex', 'faqs', '')
                ->set_layout('tabbed-horizontal')
                ->add_fields('',  [
                    Field::make('textarea', 'title', __('Title'))
                        ->set_help_text('Add a title to this block. Meta ID: title.')
                        // ->set_rows(2)
                        ->set_width(100),

                    Field::make('rich_text', 'body', __('Body'))
                        ->set_help_text('Add a rich text body copy to this block. Meta ID: body.')
                        ->set_width(100)
                        ->set_settings([
                            'media_buttons' => false,
                            'tinymce' => [
                              'toolbar1' => 'bold,italic,bullist,link',
                            ],
                            // 'tinymce' => false,
                        ]),
                ])
        ])

        // ->add_tab(__('Appendixes'), [
        //     Field::make('complex', 'appendixes', '')
        //         ->set_layout('tabbed-horizontal')
        //         ->add_fields('',  [
        //             Field::make('textarea', 'title', __('Title'))
        //                 ->set_help_text('Add a title to this block. Meta ID: title.')
        //                 ->set_rows(2)
        //                 ->set_width(100),

        //             Field::make('textarea', 'body', __('Body'))
        //                 ->set_help_text('Set a text to this block. Meta ID: body.')
        //                 ->set_rows(3)
        //                 ->set_width(100),

        //             Field::make('complex', 'buttons', 'Buttons')
        //                 ->set_help_text('Set buttons to this block. Meta ID: buttons.')
        //                 ->set_layout('tabbed-horizontal')
        //                 ->set_max(1)
        //                 ->add_fields('', set_fields_buttons()),
        //         ])
        // ])
        ;
}
