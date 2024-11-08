<?php
    session_start();
    if (!isset($_SESSION["admin"])) {
        echo "<script>document.location.href = '../index.php';</script>";
    }
    require "../database/koneksi.php";
    
    $sql_select_kamar = mysqli_query($conn, "SELECT * FROM kamar");
    
    $kamar = [];
    while ($row_kamar = mysqli_fetch_assoc($sql_select_kamar)) {
        $kamar[] = $row_kamar;
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
    <h1>Daftar Kamar</h1>
    <div class="manipulation-data">
        <a href="data_kamar.php" id="refresh"><i class="fa-solid fa-arrows-rotate"></i> Refresh</a>
        <a href="tambah_kamar.php" id="tambah"><i class="fa-solid fa-plus"></i> Tambah Kamar</a>
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
                    <th>Foto</th>
                    <th>Jenis Kamar</th>
                    <th>Jumlah Kasur</th>
                    <th>Jumlah Kamar Mandi</th>
                    <th>Maksimal</th>
                    <th>Tersedia</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach($kamar as $kmr) : ?>
                <?php $direktori = "../database/foto_kamar/" . $kmr["foto"];?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?php echo "<img src='$direktori' alt='Foto kamar' width='150px' heigth='140px'>";?></td>
                    <td><?php echo $kmr["jenis_kamar"];?></td>
                    <td><?php echo $kmr["kasur"] . " Kasur";?></td>
                    <td><?php echo $kmr["kamar_mandi"] . " Kamar Mandi";?></td>
                    <td><?php echo $kmr["orang"] . " Orang";?></td>
                    <td><?php echo $kmr["jumlah_kamar"] . " Kamar";?></td>
                    <td><?php echo "Rp " . $kmr["harga"];?></td>
                    <td style="text-align: center">
                        <div class="action-button">
                            <a href="update_kamar.php?kamar=<?= $kmr['id'] ?>">
                                <button class="delete-data">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                            </a>
                            <a href="../database/delete.php?kamar=<?= $kmr['id'] ?>" onclick="return confirm('Yakin ingin menghapus data kamar ini?');">
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
<script src="../searchjs/livesearch.js?v=<?php echo time(); ?>"></script>
</html>