<?php
require $_SERVER["DOCUMENT_ROOT"] . '/To-Do-List/vendor/autoload.php';

require $_SERVER["DOCUMENT_ROOT"] . '/To-Do-List/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable($_SERVER["DOCUMENT_ROOT"] . '/To-Do-List/');
$dotenv->load();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing Table</title>
</head>
<body>
    <style>
        .skip 
        {
        border: 1px solid transparent;
        background: rgb(125, 125, 235);
        cursor: pointer;
        border-radius: 10px;
        text-align: center;
        font-size: 15px;
        padding: 10px 10px;
        justify-content: center;
        width: 25%;
        margin-left: 475px;
        display: flex; /* Use flexbox to center the link */
        align-items: center; /* Vertically center the text */
        justify-content: center; /* Horizontally center the text */
        cursor: pointer;
        }
        .skipPage 
        {
            text-decoration: none;
            color: white;
            display: block; /* Make the link fill the entire parent div */
            width: 100%; /* Ensure it takes the full width */
            height: 100%; /* Ensure it takes the full height */
        }
        .skip:hover
        {
            background: rgb(180, 160, 250); /* Soft lavender */
            transition: 0.4s;
        }
        @media (max-width: 400px)
        {
            .skip
            {
                margin-left: 60px;
                width: 50%;
            }
        }
    </style>
        <script async src= <?php $_ENV["API_SRC"] ?>></script>
    <stripe-pricing-table pricing-table-id= <?php $_ENV["PRICING_TABLE_ID"] ?>
    publishable-key= <?php $_ENV["STRIPE_PUBLISHABLE_KEY"] ?> >
    </stripe-pricing-table>
    <div class="skip">
        <a href="/To-Do-List/Main/tasks.php" class="skipPage">Skip for now</a>
    </div>
</body>
</html>