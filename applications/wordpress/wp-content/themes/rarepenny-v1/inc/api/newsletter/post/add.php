<?php
/**
 * Custom JSON API endpoint.
 * https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/
 */

// Include Composer autoloader.
require_once __DIR__ . '/../../../../vendor/autoload.php';

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Add a subscriber to mailchimp.
function add_subscriber ($data) {
    // return [
    //     'status' => 'ok',
    //     'message' => 'Email sent.',
    // ];

    // Get all the passed params.
    $params =  $data->get_params();

    // Required fields.
    $fields = [
        'name',
        'email',
        'telephone',
        'fname',
        'lname',

        'firstName',
        'lastName',
        'emailAddress',
    ];

    //Assume all fields are correct and set this to false if not.
    $valid = true;
    $missing_field = null;
    foreach($fields as $field) {
        if(!array_key_exists($field, $params)) { 
            $valid = false; // At least one key isn't set
            $missing_field = $field;
            break;
        }
    }

    // Stop here is any field not set.
    if (!$valid) {
        return [
            'status' => 'error',
            'code' => 400,
            'message' => 'Required fields not set',

            // Dev only:
            // 'message' => "The '{$missing_field}' field is not set"
        ];
    }

    // Honeypot
    $name = $params['name']?? '';
    $email = $params['email']?? '';
    $telephone = $params['telephone']?? '';
    $fname = $params['fname']?? '';
    $lname = $params['lname']?? '';
    if ($name || 
        $email || 
        $telephone || 
        $fname || 
        $lname
    ) {
        return [
            'status' => 'error',
            'code' => 403,
            'message' => 'You shall not pass!'
        ];
    }

    $first_name = $params['firstName']?? '';
    $last_name = $params['lastName']?? '';
    $email_address = $params['emailAddress']?? '';

    // Prepare user data.
    $subscriber_data = [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email_address' => $email_address,
    ];
    // print_r($user_data);

    // Get the mail settings.
    $forms = carbon_get_theme_option('forms');
    if (is_countable($forms) && count($forms) === 0) {
        return [
            'status' => 'error',
            'code' => 500,
            'message' => 'No mail setting is found.'
        ];
    }
    $subscribe_form = get_haystack_item('newsletter', $forms);
    $attachments = $subscribe_form['attachments'];
    $server_statuses = $subscribe_form['server_statuses'];

    // Get mailchimp info.
    $option_mailchimps = carbon_get_theme_option('mailchimp');
    if (is_countable($option_mailchimps) && count($option_mailchimps) === 0) {
        return [
            'status' => 'error',
            'code' => 500,
            'message' => 'No Mailchimp setting is found.'
        ];
    }
    $option_mailchimp = $option_mailchimps[0];

    // Get the api key.
    $api_key = $option_mailchimp['api_key'];
    if (!$api_key) {
        return [
            'status' => 'error',
            'code' => 500,
            'message' => 'Mailchimp API key not found.'
        ];
    }

    // Get all lists.
    $list_ids = $option_mailchimp['list_ids'];
    if (is_countable($list_ids) && count($list_ids) === 0) {
        return [
            'status' => 'error',
            'code' => 500,
            'message' => 'Mailchimp list is not found.'
        ];
    }

    // Get the list by key.
    $list_id = get_key_value('rarepenny_contact_list', $list_ids);
    if (!$list_id) {
        return [
            'status' => 'error',
            'code' => 500,
            'message' => 'Mailchimp list ID is empty or invalid.'
        ];
    }

    
    // Trace the contact via email from the URL query.
    $contact = call_mailchimp(
        [
            'email_address' => $subscriber_data['email_address']
        ],
        $api_key,
        $list_id,
    );
    // print_r($contact);

    // Stop here if email existed already and when the contact has already subscribed.
    if ($contact['code'] === 200 && $contact['data']['status'] === 'subscribed') {
        return [
            'status' => 'error',
            'code' => 400,
            'message' => get_key_value('already_subscribed', $server_statuses)
        ];
    }

    // When no contact found
    // if ($contact['code'] === 404) {
    //     return [
    //         'status' => 'error',
    //         'code' => 400,
    //         'message' => get_key_value('contact_not_exist', $server_statuses)
    //     ];
    // }

    // Encode the serialized data
    // $encoded_data = base64_encode(serialize($user));
    $encrypted_data = encrypt_string(serialize($subscriber_data));

    // Must encode + signs in the string for URL.
    // https://www.php.net/manual/en/function.urlencode.php 
    $encoded_data = urlencode(base64_encode($encrypted_data));
    
    // $decrypted_data = decrypt_string(base64_decode($encoded_data));
    // $params = unserialize($decrypted_data);
    // print_r($params);

    // Instantiation and passing `true` enables exceptions.
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';

    try {
        // Get the SMTP details from theme options.
        $smtp_server1 = carbon_get_theme_option('smtp_servers')[0] ?? [];
        if (is_countable($smtp_server1) && count($smtp_server1) === 0) {
            return [
                'status' => 'error',
                'code' => 500,
                'message' => 'No SMTP server is found.'
            ];
        }

        // Must use SMTP to send mails for this server.
        // Server settings
        $mail->SMTPDebug = $smtp_server1['debug'] ?? false; //Enable verbose debug output
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = $smtp_server1['host']; //Set the SMTP server to send through
        $mail->SMTPAuth = $smtp_server1['authentication'] ?? false; //Enable SMTP authentication
        $mail->Username = $smtp_server1['username']; //SMTP username
        $mail->Password = $smtp_server1['password']; //SMTP password
        $mail->SMTPSecure = $smtp_server1['encryption']; //Enable implicit TLS encryption
        $mail->Port = $smtp_server1['port']; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $server_name = $subscribe_form['server_name'];
        $server_email = $subscribe_form['server_email'];

        $recipient_fname = $subscriber_data['first_name'];
        $recipient_lname = $subscriber_data['last_name'];
        $recipient_email = $subscriber_data['email_address'];

        $site_url = site_url();
        $message_body = preg_replace('/(\[FIRST_NAME\])/', $recipient_fname, $subscribe_form['message']);
        $message_body = preg_replace('/(\[LAST_NAME\])/', $recipient_lname, $message_body);

        $message_body = preg_replace('/(\[URL\])/', "{$site_url}/verify-subscription/?t={$encoded_data}", $message_body);

        $mail->setFrom($server_email, $server_name);
        $mail->addAddress($recipient_email, $recipient_fname); // Add a recipient

        //Attachments
        if (is_countable($attachments) && count($attachments) > 0) {
            foreach($attachments as $attachment) {
                // Get URL from the ID.
                // https://developer.wordpress.org/reference/functions/get_attached_file/
                $attachment_url = get_attached_file($attachment['id']);
                if ($attachment_url) {
                    $mail->addAttachment($attachment_url);
                }
            }
        }
        
        $mail->Subject = $subscribe_form['subject'];
        $mail->Body = $message_body; // 'This is the HTML message body <b>in bold!</b>'
        // $mail->AltBody = $message_body; // 'This is the body in plain text for non-HTML mail clients';
        // print_r($message_body);

        $mail->send();

        return [
            'status' => 'ok',
            'code' => 200,
            'email' => $recipient_email,
            'message' => get_key_value('sent_ok', $server_statuses)
        ];
    } catch (Exception $e) {
        return [
            'status' => 'error',
            'code' => 500,
            'email' => $recipient_email,
            'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"
        ];
    }
}

// Create the endpoint.
add_action('rest_api_init', function () use ($namespace) {
    $route = '/subscriber/add';
    $args = [
        'methods' => 'POST',
        'callback' => 'add_subscriber',

        // If your REST API endpoint is public, you can use __return_true as the
        // permission callback.
        // https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/#permissions-callback
        'permission_callback' => '__return_true'
    ];
    register_rest_route($namespace, $route, $args);
});
