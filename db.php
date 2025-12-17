<?php
/**
 * ============================================
 * Database Connection File (db.php)
 * ============================================
 * File ini berisi konfigurasi koneksi database MySQL
 * Digunakan oleh semua file PHP untuk terhubung ke database
 */

// ============================================
// Konfigurasi Database
// ============================================
$servername = "localhost";    // Nama server (default localhost untuk XAMPP/Laragon)
$username = "root";           // Username MySQL (default: root)
$password = "";               // Password MySQL (default: kosong untuk XAMPP)
$database = "portfolio_website"; // Nama database

// ============================================
// Buat Koneksi
// ============================================
try {
    // Gunakan mysqli untuk koneksi
    $conn = new mysqli($servername, $username, $password, $database);
    
    // Set charset UTF-8 untuk mendukung karakter spesial
    $conn->set_charset("utf8mb4");
    
    // Cek jika koneksi gagal
    if ($conn->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error);
    }
    
} catch (Exception $e) {
    // Tangkap error dan tampilkan pesan
    die("Error: " . $e->getMessage());
}

// ============================================
// Helper Function: Escape Input untuk Keamanan
// ============================================
function escape_input($data) {
    global $conn;
    
    // Validasi input kosong
    if (empty($data)) {
        return null;
    }
    
    // Gunakan real_escape_string untuk mencegah SQL Injection
    return $conn->real_escape_string(strip_tags(trim($data)));
}

// ============================================
// Helper Function: Validasi Input Tidak Kosong
// ============================================
function validate_required_fields($fields) {
    // $fields adalah array berisi nama-nama field yang harus diisi
    foreach ($fields as $field) {
        if (empty($_POST[$field] ?? '')) {
            return false;
        }
    }
    return true;
}

// ============================================
// Helper Function: Hash Password dengan bcrypt
// ============================================
function hash_password($password) {
    // Gunakan password_hash untuk keamanan maksimal
    // Algoritma bcrypt dipilih secara otomatis
    return password_hash($password, PASSWORD_BCRYPT, ["cost" => 10]);
}

// ============================================
// Helper Function: Verifikasi Password
// ============================================
function verify_password($password, $hash) {
    // Verifikasi password dengan hash yang tersimpan
    return password_verify($password, $hash);
}

?>
