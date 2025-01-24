<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include 'header.php';
?>
<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card p-4 shadow-lg" style="width: 400px;">
            <h2 class="text-center">Login</h2>
            <form action="login_process.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control rounded-pill" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control rounded-pill" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn w-100 rounded-pill" style="background-color: #10b995; color: #005364;">
                    Login
                </button>
            </form>

            <div class="text-center mt-2">
                Don't have an account? 
                <a href="register.php" class="text-decoration-none fw-bold" style="color: #10b995;">Register</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
