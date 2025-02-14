<?php 
    session_start();
    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/connect.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
// Google Client
$client = new Google\Client();
$client->setClientId($_ENV["GOOGLE_CLIENT_ID"]);
$client->setClientSecret($_ENV["GOOGLE_CLIENT_SECRET"]);
$client->setRedirectUri($_ENV["GOOGLE_REDIRECT_URI"]);
$client->addScope("email");
$client->addScope("profile");
//$url = $client->createAuthUrl();
$client->setPrompt("select_account");
$authUrl = $client->createAuthUrl();



// Facebook SDK Initialization
$fb = new \Facebook\Facebook([
    'app_id' => $_ENV["FACEBOOK_APP_ID"], // Your Facebook app ID
    'app_secret' => $_ENV["FACEBOOK_APP_SECRET"], // Your Facebook app secret
    'default_graph_version' => $_ENV["FACEBOOK_GRAPH_VERSION"], // The graph version
]);

$helper = $fb->getRedirectLoginHelper();
$facebookRedirectUrl = $_ENV["FACEBOOK_REDIRECT_URI"];

// Generate the login URL with required permissions
$facebookLoginUrl = $helper->getLoginUrl($facebookRedirectUrl, ['email']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogIn</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css"/>
    <script src="script.js" defer></script>
</head> 
<body onload="registerLogin.signInPassword()">

    <?php if(isset($_SESSION['access_token'])) ?>
    <div class="container" id="signIn" style="display: block;">
        <h1 class="title">LogIn</h1>
        <form method="post" action="register.php" autocomplete="on">
            <div class="input-group">
                <i class="fas fa-envelope"></i> 
                <input type="email" name="email" id="signInEmail" placeholder="Email" required autocomplete="email">
                <label for="signInEmail">Email</label>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="signInPasswordInput" placeholder="Password" required autocomplete="current-password">
                <label for="signInPasswordInput">Password</label>
                <i class="fas fa-eye" id="toggleSignInPassword" style="cursor: pointer;" onclick="registerLogin_Function.signInPassword()"></i>
            </div>

            <?php
            if(isset($_SESSION['success']))
            {
                ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>Success!</strong> <?php echo $_SESSION['success']; ?>
                </div>
                <?php
                unset($_SESSION['success']);
            }
            ?>
            
            <?php
            if(isset($_SESSION['error']))
            {
                ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>Danger!</strong> <?php echo $_SESSION['error']; ?>
                </div>
                <?php
                unset($_SESSION['error']);
            }
            ?>

            <div class="recover">
                <p><a href="/To-Do-List/LogIn/forgotPassword.php" id="forgotPass">Forgot Password</a></p>
            </div>
            <input type="submit" id="SignIn" class="btn" value="Sign In" name="signIn">
        </form>
        <p class="or">----------or----------</p>
        <div class="icons">
            <a href="<?php echo $facebookLoginUrl ?>"><i class="fab fa-facebook"></i></a>
            <a href="<?php echo $authUrl ?>"><i class="fab fa-google"></i></a>
        </div>
        <div class="links">
            <p class="account">Don't you have an account?</p>
            <a href="/To-Do-List/LogIn/signUp.php" class="signUpBtn" id="signUpButton">Sign Up</a>
        </div>
    </div>
</body>
</html>


