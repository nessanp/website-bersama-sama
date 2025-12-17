<?php
/**
 * ============================================
 * Halaman About (about.php)
 * ============================================
 * Menampilkan profil lengkap, skill, dan pengalaman singkat
 */

// Include database connection
require_once 'db.php';

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Portfolio Profesional</title>
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
                <li><a href="about.php" class="active">About</a></li>
                <li><a href="project.php">Project</a></li>
                <li><a href="login.php" class="btn-login-nav">Login Admin</a></li>
            </ul>
        </div>
    </nav>
    
    <!-- ============================================
         Page Header
         ============================================ -->
    <section class="page-header">
        <div class="container">
            <h1>Tentang Saya 👋</h1>
            <p>Kenali lebih dekat tentang profil, skill, dan pengalaman saya</p>
        </div>
    </section>
    
    <!-- ============================================
         Profile Section
         ============================================ -->
    <section class="about-section">
        <div class="container">
            <div class="about-grid">
                <div class="about-image">
                    <div class="profile-large">👨‍💼</div>
                </div>
                
                <div class="about-content">
                    <h2>Muhammad Developer</h2>
                    <p class="about-title">Full Stack Web Developer | Mobile App Developer</p>
                    
                    <div class="about-text">
                        <p>
                            Halo! Saya Muhammad, seorang Full Stack Developer yang passionate dalam menciptakan solusi teknologi 
                            inovatif. Dengan pengalaman lebih dari 5 tahun di industri, saya telah bekerja dengan berbagai klien 
                            dari startup hingga perusahaan besar untuk mengembangkan aplikasi yang scalable dan user-friendly.
                        </p>
                        
                        <p>
                            Saya percaya bahwa teknologi harus digunakan untuk memecahkan masalah nyata dan meningkatkan kualitas 
                            hidup. Oleh karena itu, saya selalu fokus pada memahami kebutuhan klien dengan mendalam sebelum 
                            memulai development.
                        </p>
                        
                        <p>
                            Ketika tidak coding, saya suka menulis artikel tentang teknologi, berbagi knowledge di komunitas developer, 
                            dan mengikuti perkembangan teknologi terbaru. Saya juga aktif berkontribusi pada beberapa open-source project.
                        </p>
                    </div>
                    
                    <div class="about-info">
                        <div class="info-item">
                            <span class="label">Lokasi:</span>
                            <span class="value">Jakarta, Indonesia</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Email:</span>
                            <span class="value"><a href="mailto:hello@portfolio.com">hello@portfolio.com</a></span>
                        </div>
                        <div class="info-item">
                            <span class="label">Phone:</span>
                            <span class="value"><a href="tel:+62812345678">+62 812-345-678</a></span>
                        </div>
                        <div class="info-item">
                            <span class="label">Pengalaman:</span>
                            <span class="value">5+ Tahun</span>
                        </div>
                    </div>
                    
                    <div class="about-buttons">
                        <a href="project.php" class="btn btn-primary">Lihat Project</a>
                        <a href="#contact" class="btn btn-secondary">Hubungi Saya</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- ============================================
         Skills Section
         ============================================ -->
    <section class="skills-section">
        <div class="container">
            <h2>Skill & Expertise 💪</h2>
            
            <div class="skills-category">
                <h3>Frontend Development</h3>
                <div class="skills-list">
                    <div class="skill-bar">
                        <div class="skill-name">
                            <span>HTML & CSS</span>
                            <span class="percentage">95%</span>
                        </div>
                        <div class="skill-progress">
                            <div class="progress-bar" style="width: 95%"></div>
                        </div>
                    </div>
                    
                    <div class="skill-bar">
                        <div class="skill-name">
                            <span>JavaScript</span>
                            <span class="percentage">90%</span>
                        </div>
                        <div class="skill-progress">
                            <div class="progress-bar" style="width: 90%"></div>
                        </div>
                    </div>
                    
                    <div class="skill-bar">
                        <div class="skill-name">
                            <span>React.js</span>
                            <span class="percentage">88%</span>
                        </div>
                        <div class="skill-progress">
                            <div class="progress-bar" style="width: 88%"></div>
                        </div>
                    </div>
                    
                    <div class="skill-bar">
                        <div class="skill-name">
                            <span>Vue.js</span>
                            <span class="percentage">85%</span>
                        </div>
                        <div class="skill-progress">
                            <div class="progress-bar" style="width: 85%"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="skills-category">
                <h3>Backend Development</h3>
                <div class="skills-list">
                    <div class="skill-bar">
                        <div class="skill-name">
                            <span>PHP</span>
                            <span class="percentage">92%</span>
                        </div>
                        <div class="skill-progress">
                            <div class="progress-bar" style="width: 92%"></div>
                        </div>
                    </div>
                    
                    <div class="skill-bar">
                        <div class="skill-name">
                            <span>Node.js</span>
                            <span class="percentage">88%</span>
                        </div>
                        <div class="skill-progress">
                            <div class="progress-bar" style="width: 88%"></div>
                        </div>
                    </div>
                    
                    <div class="skill-bar">
                        <div class="skill-name">
                            <span>Python</span>
                            <span class="percentage">80%</span>
                        </div>
                        <div class="skill-progress">
                            <div class="progress-bar" style="width: 80%"></div>
                        </div>
                    </div>
                    
                    <div class="skill-bar">
                        <div class="skill-name">
                            <span>Laravel</span>
                            <span class="percentage">85%</span>
                        </div>
                        <div class="skill-progress">
                            <div class="progress-bar" style="width: 85%"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="skills-category">
                <h3>Database & Tools</h3>
                <div class="skills-list">
                    <div class="skill-bar">
                        <div class="skill-name">
                            <span>MySQL</span>
                            <span class="percentage">90%</span>
                        </div>
                        <div class="skill-progress">
                            <div class="progress-bar" style="width: 90%"></div>
                        </div>
                    </div>
                    
                    <div class="skill-bar">
                        <div class="skill-name">
                            <span>PostgreSQL</span>
                            <span class="percentage">85%</span>
                        </div>
                        <div class="skill-progress">
                            <div class="progress-bar" style="width: 85%"></div>
                        </div>
                    </div>
                    
                    <div class="skill-bar">
                        <div class="skill-name">
                            <span>Git & GitHub</span>
                            <span class="percentage">95%</span>
                        </div>
                        <div class="skill-progress">
                            <div class="progress-bar" style="width: 95%"></div>
                        </div>
                    </div>
                    
                    <div class="skill-bar">
                        <div class="skill-name">
                            <span>Docker</span>
                            <span class="percentage">80%</span>
                        </div>
                        <div class="skill-progress">
                            <div class="progress-bar" style="width: 80%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- ============================================
         Experience Section
         ============================================ -->
    <section class="experience-section">
        <div class="container">
            <h2>Pengalaman Kerja 🏢</h2>
            
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Senior Full Stack Developer</h3>
                        <p class="company">PT. Tech Innovation Indonesia</p>
                        <p class="period">2023 - Present (2 tahun)</p>
                        <ul>
                            <li>Memimpin tim developer dalam mengembangkan aplikasi enterprise-scale</li>
                            <li>Mengoptimalkan performa aplikasi sehingga meningkat 40%</li>
                            <li>Mengelola infrastruktur cloud menggunakan AWS dan Docker</li>
                            <li>Mentoring junior developer dan code review</li>
                        </ul>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Full Stack Developer</h3>
                        <p class="company">Startup Tech Valley</p>
                        <p class="period">2021 - 2023 (2 tahun)</p>
                        <ul>
                            <li>Mengembangkan web application menggunakan React dan Node.js</li>
                            <li>Implementasi REST API dan database design</li>
                            <li>Deploy aplikasi ke production environment</li>
                            <li>Kolaborasi dengan UX/UI team untuk implementasi design</li>
                        </ul>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3>Junior Web Developer</h3>
                        <p class="company">Digital Agency Indonesia</p>
                        <p class="period">2019 - 2021 (2 tahun)</p>
                        <ul>
                            <li>Mengembangkan website statis dan dinamis menggunakan PHP</li>
                            <li>Database design dan optimization</li>
                            <li>Maintenance dan update website client</li>
                            <li>Belajar dan mengimplementasi best practices development</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- ============================================
         Education Section
         ============================================ -->
    <section class="education-section">
        <div class="container">
            <h2>Pendidikan 🎓</h2>
            
            <div class="education-items">
                <div class="education-item">
                    <h3>Sarjana Teknik Informatika</h3>
                    <p class="school">Universitas Teknologi Indonesia</p>
                    <p class="period">2015 - 2019</p>
                    <p class="description">
                        Mengambil fokus pada Software Engineering dan Web Development. 
                        GPA: 3.7/4.0
                    </p>
                </div>
                
                <div class="education-item">
                    <h3>Sertifikasi AWS Solutions Architect</h3>
                    <p class="school">Amazon Web Services</p>
                    <p class="period">2022</p>
                    <p class="description">
                        Professional level certification untuk cloud architecture design dan management.
                    </p>
                </div>
                
                <div class="education-item">
                    <h3>Full Stack Web Development Bootcamp</h3>
                    <p class="school">Code Academy Indonesia</p>
                    <p class="period">2018</p>
                    <p class="description">
                        Intensive bootcamp selama 3 bulan untuk memperkuat skill di modern web development.
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- ============================================
         Contact Section
         ============================================ -->
    <section class="contact-section" id="contact">
        <div class="container">
            <div class="section-header">
                <h2>Hubungi Saya 📧</h2>
                <p>Mari kita diskusikan project berikutnya</p>
            </div>
            
            <div class="contact-grid">
                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-icon">📧</div>
                        <h4>Email</h4>
                        <a href="mailto:hello@portfolio.com">hello@portfolio.com</a>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">📱</div>
                        <h4>Phone</h4>
                        <a href="tel:+628123456789">+62 812-345-6789</a>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">📍</div>
                        <h4>Lokasi</h4>
                        <p>Jakarta, Indonesia</p>
                    </div>
                </div>
                
                <div class="contact-form">
                    <h3>Kirim Pesan</h3>
                    <p>Tulis pesan singkat dan saya akan merespon secepatnya</p>
                    
                    <form id="contactForm">
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Nama Anda" required>
                        </div>
                        
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Email Anda" required>
                        </div>
                        
                        <div class="form-group">
                            <textarea name="message" placeholder="Pesan Anda" rows="5" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                    </form>
                </div>
            </div>
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
    
    <!-- ============================================
         JavaScript untuk Contact Form
         ============================================ -->
    <script>
        // Form contact - Demo handler (bisa dihubungkan ke email service)
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Terima kasih telah menghubungi saya! Pesan Anda telah diterima. Saya akan merespon secepatnya.');
            this.reset();
        });
    </script>
</body>
</html>
