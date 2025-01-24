<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $event_capacity = (int) $_POST['event_capacity'];
    $event_image = '';
    $user_id = $_SESSION['user_id'];

    if (!empty($_FILES['event_image']['name'])) {
        $target_dir = "uploads/";
        $image_name = basename($_FILES["event_image"]["name"]);
        $target_file = $target_dir . time() . "_" . $image_name;
        
        if (move_uploaded_file($_FILES["event_image"]["tmp_name"], $target_file)) {
            $event_image = time() . "_" . $image_name;

            $old_query = "SELECT event_image FROM events WHERE id = $event_id";
            $old_result = mysqli_query($conn, $old_query);
            $old_data = mysqli_fetch_assoc($old_result);
            if ($old_data && file_exists('uploads/' . $old_data['event_image'])) {
                unlink('uploads/' . $old_data['event_image']);
            }
        }
    }

    if (!empty($event_image)) {
        $update_query = "UPDATE events SET event_name='$event_name', event_details='$description', event_image='$event_image', capacity='$event_capacity', user_id='$user_id' WHERE id=$event_id";
    } else {
        $update_query = "UPDATE events SET event_name='$event_name', event_details='$description', capacity='$event_capacity', user_id='$user_id' WHERE id=$event_id";
    }

    if (mysqli_query($conn, $update_query)) {
        $_SESSION['success'] = "Event updated successfully!";
    } else {
        $_SESSION['error'] = "Failed to update event.";
    }

    mysqli_close($conn);
    header('Location: event_list.php');
    exit;
} else {
    $_SESSION['error'] = "Invalid request.";
    header('Location: event_list.php');
    exit;
}
?>
