<?php

function testContactForm()
{
    $url = 'http://127.0.0.1:8080/contact';
    $data = [
        'email' => 'test@example.com',
        'subject' => 'Test Subject',
        'message' => 'This is a test message.'
    ];

    $options = [
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode($data)
    ];

    $ch = curl_init();
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo "HTTP Code: $httpCode\n";
    echo "Response: $response\n";

    // Capture the timestamp at the time of request
    $timestamp = time();
    $filename = sprintf(__DIR__ . '/app/var/contacts/%s_%s.json', $timestamp, $data['email']);

    // Allow some time for the file to be created
    sleep(1);

    if (file_exists($filename)) {
        echo "File created: $filename\n";
    } else {
        echo "File not created.\n";
    }
}

testContactForm();
