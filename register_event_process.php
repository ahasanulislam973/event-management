<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    // Check event capacity
    $capacity_query = "SELECT capacity FROM events WHERE id = '$event_id'";
    $capacity_result = mysqli_query($conn, $capacity_query);
    
    if ($capacity_result && mysqli_num_rows($capacity_result) > 0) {
        $capacity_row = mysqli_fetch_assoc($capacity_result);
        $capacity = $capacity_row['capacity'];

        // Count the number of attendees already registered
        $count_query = "SELECT COUNT(*) AS total_attendees FROM attendees WHERE event_id = '$event_id'";
        $count_result = mysqli_query($conn, $count_query);
        $count_row = mysqli_fetch_assoc($count_result);
        $current_attendees = $count_row['total_attendees'];

        if ($current_attendees < $capacity) {
            // Insert the new attendee if capacity allows
            $query = "INSERT INTO attendees (event_id, name, email, phone) VALUES ('$event_id', '$name', '$email', '$phone')";
            if (mysqli_query($conn, $query)) {
                $_SESSION['success'] = "Registration successful!";
            } else {
                $_SESSION['error'] = "Error: " . mysqli_error($conn);
            }
        } else {
            $_SESSION['error'] = "Sorry, the event is already at full capacity.";
        }
    } else {
        $_SESSION['error'] = "Event not found.";
    }

    // Redirect to index.php after processing
    header("Location: index.php");
    exit();
}
?>
