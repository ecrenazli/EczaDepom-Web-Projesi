<?php
session_start();
include 'db.php';

// Hataları ekrana bas
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<div style='font-family: sans-serif; padding: 20px; line-height: 1.6;'>";

// 1. GİRİŞ KONTROLÜ
if (!isset($_SESSION['kullanici'])) {
    die("❌ <h2 style='color:red;'>Lütfen önce sisteme giriş yapın!</h2> <a href='login.php'>Giriş Yap</a></div>");
}

// 2. SENİN ID'Nİ BULALIM
$stmtUser = $pdo->prepare("SELECT id FROM users WHERE username = :kadi");
$stmtUser->execute([':kadi' => $_SESSION['kullanici']]);
$userRow = $stmtUser->fetch(PDO::FETCH_ASSOC);
$aktifID = $userRow['id'];

echo "<h3>👤 Kullanıcı ID: $aktifID İçin Yükleme Başlıyor...</h3>";

// 3. JSON DOSYASINI OKU
$json_dosyasi = 'data/tum_ilaclar.json';
if (!file_exists($json_dosyasi)) { die("❌ 'data/tum_ilaclar.json' dosyası bulunamadı!"); }

$veri = file_get_contents($json_dosyasi);
$ilaclar = json_decode($veri, true);

if (!$ilaclar) { die("❌ JSON dosyası boş veya okunamadı!"); }

$sayac = 0;

// 4. VERİTABANINA EKLE
foreach ($ilaclar as $ilac) {
    $ad = $ilac['ad'];
    $etken = $ilac['etken'];
    $kategori = $ilac['kategori'];
    
    // Rastgele Tarih ve Yer
    $yil = rand(2025, 2027);
    $ay = rand(1, 12);
    $gun = rand(1, 28);
    $skt = "$yil-$ay-$gun";
    
    $yerler = ["Ecza Dolabı", "Mutfak", "Çanta", "Çekmece", "Banyo"];
    $konum = $yerler[array_rand($yerler)];

    // Çift Kayıt Kontrolü
    $kontrol = $pdo->prepare("SELECT id FROM medicines WHERE ilac_adi = :ad AND user_id = :uid");
    $kontrol->execute([':ad' => $ad, ':uid' => $aktifID]);

    if ($kontrol->rowCount() == 0) {
        $sql = "INSERT INTO medicines (user_id, ilac_adi, etken_madde, kategori, kutu_konumu, son_kullanma_tarihi) 
                VALUES (:uid, :ad, :etken, :kat, :konum, :skt)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':uid'=>$aktifID, ':ad'=>$ad, ':etken'=>$etken, ':kat'=>$kategori, ':konum'=>$konum, ':skt'=>$skt]);
        
        echo "✅ <span style='color:green'>Eklendi: $ad</span><br>";
        $sayac++;
    } else {
        echo "⚠️ <span style='color:orange'>Zaten Var: $ad</span><br>";
    }
}

echo "<hr><h1>🎉 İŞLEM BİTTİ! Toplam $sayac yeni ilaç eklendi.</h1>";
echo "<a href='index.php' style='background:#2ecc71; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;'>🏠 Ana Sayfaya Dön</a>";
echo "</div>";
?>