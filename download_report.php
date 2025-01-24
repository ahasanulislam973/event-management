<?php
include 'db_connection.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $event_id = intval($_GET['id']);

    $query = "SELECT name, email, phone FROM attendees WHERE event_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $event_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="event_' . $event_id . '_attendees.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Name', 'Email', 'Phone']);

        while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($output, [$row['name'], $row['email'], $row['phone']]);
        }

        fclose($output);
    } else {
        echo "<script>
            alert('No attendees found for this event.');
            window.location.href='event_list.php';
        </script>";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "<script>
        alert('Invalid event ID.');
        window.location.href='event_list.php';
    </script>";
}

mysqli_close($conn);
?>
