<?php
include 'db_connection.php';
include 'header.php';

// Handle success and error messages
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

$limit = 3;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'event_name';
$sort_order = isset($_GET['order']) ? $_GET['order'] : 'ASC';
$search = isset($_GET['search']) ? $_GET['search'] : ''; 

$query = "SELECT * FROM events WHERE event_name LIKE '%$search%' ORDER BY $sort_column $sort_order LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

$total_events_query = "SELECT COUNT(*) AS total FROM events WHERE event_name LIKE '%$search%'";
$total_events_result = mysqli_query($conn, $total_events_query);
$total_events_row = mysqli_fetch_assoc($total_events_result);
$total_events = $total_events_row['total'];
$total_pages = ceil($total_events / $limit);
?>

<div class="container mt-5">
    <h1 class="text-center">Events</h1>


    <div class="d-flex justify-content-center mb-4 flex-column flex-md-row align-items-center">
        <!-- Search Form -->
        <form method="GET" class="mb-3 mb-md-0 d-flex align-items-center me-md-3">
            <input type="text" name="search" value="<?php echo $search; ?>" class="form-control" placeholder="Search by event name" style="max-width: 300px;">
            <button type="submit" class="btn btn-primary ms-2">Search</button>
        </form>

        <!-- Sorting Form -->
        <form method="GET" class="d-flex align-items-center mt-3 mt-md-0">
            <select name="sort" class="form-control me-2" style="max-width: 150px;">
                <option value="event_name" <?php if ($sort_column == 'event_name') echo 'selected'; ?>>Event Name</option>
                <option value="event_date" <?php if ($sort_column == 'event_date') echo 'selected'; ?>>Event Date</option>
            </select>
            <select name="order" class="form-control me-2" style="max-width: 120px;">
                <option value="ASC" <?php if ($sort_order == 'ASC') echo 'selected'; ?>>Ascending</option>
                <option value="DESC" <?php if ($sort_order == 'DESC') echo 'selected'; ?>>Descending</option>
            </select>
            <button type="submit" class="btn btn-secondary">Sort</button>
        </form>
    </div>

    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="uploads/<?php echo $row['event_image']; ?>" class="card-img-top" alt="Event Image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['event_name']; ?></h5>
                        <p class="card-text"><?php echo substr($row['event_details'], 0, 100); ?>...</p>
                        <div class="d-flex justify-content-between">
                            <!-- View Button -->
                            <form action="event_details.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-warning btn-sm rounded-pill" style="background-color: orange;" title="View">
                                    View
                                </button>
                            </form>
                            <!-- Attendee Registration Button -->
                            <form action="event_registration.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-primary btn-sm" title="View">
                                    Attendee Registration
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <nav>
        <ul class="pagination justify-content-end">
            <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                <a class="page-link" href="index.php?page=<?php echo $page - 1; ?>&search=<?php echo $search; ?>&sort=<?php echo $sort_column; ?>&order=<?php echo $sort_order; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="index.php?page=<?php echo $i; ?>&search=<?php echo $search; ?>&sort=<?php echo $sort_column; ?>&order=<?php echo $sort_order; ?>"><?php echo $i; ?></a>
                </li>
            <?php } ?>
            <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                <a class="page-link" href="index.php?page=<?php echo $page + 1; ?>&search=<?php echo $search; ?>&sort=<?php echo $sort_column; ?>&order=<?php echo $sort_order; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

<style>
    @media (max-width: 768px) {
        .d-flex {
            flex-direction: column;
            align-items: center;
        }

        .form-control {
            max-width: 100% !important;
        }

        .btn {
            width: 100%;
            margin-top: 10px;
        }

        .pagination {
            justify-content: center;
        }
    }
</style>
