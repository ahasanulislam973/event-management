<?php include 'header.php'; ?>

<?php

if (isset($_SESSION['success'])) {
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '" . $_SESSION['success'] . "',
        }).then((result) => {
            if (result.isConfirmed || result.isDismissed) {
                window.location.href = 'event_list.php';
            }
        });
    </script>";
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: '" . $_SESSION['error'] . "',
        }).then((result) => {
            if (result.isConfirmed || result.isDismissed) {
                window.location.href = 'create_event.php';
            }
        });
    </script>";
    unset($_SESSION['error']);
}
?>


<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card p-4 shadow-lg" style="width: 600px;">
        <h2 class="text-center">Create Event</h2>
        <form action="store_event.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Event Name</label>
                <input type="text" class="form-control" name="event_name" placeholder="Enter event name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="4" placeholder="Enter event description" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Event Capacity</label>
                <input type="number" class="form-control" name="event_capacity" placeholder="Enter event capacity" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Event Image</label>
                <input type="file" class="form-control" name="event_image" accept="image/*" required>
            </div>
            <button type="submit" class="btn w-100" style="background-color: #10b995; color: #005364;">Create Event</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
