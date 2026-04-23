---
title: "Mengenal Routing di Laravel"
description: "Pahami cara kerja routing di Laravel dengan bahasa yang sangat sederhana layaknya jalan tol untuk website kamu."
laravel_version: "10-11"
official_docs_url: "https://laravel.com/docs/routing"
fase: 1
urutan: 1
---

# Routing itu seperti Alamat Rumah

Bayangkan kamu sedang memesan pizza. Supaya kurir pizza tahu harus mengirim ke mana, kamu harus memberikan **alamat yang jelas**, kan?

Di Laravel, **Routing** adalah alamat tersebut. 

Ketika seseorang mengetik `www.websitekamu.com/tentang-kami` di browser, Laravel butuh "catatan alamat" untuk tahu halaman mana yang harus ditampilkan. Itulah fungsi utama file `routes/web.php`.

## Cara Membuat Route Sederhana

Buka file `routes/web.php`, dan tambahkan kode ini:

```php
Route::get('/halo', function () {
    return 'Halo Dunia!';
});
```

Jika kamu mengakses `/halo` di browser, akan muncul teks "Halo Dunia!". Sangat sederhana, bukan?

## Kenapa Ini Penting?

Tanpa Routing, Laravel tidak tahu harus merespon apa ketika ada permintaan dari pengguna. Routing adalah pintu masuk pertama untuk semua fitur di website kamu.
