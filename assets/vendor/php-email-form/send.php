<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Pastikan Anda telah menginstal PHPMailer melalui Composer
require 'vendor/autoload.php';

// Pastikan permintaan datang dari metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    // Validasi data
    if (empty($name) || empty($email) || empty($message)) {
        http_response_code(400);
        echo "Semua field wajib diisi!";
        exit;
    }

    try {
        // Inisialisasi PHPMailer
        $mail = new PHPMailer(true);

        // Konfigurasi SMTP
        $mail->isSMTP();
        $mail->Host = 'muhammadrafly2808.gmail.com'; // Gunakan host SMTP Anda
        $mail->SMTPAuth = true;
        $mail->Username = '@gmail.com'; // Ganti dengan email pengirim Anda
        $mail->Password = ''; // Gunakan password aplikasi jika menggunakan Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Pengaturan pengirim dan penerima
        $mail->setFrom($email, $name); // Email pengirim
        $mail->addAddress('emailtujuan@example.com'); // Ganti dengan email penerima Anda

        // Konten email
        $mail->isHTML(true);
        $mail->Subject = "Pesan dari $name";
        $mail->Body = "
            <h3>Pesan Baru</h3>
            <p><strong>Nama:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Pesan:</strong><br>$message</p>
        ";

        // Kirim email
        $mail->send();
        http_response_code(200);
        echo "Pesan berhasil dikirim!";
    } catch (Exception $e) {
        http_response_code(500);
        echo "Gagal mengirim pesan. Error: {$mail->ErrorInfo}";
    }
} else {
    http_response_code(403);
    echo "Akses tidak diizinkan.";
}
?>
