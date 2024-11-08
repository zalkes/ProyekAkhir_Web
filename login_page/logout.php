<?php
if (isset($_GET["logout"])){
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../index.php");
} else {
    echo "<script>document.location.href = '../index.php';</script>";
}
?>