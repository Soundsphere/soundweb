<?php
// get_iracing_stats.php
// Authenticate with iRacing and output your current iRating/SR as JSON.

$username = getenv('IRACING_USER');
$password = getenv('IRACING_PASS');
$cust_id  = getenv('IRACING_CUST_ID'); // your customer ID

// Login request to obtain a cookie.
$loginCurl = curl_init('https://members-ng.iracing.com/auth');
curl_setopt_array($loginCurl, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => json_encode(['email' => $username, 'password' => $password]),
    CURLOPT_HTTPHEADER     => ['Content-Type: application/json']
]);
$response = curl_exec($loginCurl);
curl_close($loginCurl);

if (!$response) {
    http_response_code(500);
    echo json_encode(['error' => 'Login failed']);
    exit;
}

// Fetch member stats
$statsCurl = curl_init("https://members-ng.iracing.com/data/stats/member_career?cust_id=$cust_id");
curl_setopt_array($statsCurl, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER     => ['Cookie: iRacingAuth=' . json_decode($response, true)['authcode']]
]);
$statsJson = curl_exec($statsCurl);
curl_close($statsCurl);

$stats = json_decode($statsJson, true);
echo json_encode([
    'iRating'       => $stats['iRating'],
    'safetyRating'  => $stats['safety_rating']
]);
