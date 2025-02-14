<?php
session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/To-Do-List/LogIn/connect.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $verifyQuery = "SELECT verify_token, verify_status FROM users WHERE verify_token='$token' LIMIT 1";
    //mysqli_query sends the sql statement to MySQL database to execute
    $verifyQuery_run = mysqli_query($conn, $verifyQuery);

    if (mysqli_num_rows($verifyQuery_run) > 0) { //if the number of rows in the database is > 0 then execute these statements
        //I used mysqli_fetch_array function fetches data and store it in 1 $row variable then I can easily access it using like this:
        //$row['verify_token'];
        $row = mysqli_fetch_array($verifyQuery_run); //We've executed the SQL query above and using it below.
        if ($row['verify_status'] == 0 || $_SESSION['provider'] == 'google') 
        { //That means if still not verified then verify it where verify_token = verify_token.
            $clickedToken = $row['verify_token'];
            $update_query = "UPDATE users SET verify_status='1' WHERE verify_token='$clickedToken' LIMIT 1";
            $update_query_run = mysqli_query($conn, $update_query);

            if ($update_query_run) 
            {
                $_SESSION['success'] = "Your Account has been Successfully Verified";
                header("Location: /To-Do-List/LogIn/index.php");
                exit();
            } else 
            {
                $_SESSION['error'] = "Verification Failed";
                header("Location: /To-Do-List/LogIn/index.php");
                exit();
            }
        } else 
        {
            $_SESSION['success'] = "Email Already Verified, Please Log In";
            header("Location: /To-Do-List/LogIn/index.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "This token does not Exist";
        header("Location: /To-Do-List/LogIn/index.php");
    }
} else {
    $_SESSION['error'] = "Not Allowed";
    header("Location: /To-Do-List/LogIn/index.php");
}
?>
