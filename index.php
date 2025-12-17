<?php
/**
 * ============================================
 * Halaman Home (index.php)
 * ============================================
 * Menampilkan ringkasan profil dan project terbaru
 * secara dinamis dari database
 */

// Include database connection
require_once 'db.php';

// ============================================
// Ambil Project Terbaru (Maksimal 3 Project)
// ============================================
$query_projects = "SELECT id, judul, deskripsi, gambar, link FROM projects ORDER BY created_at DESC LIMIT 3";
$result_projects = $conn->query($query_projects);
$projects = [];

if ($result_projects && $result_projects->num_rows > 0) {
    while ($row = $result_projects->fetch_assoc()) {
        $projects[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Portfolio Profesional</title>
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
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="project.php">Project</a></li>
                <li><a href="login.php" class="btn-login-nav">Login Admin</a></li>
            </ul>
        </div>
    </nav>
    
    <!-- ============================================
         Hero Section - Profile Summary
         ============================================ -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Halo, Saya Nessa Nirmala Pratama </h1>
                    <p class="hero-subtitle"> MAHASISWA INSTITUT TEKNOLOGI DAN KESEHATAN MAHARDIKA</p>
                    
                    <div class="hero-description">
                        <p>
                            Saya adalah mahasiswa Teknik Informatika yang memiliki minat besar pada pengembangan teknologi, khususnya di bidang pengembangan web, pemrograman, dan pemanfaatan teknologi digital untuk menyelesaikan permasalahan nyata. Terbiasa mengerjakan proyek berbasis HTML, CSS, JavaScript, serta memiliki pemahaman dasar tentang pemrograman dan sistem operasi.

Saya juga memiliki pengalaman dalam kerja tim, organisasi, dan manajemen proyek, yang membentuk kemampuan komunikasi, tanggung jawab, serta problem solving yang baik. Saya selalu terbuka untuk belajar hal baru, beradaptasi dengan perkembangan teknologi, dan berkomitmen untuk terus meningkatkan kemampuan teknis maupun non-teknis guna menunjang karier di bidang IT. 
                        </p>
                        <p>
                            Keahlian saya mencakup PHP, JavaScript, React, Vue.js, Node.js, MySQL, PostgreSQL, dan berbagai framework modern. 
                            Saya juga berpengalaman dalam mengelola server, CI/CD, dan DevOps practices.
                        </p>
                    </div>
                    
                    <div class="hero-buttons">
                        <a href="project.php" class="btn btn-primary">Lihat Project Saya →</a>
                        <a href="about.php" class="btn btn-secondary">Pelajari Lebih Lanjut</a>
                    </div>
                </div>
                
                <div class="hero-image">
                    <div class="profile-placeholder">
                        <span>👨‍💼</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- ============================================
         Project Terbaru Section
         ============================================ -->
    <section class="latest-projects">
        <div class="container">
            <div class="section-header">
                <h2>Project Terbaru 🚀</h2>
                <p>Beberapa project terkini yang telah saya kerjakan</p>
            </div>
            
            <?php if (!empty($projects)): ?>
                <div class="projects-grid">
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
                        <div class="project-card">
                            <div class="project-image">
                                <?php if (!empty($imagePath)): ?>
                                    <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($project['judul']); ?>" class="project-thumb">
                                <?php else: ?>
                                    <div class="image-placeholder">
                                        📱
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="project-content">
                                <h3><?php echo htmlspecialchars($project['judul']); ?></h3>
                                <p>
                                    <?php 
                                    // Tampilkan deskripsi dengan max 150 karakter
                                    $deskripsi = htmlspecialchars($project['deskripsi']);
                                    echo strlen($deskripsi) > 150 ? substr($deskripsi, 0, 150) . '...' : $deskripsi;
                                    ?>
                                </p>
                                
                                <a href="project-detail.php?id=<?php echo $project['id']; ?>" class="project-link">
                                    Lihat Detail →
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="text-center" style="margin-top: 30px;">
                    <a href="project.php" class="btn btn-primary">Lihat Semua Project</a>
                </div>
            <?php else: ?>
                <!-- ============================================
                     Pesan jika tidak ada project
                     ============================================ -->
                <div class="no-data">
                    <p>Tidak ada project yang tersedia saat ini.</p>
                    <a href="login.php" class="btn btn-primary">Tambah Project</a>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- ============================================
         Skills Section
         ============================================ -->
    <section class="skills-preview">
        <div class="container">
            <div class="section-header">
                <h2>Keahlian Utama 💪</h2>
                <p>Teknologi dan tools yang saya kuasai</p>
            </div>
            
            <div class="skills-grid">
                <div class="skill-item">
                    <div class="skill-icon">🔙</div>
                    <h4>Backend</h4>
                    <p>PHP, Node.js, Python, MySQL, PostgreSQL</p>
                </div>
                
                <div class="skill-item">
                    <div class="skill-icon">⚛️</div>
                    <h4>Frontend</h4>
                    <p>HTML, CSS, JavaScript, React, Vue.js</p>
                </div>
                
                <div class="skill-item">
                    <div class="skill-icon">📱</div>
                    <h4>Mobile</h4>
                    <p>React Native, Flutter, Mobile Web</p>
                </div>
                
                <div class="skill-item">
                    <div class="skill-icon">☁️</div>
                    <h4>Cloud & DevOps</h4>
                    <p>AWS, Docker, CI/CD, Linux, Git</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- ============================================
         Call to Action Section
         ============================================ -->
    <section class="cta-section">
        <div class="container">
            <h2>Tertarik Berkolaborasi? 🤝</h2>
            <p>Mari kita ciptakan sesuatu yang luar biasa bersama-sama</p>
            <a href="about.php" class="btn btn-primary btn-large">Hubungi Saya</a>
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
