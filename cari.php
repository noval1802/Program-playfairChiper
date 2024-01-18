<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Playfair Cipher - Cari Data</title>
    <!-- Tambahkan link CSS Bootstrap di sini -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Cari Data</h2>
                        <form action="proses_cari.php" method="get">
                            <div class="form-group">
                                <label for="id">Masukkan ID :</label>
                                <input type="text" class="form-control" name="id" required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Cari</button>
                        </form>
                        <!-- Tambahkan tombol kembali ke halaman utama -->
                        <div class="text-center mt-4">
                            <a href="index.php" class="btn btn-secondary">Kembali ke Halaman Utama</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambahkan script JS Bootstrap di sini (jika diperlukan) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
