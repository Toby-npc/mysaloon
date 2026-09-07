<?php
// 1. Memulakan sesi (session) untuk menyimpan data log masuk
session_start();

// Fail sambungan database (Sila tukar maklumat jika perlu)
$host = "localhost";
$user = "root";
$pass = "";
$db   = "sistem_pengurusan";

$conn = new mysqli($host, $user, $pass, $db);

// Semak jika sambungan gagal
if ($conn->connect_error) {
    die("Sambungan database gagal: " . $conn->connect_error);
}

$error_message = "";

// 2. Proses apabila pengguna menekan butang Log Masuk
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emel = mysqli_real_escape_string($conn, $_POST['emel']);
    $kata_laluan = $_POST['kata_laluan'];

    // Ambil data pengguna dan nama peranan mereka
    $sql = "SELECT users.*, roles.nama_peranan FROM users 
            JOIN roles ON users.role_id = roles.id 
            WHERE users.emel = '$emel'";
            
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        
        // Semak kata laluan (Menggunakan password_verify untuk keselamatan)
        if (password_verify($kata_laluan, $user_data['kata_laluan'])) {
            
            // Simpan maklumat pengguna dalam Session
            $_SESSION['user_id'] = $user_data['id'];
            $_SESSION['nama']    = $user_data['nama_penuh'];
            $_SESSION['role']    = $user_data['nama_peranan'];

            // Hala pengguna ke halaman utama berdasarkan peranan (Role)
            if ($_SESSION['role'] == 'Admin') {
                header("Location: dashboard_admin.php");
            } elseif ($_SESSION['role'] == 'Staff') {
                header("Location: dashboard_staff.php");
            } else {
                header("Location: dashboard_guest.php");
            }
            exit();
        } else {
            $error_message = "Kata laluan salah!";
        }
    } else {
        $error_message = "Emel tidak wujud!";
    }
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Masuk Sistem</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Log Masuk</h2>
    
    <?php if(!empty($error_message)): ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label>Emel:</label>
            <input type="email" name="emel" required placeholder="Masukkan emel anda">
        </div>
        <div class="form-group">
            <label>Kata Laluan:</label>
            <input type="password" name="kata_laluan" required placeholder="Masukkan kata laluan">
        </div>
        <button type="submit">Masuk</button>
    </form>
</div>

</body>
</html>
