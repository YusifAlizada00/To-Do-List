<?php
    // Include the header
    require $_SERVER["DOCUMENT_ROOT"].'/To-Do-List/Main/header.php';
?>
<?php
    // Start the session and load translations as before
    if (isset($_GET['lang'])) {
        $_SESSION['lang'] = $_GET['lang']; // Store selected language in session
    }
    $lang = $_SESSION['lang'] ?? 'en'; // Default to English if no language is selected
    $translations = json_decode(file_get_contents('translations.json'), true);

    // Set the page ID dynamically (you might pass this via the URL, or get it from your JSON structure)
    $pageId = "Birthday"; // This should be dynamically set based on user interaction

    // Get the translated title for the current page
    $translatedTitle = $translations[$lang][$pageId] ?? $translations['en'][$pageId]; // Fallback to English if not found
?>



<h1 class="h1"><?php echo $translatedTitle ?></h1>

<?php
    // Include the footer
    require $_SERVER["DOCUMENT_ROOT"].'/To-Do-List/Main/footer.php';
?>
