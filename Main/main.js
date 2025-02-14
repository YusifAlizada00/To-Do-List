var MainJS_Function = {
    toggleMenu: function () {
        var menu = document.getElementById('menu');
        var menuPage = document.getElementById('menuPage');

        if (menu && menuPage) {
            menu.addEventListener('click', function () {
                menuPage.classList.toggle('show');
            });

            document.addEventListener('click', function (event) {
                if (!menuPage.contains(event.target) && !menu.contains(event.target)) {
                    menuPage.classList.remove('show');
                }
            });
        }
    },
    charCount: function () {
        var input = document.getElementById('input');
        var listContainer = document.getElementById('list-container');

        if (input && listContainer) {
            input.addEventListener('input', function () {
                var charCount = document.getElementById('charCount');
                if (charCount) {
                    var currentLength = input.value.length;
                    charCount.textContent = currentLength + "/12";
                }
            });
        }
    },

    addHeader: function () {
        var add = document.getElementById('Add');
    
        if (add) {
            add.addEventListener('click', function () {
                var input = document.getElementById('input');
                var listContainer = document.getElementById('list-container');
    
                if (input.value.trim() == '') {
                    console.error("Enter header!");
                } else if (input.value.trim().length > 12) {
                    alert("Header too long! Max 12 characters.");
                } else {
                    var headerText = input.value.trim();
    
                    // Prevent duplicate headers
                    var savedHeaders = JSON.parse(localStorage.getItem('headers')) || [];
    
                    // Check for duplicates
                    if (savedHeaders.includes(headerText)) {
                        alert("Header already exists!");
                        return;
                    }
                    /*<a href="/To-Do-List/Main/work.php" class="menu-page-item">
                    <img src="notebook.png" alt="" width="20" height="15">
                    <span><?php echo $translations[$lang]['Work'] ?></span>
                </a>*/
    
                    var li = document.createElement("li");
                    /*var aCtg = document.createElement("a");
                    aCtg.href = "/To-Do-List/Main/newPage.php?pages=" + headerText;
                    aCtg.target = "_self";
                    aCtg.className = "menu-page-item";
                    var imgCtg = document.createElement("img");
                    imgCtg.src = "notebook.png";
                    imgCtg.alt = "";
                    imgCtg.width = "20";
                    imgCtg.height = "15";
                    var spanCtg = document.createElement("span");*/
                    var a = document.createElement("a");
                    a.href = "/To-Do-List/Main/newPage.php?pages=" + headerText;
                    a.target = "_self";
                    a.className = "menu-item";
    
                    // Add click event to highlight the selected header
                    a.addEventListener('click', function () {
                        // Reset all other items' background color
                        document.querySelectorAll('.menu-item').forEach(function (item) {
                            item.classList.remove('selected');
                        });
    
                        // Highlight this header
                        a.classList.add('selected');
    
                        // Save the selected header to localStorage
                        localStorage.setItem('selectedHeader', headerText);
                    });
    
                    // Display the header text inside the link
                    li.textContent = headerText;
    
                    var removeButton = document.createElement("span");
                    removeButton.textContent = " ×";
                    removeButton.className = "remove";
    
                    // Remove only the clicked header
                    removeButton.addEventListener('click', function (event) {
                        event.stopPropagation(); // Prevent accidental navigation
    
                        listContainer.removeChild(a); // Remove only this item
    
                        // Update localStorage
                        MainJS_Function.removeData(headerText);
                        MainJS_Function.saveHeader();
                    });
    
                    // Append the remove button to the anchor element
                    //var hiddenItems = document.getElementById('hiddenItems');

                    a.appendChild(li);
                    //aCtg.appendChild(imgCtg);
                    //aCtg.appendChild(spanCtg);
                    a.appendChild(removeButton);
                    listContainer.appendChild(a);
                    //hiddenItems.appendChild(aCtg);
    
                    // Save the new header to localStorage
                    savedHeaders.push(headerText);
                    localStorage.setItem('headers', JSON.stringify(savedHeaders));
    
                    input.value = ''; // Clear input field
                }
            });
        } else {
            console.error("Missing required elements: Add button, input, or list-container.");
        }
    },

    
    // Function to save headers to localStorage
    saveHeader: function () {
        var listContainer = document.getElementById('list-container');
        var items = listContainer.querySelectorAll('a'); // Changed to query for 'a' tags
        var headers = [];
    
        items.forEach(function(item) {
            headers.push(item.textContent.trim()); // Get the text content of 'a' element
        });
    
        localStorage.setItem('headers', JSON.stringify(headers));
    },
    
    // Function to load headers from localStorage
    loadHeader: function () {
        var listContainer = document.getElementById('list-container');
        var savedHeaders = JSON.parse(localStorage.getItem('headers')) || [];
        var selectedHeader = localStorage.getItem('selectedHeader'); // Retrieve the selected header
    
        savedHeaders.forEach(function(headerText) {
            var li = document.createElement("li");
    
            var a = document.createElement("a");
            a.href = "/To-Do-List/Main/newPage.php?pages=" + headerText;
            a.target = "_self";
            a.className = "menu-item";
    
            // If this header was the last selected, highlight it
            if (headerText === selectedHeader) {
                a.classList.add('selected');
            }
    
            a.addEventListener('click', function () {
            // Unselect all menu items before selecting the clicked one
            document.querySelectorAll('.menu-item.selected').forEach(item => {
                item.classList.remove('selected');
            });

            // Select the clicked header
            a.classList.add('selected');

            // Save the selected header to localStorage
            localStorage.setItem('selectedHeader', headerText);
        });
    
            li.textContent = headerText;
    
            var removeButton = document.createElement("span");
            removeButton.textContent = " ×";
            removeButton.className = "remove";
    
            removeButton.addEventListener('click', function (event) {
                event.stopPropagation();
    
                listContainer.removeChild(a);
    
                savedHeaders = savedHeaders.filter(function(item) {
                    return item !== headerText;
                });
    
                localStorage.setItem('headers', JSON.stringify(savedHeaders));
            });
    
            a.appendChild(li);
            a.appendChild(removeButton);
            listContainer.appendChild(a);
        });
    },
    
    // Function to remove header from localStorage
    removeData: function (headerText) {
        var savedHeaders = JSON.parse(localStorage.getItem('headers')) || [];
        var index = savedHeaders.indexOf(headerText);
    
        if (index !== -1) {
            savedHeaders.splice(index, 1);
            localStorage.setItem('headers', JSON.stringify(savedHeaders));
        }
    },

    

    showTask: function () {
        var listContainer = document.getElementById('list-container');
        if (listContainer) {
            listContainer.innerHTML = localStorage.getItem("data") || "";
            listContainer.addEventListener('click', function (event) {
                if (event.target.classList.contains('remove')) {
                    var li = event.target.closest('li');
                    listContainer.removeChild(li);
                    //MainJS_Function.saveData();
                }
            });
        }
        MainJS_Function.showTask();
    },


    createNewPage: function () {
        var createNew = document.getElementById('createNew');

        if (createNew) {
            createNew.addEventListener('click', function (event) {
                var createNewPage = document.getElementById('createNewPage');
                var menuPage = document.getElementById('menuPage');
                if (createNewPage && menuPage) {
                    event.preventDefault();
                    createNewPage.style.display = "block";
                    menuPage.style.display = "none";
                }
            });

            document.addEventListener('click', function (event) {
                var createNewPage = document.getElementById('createNewPage');
                if (createNewPage) {
                    if (!createNewPage.contains(event.target) && !createNew.contains(event.target)) {
                        createNewPage.style.display = "none";
                        var menuPage = document.getElementById('menuPage');
                        if (menuPage) menuPage.style.display = "block";
                    }
                }
            });
        }
    },

    cancel: function () {
        var cancel = document.getElementById('cancel');
        if (cancel) {
            cancel.addEventListener('click', function () {
                var createNewPage = document.getElementById('createNewPage');
                var menuPage = document.getElementById('menuPage');
                if (createNewPage && menuPage) {
                    createNewPage.style.display = "none";
                    menuPage.style.display = "block";
                }
            });
        }
    },
    cancelTask: function () {
        var cancel = document.getElementById('cancelTask');
        if (cancel) {
            cancel.addEventListener('click', function () {
                var taskInput = document.getElementById('taskInput');
                var menuPage = document.getElementById('menuPage');
                if (taskInput && menuPage) {
                    taskInput.style.display = "none";
                    menuPage.style.display = "block";
                }
            });
        }
    },

    showHiddenButton: function () {
        var hiddenButton = document.getElementById("hiddenButton");
        if (hiddenButton) {
            hiddenButton.style.display = "inline-block";
        }
    },

    toggleHiddenItems: function () {
        var hiddenItems = document.getElementById("hiddenItems");
        var nablaSymbol = document.getElementById("nablaSymbol");

        if (hiddenItems && nablaSymbol) {
            hiddenItems.style.display = hiddenItems.style.display === "none" ? "block" : "none";
            nablaSymbol.classList.toggle("open");
        }
    },
    toggleHiddenTables: function () {
        var hiddenTables = document.getElementById("hiddenTables");
        var nabla = document.getElementById("nabla");

        if (hiddenTables && nabla) {
            hiddenTables.style.display = hiddenTables.style.display === "none" ? "block" : "none";
            nabla.classList.toggle("open");
        }
    },

    openTask: function () {
        var addTask = document.getElementById('add');
        var menuPage = document.getElementById('menuPage');

        if (addTask && menuPage) {
            addTask.addEventListener('click', function () {
                var taskInput = document.getElementById('taskInput');
                if (taskInput) {
                    taskInput.style.display = "block";
                    menuPage.style.display = "none";
                }
            });
        }
    },

    addTask: function() {
        var input = document.getElementById('task');
        var list = document.getElementById('lists');
    
        if (input.value.trim() === '') {
            alert("Please enter a task!");
        } else {
            const taskValue = input.value.trim(); // Get user input and trim whitespace
    
            // Get existing tasks from local storage or initialize an empty array
            let tasks = JSON.parse(localStorage.getItem("tasks")) || [];
            tasks.push(taskValue); // Add the new task
            localStorage.setItem("tasks", JSON.stringify(tasks)); // Save updated tasks to local storage
    
            // Create a new list item and append it to the task list
            let li = document.createElement("li");
            let span = document.createElement("span");
            span.textContent = taskValue;
/*             li.textContent = taskValue;
 */    
            let small = document.createElement("small");
            small.textContent = "\u00d7"; // Add a close button (×)
            //small.className = "closeTask"; // Optional for styling
            small.onclick = function() {
                li.remove();
                MainJS_Function.removeTask(taskValue);
            };
    
            li.appendChild(span);
            li.appendChild(small);
            list.appendChild(li);
    
            input.value = ''; // Clear the input field
            alert("Task was added successfully!"); // Optional feedback
        }
    },
    loadTasks: function() {
/*         localStorage.setItem("tasks", JSON.stringify([])); // Initialize tasks in local storage
 */        let tasks = JSON.parse(localStorage.getItem("tasks")) || [] ;
         let list = document.getElementById('lists');
        
        tasks.forEach(task => {
            let li = document.createElement("li");
            let span = document.createElement("span");
            span.textContent = task;
    
            let small = document.createElement("small");
            small.textContent = "\u00d7";
            //small.className = "closeTask";
            small.onclick = function() {
                li.remove();
                MainJS_Function.removeTask(task);
            };
    
            li.appendChild(span);
            li.appendChild(small);
            list.appendChild(li);
        });
    },

    removeTask: function(taskValue)
    {
        var list = document.getElementById('lists');
        list.addEventListener('click', function(e)
        {
            if(e.target.tagName === "LI")
            {
                e.target.classList.toggle("checked"); // add parent element class
                MainJS_Function.saveData();
            }
            else if(e.target.tagName === 'SMALL')
            {
                e.target.parentElement.remove();
            }
        }, false);
        let tasks = JSON.parse(localStorage.getItem("tasks")) || [] ;
        tasks = tasks.filter(task => task !== taskValue); // Remove the specific task
        localStorage.setItem("tasks", JSON.stringify(tasks)); // Update localStorage
    },

    saveData: function()
    {
        var list = document.getElementById('lists');
        localStorage.setItem("data", list.innerHTML);
    },
};



document.addEventListener('DOMContentLoaded', function () {
    MainJS_Function.loadTasks();
    MainJS_Function.loadHeader();
    MainJS_Function.saveData();
    MainJS_Function.removeTask();
    //MainJS_Function.removeTask();
    MainJS_Function.addHeader();
});
