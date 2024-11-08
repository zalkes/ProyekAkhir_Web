<?php
    session_start();
    if (!isset($_SESSION["admin"])) {
        echo "<script>document.location.href = '../index.php';</script>";
    }
    require "../database/koneksi.php";
    
    $sql_select_pengguna = mysqli_query($conn, "SELECT * FROM pengguna");

    $pengguna = [];
    while ($row_pengguna = mysqli_fetch_assoc($sql_select_pengguna)) {
        $pengguna[] = $row_pengguna;
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
    <h1>Daftar Pengguna</h1>
    
    <div class="manipulation-data">
        <a href="data_pengguna.php" id="refresh"><i class="fa-solid fa-arrows-rotate"></i> Refresh</a>
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
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Nomor Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach($pengguna as $user) : ?>
                <?php $direktori = "../database/profil_pengguna/" . $user["foto"];?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?php if ($user["foto"] == "") {echo "Foto belum ada";} else {echo "<img src='$direktori' alt='Foto pengguna' width='80px' heigth='80px'>";} ?></td>
                    <td><?php echo $user["username"];?></td>
                    <td><?php echo $user["nama_lengkap"];?></td>
                    <td><?php echo $user["email"];?></td>
                    <td><?php echo $user["telepon"];?></td>
                    <td style="text-align: center">
                        <div class="action-button">
                            <a href="../database/delete.php?username=<?= $user['username'] ?>" onclick="return confirm('Yakin ingin menghapus akun pengguna ini?');">
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