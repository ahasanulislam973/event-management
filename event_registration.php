<?php
include 'db_connection.php';
include 'header.php';

$event_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($event_id === 0) {
    echo "<script>alert('Invalid event.'); window.location.href='index.php';</script>";
    exit();
}
?>

<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card p-4 shadow-lg" style="width: 400px;">
            <h2 class="text-center">Event Registration</h2>
            <form action="register_event_process.php" method="POST">
                <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control rounded-pill" placeholder="Enter your name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control rounded-pill" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control rounded-pill" placeholder="Enter your phone" required>
                </div>
                <button type="submit" class="btn w-100 rounded-pill" style="background-color: #10b995; color: #005364;">
                    Register
                </button>
                <a href="index.php" class="btn btn-secondary w-100 mt-3" style="border-radius: 50px;">
                <i class="bi bi-arrow-left"></i> Back
            </a>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>