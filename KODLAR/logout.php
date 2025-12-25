<?php
session_start();
session_destroy();

// Beni Hatırla Çerezini Sil (Zamanı geçmişe alarak silinir)
if (isset($_COOKIE['hatirla_beni'])) {
    setcookie("hatirla_beni", "", time() - 3600, "/");
}

header("Location: index.php");
exit;
?>