<?php
session_start();
include 'db.php';

$mesaj = "";

// Eğer zaten giriş yapılmışsa ana sayfaya at
if (isset($_SESSION['kullanici'])) {
    header("Location: index.php");
    exit;
}

// Beni Hatırla Çerezi Varsa Otomatik Giriş Yap
if (isset($_COOKIE['hatirla_beni'])) {
    $_SESSION['kullanici'] = $_COOKIE['hatirla_beni'];
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kadi = $_POST['kadi'];
    $sifre = $_POST['sifre'];
    
    // Veritabanı Kontrolü
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :kadi AND password = :sifre");
    $stmt->execute([':kadi' => $kadi, ':sifre' => $sifre]);
    $user = $stmt->fetch();

    if ($user) {
        // Oturum Başlat
        $_SESSION['kullanici'] = $user['username'];

        // BENİ HATIRLA İŞARETLENDİ Mİ?
        if (isset($_POST['beni_hatirla'])) {
            // 30 Günlük Çerez Oluştur (86400 saniye * 30 gün)
            setcookie("hatirla_beni", $user['username'], time() + (86400 * 30), "/");
        }

        header("Location: index.php");
        exit;
    } else {
        $mesaj = "Hatalı kullanıcı adı veya şifre!";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap - EczaDepom</title>
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { display: flex; justify-content: center; align-items: center; height: 100vh; background: #f0f2f5; }
        .login-box { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 350px; text-align: center; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; }
        button { width: 100%; padding: 10px; background: #3498db; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; }
        button:hover { background: #2980b9; }
        .error { color: red; font-size: 0.9rem; margin-bottom: 10px; }
        .checkbox-container { display: flex; align-items: center; justify-content: start; margin-bottom: 15px; font-size: 0.9rem; color: #555; }
        .checkbox-container input { margin-right: 10px; width: auto; }
    </style>
</head>
<body>

    <div class="login-box">
        <h2 style="color:#2c3e50; margin-bottom:20px;"><i class="fa-solid fa-pills"></i> EczaDepom</h2>
        
        <?php if($mesaj): ?>
            <div class="error"><?php echo $mesaj; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <input type="text" name="kadi" placeholder="Kullanıcı Adı" required>
            <input type="password" name="sifre" placeholder="Şifre" required>
            
            <div class="checkbox-container">
                <input type="checkbox" name="beni_hatirla" id="hatirla">
                <label for="hatirla">Beni Hatırla</label>
            </div>

            <button type="submit">Giriş Yap</button>
        </form>
        
        <p style="margin-top:15px; font-size:0.9rem;">
            Hesabın yok mu? <a href="register.php" style="color:#3498db;">Kayıt Ol</a>
        </p>
        <p style="margin-top:10px; font-size:0.8rem;">
            <a href="index.php" style="color:#777;">← Ana Sayfaya Dön</a>
        </p>
    </div>

</body>
</html>