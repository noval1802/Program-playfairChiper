<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'koneksi.php';
include_once 'playfair.php';

// Fungsi untuk mengonversi nomor telepon ke bentuk yang dapat dienkripsi oleh Playfair Cipher
function convertNoTelp($no_telp) {
    $conversion = [
        '0' => 'ZERO',
        '1' => 'ONE',
        '2' => 'TWO',
        '3' => 'THREE',
        '4' => 'FOUR',
        '5' => 'FIVE',
        '6' => 'SIX',
        '7' => 'SEVEN',
        '8' => 'EIGHT',
        '9' => 'NINE',
    ];

    $converted = '';
    for ($i = 0; $i < strlen($no_telp); $i++) {
        $digit = $no_telp[$i];
        if (isset($conversion[$digit])) {
            $converted .= $conversion[$digit];
        }
    }

    return $converted;
}

// Fungsi untuk menghasilkan ID Integer yang mencakup data awal (nama, email, alamat, no_telp)
function generateUniqueId($nama, $email, $alamat, $no_telp) {
    $dataAwal = $nama . $email . $alamat . $no_telp;

    // Menggunakan hash sha256 untuk mendapatkan nilai hex
    $hashedValue = hash('sha256', $dataAwal);

    // Mengambil 6 digit pertama dari nilai hex tersebut
    $id_integer = substr($hashedValue, 0, 6);

    return $id_integer;
}

// Fungsi untuk mengenkripsi nomor telepon
function playfair_encrypt_no_telp($no_telp, $id_integer) {
    // Proses enkripsi menggunakan Playfair Cipher
    $key = generateKeyFromIdInteger($id_integer);
    $keyMatrix = generateKeyMatrix($key);
    $preparedText = prepareText($no_telp);

    $ciphertext = '';
    foreach ($preparedText as $pair) {
        $ciphertext .= encryptPair($pair, $keyMatrix);
    }

    return $ciphertext;
}

// Fungsi untuk mendekripsi nomor telepon
function playfair_decrypt_no_telp($ciphertext, $id_integer) {
    // Proses dekripsi menggunakan Playfair Cipher
    $key = generateKeyFromIdInteger($id_integer);
    $keyMatrix = generateKeyMatrix($key);
    $preparedText = prepareText($ciphertext);

    $plaintext = '';
    foreach ($preparedText as $pair) {
        $plaintext .= decryptPair($pair, $keyMatrix);
    }

    return $plaintext;
}

// Fungsi untuk memeriksa apakah ID Integer sudah ada di dalam database
function isIdIntegerExist($id_integer, $conn) {
    $check_sql = "SELECT id_integer FROM data WHERE id_integer = ?";
    $stmtCheck = $conn->prepare($check_sql);
    $stmtCheck->bind_param("s", $id_integer);
    $stmtCheck->execute();
    $stmtCheck->store_result();
    return $stmtCheck->num_rows > 0;
}

// Fungsi untuk memvalidasi panjang input
function validateLength($input, $max_length, $field_name) {
    if (strlen($input) > $max_length) {
        echo "<script>alert('Error: $field_name terlalu panjang.');</script>";
        echo "<script>window.location.href = 'index.php';</script>";
        exit();
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];

    // Validasi panjang nama, email, dan nomor telepon
    validateLength($nama, 512, 'Nama');
    validateLength($email, 512, 'Email');
    validateLength($alamat, 512, 'Alamat');
    validateLength($no_telp, 512, 'Nomor Telepon');

    // Membersihkan nomor telepon dari karakter yang tidak valid
    $no_telp = preg_replace('/[^0-9]/', '', $no_telp);

    // Mengonversi nomor telepon ke bentuk yang dapat dienkripsi oleh Playfair Cipher
    $no_telp_converted = convertNoTelp($no_telp);

    // Menggunakan ID Integer yang mencakup data awal pada saat penginputan data
    $id_integer = generateUniqueId($nama, $email, $alamat, $no_telp);

    // Pemeriksaan ID yang Unik
    while (isIdIntegerExist($id_integer, $conn)) {
        $id_integer = generateUniqueId($nama, $email, $alamat, $no_telp);
    }

    // Enkripsi data menggunakan Playfair Cipher
    $playfair_result_no_telp = playfair_encrypt_no_telp($no_telp_converted, $id_integer);

    $nama_encrypted = playfair_encrypt($nama, $id_integer)['ciphertext'];
    $email_encrypted = playfair_encrypt($email, $id_integer)['ciphertext'];
    $alamat_encrypted = playfair_encrypt($alamat, $id_integer)['ciphertext'];
    $no_telp_encrypted = $playfair_result_no_telp;
    
    // Simpan data awal ke dalam kolom data_awal
    $data_awal = json_encode(['nama' => $nama, 'email' => $email, 'alamat' => $alamat, 'no_telp' => $no_telp]);
    
    // Gantilah 'nama_tabel' sesuai dengan nama tabel yang Anda gunakan
    $insert_sql = "INSERT INTO data (id_integer, nama, email, alamat, no_telp, data_awal) VALUES (?, ?, ?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($insert_sql);
    $stmtInsert->bind_param("ssssss", $id_integer, $nama_encrypted, $email_encrypted, $alamat_encrypted, $no_telp_encrypted, $data_awal);
    
    try {
        // Eksekusi Prepared Statement
        $isExecuted = $stmtInsert->execute();

        if ($isExecuted) {
            // Jika berhasil disimpan, tampilkan popup dengan hasil ID Integer
            $stmtInsert->close();
            $conn->close();
            echo "<script>alert('Data berhasil disimpan. ID Anda adalah : $id_integer');</script>";
            echo "<script>window.location.href = 'cari.php?id=$id_integer';</script>";
            exit(); // Pastikan untuk keluar setelah melakukan redirect
        } else {
            // Jika terjadi kesalahan lain, tangkap exception dan tampilkan pesan error SQL
            throw new Exception("Error: " . $stmtInsert->error);
        }
    } catch (Exception $e) {
        // Tangkap exception dan tampilkan pesan error
        echo "Error: " . $e->getMessage();
    }
}
?>