<?php
// Set the salt value (securely store this on the server)
define('SALT', 'MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCzbv3l6yhE8LYVmJWZ5pHSq9SZYWbyuYmi7zWFDwHzj29M30WLzgrHbQZAGvvU5FLDydB7s7ON/vZoISWTiB0QWSAtqc75DiHVLFwgK90OFV9/3m01yml+HRS6Vvbh0w8w/uw61gLdHWzxP7bOJh248WtS9KtfYyKN0bo87vDJ4ORn3Zr3OpEvxUi63Pju+BZSx049767/0bfTP0pUKyeJejXr2O4GASUCRyRak+Qq5z0KC7b6NVaxMCB/XQBW8/3KF5UXYvfaFL1P44APg1pMfq+rFCBoktWWV/yO7H8QKw721CiXDeLUbaESayh2IbgX7iSz2Hv8Xlcgh4HjoPspAgMBAAECggEAXvP4ZkhIGhtrsAf7+uJZ/qsxqS0zJnVq0Y9WuiAT/0jDNGHe0rnpWFloeloNND7TUYqlyiBxf04SJU6NLQJVpwYTEjcPMRr6am28HsY3h7FlxSv2jQWdR8Cp7GYC5cQkAOCWMBh6kXp14UC/Q15GUk1nZxHU8nhqm7QFoyMqxxlYqE9I3BsseWTBAFeN/TxkJzvI/94UNtreiidMkr7btwQtNE9QwYLNpzbnqyDSAG+vymYBJgHAI005K/mm11swzM4LA+3XaqfOYXevlYb9eHLFUKOTHRTKKWN8OsHdOMhzKh3i13DGwOiWb34WM9R84QjMO0Qc6kqDtRD11/TWEQKBgQDtCcdjMg1wq10zTVuuppDzI/PkjWAYdOKJOyNsnSw7+70nUcgjpurk1bvuUB2rfnGncKwOsF5phtvD0xcPlUPlMLawGK/qLzzH2mRP0Z/oKeqqPtnAPzKT46D5Jf4ZFP8vYDOsYwZ47TReNmn5VYX1z7plDZsP4CSxrV/fH11LLQKBgQDByYxKxl1NXQgZK2RDbyzopl7miWEEZUfD5qCzBuQA6NIGxDIaX8TvJX2DA/wMVKpRC8Cjw3G1mLfY42/atTKyaosriIlSptscSLKX4JiVAJld/53USnnD+VgkEk7S6dlqEdjSUk+am+3gy3OIvXvUEzwDlrxxYpVEKfYx2999bQKBgQCyOIcEqy51xzJ1DzXe0/fqB98pua5F1SQ6oA9ba7VFiFpJBPFg9PBpi9YYMX6NYa2cglerV6o016PG0aDmI4l/+idxsa4aetfNQAPqC6eaTGHXDRh1tk6V6TEwAwPQ4fuYKFHRzEaih163c1wsjsQA9OWlcxxiTFnqiXuq7A8eJQKBgEAnOQqIINs7sTKj6s1oQLXEXiZz1GpgHSH9d7XM0i565QzYZr3Udp21C5gT+Z0bakbqXRvZ2AsGQ9bJdH4y/lWScAA5czypgGAcsQMWl2y8hglYViexgB4grc1DQlUQlalHvz/hf/jvJhEFSXo7QIM02ulVPY1L1Z57RcW7xIEBAoGAYQCBIpXl+Ytn6ZtAATwazrAWpZ9LTV9hWtrbGQJfMb9Gg6KmQBtUcRts6ifvWQqo6xlVxEobkI62QfRJFHKWXu0jVkKmEazDYT5mVKl+GDTMpwLdamxFh/blFjY+9im4P4J5yVvwIE6nxWU3V4YFNWjSZN/GBQZCfeC+ViyD3N8=');

// Handle POST request to generate hash
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['data'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required field: data']);
        exit;
    }

    try {
        // Concatenate the data with the salt and generate the hash
        $data = $input['data'];
        $hash = hash('sha512', $data . SALT);

        // Return the hash
        echo json_encode(['hash' => $hash]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error generating hash']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
