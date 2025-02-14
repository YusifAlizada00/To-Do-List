<?php
    $barId = "Calendar";
    //require $_SERVER["DOCUMENT_ROOT"].'/To-Do-List/Main/translations.json';
        // Start the session and load translations as before
        if (isset($_GET['lang'])) {
            $_SESSION['lang'] = $_GET['lang']; // Store selected language in session
        }
        $lang = $_SESSION['lang'] ?? 'en'; // Default to English if no language is selected
        $translations = json_decode(file_get_contents('../translations.json'), true);
    
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
<link rel="stylesheet" href="/To-Do-List/Main/main.css"/>
<script src="/To-Do-List/Main/main.js" defer></script>
<link rel="stylesheet" href="/To-Do-List/Main/Calendar/calendar.css"/>
<title><?php echo $translations[$lang]['Full Calendar'] ?></title>
</head>
<body>
<div id='calendar'></div>

<!--Start popup dialog box -->
<div class="modal fade" id="AddEvent" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel"><b><?php echo $translations[$lang]['Add New Event'] ?></b></h5>
            </div>
            <form action="" method="post" id="SubmitEvent">
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-sm-12">  
                                <div class="form-group">
                                    <label for="event_name"><b><?php echo $translations[$lang]['Event Name'] ?></b></label>
                                    <input type="text" name="event_name" id="event_name" class="form-control clear-form" placeholder="Enter your event name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">  
                                <div class="form-group">
                                    <label for="event_start_date"><b><?php echo $translations[$lang]['Start Date'] ?></b></label>
                                    <input type="date" name="start_date" id="start_date" class="form-control clear-form">
                                </div>
                            </div>
                            <div class="col-sm-6">  
                                <div class="form-group">
                                    <label for="event_end_date"><b><?php echo $translations[$lang]['End Date'] ?></b></label>
                                    <input type="date" name="end_date" id="end_date" class="form-control clear-form">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="event_start_date"><b><?php echo $translations[$lang]['Color'] ?></b></label>
                                    <input type="color" name="color" id="color" class="form-control clear-form">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="event_end_date"><b>Url</b></label>
                                    <input type="url" name="link" id="link" class="form-control clear-form">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><?php echo $translations[$lang]['Submit'] ?></button>
                </div>
            </form>
        </div>
    </div> 
</div>
<!-- End popup dialog box -->
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
                <img src="../crown.png" alt="" width="20" height="20">
                <span><?php echo $translations[$lang]['Upgrade To Pro'] ?></span>
            </a>
            <a href="#" class="menu-page-item">
                <img src="../flag.png" alt="" width="20" height="20">
                <span><?php $translations[$lang]['Flag Tasks'] ?></span>
            </a>
            <a href="#" class="menu-page-item" onclick="MainJS_Function.toggleHiddenItems()">
                <img src="../category.png" alt="" width="20" height="15">
                <span><?php echo $translations[$lang]['Category'] ?></span>
                <span class="nabla" id="nablaSymbol">▼</span>
            </a>
        
            <!-----------------------------Hidden items initially ------------------------------------>
            <div id="hiddenItems" style="display: none;">
                <a href="/To-Do-List/Main/all.php" class="menu-page-item">
                    <img src="../notebook.png" alt="" width="20" height="15">
                    <span><?php echo $translations[$lang]['All'] ?></span>
                </a>
                <a href="/To-Do-List/Main/work.php" class="menu-page-item">
                    <img src="../notebook.png" alt="" width="20" height="15">
                    <span><?php echo $translations[$lang]['Work'] ?></span>
                </a>
                <a href="/To-Do-List/Main/personal.php" class="menu-page-item">
                    <img src="../notebook.png" alt="" width="20" height="15">
                    <span><?php echo $translations[$lang]['Personal'] ?></span>
                </a>
                <a href="/To-Do-List/Main/sport.php" class="menu-page-item">
                    <img src="../notebook.png" alt="" width="20" height="15">
                    <span><?php echo $translations[$lang]['Sport'] ?></span>
                </a>
                <a href="/To-Do-List/Main/wishList.php" class="menu-page-item">
                    <img src="../notebook.png" alt="" width="20" height="15">
                    <span><?php echo $translations[$lang]['WishList'] ?></span>
                </a>
                <a href="/To-Do-List/Main/birthday.php" class="menu-page-item">
                    <img src="../notebook.png" alt="" width="20" height="15">
                    <span><?php echo $translations[$lang]['Birthday'] ?></span>
                </a>
                <a href="/To-Do-List/Main/special.php" class="menu-page-item">
                    <img src="../notebook.png" alt="" width="20" height="15">
                    <span><?php echo $translations[$lang]['Special'] ?></span>
                </a>
                <a href="/To-Do-List/Main/yourNotes.php" class = "menu-page-item">
                    <img src="../notebook.png" alt="" width = "20" height = "15">
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

<script src='js/index.global.js'></script> <!--This is a JS library-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script type="text/javascript">
    function getEvent()
    {
        var events = new Array();
        $.ajax(
            {
                type : "POST",
                url : "function.php?type=list", 
                dataType : "json",
                success : function(data) 
                {
                    var result = data;

                    $.each(result, function(i, item)
                    {
                        events.push(
                            {
                                event_id : result[i].id,
                                title : result[i].event_name,
                                start : result[i].start_date,
                                end : result[i].end_date,
                                color : result[i].color,
                                url : result[i].link,
                            });
                    });
                    
                    var calendarEl = document.getElementById('calendar');
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                        },
                        initialDate: '<?=date('Y-m-d')?>', // ?= means echo
                        navLinks: true, // can click day/week names to navigate views
                        businessHours: true, // display business hours
                        editable: true,
                        selectable: true,
                        events: events,
                        select: function(datetime)
                        {
                            $('.clear-form').val('');
                            $('#start_date').val(moment(datetime.start).format('YYYY-MM-DD'));
                            $('#end_date').val(moment(datetime.end).format('YYYY-MM-DD'));
                            $('#AddEvent').modal('show');
                        },
                        eventClick: function(info) 
                        {
                        var deleteMsg = confirm("Do you really want to delete?");
                        if (deleteMsg) {
                            $.ajax({
                                type: "GET", // Use GET for a query string
                                url: "function.php?type=delete", 
                                data: { event_name: info.event.title }, // Pass the correct event name
                                success: function(response) {
                                    if (parseInt(response) > 0) {
                                        info.event.remove(); // Remove event from calendar
                                        alert("Deleted Successfully");
                                    } else {
                                        alert("Failed to delete the event.");
                                    }
                                }
                            });
                        }
                    },

                    });
            
                    calendar.render();
                }
            });
    }

    getEvent();


    $('body').delegate('#SubmitEvent', 'submit', function(e)
    {
        e.preventDefault();
        $.ajax(
        {
            type : "POST",
            url : "function.php?type=add", 
            data : $(this).serialize(),
            dataType : "json",
            success : function(data) 
            {
                alert(data.message);
                $('#AddEvent').modal('hide');
                getEvent();
            }
        });
    });



</script>


</body>
</html>
<!--You can you var only in scope but let outside of scope as well-->