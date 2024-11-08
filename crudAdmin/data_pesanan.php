<?php
    session_start();
    if (!isset($_SESSION["admin"])) {
        echo "<script>document.location.href = '../index.php';</script>";
    }
    require "../database/koneksi.php";
    
    $sql = "SELECT 
        pgg.username, pgg.nama_lengkap, 
        psn.tanggal_pesan, psn.tanggal_checkin, psn.tanggal_checkout, psn.jml_kamar, psn.total_harga,psn.id,
        kmr.jenis_kamar
    FROM 
        pengguna pgg
    JOIN 
        pemesanan psn ON pgg.username = psn.user_pemesan
    JOIN 
        kamar kmr ON psn.id_kamar = kmr.id;";

    $select_pesanan = mysqli_query($conn, $sql);
    
    $pesanan = [];
    while ($row_pesan = mysqli_fetch_assoc($select_pesanan)) {
        $pesanan[] = $row_pesan;
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
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <?php include ("sidebarAdmin.php")?>   
    <h1>Daftar Pesanan</h1>

    <div class="manipulation-data">
        <a href="data_pesanan.php" id="refresh"><i class="fa-solid fa-arrows-rotate"></i> Refresh</a>
        <form action="" method="get" class="search">
            <input type="text" name="search" placeholder="Cari..." id="keyword">
            <button type="submit" id="tombol-cari">Cari</button>
        </form>
    </div>
    
    <div class="table-container" id="container">
        <table border=1>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama Pemesan</th>
                    <th>Jenis Kamar</th>
                    <th>Jumlah Kamar</th>
                    <th>Tanggal Pemesanan</th>
                    <th>Tanggal Check-In</th>
                    <th>Tanggal Check-Out</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach($pesanan as $pesan) : ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?php echo $pesan["username"];?></td>
                    <td><?php echo $pesan["nama_lengkap"];?></td>
                    <td><?php echo $pesan["jenis_kamar"];?></td>
                    <td><?php echo $pesan["jml_kamar"];?></td>
                    <td><?php echo $pesan["tanggal_pesan"];?></td>
                    <td><?php echo $pesan["tanggal_checkin"];?></td>
                    <td><?php echo $pesan["tanggal_checkout"];?></td>
                    <td><?php echo $pesan["total_harga"];?></td>
                    <td style="text-align: center">
                        <div class="action-button">
                            <a href="../database/delete.php?pemesanan=<?= $pesan['id'] ?>&jumlah=<?= $pesan['jml_kamar']?>&jenis=<?= $pesan['jenis_kamar']?>" onclick="return confirm('Yakin ingin membatalkan pemesanan ini?');">
                                <button class="delete-data">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php $i++; endforeach ?>
            </tbody>
        </table>
    </div>
    
</body>
<script src="admin.js?v=<?php echo time(); ?>"></script>
<script src="../searchjs/livesearch.js"></script>
</html>