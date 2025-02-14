<?php
    // Include the header
    require $_SERVER["DOCUMENT_ROOT"].'/To-Do-List/Main/header.php';
    $pageId = "All";
?>

<h1 class="h1" id="all"><?php echo $translations[$lang]['All'] ?? $translations['en']['All']; ?></h1>

<?php
    // Include the footer
    require $_SERVER["DOCUMENT_ROOT"].'/To-Do-List/Main/footer.php';
?>
