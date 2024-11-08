<?php 
session_start();
if (!isset($_SESSION["user"])) {
    echo "<script>document.location.href = '../crudAdmin/dashboard.php';</script>";
}
require "../database/koneksi.php";

if (isset($_SESSION["user"])){
    $select_pengguna = mysqli_query($conn, "SELECT * FROM pengguna WHERE username = '$_SESSION[username]'");
    if (mysqli_num_rows ($select_pengguna) == 0 && isset($_SESSION["user"])) {
      echo 
      "<script>
      document.location.href = '../login_page/logout.php?logout=true';
      </script>";
    }
}

$sql_pemesanan = mysqli_query($conn, "SELECT 
        pgg.username, pgg.nama_lengkap, 
        psn.tanggal_pesan, psn.tanggal_checkin, psn.tanggal_checkout, psn.jml_kamar, psn.total_harga,psn.id,
        kmr.jenis_kamar
    FROM 
        pengguna pgg
    JOIN 
        pemesanan psn ON pgg.username = psn.user_pemesan
    JOIN 
        kamar kmr ON psn.id_kamar = kmr.id WHERE user_pemesan = '$_SESSION[username]'");
$pemesanan = [];

while ($row = mysqli_fetch_assoc($sql_pemesanan)) {
    $pemesanan[] = $row;
}

$sql_pengguna = mysqli_query($conn, "SELECT * FROM pengguna WHERE username = '$_SESSION[username]'");
while ($row = mysqli_fetch_assoc($sql_pengguna)) {
    $pengguna[] = $row;
}

$pengguna = $pengguna[0];

if (isset($_POST["profil"])) {
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $no_hp = $_POST["no_hp"];

    $foto = $_FILES["gambar"]["name"];
    $temp = $_FILES["gambar"]["tmp_name"];

    if ($foto == "") {
        $sql = "UPDATE pengguna SET nama_lengkap='$nama', email='$email', telepon='$no_hp' WHERE username = '$_SESSION[username]'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "
            <script>
            alert('Berhasil Mengubah Profil!');
            document.location.href = 'profil.php';
            </script>
            ";
        } else {
            echo "
            <script>
            alert('Gagal Mengubah Profil!');
            </script>
            ";
        }
    } else {
        date_default_timezone_set("Asia/Makassar");
        $ekstensi = explode('.', $foto);
        $ekstensi = strtolower(end($ekstensi));
        $namabaru = date("Y-m-d H.i.s") . "." . $ekstensi;
        $direktori = "../database/profil_pengguna/" . $namabaru;
        $support = ["jpg", "jepg", "png"];

        if (in_array($ekstensi, $support)) {
            if (move_uploaded_file($temp, $direktori)) {
                $sql = "UPDATE pengguna SET nama_lengkap='$nama', email='$email', telepon='$no_hp', foto='$namabaru' WHERE username = '$_SESSION[username]'";

                $result = mysqli_query($conn, $sql);

                if ($result) {
                    echo "
                    <script>
                    alert('Berhasil Mengubah Profil!');
                    document.location.href = 'profil.php';
                    </script>
                    ";
                } else {
                    echo "
                    <script>
                    alert('Gagal Mengubah Profil!');
                    </script>
                    ";
                }
            }
        }
    }
}

