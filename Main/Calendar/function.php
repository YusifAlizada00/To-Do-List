<?php
    require $_SERVER["DOCUMENT_ROOT"] . '/To-Do-List/Main/Calendar/databaseConn.php';

    if(!empty($_GET['type']) && $_GET['type'] == 'list')
    {
        $sql = "SELECT * FROM event";
        $result = $conn->query($sql);
        $eventArray = array();

        while($row = $result->fetch_assoc())
        {
            $eventArray[] = $row;
        }
        echo json_encode($eventArray);
    }
    else if(!empty($_GET['type']) && $_GET['type'] == 'add')
    {
        $sql = "INSERT INTO `event`(`event_name`, `color`, `link`, `start_date`, `end_date`)
         VALUES ('".$_POST['event_name']."', '".$_POST['color']."', '".$_POST['link']."', '".$_POST['start_date']."', '".$_POST['end_date']."')";

         if($conn->query($sql) == TRUE)
         {
            $json['status'] = true;
            $json['message'] = "Event successfully created!";
         }
         else
         {
            $json['status'] = false;
            $json['message'] = "Error occured, Please try again!";
         }
         echo json_encode($json);
    }
    else if(!empty($_GET['type']) && $_GET['type'] == 'delete')
    {
            $event_name = $_GET['event_name'];
    
            $sqlDelete = "DELETE FROM event WHERE event_name = '$event_name'";
    
            if($conn->query($sqlDelete)) {
                echo 1; // Successful deletion
            } else {
                echo 0; // Deletion failed
            }
    } 
?>