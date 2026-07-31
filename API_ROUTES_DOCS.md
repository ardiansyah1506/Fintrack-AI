# Dokumentasi Fitur & Routes FinTrack AI

Berikut adalah daftar seluruh fitur dan *routes* yang ada di dalam aplikasi **FinTrack AI**, beserta deskripsi dan parameternya berdasarkan struktur *backend* dan integrasi API yang berjalan:

### 1. 📊 Dashboard & Statistics
Fitur ini digunakan untuk menampilkan rangkuman data keuangan, _Key Performance Indicators_ (KPI) di halaman utama, serta data yang dibutuhkan untuk menggambar grafik statistik.
* **Web Route:**
  * `GET /` - Halaman tampilan UI untuk Dashboard pengguna. 
* **API Route:**
  * `GET /api/dashboard` - Mengambil *summary* KPI _(Total Balance, Income, Expense)_.
  * `GET /api/statistics` - Mengambil data statistik untuk keperluan _chart_.
* **Parameter:**
  * Secara default tidak wajib ada parameter. Namun, terkadang bisa disematkan parameter global seperti query `type`, `start_date`, dan `end_date` untuk menyesuaikan range kalkulasi waktu.

### 2. 🗂️ Manajemen Kategori (Category)
Fitur CRUD (_Create, Read, Update, Delete_) untuk mengelola data _master_ kategori, yang digunakan untuk mengelompokkan jenis transaksi Anda secara dinamis.
* **Web Route:** `GET | POST | PUT/PATCH | DELETE /categories`
* **API Route:** `GET | POST | PUT/PATCH | DELETE /api/categories`
* **Deskripsi Request:**
  * **(Read)** `GET /api/categories` -> **Parameter Query:** `?type=income` atau `?type=expense` (Untuk memfilter berdasarkan tipe arus kas).
  * **(Create/Update)** `POST` atau `PUT` -> **Parameter Payload (Body Request):**
     * `name` (string, wajib) - Nama untuk kategorinya.
     * `type` (string, wajib) - Tipe kategori (contoh valuenya: `'income'` atau `'expense'`).

### 3. 💸 Manajemen Transaksi (Transaction)
Fitur inti _FinTrack AI_ untuk melakukan pencatatan operasional keuangan baik pemasukan maupun pengeluaran.
* **Web Route:** `GET | POST | PUT/PATCH | DELETE /transactions`
* **API Route:** `GET | POST | PUT/PATCH | DELETE /api/transactions`
* **Deskripsi Request:**
  * **(Read)** `GET /api/transactions` -> Menampilkan daftar riwayat transaksi.
     * **Parameter Query Filter (Optional):** `type`, `category` (string), `start_date`, `end_date`, `min_amount`, `max_amount`, `per_page`.
  * **(Create/Update)** `POST` atau `PUT` -> **Parameter Payload (Body Request):**
     * `category` (string, wajib) - Nama kategori transaksi sebagai string *(catatan refactor: sebelumnya menggunakan foreign key `category_id`)*.
     * `type` (string, wajib) - Harus berisi `'income'` atau `'expense'`.
     * `amount` (numeric, wajib) - Nominal angka transaksi.
     * `date` (date, wajib) - Tanggal kejadian transaksinya.
     * `description` (string, opsional) - Catatan keterangan rinci.

### 4. 📈 Laporan Keuangan (Financial Report)
Fitur yang menyediakan rekapitulasi pelaporan transaksi yang telah diolah dari database sistem berdasarkan kategori kerangka waktu tertentu (harian/mingguan/bulanan).
* **Web Route:**
  * `GET /reports` - Halaman tampilan UI untuk pelaporan.
* **API Route:**
  * `GET /api/report/daily` - Laporan perhitungan harian.
  * `GET /api/report/weekly` - Laporan perhitungan mingguan.
  * `GET /api/report/monthly` - Laporan perhitungan bulanan.
* **Parameter Query (Opsional - berdasarkan jenis end point):**
  * `date` (contoh: *'2026-07-31'*)
  * `start_date` & `end_date` (Rentang mingguan / kustomisasi limit)
  * `year` & `month` (Spesifikasi untuk laporan filter bulanan)
  * `period`

### 5. 🤖 N8N / Telegram Bot Integration Target
Fitur khusus untuk interaksi via pesan, memungkinkan sistem AI dapat memproses percakapan _Natural Language (NL)_ menjadi data record input transaksi secara terstruktur.
* **API Route:**
  * `POST /api/bot/execute`
* **Deskripsi:** Endpoint _webhook_ yang khusus disediakan sebagai _Source of Truth_ perintah dari _workflow_ third-party seperti **N8N** atau Bot Telegram.
* **Parameter Payload (Body Request):**
  * `intent` (string, wajib) - Intensi pesan apakah `create_transaction` atau laporan *(sebagaimana input data yang divalidasi sistem controller Bot)*. 
  * Diikuti JSON parameter tambahan fleksibel lain yang di-extract dari natural language modelnya.

### 6. ⚙️ Pengaturan (Settings)
Fitur untuk pengaturan umum aplikasi atau konfigurasi dasar user interface.
* **Web Route:** `GET /settings`
* **Parameter:** *(Tidak memiliki parameter eksplisit, umumnya hanya mengakses halaman UI)*.
