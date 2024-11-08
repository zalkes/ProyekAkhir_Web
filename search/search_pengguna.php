<?php
    session_start();
    if (!isset($_SESSION["admin"])) {
        echo "<script>document.location.href = '../index.php';</script>";
    }
    require "../database/koneksi.php";

    $keyword = $_GET['keyword'];
    $sql_select_pengguna = mysqli_query($conn, "SELECT * FROM pengguna WHERE username LIKE '%$keyword%' OR nama_lengkap LIKE '%$keyword%' OR email LIKE '%$keyword%' OR telepon LIKE '%$keyword%'");

    $pengguna = [];
    while ($row_pengguna = mysqli_fetch_assoc($sql_select_pengguna)) {
        $pengguna[] = $row_pengguna;
    }
?>

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
                    <a href="../database/delete.php?username=<?= $user['username'] ?>" onclick="return confirm('Yakin ingin menghapus bukti pembelian ini?');">
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

