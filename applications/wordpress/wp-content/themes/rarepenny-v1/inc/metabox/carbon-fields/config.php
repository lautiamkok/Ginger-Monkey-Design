<?php
// Set generic options.

// Set all available post types.
function set_all_available_post_types() {
    return [
        [
            'type'      => 'post',
            'post_type' => 'post',
        ],
        [
            'type'      => 'post',
            'post_type' => 'page',
        ],
        [
            'type'      => 'post',
            'post_type' => 'project',
        ]
    ];
}

function set_flex_center_options() {
    return [
         '' => 'Select One',
        'flex-center-xy' => 'XY Center',
    ];
}

function set_flex_direction_options() {
    return [
         '' => 'Select One',
        'flex-row-reverse' => 'Row Reverse',
    ];
}

function set_flex_justify_options() {
    return [
         '' => 'Select One',
        'justify-start' => 'Justify Left',
        'justify-end' => 'Justify Right',
    ];
}

function set_padding_options() {
    return [
         '' => 'Select One',
        'pb-0' => 'Padding Bottom 0',
    ];
}

function set_bg_options() {
    return [
         '' => 'Select One',
        'bg-black' => 'Black',
        'bg-[#bdb49c]' => 'Tan'
    ];
}

function set_text_alignment_options() {
    return [
         '' => 'Select One',
        'text-center' => 'Center',
    ];
}

// Abstract responsive size options to be reuse.
function set_order_options() {
    return [
        '' => 'Select One',
        'order-2' => 'Order 2'
    ];
}

// Abstract responsive size options to be reuse.
function set_column_size_options() {
    return [
        '' => 'Select One',
        // 'w-3/12' => '3/12',
        // 'w-4/12' => '4/12',
        // 'w-5/12' => '5/12',
        // 'w-6/12' => '6/12',
        // 'w-7/12' => '7/12',
        'w-8/12' => '8/12',
        // 'w-9/12' => '9/12',
        'w-10/12' => '10/12',
        // 'w-11/12' => '11/12',
        'w-12/12' => '12/12',
    ];
}

function set_percentage_options() {
    return [
        '' => 'Select One',
        '0' => 0,
        '10' => 10,
        '20' => 20,
        '30' => 30,
        '40' => 40,
        '50' => 50,
        '60' => 60,
        '70' => 70,
        '80' => 80,
        '90' => 90,
        '100' => 100,
    ];
}

function set_contact_form_labels() {
    return [
        [
            'key' => 'input_name',
            'val' => 'Name',
        ],
        [
            'key' => 'input_email',
            'val' => 'Email',
        ],
        [
            'key' => 'input_phone',
            'val' => 'Phone',
        ],
        [
            'key' => 'input_contact_method',
            'val' => 'How would you like to be contacted?',
        ],
        [
            'key' => 'input_message',
            'val' => 'Your Request',
        ],
        [
            'key' => 'option_select_one',
            'val' => 'Select one',
        ],
        [
            'key' => 'option_email',
            'val' => 'Email',
        ],
        [
            'key' => 'option_phone',
            'val' => 'Phone',
        ],
        [
            'key' => 'button_submit',
            'val' => 'Submit',
        ],
        [
            'key' => 'placeholder_required',
            'val' => '(required)',
        ],
        [
            'key' => 'placeholder_optional',
            'val' => '(optional)',
        ],
    ];
}

function set_contact_form_client_statuses() {
    return [
        [
            'key' => 'name_invalid',
            'val' => 'Please fill this out, it\'s required.',
        ],
        [
            'key' => 'email_invalid',
            'val' => 'Please fill this out, it\'s required. Or, it is invalid.',
        ],
        [
            'key' => 'phone_invalid',
            'val' => 'Please fill this out, it\'s required.',
        ],
        [
            'key' => 'contact_method_invalid',
            'val' => 'Please select one, it\'s required.',
        ],
        [
            'key' => 'message_invalid',
            'val' => 'Please fill this out, it\'s required.',
        ],
    ];
}

function set_contact_form_server_statuses() {
    return [
        [
            'key' => 'sent_failed',
            'val' => 'Sorry, there was an error in sending your message. Please try again later.',
        ],
        [
            'key' => 'sent_ok',
            'val' => 'Thank you for leaving your mark. We will be in touch soon.',
        ],
    ];
}

