<?php
    require "../database/koneksi.php";

    $id_pemesanan = $_GET["id"];

    $result = mysqli_query($conn, "DELETE FROM pemesanan WHERE id = $id_pemesanan");

    if ($result) {
        echo "
        <script>
        alert('Berhasil Menghapus Riwayat Reservasi!');
        document.location.href = 'profil.php';
        </script>
        ";
    }
?>