<?php
/**
 * ============================================
 * Halaman Login Admin (login.php)
 * ============================================
 * Halaman untuk autentikasi admin sebelum mengakses
 * admin dashboard untuk CRUD project
 */

// Mulai session untuk menyimpan data admin yang login
session_start();

// Include database connection
require_once 'db.php';

// ============================================
// Validasi: Jika sudah login, redirect ke admin page
// ============================================
if (isset($_SESSION['admin_id']) && isset($_SESSION['admin_username'])) {
    header("Location: admin.php");
    exit();
}

// ============================================
// Proses Login
// ============================================
$error_message = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi field tidak kosong
    if (empty($_POST['username'] ?? '') || empty($_POST['password'] ?? '')) {
        $error_message = "Username dan password harus diisi!";
    } else {
        // Ambil dan sanitasi input
        $username = escape_input($_POST['username']);
        $password = $_POST['password']; // Jangan hash dulu, akan diverifikasi
        
        // Query untuk mencari admin dengan username yang sesuai
        $query = "SELECT id, username, password FROM admin WHERE username = '$username' LIMIT 1";
        $result = $conn->query($query);
        
        // Cek jika query berhasil
        if ($result && $result->num_rows > 0) {
            // Ambil data admin dari database
            $admin = $result->fetch_assoc();
            
            // Verifikasi password dengan menggunakan bcrypt
            if (verify_password($password, $admin['password'])) {
                // Password benar, set session
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                
                // Redirect ke admin page
                header("Location: admin.php");
                exit();
            } else {
                // Password salah
                $error_message = "Username atau password salah!";
            }
        } else {
            // Username tidak ditemukan
            $error_message = "Username atau password salah!";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Portfolio</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* ============================================
           Styling untuk halaman login
           ============================================ */
        
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        
        .login-container h1 {
            text-align: center;
            color: #333;
            margin-top: 0;
            font-size: 28px;
        }
        
        .login-container p {
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .error-message {
            background-color: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #c33;
            font-size: 14px;
        }
        
        .success-message {
            background-color: #efe;
            color: #3c3;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #3c3;
            font-size: 14px;
        }
        
        .login-footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 13px;
        }
        
        .login-footer a {
            color: #667eea;
            text-decoration: none;
        }
        
        .login-footer a:hover {
            text-decoration: underline;
        }
        
        .demo-info {
            background-color: #f0f4ff;
            border: 1px solid #667eea;
            padding: 12px;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 12px;
            color: #333;
        }
        
        .demo-info p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>🔐 Login Admin</h1>
        <p>Masukkan username dan password untuk akses admin</p>
        
        <!-- ============================================
             Tampilkan error message jika ada
             ============================================ -->
        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        
        <!-- ============================================
             Tampilkan success message jika ada
             ============================================ -->
        <?php if (!empty($success_message)): ?>
            <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>
        
        <!-- ============================================
             Form Login
             ============================================ -->
        <form method="POST" action="" onsubmit="return validateLoginForm()">
            <div class="form-group">
                <label for="username">Username</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    placeholder="Masukkan username" 
                    required
                >
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Masukkan password" 
                    required
                >
            </div>
            
            <button type="submit" class="btn-login">Masuk</button>
        </form>
        
        <!-- ============================================
             Informasi Demo Akun
             ============================================ -->
        <div class="demo-info">
            <p><strong>📝 Demo Akun:</strong></p>
            <p><strong>Username:</strong> admin</p>
            <p><strong>Password:</strong> admin123</p>
            <hr style="margin: 8px 0; border: none; border-top: 1px solid #667eea;">
            <p><strong>Username:</strong> user</p>
            <p><strong>Password:</strong> user123</p>
        </div>
        
        <div class="login-footer">
            <a href="index.php">← Kembali ke Home</a>
        </div>
    </div>
    
    <!-- ============================================
         JavaScript untuk validasi form
         ============================================ -->
    <script>
        function validateLoginForm() {
            // Ambil nilai input
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            
            // Validasi username tidak kosong
            if (username === '') {
                alert('Username tidak boleh kosong!');
                return false;
            }
            
            // Validasi password tidak kosong
            if (password === '') {
                alert('Password tidak boleh kosong!');
                return false;
            }
            
            // Validasi panjang username minimal 3 karakter
            if (username.length < 3) {
                alert('Username minimal 3 karakter!');
                return false;
            }
            
            // Validasi panjang password minimal 6 karakter
            if (password.length < 6) {
                alert('Password minimal 6 karakter!');
                return false;
            }
            
            return true;
        }
    </script>
</body>
</html>
