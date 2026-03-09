<?php
// 1. Create a form from the Form builder at:
// https://us1.admin.mailchimp.com/lists/dashboard/signup-forms?id=1644450
//
// 2. Grab the embedded code from Embedded forms at:
// https://us1.admin.mailchimp.com/lists/integration/embeddedcode?id=1644450
//
// 3. Create your API key at:
// https://us1.admin.mailchimp.com/lists/integration/embeddedcode?id=1644450
// https://us1.admin.mailchimp.com/account/api/
//
// Note that the server prefix URL (us1) and the id from your Mc account might be different from above.
//
// Email automation:
// https://mailchimp.com/help/create-an-automated-welcome-email/
//
// Contact types:
// https://mailchimp.com/help/about-your-contacts/
//
// Code references:
// https://gist.github.com/marciotoledo/ffd05c6caad655b13368eb82f6132107
// https://stackoverflow.com/questions/30481979/adding-subscribers-to-a-list-using-mailchimps-api-v3
// https://rudrastyh.com/mailchimp-api/get-all-list-subscribers.html
// https://rudrastyh.com/mailchimp-api/get-lists.html#mailchimp_api_connect
function call_mailchimp(
    $data,
    $api_key,
    $list_id,
    $method = 'GET'
) {
    $contact_id = md5(strtolower($data['email_address']));
    $data_center = substr($api_key,strpos($api_key,'-') + 1);
    $url = 'https://' . $data_center . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . $contact_id;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $api_key);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // Send the post data if it is not a GET method.
    if ($method !== 'GET') {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $response = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return [
        'code' => $code,
        'data' => json_decode($response, true)
    ];
}
