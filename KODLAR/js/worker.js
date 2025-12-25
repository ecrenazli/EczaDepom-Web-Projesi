let sayac = 0;
setInterval(() => {
    sayac++;
    postMessage(sayac);
}, 10000); // Her 10 saniyede bir sayar