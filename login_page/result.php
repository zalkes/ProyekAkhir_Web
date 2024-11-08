<?php 
    session_start();
    require "../database/koneksi.php";
    
    if (isset($_POST["login"])){
        $username = $_POST["username"];
        $password = $_POST["password"];

        $sql_select = mysqli_query($conn, "SELECT * FROM pengguna");

        if ($username == "admin" && $password == "admin123"){
            $_SESSION["admin"] = true;
            echo "
                <script>
                    alert('Login Berhasil, Selamat Datang Admin');
                    document.location.href = '../crudAdmin/dashboard.php';
                </script>
            ";
            exit;
        }

        $count = 0;
        while ($row = mysqli_fetch_assoc($sql_select)){
            $pengguna[] = $row;
            if ($pengguna[$count]["username"] == $username && password_verify($password, $pengguna[$count]["pasword"])){
                $_SESSION["user"] = true;
                $_SESSION["username"] = $pengguna[$count]["username"];
                echo "
                    <script>
                        alert('Login Berhasil, Selamat Datang ". $pengguna[$count]["nama_lengkap"] ."');
                        document.location.href = '../index.php';
                    </script>
                ";

                exit;
                
            } 
            $count ++;
        }

        echo "
            <script>
                alert('Gagal Login, email atau password salah');
                document.location.href = 'login.php';
            </script>
        ";
        exit;
        
    } else if (isset($_POST["signup"])) {
        $fullname_up = $_POST['fullname_up'];
        $username_up = $_POST['username_up'];
        $email_up = $_POST['email_up'];
        $password_up = $_POST['password_up'];
        $phone_up = $_POST['phone_up'];

        $checkQuery = "SELECT * FROM pengguna WHERE username = '$username_up'";
        $checkResult = mysqli_query($conn, $checkQuery);
        $password_up = password_hash($password_up, PASSWORD_DEFAULT);

        if ($username_up == "admin"){
            echo 
            "<script>
            alert('Username sudah digunakan');
            document.location.href = 'login.php';
            </script>";
        }

        if (mysqli_num_rows($checkResult) > 0) {
            echo 
            "<script>
            alert('Username sudah digunakan');
            document.location.href = 'login.php';
            </script>";

        } else {
            $query = "INSERT INTO pengguna (username, nama_lengkap, email, telepon, pasword, foto) VALUES ('$username_up', '$fullname_up', '$email_up', '$phone_up', '$password_up', '')";
            
            if (mysqli_query($conn, $query)) {
                echo "
                <script>
                    alert('Signup berhasil, silakan login');
                    document.location.href = 'login.php';
                </script>";
            } else {
                echo "
                <script>
                    alert('Signup gagal, coba lagi');
                    document.location.href = 'login.php';
                </script>";
            }
        }
    } else {
        echo "<script>document.location.href = '../index.php';</script>";
    }
    
?>