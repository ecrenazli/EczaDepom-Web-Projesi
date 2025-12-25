<?php
require_once 'db.php';

// JSON verisini al
$veri = json_decode(file_get_contents("php://input"), true);

if (isset($veri['id'])) {
    try {
        // Kriter 9 & 24: SQL UPDATE İşlemi
        $sql = "UPDATE medicines SET son_kullanma_tarihi = :tarih, kutu_konumu = :konum WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        
        $sonuc = $stmt->execute([
            ':tarih' => $veri['tarih'],
            ':konum' => $veri['konum'],
            ':id' => $veri['id']
        ]);

        if ($sonuc) {
            echo json_encode(["durum" => "basarili"]);
        } else {
            echo json_encode(["durum" => "hata", "mesaj" => "Güncellenemedi."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["durum" => "hata", "mesaj" => $e->getMessage()]);
    }
}
?>