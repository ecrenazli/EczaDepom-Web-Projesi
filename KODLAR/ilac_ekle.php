<?php
session_start();
include 'db.php'; 

// Otomatik Giriş Kontrolü
if (!isset($_SESSION['kullanici']) && isset($_COOKIE['hatirla_beni'])) {
    $_SESSION['kullanici'] = $_COOKIE['hatirla_beni'];
}

// Giriş yapılmamışsa ana sayfaya at
if (!isset($_SESSION['kullanici'])) {
    header("Location: index.php");
    exit;
}

// Hataları göster (Geliştirme aşamasında açık kalsın)
ini_set('display_errors', 1); error_reporting(E_ALL);

// Aktif Kullanıcıyı Bul
$stmtUser = $pdo->prepare("SELECT id FROM users WHERE username = :kadi");
$stmtUser->execute([':kadi' => $_SESSION['kullanici']]);
$userRow = $stmtUser->fetch(PDO::FETCH_ASSOC);
$aktifKullaniciID = $userRow ? $userRow['id'] : 1;

// JSON Dosyasını Oku
$json_dosyasi = 'data/tum_ilaclar.json';
$hazir_ilaclar = [];
if (file_exists($json_dosyasi)) {
    $veri = file_get_contents($json_dosyasi);
    $hazir_ilaclar = json_decode($veri, true) ?? [];
}

$mesaj = "";

