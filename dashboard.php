<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

include 'db_conn.php';

// Fetch workers data from the database
$result = $conn->query("SELECT * FROM pekerja");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
       /* General Page Styling */
html, body, .intro {
    height: 100%;
    padding: 5px;
}

/* Table Styling */
.table {
    width: 100%; /* Full width table */
    table-layout: auto; /* Automatically adjusts column width based on content */
    border-radius: 4px;
    overflow: hidden; /* Ensures rounded corners are visible */
    max-width: 100%; /* Prevents the table from exceeding its container */
}

table td, table th {
    text-align: center;
    vertical-align: middle;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* ID column alignment */
.table td.text-left, .table th.text-left {
    text-align: left;
}
/* Table Header Styling */
.table th, .table td {
    color: rgb(255, 255, 255) !important;
    background-color: #333 !important;
}

.table thead th {
    background-color: #1a1a1a !important;
    color: #fff !important;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 16px;
}

tbody td {
    color: rgb(255, 255, 255) !important;
    background-color: #333;
    font-weight: 500;
}

/* Navbar Styling */
.navbar {
    margin-bottom: 20px;
}

.navbar .text {
    color: black;
}

.navbar b {
    font-size: 13px;
    margin-bottom: 25px;
}

.btn {
    margin-top: 10px;
}

/* Body Background */
body {
    background-color: #121212;
    color: #fff;
}

.custom-btn {
    width: 30%;
    border-radius: 3px;
    padding: 7px;
    text-align: center;
    margin: 3px;
}

/* Ensure the table fits within the container */
.container-fluid {
    padding: 5px;  /* Remove padding for full-width table */
    overflow-x: hidden;  /* Prevent horizontal scrolling */
}


        /* Modal and Button Styling */
        .modal-header {
            background-color: #333;
        }

        .modal-title {
            color: #fff;
            text-align: center;
        }

        .modal-body {
            color: #000;
            font-weight: normal;
            text-align: center;
            padding: 10px;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-start;
        }

        .btn-close {
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
        }


    </style>
</head>

<body class="bg-dark text-light">
    <!-- Navbar -->
    <nav class="navbar navbar-light bg-light rounded m-2 px-3">
        <div class="text" style="color: black;">
            <b style="font-size: 11px; margin-bottom: 25px;">ANISHOLDING SDN. BHD.</b>
            <br>
            <button class="btn btn-primary mt-1" onclick="window.location.href='add.php'">Add</button>
        </div>
    </nav>

    <div class="container-fluid">
        <!-- Centered Text -->
        <p class="text-center">SENARAI PEKERJA</p>

        <div class="row justify-content-center">
            <div class="col-12">
                <!-- Table -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                        <thead>
    <tr>
        <th scope="col" class="text-left">ID</th> <!-- Left aligned -->
        <th scope="col">NAMA PEKERJA</th> <!-- Default (centered) -->
        <th scope="col">NO KP</th> <!-- Default (centered) -->
        <th scope="col">NO HP</th> <!-- Default (centered) -->
        <th scope="col">JANTINA</th> <!-- Default (centered) -->
        <th scope="col">&nbsp;</th>
    </tr>
</thead>
<tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td class="text-left"><?= $row['id'] ?></td> <!-- Left aligned -->
            <td><?= $row['nama_pekerja'] ?></td> <!-- Default (centered) -->
            <td><?= $row['no_kp'] ?></td> <!-- Default (centered) -->
            <td><?= $row['no_hp'] ?></td> <!-- Default (centered) -->
            <td><?= $row['jantina'] ?></td> <!-- Default (centered) -->
            <td>
                <a href="update.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm custom-btn">UPDATE</a>
                <button class="btn btn-danger btn-sm custom-btn" onclick="showDeleteAlert(<?= $row['id'] ?>)">DELETE</button>
            </td>
        </tr>
    <?php endwhile; ?>
</tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Delete Confirmation -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title text-center" id="deleteModalLabel">DELETE!</h5>
                    <button type="button" class="btn-close" style="color: white;" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-2">
                    <b>Adakah anda pasti untuk menghapuskan rekod ini?</b>
                    <br><br>
                    <p>Sila pastikan dengan betul!</p>
                </div>
                <div class="modal-footer d-flex justify-content-start">
                    <button type="button" class="btn btn-danger btn-sm" id="confirmDeleteBtn">YES DELETE!</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">CANCEL</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        let deleteId = null;

        // Show delete confirmation modal and store the ID to delete
        function showDeleteAlert(id) {
            deleteId = id;
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }

        // Handle the deletion after confirmation
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (deleteId !== null) {
                window.location.href = `delete.php?id=${deleteId}`;
            }
        });
    </script>
</body>

</html>
