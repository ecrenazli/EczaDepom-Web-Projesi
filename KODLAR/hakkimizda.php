<?php session_start(); ?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hakkımızda - EczaDepom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background-color: #f0f4f8; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* MAVİ TEMA AYARLARI */
        .hero-section {
            background: linear-gradient(120deg, #1e3799, #0984e3); /* Kurumsal Mavi */
            color: white;
            padding: 80px 0;
            margin-bottom: 50px;
            text-align: center;
            border-bottom: 5px solid #74b9ff;
            box-shadow: 0 10px 20px rgba(30, 55, 153, 0.2);
        }
        
        .feature-box {
            padding: 30px;
            border-radius: 15px;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            height: 100%;
            transition: all 0.3s ease;
            border: 1px solid #e1e8ef;
        }
        
        .feature-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(30, 55, 153, 0.15);
            border-color: #74b9ff;
        }
        
        .icon-circle {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #e1f5fe, #b3e5fc);
            color: #0277bd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 25px;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 5px 15px rgba(2, 119, 189, 0.2);
        }
        
        /* Navbar Mavi */
        .custom-navbar {
            background-color: #1e3799 !important;
            box-shadow: 0 4px 12px rgba(30, 55, 153, 0.2);
        }

        /* YENİ MODERN GÖRSEL STİLİ */
        .profesyonel-resim {
            width: 100%; 
            max-width: 500px;
            border-radius: 20px; 
            box-shadow: 0 20px 50px rgba(30, 55, 153, 0.2);
            border: 5px solid white;
            transition: transform 0.3s;
            object-fit: cover;
        }
        .profesyonel-resim:hover {
            transform: scale(1.02);
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark custom-navbar sticky-top py-3">
        <div class="container">
            <span class="navbar-brand fw-bold" style="font-size: 1.5rem; letter-spacing: 1px;">
                <i class="fa-solid fa-pills me-2"></i>EczaDepom
            </span>
            <a href="index.php" class="btn btn-outline-light btn-sm rounded-pill px-4 fw-bold">
                <i class="fa-solid fa-arrow-left me-2"></i>Ana Sayfaya Dön
            </a>
        </div>
    </nav>

    <header class="hero-section">
        <div class="container">
            <h1 class="display-4 fw-bolder mb-3">Sağlığınız İçin Akıllı Teknoloji</h1>
            <p class="lead opacity-90" style="font-weight: 500;">Evdeki ilaç yönetimini dijitalleştirerek güvenli ve sürdürülebilir bir gelecek inşa ediyoruz.</p>
        </div>
    </header>

    <div class="container mb-5">
        <div class="row mb-5 align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="fw-bold mb-4" style="color: #1e3799; font-size: 2.2rem;">Biz Kimiz?</h2>
                <p class="text-muted" style="font-size: 1.15rem; line-height: 1.9;">
                    EczaDepom, bireylerin ve ailelerin sağlık süreçlerini modern teknolojiyle buluşturmak için kurulmuş <strong>yeni nesil bir dijital sağlık girişimidir.</strong>
                </p>
                <p class="text-muted" style="font-size: 1.15rem; line-height: 1.9;">
                    Amacımız; evlerdeki ilaç karmaşasını, son kullanma tarihi takipsizliğini ve bilinçsiz ilaç kullanımını, geliştirdiğimiz akıllı stok yönetim algoritmalarıyla sona erdirmektir.
                </p>
            </div>
            <div class="col-lg-6 text-center">
                <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=800&q=80" 
                     alt="Dijital Sağlık Teknolojisi" 
                     class="profesyonel-resim">
            </div>
        </div>

        <hr class="my-5" style="border-color: #74b9ff; opacity: 0.3;">

        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="feature-box">
                    <div class="icon-circle">
                        <i class="fa-solid fa-bullseye"></i>
                    </div>
                    <h4 class="fw-bold" style="color: #1e3799;">Misyonumuz</h4>
                    <p class="text-muted mt-3">
                        İlaç israfını önlemek ve her haneye güvenli ilaç kullanım bilincini yerleştirerek toplumsal sağlığa ve ekonomiye katkı sağlamak.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box">
                    <div class="icon-circle">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h4 class="fw-bold" style="color: #1e3799;">Vizyonumuz</h4>
                    <p class="text-muted mt-3">
                        Sağlık teknolojileri (HealthTech) alanında global bir oyuncu olmak ve evrensel bir "dijital sağlık asistanı" standardı oluşturmak.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box">
                    <div class="icon-circle">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h4 class="fw-bold" style="color: #1e3799;">Güvenlik & Gizlilik</h4>
                    <p class="text-muted mt-3">
                        Veri güvenliği bizim temel taşımızdır. Sağlık verileriniz, en güncel şifreleme standartlarıyla korunmaktadır.
                    </p>
                </div>
            </div>
        </div>

        <div class="text-center mt-5 pt-5">
            <h5 class="fw-bold mb-3" style="color: #1e3799; letter-spacing: 2px;">ECZADEPOM EKİBİ</h5>
            <p class="text-muted fst-italic">"Daha sağlıklı yarınlar için teknolojiyi kullanıyoruz."</p>
        </div>
    </div>

    <footer class="text-white text-center py-4 mt-auto" style="background-color: #1e3799; border-top: 5px solid #0984e3;">
        <div class="container">
            <div class="mb-2 d-flex justify-content-center align-items-center">
                <i class="fa-solid fa-pills fa-2x me-3"></i> 
                <span class="fw-bold" style="font-size: 1.2rem; letter-spacing: 1px;">EczaDepom</span>
            </div>
            <small style="opacity: 0.7; letter-spacing: 1px;">&copy; 2025 Tüm Hakları Saklıdır. | Dijital Sağlık Çözümleri A.Ş.</small>
        </div>
    </footer>

</body>
</html>