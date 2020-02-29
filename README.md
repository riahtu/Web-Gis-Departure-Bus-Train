# Web Gis
Assalamualaikum Warohmatullohi Wabaroktuh

Halo, aplikasi ini adalah implementasi dari soal lomba LSK Web design 2018, dengan studi kasus Informasi Keberangkatan Bus dan Kereta Api. Aplikasi terbagi menjadi 2 bagian, `Webservice` dan `Webclient`, Webservice bertindak sebagai server REST API, dan Webclient adalah Website yang memanfaatkan API yang disediakan oleh Webservice.

## Apakah Aplikasi ini Gratis?
Aplikasi ini gratis untuk digunakan, dipelajari, dijadikan referensi atau dikembangkan, dan perlu diingat bahwa **APLIKASI INI TIDAK DIPERJUAL BELIKAN**, berbeda cerita jika aplikasi telah dikembangkan sedemikian rupa, sehingga sangat berbeda dengan yang sekarang, maka boleh-boleh saja untuk menjualnya, namun tetap menyertakan **SUMBER**.

## Apa Saja Fiturnya?
### Web Service :
1. Register
2. CRUD Place (admin)
3. CRUD Schedule (admin)
4. CRUD Route
5. 3 hak akses : Admin, User and Umum

### Web Client
1. Search Route With Ajax
2. View map and Keterangan foreach Place
3. History search For user login
4. CRUD Place (Admin)
5. 3 hak akses : Admin, User and Umum

## Teknologi Apa yang digunakan?
1. PHP7
2. MariaDB
3. LARAVEL
4. HTML5
5. CSS3
6. JAVASCRIPT
7. Bootstrap
8. Maphilight

## Petunjuk Install
### Localhost
Memerlukan :
1. XAMPP v7.2.0 ke-Atas

Install :
1. Clone or Download Zip and Extract
2. Copy folder `Webclient` dan `Webservice` kedalam folder HTDOCS
3. Buat database dengan nama `webservice` dan export database `webservice.sql`
4. Buka Command Line/Command Prompt, masuk ke folder Webservice yang ada di HTDOCS, kemudian jalankan server PHP lewat dengan mengetik `php -S localhost:8080 -t public`lalu tekan enter, **jangan diclose**.
5. Buka lagi Command Line/Command Prompt, masuk kefolder Webclient yang ada di HTDOCS, kemudian jalankan server PHP dengan mengetik `php -S localhost:8080 -t public`lalu tekan enter, **jangan diclose**.
6. Sekarang buka browser dan akses url `localhost:8080`
7. Selamat aplikasi berhasil diintall

## Info Login Default
### Admin :
----
**No**|**Username**|**Password**
:----:|:----:|:----:
1|reza|reza

### User :
----
**No**|**Username**|**Password**
:----:|:----:|:----:
1|dian|dian