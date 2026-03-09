<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Post attributes metabox.
add_action('carbon_fields_register_fields', 'crb_attach_home_meta_attributes');
function crb_attach_home_meta_attributes() {
    Container::make('post_meta', __('Home Attributes'))
        ->where('post_id', 'IN', [get_option('page_on_front')])
        
        ->add_tab(__('H1'), [
            Field::make('text', 'h1', __(''))
                ->set_help_text('Set a H1 to this page. Meta ID: h1.')
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

        ;
}
