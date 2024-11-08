<?php
    session_start();
    if (!isset($_SESSION["admin"])) {
        echo "<script>document.location.href = '../index.php';</script>";
    }
    require "../database/koneksi.php";

    if (isset($_POST["submit"])){
        $jenis = $_POST["type"];
        $jml_kamar = $_POST["amount"];
        $jml_kasur = $_POST["bed"];
        $jml_km = $_POST["bath"];
        $jml_org = $_POST["people"];
        $harga = $_POST["price"];
        $deskripsi = $_POST["descript"];

        $foto = $_FILES["room"]["name"];
        $temp = $_FILES["room"]["tmp_name"];

        date_default_timezone_set("Asia/Makassar");
        $ekstensi = explode('.', $foto);
        $ekstensi = strtolower(end($ekstensi));
        $namabaru = date("Y-m-d H.i.s") . "." . $ekstensi;
        $direktori = "../database/foto_kamar/" . $namabaru;
        $support = ["jpg", "jepg", "png"];

        if (in_array($ekstensi, $support)){
            if (move_uploaded_file($temp, $direktori)){
                
                $sql = "INSERT INTO kamar VALUES (0, '$jenis', '$deskripsi', $jml_kasur, $jml_km, $jml_org, $harga, $jml_kamar, '$namabaru')";

                $result = mysqli_query($conn, $sql);

                if ($result){
                    echo "
                        <script>
                            alert('Berhasil Menambah Kamar');
                            document.location.href = 'data_kamar.php';
                        </script>
                    ";
                } else {
                    echo "
                        <script>
                            alert('Gagal Menambah Kamar');
                        </script>
                    ";
                }
            }

        } 
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
    <h1>Tambah Kamar</h1>
    
    <form action="" class="form-room-container" method="POST" enctype="multipart/form-data">
        <div class="room-container">
            <div class="photo-container">
                <label for="photo" class="input-photo">
                    <p class="title-pict" id="title-picture">Foto kamar</p>
                    <img id="up-picture" alt="preview" class="room-preview">
                </label><br>
                <input type="file" name="room" id="photo" onchange="limit_size(event)" required><br>
            </div>
            <div class="room-data">
                <div class="room-type">
                    <label for="type"> 
                        Jenis Kamar: <br>
                        <input type="text" id="type" name="type" class="form-room" placehorder="Masukkan Jenis Kamar" maxlength="50" required>
                    </label>
                    <label for="amount"> 
                        Jumlah Kamar: <br>
                        <input type="number" id="amount" name="amount" class="form-room" placehorder="Masukkan Jumlah Kamar" min="1" required>
                    </label>
                </div>
                <div class="room-type">
                    <label for="bed" class="amount"> 
                        <i class="fa-solid fa-bed"></i> Kasur: <br>
                        <input type="number" id="bed" name="bed" class="form-amount" placehorder="Kasur" pattern="[0-9]{1,11}" min="1" required>
                    </label>

                    <label for="bath" class="amount"> 
                        <i class="fa-solid fa-bath"></i>Kamar Mandi: <br>
                        <input type="number" id="bath" name="bath" class="form-amount" placehorder="Kamar Mandi" pattern="[0-9]{1,11}" min="1" required>
                    </label>

                    <label for="people" class="amount"> 
                        <i class="fa-solid fa-users"></i>Orang: <br>
                        <input type="number" id="people" name="people" class="form-amount" placehorder="Orang" pattern="[0-9]{1,11}" min="1" required>
                    </label>
                </div>
                <div class="room-type">
                    <label for="price"> 
                        Harga: <br>
                        Rp <input type="text" id="price" name="price" class="form-price" pattern="[0-9]{1,15}" placehorder="Harga" min="1" inputmode="numeric" title="Masukkan Angka Maksimal 15 Digit" required>
                    </label>
                </div>
            </div>
        </div>
        <div class="descript-container">
            <label for="descript"> 
                Deskripsi: <br>
                <input type="text" id="descript" name="descript" class="form-descript" placehorder="Deskripsi" maxlength="140" required>
            </label>
            <input type="submit" name="submit" value="Tambah Kamar" class="add-room">
        </div>

    </form>
</body>
<script>
    document.getElementById('amount').addEventListener('input', function() {
        var max = this.value;
        if (max.length > 9){
            alert('Jumlah digit sudah mencapai batas!');
            this.value = 1
        }
    });
    document.getElementById('bed').addEventListener('input', function() {
        var max = this.value;
        if (max.length > 9){
            alert('Jumlah digit sudah mencapai batas!');
            this.value = 1
        }
    });
    document.getElementById('bath').addEventListener('input', function() {
        var max = this.value;
        if (max.length > 9){
            alert('Jumlah digit sudah mencapai batas!');
            this.value = 1
        }
    });
    document.getElementById('people').addEventListener('input', function() {
        var max = this.value;
        if (max.length > 9){
            alert('Jumlah digit sudah mencapai batas!');
        }
    });
</script>
<script src="admin.js?v=<?php echo time(); ?>"></script>
</html>