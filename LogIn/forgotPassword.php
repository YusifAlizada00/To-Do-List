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
    <title>Forgot Password</title>
</head>
<body>
           <!---------------------Forgot Password-------------------->
        <div class="container container3" id="forgotContainer" style="display:block; margin-top: 10rem; padding-bottom: 5rem;" >
            <h1 class="title">Forgot Password</h1>
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
            <form id="forgotPasswordForm" method="POST" action="/To-Do-List/LogIn/phpMailer/forgot-password.php" autocomplete="on"> 
                <div class="input-group">
                        <i class="fas fa-envelope" id="emailIcon"></i> 
                        <input type="email" name="email" id="forgotEmail" placeholder="Email" required autocomplete="email">
                        <label for="signInEmail">Email</label>
                    <div class="active">
                        <button class="activation" type="submit" name="password_reset_link" style="width: 200px; margin-left:70px">Send Reset Link</button>
                        <button class="btn" style="margin-top: 15px" onclick="window.location.href='/To-Do-List/LogIn/index.php'">Go Back</button>
                    </div>
                </div>
            </form> 
        </div>
</body>
</html>