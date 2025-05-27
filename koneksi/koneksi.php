<?php
function koneksi() {
    $conn =  mysqli_connect("localhost", "root", "", "Bisniscenter");
    if(!$conn){
        echo "Gagal".mysqli_connect_error()."<br>";
    }
    return $conn;
}
?>