<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css"/>
    <script src="script.js"></script>
    <title>Reset Password</title>
</head>
<body>
<div class="container" id="forgotContainer" style="display:block; margin-top: 10rem; padding-bottom: 5rem;" >
    <h1 class="title">Reset Password</h1>
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
            <br>
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
            <br>
    <form action="/To-Do-List/LogIn/phpMailer/forgot-password.php" method="POST">
        <input type="hidden" name="password_token" value="<?php if(isset($_GET['token'])){echo $_GET['token'];} ?>">
    <div class="input-group">
        <i class="fas fa-envelope"></i> 
        <input type="email" name="email" id="forgotEmail" value="<?php if(isset($_GET['email'])){echo $_GET['email'];} ?>" placeholder="Email" required autocomplete="email">
        <label for="signInEmail">Email</label>
    </div>
    <div class="passwords">
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="new_password" id="forgotPassword" placeholder="Password" required>
            <label for="forgotPassword">New Password</label>
            <i class="fas fa-eye" id="toggleForgotPassword" style="cursor: pointer;" onclick="registerLogin_Function.forgotPassword()"></i>
        </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="confirm_password" id="confirmPassword" placeholder="Password" 
                required autocomplete="current-password">
                <label for="confirmPassword">Confirm Password</label>
                <i class="fas fa-eye" id="toggleConfirmPassword" style="cursor: pointer;" onclick="registerLogin_Function.forgotPassword()"></i>
            </div>
        </div>
        <input type="submit" id="loginBtn" class="forgotBtn" value="Update Password" name="update_password">
  
        <a href="/To-Do-List/LogIn/index.php" id="goBack" class="goBack">Go Back</a> 
    </form>
    </div>
</body>
</html>