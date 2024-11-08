<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: ../login_page/login.php");
    exit;
}
require "../database/koneksi.php";
date_default_timezone_set('Asia/Makassar');

if (isset($_SESSION["user"])){
    $select_pengguna = mysqli_query($conn, "SELECT * FROM pengguna WHERE username = '$_SESSION[username]'");
    if (mysqli_num_rows ($select_pengguna) == 0 && isset($_SESSION["user"])) {
      echo 
      "<script>
      document.location.href = '../login_page/logout.php?logout=true';
      </script>";
    }
}

$id;
$kamar;
$tanggal = date('Y-m-d');
if (isset($_GET["kamar"])){
    $id = $_GET["kamar"];

    $select = mysqli_query($conn, "SELECT * FROM kamar WHERE id='$id'");
    $kamar = mysqli_fetch_assoc($select);
    $direktori2 = "../database/foto_kamar/" . $kamar["foto"];
}

if (isset($_POST["submit"])) {
    $user_pemesan = $_SESSION["username"];
    $tgl_checkin = $_POST["checkin"];
    $tgl_checkout = $_POST["checkout"];
    $jumlah_kamar = $_POST["jumlah_kamar"];
    $tanggal_pesan = date('Y-m-d H:i:s');
    $id_kamar = $kamar["id"];

    $hasil_kamar = $kamar["jumlah_kamar"] - $jumlah_kamar;
    $update_kamar = mysqli_query($conn, "UPDATE kamar SET jumlah_kamar=$hasil_kamar WHERE id = $id");
    $harga_total = $jumlah_kamar * $kamar["harga"];

    $sql = "INSERT INTO pemesanan VALUES (0 ,'$user_pemesan', '$tanggal_pesan', '$tgl_checkin', '$tgl_checkout', $id_kamar, $jumlah_kamar, $harga_total);";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "
        <script>
        alert('Berhasil Melakukan Reservasi!');
        document.location.href = '../index.php';
        </script>
        ";
    } else {
        echo "
        <script>
        alert('Gagal Melakukan Reservasi!');
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Reservasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="reservasi.css">
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="../script.js?v=<?php echo time(); ?>" defer></script>
</head>
<?php include ("../login_page/navbar.php");?>
<body>
    <div class="wrapper">
        <div class="room-info">
            <h3><?php echo $kamar["jenis_kamar"] ?></h3>
            <?php echo"<img src='$direktori2' alt='Gambar Kamar'>";?>
        </div>
        <div class="form-container">
            <form action="" method="POST">
                <h2 class="form-title">Reservasi Kamar</h2>
                <div class="form-group">
                    <label for="checkin">Tanggal Check-in</label>
                    <input type="date" name="checkin" min="<?php echo $tanggal?>" id="checkin" required>
                </div>
                <div class="form-group">
                    <label for="checkout">Tanggal Check-out</label>
                    <input type="date" name="checkout" id="checkout" readonly required>
                </div>
                <div class="form-group">
                    <label for="jumlah_kamar">Jumlah Kamar</label>
                    <input type="number" name="jumlah_kamar" placeholder="<?php echo $kamar["jumlah_kamar"] . " Kamar Tersedia"; ?>" id="jumlah_kamar" min="1" max="<?php echo $kamar["jumlah_kamar"]?>" required>
                <script>                
                document.getElementById('checkin').addEventListener('input', function(){
                    var tglCheckin = this.value;
                    var tglCheckout = document.getElementById('checkout').value;
                    if (tglCheckout && tglCheckin >= tglCheckout) {
                        alert('Tanggal check-in harus sebelum tanggal check-out!');
                        this.value = '';
                        document.getElementById('checkout').setAttribute("readonly", true);
                        return;
                    }
                    if (!tglCheckin) {
                        document.getElementById('checkout').setAttribute("readonly", true);
                        return;
                    } else {
                        document.getElementById('checkout').removeAttribute("readonly");
                    }
                    var tgl = new Date(tglCheckin);     
                    tgl.setDate(tgl.getDate() + 1); 
                    var minCheckout = tgl.toISOString().split("T")[0];
                    document.getElementById('checkout').setAttribute("min", minCheckout);
                });

                document.getElementById('jumlah_kamar').addEventListener('input', function() {
                    var maxKamar = <?php echo $kamar["jumlah_kamar"]; ?>;
                    var jumlahKamar = this.value;
                    if (jumlahKamar <= 0){
                        this.value = 1;
                    }

                    if (jumlahKamar > maxKamar) {
                        alert('Jumlah kamar yang dipesan melebihi jumlah kamar tersedia!');
                        this.value = maxKamar;
                    }
                });
                </script>
                </div>
                <button type="submit" name="submit" class="submit-btn">Reservasi</button>
            </form>
        </div>
    </div>
</body>
</html>