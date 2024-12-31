<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
include 'db_conn.php';

// Get the record ID from the URL
$id = $_GET['id'] ?? null; // If there's no ID, it should be handled properly
if ($id === null) {
    header("Location: dashboard.php"); // Redirect to dashboard if no ID
    exit;
}

// Fetch the existing record from the database
$sql = "SELECT * FROM pekerja WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$record = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_pekerja'];
    $no_kp = $_POST['no_kp'];
    $jantina = $_POST['jantina'];
    $no_hp = $_POST['no_hp'];

    // Update the record in the database
    $update_sql = "UPDATE pekerja SET nama_pekerja = ?, no_kp = ?, jantina = ?, no_hp = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssi", $nama, $no_kp, $jantina, $no_hp, $id);

    if ($update_stmt->execute()) {
        header("Location: dashboard.php"); // Redirect to the dashboard after updating
        exit;
    } else {
        $error = "Failed to update pekerja.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    .form-control {
        border: 1px solid #bbb;
        /* Light grey border */
    }

    .form-select {
        border: 1px solid #bbb;
        /* Light grey border */
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0056b3;
        /* Change border color when focused */
        box-shadow: 0 0 5px rgba(0, 86, 179, 0.5);
        /* Add shadow on focus */
    }

    .form-label {
        font-weight: bold;
    }

    /* Remove border for disabled fields */
    input:disabled, select:disabled {
        border: none;
        background-color: #f8f9fa; /* Light background color to indicate it's disabled */
        color: #6c757d; /* Gray text to indicate disabled state */
    }
</style>

    <title>Update Pekerja</title>
</head>

<body class="bg-dark text-light">
    <!-- Navbar -->
    <nav class="navbar navbar-light bg-light rounded m-2 px-3">
        <a href="dashboard.php" class="btn btn-primary">Back</a>
    </nav>

    <!-- Update Pekerja Form -->
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card p-4 w-100" style="height: auto;">
            <h2 class="text-center text-dark mb-4">UPDATE MAKLUMAT <?= htmlspecialchars($record['nama_pekerja']) ?></h2>
            <form method="POST">
    <div class="mb-3">
        <label for="no_kp" class="form-label text-dark">IC</label>
        <input type="text" name="no_kp" id="no_kp" class="form-control" value="<?= htmlspecialchars($record['no_kp']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="nama_pekerja" class="form-label text-dark">NAMA</label>
        <!-- Use a hidden input if you do not want the user to edit it, but still need to submit -->
        <input type="hidden" name="nama_pekerja" value="<?= htmlspecialchars($record['nama_pekerja']) ?>">
        <input type="text" name="nama_pekerja_display" id="nama_pekerja_display" class="form-control" value="<?= htmlspecialchars($record['nama_pekerja']) ?>" disabled>
    </div>
    <div class="mb-3">
        <label for="no_hp" class="form-label text-dark">HP</label>
        <input type="text" name="no_hp" id="no_hp" class="form-control" value="<?= htmlspecialchars($record['no_hp']) ?>" required>
    </div>
    <div class="mb-3">
               <label for="jantina" class="form-label text-dark">JANTINA</label>
               <select name="jantina" id="jantina" class="form-select" required>
                   <option value="" selected>Sila Pilih</option>
                   <option value="Lelaki" <?= ($record['jantina'] == 'Lelaki') ? '' : '' ?>>Lelaki</option>
                   <option value="Perempuan" <?= ($record['jantina'] == 'Perempuan') ? '' : '' ?>>Perempuan</option>
               </select>
           </div>
    <!-- Buttons -->
    <div class="d-flex justify-content-between align-items-center">
        <button type="submit" class="btn btn-primary w-45">Update</button>
        <button type="reset" class="btn text-danger border-0 bg-transparent w-45">Clear</button>
    </div>
    <?php if (isset($error)) echo "<p class='text-danger text-center mt-3'>$error</p>"; ?>
</form>

            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
