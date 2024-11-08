<?php
  require "../database/koneksi.php";
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
  <title>Hotel Bintang 7</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
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
          <li><a href="../index.php">Home</a></li>
          <li><a href="../index.php#Rooms">Rooms</a></li>
          <li><a href="../index.php#About">About Us</a></li>
          <li class="btn"><input type="checkbox" id="dark-mode-button" onclick="mode()"></li>
          <?php if (isset($_SESSION["user"])): ?>
                <li>
                  <?php $direktori = "../database/profil_pengguna/".$pengguna["foto"]; ?>
                  <?php if ($pengguna["foto"] == "") {
                      echo "<img src='https://gravatar.com/avatar/00000000000000000000000000000000?d=mp' class='user-pic' alt='Foto Profil' class='user-pic' onclick='toggleMenu()'>";
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

                      <a href="../user_profile/profil.php#akun" class="sub-menu-link">
                        <i class="fa-solid fa-user"></i>
                        <p>Edit Profil</p>
                        <span>></span>
                      </a>

                      <a href="../user_profile/profil.php#riwayat" class="sub-menu-link">
                        <i class="fa-solid fa-ticket"></i>
                        <p>Riwayat Reservasi</p>
                        <span>></span>
                      </a>

                      <a href="../login_page/logout.php" class="sub-menu-link">
                        <i class="fa-solid fa-sign-out"></i>
                        <p>Logout</p>
                        <span>></span>
                      </a>

                    </div>
                  </div>
                </li>
          <?php else: ?>
                <li><a href="../login_page/login.php" class="login">Login</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </nav>
  </header>
</body>
</html>
