# Web Gis
Assalamualaikum Warohmatullohi Wabaroktuh

Halo, aplikasi ini adalah implementasi dari soal lomba LSK Web design 2018, dengan studi kasus Informasi Keberangkatan Bus dan Kereta Api, jadi pengguna bisa melihat jadwal kebrangkatan bus dan kereta pada hari tersebut. Aplikasi terbagi menjadi 2 bagian, `Webservice` dan `Webclient`, Webservice bertindak sebagai server REST API, dan Webclient adalah Website yang memanfaatkan API yang disediakan oleh Webservice.

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

## Install :
1. Clone or Download Zip and Extract
2. Copy folder `Webclient` dan `Webservice` kedalam folder HTDOCS
3. Buat database dengan nama `webservice` dan export database `webservice.sql`
4. Buka Command Line/Command Prompt, masuk ke folder Webservice yang ada di HTDOCS, kemudian jalankan server PHP lewat dengan mengetik `php -S localhost:8000 -t public`lalu tekan enter, **jangan diclose**.
5. Buka lagi Command Line/Command Prompt, masuk kefolder Webclient yang ada di HTDOCS, kemudian jalankan server PHP dengan mengetik `php -S localhost:8080 -t public`lalu tekan enter, **jangan diclose**.
6. Sekarang buka browser dan akses url `localhost:8080`
7. Selamat aplikasi berhasil diintall

## Penggunaan
Untuk menggunakan aplikasi kamu harus membuat schadule keberangkatan terlebih dahulu, dengan memanfaatkan aplikasi seperti POSTMAN atau INSOMNIA.

Untuk Menambahkan Scahadule :  
1. URl: POST - `localhost:8000/api/schedule?api_token=cab2384fe07bded068d9b0804423387c`
2. Example Param : 
	- type : bus
	- line : 1
	- from_place_id : 2
	- to_place_id : 3
	- departure_time : 12:00:00
	- arrival_time : 11:50:00
	- distance : 100 km
	- speed : 1 Jam

> Perlu diperhatikan bahwa departure time dan arrival time relatif terhadap waktu nyata saat kamu mengakses aplikasi ini, jadi silahkan isi waktu dengan jarak sedikit lebih jauh dari kamu sekarang.

1. Lakukan request dengan method post, url, dan param diatas.
2. Pastikan response code 201 atau created
3. Buka webclient dengan alamat `localhost:8080`
4. Lalu pada source location klik aceh dan padang, karena from place: 2 adalah id place aceh, dan to place: 3 adalah id place padang, kamu juga bisa menambahkan mulai dari waktu mana kebrangkatan yang ingin kamu lihat, contoh : `Aceh to Padang at 10:00:00`, artinya kamu ingin mencari route Aceh ke Padang yang waktu keberangkatannya mulai dari jam 10 keatas.
5. Jika sudah selesai klik get routes, maka akan menampilkan route-nya klik route maka akan menampilkan penanda pada peta, untuk keterangan penanda lihat legenda peta.

## Info Login Default
### Admin :
**No**|**Username**|**Password**
:----:|:----:|:----:
1|reza|reza

### User :
**No**|**Username**|**Password**
:----:|:----:|:----:
1|dian|dian