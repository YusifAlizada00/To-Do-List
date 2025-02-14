var name = {
generateName: function() {
    var addName = document.getElementById('tableName');
    var tableTitle = document.getElementById('tableTitle');
    if (addName.value.trim() !== "") {
        tableTitle.textContent = addName.value.trim();
    } else {
        alert("Please enter Table Name");
    }
}
}