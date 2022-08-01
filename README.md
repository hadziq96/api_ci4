# api_ci4
Contoh Server Api menggunakan CodeIgniter 4

# instalasi
Pertama download CodeIgniter 4, saya menggunakan versi 4.2.1
setelah itu, gantikan folder isi folder app dengan repo ini. selesai.

# tambahan
Bagian yang saya tambahkan dan ubah dalam folder app.
### 1. Filters/Options.php
Fungsinya untuk agar bisa diakses server lain
### 2. Config/Filters.php
Mendaftarkan filters tadi
### 3. Config/Routes.php
Menambahkan routes : get_data , insert_data, not_found (ketika user mengakses selain routes yang sudah didaftarkan)
### 4. Controllers/Test_api
Berisi 4 fungsi seperti routes ditambah satu fungsi private untuk validasi insert
