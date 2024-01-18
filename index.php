<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Playfair Cipher</title>
    <!-- Tambahkan link CSS Bootstrap di bawah ini -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }
    </style>
</head>
<?php
        // Cek apakah terdapat pesan error dari proses_input.php
        if (isset($_GET['error'])) {
            $errorMessage = $_GET['error'];
            echo '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>';
        }
        ?>
<body>
    <div class="container">
        <h2 class="mt-3 mb-4">Form Pengisian Data</h2>
        <form action="proses_input.php" method="post">
            <div class="form-group">
                <label for="nama">Nama :</label>
                <input type="text" class="form-control" name="nama" required maxlength="255">
            </div>

            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" class="form-control" name="email" required maxlength="255">
            </div>
            <div class="form-group">
                <label for="nama">Alamat :</label>
                <input type="text" class="form-control" name="alamat" required maxlength="512">
            </div>
            
            <div class="form-group">
                <label for="no_telp">No.Telp :</label>
                <input type="text" class="form-control" name="no_telp" required maxlength="512">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <!-- Tambahkan script JS Bootstrap di bawah ini (opsional, tergantung kebutuhan) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
