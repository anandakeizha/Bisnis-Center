<?php
function koneksi() {
    $conn =  mysqli_connect("localhost", "root", "", "bisniscenter");
    if(!$conn){
        echo "Gagal".mysqli_connect_error()."<br>";
    }
    return $conn;
}
?>