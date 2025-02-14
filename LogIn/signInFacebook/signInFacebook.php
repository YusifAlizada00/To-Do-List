
<?php
session_start();

require $_SERVER["DOCUMENT_ROOT"] . '/To-Do-List/vendor/autoload.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/To-Do-List/LogIn/connect.php'; // your DB connection file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');  
$dotenv->load();

// Facebook SDK Initialization
$client = new Facebook\Facebook([
    'app_id' => $_ENV["FACEBOOK_APP_ID"], // Secure app ID from environment
    'app_secret' => $_ENV["FACEBOOK_APP_SECRET"], // Secure app secret from environment
    'default_graph_version' => $_ENV["FACEBOOK_GRAPH_VERSION"], // Ensure this matches your app configuration
]);

$helper = $client->getRedirectLoginHelper();
$facebookRedirectUrl = "http://localhost/To-Do-List/LogIn/signInFacebook/signInFacebook.php";

// Step 1: Check if the code is set (user has been redirected back from Facebook)
if (!isset($_GET['code'])) {
    $loginUrl = $helper->getLoginUrl($facebookRedirectUrl, ['email']);
    header('Location: ' . filter_var($loginUrl, FILTER_SANITIZE_URL));
    exit();
}

// Step 2: Fetch the access token after successful authentication
try {
    $token = $helper->getAccessToken();
} catch (Facebook\Exceptions\FacebookResponseException $e) {
    die('Facebook API Error: ' . $e->getMessage());
} catch (Facebook\Exceptions\FacebookSDKException $e) {
    die('Facebook SDK Error: ' . $e->getMessage());
}

// Check if token is valid
if (!$token) {
    die('Error: No access token found.');
}

// Step 3: If token is short-lived, exchange it for a long-lived token
if ($token->getExpiresAt() && $token->getExpiresAt()->getTimestamp() < time()) {
    $longLivedTokenUrl = "https://graph.facebook.com/v21.0/oauth/access_token?" .
    "grant_type=fb_exchange_token&" .
    "client_id=" . $_ENV("FACEBOOK_APP_ID") . "&" .
    "client_secret=" . $_ENV("FACEBOOK_APP_SECRET") . "&" .
    "fb_exchange_token=" . $token->getValue();

    
    $response = file_get_contents($longLivedTokenUrl);
    if ($response === FALSE) {
        die('Error in token exchange.');
    }
    
    $data = json_decode($response, true);
    
    if (isset($data['access_token'])) {
        $longLivedToken = $data['access_token'];
        $client->setDefaultAccessToken($longLivedToken);
    } else {
        die('Error: Long-lived token exchange failed.');
    }
} else {
    // Set default token
    $client->setDefaultAccessToken($token->getValue());
}

// Step 4: Get the user's info from Facebook
try {
    $response = $client->get('/me?fields=id,name,email,first_name,last_name');
    $userInfo = $response->getGraphUser();
} catch (Facebook\Exceptions\FacebookResponseException $e) {
    die('Facebook API Error: ' . $e->getMessage());
} catch (Facebook\Exceptions\FacebookSDKException $e) {
    die('Facebook SDK Error: ' . $e->getMessage());
}

if (!$userInfo || !$userInfo->getEmail()) {
    die("Failed to retrieve user information or email. Please try again.");
}

// Step 5: Ensure the values exist before using them
$first_name = $userInfo->getFirstName() ? $userInfo->getFirstName() : 'Unknown';
$last_name = $userInfo->getLastName() ? $userInfo->getLastName() : 'Unknown';
$email = $userInfo->getEmail();

$_SESSION['email'] = $email;
$_SESSION['fullName'] = $userInfo->getName();
$_SESSION['firstName'] = $first_name;
$_SESSION['lastName'] = $last_name;
$_SESSION['provider'] = 'facebook';

// Log session data for debugging
error_log('Facebook Session Values: ' . print_r($_SESSION, true));

// Database insertion
$password = '';  // Facebook login does not use a password
$provider = 'facebook';

// Step 6: Check if the user already exists in the database
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
if (!$stmt) {
    die('Database error: ' . $conn->error);
}
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User exists, update provider if necessary
    $stmt = $conn->prepare("UPDATE users SET provider = ?, verify_status = 1 WHERE email = ?");
    $stmt->bind_param("ss", $provider, $email);
    $stmt->execute();
} else {
    // Insert new user into the database with verify_status = 1
    $stmt = $conn->prepare("INSERT INTO users (firstName, lastName, email, password, provider, verify_status) VALUES (?, ?, ?, ?, ?, 1)");
    $stmt->bind_param("sssss", $first_name, $last_name, $email, $password, $provider);
    $stmt->execute();
}

// Step 7: Redirect to the payment page after login
header('Location: /To-Do-List/Pricing/payment.html');
exit();
//