<?php
    session_start();
    if (!isset($_SESSION["admin"])) {
        echo "<script>document.location.href = '../index.php';</script>";
    }
    require "../database/koneksi.php";

    $keyword = $_GET['keyword'];
    $sql_select_kamar = mysqli_query($conn, "SELECT * FROM kamar WHERE jenis_kamar LIKE '%$keyword%' OR kasur LIKE '%$keyword%' OR kamar_mandi LIKE '%$keyword%' OR orang LIKE '%$keyword%' OR jumlah_kamar LIKE '%$keyword%' OR harga LIKE '%$keyword%'");
    
    $kamar = [];
    while ($row_kamar = mysqli_fetch_assoc($sql_select_kamar)) {
        $kamar[] = $row_kamar;
    }
?>

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
                    <a href="../database/delete.php?kamar=<?= $kmr['id'] ?>" onclick="return confirm('Yakin ingin menghapus bukti pembelian ini?');">
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