<?php
session_start();
if (isset($_SESSION['user_id'])) {

    include 'header.php';
    include 'db_connection.php';

    $query = "SELECT id, event_name, event_details,capacity, event_image FROM events ORDER BY id DESC";
    $result = mysqli_query($conn, $query);

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
                window.location.href = 'event_list.php';
            }
        });
    </script>";
        unset($_SESSION['error']);
    }
?>

    <div class="container mt-5" style="height: 100vh;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Event List</h2>
            <a href="create_event.php" class="btn btn-success rounded-pill" style="background-color: #10b995; color: #005364;">
                Create Event
            </a>
        </div>

        <table class="table table-bordered shadow-lg">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Capacity</th>
                    <th class="text-center">Image</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['event_name']); ?></td>

                        <td class="card-text"><?php echo substr($row['event_details'], 0, 100); ?>...</td>

                        <td><?php echo htmlspecialchars($row['capacity']); ?></td>

                        <td class="text-center">
                            <img src="uploads/<?php echo $row['event_image']; ?>" alt="Event Image" width="100" height="80" class="img-thumbnail">
                        </td>
                        <td class="text-center">
                            <a href="edit_event.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm rounded-pill" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="delete_event.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm rounded-pill" style="background-color: red; color:#fff" title="Delete">
                                <i class="fa fa-trash"></i>
                            </a>
                            <a href="view_event.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm rounded-pill" style="background-color: orange;" title="View">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="download_report.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm rounded-pill" style="background-color: blue; color: #fff;" title="Download Report">
                                <i class="fa fa-download"></i>
                            </a>
                            <a href="attendee_list.php?event_id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm rounded-pill" style="background-color: green; color: #fff;" title="View Attendees">
                                <i class="fa fa-users"></i> Attendees
                            </a>
                        </td>

                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const deleteButtons = document.querySelectorAll('.btn-danger');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const deleteUrl = this.getAttribute('href');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = deleteUrl;
                    }
                });
            });
        });
    </script>

<?php
    mysqli_close($conn);
    include 'footer.php';
} else {
    header("Location:login.php");
}
?>