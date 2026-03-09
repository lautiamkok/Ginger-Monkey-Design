<?php
/**
 * The template used for displaying verified
 *
 * @package WordPress
 * @subpackage Menstrual 1.0
 * @since 1.0
 * @version 1.0
 */
?>

<?php
function verify() {
    $token = get_query_var('t');
    $title = '';
    $message = '';
    $decrypted_data = '';

    // When no token provided.
    if (!$token) {
        return [
          'status' => 'error',
          'code' => 400,
          'message' => 'Token is missing!',
        ];
    }


    // Decode and decrypt the data.
    $params = [];
    if ($token) {
        $decrypted_data = decrypt_string(base64_decode($token));
    }

    // Stop here if the data fails at decryption.
    if ($decrypted_data === false) {
        return [
          'status' => 'error',
          'code' => 400,
          'message' => 'Data failed at decryption!',
        ];
    }

    // Unserialise the decrypted data.
    $params = unserialize($decrypted_data);

    // Required fields.
    $fields_required = [
        'first_name',
        'last_name',
        'email_address',
    ];

    //Assume all fields are correct and set this to false if not.
    $valid = true;
    $missing_field = null;
    foreach($fields_required as $field) {
        if (!array_key_exists($field, $params)) { 
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
            'message' => 'Required fields not set!',

            // Dev only:
            // 'message' => "The '{$missing_field}' field is not set"
        ];
    }

    // Remove fields that allowed to be empty.
    // $fields_required = array_diff($fields_required, [
    //     'title_other', 
    //     'profession_other'
    // ]);
    // print_r($fields_required);

    // Stop here is any required field is empty.
    $empty_field = null;
    foreach($fields_required as $field) {
        if ($params[$field] === '') {
            $valid = false; // At least one key is empty
            $empty_field = $field;
            break;
        }
    }
    if (!$valid) {
        return [
            'status' => 'error',
            'code' => 400,
            'message' => 'Required fields not must not be empty!',

            // Dev only:
            // 'message' => "The '{$empty_field}' field must not be empty"
        ];
    }

    // Honeypot
    $name = $params['name'] ?? '';
    $email = $params['email'] ?? '';
    $telephone = $params['telephone'] ?? '';
    $fname = $params['fname'] ?? '';
    $lname = $params['lname'] ?? '';
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

    $first_name = $params['first_name'] ?? '';
    $last_name = $params['last_name'] ?? '';
    $email_address = $params['email_address'] ?? '';

    // Get the form settings.
    $forms = carbon_get_theme_option('forms');
    if (is_countable($forms) && count($forms) === 0) {
        return [
            'title' => 'Server Error',
            'message' => 'No form setting is found.'
        ];
    }

    $subscribe_setting = get_haystack_item('newsletter', $forms);
    $subscribe_server_statuses = $subscribe_setting['server_statuses'];

    // Get mailchimp info.
    $option_mailchimps = carbon_get_theme_option('mailchimp');
    if (is_countable($option_mailchimps) && count($option_mailchimps) === 0) {
        return [
            'title' => 'Server Error',
            'message' => 'No Mailchimp setting is found.'
        ];
    }
    $option_mailchimp = $option_mailchimps[0];

    // Get the api key.
    $api_key = $option_mailchimp['api_key'];
    if (!$api_key) {
        return [
            'title' => 'Server Error',
            'message' => 'Mailchimp API key not found.'
        ];
    }

    // Get all lists.
    $list_ids = $option_mailchimp['list_ids'];
    if (is_countable($list_ids) && count($list_ids) === 0) {
        return [
            'title' => 'Server Error',
            'message' => 'Mailchimp list is not found.'
        ];
    }

    // Get the list by key.
    $list_id = get_key_value('rarepenny_contact_list', $list_ids);
    if (!$list_id) {
        return [
            'title' => 'Server Error',
            'message' => 'Mailchimp list ID is empty or invalid.'
        ];
    }

    // Trace the contact via email from the URL query.
    $contact = call_mailchimp(
        [
            'email_address' => $email_address
        ],
        $api_key,
        $list_id,
    );

    // Stop here if email existed already and when the contact has already subscribed.
    if ($contact['code'] === 200 && $contact['data']['status'] === 'subscribed') {
        return [
            'message' => get_key_value('already_subscribed', $subscribe_server_statuses)
        ];
    }

    // When no contact found, inject them.
    $data = [
      'email_address' => $email_address,
      'status' => 'subscribed',
      'merge_fields' => [
          'FNAME' => $first_name,
          'LNAME' => $last_name,
          'ORIGIN' => site_url(),
      ]
    ];

    // Otherwise, update the member.
    $contact = call_mailchimp(
        $data,
        $api_key,
        $list_id,
        'PUT'
    );

    if ($contact['code'] !== 200) {
        $message = get_key_value('verify_failed', $subscribe_server_statuses);
    }

    if ($contact['code'] === 200) {
        $message = get_key_value('verify_ok', $subscribe_server_statuses);
    }

    return [
      'message' => $message,
    ];
};

// Only run the code if it is not an admin.
// https://developer.wordpress.org/reference/functions/is_user_logged_in/
$title = 'Subscription Confirmation';
$message = 'You are logged in as an admin!';
if (is_user_logged_in() === false) {
    $result = verify();

    $title = $result['title'] ?? $title;
    $message = $result['message'];
}
?>

<!-- block -->
<div class="bg-earth-dark">

  <div class="text-center py-10 border-0 border-red-500" >
    <div
      class="2xl:container mx-auto flex flex-col justify-center items-center"
      data-aos="fade-up" 
      data-aos-duration="1000"
      data-aos-delay="500"
    >
      <h1 class="w-10/12 <md:w-full text-white text-8xl <lg:text-6xl font-serif pt-5 <lg:pt-2 border-0 border-blue-500">
        <?php echo $title; ?>
      </h1>
    </div>
  </div>

</div>
<!-- block -->

<!-- block -->
<div class="py-30 px-10 <md:px-5 bg-white">
   
  <!-- container -->
  <div class="2xl:container mx-auto flex flex-col flex-wrap items-center justify-center space-y-5 border-0 border-red-500 overflow-hidden"
    data-aos="fade-right" 
    data-aos-duration="1000"
    data-aos-delay="500"
  >
    <div class="text-xl <md:text-lg w-6/12 <lg:w-10/12 <md:w-full text-center border-0 border-red-500">
      <?php echo wpautop($message); ?>
    </div>
  </div>
  <!-- container -->

</div>
<!-- block -->

<?php get_template_part('template-parts/contents/newsletter'); ?>
