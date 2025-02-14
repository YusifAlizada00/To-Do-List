<?php
session_start(); // Start the session to store user-specific data

// Default image path
$defaultImagePath = '/To-Do-List/Main/user.png'; // Fallback image if no upload

// Check if an uploaded image exists in the session
$imagePath = isset($_SESSION['profile_image']) ? './uploads/' . $_SESSION['profile_image'] : $defaultImagePath;

// Handle file upload if the form is submitted
if (isset($_POST['submit'])) 
{
    $file = $_FILES['file']; // File upload array

    // Get file properties
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    // Extract file extension and convert it to lowercase
    $fileExt = explode('.', $fileName);// File extension
    $fileActualExt = strtolower(end($fileExt));

    // Allowed file types
    $allowed = array('jpg', 'jpeg', 'png', 'gif');

    // Validate file extension and handle upload
    if (in_array($fileActualExt, $allowed)) 
    {
        if ($fileError === 0) 
        {
            if ($fileSize < 5000000) // Limit file size to < 5MB
            { 
                // Generate a unique file name for the uploaded file
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                $fileDestination = './uploads/' . $fileNameNew;

                // Move the uploaded file to the desired location
                move_uploaded_file($fileTmpName, $fileDestination);

                // Store the file name in the session for later use
                $_SESSION['profile_image'] = $fileNameNew;

                // Redirect to the same page to refresh the profile image
                header("Location: profile.php?uploadsuccess");
                exit();
            } 
            else 
            {
                echo "<script>alert('Your file is too big!');
                window.history.back(); 
                </script>";
            }
        } 
        else 
        {
            echo "<script>alert('There was an error uploading your file!');
            window.history.back(); 
            </script>";

        }
    } 
    else 
    {
        echo "<script>alert('You cannot upload files of this type!');;
        window.history.back(); 
        </script>"; // window.history.back(); this function gets me back to the original page since it goes away when i click ok in alert
    }
}


//Deletion of the image

if (isset($_POST['delete'])) 
{
    if (isset($_SESSION['profile_image'])) 
    {
        $fileToDelete = './uploads/' . $_SESSION['profile_image'];
        if (file_exists($fileToDelete)) 
        {
            unlink($fileToDelete); // Delete the file
        }
        unset($_SESSION['profile_image']);
    }
    header("Location: profile.php?deletesuccess");
    exit();
}
?>