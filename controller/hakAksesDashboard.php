<?php
if (!isset($_SESSION['role'])) {
    header("Location: loginUser.php");
    exit;
  }
?>