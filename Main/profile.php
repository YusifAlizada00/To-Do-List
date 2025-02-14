<?php
    $barId = "Profile";
    require $_SERVER["DOCUMENT_ROOT"].'/To-Do-List/Main/uploadImage.php';

        if (isset($_GET['lang'])) {
            $_SESSION['lang'] = $_GET['lang']; // Store selected language in session
        }
        $lang = $_SESSION['lang'] ?? 'en'; // Default to English if no language is selected
        $translations = json_decode(file_get_contents('translations.json'), true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link rel="stylesheet" href="main.css">
    <script src="main.js" defer></script>
    <title>Profile</title>
</head>
<body>
    <style>
        .taskBar{
            width: 320px;
        }
    </style>
    <div class="profileContainer">
        <form action="uploadImage.php" method="POST" enctype="multipart/form-data"> <!--Using this enctype we can upload files inside uploadImages.php---->
            <input type="file" name="file" id="file">
            <label for="file" class="uploadFile"><i class="fa-solid fa-upload"></i>Upload File</label>
            <button type="submit" name="submit" class="submitFile">Submit chosen file/image</button>
            <button type="submit" name="delete" class="deleteFile" style="background-color:red;">Delete</button>
        </form>

        <img id="userImg" src="<?php echo $imagePath; ?>" alt="" height="150" width="150">

            <small class="login">Go To <a href="/To-Do-List/LogIn/index.php">LogIn</a></small>
        <div class="upgradePro">
            <h3>Upgrade to Pro</h3>
            <span class="text">Make it easier</span>
                <div class="pro">
                    <a href="/To-Do-List/Pricing/payment.html">
                        <img src="crown.png" alt="Crown Icon" width="20" height="20">
                        <span>Pro</span>
                    </a>
                </div>
        </div>

        <span class="tasksOverview">Tasks Overview</span>
        <div class="box1">
            <p>Completed Tasks</p>
        </div>
        <div class="box2">
            <p>Total Tasks</p>
        </div>
    </div>
    <div class="whiteSpace"></div>


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
                    <span><?php echo $translations[$lang]['Notes'] ?></span>
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
                    <span><?php echo $translations[$lang]['Tables'] ?></span>
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
                        <button  class= "Add" id="Add" onclick="MainJS_Function.addHeader(); setTimeout(function(){ window.location.href = 'tasks.php'; }, 100);"><?php echo $translations[$lang]['Add'] ?></button>
                    </div>
            </div>
</body>
</html>
