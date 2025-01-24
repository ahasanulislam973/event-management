<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include 'db_connection.php';
include 'header.php';

if (isset($_SESSION['success'])) {
    echo "<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '" . $_SESSION['success'] . "',
    }).then((result) => {
        if (result.isConfirmed || result.isDismissed) {
            window.location.href = 'login.php';
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
    });
</script>";
    unset($_SESSION['error']);
}
?>

<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card p-4 shadow-lg" style="width: 400px;">
            <h2 class="text-center">Register</h2>
            <form action="register_process.php" method="POST">
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
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control rounded-pill" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn w-100 rounded-pill" style="background-color: #10b995; color: #005364;">
                    Register
                </button>
            </form>
            <div class="text-center mt-3">
                Already have an account?
                <a href="login.php" class="text-decoration-none fw-bold" style="color: #10b995;">Login</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
