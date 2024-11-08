<?php
    session_start();
    if (!isset($_SESSION["admin"])) {
        echo "<script>document.location.href = '../index.php';</script>";
    }
    require "../database/koneksi.php";

    
    $sql_select_pengguna = mysqli_query($conn, "SELECT * FROM pengguna");
    $sql_select_kamar = mysqli_query($conn, "SELECT * FROM kamar");
    $sql_select_pemesanan = mysqli_query($conn, "SELECT * FROM pemesanan");
    
    $kamar = [];
    while ($row_kamar = mysqli_fetch_assoc($sql_select_kamar)) {
        $kamar[] = $row_kamar;
    }

    $pengguna = [];
    while ($row_pengguna = mysqli_fetch_assoc($sql_select_pengguna)) {
        $pengguna[] = $row_pengguna;
    }
    
    $pemesanan = [];
    while ($row_pemesanan = mysqli_fetch_assoc($sql_select_pemesanan)) {
        $pemesanan[] = $row_pemesanan;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Reservasi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../database/data.css">
    <link rel="stylesheet" href="admin.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include ("sidebarAdmin.php")?>   
    <h1>Dashboard</h1>
    <div class="dashboard-container">
        <div class="dashboard-card" onclick="location.href='data_pengguna.php';" style="cursor: pointer;">
            <i class="fa-solid fa-user" id="pengguna"></i>
            <h2>Total Pengguna</h2>
            <p><?php echo count($pengguna); ?></p>
        </div>
        <div class="dashboard-card" onclick="location.href='data_kamar.php';" style="cursor: pointer;">
            <i class="fa-solid fa-hotel" id="kamar"></i>
            <h2>Total Kamar</h2>
            <p><?php echo count($kamar); ?></p>
        </div>
        <div class="dashboard-card" onclick="location.href='data_pesanan.php';" style="cursor: pointer;">
            <i class="fa-solid fa-ticket" id="pesanan"></i>
            <h2>Total Pemesanan</h2>
            <p><?php echo count($pemesanan); ?></p>
        </div>
    </div>
</body>
<script src="admin.js?v=<?php echo time(); ?>"></script>
<script src="../searchjs/livesearch.js"></script>
</html>