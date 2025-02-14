<?php
// Handle file deletion
if (isset($_POST['delete'])) {
    if (isset($_SESSION['profile_image'])) {
        $fileToDelete = './uploads/' . $_SESSION['profile_image'];
        if (file_exists($fileToDelete)) {
            unlink($fileToDelete); // Delete the file
        }
        unset($_SESSION['profile_image']);
    }
    header("Location: profile.php?deletesuccess");
    exit();
}
?>