if (isset($_POST["pw"])) {
    $password_lama = $_POST["password_lama"];
    $password_baru = $_POST["password_baru"];
    $konfirmasi = $_POST["konfirmasi"];

    $sql = mysqli_query($conn, "SELECT pasword FROM pengguna WHERE username = '$_SESSION[username]'");
    $data = mysqli_fetch_assoc($sql);

    if ($data) {
        if (password_verify($password_lama, $data["pasword"])) {
            if ($password_baru == $konfirmasi) {
                $password_baru = password_hash($password_baru, PASSWORD_DEFAULT);
                $sql = "UPDATE pengguna SET pasword='$password_baru' WHERE username = '$_SESSION[username]'";

                $result = mysqli_query($conn, $sql);

                if ($result) {
                    echo "
                    <script>
                    alert('Berhasil Mengubah Password!');
                    document.location.href = 'profil.php';
                    </script>
                    ";
                } else {
                    echo "
                    <script>
                    alert('Gagal Mengubah Password!');
                    </script>
                    ";
                }
            } else {
                echo "
                <script>
                alert('Password Baru dan Konfirmasi Password tidak sama!');
                </script>
                ";
            }
        } else {
            echo "
            <script>
            alert('Password Lama Salah!');
            </script>
            ";
        }
    } else {
        echo "
        <script>
        alert('Data tidak ditemukan.');
        </script>
        ";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../styles.css">
</head>
<?php include ("../login_page/navbar.php"); ?>
<body>
    <div class="container">
        <div class="profile">
            <div class="profile-header">
                <?php $direktori = "../database/profil_pengguna/".$pengguna["foto"]; ?>
                <?php if ($pengguna["foto"] == "") {
                    echo "<img src='https://gravatar.com/avatar/00000000000000000000000000000000?d=mp' alt='Foto Profil' class='profile-img'>";
                } else {
                    echo "<img src='$direktori' alt='Foto Profil' class='profile-img'>";
                } ?>
                <div class="profile-text-container">
                    <h1 class="profile-title"><?= $pengguna["username"] ?></h1>
                    <p class="profile-email"><?= $pengguna["email"] ?></p>
                </div>
            </div>
            <div class="menu">
                <a class="menu-link" onclick="openTab('akun')"><i class="fa-solid fa-user menu-icon"></i>Informasi Akun</a>
                <a class="menu-link" onclick="openTab('keamanan')"><i class="fa-solid fa-lock menu-icon"></i>Ganti Password</a>
                <a class="menu-link" onclick="openTab('riwayat')"><i class="fa-solid fa-ticket menu-icon"></i>Riwayat Reservasi</a>
                <a class="menu-link" href="../login_page/logout.php?logout=true"><i class="fa-solid fa-sign-out menu-icon"></i>Keluar</a>
            </div>
        </div>

        <div id="akun" class="account">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="account-header">
                    <h1 class="account-title">Informasi Akun</h1>
                    <div class="btn-container">
                        <button class="btn-save" name="profil">Simpan</button>
                        <button class="btn-cancel">Batal</button>
                    </div>
                </div>

                <div class="account-edit">
                    <div class="input-container">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" value="<?= $pengguna["nama_lengkap"] ?>" maxlength="50" required>
                    </div>
                </div>

                <div class="account-edit">
                    <div class="input-container">
                        <label>Email</label>
                        <input type="email" name="email" id="email" value="<?= $pengguna["email"] ?>" maxlength="100" required>
                    </div>
                    <div class="input-container">
                        <label>Nomor Hp</label>
                        <input type="text" name="no_hp" id="no_hp" value="<?= $pengguna["telepon"] ?>" pattern="[0-9]{12}" inputmode="numeric" title="Masukkan Angka 12 Digit" required>
                    </div>
                </div>

                <div class="account-edit">
                    <div class="input-container">
                        <label>Ubah Foto Profil</label>
                        <input type="file" name="gambar" id="gambar">
                    </div>
                </div>

            </form>
        </div>

        <div id="keamanan" class="account">
            <form action="" method="POST">
                <div class="account-header">
                    <h1 class="account-title">Ganti Password</h1>
                    <div class="btn-container">
                        <button class="btn-save" name="pw">Simpan</button>
                        <button class="btn-cancel">Batal</button>
                    </div>
                </div>

                <div class="account-edit">
                    <div class="input-container">
                        <label>Password Lama</label>
                        <input type="password" name="password_lama" id="password_lama" placeholder="Password Lama" minlength="8" maxlength="255" required>
                    </div>
                </div>

                <div class="account-edit">
                    <div class="input-container">
                        <label>Password Baru</label>
                        <input type="password" name="password_baru" id="password_baru" placeholder="Password Baru" minlength="8" maxlength="255" required>
                    </div>
                </div>

                <div class="account-edit">
                    <div class="input-container">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" name="konfirmasi" id="konfirmasi" placeholder="Konfirmasi Password Baru" minlength="8" maxlength="255" required>
                    </div>
                </div>
            </form>
        </div>

        <div id="riwayat" class="account">
            <div class="account-header">
                <h1 class="account-title">Riwayat Reservasi</h1>
            </div>
            <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Reservasi</th>
                        <th>Tanggal Check-in</th>
                        <th>Tanggal Check-out</th>
                        <th>Jenis Kamar</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach($pemesanan as $res) : ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $res["tanggal_pesan"] ?></td>
                        <td><?= $res["tanggal_checkin"] ?></td>
                        <td><?= $res["tanggal_checkout"] ?></td>
                        <td><?= $res["jenis_kamar"] ?></td>
                        <td><?= $res["jml_kamar"] ?></td>
                        <td><?= $res["total_harga"] ?></td>
                        <td>
                        <a href="../database/delete.php?pemesanan=<?= $res['id'] ?>&jumlah=<?= $res['jml_kamar']?>&jenis=<?= $res['jenis_kamar']?>" id="hapus" onclick="return confirm('Yakin ingin membatalkan pemesanan ini?');"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php $i++; endforeach; ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <script>
        if (window.location.href.indexOf("riwayat") > -1) {
            document.getElementById('riwayat').classList.add('active');
            document.querySelector('.menu-link[onclick*="riwayat"]').classList.add('active');
        } else {
            document.getElementById('akun').classList.add('active');
            document.querySelector('.menu-link[onclick*="akun"]').classList.add('active');
        }

        function openTab(tabName) {
            var i, tabContent, tabs;
            tabContent = document.getElementsByClassName('account');
            for (i = 0; i < tabContent.length; i++) {
                tabContent[i].classList.remove('active');
            }
            tabs = document.getElementsByClassName('menu-link');
            for (i = 0; i < tabs.length; i++) {
                tabs[i].classList.remove('active');
            }
            document.getElementById(tabName).classList.add('active');
            event.currentTarget.classList.add('active');
        }

    document.getElementById('gambar').addEventListener('input', function() {
        const limit = 3 * 1024 * 1024;
        var file = this.files[0];
        var ext = file.name.split(".").pop();

        if (file.size > limit) {
            alert('Maksimal File Adalah 3 MB');
            this.value = "";
        }
        
        if (ext == "png" || ext == "jpg" || ext == "jpeg") {
            return;
            
        } else {
            alert("Ekstensi File Harus png, jpg, jpeg");
            this.value = "";
        }
    })
    </script>
    <script src="../script.js" defer></script>
</body>
</html>