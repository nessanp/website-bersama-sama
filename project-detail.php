<?php
/**
 * ============================================
 * Halaman Detail Project (project-detail.php)
 * ============================================
 * Menampilkan detail lengkap project berdasarkan ID
 */

require_once 'db.php';

// Ambil ID project dari query string
$project_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($project_id <= 0) {
    die("ID project tidak valid.");
}

// Ambil data project
$query = "SELECT id, judul, deskripsi, gambar, link, created_at, updated_at FROM projects WHERE id = $project_id LIMIT 1";
$result = $conn->query($query);

if (!$result || $result->num_rows === 0) {
    die("Project tidak ditemukan.");
}

$project = $result->fetch_assoc();

// Tentukan path gambar jika ada
$imagePath = '';
if (!empty($project['gambar'])) {
    $possiblePath = __DIR__ . '/uploads/' . $project['gambar'];
    if (file_exists($possiblePath)) {
        $imagePath = 'uploads/' . $project['gambar'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($project['judul']); ?> - Detail Project</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">
                <a href="index.php">
                    <h2>💼 Portfolio</h2>
                </a>
            </div>
            
            <ul class="nav-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="project.php">Project</a></li>
                <li><a href="login.php" class="btn-login-nav">Login Admin</a></li>
            </ul>
        </div>
    </nav>

    <!-- Header -->
    <section class="page-header">
        <div class="container">
            <h1><?php echo htmlspecialchars($project['judul']); ?></h1>
            <p>Detail lengkap project dan tautan terkait</p>
        </div>
    </section>

    <!-- Detail Content -->
    <section class="projects-section">
        <div class="container">
            <div class="project-card-large">
                <div class="project-image-large">
                    <?php if (!empty($imagePath)): ?>
                        <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($project['judul']); ?>" class="project-thumb-large">
                    <?php else: ?>
                        <div class="image-placeholder-large">📱</div>
                    <?php endif; ?>
                </div>
                <div class="project-content-large">
                    <div>
                        <div class="project-meta" style="margin-bottom:10px;">
                            <span class="project-date">📅 Dibuat: <?php echo date('d M Y', strtotime($project['created_at'])); ?></span>
                            <?php if (!empty($project['updated_at'])): ?>
                                <span style="margin-left:15px; color:#666;">🔄 Update: <?php echo date('d M Y', strtotime($project['updated_at'])); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="project-description" style="white-space: pre-line;">
                            <?php echo htmlspecialchars($project['deskripsi']); ?>
                        </div>
                    </div>

                    <div class="project-actions" style="margin-top:20px;">
                        <?php if (!empty($project['link'])): ?>
                            <a href="<?php echo htmlspecialchars($project['link']); ?>" target="_blank" class="btn btn-primary">Buka Link Project</a>
                        <?php else: ?>
                            <span class="btn btn-disabled">Link tidak tersedia</span>
                        <?php endif; ?>
                        <a href="project.php" class="btn btn-secondary">← Kembali ke Project</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section">
        <div class="container">
            <h2>Tertarik berkolaborasi?</h2>
            <p>Hubungi saya untuk berdiskusi lebih lanjut tentang project ini.</p>
            <a href="about.php" class="btn btn-primary btn-large">Hubungi Saya</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>Portfolio</h4>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="project.php">Project</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Social Media</h4>
                    <ul>
                        <li><a href="https://github.com" target="_blank">GitHub</a></li>
                        <li><a href="https://linkedin.com" target="_blank">LinkedIn</a></li>
                        <li><a href="https://twitter.com" target="_blank">Twitter</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Kontak</h4>
                    <ul>
                        <li>Email: hello@portfolio.com</li>
                        <li>Phone: +62 812-345-6789</li>
                        <li>Location: Indonesia</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 Portfolio Profesional. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>
</body>
</html>
