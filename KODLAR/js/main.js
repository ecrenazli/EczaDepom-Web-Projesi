import AramaMotoru from './AramaMotoru.js';

const motor = new AramaMotoru();
let secilenIlacGecici = null;
let islemModu = 'ekle'; // 'ekle' veya 'duzenle' olabilir

document.addEventListener('DOMContentLoaded', async () => {
    await motor.verileriYukle();
    
    // LocalStorage'dan son aramayı getir
    const sonArama = localStorage.getItem('sonArananKelime');
    if (sonArama) document.getElementById('aramaInput').value = sonArama;

    // Varsayılan tarih
    tarihSifirla();
});

function tarihSifirla() {
    const bugun = new Date();
    bugun.setFullYear(bugun.getFullYear() + 1);
    document.getElementById('tarihInput').valueAsDate = bugun;
}

// HTML Elemanları
const aramaKutusu = document.getElementById('aramaInput');
const sonucKutusu = document.getElementById('sonuclar');
const modal = document.getElementById('tarihModal');
const btnOnayla = document.getElementById('btnOnayla');
const btnIptal = document.getElementById('btnIptal');
const tarihInput = document.getElementById('tarihInput');
const konumInput = document.getElementById('konumInput');
const secilenIlacIsmi = document.getElementById('secilenIlacIsmi');
const duzenlenecekId = document.getElementById('duzenlenecekId');
const modalBaslik = document.getElementById('modalBaslik');

if (aramaKutusu) {
    // Arama İşlemleri
    aramaKutusu.addEventListener('input', (olay) => {
        const kelime = olay.target.value;
        localStorage.setItem('sonArananKelime', kelime);
        const sonuclar = motor.ilacAra(kelime);
        sonucKutusu.innerHTML = '';

        if (kelime.length > 0 && sonuclar.length > 0) {
            sonucKutusu.style.display = 'block';
            sonuclar.forEach(ilac => {
                const div = document.createElement('div');
                div.className = 'arama-sonuc-satiri';
                div.innerHTML = `<span><i class="fa-solid fa-capsules"></i> <strong>${ilac.ad}</strong> <small>(${ilac.etken})</small></span><span style="color:#27ae60; font-weight:bold;">+ SEÇ</span>`;
                
                div.addEventListener('click', () => {
                    // Ekleme Modunu Başlat
                    islemModu = 'ekle';
                    secilenIlacGecici = ilac;
                    modalBaslik.innerText = "➕ Yeni İlaç Ekle";
                    secilenIlacIsmi.innerText = ilac.ad;
                    tarihSifirla(); // Tarihi sıfırla
                    modal.style.display = 'flex';
                    sonucKutusu.style.display = 'none';
                });
                sonucKutusu.appendChild(div);
            });
        } else {
            sonucKutusu.style.display = 'none';
        }
    });

    // İptal Butonu
    btnIptal.addEventListener('click', () => { modal.style.display = 'none'; });

    // KAYDET BUTONU (Hem Ekleme Hem Güncelleme Yapar)
    btnOnayla.addEventListener('click', async () => {
        const tarih = tarihInput.value;
        const konum = konumInput.value;

        if (islemModu === 'ekle') {
            // --- EKLEME İŞLEMİ ---
            if (tarih && secilenIlacGecici) {
                const veri = { ad: secilenIlacGecici.ad, etken: secilenIlacGecici.etken, tarih: tarih, konum: konum };
                veriyiGonder('ilac_ekle.php', veri, "İlaç eklendi!");
            }
        } else if (islemModu === 'duzenle') {
            // --- GÜNCELLEME İŞLEMİ ---
            const id = duzenlenecekId.value;
            if (id && tarih) {
                const veri = { id: id, tarih: tarih, konum: konum };
                veriyiGonder('ilac_guncelle.php', veri, "İlaç güncellendi!");
            }
        }
    });

    // Veri Gönderme Fonksiyonu (Fetch API)
    async function veriyiGonder(url, veri, mesaj) {
        try {
            const cevap = await fetch(url, {
                method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(veri)
            });
            const sonuc = await cevap.json();
            if (sonuc.durum === "basarili") {
                // alert(mesaj); // İstersen açabilirsin
                location.reload();
            } else {
                alert("Hata: " + sonuc.mesaj);
            }
        } catch (hata) { console.error(hata); }
    }
    
    // Dışarıdan Tıklama
    document.addEventListener('click', (e) => {
        if (!aramaKutusu.contains(e.target) && !sonucKutusu.contains(e.target)) {
            sonucKutusu.style.display = 'none';
        }
    });
}

// Global Fonksiyon: PHP'den "Düzenle" butonuna basılınca bu çalışır
window.duzenleModalAc = function(ilacVerisi) {
    islemModu = 'duzenle';
    modalBaslik.innerText = "✏️ İlacı Düzenle";
    secilenIlacIsmi.innerText = ilacVerisi.ilac_adi;
    
    // Mevcut bilgileri kutulara doldur
    duzenlenecekId.value = ilacVerisi.id;
    tarihInput.value = ilacVerisi.son_kullanma_tarihi;
    konumInput.value = ilacVerisi.kutu_konumu; // Eski konumu seç

    modal.style.display = 'flex';
};