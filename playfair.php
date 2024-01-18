<?php
function playfair_encrypt($plaintext, $id_integer) {
    // Generate key from ID Integer
    $key = generateKeyFromIdInteger($id_integer);
    $keyMatrix = generateKeyMatrix($key);

    // Simpan informasi enkripsi, termasuk plaintext
    $encryptionInfo = [
        'id_integer' => $id_integer,
        'plaintext' => $plaintext,
        'ciphertext' => ''
    ];

    $preparedText = prepareText($plaintext);

    foreach ($preparedText as $pair) {
        $encryptionInfo['ciphertext'] .= encryptPair($pair, $keyMatrix);
    }

    return $encryptionInfo;
}
function playfair_decrypt($ciphertext, $id_integer) {
    $key = generateKeyFromIdInteger($id_integer);
    $keyMatrix = generateKeyMatrix($key);
    $preparedText = prepareText($ciphertext);

    $plaintext = '';
    foreach ($preparedText as $pair) {
        $plaintext .= decryptPair($pair, $keyMatrix);
    }

    return $plaintext;
}
// Fungsi untuk menghasilkan kunci dari ID Integer
function generateKeyFromIdInteger($id_integer) {
    return hash('sha256', $id_integer);
}

function prepareText($text) {
    $text = strtoupper($text);
    $text = str_replace('J', 'I', $text);
    $text = preg_replace('/[^A-Z]/', '', $text);

    $textPairs = str_split($text, 2);
    $preparedText = array();

    foreach ($textPairs as $pair) {
        if (strlen($pair) == 1) {
            // Jika panjang pair adalah 1, abaikan karakter ini
            continue;
        }
        $preparedText[] = $pair;
    }

    return $preparedText;
}

function findCharPosition($char, $keyMatrix) {
    foreach ($keyMatrix as $row => $cols) {
        foreach ($cols as $col => $value) {
            if ($value == $char) {
                return array($row, $col);
            }
        }
    }
    // Modifikasi di sini: kembalikan array dengan nilai -1 jika karakter tidak ditemukan
    return array(-1, -1);
}


function encryptPair($pair, $keyMatrix) {
    if (strlen($pair) !== 2) {
        // Pastikan panjang pair adalah 2, jika tidak, abaikan
        return '';
    }

    list($row1, $col1) = findCharPosition($pair[0], $keyMatrix);
    list($row2, $col2) = findCharPosition($pair[1], $keyMatrix);

    $encryptedPair = '';

    if ($row1 == $row2) {
        $col1 = ($col1 + 1) % 5;
        $col2 = ($col2 + 1) % 5;
        $encryptedPair .= $keyMatrix[$row1][$col1] . $keyMatrix[$row2][$col2];
    } elseif ($col1 == $col2) {
        $row1 = ($row1 + 1) % 5;
        $row2 = ($row2 + 1) % 5;
        $encryptedPair .= $keyMatrix[$row1][$col1] . $keyMatrix[$row2][$col2];
    } else {
        // Jika berbeda baris dan kolom, ambil diagonal
        $encryptedPair .= $keyMatrix[$row1][$col2] . $keyMatrix[$row2][$col1];
    }

    return $encryptedPair;
}


function decryptPair($pair, $keyMatrix) {
    list($row1, $col1) = findCharPosition($pair[0], $keyMatrix);
    list($row2, $col2) = findCharPosition($pair[1], $keyMatrix);

    // Modifikasi di sini: tambahkan pengecekan jika karakter tidak ditemukan
    if ($row1 === -1 || $col1 === -1 || $row2 === -1 || $col2 === -1) {
        return ''; // Atau lakukan penanganan sesuai kebutuhan
    }

    if ($row1 == $row2) {
        $col1 = ($col1 - 1 + 5) % 5;
        $col2 = ($col2 - 1 + 5) % 5;
    } elseif ($col1 == $col2) {
        $row1 = ($row1 - 1 + 5) % 5;
        $row2 = ($row2 - 1 + 5) % 5;
    } else {
        $temp = $col1;
        $col1 = $col2;
        $col2 = $temp;
    }

    return $keyMatrix[$row1][$col1] . $keyMatrix[$row2][$col2];
}


// Fungsi untuk menghasilkan key secara otomatis dan acak
function generateRandomKey() {
    $characters = 'ABCDEFGHIKLMNOPQRSTUVWXYZ';
    $key = '';
    for ($i = 0; $i < 5; $i++) {
        $key .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $key;
}

// Fungsi untuk menghasilkan matriks kunci
function generateKeyMatrix($key) {
    $key = strtoupper($key);
    $key = str_replace('J', 'I', $key);

    $alphabet = 'ABCDEFGHIKLMNOPQRSTUVWXYZ';
    $keyMatrix = array();

    $keyChars = str_split($key . $alphabet);
    $keyChars = array_unique($keyChars);

    $row = $col = 0;
    foreach ($keyChars as $char) {
        $keyMatrix[$row][$col] = $char;
        $col++;
        if ($col == 5) {
            $col = 0;
            $row++;
        }
    }

    return $keyMatrix;
}
?>