function set_signup_form_labels() {
    return [
        [
            'key' => 'input_name',
            'val' => 'Name',
        ],
        [
            'key' => 'input_email',
            'val' => 'Email',
        ],
        [
            'key' => 'input_subscribed',
            'val' => 'I agree to receive marketing material.',
        ],
        [
            'key' => 'button_submit',
            'val' => 'Submit',
        ],
        [
            'key' => 'placeholder_required',
            'val' => '(required)',
        ],
        [
            'key' => 'placeholder_optional',
            'val' => '(optional)',
        ]
    ];
}

function set_signup_form_client_statuses() {
    return [
        [
            'key' => 'form_invalid',
            'val' => 'There are some errors in your form.',
        ],
        [
            'key' => 'fname_invalid',
            'val' => 'Please fill in this required field.',
        ],
        [
            'key' => 'lname_invalid',
            'val' => 'Please fill in this required field.',
        ],
        [
            'key' => 'email_invalid',
            'val' => 'Please fill in this required field.',
        ],
    ];
}

function set_signup_form_server_statuses() {
    return [
        [
            'key' => 'mailchimp_key_absent',
            'val' => 'Mailchimp API key not found.',
        ],
        [
            'key' => 'mailchimp_list_empty',
            'val' => 'Mailchimp list is not found.',
        ],
        [
            'key' => 'mailchimp_list_id_invalid',
            'val' => 'Mailchimp list ID is empty or invalid.',
        ],
        [
            'key' => 'add_ok',
            'val' => 'You have been added successfully!',
        ],
        [
            'key' => 'add_failed',
            'val' => 'An error occurs! Please try again.',
        ],
        [
            'key' => 'sent_failed',
            'val' => 'Sorry, there was an error in sending you an email to verify your email address. Please try again later.',
        ],
        [
            'key' => 'sent_ok',
            'val' => 'Thank you for signing up. We have sent you an email to verify your email address. Please check your email and click the token that we just sent you.',
        ],
    ];
}

function set_verify_form_labels() {
    return [
        [
            'key' => 'input_email',
            'val' => 'Email',
        ],
        [
            'key' => 'button_submit',
            'val' => 'Submit',
        ],
        [
            'key' => 'placeholder_required',
            'val' => '(required)',
        ],
        [
            'key' => 'placeholder_optional',
            'val' => '(optional)',
        ],
    ];
}

function set_verify_form_client_statuses() {
    return [
        [
            'key' => 'email_invalid',
            'val' => 'Please fill this out, it\'s required. Or, it is invalid.',
        ],
    ];
}

function set_verify_form_server_statuses() {
    return [
        [
            'key' => 'verify_failed',
            'val' => 'Sorry, a problem occurred when verifying your email. Please contact us.',
        ],
        [
            'key' => 'verify_ok',
            'val' => 'Your email address is now verified. Thank you for verifying.',
        ],
        [
            'key' => 'ok_title',
            'val' => 'Thank You',
        ],
        [
            'key' => 'failed_title',
            'val' => 'Error',
        ],
        [
            'key' => 'token_invalid',
            'val' => 'Sorry, the token is not valid.',
        ],
        [
            'key' => 'contact_not_exist',
            'val' => 'Sorry, we cannot find you in our contact list.',
        ],
        [
            'key' => 'already_verified',
            'val' => 'You have already verified.',
        ],
    ];
}

function set_verify_form_message_blocks() {
    return [
        [
            'key' => 'body',
            'val' => 'Thank you for verifying your email. It is verified successfully.',
        ],
        [
            'key' => 'unsubscribe',
            'val' => 'If you ever wish to unsubscribe, please use the link below:',
        ],
        [
            'key' => 'footer',
            'val' => "Thank you, \r\nJane Doe", // line breaks require double quotes.
        ],
    ];
}

function set_unsubscribe_form_client_statuses() {
    return [
        [
            'key' => 'form_invalid',
            'val' => 'There are some errors in your form.',
        ],
        [
            'key' => 'email_invalid',
            'val' => 'Please fill in this required field.',
        ],
    ];
}

function set_unsubscribe_form_server_statuses() {
    return [
        [
            'key' => 'contact_not_exist',
            'val' => 'Sorry, we cannot find your email address in our contact list.',
        ],
        [
            'key' => 'already_unsubscribed',
            'val' => 'Sorry, you are already unsubscribed from our mailing list.',
        ],
        [
            'key' => 'unsubscribed_ok',
            'val' => 'You are now unsubscribed from our mailing list. Thank you.',
        ],
        [
            'key' => 'unsubscribed_failed',
            'val' => 'Failed to unsubscribe your email. Please try again.',
        ],
    ];
}
