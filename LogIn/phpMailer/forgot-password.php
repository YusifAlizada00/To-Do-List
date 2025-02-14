<?php
    session_start();
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    //Load Composer's autoloader
    require $_SERVER['DOCUMENT_ROOT'] . '/To-Do-List/vendor/autoload.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/To-Do-List/LogIn/connect.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');  
    $dotenv->load();
    

function send_password_reset($get_email, $token)
{
    $mail = new PHPMailer(true);
    try 
    {
        //Server settings
        $mail->SMTPDebug = 0/*SMTP::DEBUG_SERVER*/;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $_ENV["EMAIL_ADDRESS"];                     //SMTP username
        $mail->Password   = $_ENV["APP_PASSWORD"];                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($_ENV["EMAIL_FROM"], $_ENV["NAME"]);
        //$mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
        $mail->addAddress($get_email);               //Name is optional
        $mail->addReplyTo($_ENV["EMAIL_FROM"], $_ENV["NAME"]);
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Password Reset Verification';
        
        $email_template = "
        <h2>Hello</h2>
        <h4>We recieved Password Reset Request from your Account.</h4>
        <h5>Please click the link given below to Reset in now!</h5>
        <br><br>
        <a href='http://localhost/To-Do-List/LogIn/reset-password.php?token=$token&email=$get_email'>Reset Password</a>";
        $mail->Body = $email_template;
        if($mail->send())
        {
            $_SESSION["success"] =  'Message has been sent, Please check your Email';
            header("Location: /To-Do-List/LogIn/forgotPassword.php");
        }
    } 
    catch (Exception $e) 
    {
        $_SESSION["error"] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        header("Location: /To-Do-List/LogIn/forgotPassword.php");
    }
}


    if(isset($_POST['password_reset_link']))
    {
        //We use mysqli_real_escape_stirng() function to prevent SQL Injection .
        //It escapes from some characters that are special in SQL Query like: quotes or backslashes etc.
        //It treats characters as data not part of SQL Query.
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $token = md5(rand());

        $check_email = "SELECT email FROM users WHERE email = '$email' LIMIT 1";
        $check_email_run = mysqli_query($conn, $check_email);

        if(mysqli_num_rows($check_email_run) > 0)
        {
            $row = mysqli_fetch_array($check_email_run);
            $get_email = $row['email'];

            $update_token = "UPDATE users SET verify_token='$token' WHERE email='$get_email' LIMIT 1";
            $update_token_run = mysqli_query($conn, $update_token);

            if($update_token_run)
            {
                send_password_reset($get_email, $token);
                $_SESSION['success'] = "Your reset mail was sent, Please check you email";
                header("Location: /To-Do-List/LogIn/forgotPassword.php");
                exit();
            }
            else
            {
                $_SESSION['error'] = "Something went wrong";
                header("Location: /To-Do-List/LogIn/forgotPassword.php");
                exit();
            }
        }
        else
        {
           $_SESSION['error'] = "No Email Found";
           header("Location: /To-Do-List/LogIn/forgotPassword.php");
           exit(); 
        }
    }


    if(isset($_POST['update_password']))
    {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
        $token = mysqli_real_escape_string($conn, $_POST['password_token']);
    
        if(!empty($token))
        {
            if(!empty($email) && !empty($new_password) && !empty($confirm_password))  // Check plain text password here
            {
                // Checking if the token is valid or not
                $check_token = "SELECT verify_token FROM users WHERE verify_token='$token' LIMIT 1";
                $check_token_run = mysqli_query($conn, $check_token);
    
                if(mysqli_num_rows($check_token_run) > 0)
                {
                    if($new_password == $confirm_password)  // Compare plain text passwords
                    {
                        // Update password in database
                        $update_password = "UPDATE users SET password='$new_password_hash' WHERE verify_token='$token' LIMIT 1";
                        $update_password_run = mysqli_query($conn, $update_password);
    
                        if($update_password_run)
                        {
                            // Generate new token and update
                            $new_token = md5(rand()) . "Todo";
                            $update_to_new_token = "UPDATE users SET verify_token='$new_token' WHERE verify_token='$token' LIMIT 1";
                            $update_to_new_token_run = mysqli_query($conn, $update_to_new_token);
    
                            $_SESSION['success'] = "Successfully Updated!";
                            header("Location: /To-Do-List/LogIn/index.php");
                            exit();
                        }
                        else
                        {
                            $_SESSION['error'] = "Could not update password, something went wrong!";
                            header("Location: /To-Do-List/LogIn/reset-password.php?token=$token&email=$email");
                            exit();
                        }
                    }
                    else
                    {
                        $_SESSION['error'] = "Password and Confirm Password do not match!";
                        header("Location: /To-Do-List/LogIn/reset-password.php?token=$token&email=$email");
                        exit();
                    }
                }
                else
                {
                    $_SESSION['error'] = "Invalid Token";
                    header("Location: /To-Do-List/LogIn/reset-password.php?token=$token&email=$email");
                    exit();
                }
            }
            else
            {
                $_SESSION['error'] = "All Fields are Mandatory";
                header("Location: /To-Do-List/LogIn/reset-password.php?token=$token&email=$email");
                exit();
            }
        }
        else
        {
            $_SESSION['error'] = "No Token Available";
            header("Location: /To-Do-List/LogIn/reset-password.php?token=$token&email=$email");
            exit();
        }
    }
    
?>