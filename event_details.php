<?php
    include 'header.php';
    include 'db_connection.php';

    if (isset($_POST['id'])) {
        $event_id = $_POST['id'];

        $query = "SELECT event_name, event_details, capacity, event_image, event_date FROM events WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $event_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $event = $result->fetch_assoc();
        } else {
            header('Location: event_list.php');
            exit;
        }
    } else {
        header('Location: event_list.php');
        exit;
    }

?>

    <div class="container mt-5" style="height: 100vh;">
        <h2 class="mb-4"><?php echo htmlspecialchars($event['event_name']); ?></h2>
        <p><strong>Capacity:</strong> <?php echo nl2br(htmlspecialchars($event['capacity'])); ?></p>

        <p><strong>Event Date:</strong> <?php echo nl2br(htmlspecialchars($event['event_date'])); ?></p> <!-- Add this line -->

        <div class="row">
            <div class="col-md-8">
                <p> <?php echo nl2br(htmlspecialchars($event['event_details'])); ?></p>
            </div>
            <div class="col-md-4">
                <?php
                $imagePath = 'uploads/' . $event['event_image'];
                if (file_exists($imagePath) && !empty($event['event_image'])): ?>
                    <img src="<?php echo $imagePath; ?>" alt="Event Image" class="img-fluid rounded">
                <?php else: ?>
                    <span class="text-muted">No Image</span>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-4">
            <a href="index.php" class="btn btn-secondary rounded-pill">Back</a>
        </div>
    </div>

<?php
    mysqli_close($conn);
    include 'footer.php';
?>