// Form Gönderildiğinde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verileri al
    $ilac_adi = $_POST['ilac_adi'];
    $etken_madde = $_POST['etken_madde'];
    $kategori = $_POST['kategori'];
    $skt = $_POST['skt'];
    $konum = $_POST['konum'];
    $notlar = $_POST['notlar']; // Yeni eklenen alan

    // Basit doğrulama
    if(!empty($ilac_adi) && !empty($skt)) {
        try {
            // SQL Sorgusu (notlar alanı eklendi)
            $sql = "INSERT INTO medicines (user_id, ilac_adi, etken_madde, son_kullanma_tarihi, kutu_konumu, kategori, notlar) 
                    VALUES (:uid, :ad, :etken, :skt, :konum, :kat, :not)";
            
            $stmt = $pdo->prepare($sql);
            $sonuc = $stmt->execute([
                ':uid' => $aktifKullaniciID, 
                ':ad' => $ilac_adi, 
                ':etken' => $etken_madde, 
                ':skt' => $skt, 
                ':konum' => $konum, 
                ':kat' => $kategori,
                ':not' => $notlar
            ]);
            
            if($sonuc) {
                $mesaj = "<div style='background:#d4edda; color:#155724; padding:15px; border-radius:5px; margin-bottom:20px; border:1px solid #c3e6cb;'>
                            ✅ <strong>BAŞARILI!</strong> İlaç dolabınıza eklendi. <a href='index.php' style='font-weight:bold; text-decoration:underline;'>Listeye Dön</a>
                          </div>";
            }
        } catch (PDOException $e) { 
            $mesaj = "<div style='background:#f8d7da; color:#721c24; padding:15px; border-radius:5px;'>❌ Hata: " . $e->getMessage() . "</div>"; 
        }
    } else { 
        $mesaj = "<div style='background:#fff3cd; color:#856404; padding:15px; border-radius:5px;'>⚠️ Lütfen ilaç adı ve son kullanma tarihini girin.</div>"; 
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İlaç Ekle - EczaDepom</title>
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    
    <nav class="navbar">
        <div class="logo" style="font-size:1.5rem; font-weight:bold;">
            <i class="fa-solid fa-pills"></i> EczaDepom
        </div>
        <div>
            <a href="index.php" style="color:white; font-weight:bold;">
                <i class="fa-solid fa-arrow-left"></i> Ana Sayfaya Dön
            </a>
        </div>
    </nav>

    <div class="ana-kapsayici">

        <aside class="sol-menu">
            <div class="panel-kart">
                <h3 style="color:#2c3e50; margin-bottom:15px;">📌 Menü</h3>
                <ul>
                    <li><a href="index.php"><i class="fa-solid fa-house"></i> Ana Sayfa</a></li>
                    <li><a href="ilac_ekle.php" style="background:#e3f2fd; color:#3498db;"><i class="fa-solid fa-plus-circle"></i> İlaç Ekle</a></li>
                </ul>
            </div>
        </aside>

        <main>
            <div class="panel-kart">
                <h2 style="color:#2c3e50; border-bottom:3px solid #3498db; padding-bottom:10px; margin-bottom:20px;">
                    <i class="fa-solid fa-file-medical"></i> İlaç Kaydı
                </h2>

                <?php echo $mesaj; ?>

                <form action="" method="POST">
                    
                    <div style="margin-bottom:15px;">
                        <label style="font-weight:bold; display:block; margin-bottom:5px;">Hızlı Seçim (İsteğe Bağlı):</label>
                        <select id="ilacSecimi" style="width:100%; padding:12px; border:2px solid #3498db; border-radius:5px; background:#f0f8ff;">
                            <option value="">-- Listeden Seçip Otomatik Doldur --</option>
                            <?php foreach ($hazir_ilaclar as $ilac) { 
                                echo "<option value='{$ilac['ad']}' data-etken='{$ilac['etken']}' data-kategori='{$ilac['kategori']}'>{$ilac['ad']}</option>"; 
                            } ?>
                        </select>
                        <small style="color:#666; font-size:0.8rem;">Listeden seçebilir VEYA aşağıya kendiniz yazabilirsiniz.</small>
                    </div>

                    <div style="margin-bottom:15px;">
                        <label style="font-weight:bold;">İlaç Adı:</label>
                        <input type="text" name="ilac_adi" id="ilacAdiInput" placeholder="İlacın adını yazın..." required style="width:100%; padding:12px; border:1px solid #ccc; border-radius:5px;">
                    </div>

                    <div style="margin-bottom:15px;">
                        <label style="font-weight:bold;">Etken Madde:</label>
                        <input type="text" name="etken_madde" id="etkenKutusu" placeholder="Örn: Parasetamol" style="width:100%; padding:12px; border:1px solid #ccc; border-radius:5px; background:#f9f9f9;">
                    </div>

                    <div style="margin-bottom:15px;">
                        <label style="font-weight:bold;">Kategori:</label>
                        <input type="text" name="kategori" id="kategoriKutusu" placeholder="Örn: Ağrı Kesici" style="width:100%; padding:12px; border:1px solid #ccc; border-radius:5px; background:#f9f9f9;">
                    </div>

                    <div style="margin-bottom:15px;">
                        <label style="font-weight:bold;">Son Kullanma Tarihi:</label>
                        <input type="date" name="skt" required style="width:100%; padding:12px; border:1px solid #ccc; border-radius:5px;">
                    </div>

                    <div style="margin-bottom:20px;">
                        <label style="font-weight:bold;">Konum:</label>
                        <select name="konum" style="width:100%; padding:12px; border:1px solid #ccc; border-radius:5px;">
                            <option value="Ecza Dolabı">Ecza Dolabı</option>
                            <option value="Mutfak">Mutfak</option>
                            <option value="Banyo">Banyo</option>
                            <option value="Çanta">Çanta</option>
                            <option value="Yatak Odası">Yatak Odası</option>
                            <option value="Diğer">Diğer</option>
                        </select>
                    </div>

                    <div style="margin-bottom:20px;">
                        <label style="font-weight:bold;">Notlar / Açıklama:</label>
                        <textarea name="notlar" rows="3" placeholder="Örn: Günde 2 defa tok karna..." style="width:100%; padding:12px; border:1px solid #ccc; border-radius:5px;"></textarea>
                    </div>

                    <button type="submit" style="background:#27ae60; color:white; padding:15px; border:none; border-radius:8px; cursor:pointer; font-size:1.1rem; width:100%; font-weight:bold;">
                        <i class="fa-solid fa-save"></i> KAYDET
                    </button>

                </form>
            </div>
        </main>

        <aside class="sag-menu">
            <div class="bilgi-karti">
                <div class="bilgi-baslik" style="background: linear-gradient(135deg, #e74c3c, #c0392b);">
                    <i class="fa-solid fa-triangle-exclamation"></i> Önemli Uyarılar
                </div>
                <div class="bilgi-icerik">
                    
                    <div class="bilgi-satir">
                        <div class="bilgi-ikon" style="color:#c0392b; background:#fadbd8;">
                            <i class="fa-solid fa-trash-can"></i>
                        </div>
                        <div class="bilgi-metin">
                            <strong>Tarihi Geçeni Atın!</strong><br>
                            Bozulmuş ilaçlar zehirlenmeye yol açabilir. Asla kullanmayın.
                        </div>
                    </div>

                    <div class="bilgi-satir">
                        <div class="bilgi-ikon" style="color:#e67e22; background:#fff3e0;">
                            <i class="fa-solid fa-temperature-low"></i>
                        </div>
                        <div class="bilgi-metin">
                            <strong>Isı ve Nemden Koruyun</strong><br>
                            Serin ve kuru yerleri tercih edin.
                        </div>
                    </div>

                    <div class="bilgi-satir">
                        <div class="bilgi-ikon" style="color:#27ae60; background:#e8f8f5;">
                            <i class="fa-solid fa-child-reaching"></i>
                        </div>
                        <div class="bilgi-metin">
                            <strong>Çocuk Güvenliği</strong><br>
                            İlaçları çocukların erişemeyeceği yüksek yerlerde saklayın.
                        </div>
                    </div>

                </div>
            </div>
        </aside>

    </div>

    <footer style="background: #ecf0f1; color: #7f8c8d; padding: 20px 0; margin-top: 40px; border-top: 3px solid #bdc3c7;">
        <div class="footer-container" style="text-align: center;">
            <p style="font-size: 0.9rem;">
                <i class="fa-solid fa-shield-alt"></i> <strong>Veri Güvenliği:</strong> Girdiğiniz ilaç bilgileri şifreli bağlantı ile korunmaktadır.
            </p>
            <p style="margin-top: 10px;">EczaDepom &copy; 2025</p>
        </div>
    </footer>

    <script>
        document.getElementById('ilacSecimi').addEventListener('change', function() {
            var opt = this.options[this.selectedIndex];
            var ilacAdi = opt.value; // Seçilen ilacın adı
            var etken = opt.getAttribute('data-etken');
            var kategori = opt.getAttribute('data-kategori');
            
            if(ilacAdi) {
                // Listeden seçildiyse Inputlara doldur
                document.getElementById('ilacAdiInput').value = ilacAdi;
                document.getElementById('etkenKutusu').value = etken;
                document.getElementById('kategoriKutusu').value = kategori;

                // Görsel efekt (Yeşil yanıp sönme)
                document.getElementById('ilacAdiInput').style.backgroundColor = "#d4edda";
                setTimeout(() => { document.getElementById('ilacAdiInput').style.backgroundColor = "#fff"; }, 500);
            } else {
                // "Seçiniz"e dönerse temizleme yapmıyoruz ki kullanıcı elle yazabilsin
            }
        });
    </script>

</body>
</html>