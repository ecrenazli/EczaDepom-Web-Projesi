<?php 
session_start();
// Veritabanı bağlantı dosyanı dahil ediyoruz
include 'db.php'; 

// Form gönderildi mi kontrolü (POST işlemi)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri değişkenlere alıyoruz
    $ad_soyad = $_POST['ad_soyad'];
    $email    = $_POST['email'];
    $konu     = $_POST['konu'];
    $mesaj    = $_POST['mesaj'];

    // Verilerin boş olup olmadığını basitçe kontrol edelim
    if(!empty($ad_soyad) && !empty($email) && !empty($mesaj)) {
        try {
            // Veritabanına ekleme sorgusu
            $sql = "INSERT INTO iletisim (ad_soyad, email, konu, mesaj) VALUES (:ad_soyad, :email, :konu, :mesaj)";
            $stmt = $pdo->prepare($sql);
            
            $sonuc = $stmt->execute([
                ':ad_soyad' => $ad_soyad,
                ':email' => $email,
                ':konu' => $konu,
                ':mesaj' => $mesaj
            ]);

            if ($sonuc) {
                // Başarılı ise JavaScript ile uyarı ver ve sayfayı yenile
                echo "<script>
                        alert('Mesajınız başarıyla iletildi. En kısa sürede dönüş yapacağız.');
                        window.location.href='iletisim.php';
                      </script>";
            } else {
                echo "<script>alert('Bir hata oluştu, lütfen tekrar deneyiniz.');</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('Veritabanı hatası: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Lütfen tüm alanları doldurunuz.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim - EczaDepom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f0f4f8; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        .contact-icon-box {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .custom-navbar {
            background-color: #1e3799 !important;
            box-shadow: 0 4px 12px rgba(30, 55, 153, 0.2);
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark custom-navbar mb-4 p-3">
        <div class="container">
            <span class="navbar-brand fw-bold" style="font-size: 1.4rem;">
                <i class="fa-solid fa-envelope-open-text me-2"></i> İletişim
            </span>
            <a href="index.php" class="btn btn-outline-light btn-sm rounded-pill px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Ana Sayfaya Dön
            </a>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="row justify-content-center">
            
            <div class="col-md-5 mb-4">
                <div class="card shadow border-0 h-100" style="background: linear-gradient(135deg, #2c3e50, #1e3799); color: white; border-radius: 15px;">
                    <div class="card-body p-5 d-flex flex-column justify-content-center">
                        <h3 class="mb-4 fw-bold">Bize Ulaşın</h3>
                        <p class="opacity-75 mb-5">Sorularınız, önerileriniz veya teknik destek talepleriniz için bize aşağıdaki kanallardan ulaşabilirsiniz.</p>
                        
                        <div class="d-flex align-items-center mb-4">
                            <div class="contact-icon-box"><i class="fa-solid fa-location-dot fa-lg"></i></div>
                            <div>
                                <h6 class="fw-bold mb-0">Adres</h6>
                                <small class="opacity-75">Teknoloji Geliştirme Bölgesi, İstanbul</small>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-4">
                            <div class="contact-icon-box"><i class="fa-solid fa-phone fa-lg"></i></div>
                            <div>
                                <h6 class="fw-bold mb-0">Telefon</h6>
                                <small class="opacity-75">+90 850 123 45 67</small>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-4">
                            <div class="contact-icon-box"><i class="fa-solid fa-envelope fa-lg"></i></div>
                            <div>
                                <h6 class="fw-bold mb-0">E-Posta</h6>
                                <small class="opacity-75">info@eczadepom.com</small>
                            </div>
                        </div>
                        
                        <div class="mt-auto">
                            <h6 class="mb-3">Bizi Takip Edin</h6>
                            <a href="#" class="text-white me-3 opacity-75 hover-opacity-100"><i class="fa-brands fa-instagram fa-xl"></i></a>
                            <a href="#" class="text-white me-3 opacity-75 hover-opacity-100"><i class="fa-brands fa-linkedin fa-xl"></i></a>
                            <a href="#" class="text-white opacity-75 hover-opacity-100"><i class="fa-brands fa-twitter fa-xl"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7 mb-4">
                <div class="card shadow border-0" style="border-radius: 15px;">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h5 class="m-0 text-primary fw-bold" style="color: #1e3799 !important;">Görüş ve Öneri Formu</h5>
                    </div>
                    <div class="card-body p-4">
                        
                        <form method="POST" action="">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-muted small">ADINIZ SOYADINIZ</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-user text-muted"></i></span>
                                        <input type="text" name="ad_soyad" class="form-control bg-light border-start-0" placeholder="Adınız..." required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-muted small">E-POSTA ADRESİNİZ</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-at text-muted"></i></span>
                                        <input type="email" name="email" class="form-control bg-light border-start-0" placeholder="ornek@email.com" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted small">KONU</label>
                                <select name="konu" class="form-select bg-light">
                                    <option>Genel Sorular</option>
                                    <option>Hata Bildirimi</option>
                                    <option>İş Birliği</option>
                                    <option>Öneri / Teşekkür</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-muted small">MESAJINIZ</label>
                                <textarea name="mesaj" class="form-control bg-light" rows="5" placeholder="Mesajınızı buraya yazınız..." required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 fw-bold py-2" style="background-color: #1e3799; border: none;">
                                <i class="fa-solid fa-paper-plane me-2"></i> GÖNDER
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-white text-center py-4 mt-auto" style="background-color: #1e3799;">
        <div class="container">
            <small style="opacity: 0.8; letter-spacing: 0.5px;">&copy; 2025 EczaDepom İletişim Merkezi | Tüm Hakları Saklıdır.</small>
        </div>
    </footer>

</body>
</html>