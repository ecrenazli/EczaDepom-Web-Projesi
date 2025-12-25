export default class AramaMotoru {
    constructor() {
        this.veriSeti = [];
    }

    async verileriYukle() {
        try {
            // ./data/ diyerek ana klasöre çıkıp data'ya giriyoruz
            const cevap = await fetch('./data/tum_ilaclar.json');
            
            if (!cevap.ok) throw new Error("Dosya bulunamadı!");

            this.veriSeti = await cevap.json();
            console.log("✅ JSON Verisi Hafızaya Alındı:", this.veriSeti);
        } catch (hata) {
            console.error("❌ Veri Çekme Hatası:", hata);
            alert("Veri seti yüklenemedi! Console'a bak.");
        }
    }

    ilacAra(kelime) {
        if (!kelime) return [];
        kelime = kelime.toLowerCase();
        return this.veriSeti.filter(ilac => 
            ilac.ad.toLowerCase().includes(kelime) || 
            ilac.etken.toLowerCase().includes(kelime)
        );
    }
}