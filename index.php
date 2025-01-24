<?php
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
            window.location.href = 'index.php';
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



$limit = 2;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$query = "SELECT * FROM events LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);
$total_events_query = "SELECT COUNT(*) AS total FROM events";
$total_events_result = mysqli_query($conn, $total_events_query);
$total_events_row = mysqli_fetch_assoc($total_events_result);
$total_events = $total_events_row['total'];
$total_pages = ceil($total_events / $limit);
?>

<div class="container mt-5">
    <h1 class="text-center">Events</h1>
    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="uploads/<?php echo $row['event_image']; ?>" class="card-img-top" alt="Event Image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['event_name']; ?></h5>
                        <p class="card-text"><?php echo substr($row['event_details'], 0, 100); ?>...</p>
                        <div class="d-flex justify-content-between">
                            <a href="event_details.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">View</a>
                            <a href="event_registration.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Register</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <nav>
        <ul class="pagination justify-content-end">
            <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                <a class="page-link" href="index.php?page=<?php echo $page - 1; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php } ?>
            <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                <a class="page-link" href="index.php?page=<?php echo $page + 1; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

<?php include 'footer.php'; ?>