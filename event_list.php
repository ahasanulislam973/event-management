<?php
session_start();
if (isset($_SESSION['user_id'])) {

    include 'header.php';
    include 'db_connection.php';

    $query = "SELECT id, event_name, event_details, event_date, capacity, event_image FROM events ORDER BY id DESC";
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
            <a href="create_event.php" class="btn btn-success rounded-pill" style="background-color: #10b995; color: #ffffff;">
                Create Event
            </a>
        </div>


        <div class="table-responsive" style="overflow-x:auto;">
            <table class="table table-bordered shadow-lg">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Capacity</th>
                        <th>Event Date</th>
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
                            <td><?php echo htmlspecialchars($row['event_date']); ?></td>
                            <td class="text-center">
                                <img src="uploads/<?php echo $row['event_image']; ?>" alt="Event Image" width="100" height="80" class="img-thumbnail">
                            </td>
                            <td class="text-center">
                                <!-- Edit Button -->
                                <form action="edit_event.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-warning btn-sm rounded-pill" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </form>

                                <!-- Delete Button -->
                                <form action="delete_event.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm rounded-pill" style="background-color: red; color:#fff" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                                <!-- View Button -->
                                <form action="view_event.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-warning btn-sm rounded-pill" style="background-color: orange;" title="View">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </form>

                                <!-- Download Report Button -->
                                <form action="download_report.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-info btn-sm rounded-pill" style="background-color: blue; color: #fff;" title="Download Report">
                                        <i class="fa fa-download"></i>
                                    </button>
                                </form>

                                <!-- Attendees Button -->
                                <form action="attendee_list.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="event_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-primary btn-sm rounded-pill" style="background-color: green; color: #fff;" title="View Attendees">
                                        <i class="fa fa-users"></i> Attendees
                                    </button>
                                </form>
                            </td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>

            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const deleteButtons = document.querySelectorAll('.btn-danger');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const form = this.closest('form');
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
                        form.submit();
                    }
                });
            });
        });
    </script>

    <style>
        @media (max-width: 767px) {
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }


            .table td a {
                margin-bottom: 5px;
                display: block;
            }


            .table td {
                word-wrap: break-word;
            }
        }


        @media (min-width: 768px) {
            .table-responsive {
                overflow: unset;
            }



            .table td a {
                display: inline-block;
                margin-bottom: 0;
            }
        }

        @media (max-width: 767px) {
            .table td form {
                display: block;
                margin-bottom: 10px;
            }

            .table td form button {
                width: 100%;
            }
        }

        @media (min-width: 768px) {
            .table td form {
                display: inline-block;
                margin-bottom: 5px;
            }

            .table td form button {
                width: auto;
            }
        }

        @media (max-width: 767px) {
            .table td form button {
                margin-bottom: 10px;
            }
        }
    </style>

<?php
    mysqli_close($conn);
    include 'footer.php';
} else {
    header("Location:login.php");
}
?>