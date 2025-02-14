<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css"/>
    <script src="script.js" defer></script>
</head> 
<body>


<?php

//session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/To-Do-List/LogIn/connect.php';
require $_SERVER["DOCUMENT_ROOT"] . '/To-Do-List/LogIn/phpMailer/mailer.php';


if (isset($_POST['signIn']))
{
    $emailLogIn = $_POST['email'];
    $password = $_POST['password'];

    // Query the database for the user by email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $emailLogIn);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc(); //Means make sure it returns assocative array

        if (password_verify($password, $row['password']))
        {
            if($row['verify_status'] == 1)
            {
                //hashes password and compares it with the one in the database
                // Password is correct, start session
                $_SESSION['email'] = $row['email']; 
                /*?>
                        <script>
                            localStorage.add("", <?php echo ?>)
                        </script>
                <?php
                */
                header("Location: /To-Do-List/Pricing/payment.html");
                exit();
            }
            else
            {
                $_SESSION['error'] = "Please Verify your account before logging in!";
                header("Location: /To-Do-List/LogIn/index.php");
            }
        } 
        else
        {
            $_SESSION['error'] =  "Check your password and try again, If you have a problem Reset it now!";
            header("Location:  /To-Do-List/LogIn/index.php");
        }
    }
    else
    {   
        $_SESSION['error'] =  "Check your password and try again, If you have a problem Reset it now!";
        header("Location:  /To-Do-List/LogIn/index.php");
    }
}

?>

