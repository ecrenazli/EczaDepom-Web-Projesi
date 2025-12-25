/* =========================================
   1. TEKNİK ÖZELLİKLER (OOP, Fetch, LocalStorage)
   ========================================= */

// OOP: Class ve Extends (Kriter 85, 86)
class TemelBildirim {
    constructor() { this.indexKey = "sonOkunanBilgi"; }
    gosterKutu(mesaj) {
        let bilgiKutusu = document.createElement("div");
        bilgiKutusu.style = "position:fixed; bottom:20px; right:20px; background:#2ecc71; color:white; padding:15px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.2); z-index:9999; max-width:300px; font-size:0.9rem;";
        bilgiKutusu.innerHTML = `<strong>💡 Günün Bilgisi:</strong><br>${mesaj}<br><button onclick="this.parentElement.remove()" style="background:none; border:none; color:white; font-size:0.8rem; margin-top:5px; text-decoration:underline; cursor:pointer;">Kapat</button>`;
        document.body.appendChild(bilgiKutusu);
    }
}

class BildirimYoneticisi extends TemelBildirim {
    veriyiIsle() {
        try {
            let sonBilgiIndex = localStorage.getItem(this.indexKey) || 0;
            fetch('js/bilgiler.json')
                .then(r => r.ok ? r.json() : null)
                .then(data => {
                    if(data) {
                        this.gosterKutu(data[sonBilgiIndex % data.length].bilgi);
                        localStorage.setItem(this.indexKey, parseInt(sonBilgiIndex) + 1);
                    }
                });
        } catch (e) { console.error("Hata:", e); }
    }
}

// --- GÜNLÜK İLAÇ TAKİP (Array Push/Pop - Kriter 74) ---
let gunlukIlaclar = ["Sabah: Aspirin", "Öğle: Vitamin C"]; 

function listeyiGuncelle() {
    let el = document.getElementById("takipListesi");
    if(el) {
        el.innerHTML = "";
        gunlukIlaclar.map(ilac => {
            el.innerHTML += `<li style="border-bottom:1px dashed #eee; padding:5px 0;">💊 ${ilac}</li>`;
        });
    }
}

// HTML'deki onclick="ilacEkle()" burayı çalıştırır
function ilacEkle() {
    let input = document.getElementById("ilacInput"); // HTML'deki ID ile aynı
    if (input && input.value.trim() !== "") {
        let saat = new Date().toLocaleTimeString('tr-TR', {hour: '2-digit', minute:'2-digit'});
        gunlukIlaclar.push(`${saat} - ${input.value}`);
        input.value = "";
        listeyiGuncelle();
    }
}

function sonuncuyuGeriAl() {
    if (gunlukIlaclar.length > 0) {
        gunlukIlaclar.pop();
        listeyiGuncelle();
    } else {
        Swal.fire("Liste zaten boş!");
    }
}

// --- KONUM BULMA (Geolocation - Kriter 55) ---
function konumBul() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (pos) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Konum Bulundu!',
                    html: `<strong>Enlem:</strong> ${pos.coords.latitude}<br><strong>Boylam:</strong> ${pos.coords.longitude}`,
                    confirmButtonColor: '#3498db'
                });
            },
            (err) => {
                Swal.fire({icon: 'error', title: 'Hata', text: 'Konum alınamadı veya izin verilmedi.'});
            }
        );
    } else { 
        alert("Tarayıcı desteklemiyor."); 
    }
}

// --- COOKIE SİLME (Kriter 54) ---
function cerezleriSil() {
    document.cookie = "son_ziyaret=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    document.cookie = "ziyaret=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    location.reload();
}

// --- SİLME ONAYI ---
function silmeOnayi(id) {
    Swal.fire({
        title: 'Emin misiniz?',
        text: "Bu ilacı silmek istediğinize emin misiniz?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Evet, sil!',
        cancelButtonText: 'Hayır, vazgeç'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'ilac_sil.php?id=' + id;
        }
    })
}

// --- SAYFA YÜKLENİNCE ÇALIŞACAKLAR ---
document.addEventListener("DOMContentLoaded", function() {
    
    // Drag & Drop
    const dropArea = document.getElementById('drop-area');
    if(dropArea) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, (e) => { e.preventDefault(); e.stopPropagation(); }, false);
        });
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => dropArea.classList.add('highlight'), false);
        });
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => dropArea.classList.remove('highlight'), false);
        });
        dropArea.addEventListener('drop', (e) => {
            Swal.fire({ icon: 'success', title: 'Dosya Alındı!', text: 'Reçete görseli yüklendi (Simülasyon).' });
        });
    }

    // Web Worker
    if (window.Worker) {
        try { const w = new Worker("js/worker.js"); w.onmessage = e => console.log("Worker: " + e.data); } catch(e){}
    }

    // Listeyi Başlat
    listeyiGuncelle();
    
    // Bildirimi Başlat
    const bildirim = new BildirimYoneticisi();
    bildirim.veriyiIsle();

    // Silme Mesajı Kontrolü
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('mesaj') === 'silindi') {
        Swal.fire('Silindi!', 'İlaç başarıyla silindi.', 'success');
        window.history.replaceState(null, null, window.location.pathname);
    }
    
});