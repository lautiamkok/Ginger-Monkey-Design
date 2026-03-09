<?php
/**
 * Custom JSON API endpoint.
 * https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/
 */

// Add a subscriber to mailchimp.
function get_stockists_csv ($data) {
    $rows = [];

    // Get the params from the route.
    $attachment_id = $data->get_param('attachment_id');

    // Get full path of the attachment.
    // https://developer.wordpress.org/reference/functions/get_attached_file/
    $attachment_path = get_attached_file($attachment_id);
    if (!$attachment_path) {
        return $rows;
    }

    $handle = fopen($attachment_path, 'r');
    if ($handle) {
        // Skip the UTF-8 BOM
        fseek($handle, 3); 

        // Read the header line.
        $header = fgetcsv($handle);

        // Make all values in array to lowercase.
        $header = array_map('strtolower', $header);

        // Loop over the remaining lines.
        while (($line = fgetcsv($handle)) !== FALSE) {
            // Combine the header with the current line to form an associative array.
            $row = array_combine($header, $line);
            // print_r($row);

            // Push the row to array only if longitude and latitude are not empty.
            if (isset($row['longitude']) && isset($row['latitude'])) {
                if ($row['longitude'] && $row['latitude']) {
                    $rows[] = $row;
                }
            } else {
                $rows[] = $row;
            }
        }

        // Close the file handle.
        fclose($handle);
    }
    return $rows;
}

// Create the endpoint.
add_action('rest_api_init', function () use ($namespace) {
    $route = '/get-stockists/csv/(?P<attachment_id>[0-9-]+)';
    $args = [
        'methods' => 'GET',
        'callback' => 'get_stockists_csv',

        // If your REST API endpoint is public, you can use __return_true as the
        // permission callback.
        // https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/#permissions-callback
        'permission_callback' => '__return_true'
    ];
    register_rest_route($namespace, $route, $args);
});
