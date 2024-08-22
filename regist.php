<?php
// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Validasi sederhana
    if ($password != $confirm_password) {
        echo "Password tidak cocok!";
        exit;
    }

    // Hash password sebelum disimpan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Koneksi ke database
    $conn = new mysqli('localhost', 'root', '', 'siatan');

    // Cek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Insert data ke database
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        echo "Pendaftaran berhasil!";
        // Redirect ke halaman login
        header('Location: login.html');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Tutup koneksi
    $conn->close();
}
?>
