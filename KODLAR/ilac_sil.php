<?php
session_start();
include 'db.php';

// Giriş yapılmamışsa at
if (!isset($_SESSION['kullanici'])) {
    header("Location: index.php");
    exit;
}

if (isset($_GET['id'])) {
    $silinecekID = $_GET['id'];
    
    // Aktif Kullanıcıyı Bul
    $stmtUser = $pdo->prepare("SELECT id FROM users WHERE username = :kadi");
    $stmtUser->execute([':kadi' => $_SESSION['kullanici']]);
    $userRow = $stmtUser->fetch(PDO::FETCH_ASSOC);
    $aktifUserID = $userRow['id'];

    // SİLME İŞLEMİ (Sadece kendi ilacını silebilir)
    // WHERE user_id = :uid kısmı ÇOK ÖNEMLİDİR. Güvenlik sağlar.
    $sql = "DELETE FROM medicines WHERE id = :id AND user_id = :uid";
    $stmt = $pdo->prepare($sql);
    $sonuc = $stmt->execute([':id' => $silinecekID, ':uid' => $aktifUserID]);

    if ($sonuc) {
        // Başarılıysa geri dön ve url'ye not düş
        header("Location: index.php?mesaj=silindi");
    } else {
        echo "Silme işlemi başarısız oldu.";
    }
} else {
    header("Location: index.php");
}
?>