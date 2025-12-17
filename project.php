<?php
/**
 * ============================================
 * Halaman Project (project.php)
 * ============================================
 * Menampilkan daftar project dari database
 * dengan judul, deskripsi, gambar, dan link
 */

// Include database connection
require_once 'db.php';

// ============================================
// Ambil semua project dari database
// ============================================
$query = "SELECT id, judul, deskripsi, gambar, link, created_at FROM projects ORDER BY created_at DESC";
$result = $conn->query($query);

// Validasi query
if (!$result) {
    die("Error: " . $conn->error);
}

// Siapkan array untuk menyimpan project
$projects = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
}

// ============================================
// Filter project berdasarkan pencarian (jika ada)
// ============================================
$search_query = isset($_GET['search']) ? escape_input($_GET['search']) : '';

if (!empty($search_query)) {
    $search_results = [];
    foreach ($projects as $project) {
        // Cari di judul dan deskripsi
        if (
            stripos($project['judul'], $search_query) !== false ||
            stripos($project['deskripsi'], $search_query) !== false
        ) {
            $search_results[] = $project;
        }
    }
    $projects = $search_results;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project - Portfolio Profesional</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- ============================================
         Navigation Bar
         ============================================ -->
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
                <li><a href="project.php" class="active">Project</a></li>
                <li><a href="login.php" class="btn-login-nav">Login Admin</a></li>
            </ul>
        </div>
    </nav>
    
    <!-- ============================================
         Page Header
         ============================================ -->
    <section class="page-header">
        <div class="container">
            <h1>Portfolio Project 🚀</h1>
            <p>Berikut adalah koleksi project yang telah saya kerjakan</p>
        </div>
    </section>
    
    <!-- ============================================
         Search & Filter Section
         ============================================ -->
    <section class="search-section">
        <div class="container">
            <form method="GET" action="project.php" class="search-form">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Cari project berdasarkan nama atau deskripsi..." 
                    value="<?php echo htmlspecialchars($search_query); ?>"
                    class="search-input"
                >
                <button type="submit" class="btn btn-primary">Cari</button>
                <?php if (!empty($search_query)): ?>
                    <a href="project.php" class="btn btn-secondary">Reset</a>
                <?php endif; ?>
            </form>
        </div>
    </section>
    
    <!-- ============================================
         Projects Grid Section
         ============================================ -->
    <section class="projects-section">
        <div class="container">
            <!-- ============================================
                 Tampilkan hasil pencarian atau semua project
                 ============================================ -->
            <?php if (!empty($search_query)): ?>
                <p class="search-info">
                    Hasil pencarian untuk: <strong><?php echo htmlspecialchars($search_query); ?></strong> 
                    (<?php echo count($projects); ?> project ditemukan)
                </p>
            <?php endif; ?>
            
            <?php if (!empty($projects)): ?>
                <div class="projects-grid-large">
                    <!-- ============================================
                         Loop melalui setiap project
                         ============================================ -->
                    <?php foreach ($projects as $project): ?>
                        <?php 
                            $imagePath = '';
                            if (!empty($project['gambar'])) {
                                $possiblePath = __DIR__ . '/uploads/' . $project['gambar'];
                                if (file_exists($possiblePath)) {
                                    $imagePath = 'uploads/' . $project['gambar'];
                                }
                            }
                        ?>
                        <div class="project-card-large">
                            <div class="project-image-large">
                                <?php if (!empty($imagePath)): ?>
                                    <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($project['judul']); ?>" class="project-thumb-large">
                                <?php else: ?>
                                    <div class="image-placeholder-large">
                                        📱
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="project-content-large">
                                <h3><?php echo htmlspecialchars($project['judul']); ?></h3>
                                
                                <div class="project-meta">
                                    <span class="project-date">
                                        📅 <?php echo date('d M Y', strtotime($project['created_at'])); ?>
                                    </span>
                                </div>
                                
                                <div class="project-description">
                                    <?php echo htmlspecialchars($project['deskripsi']); ?>
                                </div>
                                
                                <div class="project-tech">
                                    <span class="tech-tag">🔧 PHP</span>
                                    <span class="tech-tag">🗄️ MySQL</span>
                                    <span class="tech-tag">⚡ JavaScript</span>
                                </div>
                                
                                <div class="project-actions">
                                    <a href="project-detail.php?id=<?php echo $project['id']; ?>" class="btn btn-primary">
                                        Lihat Detail →
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- ============================================
                     Pesan jika tidak ada project
                     ============================================ -->
                <div class="no-data">
                    <p>
                        <?php 
                        if (!empty($search_query)) {
                            echo "Tidak ada project yang sesuai dengan pencarian '" . htmlspecialchars($search_query) . "'";
                        } else {
                            echo "Tidak ada project yang tersedia saat ini.";
                        }
                        ?>
                    </p>
                    
                    <?php if (!empty($search_query)): ?>
                        <a href="project.php" class="btn btn-primary">Kembali ke semua project</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary">Login untuk menambah project</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- ============================================
         Statistics Section
         ============================================ -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number"><?php echo count($projects); ?>+</div>
                    <p class="stat-label">Project Selesai</p>
                </div>
                
                <div class="stat-item">
                    <div class="stat-number">5+</div>
                    <p class="stat-label">Tahun Pengalaman</p>
                </div>
                
                <div class="stat-item">
                    <div class="stat-number">50+</div>
                    <p class="stat-label">Client Puas</p>
                </div>
                
                <div class="stat-item">
                    <div class="stat-number">100%</div>
                    <p class="stat-label">Quality Assurance</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- ============================================
         Call to Action Section
         ============================================ -->
    <section class="cta-section">
        <div class="container">
            <h2>Punya Project yang Menarik? 💡</h2>
            <p>Mari kita wujudkan ide Anda menjadi kenyataan</p>
            <a href="about.php" class="btn btn-primary btn-large">Hubungi Saya Sekarang</a>
        </div>
    </section>
    
    <!-- ============================================
         Footer
         ============================================ -->
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
