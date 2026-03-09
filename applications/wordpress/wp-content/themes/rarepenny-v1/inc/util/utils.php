<?php
// Rules: Function names use underscores between words, while class names use
// both the camelCase and PascalCase rules.
// https://www.php.net/manual/en/userlandnaming.rules.php

// Get the url of any attachment, image, file, video, etc.
// https://developer.wordpress.org/reference/functions/wp_get_attachment_url/
function get_asset_url($attachment_id) {
    return wp_get_attachment_url($attachment_id);
}

// Get the image by different sizes: (Default WordPress Image Sizes) full,
// 2048x2048, 1536x1536, medium, large, medium_large, thumbnail.
// https://developer.wordpress.org/reference/functions/wp_get_attachment_image_src/
// https://bloggerpilot.com/en/disable-wordpress-image-sizes/
function get_image_url($attachment_id, $size = '') {
    $data = wp_get_attachment_image_src($attachment_id, $size);
    if (!is_countable($data)) {
        return false;
    }
    return $data[0];
}

// Get asset (image, file, video, etc) data and its sizes (image only).
// https://developer.wordpress.org/reference/functions/wp_get_attachment_metadata/
function get_asset_data($attachment_id) {
    if (!$attachment_id) {
        return false;
    }
    $data = wp_get_attachment_metadata($attachment_id);
    if (!$data) {
        return false;
    }
    $uploads_baseurl = wp_upload_dir()['baseurl'];

    // Push more keys to the data.
    $data['url'] = $uploads_baseurl . '/' . $data['file'];
    $data['mime_type'] = $data['mime_type'] ?? get_post_mime_type($attachment_id);

    // Push the `url` key to the sizes (image only).
    if ($data['sizes']) {
        foreach($data['sizes'] as $key => &$size) {
            // Change the 'mime-type' default to 'mime_type' so that it is
            // consistent with other assets, such as videos..
            $size['mime_type'] = $size['mime-type'];
            unset($size['mime-type']);

            $size['url'] = $uploads_baseurl . '/' . $data['file'];
        }
    }
    return $data;
}

// Convert objects to an array.
function to_array($items) {
    return json_decode(json_encode($items), true);
}

// Search index by value and get the value by property.
function array_search_by_value(
  $array, // required
  $column, // required
  $search, // required
  $get = false // optional
) {
  $index = array_search($search, array_column($array, $column));
  if ($index === false) {
    return false;
  }
  if ($get) {
    return $array[$index][$get];
  }
  return $array[$index];
}

// Get an item from the haystack.
function get_haystack_item(string $needle = '', array $haystack = [], string $column = 'slug') {
    if (!$needle) {
        return false;
    }
    if (is_countable($haystack) === false || count($haystack) === 0) {
        return false;
    }

    // Get the index.
    $index = array_search($needle, array_column($haystack, $column));
    if ($index === false) {
        return false;
    }

    return $haystack[$index];
}

// Get the value from key-value metabox.
function get_key_value($needle = '', $haystack = []) {
    if (!$needle) {
        return false;
    }
    if (is_countable($haystack) === false || count($haystack) === 0) {
        return false;
    }

    // Get the index.
    $index = array_search($needle, array_column($haystack, 'key'));
    if ($index === false) {
        return false;
    }

    return $haystack[$index]['val'];
}

function replace_brackets($string, $classes = 'text-black') {
    // $search = ['[', ']'];
    // $replace = ['<span class="' . $classes . '">', '</span>'];
    // return str_replace($search, $replace, $string);
    $replace = [
        '[' => '<span class="' . $classes . '">',
        ']' => '</span>',
    ];
    return strtr($string, $replace);
}

function nl_to_blocks($string) {
    $lines = explode("\n", $string);
    $blocks = array_map(function($line) {
        return '<span>' . htmlspecialchars($line) . '</span>';
    }, $lines);
    return implode("\n", $blocks);
}

function to_blocks($string, $separator = "\n") {
    $lines = explode($separator, $string);
    $blocks = array_map(function($line) {
        // return '<span>' . htmlspecialchars($line) . '</span>';
        return '<span>' . $line . '</span>';
    }, $lines);
    return implode("\n", $blocks);
}

function to_tags($string, $tagname = 'li') {
    $lines = explode("\n", $string);
    $blocks = array_map(function($line) use ($tagname) {
        return "<{$tagname}>" . $line . "</{$tagname}>";
        // return "<{$tagname}>" . htmlspecialchars($line) . "</{$tagname}>";
    }, $lines);
    return implode("\n", $blocks);
}

function is_even($number) {
    if ($number % 2 == 0) {
      return true;
    }
    return false;
}

// Encrypt array as string.
// https://stackoverflow.com/questions/837417/encrypt-array-as-string
function encode_array($data) {
    return base64_encode(serialize($data));
}

function decode_array($data) {
    // When a string is not unserializeable, FALSE is returned and E_NOTICE is issued
    // You can't catch "Error at offset", unserialize() does not throw Exception
    // https://stackoverflow.com/questions/12684871/how-to-catch-unserialize-exception
    set_error_handler("exception_error_handler");
    try {
        $unserialised = unserialize(base64_decode($data));
    } catch(ErrorException $e) {
        $unserialised = false;
    }
    return $unserialised;
}

function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}

// Encrypt and decrypt string.
// https://stackoverflow.com/questions/16600708/how-do-you-encrypt-and-decrypt-a-php-string
// https://stackoverflow.com/questions/48017856/correct-way-to-use-php-openssl-encrypt
function encrypt_string(
    string $pure_string,
    string $passkey = 'passkey', 
    string $hash_algo = 'sha256', 
    string $cipher = 'AES-256-CBC', 
    $options = OPENSSL_RAW_DATA
) {
    $encryption_key = openssl_digest('passkey', $hash_algo, TRUE);
    
    $ivlen = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext_raw = openssl_encrypt($pure_string, $cipher, $encryption_key, $options, $iv);
    $hmac = hash_hmac($hash_algo, $ciphertext_raw, $encryption_key, true);
    return $iv.$hmac.$ciphertext_raw;
}

function decrypt_string(
    string $encrypted_string, 
    string $passkey = 'passkey', 
    string $hash_algo = 'sha256', 
    string $cipher = 'AES-256-CBC', 
    $options = OPENSSL_RAW_DATA
) {
    $encryption_key = openssl_digest('passkey', $hash_algo, TRUE);
    $sha2len = 32;
    
    $ivlen = openssl_cipher_iv_length($cipher);
    $iv = substr($encrypted_string, 0, $ivlen);
    $hmac = substr($encrypted_string, $ivlen, $sha2len);
    $ciphertext_raw = substr($encrypted_string, $ivlen+$sha2len);

    $calcmac = hash_hmac($hash_algo, $ciphertext_raw, $encryption_key, true);
    if (hash_equals($hmac, $calcmac)) {
        return  openssl_decrypt($ciphertext_raw, $cipher, $encryption_key, $options, $iv);
    }
    return false;
}

