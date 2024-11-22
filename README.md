## Daftar Isi

- [Project Laravel Installation Guide](#project-laravel-installation-guide)
- [Miskonsepsi Mengenai Bahasa Pemrograman](#miskonsepsi-mengenai-bahasa-pemrograman-📚)

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Project Laravel Installation Guide

## Prerequisites

Before you begin, make sure you have the following installed:

- **Laragon** (or any other local development environment like XAMPP, WAMP, etc.)
- **Composer** (for PHP dependencies)
- **Node.js** and **NPM** (for frontend dependencies)

## Installation Steps

Follow these steps to set up the project locally:

### 1. Clone the Repository

Clone the project repository from Git:
```bash
git clone https://github.com/yourusername/your-laravel-project.git
```

Move into the project directory:
```bash
cd your-laravel-project
```

### 2. Install Composer Dependencies

Run the following command to install the necessary PHP dependencies:
```bash
composer install
```

### 3. Install NPM Dependencies

Run the following command to install the required Node.js packages:
```bash
npm install
```

### 4. Setup Environment File

Create a copy of the `.env.example` file and rename it to `.env`:
```bash
cp .env.example .env
```

Open the `.env` file and update the following database configuration (adjust as necessary for your environment):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate Application Key

Run the following command to generate the application key:
```bash
php artisan key:generate
```

### 6. Run Migrations

If the project requires database tables, run the migrations:
```bash
php artisan migrate
```

### 7. Compile Frontend Assets (Optional)

If the project requires you to compile frontend assets like CSS or JavaScript, run:
```bash
npm run dev
```
For real-time watching of changes:
```bash
npm run watch
```

### 8. Serve the Application

You can use the built-in Laravel development server:
```bash
php artisan serve
```
Alternatively, if you're using Laragon, it will automatically recognize the project and serve it on a local domain (e.g., `http://your-laravel-project.test`).

### 9. (Optional) Running on Laragon

If you're using Laragon, simply place the project in the `C:\laragon\www` directory, and Laragon will automatically detect and serve it. You can access the project at `http://your-laravel-project.test`.

## Troubleshooting

If you encounter any issues during installation, consider the following:

- Ensure the `.env` file is correctly set up.
- Make sure the database is created and properly configured.
- Check for any missing extensions in your PHP installation (such as `ext-mbstring`, `ext-xml`, etc.).

## License

This project is open-source and available under the [MIT License](LICENSE).

# MISKONSEPSI MENGENAI BAHASA PEMROGRAMAN 📚

## Pendahuluan
Dalam dunia teknologi yang terus berkembang, platform dan bahasa pemrograman seperti Flutter, PHP, dan Laravel sering menjadi pilihan utama bagi para pengembang. Namun, bersama dengan popularitasnya, muncul berbagai miskonsepsi atau kesalahpahaman yang dapat memengaruhi persepsi dan penggunaan teknologi ini.

Miskonsepsi sering kali muncul karena kurangnya pemahaman yang mendalam, perubahan teknologi yang cepat, atau pengalaman terbatas dengan alat dan bahasa tersebut. Beberapa pengembang mungkin mendasarkan pandangan mereka pada tren masa lalu, tanpa mempertimbangkan pembaruan dan inovasi yang telah terjadi. Hal ini dapat mengarah pada keputusan yang kurang tepat, seperti menghindari alat atau framework yang sebenarnya sangat relevan dan bermanfaat.

Flutter, sebagai framework UI lintas platform, sering disalahpahami sebagai alat yang hanya cocok untuk pengembangan aplikasi mobile kecil. Padahal, Flutter telah berkembang menjadi solusi serbaguna untuk berbagai platform, termasuk web dan desktop. Di sisi lain, PHP yang sudah lama digunakan sering dianggap usang dan tidak relevan, meskipun masih menjadi tulang punggung sebagian besar aplikasi web modern. Laravel, framework PHP yang populer, juga menghadapi stigma sebagai alat untuk proyek skala kecil, meskipun memiliki kemampuan untuk mendukung aplikasi berskala besar.

Miskonsepsi ini, jika dibiarkan, dapat menghalangi pengembang untuk memanfaatkan teknologi ini dengan maksimal. Oleh karena itu, penting untuk memahami fakta sebenarnya di balik Flutter, PHP, dan Laravel, sehingga pengembang dapat membuat keputusan yang lebih informasional dan strategis dalam proyek mereka. Artikel ini bertujuan untuk meluruskan beberapa kesalahpahaman umum dan memberikan pandangan yang lebih akurat tentang kemampuan dan penggunaan teknologi tersebut.

## Flutter Miskonsepsi 🚀
1. **Flutter Hanya untuk Aplikasi Mobile** Banyak orang percaya bahwa Flutter hanya dirancang untuk aplikasi mobile. Namun, Flutter kini mendukung pengembangan lintas platform, termasuk aplikasi desktop (Windows, macOS, Linux) dan web. Dengan fitur-fitur seperti *adaptive layouts* dan dukungan untuk berbagai platform, Flutter memungkinkan pengembang menggunakan satu basis kode untuk berbagai perangkat. Dukungan Flutter untuk pengembangan lintas platform menjadikannya alat yang fleksibel untuk berbagai jenis proyek.
2. **Flutter Tidak Memerlukan Pengetahuan Native** Salah satu kesalahpahaman adalah bahwa menggunakan Flutter menghilangkan kebutuhan untuk memahami pengembangan native Android atau iOS. Meskipun Flutter mempermudah pengembangan lintas platform, ada situasi di mana pengembang perlu mengintegrasikan *plugins* atau memanfaatkan fitur platform spesifik, seperti pemrosesan latar belakang atau integrasi layanan pihak ketiga. Dalam kasus seperti ini, pengetahuan tentang pengembangan native sangat membantu.
3. **Flutter Tidak Optimal untuk Proyek Skala Besar** Ada anggapan bahwa Flutter hanya cocok untuk proyek kecil atau menengah. Ini salah besar, karena Flutter memiliki ekosistem yang kuat dan mendukung *state management* yang kompleks seperti Bloc atau Riverpod, yang dirancang untuk menangani aplikasi besar. Flutter juga memungkinkan pengelolaan dependensi dan modularisasi yang mempermudah kolaborasi dalam tim besar.
4. **Flutter Tidak Mendukung SEO** Sementara Flutter menghadapi tantangan dalam SEO untuk aplikasi web, pengembang dapat mengoptimalkan ini dengan menggunakan Progressive Web Apps (PWA) atau integrasi server-side rendering (SSR). Flutter Web memungkinkan pengembangan aplikasi web yang responsif, meskipun tidak dirancang untuk aplikasi yang bergantung sepenuhnya pada SEO.
5. **Flutter Lambat Dibanding Native** Banyak yang mengira bahwa performa Flutter lebih lambat karena berbasis *framework*. Faktanya, Flutter menggunakan mesin rendering *Skia* yang berjalan langsung di atas perangkat keras, memungkinkan performa yang sangat mendekati aplikasi native. Hal ini terbukti pada aplikasi yang memerlukan animasi intensif, di mana Flutter mampu memberikan pengalaman pengguna yang lancar.

## PHP Misconceptions 🐘
1. **PHP Sudah Usang dan Tidak Relevan Lagi** Ada anggapan bahwa PHP merupakan bahasa usang yang tidak sesuai dengan standar modern. Namun, PHP terus diperbarui dengan fitur-fitur canggih seperti *typed properties* dan *just-in-time (JIT) compilation* di versi terbaru, yang meningkatkan kecepatan eksekusi dan efisiensi. PHP juga menjadi tulang punggung banyak aplikasi populer seperti WordPress dan Facebook.
2. **PHP Tidak Aman untuk Aplikasi Web** PHP sering disalahkan atas kerentanan keamanan, padahal ini lebih disebabkan oleh implementasi pengembang yang buruk. PHP menyediakan alat bawaan untuk keamanan, seperti *prepared statements* untuk melindungi dari serangan SQL injection, dan fungsi bawaan untuk *password hashing*. Dengan mengikuti praktik terbaik, pengembang dapat membangun aplikasi yang sangat aman menggunakan PHP.
3. **PHP Tidak Mendukung Pemrograman Berorientasi Objek** Beberapa orang menganggap PHP hanya cocok untuk pengembangan procedural. Kenyataannya, PHP telah mendukung pemrograman berorientasi objek (OOP) sejak versi 5. Dengan fitur seperti pewarisan (*inheritance*), antarmuka (*interfaces*), dan *traits*, PHP mampu mendukung arsitektur yang kompleks, layaknya bahasa OOP modern lainnya.

## Laravel Misconceptions 🌐
1. **Laravel Hanya untuk Proyek Skala Kecil** Laravel sering dianggap hanya cocok untuk proyek kecil karena kemudahan penggunaannya. Padahal, framework ini dirancang untuk menangani proyek skala besar dengan fitur seperti sistem antrian (*queueing system*) untuk pengelolaan proses latar belakang, caching untuk performa, dan dukungan mikroservis. Banyak aplikasi besar menggunakan Laravel karena fleksibilitasnya dalam arsitektur aplikasi yang kompleks.
2. **Laravel Lambat Dibanding Framework Lain** Kritik terhadap Laravel sering menyebut bahwa framework ini lambat dibandingkan framework PHP lainnya. Namun, Laravel fokus pada produktivitas pengembang dengan menyediakan fitur bawaan seperti *cache*, *queue*, dan *event broadcasting* untuk mengurangi waktu eksekusi proses yang berat. Dengan optimasi yang tepat, seperti memanfaatkan *OpCache* dan *caching layer*, Laravel dapat memberikan performa yang setara atau lebih baik dibanding framework lainnya.

## Referensi Miskonsepsi
https://flutter.dev/multi-platform/desktop

https://docs.flutter.dev/platform-integration/desktop

https://docs.flutter.dev/platform-integration/web/faq

https://runcloud.io/blog/php-security-best-practices

https://www.php.net/manual/en/security.php

https://www.php.net/manual/en/security.intro.php

https://www.getastra.com/blog/cms/php-security/php-security-guide/