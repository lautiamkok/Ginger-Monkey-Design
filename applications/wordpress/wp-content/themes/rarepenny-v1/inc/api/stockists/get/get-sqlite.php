<?php
/**
 * Custom JSON API endpoint.
 * https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/
 */

// Add a subscriber to mailchimp.
function get_stockists_sqlite ($data) {
    $rows = [];

    // Get the params from the route.
    $attachment_id = $data->get_param('attachment_id');

    // Get full path of the attachment.
    // https://developer.wordpress.org/reference/functions/get_attached_file/
    $attachment_path = get_attached_file($attachment_id);
    if (!$attachment_path) {
        return $rows;
    }

    // Using PDO.
    // Specify your sqlite database name and path.
    $dir = 'sqlite:' . $attachment_path;

    // Instantiate PDO connection object and failure msg.
    $dbh = new PDO($dir) or die('cannot open database');

    // Get all table names and only take the first one.
    // https://stackoverflow.com/a/23577001/413225
    $query_tables = "SELECT name FROM sqlite_master WHERE type='table'";
    $table_first = null;
    foreach ($dbh->query($query_tables) as $row) {
        $table_first = $row['name'];
    }

    // Get all the data from the first table.
    $query_data = "SELECT * FROM '" . $table_first ."'";
    foreach ($dbh->query($query_data) as $row) {
        $rows[] = $row;
    }
    return $rows;
}

// Create the endpoint.
add_action('rest_api_init', function () use ($namespace) {
    $route = '/get-stockists/sqlite/(?P<attachment_id>[0-9-]+)';
    $args = [
        'methods' => 'GET',
        'callback' => 'get_stockists_sqlite',

        // If your REST API endpoint is public, you can use __return_true as the
        // permission callback.
        // https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/#permissions-callback
        'permission_callback' => '__return_true'
    ];
    register_rest_route($namespace, $route, $args);
});
