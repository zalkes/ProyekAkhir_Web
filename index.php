<?php
  session_start();
  if (isset($_SESSION["admin"])) {
    echo "<script>document.location.href = 'crudAdmin/dashboard.php';</script>";
  }
  require "database/koneksi.php";
  $sql_select_kamar = mysqli_query($conn, "SELECT * FROM kamar");
    
    $kamar = [];
    $count = 0;
    while ($row_kamar = mysqli_fetch_assoc($sql_select_kamar)) {
        $kamar[] = $row_kamar;
        $count++;
    }

  $pengguna;
  if (isset($_SESSION["user"])){
    $select_pengguna = mysqli_query($conn, "SELECT * FROM pengguna WHERE username = '$_SESSION[username]'");
    if (mysqli_num_rows ($select_pengguna) == 0 && isset($_SESSION["user"])) {
      echo 
      "<script>
      document.location.href = 'login_page/logout.php?logout=true';
      </script>";
    }
  }

  if (isset($_SESSION["user"])) {
    $sql_pengguna = mysqli_query($conn, "SELECT * FROM pengguna WHERE username = '$_SESSION[username]'");
    while ($row = mysqli_fetch_assoc($sql_pengguna)) {
        $pengguna[] = $row;
    }
    $pengguna = $pengguna[0];
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sedar Hotel</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="styles.css">
  <script src="script.js?v=<?php echo time(); ?>" defer></script>
</head>

<body>
<header>
    <nav class="container navbar">
      <div class="hamburger">
        <i class="fa-solid fa-bars" data-visible="true"></i>
        <i class="fa-solid fa-close" data-visible="false"></i>
      </div>
      <div class="logo">
        <a href="#">
          <h1><span>Hotel </span><i class="fa-solid fa-star" style="color: #00b4d8;"></i>7 </h1>
        </a>
      </div>
    
      </div>

      </div>
    
      <div>
        <ul class="nav-links" data-visible="false">
          <li><a href="#">Home</a></li>
          <li><a href="#Rooms">Rooms</a></li>
          <li><a href="#About">About Us</a></li>
          <li class="btn"><input type="checkbox" id="dark-mode-button" onclick="mode()"></li>
          <?php if (isset($_SESSION["user"])): ?>
                <li>
                  <?php $direktori = "database/profil_pengguna/".$pengguna["foto"]; ?>
                  <?php if ($pengguna["foto"] == "") {
                      echo "<img src='https://gravatar.com/avatar/00000000000000000000000000000000?d=mp' class='user-pic' alt='Foto Profil' onclick='toggleMenu()'>";
                  } else {
                      echo "<img src='$direktori' alt='Foto Profil' class='user-pic' onclick='toggleMenu()'>";
                  } ?>
                  <div class="sub-menu-wrap" id="subMenu">
                    <div class="sub-menu">
                      <div class="user-info">
                        <?php if ($pengguna["foto"] == "") {
                            echo "<img src='https://gravatar.com/avatar/00000000000000000000000000000000?d=mp' alt='Foto Profil'>";
                        } else {
                            echo "<img src='$direktori' alt='Foto Profil'>";
                        } ?>
                        <h3><?php echo $_SESSION["username"]?></h3>
                      </div>
                      <hr>

                        <a href="user_profile/profil.php#akun" class="sub-menu-link">
                        <i class="fa-solid fa-user"></i>
                        <p>Edit Profil</p>
                        <span>></span>
                        </a>

                      <a href="user_profile/profil.php#riwayat" class="sub-menu-link">
                        <i class="fa-solid fa-ticket"></i>
                        <p>Riwayat Reservasi</p>
                        <span>></span>
                      </a>

                      <a href="login_page/logout.php?logout=true" class="sub-menu-link">
                        <i class="fa-solid fa-sign-out"></i>
                        <p>Logout</p>
                        <span>></span>
                      </a>

                    </div>
                  </div>
                </li>
          <?php else: ?>
                <li><a href="login_page/login.php" class="login">Login</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </nav>
  </header>
  <main>

    <section class="hero">
      <div class="container">
        <div class="hero-content">
          <h1>Selamat Datang di Hotel Bintang 7</h1>
           <p>Hotel Terbaik di Samarinda</p>
          <a href="#Rooms" class="book">Booking Sekarang</a>
        </div>
      </div>
    </section>
    <?php if ($count == 0) :?>
    <?php echo""?>
    <?php else: ?>
    <section id="Rooms" class="rooms">
      <div class="container">
          <div class="rooms-title">
              <h2>Kamar <span>Terbaik</span> Kami</h2>
              <p>Rasakan kenyamanan maksimal di kamar hotel kami yang dirancang dengan elegan dan modern. Nikmati pemandangan kota Samarinda yang memukau langsung dari jendela kamar anda</p>
          </div>
          <div class="room-cards">
            
            <?php $i = 1; foreach($kamar as $kmr) : ?>
            <?php $direktori = "database/foto_kamar/" . $kmr["foto"];?>
                <div class="room-card">
                <?php echo"<img src='$direktori' class='room-photo' alt='Room'>";?>
                    <div class="room-info">
                        <h3 class="type-room"><?php echo $kmr["jenis_kamar"];?></h3>
                        <p class="descript"><?php echo $kmr["deskripsi"];?></p>
                        <div class="room-specification">
                            <div>
                                <span><i class="fa-solid fa-bed"></i> <?php echo $kmr["kasur"];?> Kasur</span>
                            </div>
                            <div>
                                <span><i class="fa-solid fa-bath"></i> <?php echo $kmr["kamar_mandi"];?> Kamar Mandi</span>
                            </div>
                            <div>
                                <span><i class="fa-solid fa-users"></i> <?php echo $kmr["orang"];?> Orang</span>
                            </div>
                        </div>
                        <p style="text-align: right;"><?php echo $kmr["jumlah_kamar"] . " Kamar Tersedia";?></p>
                        <div class="room-price">
                            <a href="reservasi/reservasi.php?kamar=<?= $kmr['id'] ?>" onclick="if (<?php echo $kmr['jumlah_kamar']; ?> == 0) { alert('Kamar Tidak Tersedia'); return false; }">Rp <?php echo $kmr["harga"];?></a>
                        </div>
                    </div>
                </div>
            
            <?php $i++; endforeach?>
              
          </div>
      </div>
    </section>
    <?php endif; ?>
                
    <section id="About" class="about">
      <div class="container">
        <div class="side-bar">
          <h2>About Us</h2>
          <p>Kelompok 6</p>

        </div>

        <div class="about-info">
          <div class="about-images">
            <div class="about-image">
              <img src='assets/aldi.jpg' alt="aldi">
              <p>Aldi Daffa Arisyi</p>
            </div>
            <div class="about-image">
              <img src='assets/afrizal.jpg' alt="rizal">
              <p>Muhammad Afrizal Kesuma</p>
            </div>
            <div class="about-image">
              <img src='assets/agil.jpeg' alt="agil">
              <p>Muhammad Agill Firmansyah</p>
            </div>
          </div>
          <p id="caption">Website ini dibuat sebagai proyek akhir praktikum Pemrograman Web. Dengan adanya website ini, diharap dapat
            memudahkan pengguna dalam melakukan reservasi kamar hotel. Website ini juga dilengkapi dengan berbagai fitur yang memudahkan pengguna dalam melakukan reservasi kamar hotel.
          </p>
        </div>
      </div>
    </section>
  </main>

    <footer>
      <div class="container">
        <div class="logo">
          <a href="#">
          <h1><span>Hotel </span><i class="fa-solid fa-star" style="color: #00b4d8;"></i>7 </h1>
          </a>
          <p>Jl. Lama, Samarinda, Kalimantan Timur, Indonesia </p>
        </div>
        <div class="footer-content">
          <p>Copyright © 2024 All rights reserved - Hotel Bintang 7</p>
          <ul>
            <li><a href="#"><i class="fa-brands fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
            <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
          </ul>
          <p>Proyek Akhir Pemrograman Web <span>Kelompok 6</span></p>
        </div>
      </div>
    </footer>

</body>
</html>