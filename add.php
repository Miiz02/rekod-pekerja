<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_pekerja'];
    $no_kp = $_POST['no_kp'];
    $jantina = $_POST['jantina'];
    $no_hp = $_POST['no_hp'];

    $sql = "INSERT INTO pekerja (nama_pekerja, no_kp, jantina, no_hp) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nama, $no_kp, $jantina, $no_hp);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Failed to add pekerja.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .form-control {
            border: 1px solid #bbb;
            /* Black border */
        }

        .form-select {
            border: 1px solid #bbb;
            /* Black border */
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0056b3;
            /* Change border color when focused */
            box-shadow: 0 0 5px rgba(0, 86, 179, 0.5);
            /* Add shadow on focus */
        }
    </style>
    <title>Add Maklumat</title>
</head>

<body class="bg-dark text-light">
    <!-- Navbar -->
    <nav class="navbar navbar-light bg-light rounded m-2 px-3">
        <a href="dashboard.php" class="btn btn-primary">Back</a>
    </nav>

    <!-- Add Pekerja Form -->
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card p-4 w-25">
            <h2 class="text-center text-dark mb-4">ADD MAKLUMAT</h2>
            <form method="POST">
                <div class="mb-3">
                    <label for="no_kp" class="form-label text-dark fw-bold">IC</label>
                    <input type="text" name="no_kp" id="no_kp" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="nama_pekerja" class="form-label text-dark fw-bold">NAMA</label>
                    <input type="text" name="nama_pekerja" id="nama_pekerja" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label for="no_hp" class="form-label text-dark fw-bold">HP</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="jantina" class="form-label text-dark fw-bold">JANTINA</label>
                    <select name="jantina" id="jantina" class="form-select" required>
                        <option value="" disabled selected>--Sila Pilih--</option>
                        <option value="Lelaki">Lelaki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <!-- Buttons -->
                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary w-45">Add</button>
                    <button type="reset" class="btn text-danger border-0 bg-transparent w-45">Clear</button>
                </div>
                <?php if (isset($error)) echo "<p class='text-danger text-center mt-3'>$error</p>"; ?>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>