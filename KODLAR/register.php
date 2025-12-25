<?php
session_start();
include 'db.php'; // Veritabanı bağlantısı

$mesaj = "";
$mesajTuru = ""; // success veya error

// Zaten giriş yapmışsa ana sayfaya gönder
if (isset($_SESSION['kullanici'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kadi = trim($_POST['kadi']);
    $sifre = $_POST['sifre'];
    $sifre_tekrar = $_POST['sifre_tekrar'];

    // 1. Boş alan kontrolü
    if (empty($kadi) || empty($sifre)) {
        $mesaj = "Lütfen tüm alanları doldurun.";
        $mesajTuru = "error";
    } 
    // 2. Şifreler eşleşiyor mu?
    elseif ($sifre !== $sifre_tekrar) {
        $mesaj = "Şifreler birbiriyle uyuşmuyor!";
        $mesajTuru = "error";
    } 
    else {
        // 3. Kullanıcı adı zaten var mı?
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :kadi");
        $stmt->execute([':kadi' => $kadi]);
        
        if ($stmt->rowCount() > 0) {
            $mesaj = "Bu kullanıcı adı zaten kullanılıyor.";
            $mesajTuru = "error";
        } else {
            // 4. KAYIT İŞLEMİ (INSERT)
            // Not: Login sayfanla uyumlu olması için şifreyi düz kaydediyoruz.
            $sql = "INSERT INTO users (username, password) VALUES (:kadi, :sifre)";
            $kayitStmt = $pdo->prepare($sql);
            $sonuc = $kayitStmt->execute([':kadi' => $kadi, ':sifre' => $sifre]);

            if ($sonuc) {
                // Kayıt başarılı, login sayfasına yönlendir (veya mesaj ver)
                echo "<script>
                        alert('Kayıt Başarılı! Giriş sayfasına yönlendiriliyorsunuz...');
                        window.location.href = 'login.php';
                      </script>";
                exit;
            } else {
                $mesaj = "Kayıt sırasında bir hata oluştu.";
                $mesajTuru = "error";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol - EczaDepom</title>
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { display: flex; justify-content: center; align-items: center; height: 100vh; background: #f0f2f5; font-family: sans-serif; }
        .register-box { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 350px; text-align: center; }
        input[type="text"], input[type="password"] { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #27ae60; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 1rem; transition: 0.3s; }
        button:hover { background: #219150; }
        .message { padding: 10px; margin-bottom: 15px; border-radius: 5px; font-size: 0.9rem; }
        .error { background: #ffebee; color: #c62828; border: 1px solid #ffcdd2; }
        .success { background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }
        a { text-decoration: none; color: #3498db; font-weight: bold; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="register-box">
        <h2 style="color:#2c3e50; margin-bottom:10px;"><i class="fa-solid fa-user-plus"></i> Kayıt Ol</h2>
        <p style="color:#7f8c8d; font-size:0.9rem; margin-bottom:20px;">EczaDepom ailesine katılın</p>
        
        <?php if($mesaj): ?>
            <div class="message <?php echo $mesajTuru; ?>"><?php echo $mesaj; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div style="text-align: left; font-size: 0.85rem; color: #555; margin-bottom: 2px;">Kullanıcı Adı</div>
            <input type="text" name="kadi" placeholder="Örn: ahmet123" required>
            
            <div style="text-align: left; font-size: 0.85rem; color: #555; margin-bottom: 2px;">Şifre</div>
            <input type="password" name="sifre" placeholder="******" required>
            
            <div style="text-align: left; font-size: 0.85rem; color: #555; margin-bottom: 2px;">Şifre Tekrar</div>
            <input type="password" name="sifre_tekrar" placeholder="******" required>

            <button type="submit">Hesap Oluştur</button>
        </form>
        
        <p style="margin-top:20px; font-size:0.9rem;">
            Zaten hesabın var mı? <br>
            <a href="login.php">Giriş Yap</a>
        </p>
        <p style="margin-top:10px; font-size:0.8rem;">
            <a href="index.php" style="color:#777;">← Ana Sayfaya Dön</a>
        </p>
    </div>

</body>
</html>