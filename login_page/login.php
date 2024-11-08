<?php
    session_start();
    if (isset($_SESSION["user"])) {
        echo "<script>document.location.href = '../index.php';</script>";
    }  if (isset($_SESSION["admin"])){
        echo "<script>document.location.href = '../index.php';</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>LoginPage</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="login.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <?php include ("navbar.php");?>
    <body>
        <div class="wrapper">
            <div class="title-text">
                <div class="title login">
                    Login
                </div>
                <div class="title signup">
                    Signup
                </div>
            </div>
            <div class="form-container">
                <div class="slide-controls">
                    <input type="radio" name="slide" id="login" checked>
                    <input type="radio" name="slide" id="signup">
                    <label for="login" class="slide login">Login</label>
                    <label for="signup" class="slide signup">Signup</label>
                    <div class="slider-tab"></div>
                </div>
                <div class="form-inner">
                    <form action="result.php" method="POST" class="login" >
                        <div class="field">
                            <input type="text" id="username" name="username" placeholder="Username" maxlength="20" required>
                        </div>
                        <div class="field">
                            <input type="password" id="password" name="password" placeholder="Password" minlength="8" maxlength="255" required>
                        </div>
                        <div class="field btn">
                            <div class="btn-layer"></div>
                            <input type="submit" name="login" value="Login">
                        </div>
                        <div class="signup-link">
                            Belum punya akun? <a href="">Signup</a>
                        </div>
                    </form>
                    <form action="result.php" method="POST" class="signup">
                          <div class="field">
                                <input type="text" name="fullname_up" id="username_up" placeholder="Nama Lengkap" maxlength="20" required>
                          </div>
                          <div class="field">
                                <input type="text" name="username_up" id="username_up" placeholder="Username" maxlength="50" required>
                          </div>
                          <div class="field">
                                <input type="email" name="email_up" id="email_up" placeholder="Email" maxlength="100" required>
                          </div>
                          <div class="field">
                                <input type="password" name="password_up" id="password_up" placeholder="Password" minlength="8" maxlength="255" required>
                          </div>
                          <div class="field">
                                <input type="text" name="phone_up" id="phone_up" pattern="[0-9]{12}" placeholder="Nomor Hp" inputmode="numeric" title="Masukkan Angka 12 Digit" required>
                          </div>
                          <div class="field btn">
                                <div class="btn-layer"></div>
                                <input type="submit" name="signup" value="Signup">
                          </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="login.js"></script>
    </body>
</html>

<?php include('footer.php'); ?>