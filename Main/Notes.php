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
    $pageId = "Notes"; // This should be dynamically set based on user interaction

    // Get the translated title for the current page
    $translatedTitle = $translations[$lang][$pageId] ?? $translations['en'][$pageId]; // Fallback to English if not found
?>



<h1 class="h1"><?php echo $translatedTitle ?></h1>

<form>
  <textarea id="notes" class = "notes" name="note"><?php echo $translations[$lang]['Your Notes'] ?></textarea>

</form>
  <script>
          var notesArea = document.getElementById('notes');

        // Load saved notes on page load
        window.addEventListener('DOMContentLoaded', () => {
            var savedNotes = localStorage.getItem('userNotes');
            if (savedNotes) {
                notesArea.value = savedNotes;
            }
        });

        // Save notes on input
        notesArea.addEventListener('input', () => {
            localStorage.setItem('userNotes', notesArea.value);
        });
  </script>

<footer>
    <div class="taskBar">
        <div class="taskItem" id="menu" onclick="MainJS_Function.toggleMenu()">
            <i class="fas fa-bars"></i>
            <span><?php echo $translations[$lang]['Menu']; ?></span> <!-- Translated "Menu" -->
        </div>
        <a href="/To-Do-List/Main/tasks.php" class="taskItem" id="tasks">
            <i class="fas fa-tasks"></i>
            <span><?php echo $translations[$lang]['Tasks']; ?></span> <!-- Translated "Tasks" -->
        </a>
        <a href="/To-Do-List/Main/Calendar/calendar.php" class="taskItem">
            <i class="fas fa-calendar"></i>
            <span><?php echo $translations[$lang]['Calendar']; ?></span> <!-- Translated "Calendar" -->
        </a>
        <a href="/To-Do-List/Main/profile.php" class="taskItem" id="profile">
            <i class="fas fa-user"></i>
            <span><?php echo $translations[$lang]['Profile']; ?></span> <!-- Translated "Profile" -->
        </a>
    </div>
</footer>



        <div class="menu-page" id="menuPage">
            <h2><?php echo $translations[$lang]['To-Do List'] ?></h2>
            <a href="/To-Do-List/Pricing/payment.html" class="menu-page-item">
                <img src="crown.png" alt="" width="20" height="20">
                <span><?php echo $translations[$lang]['Upgrade To Pro'] ?></span>
            </a>
            <a href="#" class="menu-page-item" onclick="MainJS_Function.toggleHiddenItems()">
                <img src="category.png" alt="" width="20" height="15">
                <span><?php echo $translations[$lang]['Category'] ?></span>
                <span class="nabla" id="nablaSymbol">▼</span>
            </a>
        
            <!-----------------------------Hidden items initially ------------------------------------>
            <div id="hiddenItems" style="display: none;">
                <a href="/To-Do-List/Main/all.php" class="menu-page-item">
                    <img src="notebook.png" alt="" width="20" height="15">
                    <span><?php echo $translations[$lang]['All'] ?></span>
                </a>
                <a href="/To-Do-List/Main/work.php" class="menu-page-item">
                    <img src="notebook.png" alt="" width="20" height="15">
                    <span><?php echo $translations[$lang]['Work'] ?></span>
                </a>
                <a href="/To-Do-List/Main/personal.php" class="menu-page-item">
                    <img src="notebook.png" alt="" width="20" height="15">
                    <span><?php echo $translations[$lang]['Personal'] ?></span>
                </a>
                <a href="/To-Do-List/Main/sport.php" class="menu-page-item">
                    <img src="notebook.png" alt="" width="20" height="15">
                    <span><?php echo $translations[$lang]['Sport'] ?></span>
                </a>
                <a href="/To-Do-List/Main/wishList.php" class="menu-page-item">
                    <img src="notebook.png" alt="" width="20" height="15">
                    <span><?php echo $translations[$lang]['WishList'] ?></span>
                </a>
                <a href="/To-Do-List/Main/birthday.php" class="menu-page-item">
                    <img src="notebook.png" alt="" width="20" height="15">
                    <span><?php echo $translations[$lang]['Birthday'] ?></span>
                </a>
                <a href="/To-Do-List/Main/special.php" class="menu-page-item">
                    <img src="notebook.png" alt="" width="20" height="15">
                    <span><?php echo $translations[$lang]['Special'] ?></span>
                </a>
                <a href="/To-Do-List/Main/Notes.php" class = "menu-page-item">
                    <img src="notebook.png" alt="" width = "20" height = "15">
                    <span><?php echo $translations[$lang]['Your Notes'] ?></span>
                </a>
            </div>
        
            <!--------------- Create New button moved here ------------------------->
            <a href="#" class="menu-page-item" id="createNew">
                <span class="create">+</span>
                <span  onclick="MainJS_Function.createNewPage()"><?php echo $translations[$lang]['Create New Category'] ?></span>
            </a>

                <!--------------Making a table--------------------------------------------->
                <a href="/To-Do-List/Table/table.html" class="menu-page-item" id="createTable">
                    <i class="fas fa-table" id="table"></i>
                    <span><?php echo $translations[$lang]['Create Table'] ?></span>
                </a>

            <!----------------------------- Settings ------------------------------------>
            <a href="settings.php" class="menu-page-item" id="settings">
                <i class="fas fa-cog" id="setting" style="top:50%;"></i>
                <span><?php echo $translations[$lang]['Settings'] ?></span>
            </a>
    </div>
            <!-----------------------------Input for Createing New Page-------------------------------->
            <div class="createNewPage" id="createNewPage" style="display: none;">
                <h4><?php echo $translations[$lang]['Create New Category'] ?></h4>
                    <div class="inputBtn">
                        <input type="text" name = "page" id="input" class="input" maxlength="12" 
                               placeholder="Enter Your Header" style="border-radius: 0.5rem;">
                        <span id="charCount" class="charCount">0/12</span>
                        <button class="cancel" id="cancel" onclick="MainJS_Function.cancel()"><?php echo $translations[$lang]['Cancel'] ?></button>
                        <button  class= "Add" id="Add" onclick="MainJS_Function.addHeader()"><?php echo $translations[$lang]['Add'] ?></button>
                    </div>
            </div>