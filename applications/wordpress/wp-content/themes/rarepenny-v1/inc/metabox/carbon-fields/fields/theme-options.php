<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Theme options metabox.
add_action('carbon_fields_register_fields', 'crb_attach_theme_options');
function crb_attach_theme_options() {
    // Default options page
    $basic_options_container = Container::make('theme_options', __('Basic Options')) 

        // https://docs.carbonfields.net/learn/containers/tabs.html
        ->add_tab(__('General Settings'), [
            Field::make('textarea', 'description', __('Description'))
                // ->set_required(true)
                ->set_width(50)
                ->set_rows(8),

            Field::make('textarea', 'keywords', __('Keywords'))
                ->set_width(50)
                ->set_rows(8),

            Field::make('text', 'company', 'Company')
                ->set_help_text('Set a company name.')
                ->set_width(50),

            // Use WP default tagline (formerly description) instead.
            // Field::make('text', 'tagline', 'Tagline')
            //     ->set_help_text('Set a company tagline.')
            //     ->set_width(50),

            Field::make('text', 'telephone', 'Telephone')
                ->set_width(50),

            // Field::make('text', 'email', 'Email')
            //     ->set_width(50),

            // Field::make('textarea', 'address', __('Address'))
            //     ->set_width(50)
            //     ->set_rows(8),

            // Field::make('textarea', 'warning', __('Warning'))
            //     ->set_width(50)
            //     ->set_rows(8),

            Field::make('complex', 'addresses', 'Addresses')
                ->set_layout('tabbed-horizontal')
                // ->set_max(1)
                ->set_help_text('Set contents for getting contacted. Meta ID: addresses.')
                ->add_fields([
                    Field::make('text', 'title', __('Title'))
                        ->set_help_text('Add a Title heading to this block. Meta ID: title.')
                        ->set_width(50),

                    Field::make('textarea', 'body', __('Body'))
                        ->set_width(50)
                        ->set_rows(8),
                ])
                ->set_default_value([
                    [
                        'title' => '',
                        'body' => '',
                    ],
                ]),

            Field::make('complex', 'warnings', 'Warnings')
                ->set_layout('tabbed-horizontal')
                // ->set_max(1)
                ->set_help_text('Set contents for getting contacted. Meta ID: warnings.')
                ->add_fields([
                    Field::make('text', 'title', __('Title'))
                        ->set_help_text('Add a Title heading to this block. Meta ID: title.')
                        ->set_width(50),

                    Field::make('textarea', 'body', __('Body'))
                        ->set_width(50)
                        ->set_rows(8),
                ])
                ->set_default_value([
                    [
                        'title' => '',
                        'body' => '',
                    ],
                ]),

            Field::make('complex', 'emails', 'Emails')
                ->set_layout('tabbed-horizontal')
                // ->set_max(1)
                ->set_help_text('Set contents for getting contacted. Meta ID: addresses.')
                ->add_fields([
                    Field::make('text', 'title', __('Title'))
                        ->set_help_text('Add a Title heading to this block. Meta ID: title.')
                        ->set_width(50),

                    Field::make('text', 'body', __('Body'))
                        ->set_help_text('Add a Body heading to this block. Meta ID: body.')
                        ->set_width(50),
                ])
                ->set_default_value([
                    [
                        'title' => '',
                        'body' => '',
                    ],
                ]),

            Field::make('textarea', 'opening_hours', __('Opening Hours'))
                ->set_width(50)
                ->set_rows(8),

            Field::make('textarea', 'copyright', __('Copyright'))
                ->set_width(50)
                ->set_rows(8),

            Field::make('textarea', 'credit', __('Credit'))
                ->set_width(50)
                ->set_rows(8),

            Field::make('image', 'logo', __('Logo'))
                ->set_help_text('Set a logo to this site.')
                ->set_width(50),

            // Field::make('image', 'logo_medium', __('Logo Medium'))
            //     ->set_help_text('Set a logo to this site for medium screens.')
            //     ->set_width(50),

            // Field::make('image', 'logo_small', __('Logo Small'))
            //     ->set_help_text('Set a logo to this site for small screens.')
            //     ->set_width(50),

            // Field::make('complex', 'logos', 'Logos')
            //     ->set_help_text('Set multiple logos on this site. For example, the logos on the footer.')
            //     // ->add_fields('icon',  [
            //     //     Field::make('text', 'name', __('Name'))
            //     //         ->set_help_text('Set the name of the icon, e.g. "icon-ce".')
            //     //         ->set_width(50),

            //     //     Field::make('text', 'sizes', __('Sizes'))
            //     //         ->set_help_text('Set the icon responsive sizes, e.g. "text-5xl @md:text-2xl @sm:text-xl".')
            //     //         ->set_width(50),
            //     // ])

            //     ->add_fields('image',  [
            //         Field::make('image', 'id', __(''))
            //             ->set_help_text('Set an image.')
            //             ->set_required(true)
            //             ->set_width(50),

            //         Field::make('select', 'size', __('Screen Size'))
            //             ->set_help_text('Select the screen size of this logo is used for. Meta ID: size.')
            //             ->set_required(true)
            //             ->set_width(50)
            //             ->set_options([
            //                  '' => 'Select One',
            //                 'small' => 'Small',
            //                 'medium' => 'Medium'
            //             ]),
            //     ]),            
        ])

        ->add_tab(__('Cookie Bar'), [
            Field::make('complex', 'cookies', '')
                ->set_layout('tabbed-horizontal')
                ->set_max(1)
                ->set_help_text('Set a cookie bar on the website. Meta ID: cookies.')
                ->add_fields([
                    Field::make('rich_text', 'body', __(''))
                        ->set_help_text('Set the cookie body. Meta ID: body.')
                        ->set_rows(8)
                        ->set_settings([
                            'media_buttons' => false
                        ]),

                    Field::make('text', 'accept', 'Accept')
                        ->set_help_text('Set the text for the Accept button. Meta ID: accept.')
                        ->set_width(100),

                    Field::make('text', 'reject', 'Reject')
                        ->set_help_text('Set the text for the Reject button. Meta ID: reject.')
                        ->set_width(100),

                    Field::make('checkbox', 'disable', 'Disable')
                        ->set_help_text('Check the box to turn off the cookie bar if it is not needed on your site. Meta ID: disable.'),
                ])
                ->set_default_value([
                    [
                        'body' => 'We use cookies to provide our services and for analytics and marketing. To find out more about our use of cookies, please see our Privacy Policy. By continuing to browse our website, you agree to our use of cookies.',
                        'accept' => 'Accept',
                        'reject' => 'Reject'
                    ],
                ]),
            
        ])

        ->add_tab(__('Page Not Found (404)'), [
            Field::make('complex', 'page_not_found', '')
                ->set_help_text('Set contents for page not found (404).')
                ->set_layout('tabbed-horizontal')
                ->set_max(1)
                ->add_fields([
                    Field::make('text', 'h1', __('H1'))
                        ->set_help_text('Add a H1 heading to this page. Meta ID: h1.')
                        ->set_width(100),

                    Field::make('textarea', 'h2', __('H2'))
                        ->set_help_text('Add a H2 heading to this page. Meta ID: h1.')
                        ->set_width(100),

                    Field::make('rich_text', 'introduction', __('Introduction'))
                        ->set_help_text('Add a rich text introduction copy to this page. Meta ID: introduction.')
                        ->set_rows(8)
                        ->set_settings([
                            'media_buttons' => false
                        ]),

                    Field::make('rich_text', 'body', __('Body'))
                        ->set_help_text('Add a rich text body copy to this page. Meta ID: body.')
                        ->set_rows(8)
                        ->set_settings([
                            'media_buttons' => false
                        ]),

                    Field::make('complex', 'buttons', 'Buttons')
                        ->set_help_text('Set buttons to this block. Meta ID: buttons.')
                        ->set_layout('tabbed-horizontal')
                        ->set_max(1)
                        ->add_fields('', set_fields_buttons()),

                    // Field::make('complex', 'assets', __('Assets'))
                    //     ->set_help_text('Add assets to this block. Meta ID: assets.')
                    //     ->set_layout('tabbed-vertical')
                    //     ->set_max(5)
                    //     ->add_fields(add_crb_asset_fields(
                    //         type: 'image',
                    //         options: ['alt']
                    //     )),

                    // Field::make('complex', 'appendixes', 'Appendixes')
                    //     ->set_layout('tabbed-horizontal')
                    //     ->add_fields('',  [
                    //         Field::make('textarea', 'title', __('Title'))
                    //             ->set_help_text('Add a title to this block. Meta ID: title.')
                    //             ->set_rows(2)
                    //             ->set_width(100),

                    //         Field::make('textarea', 'body', __('Body'))
                    //             ->set_help_text('Set a text to this block. Meta ID: body.')
                    //             ->set_rows(3)
                    //             ->set_width(100),

                    //         Field::make('complex', 'buttons', 'Buttons')
                    //             ->set_help_text('Set buttons to this block. Meta ID: buttons.')
                    //             ->set_layout('tabbed-horizontal')
                    //             ->set_max(1)
                    //             ->add_fields('', set_fields_buttons()),
                    //     ])
                ])
                ->set_default_value([
                    [
                        'h1' => '',
                        'body' => '',
                    ],
                ]),

        ])

        // ->add_tab(__('Appendixes'), [
        //     Field::make('complex', 'appendixes', '')
        //         ->set_layout('tabbed-horizontal')
        //         ->add_fields('',  [
        //             // Field::make('textarea', 'title', __('Title'))
        //             //     ->set_help_text('Add a title to this block. Meta ID: title.')
        //             //     ->set_rows(2)
        //             //     ->set_width(100),

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

    // Add 3rd options page under 'Basic Options'
    Container::make('theme_options', __('Form Options'))
        ->set_page_parent($basic_options_container) // reference to a top level container

        ->add_tab(__('Forms'), [
            Field::make('complex', 'forms', '')
                ->set_help_text('Set forms used by the site.')
                ->set_layout('tabbed-vertical')

                // Add contact form (outbound) options.
                ->add_fields([
                    Field::make('text', 'slug', 'Slug')
                        ->set_default_value('newsletter')
                        ->set_help_text('Set an unique key or ID to this component.')
                        ->set_width(100),

                    Field::make('text', 'title', __('Title'))
                        ->set_default_value('Newsletter')
                        ->set_help_text('text', 'Set the title of this component.')
                        ->set_width(100),

                    Field::make('textarea', 'body', __('Body'))
                        ->set_help_text('Set the body text of this component.')
                        ->set_width(100)
                        ->set_rows(8),

                    // Field::make('rich_text', 'body', __('Body'))
                    //     ->set_help_text('Set the body text of this component.')
                    //     ->set_width(100)
                    //     ->set_rows(8)
                    //     ->set_settings([
                    //         'media_buttons' => false
                    //     ]),

                    Field::make('text', 'server_name', 'Server Name')
                        ->set_default_value('Jane Doe Server')
                        ->set_help_text('')
                        ->set_width(100),

                    Field::make('text', 'server_email', 'Server Email')
                        ->set_default_value('no-reply@janedoe.com')
                        ->set_help_text('')
                        ->set_width(100),

                    Field::make('text', 'subject', 'Subject')
                        ->set_default_value('Form Subject')
                        ->set_help_text('')
                        ->set_width(100),

                    Field::make('rich_text', 'message', __('Message'))
                        ->set_help_text('Set the message text of this component.')
                        ->set_width(100)
                        ->set_rows(10)
                        ->set_settings([
                            'media_buttons' => true
                        ]),

                    Field::make('complex', 'attachments', 'Attachments')
                        ->set_help_text('The attachments for this outbound contact form.')
                        ->add_fields([
                            Field::make('file', 'id', __('File'))
                                // ->set_value_type('url')
                                ->set_help_text('Set a file.')
                                ->set_width(50),
                        ]),

                    Field::make('complex', 'labels', 'Labels')
                        ->set_help_text('The labels on the client form.')
                        ->add_fields(add_crb_key_value_group()),

                    Field::make('complex', 'client_statuses', 'Client Statuses')
                        ->set_help_text('Client side verification statuses when using the client form.')
                        ->add_fields(add_crb_key_value_group('textarea')),

                    Field::make('complex', 'server_statuses', 'Server Statuses')
                        ->set_help_text('Response from the server when sending the form data from the client.')
                        ->add_fields(add_crb_key_value_group('textarea'))
                ])
                ->set_help_text('Mail settings for receiving emails from users when they use the contact form.')
                // https://docs.carbonfields.net/learn/fields/complex.html#config-methods-2
                // https://stackoverflow.com/a/38084493/413225
                ->set_header_template('<%- _.startCase(title) %>')

        ])

        ->add_tab(__('SMTP Servers'), [
            Field::make('complex', 'smtp_servers', '')
                ->set_layout('tabbed-horizontal')
                ->set_max(1)
                ->set_help_text('Go to https://developers.google.com/maps/documentation/ to register a new project and get the map info from Google. Meta ID: smtp_servers.')
                ->add_fields([
                    // Field::make('text', 'slug', 'Slug')
                    //     ->set_help_text('Set the slug. Meta ID: slug.')
                    //     ->set_width(50),
                    Field::make('text', 'username', 'Username')
                        ->set_help_text('Set the SMTP username. Meta ID: username.')
                        ->set_width(50),
                    Field::make('text', 'password', 'Password')
                        ->set_help_text('Set the SMTP password. Meta ID: password.')
                        ->set_width(50),
                    Field::make('text', 'host', 'Host')
                        ->set_help_text('Set the SMTP host. Meta ID: host.')
                        ->set_width(50),
                    Field::make('text', 'port', 'Port')
                        ->set_help_text('Set the SMTP port. Meta ID: port.')
                        ->set_width(50),
                    Field::make('select', 'encryption', 'Encryption')
                        ->set_help_text('Set the SMTP encryption. Meta ID: encryption.')
                        ->set_options(array(
                            'TLS' => 'TLS',
                            'SSL' => 'SSL',
                        ))
                        ->set_width(100), // doesn't work
                    Field::make('checkbox', 'authentication', 'Authentication')
                        ->set_help_text('Set the SMTP  authentication. Meta ID: authentication.')
                        ->set_option_value('true')
                        ->set_width(100),
                    Field::make('checkbox', 'debug', 'Debug')
                        ->set_help_text('Set the SMPT debugger. Meta ID: debug.')
                        ->set_option_value('true')
                        ->set_width(100),
                ])
                ->set_default_value([
                    [
                        // 'slug' => 'default',
                        'username' => 'user@example.com',
                        'password' => 'secret',
                        'host' => 'smtp.example.com',
                        'port' => '465',
                        'encryption' => 'TLS',
                        'authentication' => 'true',
                        'debug' => 'true',
                    ]
                ]),
        ])

        ;

    // Add new options page under 'Basic Options'
    Container::make('theme_options', __('Social Options'))
        ->set_page_parent($basic_options_container) // reference to a top level container

        ->add_tab(__('Open Graph'), [
            Field::make('complex', 'open_graph', '')
                ->set_duplicate_groups_allowed(false)
                // ->set_max(1) // same as above.
                ->add_fields([
                    Field::make('text', 'fb_app_id', 'fb:app_id')
                        ->set_help_text('Go to https://developers.facebook.com/, create a Facebook app and grab the ID from there, e.g. 2740922996222837.')
                        ->set_width(100),

                    Field::make('text', 'og_type', 'og:type')
                        ->set_default_value('article')
                        ->set_help_text('The type of your object, e.g. video.movie.')
                        ->set_width(100),

                    Field::make('image', 'og_image', 'og:image')
                        ->set_help_text('The cover image of the post you share on social channels.')
                        ->set_value_type('url'),

                    Field::make('number', 'og_image_width', 'og:image:width')
                        ->set_default_value(1200)
                        ->set_help_text('The width of the cover image.')
                        ->set_width(100),

                    Field::make('number', 'og_image_height', 'og:image:height')
                        ->set_default_value(720)
                        ->set_help_text('The height of the cover image.')
                        ->set_width(100),

                    Field::make('text', 'twitter_card', 'twitter:card')
                        ->set_default_value('summary_large_image')
                        ->set_help_text('The type of Twitter Card, .e.g. summary, summary_large_image, etc. For more information, please check https://developer.twitter.com/en/docs/twitter-for-websites/cards/overview/abouts-cards')
                        ->set_width(100),

                    Field::make('text', 'twitter_site', 'twitter:site')
                        ->set_default_value('')
                        ->set_help_text('@username for the website used in the card footer.')
                        ->set_width(100),

                    Field::make('text', 'twitter_creator', 'twitter:creator')
                        ->set_default_value('')
                        ->set_help_text('@username for the content creator / author.')
                        ->set_width(100),
                ])
                ->set_default_value([
                    [
                        'fb_app_id' => '',
                        'og_type' => 'article',
                        'og_image' => '',
                        'og_image_width' => '1200',
                        'og_image_height' => '1200',
                        'twitter_card' => 'summary_large_image',
                        'twitter_site' => '',
                        'twitter_creator' => '',
                    ],
                ]),
        ])

        ->add_tab(__('Social Profiles'), [
            // Repeater.
            // https://carbonfields.net/docs/guides-repeating-groups-2/?crb_version=2-2-0
            Field::make('complex', 'social_profiles', '')
                ->set_help_text('Add social profiles. Meta ID: social_profiles.')
                ->set_layout('tabbed-horizontal')
                ->set_max(1)
                ->add_fields([
                    Field::make('text', 'title', __('Title'))
                        ->set_help_text('Add a title. Meta ID: title.')
                        ->set_width(100),

                    Field::make('rich_text', 'body', __(''))
                        ->set_help_text('Add a rich text body copy. Meta ID: body.')
                        ->set_rows(8)
                        ->set_settings([
                            'media_buttons' => false
                        ]),

                    Field::make('complex', 'assets', __('Assets'))
                        ->set_help_text('Add assets to this block. Meta ID: assets.')
                        // ->set_layout('tabbed-vertical')
                        ->set_max(5)
                        ->add_fields(add_crb_asset_fields(
                            type: 'image',
                            options: ['alt']
                        )),

                    Field::make('complex', 'profiles', '')
                        ->set_help_text('Add profiles to the list. Meta ID: profiles.')
                        ->add_fields([
                            Field::make('text', 'slug', 'Slug')
                                ->set_help_text('e.g. facebook, instagram, etc')
                                ->set_width(20),

                            Field::make('text', 'name_short', 'Short Name')
                                ->set_help_text('e.g. nasa, bbc')
                                ->set_width(20),

                            Field::make('text', 'name_long', 'Long Name')
                                ->set_help_text('e.g. instagram.com/nasa')
                                ->set_width(20),

                            Field::make('text', 'url', 'URL')
                                ->set_help_text('e.g. https://www.instagram.com/nasa/')
                                ->set_width(20),

                            Field::make('text', 'icon', 'Icon')
                                ->set_help_text('e.g. icon-social-facebook, icon-social-instagram')
                                ->set_width(20),
                        ]),
                ])
                ->set_default_value([
                    [
                        'h1' => '',
                        'body' => '',
                    ],
                ])
        ])

        ;

    // Add 4th options page under 'Basic Options'
    Container::make('theme_options', __('API Options'))
        ->set_page_parent($basic_options_container) // reference to a top level container

        ->add_tab(__('Google Analytics'), [
            Field::make('complex', 'google_analytics', '')
                ->set_layout('tabbed-horizontal')
                ->set_max(1)
                ->set_help_text('Go to https://analytics.google.com/analytics/web/provision/?authuser=7#/provision to register a new site and get the measurement ID from Google. Meta ID: google_analytics.')
                ->add_fields([
                    Field::make('text', 'measurement_id', 'Measurement ID')
                        ->set_help_text('Set the measurement ID. Meta ID: measurement_id.')
                        ->set_width(100),
                ])
                ->set_default_value([
                    [
                        'measurement_id' => 'UA-8602078-2'
                    ],
                ]),
        ])

        ->add_tab(__('Google Maps'), [
            Field::make('complex', 'google_maps', '')
                ->set_layout('tabbed-horizontal')
                ->set_max(1)
                ->set_help_text('Go to https://developers.google.com/maps/documentation/ to register a new project and get the map info from Google. Meta ID: google_maps.')
                ->add_fields([
                    Field::make('text', 'api_key', 'API Key')
                        ->set_help_text('Set the measurement ID. Meta ID: api_key.')
                        ->set_width(50),
                    Field::make('text', 'map_id', 'Map ID')
                        ->set_help_text('Set the map ID. Meta ID: map_id.')
                        ->set_width(50),
                    Field::make('text', 'longitude', 'Longitude')
                        ->set_help_text('Set the longitude. Meta ID: longitude.')
                        ->set_width(50),
                    Field::make('text', 'latitude', 'Latitude')
                        ->set_help_text('Set the latitude. Meta ID: latitude.')
                        ->set_width(50),
                    Field::make('text', 'zoom', 'Zoom')
                        ->set_help_text('Set the zoom. Meta ID: zoom.')
                        ->set_width(50),
                    Field::make('text', 'zoom_click', 'Zoom (Click)')
                        ->set_help_text('Set the zoom on click. Meta ID: zoom_click.')
                        ->set_width(50),
                    Field::make('text', 'glyph_colour', 'Glyph Colour')
                        ->set_help_text('Set the glyph colour. Meta ID: glyph_colour.')
                        ->set_width(50),
                    Field::make('text', 'glyph_border_colour', 'Glyph Border Colour')
                        ->set_help_text('Set the glyph border colour. Meta ID: glyph_border_colour.')
                        ->set_width(50),
                    Field::make('text', 'glyph_background', 'Glyph Background')
                        ->set_help_text('Set the glyph background. Meta ID: glyph_background.')
                        ->set_width(50),
                ])
                ->set_default_value([
                    [
                        'api_key' => 'AIzaSyAoNifGJFXlSrA4d2uYG_b8QRR36m-kd80',
                        'map_id' => '85ce2b243c24bff816337030',
                        'longitude' => '133.775131',
                        'latitude' => '-25.274399',
                        'zoom' => '5',
                        'zoom_click' => '12',
                        'glyph_colour' => '#f9f2e8',
                        'glyph_border_colour' => '#f9f2e8',
                        'glyph_background' => '#d31f2b',
                    ]
                ]),
        ])
        
        ->add_tab(__('Mailchimp'), [
            Field::make('complex', 'mailchimp', '')
                ->set_layout('tabbed-horizontal')
                ->set_help_text('Log in your account at https://mailchimp.com/, navigate to "Account", then to "Extras" and "API Keys" to create the API key for your account.')
                ->add_fields([
                    Field::make('text', 'slug', 'Slug')
                        ->set_help_text('Set a unique key or ID to this component.')
                        ->set_width(100),

                    Field::make('text', 'api_key', 'API Key')
                        ->set_help_text('Set API key, e.g. 0fce7946064051c7ac2234040acfedd8-us1. Meta ID: api_key.')
                        ->set_width(100),

                    Field::make('complex', 'list_ids', 'List IDs')
                        ->set_help_text('Set list IDs, e.g. 2d561a6c0a. Meta ID: list_ids.')
                        ->add_fields(add_crb_key_value_group())
                        ->set_default_value([
                            [
                                'key' => 'basic_contact_list',
                                'val' => '',
                            ],
                        ]),
                ])
                ->set_default_value([
                    [
                        'api_key' => '',
                    ],
                ]),
        ])

        ;
}
