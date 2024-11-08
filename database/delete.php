<?php
    session_start();
    require "koneksi.php";
    
    if (isset($_GET["username"])){
        $username = $_GET["username"];
        $select = mysqli_query($conn, "SELECT * FROM pengguna WHERE username = '$username'");
        $pengguna = mysqli_fetch_assoc($select);
        $deletePemesanan = mysqli_query($conn, "DELETE FROM pemesanan WHERE user_pemesan = '$username'");
        $filePath = "../database/profil_pengguna/" . $pengguna["foto"];
        if (file_exists($filePath) && !is_dir($filePath)) {
            unlink($filePath);
        }
        $result = mysqli_query($conn, "DELETE FROM pengguna WHERE username = '$username'");
    
        if ($result) {
            echo "
            <script>
            alert('Berhasil Menghapus Data Pengguna!');
            document.location.href = '../crudAdmin/data_pengguna.php';
            </script>
            ";
        }
    }
    
    if (isset($_GET["kamar"])){
        $id = $_GET["kamar"];

        $select = mysqli_query($conn, "SELECT * FROM kamar WHERE id = $id");
        $kamar = mysqli_fetch_assoc($select);
        $filePath = '../database/foto_kamar/' . $kamar["foto"];
        if (file_exists($filePath)) {
            unlink($filePath);
        } else {
            echo "File tidak ada: " . $filePath;
        }

        $result = mysqli_query($conn, "DELETE FROM pemesanan WHERE id_kamar = $id");
        $result = mysqli_query($conn, "DELETE FROM kamar WHERE id = $id");
        
        if ($result){
            echo "
            <script>
            alert('Berhasil Menghapus Data Kamar!');
            document.location.href = '../crudAdmin/data_kamar.php';
            </script>
            ";
        }
    }

    if (isset($_GET["pemesanan"])  && isset($_GET["jumlah"] ) && isset($_GET["jenis"])){
        $id = $_GET["pemesanan"];
        $jenis = $_GET["jenis"];
        $jumlah_kamar = $_GET["jumlah"];
        $select = mysqli_query($conn, "SELECT * FROM kamar WHERE jenis_kamar = '$jenis'");
        $kamar = mysqli_fetch_assoc($select);
        $hasil_kamar = $kamar["jumlah_kamar"] + $jumlah_kamar;
        $update_kamar = mysqli_query($conn, "UPDATE kamar SET jumlah_kamar=$hasil_kamar WHERE jenis_kamar = '$jenis'");

        
        $result = mysqli_query($conn, "DELETE FROM pemesanan WHERE id = $id");

        if ($result) {
            if (isset($_SESSION["user"])) {
                echo "
                <script>
                alert('Berhasil Membatalkan Pesanan!');
                document.location.href = '../user_profile/profil.php';
                </script>
                ";
            }
            else {
                echo "
                <script>
                alert('Berhasil Membatalkan Pesanan!');
                document.location.href = '../crudAdmin/data_pesanan.php';
                </script>
                ";
            }
        }
    }
?>