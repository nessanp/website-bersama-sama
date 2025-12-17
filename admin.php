<?php
/**
 * ============================================
 * Halaman Admin Dashboard (admin.php)
 * ============================================
 * Halaman admin untuk CRUD project
 * Hanya user yang sudah login yang bisa mengakses
 */

// Mulai session
session_start();

// Include database connection
require_once 'db.php';

// Direktori penyimpanan upload gambar
$uploadDir = __DIR__ . '/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Helper upload gambar dengan validasi dasar
function handle_image_upload($fieldName, &$error_message, $existingFile = null) {
    global $uploadDir;

    // Jika tidak ada file baru, kembalikan file lama
    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] === UPLOAD_ERR_NO_FILE) {
        return $existingFile;
    }

    if ($_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
        $error_message = "Upload gambar gagal, coba lagi.";
        return $existingFile;
    }

    $tmpPath = $_FILES[$fieldName]['tmp_name'];
    $originalName = basename($_FILES[$fieldName]['name']);
    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($ext, $allowed)) {
        $error_message = "Format gambar harus jpg, jpeg, png, atau webp.";
        return $existingFile;
    }

    // Sanitasi nama file
    $safeName = time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', $originalName);
    $destination = $uploadDir . $safeName;

    if (!move_uploaded_file($tmpPath, $destination)) {
        $error_message = "Gagal menyimpan file gambar.";
        return $existingFile;
    }

    // Hapus file lama bila diganti
    if (!empty($existingFile) && file_exists($uploadDir . $existingFile)) {
        @unlink($uploadDir . $existingFile);
    }

    return $safeName;
}

// ============================================
// Validasi: Cek apakah admin sudah login
// ============================================
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_username'])) {
    // Jika belum login, redirect ke login page
    header("Location: login.php");
    exit();
}

// ============================================
// Variabel untuk pesan
// ============================================
$success_message = "";
$error_message = "";
$action = isset($_GET['action']) ? $_GET['action'] : '';
$edit_id = isset($_GET['id']) ? intval($_GET['id']) : null;

// ============================================
// PROSES: Tambah Project (CREATE)
// ============================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    // Validasi field tidak kosong
    if (
        empty($_POST['judul'] ?? '') || 
        empty($_POST['deskripsi'] ?? '')
    ) {
        $error_message = "Judul dan deskripsi tidak boleh kosong!";
    } else {
        // Ambil dan sanitasi input
        $judul = escape_input($_POST['judul']);
        $deskripsi = escape_input($_POST['deskripsi']);
        $link = escape_input($_POST['link']);

        // Proses upload gambar
        $gambar = handle_image_upload('gambar', $error_message);
        
        if (empty($error_message)) {
            // Query insert ke database
            $query = "INSERT INTO projects (judul, deskripsi, gambar, link) 
                      VALUES ('$judul', '$deskripsi', '$gambar', '$link')";
        
            if ($conn->query($query) === TRUE) {
                $success_message = "Project berhasil ditambahkan!";
            } else {
                $error_message = "Error: " . $conn->error;
            }
        }
    }
}

// ============================================
// PROSES: Update Project (UPDATE)
// ============================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    // Validasi field tidak kosong
    if (
        empty($_POST['id'] ?? '') || 
        empty($_POST['judul'] ?? '') || 
        empty($_POST['deskripsi'] ?? '')
    ) {
        $error_message = "Semua field harus diisi!";
    } else {
        // Ambil dan sanitasi input
        $id = intval($_POST['id']);
        $judul = escape_input($_POST['judul']);
        $deskripsi = escape_input($_POST['deskripsi']);
        $link = escape_input($_POST['link']);

        // Ambil data lama untuk gambar
        $oldImage = '';
        $oldQuery = $conn->query("SELECT gambar FROM projects WHERE id = $id LIMIT 1");
        if ($oldQuery && $oldQuery->num_rows > 0) {
            $oldData = $oldQuery->fetch_assoc();
            $oldImage = $oldData['gambar'] ?? '';
        }

        // Proses upload gambar (jika ada yang baru)
        $gambar = handle_image_upload('gambar', $error_message, $oldImage);
        
        if (empty($error_message)) {
            // Query update ke database
            $query = "UPDATE projects SET judul = '$judul', deskripsi = '$deskripsi', 
                      gambar = '$gambar', link = '$link' WHERE id = $id";
        
            if ($conn->query($query) === TRUE) {
                $success_message = "Project berhasil diupdate!";
                $action = '';
                $edit_id = null;
            } else {
                $error_message = "Error: " . $conn->error;
            }
        }
    }
}

