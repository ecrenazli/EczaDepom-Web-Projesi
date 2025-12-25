<?php
//  Sunucu Tarafı OOP (Abstract, Inheritance, Encapsulation)

// 1. ABSTRACT CLASS (SOYUT SINIF) 
abstract class TemelKullanici {
    // Encapsulation (Kapsülleme): protected, miras alan sınıflar erişebilir
    protected $db; 

    public function __construct($databaseConnection) {
        $this->db = $databaseConnection;
    }

    // Abstract Metot: Alt sınıflar bunu kullanmak ZORUNDA 
    abstract public function login($username);
}

// 2. INHERITANCE (KALITIM - extends) 
class User extends TemelKullanici {
    
    // Encapsulation: private özellikler sadece bu sınıfta geçerli
    private $username;
    public $id;

    // Constructor (Kurucu Metot) - Parent sınıfın kurucusunu çağırır
    public function __construct($databaseConnection) {
        parent::__construct($databaseConnection);
    }

    // 3. POLYMORPHISM & IMPLEMENTATION (Uygulama)
    // Abstract sınıftaki zorunlu metodu burada dolduruyoruz
    public function login($username) {
        $this->username = $username;
        
        // Veritabanından kullanıcıyı bul (Senin orijinal kodun)
        try {
            $stmt = $this->db->prepare("SELECT id, username FROM users WHERE username = :user");
            $stmt->execute([':user' => $this->username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $this->id = $user['id'];
                return true; // Kullanıcı bulundu
            }
        } catch (PDOException $e) {
            // Hata olursa sessizce false dön
            return false;
        }
        
        return false; // Kullanıcı bulunamadı
    }

    // Kullanıcı Adını Getiren Metot
    public function getUsername() {
        return htmlspecialchars($this->username);
    }
    
    // ID Getiren Metot (Encapsulation örneği için)
    public function getId() {
        return $this->id;
    }
}
?>