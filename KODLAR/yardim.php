<?php session_start(); ?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yardım Merkezi - EczaDepom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f0f4f8; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        .custom-navbar {
            background-color: #1e3799 !important;
            box-shadow: 0 4px 12px rgba(30, 55, 153, 0.2);
        }

        .accordion-button:not(.collapsed) {
            color: #1e3799;
            background-color: #e1f5fe;
            box-shadow: inset 0 -1px 0 rgba(0,0,0,.125);
            font-weight: bold;
        }
        
        .accordion-button:focus {
            box-shadow: 0 0 0 0.25rem rgba(30, 55, 153, 0.25);
            border-color: #1e3799;
        }

        .help-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .help-header {
            background: linear-gradient(135deg, #1e3799, #4a69bd);
            color: white;
            padding: 40px;
            text-align: center;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark custom-navbar mb-4 p-3">
        <div class="container">
            <span class="navbar-brand fw-bold" style="font-size: 1.4rem;">
                <i class="fa-solid fa-circle-question me-2"></i> Yardım Merkezi
            </span>
            <a href="index.php" class="btn btn-outline-light btn-sm rounded-pill px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Ana Sayfaya Dön
            </a>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                
                <div class="card help-card">
                    <div class="help-header">
                        <h2 class="fw-bold"><i class="fa-solid fa-headset fa-lg mb-3"></i><br>Nasıl Yardımcı Olabiliriz?</h2>
                        <p class="opacity-75 mb-0">Sıkça sorulan soruları ve sistem kullanım kılavuzunu aşağıda bulabilirsiniz.</p>
                    </div>

                    <div class="card-body p-5">
                        <div class="accordion" id="accordionHelp">
                            
                            <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                        <i class="fa-solid fa-plus-circle me-2 text-primary"></i> Sisteme nasıl ilaç ekleyebilirim?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionHelp">
                                    <div class="accordion-body text-muted">
                                        Üye girişi yaptıktan sonra sol menüde bulunan <strong>"İlaç Ekle"</strong> butonuna tıklayarak yeni ilaç kayıt formuna ulaşabilirsiniz. İlacın adını, kategorisini ve son kullanma tarihini girip kaydetmeniz yeterlidir.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                        <i class="fa-solid fa-triangle-exclamation me-2 text-danger"></i> Kırmızı renkli ilaçlar ne anlama geliyor?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionHelp">
                                    <div class="accordion-body text-muted">
                                        Listede kırmızı renkle işaretlenmiş ve üzerinde "⚠️" uyarısı bulunan ilaçlar, <strong>Son Kullanma Tarihi (SKT) geçmiş</strong> ilaçlardır. Bu ilaçları kullanmamanız ve en yakın atık ilaç toplama merkezine teslim etmeniz önerilir.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                        <i class="fa-solid fa-trash-can me-2 text-secondary"></i> Kaydettiğim bir ilacı nasıl silerim?
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionHelp">
                                    <div class="accordion-body text-muted">
                                        İlaç listenizdeki her satırın sağ tarafında bir <strong>Çöp Kutusu</strong> ikonu bulunur. Buna tıkladığınızda sistem sizden onay ister. Onay verirseniz ilaç kaydı kalıcı olarak silinir.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                        <i class="fa-solid fa-user-lock me-2 text-success"></i> Üyelik bilgilerim güvende mi?
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionHelp">
                                    <div class="accordion-body text-muted">
                                        Evet, EczaDepom kişisel verilerinizi üçüncü şahıslarla paylaşmaz. Şifreleriniz veritabanımızda güvenli algoritmalarla saklanmaktadır.
                                    </div>
                                </div>
                            </div>

                             <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                                <h2 class="accordion-header" id="headingFive">
                                    <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive">
                                        <i class="fa-solid fa-filter me-2 text-warning"></i> İlaçları nasıl filtreleyebilirim?
                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionHelp">
                                    <div class="accordion-body text-muted">
                                        Ana sayfadaki "İlaç Arama ve Filtreleme" kutusunu kullanarak ilaçları kategorilerine (Ağrı Kesici, Vitamin vb.) göre filtreleyebilir veya isme göre A'dan Z'ye sıralayabilirsiniz.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    
                    <div class="card-footer bg-light text-center p-4">
                        <p class="mb-2">Aradığınız cevabı bulamadınız mı?</p>
                        <a href="iletisim.php" class="btn btn-primary fw-bold px-4" style="background-color: #1e3799; border:none;">
                            Destek Ekibiyle İletişime Geçin
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <footer class="text-white text-center py-4 mt-auto" style="background-color: #1e3799;">
        <div class="container">
            <small style="opacity: 0.8; letter-spacing: 0.5px;">&copy; 2025 EczaDepom Yardım Merkezi | Tüm Hakları Saklıdır.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>