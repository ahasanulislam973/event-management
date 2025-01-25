<?php
session_start();
include 'db_connection.php';

if (isset($_POST['id'])) {
    $event_id = $_POST['id'];

    $disable_fk_check = "SET foreign_key_checks = 0;";
    mysqli_query($conn, $disable_fk_check);

    $query = "DELETE FROM events WHERE id = '$event_id'";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Event deleted successfully!";
    } else {
        $_SESSION['error'] = "Failed to delete the event!";
    }

    $enable_fk_check = "SET foreign_key_checks = 1;";
    mysqli_query($conn, $enable_fk_check);

    header('Location: event_list.php');
    exit();
}

mysqli_close($conn);
