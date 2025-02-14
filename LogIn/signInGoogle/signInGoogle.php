<?php
// Start the session and store the user info
session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/To-Do-List/vendor/autoload.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/To-Do-List/LogIn/connect.php'; // your DB connection file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');  
$dotenv->load();

// Google Client setup
$client = new Google\Client();
$client->setClientId($_ENV["GOOGLE_CLIENT_ID"]);
$client->setClientSecret($_ENV["GOOGLE_CLIENT_SECRET"]);
$client->setRedirectUri($_ENV["GOOGLE_REDIRECT_URI"]);

if (!isset($_GET['code'])) {
    // Step 1: Redirect to Google OAuth if no code is present
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
    exit();
}

$token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);

if (isset($token['error'])) {
    exit('Error fetching access token: ' . $token['error']);
}

if (!isset($token["access_token"])) { //If the code does not contain a valid access token
    exit("Access token is missing or invalid.");
}

$client->setAccessToken($token["access_token"]);

$oauth = new Google\Service\Oauth2($client);
$userInfo = $oauth->userinfo->get(); // This fetches the user's profile information, like: email, name, and other basic details.

if (!$userInfo || !isset($userInfo->email)) { //If the userInfo object is empty or doesn't contain an email, it will stop and display an error
    exit("Failed to retrieve user information. Please try again.");
}
$_SESSION['email'] = $userInfo->email;
$_SESSION['fullName'] = $userInfo->name;
$_SESSION['firstName'] = $userInfo->givenName;
$_SESSION['lastName'] = $userInfo->familyName;
$_SESSION['provider'] = 'google'; // Set the provider to 'google'

// Now insert this data into your database
$email = $_SESSION['email'];
$first_name = $_SESSION['firstName'];
$last_name = $_SESSION['lastName'];
$password = ''; // If you don't want to store a password for Google login, you can leave it empty or generate a random password
$provider = 'google'; // For Google login

// Check if the user already exists in the database
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User already exists, update provider if necessary
    $stmt = $conn->prepare("UPDATE users SET provider = ?, verify_status = 1 WHERE email = ?");
    $stmt->bind_param("ss", $provider, $email);
    $stmt->execute();
} else {
    // Insert new user into the database with verify_status = 1
    $stmt = $conn->prepare("INSERT INTO users (firstName, lastName, email, password, provider, verify_status) VALUES (?, ?, ?, ?, ?, 1)");
    $stmt->bind_param("sssss", $first_name, $last_name, $email, $password, $provider);
    $stmt->execute();
}

// Redirect to payment page after login
header('Location: /To-Do-List/Pricing/payment.html');
exit();
?>
