<?php 
include 'header.php'; 
include 'db_connection.php'; 

if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $event_id = $_POST['id'];

    $query = "SELECT * FROM events WHERE id = $event_id";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $event = mysqli_fetch_assoc($result);
    } else {
        $_SESSION['error'] = "Event not found!";
        header('Location: event_list.php');
        exit;
    }
} else {
    $_SESSION['error'] = "Invalid event ID!";
    header('Location: event_list.php');
    exit;
}
?>

<div class="container mt-4">
    <div class="d-flex justify-content-center align-items-center">
        <div class="card p-4 shadow-lg" style="width: 600px;">
            <h2 class="text-center">Edit Event</h2>
            <form action="update_event.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">

                <div class="mb-3">
                    <label class="form-label">Event Name</label>
                    <input type="text" class="form-control" name="event_name" value="<?php echo htmlspecialchars($event['event_name']); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="4" required><?php echo htmlspecialchars($event['event_details']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Event Capacity</label>
                    <input type="number" class="form-control" name="event_capacity" value="<?php echo htmlspecialchars($event['capacity']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Event Date</label>
                    <input type="date" class="form-control" name="event_date" value="<?php echo htmlspecialchars($event['event_date']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Event Image</label>
                    <input type="file" class="form-control" name="event_image" accept="image/*">
                    <p class="mt-2">Current Image:</p>
                    <?php if (!empty($event['event_image']) && file_exists('uploads/' . $event['event_image'])): ?>
                        <img src="uploads/<?php echo $event['event_image']; ?>" alt="Event Image" width="100" class="img-thumbnail">
                    <?php else: ?>
                        <span class="text-muted">No Image</span>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn w-100" style="background-color: #10b995; color: #005364;">Update Event</button>
                
            </form>

            <a href="event_list.php" class="btn btn-secondary w-100 mt-3" style="border-radius: 50px;">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>