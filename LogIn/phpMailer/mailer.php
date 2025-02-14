<?php
session_start();
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require $_SERVER["DOCUMENT_ROOT"] . '/To-Do-List/vendor/autoload.php';
require $_SERVER["DOCUMENT_ROOT"] . '/To-Do-List/LogIn/connect.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');  
$dotenv->load();

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);


if (isset($_POST['signUp'])) 
{
    $firstName = $_POST['fname'];
    $lastName = $_POST['lname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $verify_token = md5(rand()); //Generates the random numbers and strings

    // Check if email already exists
    $checkEmail = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkEmail);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "There was an issue with your registration. Please try again.";
        header("Location: /To-Do-List/LogIn/signUp.php");
        exit();
    } 
    else 
    {
        // Insert new user
        $insertQuery = "INSERT INTO users (firstName, lastName, email, password, verify_token) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sssss", $firstName, $lastName, $email, $password, $verify_token);

        if ($stmt->execute()) 
        {
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
                $mail->addAddress($email);               //Name is optional
                $mail->addReplyTo($_ENV["EMAIL_FROM"], $_ENV["NAME"]);
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');

                //Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Email verification from To Do List';
                
                $email_template = "
                <h2>You have successfully registered with To Do List Application</h2>
                <h5>Confirm your email address to LogIn by clicking the link given below</h5>
                <br><br>
                <a href='http://localhost/To-Do-List/LogIn/verify-email.php?token=$verify_token'>Activate Account</a>";
                $mail->Body = $email_template;
                if($mail->send())
                {
                    $_SESSION["success"] =  'Message has been sent, Please check your email';
                    header("Location: /To-Do-List/LogIn/signUp.php");
                }
            } 
            catch (Exception $e) 
            {
                $_SESSION["error"] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } 
        else 
        {
            $_SESSION['error'] = "Registration failed. Please try again.";
            header("Location: /To-Do-List/LogIn/signUp.php");
            exit();
        }
    }
}

?>