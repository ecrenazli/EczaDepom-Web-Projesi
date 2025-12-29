<?php
session_start();
include 'db.php'; 
include 'User.php'; 
error_reporting(0);

// Cookie Oluşturma
if(!isset($_COOKIE['son_ziyaret'])) { setcookie("son_ziyaret", date("H:i d.m.Y"), time() + (86400 * 30), "/"); }
$sonZiyaret = isset($_COOKIE['son_ziyaret']) ? $_COOKIE['son_ziyaret'] : "İlk Ziyaretiniz";
setcookie("son_ziyaret", date("H:i d.m.Y"), time() + (86400 * 30), "/");
if(!isset($_COOKIE['ziyaret'])) { setcookie("ziyaret", "1", time() + (86400 * 30), "/"); }

// Giriş Kontrolü
$girisYapildi = isset($_SESSION['kullanici']);
$aktifKullaniciID = 0;
$mod = "ziyaretci"; 

if ($girisYapildi) {
    $currentUser = new User($pdo); 
    if ($currentUser->login($_SESSION['kullanici'])) {
        $mod = "uye";
        $aktifKullaniciID = $currentUser->getId();
    }
}

// Veri Çekme
if ($mod == "uye") {
    $stmtToplam = $pdo->prepare("SELECT COUNT(*) FROM medicines WHERE user_id = :uid");
    $stmtToplam->execute([':uid' => $aktifKullaniciID]);
    $toplamIlac = $stmtToplam->fetchColumn();
    $stmtGecmis = $pdo->prepare("SELECT COUNT(*) FROM medicines WHERE user_id = :uid AND son_kullanma_tarihi < CURDATE()");
    $stmtGecmis->execute([':uid' => $aktifKullaniciID]);
    $gecmisIlac = $stmtGecmis->fetchColumn();
} else {
    $stmtToplam = $pdo->query("SELECT COUNT(DISTINCT ilac_adi) FROM medicines");
    $toplamIlac = $stmtToplam->fetchColumn();
    $gecmisIlac = "-";
}

// SQL Sorgusu
$where = []; $params = [];
if ($mod == "uye") { $sql = "SELECT * FROM medicines WHERE user_id = :uid"; $params[':uid'] = $aktifKullaniciID; $tabloBaslik = "📦 Ecza Dolabım"; } 
else { $sql = "SELECT * FROM medicines"; $tabloBaslik = "💊 İlaç Rehberi"; }

$bolge = isset($_GET['bolge']) ? $_GET['bolge'] : '';
if ($bolge == 'bas') { $where[] = "(kategori LIKE :k1 OR kategori LIKE :k2 OR kategori LIKE :k3)"; $params[':k1'] = '%Ağrı%'; $params[':k2'] = '%Grip%'; $params[':k3'] = '%Baş%'; }
elseif ($bolge == 'omuz') { $where[] = "(kategori LIKE :k1 OR kategori LIKE :k2)"; $params[':k1'] = '%Kas%'; $params[':k2'] = '%Romatizma%'; }
elseif ($bolge == 'karin') { $where[] = "(kategori LIKE :k1 OR kategori LIKE :k2)"; $params[':k1'] = '%Mide%'; $params[':k2'] = '%Sindirim%'; }
elseif ($bolge == 'cilt') { $where[] = "(kategori LIKE :k1 OR kategori LIKE :k2)"; $params[':k1'] = '%Cilt%'; $params[':k2'] = '%Krem%'; }

if (isset($_GET['kategori']) && !empty($_GET['kategori'])) { $where[] = "kategori = :kat_filtre"; $params[':kat_filtre'] = $_GET['kategori']; }
if (count($where) > 0) { if ($mod == "uye") $sql .= " AND " . implode(" AND ", $where); else $sql .= " WHERE " . implode(" AND ", $where); }
if ($mod == "ziyaretci") { $sql .= " GROUP BY ilac_adi"; }

