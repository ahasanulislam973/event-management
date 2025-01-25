<?php
session_start();
include 'header.php';
include 'db_connection.php';

if (isset($_POST['event_id'])) {
    $event_id = intval($_POST['event_id']);

    $query = "SELECT name, email, phone FROM attendees WHERE event_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $event_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $_SESSION['error'] = "Invalid event ID.";
    header("Location: event_list.php");
    exit();
}
?>
<div style="height: 100vh">
    <div class="container mt-5">
        <h2>Attendee List</h2>

        <div class="table-responsive" style="overflow-x:auto;">
            <table class="table table-bordered shadow-lg">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <a href="event_list.php" class="btn btn-secondary rounded-pill">Back to Events</a>
    </div>
</div>

<style>
    @media (max-width: 767px) {
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    }
</style>

<?php
mysqli_stmt_close($stmt);
mysqli_close($conn);
include 'footer.php';
?>