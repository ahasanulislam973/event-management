<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $event_name = $_POST['event_name'];
    $event_details = $_POST['description'];
    $event_capacity = (int) $_POST['event_capacity'];
    $event_date = $_POST['event_date'];
    

    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error'] = "You must be logged in to create an event.";
        header("Location: login.php");
        exit();
    }
    $user_id = $_SESSION['user_id'];

    $image_name = $_FILES['event_image']['name'];
    $image_tmp_name = $_FILES['event_image']['tmp_name'];
    $image_size = $_FILES['event_image']['size'];
    $image_error = $_FILES['event_image']['error'];

    if ($image_error === 0) {
        if ($image_size < 5000000) {
            $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
            $image_extension = strtolower($image_extension);
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($image_extension, $allowed_extensions)) {
                $new_image_name = uniqid('', true) . '.' . $image_extension;
                $image_upload_path = 'uploads/' . $new_image_name;

                move_uploaded_file($image_tmp_name, $image_upload_path);
            } else {
                $_SESSION['error'] = "Invalid image format. Only JPG, JPEG, PNG, GIF are allowed.";
                header("Location: create_event.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Image size is too large. Max size is 5MB.";
            header("Location: create_event.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "There was an error uploading the image.";
        header("Location: create_event.php");
        exit();
    }

    $query = "SELECT event_name FROM events WHERE event_name = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $event_name);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['error'] = "Event already exists!";
        header("Location: create_event.php");
        exit();
    }

    $sql = "INSERT INTO events (event_name, event_details, capacity, event_image, event_date, user_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssisis", $event_name, $event_details, $event_capacity, $new_image_name, $event_date, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Event created successfully!";
        header("Location: event_list.php");
        exit();
    } else {
        $_SESSION['error'] = "Event creation failed. Please try again.";
        header("Location: create_event.php");
        exit();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
