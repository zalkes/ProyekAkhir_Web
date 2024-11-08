<?php
    session_start();
    if (!isset($_SESSION["admin"])) {
        echo "<script>document.location.href = '../index.php';</script>";
    }
    require "../database/koneksi.php";
    
    $keyword = $_GET['keyword'];
    $sql = "SELECT 
        pgg.username, pgg.nama_lengkap, 
        psn.tanggal_pesan, psn.tanggal_checkin, psn.tanggal_checkout, psn.jml_kamar, psn.total_harga,psn.id,
        kmr.jenis_kamar
    FROM 
        pengguna pgg
    JOIN 
        pemesanan psn ON pgg.username = psn.user_pemesan
    JOIN 
        kamar kmr ON psn.id_kamar = kmr.id
    WHERE pgg.username LIKE '%$keyword%' OR pgg.nama_lengkap LIKE '%$keyword%' OR kmr.jenis_kamar LIKE '%$keyword%' OR psn.tanggal_pesan LIKE '%$keyword%' OR psn.tanggal_checkin LIKE '%$keyword%' OR psn.tanggal_checkout LIKE '%$keyword%' OR psn.jml_kamar LIKE '%$keyword%' OR psn.total_harga LIKE '%$keyword%';";

    $select_pesanan = mysqli_query($conn, $sql);
    
    $pesanan = [];
    while ($row_pesan = mysqli_fetch_assoc($select_pesanan)) {
        $pesanan[] = $row_pesan;
    }
?>

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
                    <a href="../database/delete.php?pemesanan=<?= $pesan['id'] ?>&jumlah=<?= $pesan['jml_kamar']?>&jenis=<?= $pesan['jenis_kamar']?>" onclick="return confirm('Yakin ingin menghapus bukti pembelian ini?');">
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