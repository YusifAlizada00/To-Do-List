<?php
// Start the session
session_start();

// Set language based on GET parameter or use default
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang']; // Store selected language in session
}
$lang = $_SESSION['lang'] ?? 'en'; // Default to English if no language is selected

// Read the translations from the JSON file
$translations = json_decode(file_get_contents('translations.json'), true);

// Define $pageId based on the current page or request (adjust as necessary)
$pageId = basename($_SERVER['PHP_SELF'], '.php'); // Extracts the filename without the extension

?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link rel="stylesheet" href="main.css">
    <script src="main.js" defer></script>
    <title><?php echo $translations[$lang]['Tasks']; ?></title> <!-- Set page title dynamically -->
</head>
<body class="body" id="bodyAll">
    
    <ul id="list-container">
        <?php
        // Read the JSON file for menu items
        $readFile = file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/To-Do-List/Main/pages.json');
        $menuData = json_decode($readFile, true);

        // Loop through the menu items
        foreach ($menuData['menuItems'] as $menuId => $menuItem) {
            $menuTitle = $menuItem["title"];
            $menuHref = $menuItem["href"];

            // Check if the translation exists, otherwise use the English version
            $translatedTitle = $translations[$lang][$menuTitle] ?? $translations['en'][$menuTitle];

            echo "<a href='$menuHref' target='_self' class='menu-item " . (strtolower($menuTitle) == strtolower($pageId) ? 'selected' : '') . "'> 
                    <li>" . $translatedTitle . "</li> 
                  </a>";
        }
        ?>
        </ul>
<?php
        ?>
        
        <!-- Language Switcher Form -->
        <form action="" method="GET" class="lang-form" style="position: sticky; float: right;">
            <select name="lang" onchange="this.form.submit()">
                <option value="en" <?php echo ($lang == 'en') ? 'selected' : ''; ?>>English</option>
                <option value="az" <?php echo ($lang == 'az') ? 'selected' : ''; ?>>Azerbaijani</option>
                <option value="tr" <?php echo ($lang == 'tr') ? 'selected' : ''; ?>>Turkish</option>
                <option value="fr" <?php echo ($lang == 'fr') ? 'selected' : ''; ?>>French</option>
                <option value="ar" <?php echo ($lang == 'ar') ? 'selected' : ''; ?>>Arabic</option>
                <option value="zh" <?php echo ($lang == 'zh') ? 'selected' : ''; ?>>Chinese</option>
                <option value="nl" <?php echo ($lang == 'nl') ? 'selected' : ''; ?>>Dutch</option>
                <option value="es" <?php echo ($lang == 'es') ? 'selected' : ''; ?>>Spanish</option>
                <option value="ru" <?php echo ($lang == 'ru') ? 'selected' : ''; ?>>Russian</option>
            </select>
        </form>
</body>
</html>
