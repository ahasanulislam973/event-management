<?php 
include 'db_connection.php'; 

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    $disable_fk_check = "SET foreign_key_checks = 0;";
    mysqli_query($conn, $disable_fk_check);

    $query = "DELETE FROM events WHERE id = '$event_id'";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Event deleted successfully!";
        header('Location: event_list.php');
    } else {
        $_SESSION['error'] = "Failed to delete the event!";
        header('Location: event_list.php');
    }

    $enable_fk_check = "SET foreign_key_checks = 1;";
    mysqli_query($conn, $enable_fk_check);
}

mysqli_close($conn);
?>  
