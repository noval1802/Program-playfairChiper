<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Ambil ID dari parameter GET
    $id_integer = $_GET['id'];

    $sql = "SELECT data_awal FROM data WHERE id_integer = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_integer);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($data_awal);
        $stmt->fetch();


    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil</title>
    <!-- Tambahkan link CSS Bootstrap di sini -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Hasil</h2>
                        <?php
                        if (isset($data_awal)) {
                            // Menampilkan data awal menggunakan Bootstrap
                            echo '<div class="table-responsive">';
                            echo '<table class="table table-bordered">';
                            echo '<tbody>';
                            $data_awal_array = json_decode($data_awal, true);

                            // Membuat array untuk mapping label yang lebih ramah pengguna
                            $label_mapping = [
                                'nama' => 'Nama',
                                'email' => 'Email',
                                'alamat' => 'Alamat',
                                'no_telp' => 'No Handpone',
                            ];

                            foreach ($data_awal_array as $field => $value) {
                                echo '<tr>';
                                echo "<td><strong>{$label_mapping[$field]}:</strong></td>";
                                echo "<td>$value</td>";
                                echo '</tr>';
                            }
                            echo '</tbody>';
                            echo '</table>';
                            echo '</div>';
                        } else {
                            // Jika data tidak ditemukan
                            echo "<div class='alert alert-danger' role='alert'>Data tidak ditemukan.</div>";
                        }
                        ?>
                    </div>
                    <div class="text-center mt-4">
                        <!-- Tambahkan script JS untuk kembali ke halaman cari.php -->
                        <script>
                            function redirectToCari() {
                                window.location.href = 'index.php';
                            }
                        </script>
                        <!-- Tambahkan tombol untuk kembali ke halaman cari.php -->
                        <button class='btn btn-primary' onclick='redirectToCari()'>Halaman Utama</button>
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