$order = "ORDER BY ilac_adi ASC"; 
if (isset($_GET['sirala'])) {
    if ($_GET['sirala'] == 'az') $order = "ORDER BY ilac_adi ASC";
    if ($_GET['sirala'] == 'za') $order = "ORDER BY ilac_adi DESC";
    if ($mod == 'uye' && $_GET['sirala'] == 'yakin') $order = "ORDER BY son_kullanma_tarihi ASC";
}
$sql .= " " . $order;
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="EczaDepom Stok Takip">
    <title>EczaDepom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
</head>
<body>
    <a id="sayfaBasi"></a>

    <nav class="navbar">
        <div class="logo" style="font-size:1.5rem; font-weight:bold;"><i class="fa-solid fa-pills"></i> EczaDepom</div>
        <div>
            <a href="#footerAlani" style="color:white; margin-right:15px; font-size:0.8rem; border:1px solid white; padding:5px 10px; border-radius:15px; text-decoration:none;">
                <i class="fa-solid fa-arrow-down"></i> Alta İn
            </a>
            <?php if ($girisYapildi): ?>
                <span>Hoşgeldin, <strong><?php echo htmlspecialchars($_SESSION['kullanici']); ?></strong> | </span>
                <a href="logout.php" style="background:#e74c3c; padding:5px 10px; border-radius:5px; color:white; margin-left:10px;">Çıkış</a>
            <?php else: ?>
                <a href="login.php" style="color:white; font-weight:bold; border:1px solid white; padding:5px 10px; border-radius:5px;">Giriş</a>
                <a href="register.php" style="background:white; color:#3498db; padding:5px 10px; border-radius:5px; font-weight:bold;">Kayıt Ol</a>
            <?php endif; ?>
        </div>
    </nav>

    <nav class="yatay-menu">
        <ul>
            <li><a href="index.php"><i class="fa-solid fa-home"></i> Ana Sayfa</a></li>
            <li><a href="hakkimizda.php"><i class="fa-solid fa-info-circle"></i> Hakkımızda</a></li>
            <li><a href="iletisim.php"><i class="fa-solid fa-envelope"></i> İletişim</a></li>
            <li><a href="yardim.php"><i class="fa-solid fa-circle-question"></i> Yardım</a></li>
            <?php if ($girisYapildi): ?>
                <li><a href="logout.php" style="background-color: #c0392b;"><i class="fa-solid fa-right-from-bracket"></i> Çıkış Yap</a></li>
            <?php else: ?>
                <li><a href="login.php"><i class="fa-solid fa-user"></i> Giriş Yap</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="ana-kapsayici">
        <aside class="sol-menu">
            <div class="panel-kart" style="text-align:center;">
                <h3 style="color:#2c3e50; margin-bottom:15px; border-bottom:2px solid #3498db; padding-bottom:5px;">
                    <?php echo ($mod == 'uye') ? '📊 Dolap Özeti' : '🌍 Sistem Verisi'; ?>
                </h3>
                <div style="background:#e3f2fd; padding:10px; border-radius:8px; margin-bottom:10px;">
                    <strong style="color:#1565c0; font-size:1.5rem; display:block;"><?php echo $toplamIlac; ?></strong>
                    <span style="font-size:0.9rem; color:#555;"><?php echo ($mod == 'uye') ? 'Kayıtlı İlaç' : 'İlaç Çeşidi'; ?></span>
                </div>

                <?php if ($mod == 'uye'): ?>
                    <div style="background:#ffebee; padding:10px; border-radius:8px; margin-bottom:15px;">
                        <strong style="color:#c62828; font-size:1.5rem; display:block;"><?php echo $gecmisIlac; ?></strong>
                        <span style="font-size:0.9rem; color:#555;">Tarihi Geçen</span>
                    </div>
                    
                    <a href="ilac_ekle.php" style="display:block; background:#27ae60; color:white; padding:12px; border-radius:5px; font-weight:bold; transition:0.3s; text-decoration:none; margin-bottom:20px;">
                        <i class="fa-solid fa-plus"></i> İlaç Ekle
                    </a>
                    
                    <div style="border-top:2px dashed #ccc; padding-top:15px; text-align:left;">
                        <h6 style="font-weight:bold; color:#2c3e50;"><i class="fa-solid fa-clipboard-check"></i> Günlük İlaç Takip</h6>
                        <small style="color:#777; font-size:0.7rem;">(Bugün aldıklarınızı not edin)</small>
                        
                        <div class="input-group mb-2 mt-2">
                            <input type="text" id="ilacInput" class="form-control form-control-sm" placeholder="İlaç adı...">
                            <button class="btn btn-success btn-sm" onclick="ilacEkle()">
                                <i class="fa-solid fa-check"></i>
                            </button>
                        </div>
                        
                        <ul id="takipListesi" style="font-size:0.85rem; padding-left:20px; margin-bottom:10px; list-style:none; padding:0;"></ul>

                        <button onclick="sonuncuyuGeriAl()" class="btn btn-sm btn-outline-danger w-100" style="font-size:0.8rem;">
                            <i class="fa-solid fa-rotate-left"></i> Sonuncuyu Geri Al
                        </button>
                    </div>
                    
                    <div id="drop-area" style="margin-top:15px;">
                        <i class="fa-solid fa-cloud-arrow-up fa-2x text-muted"></i>
                        <p style="font-size:0.8rem; margin-top:5px; margin-bottom:0; color:#666;">Reçete Fotoğrafı Sürükle</p>
                    </div>

                <?php else: ?>
                    <div style="background:#fff3cd; padding:10px; border-radius:8px; margin-bottom:15px;">
                        <p style="font-size:0.8rem; color:#856404;">Kendi dolabınızı yönetmek için giriş yapın.</p>
                    </div>
                    <form action="login.php" method="POST" style="text-align:left;">
                        <div class="mb-2"><input type="text" name="kullanici_adi" class="form-control form-control-sm" placeholder="Kullanıcı Adı" required></div>
                        <div class="mb-2"><input type="password" name="sifre" class="form-control form-control-sm" placeholder="Şifre" required></div>
                        <button type="submit" class="btn btn-sm btn-primary w-100 fw-bold">Hızlı Giriş</button>
                    </form>
                    <div class="text-center mt-2"><a href="register.php" style="font-size:0.8rem; text-decoration:underline;">Kayıt Ol</a></div>
                <?php endif; ?>
            </div>

            <div class="panel-kart" style="text-align:center; background:#f9f9f9;">
                <p style="font-weight:bold; margin-bottom:10px; color:#c0392b;">🏥 Yakın Eczaneler</p>
                <ul style="list-style:none; padding:0; text-align:left; font-size:0.9rem; margin-bottom:10px;">
                    <li style="border-bottom:1px solid #ddd; padding:5px 0;">
                        <i class="fa-solid fa-location-dot" style="color:#e74c3c;"></i> <strong>Merkez Eczanesi</strong>
                        <div style="font-size:0.8rem; color:#666; margin-left:15px;">0.5 km | <span style="color:green; font-weight:bold;">Açık</span></div>
                    </li>
                </ul>
                <a href="https://www.google.com/maps/search/nöbetçi+eczane" target="_blank" style="display:block; background:#34495e; color:white; padding:8px; border-radius:5px; font-size:0.9rem; text-decoration:none;">
                    <i class="fa-solid fa-map-location-dot"></i> Haritada Göster
                </a>
                
                <button onclick="konumBul()" style="width: 100%; margin-top: 10px; margin-bottom: 10px; padding: 8px; border: none; background-color: #d35400; color: white; border-radius: 5px; cursor: pointer; font-size: 0.9rem; transition: 0.3s;">
                    <i class="fa-solid fa-location-crosshairs"></i> Konumumu Bul
                </button>

                <div style="margin-top: 10px; border: 3px solid #e74c3c; border-radius: 4px; overflow: hidden; box-shadow: 0 0 10px rgba(231, 76, 60, 0.4);">
                    <iframe src="https://maps.google.com/maps?q=eczane&t=&z=13&ie=UTF8&iwloc=&output=embed" width="100%" height="150" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </aside>

        <main>
            <?php if ($mod == 'ziyaretci'): ?>
            <div class="panel-kart" style="background: linear-gradient(rgba(52, 152, 219, 0.9), rgba(41, 128, 185, 0.8)), url('https://upload.wikimedia.org/wikipedia/commons/thumb/e/e4/Stethoscope_and_doypack.jpg/1280px-Stethoscope_and_doypack.jpg'); background-size: cover; background-position: center; color: white; text-align: center; padding: 40px 20px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                <h1 style="font-size: 2.5rem; margin-bottom: 15px; font-weight: 900;"><i class="fa-solid fa-heart-pulse"></i> EczaDepom</h1>
                <p style="font-size: 1.1rem; max-width: 600px; margin: 0 auto 20px auto; line-height: 1.6;">Evinizdeki ilaç karmaşasına son verin.</p>
                <a href="register.php" style="background: #2ecc71; color: white; padding: 12px 25px; border-radius: 30px; text-decoration: none; font-weight: bold;">Hemen Başla</a>
            </div>
            <?php endif; ?>

            <div class="panel-kart" style="border-top: 4px solid #f39c12;">
                <h4 style="margin-bottom:15px; color:#f39c12;"><i class="fa-solid fa-filter"></i> İlaç Arama</h4>
                <form action="index.php" method="GET" style="display:flex; gap:10px; flex-wrap:wrap;">
                    <select name="kategori" style="flex:1; padding:12px; border:1px solid #ddd; border-radius:5px;">
                        <option value="">-- Kategori --</option>
                        <option value="Ağrı Kesici">💊 Ağrı Kesici</option>
                        <option value="Grip İlacı">🤧 Grip İlacı</option>
                        <option value="Mide İlacı">🤢 Mide İlacı</option>
                        <option value="Kas Gevşetici">💪 Kas Gevşetici</option>
                        <option value="Vitamin">⚡ Vitamin</option>
                    </select>
                    <select name="sirala" style="flex:1; padding:12px; border:1px solid #ddd; border-radius:5px;">
                        <option value="az">🔤 İsim (A-Z)</option>
                        <option value="za">🔤 İsim (Z-A)</option>
                        <?php if($mod == 'uye'): ?><option value="yakin">📅 Tarih</option><?php endif; ?>
                    </select>
                    <button type="submit" style="background:#f39c12; color:white; border:none; padding:12px 25px; border-radius:5px; cursor:pointer; font-weight:bold;">Uygula</button>
                    <?php if(!empty($_GET['kategori']) || !empty($_GET['sirala']) || !empty($bolge)): ?>
                        <a href="index.php" style="background:#e74c3c; color:white; padding:12px 15px; border-radius:5px; display:flex; align-items:center; text-decoration:none;" title="Temizle"><i class="fa-solid fa-times"></i></a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="panel-kart" style="text-align: center;">
                <h3 style="margin-bottom:15px; color:#2c3e50;">Rahatsızlık Bölgesi</h3>
                <div class="vucut-container">
                    <img src="images/vucut.jpg" alt="Vücut Haritası" style="display: block; width: 100%; border-radius: 10px; border: 1px solid #ddd;">
                    <a href="index.php?bolge=bas" class="tiklama-alani" title="Baş Ağrısı" style="top: 2%; left: 35%; width: 30%; height: 18%;"></a>
                    <a href="index.php?bolge=karin" class="tiklama-alani" title="Mide ve Karın" style="top: 35%; left: 30%; width: 40%; height: 30%; border-radius: 20%;"></a>
                    <a href="index.php?bolge=omuz" class="tiklama-alani" title="Omuz ve Sırt" style="top: 20%; left: 10%; width: 80%; height: 15%; border-radius: 10px;"></a>
                    <map name="hidden_map_fix"><area shape="rect" coords="0,0,10,10" href="#" alt="Kriter"></map>
                </div>
                <p style="font-size:0.75rem; color:#888; margin-top: 10px;">(Seçmek için bölgeye tıklayın)</p>
            </div>

            <div class="panel-kart">
                
                <?php if ($mod == 'uye'): ?>
                <div style="margin-bottom: 15px; text-align: right;">
                    <a href="ilac_ekle.php" class="btn btn-success fw-bold">
                        <i class="fa-solid fa-plus"></i> Yeni İlaç Ekle
                    </a>
                </div>
                <?php endif; ?>

                <button class="btn w-100 d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#ilacListesiCollapse" aria-expanded="true" aria-controls="ilacListesiCollapse" style="background:transparent; border:none; border-bottom:1px solid #ddd; padding:15px 0; box-shadow:none;">
                    <h3 style="margin:0; color:#2c3e50; font-size:1.3rem;"><?php echo $tabloBaslik; ?></h3>
                    <i class="fa-solid fa-chevron-down text-primary"></i>
                </button>
                <div class="collapse show" id="ilacListesiCollapse">
                    <div class="card card-body border-0 p-0 mt-3">
                        <table id="tablo" class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>İlaç Adı</th>
                                    <th>Etken Madde</th>
                                    <th>Kategori</th>
                                    <?php if ($mod == 'uye'): ?>
                                        <th>Notlar</th> <th>S.K.T.</th>
                                        <th>Konum</th>
                                        <th style="width:50px;">İşlem</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                try {
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute($params);
                                    if($stmt->rowCount() == 0) {
                                        echo "<tr><td colspan='7' class='text-center p-3 text-muted'>Kayıt bulunamadı.</td></tr>";
                                    } else {
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            $ilacAdi = htmlspecialchars($row['ilac_adi']);
                                            $etken = htmlspecialchars($row['etken_madde']);
                                            $kat = htmlspecialchars($row['kategori']);
                                            echo "<tr class='align-bottom' style='height: 50px;'>"; 
                                            echo "<td class='fw-bold text-primary'>💊 $ilacAdi</td>"; 
                                            echo "<td class='fst-italic'>$etken</td>";
                                            echo "<td><span class='badge bg-secondary text-decoration-underline'>$kat</span></td>";
                                            if ($mod == 'uye') {
                                                // NOTLAR SÜTUNU: Eğer boşsa tire koy
                                                $notlar = !empty($row['notlar']) ? htmlspecialchars($row['notlar']) : "-";
                                                echo "<td class='small text-muted'>$notlar</td>";

                                                $skt = $row['son_kullanma_tarihi'];
                                                $konum = htmlspecialchars($row['kutu_konumu']);
                                                $id = $row['id'];
                                                $gecmis = ($skt < date("Y-m-d"));
                                                $styleClass = $gecmis ? "text-danger fw-bold text-decoration-line-through" : "";
                                                $uyari = $gecmis ? "⚠️ " : "";
                                                echo "<td class='$styleClass'>$uyari".date("d.m.Y", strtotime($skt))."</td>";
                                                echo "<td>$konum</td>";
                                                echo "<td class='text-center'><button onclick='silmeOnayi($id)' class='btn btn-sm text-danger' style='border:none; background:none;'><i class='fa-solid fa-trash-can fa-lg'></i></button></td>";
                                            }
                                            echo "</tr>";
                                        }
                                    }
                                } catch (PDOException $e) { echo "<tr><td colspan='7'>Hata: ".$e->getMessage()."</td></tr>"; }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <aside class="sag-menu">
            <div class="panel-kart" style="text-align:center;">
                <h4 style="color:#2c3e50; border-bottom:2px solid #eee; padding-bottom:10px; margin-bottom:10px;"><i class="fa-solid fa-link"></i> Resmi Kurumlar</h4>
                <marquee direction="left" scrollamount="4" onmouseover="this.stop();" onmouseout="this.start();">
                    <div style="display:flex; gap: 30px; align-items: center;">
                        <a href="https://www.turkiye.gov.tr/" target="_blank" style="text-decoration:none; color:#333; display:inline-block; text-align:center;">
                            <div style="font-size: 2rem; color: #cc0000; margin-bottom: 5px;"><i class="fa-solid fa-landmark-dome"></i></div><span style="font-size:0.7rem; font-weight:bold;">E-Devlet</span>
                        </a>
                        <a href="https://enabiz.gov.tr/" target="_blank" style="text-decoration:none; color:#333; display:inline-block; text-align:center;">
                            <div style="font-size: 2rem; color: #e91e63; margin-bottom: 5px;"><i class="fa-solid fa-heart-pulse"></i></div><span style="font-size:0.7rem; font-weight:bold;">e-Nabız</span>
                        </a>
                        <a href="https://www.yesilay.org.tr/" target="_blank" style="text-decoration:none; color:#333; display:inline-block; text-align:center;">
                            <div style="font-size: 2rem; color: #2e7d32; margin-bottom: 5px;"><i class="fa-solid fa-leaf"></i></div><span style="font-size:0.7rem; font-weight:bold;">Yeşilay</span>
                        </a>
                    </div>
                </marquee>
            </div>

            <div class="panel-kart" style="background:#fff3cd; border-left:4px solid #ffc107; margin-top: 15px;">
                <h4 style="color:#856404; font-size:1.1rem;"><i class="fa-solid fa-bullhorn"></i> Duyurular</h4>
                <marquee direction="up" scrollamount="2" height="120px" onmouseover="this.stop();" onmouseout="this.start();">
                    <ul style="list-style:none; padding:0; margin:0; font-size:0.9rem;">
                        <li style="margin-bottom:10px;">⚠️ <strong>Kış Uyarısı:</strong> Grip salgınına dikkat edin.</li>
                        <li style="margin-bottom:10px;">📅 <strong>Kontrol:</strong> İlaç tarihlerini kontrol ediniz.</li>
                    </ul>
                </marquee>
            </div>

            <div class="panel-kart" style="margin-top: 20px; padding:0; border:none; background:transparent;">
                <div style="background: linear-gradient(45deg, #ff3cac, #784ba0); color:white; padding:15px; border-radius:10px; text-align:center; box-shadow:0 4px 15px rgba(0,0,0,0.2);">
                    <i class="fa-solid fa-gift fa-2x mb-2"></i>
                    <h5 style="font-weight:bold; color:#ffeb3b;">FIRSAT!</h5>
                    <p style="font-size:0.85rem;">Vitaminlerde %50 İndirim!</p>
                    <button class="btn btn-sm btn-light" style="font-size:0.7rem; font-weight:bold;">Tıkla & Kazan</button>
                </div>
                <p style="text-align:center; font-size:0.6rem; color:#aaa; margin-top:5px;">- Sponsorlu Reklam -</p>
            </div>
        </aside>
    </div>

    <footer id="footerAlani">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-6 mb-3 mb-md-0">
                    <h5 class="text-uppercase mb-1"><i class="fa-solid fa-pills me-2"></i> EczaDepom</h5>
                    <small style="display:block; color:#bdc3c7; margin-top:5px; font-size:0.7rem;">🕒 Son Ziyaret: <?php echo $sonZiyaret; ?></small>
                    <div class="copyright-text">© 2025 Tüm Hakları Saklıdır.</div>
                </div>
                <div class="col-md-6 text-md-end text-center">
                    <div class="footer-social mb-3">
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#"><i class="fa-brands fa-twitter"></i></a>
                    </div>
                    <div>
                        <a href="#sayfaBasi" class="text-white text-decoration-none small fw-bold"><i class="fa-solid fa-arrow-up me-1"></i> Sayfa Başına Dön</a><br>
                        <a href="javascript:void(0)" onclick="cerezleriSil()" style="font-size:0.7rem; color:#bdc3c7; text-decoration:underline;"><i class="fa-solid fa-trash"></i> Çerezleri Temizle</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="js/script.js?v=<?php echo time(); ?>"></script>
</body>
</html>