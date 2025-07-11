# 📦 Aplikasi Manajemen Stok Produk 

## 📌 Deskripsi Proyek

Aplikasi ini adalah sistem **Manajemen Stok Produk** yang dikembangkan menggunakan **Laravel** dengan pendekatan **Domain-Driven Design (DDD)**, **Clean Architecture**, dan pola **Hexagonal Architecture**. Proyek ini bertujuan untuk mengelola proses distribusi produk mulai dari pencatatan master data hingga proses transfer stok dan mutasi.

---

## 🧩 Fitur Utama

### ✅ Master Data
- 📁 Kategori Produk
- ⚖️ Satuan Produk
- 📦 Produk
- 🏢 Suplier
- 🔄 Jenis Mutasi
- 🏪 Lokasi
- 🛡 Role & Permissions

### 🔄 Transaksi & Mutasi
- 🔁 Transfer Produk:
  - Transfer Masuk ✅ *(Selesai)*
  - Transfer Keluar ✅ *(Selesai)*
- 📥 Pengadaan Produk *(Hanya Struktur DB)*
- 💰 Transaksi Produk *(Hanya Struktur DB)*
- 🔢 Serial Produk
- 📌 Mutasi Produk
- 📚 History Mutasi berdasarkan:
  - Produk
  - User

---

## 🔐 Autentikasi & Role Akses

Autentikasi berbasis Laravel Sanctum dengan sistem **Role-Based Access Control (RBAC)**. Setiap user mendapatkan hak akses berdasarkan **permission** yang didaftarkan ke rolenya.

### 👤 Data User Default:

| Email              | Password  | Akses                                                                 |
|--------------------|-----------|------------------------------------------------------------------------|
| `super@example.com`| `password`| Memiliki seluruh akses dan izin CRUD semua entitas                    |
| `user@example.com` | `password`| Dapat CRUD pada: `kategori_produk`, `lokasi`, `satuan_produk`, `jenis_mutasi` |

---

## 🧱 Arsitektur Proyek

Proyek ini mengadopsi pendekatan:
- ✅ **DDD (Domain-Driven Design)**
- ✅ **Clean Architecture**
- ✅ **Hexagonal (Ports & Adapters)**


## 🏗️ Teknologi yang Digunakan  

### 🔹 Backend  
- **Laravel 12** – Framework PHP untuk backend aplikasi  
- **PHP 8.4** – Bahasa pemrograman yang digunakan  
- **MySQL** – Database relasional untuk menyimpan data  
- **JWT Authentication** – Sistem keamanan berbasis token untuk autentikasi pengguna  



## 🛠 Langkah Instalasi Laravel

Pertama, clone repositori ini ke mesin lokal Anda.

### 1️⃣ Clone Repository
```bash
git clone https://github.com/tajillahibnu/id_grow.git
cd id_grow
```

### 🚀 Metode 1: Menjalankan dengan Docker

## 🛠 Langkah Instalasi Docker

### 1️⃣ Build dan Jalankan Layanan dengan Docker Compose
Masuk ke folder **`docker_app/`** dan jalankan perintah berikut untuk membangun dan menjalankan aplikasi menggunakan Docker Compose:
```
cd docker_app
docker-compose up --build
```
### 2️⃣ Masuk ke terminal container
Setelah container berjalan, masuk ke terminal aplikasi dengan perintah berikut:
```
docker exec -it laravelapp sh
```
### 3️⃣ Install Laravel
Jika pertama kali menjalankan container, Anda perlu menginstal Laravel di dalam container:
```
composer install
```
### 4️⃣ Akses Aplikasi
Akses aplikasi di browser dengan URL berikut:
```
http://localhost:8080
```
### 🧹 Menghentikan Layanan
Untuk menghentikan aplikasi dan membersihkan semua container yang sedang berjalan:
```
docker-compose down
```
Jika Anda ingin menghentikan aplikasi tanpa menghapus container, Anda bisa menggunakan:
```
docker-compose stop
```
### 🚀 Metode 2: Menjalankan Tanpa Docker (Local Development)

### 1️⃣ Salin File .env
Salin file .env.example menjadi .env:
```
cp .env.example .env
```
### 2️⃣ Install Dependensi
Install dependensi dengan Composer:
```
composer install
```
### 3️⃣ Generate Key Aplikasi
Generate key aplikasi dengan perintah:
```
php artisan key:generate
```
### 4️⃣ Konfigurasi Database
Buka file .env dan sesuaikan konfigurasi database. Jika menggunakan Docker, ganti DB_HOST=127.0.0.1 menjadi DB_HOST=database (sesuai dengan nama service di Docker Compose):
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1  # Ganti dengan 'database' jika menggunakan Docker
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```
### 5️⃣ Menjalankan Migrasi dan Seeder
Jalankan migrasi dan seeder untuk mengisi database:
```
php artisan migrate --seed
```
### 6️⃣ Jalankan Server
Jika Anda ingin menjalankan aplikasi di local server, gunakan:
```
php artisan serve
```

## 🔗 Dokumentasi API - Postman Collection

Anda dapat mengakses **Postman Collection** untuk API aplikasi ini di link berikut:

[**Postman Collection**](https://www.postman.com/spacecraft-astronomer-92425175/workspace/id-grow/collection/27822651-a7403ec5-d66d-4105-add5-c82275ba2dd4?action=share&source=copy-link&creator=27822651)

Untuk menggunakan Postman Collection, ikuti langkah-langkah berikut:

1. Klik link di atas untuk mengunduh atau mengimpor collection.
2. Impor collection ke dalam aplikasi Postman Anda.
3. Gunakan endpoint yang disediakan di collection untuk menguji API aplikasi ini.


## 📂 Struktur Proyek
Berikut adalah struktur proyek:
```
project-root/
├── app/                                     
│   ├── Domain/                               
│   │   ├── Product/                          
│   │   │   ├── Entities/                     
│   │   │   ├── Repositories/                 
│   │   │   └── Services/                     
│   │   └── Shared/                           
│   ├── Application/                          
│   │   ├── DTOs/                             
│   │   └── UseCase/                          
│   └── Infrastructure/                       
│       ├── Providers/                        
│       ├── Services/                         
│       ├── Persistence/                      
│       │   ├── Eloquent/                     
│       │   └── Model/                        
│       └── Http/                             
│           ├── Controllers/                  
│           │   └── Api/                      
│           ├── Middleware/                   
│           └── Requests/                     
├── config/                                   
├── database/                                 
│   ├── migrations/                           
│   └── seeds/                                
├── public/                                   
├── resources/                                
│   ├── views/                                
│   └── lang/                                 
├── routes/                                   
│   ├── web.php                               
│   └── api.php    
├── docker_app/                                   
│   ├── docker-compose.yml                             
│   └── Dockerfile                            
```