// ============================================
// PROSES: Hapus Project (DELETE)
// ============================================
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);

    // Ambil data gambar untuk dihapus dari storage
    $imgRes = $conn->query("SELECT gambar FROM projects WHERE id = $delete_id LIMIT 1");
    $imgName = '';
    if ($imgRes && $imgRes->num_rows > 0) {
        $imgRow = $imgRes->fetch_assoc();
        $imgName = $imgRow['gambar'] ?? '';
    }
    
    // Query delete dari database
    $query = "DELETE FROM projects WHERE id = $delete_id";
    
    if ($conn->query($query) === TRUE) {
        $success_message = "Project berhasil dihapus!";

        // Hapus file gambar jika ada
        if (!empty($imgName) && file_exists($uploadDir . $imgName)) {
            @unlink($uploadDir . $imgName);
        }
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

// ============================================
// Ambil data project untuk di-edit (jika ada)
// ============================================
$edit_project = null;
if ($action === 'edit' && $edit_id) {
    $query = "SELECT * FROM projects WHERE id = $edit_id LIMIT 1";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        $edit_project = $result->fetch_assoc();
    }
}

// ============================================
// Ambil semua project dari database
// ============================================
$query = "SELECT id, judul, deskripsi, gambar, link, created_at FROM projects ORDER BY created_at DESC";
$result = $conn->query($query);
$projects = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Portfolio</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* ============================================
           Styling khusus untuk admin page
           ============================================ */
        
        .admin-container {
            display: block;
            min-height: 100vh;
            position: relative;
        }
        
        .admin-sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            position: fixed;
            height: 100vh;
            width: 250px;
            overflow-y: auto;
        }
        
        .admin-sidebar h3 {
            margin-top: 0;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        
        .admin-sidebar ul {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }
        
        .admin-sidebar ul li {
            margin-bottom: 10px;
        }
        
        .admin-sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        
        .admin-sidebar ul li a:hover {
            background: rgba(255,255,255,0.1);
        }
        
        .admin-sidebar ul li a.active {
            background: rgba(255,255,255,0.2);
            font-weight: bold;
        }
        
        .admin-content {
            margin-left: 250px;
            padding: 30px;
            background: #f5f5f5;
            min-height: 100vh;
            overflow-x: auto;
            box-sizing: border-box;
        }
        
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .admin-header h1 {
            margin: 0;
            color: #333;
        }
        
        .admin-logout {
            background: #ff6b6b;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.3s;
        }
        
        .admin-logout:hover {
            background: #ff5252;
        }
        
        .admin-form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .admin-form h2 {
            margin-top: 0;
            color: #333;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .form-group-full {
            grid-column: 1 / -1;
        }
        
        .projects-list {
            background: white;
            border-radius: 10px;
            overflow-x: auto;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-top: 20px;
            margin-bottom: 30px;
            visibility: visible !important;
            display: block !important;
            width: 100%;
            min-height: 50px;
        }
        
        .projects-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        
        .projects-table thead {
            background: #667eea;
            color: white;
        }
        
        .projects-table thead th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        
        .projects-table tbody tr {
            border-bottom: 1px solid #eee;
        }
        
        .projects-table tbody tr:hover {
            background: #f9f9f9;
        }
        
        .projects-table tbody td {
            padding: 15px;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn-small {
            padding: 8px 15px;
            font-size: 13px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: 0.3s;
        }
        
        .btn-edit {
            background: #4a90e2;
            color: white;
        }
        
        .btn-edit:hover {
            background: #357abd;
        }
        
        .btn-delete {
            background: #e24a4a;
            color: white;
        }
        
        .btn-delete:hover {
            background: #c23535;
        }
        
        .btn-cancel {
            background: #999;
            color: white;
        }
        
        .btn-cancel:hover {
            background: #777;
        }
        
        .user-info {
            font-size: 13px;
            color: rgba(255,255,255,0.8);
        }
        
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
        }
        
        .alert.show {
            display: block;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        @media (max-width: 768px) {
            .admin-container {
                grid-template-columns: 1fr;
            }
            
            .admin-sidebar {
                position: relative;
                height: auto;
                width: 100%;
                margin-bottom: 20px;
            }
            
            .admin-content {
                margin-left: 0;
                padding: 15px;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .admin-header {
                flex-direction: column;
                gap: 15px;
            }
            
            .projects-list {
                margin-top: 20px;
            }
            
            .projects-table {
                font-size: 12px;
            }
            
            .projects-table thead th,
            .projects-table tbody td {
                padding: 10px;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 5px;
            }
            
            .btn-small {
                padding: 6px 10px;
                font-size: 11px;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- ============================================
             Sidebar Navigation
             ============================================ -->
        <div class="admin-sidebar">
            <h3>🔐 Admin Panel</h3>
            <p class="user-info">Logged in as:<br><strong><?php echo htmlspecialchars($_SESSION['admin_username']); ?></strong></p>
            
            <ul>
                <li><a href="admin.php" class="<?php echo empty($action) ? 'active' : ''; ?>">📋 Dashboard</a></li>
                <li><a href="admin.php?action=add" class="<?php echo $action === 'add' ? 'active' : ''; ?>">➕ Tambah Project</a></li>
            </ul>
            
            <hr style="border: none; border-top: 1px solid rgba(255,255,255,0.2); margin: 20px 0;">
            
            <ul>
                <li><a href="index.php" target="_blank">👁️ Lihat Website</a></li>
                <li><a href="logout.php" class="admin-logout">🚪 Logout</a></li>
            </ul>
        </div>
        
        <!-- ============================================
             Main Content
             ============================================ -->
        <div class="admin-content">
            <!-- ============================================
                 Page Header
                 ============================================ -->
            <div class="admin-header">
                <h1>📊 Admin Dashboard</h1>
                <span class="user-info">Selamat datang, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</span>
            </div>
            
            <!-- ============================================
                 Alert Messages
                 ============================================ -->
            <?php if (!empty($success_message)): ?>
                <div class="alert alert-success show">
                    ✅ <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-error show">
                    ❌ <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            
            <!-- ============================================
                 Form: Tambah/Edit Project
                 ============================================ -->
            <?php if ($action === 'add' || ($action === 'edit' && $edit_project)): ?>
                <div class="admin-form">
                    <h2>
                        <?php echo $action === 'add' ? '➕ Tambah Project Baru' : '✏️ Edit Project'; ?>
                    </h2>
                    
                    <form method="POST" action="" onsubmit="return validateProjectForm()" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="<?php echo $action; ?>">
                        
                        <?php if ($action === 'edit' && $edit_project): ?>
                            <input type="hidden" name="id" value="<?php echo $edit_project['id']; ?>">
                        <?php endif; ?>
                        
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="judul">Judul Project *</label>
                                <input 
                                    type="text" 
                                    id="judul" 
                                    name="judul" 
                                    placeholder="Masukkan judul project"
                                    value="<?php echo $edit_project ? htmlspecialchars($edit_project['judul']) : ''; ?>"
                                    required
                                >
                            </div>
                            
                            <div class="form-group">
                                <label for="link">Link Project (opsional)</label>
                                <input 
                                    type="text" 
                                    id="link" 
                                    name="link" 
                                    placeholder="https://github.com/..."
                                    value="<?php echo $edit_project ? htmlspecialchars($edit_project['link']) : ''; ?>"
                                >
                            </div>

                            <div class="form-group">
                                <label for="gambar">Upload Gambar (jpg/png/webp)</label>
                                <input 
                                    type="file" 
                                    id="gambar" 
                                    name="gambar" 
                                    accept=".jpg,.jpeg,.png,.webp"
                                >
                                <?php if ($edit_project && !empty($edit_project['gambar'])): ?>
                                    <p style="margin-top:8px; font-size:13px; color:#666;">
                                        Gambar saat ini: <?php echo htmlspecialchars($edit_project['gambar']); ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="form-group form-group-full">
                                <label for="deskripsi">Deskripsi Project *</label>
                                <textarea 
                                    id="deskripsi" 
                                    name="deskripsi" 
                                    placeholder="Jelaskan project ini secara detail..."
                                    rows="6"
                                    required
                                ><?php echo $edit_project ? htmlspecialchars($edit_project['deskripsi']) : ''; ?></textarea>
                            </div>
                        </div>
                        
                        <div style="display: flex; gap: 10px; margin-top: 20px;">
                            <button type="submit" class="btn btn-primary">
                                <?php echo $action === 'add' ? '✅ Tambah Project' : '💾 Simpan Perubahan'; ?>
                            </button>
                            
                            <a href="admin.php" class="btn btn-cancel">❌ Batal</a>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
            
            <!-- ============================================
                 Daftar Project Tabel
                 ============================================ -->
            <div style="clear: both; margin-top: 50px; padding-top: 20px; border-top: 2px solid #ddd; background: #fff; padding: 15px; border-radius: 5px;">
                <h2 style="margin: 20px 0; color: #333; border-bottom: 2px solid #667eea; padding-bottom: 10px; font-size: 24px;">
                    📋 Daftar Project (Total: <?php echo count($projects); ?>)
                </h2>
            </div>
            <div class="projects-list">
                <table class="projects-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Link</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php if (!empty($projects)): ?>
                                <?php foreach ($projects as $index => $project): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($project['judul']); ?></strong><br>
                                            <small style="color: #666;">
                                                <?php 
                                                $deskripsi = htmlspecialchars($project['deskripsi']);
                                                echo strlen($deskripsi) > 50 ? substr($deskripsi, 0, 50) . '...' : $deskripsi;
                                                ?>
                                            </small>
                                        </td>
                                        <td>
                                            <?php if (!empty($project['link'])): ?>
                                                <a href="<?php echo htmlspecialchars($project['link']); ?>" target="_blank" style="color: #667eea;">
                                                    Lihat →
                                                </a>
                                            <?php else: ?>
                                                <span style="color: #999;">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo date('d M Y', strtotime($project['created_at'])); ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                    <a href="project-detail.php?id=<?php echo $project['id']; ?>" target="_blank" class="btn-small btn-secondary">
                                                        👁️ Detail
                                                    </a>
                                                <a href="admin.php?action=edit&id=<?php echo $project['id']; ?>" class="btn-small btn-edit">
                                                    ✏️ Edit
                                                </a>
                                                <a href="admin.php?delete_id=<?php echo $project['id']; ?>" class="btn-small btn-delete" onclick="return confirm('Yakin hapus project ini?')">
                                                    🗑️ Hapus
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 30px;">
                                        Belum ada project. <a href="admin.php?action=add">Tambah project baru</a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <p style="margin-top: 20px; text-align: center; color: #666;">
                    📊 Total project: <?php echo count($projects); ?>
                </p>
        </div>
    </div>
    
    <!-- ============================================
         JavaScript untuk Validasi Form
         ============================================ -->
    <script>
        function validateProjectForm() {
            // Ambil nilai input
            const judul = document.getElementById('judul').value.trim();
            const deskripsi = document.getElementById('deskripsi').value.trim();
            
            // Validasi judul tidak kosong
            if (judul === '') {
                alert('Judul project tidak boleh kosong!');
                document.getElementById('judul').focus();
                return false;
            }
            
            // Validasi deskripsi tidak kosong
            if (deskripsi === '') {
                alert('Deskripsi project tidak boleh kosong!');
                document.getElementById('deskripsi').focus();
                return false;
            }
            
            // Validasi panjang judul
            if (judul.length < 3) {
                alert('Judul project minimal 3 karakter!');
                return false;
            }
            
            // Validasi panjang deskripsi
            if (deskripsi.length < 20) {
                alert('Deskripsi project minimal 20 karakter!');
                return false;
            }
            
            return true;
        }
        
        // Sembunyikan alert setelah 5 detik
        const alerts = document.querySelectorAll('.alert.show');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.display = 'none';
            }, 5000);
        });
    </script>
</body>
</html>
