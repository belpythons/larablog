# Larablog // Jembatan Bahasa Bayi Laravel

Blog statis (Flat-file) yang didesain khusus sebagai panduan ramah pemula sebelum menyentuh dokumentasi resmi Laravel 10-13. Tidak ada database, tidak ada admin panel yang membingungkan. Murni Markdown dan kode.

## 🚀 Key Features

- **Neo-Brutalist UI Design**: Desain kontras tinggi yang fokus pada konten dan tipografi.
- **No Database & No Admin Panel**: Konten sepenuhnya bersumber dari file Markdown (Flat-file architecture).
- **7 Fase Pembelajaran Terstruktur**: Panduan belajar Laravel langkah demi langkah.
- **Integrasi Resmi**: Terdapat direct link ke Official Laravel Docs di setiap materi.

## 📝 How to Add Content

Untuk menambahkan artikel baru, cukup buat file ber-ekstensi `.md` di dalam direktori `resources/posts/`.

Berikut adalah contoh format **Front Matter** yang harus ada di awal file markdown:

```yaml
---
title: "Mengenal Routing di Laravel"
description: "Pahami cara kerja routing di Laravel dengan bahasa yang sangat sederhana layaknya jalan tol untuk website kamu."
laravel_version: "10-11"
official_docs_url: "https://laravel.com/docs/routing"
fase: 1
urutan: 1
---

# Konten Artikel Anda di sini
Tuliskan materi belajar menggunakan sintaks Markdown biasa...
```

## 🛠 Tech Stack

- **Laravel 12**
- **Tailwind CSS** (Neo-Brutalist configuration)
- **Lucide Icons**
- **Spatie Yaml Front Matter** (Markdown parser)

## 📦 Installation & Setup

1. **Clone repository**
   ```bash
   git clone <repository-url>
   cd larablog
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Build Assets & Serve**
   ```bash
   npm run build
   php artisan serve
   ```

## 🤝 Contributing

Silakan buat Pull Request jika Anda ingin menambahkan materi belajar baru di folder `resources/posts/`. Pastikan mengikuti format Front Matter yang telah ditentukan.

## 📝 License

Proyek ini bersifat open-source dengan lisensi [MIT license](https://opensource.org/licenses/MIT).
