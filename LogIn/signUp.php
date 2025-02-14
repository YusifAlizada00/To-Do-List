<?php
    session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css"/>
    <script src="script.js" defer></script>
</head> 
<body>

    
    <!--------------------------Sign Up Page----------------------------->
    <div class="container container2" id="signUp" style="display: block;">
        <h1 class="title">Register</h1>

                    <!--Doing alerts using bootstrap-->

        <form method="post" action="register.php" autocomplete="on">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="fname" id="fname" placeholder="First Name" required>
                <label for="fname">First Name</label>
            </div>
            <div class="input-group"> 
                <i class="fas fa-user"></i>
                <input type="text" name="lname" id="lname" placeholder="Last Name" required>
                <label for="lname">Last Name</label>
            </div>
            <div class="input-group">
                <i class="fas fa-envelope"></i> 
                <input type="email" name="email" id="email" placeholder="Email" required autocomplete="email">
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="signUpPasswordInput" placeholder="Password" 
                required autocomplete="current-password">
                <label for="signUpPasswordInput">Password</label>
                <i class="fas fa-eye" id="toggleSignUpPassword" style="cursor: pointer;" onclick="registerLogin_Function.signUpPassword()"></i>
            </div>

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

            <input type="submit" class="btn" value="Sign Up" name="signUp">
        </form>
        <p class="or">----------or----------</p>
        <div class="icons">
            <i class="fab fa-google"></i>
            <i class="fab fa-facebook"></i>
        </div>
    <div class="links">
            <p>Already have an account?</p>
            <a href="/To-Do-List/LogIn/index.php" class="signInBtn" id="signInButton">Sign In</a>
        </div>
</div>

</body>
</html>