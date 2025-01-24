<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<?php include 'header.php'; ?>
<div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
    <a href="logout.php" class="btn btn-danger">Logout</a>
</div>
<?php include 'footer.php'; ?>
