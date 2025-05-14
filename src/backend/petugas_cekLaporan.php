<?php

include '../connect.php';

function query($query) {
    global $db; // agar var $db diluar bisa digunakan dalam function ini
    $result = mysqli_query($db, $query); // mysql: $db, ya buat gunain db
                                                       // query: $query, command mysql nya 
    $rows = []; // nyediain tempat buat nanti diisi data
    while ($row = mysqli_fetch_assoc($result)) { // nyimpen data dari db ke $row
        $rows[] = $row; // array $rows diisi dengan data $row secara rapi dan berurutan
    }
    return $rows; // mengembalikan hasil fungsi ke $rows (masih ga ngerti fungsi return, wek)
}

?>
