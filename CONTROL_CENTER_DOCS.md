# Dokumentasi API & Fitur FinTrack AI Control Center

Update ini mendokumentasikan keseluruhan fitur dan *routes* (Web & REST API) pada sistem **FinTrack AI** yang baru saja dirombak menjadi **Control Center** untuk sinkronisasi otomatis dengan AI Telegram Assistant (via n8n).

---

## 🏗️ 1. Arsitektur & Teknologi

* **Frontend Dashboard/UI**: Laravel Blade, Tailwind CSS (CDN), Alpine.js (CDN), Chart.js (CDN).
* **Backend Source of Truth**: Laravel 12 (Service Pattern + Form Request Validation).
* **AI Orchestrator Target**: N8N Automation & webhook Telegram Bot.

Semua pengolahan logic AI (pengingat jatuh tempo, generasi *insight*, parsing struk dari chat telegram) dieksekusi di ranah **n8n**. Laravel hanya menyediakan API JSON dan UI Control Center berbasis Web untuk memonitor data.

---

## 🗂️ 2. Daftar Modul & Endpoint API Baru

> **Catatan:** Seluruh Endpoint API di-prefix dengan `/api/` dan mengembalikan / menerima format `application/json`.

### A. Reminders (Pengingat Tugas & Chat)
* **Web UI Route**: `GET /reminders`
* **API Endpoints**:
  * `GET /api/reminders` (Daftar semua tasks)
  * `POST /api/reminders` (Membuat task baru)
  * `PUT /api/reminders/{id}` (Update status)
  * `DELETE /api/reminders/{id}` (Hapus task)
* **Parameter Payload (POST/PUT)**:
  * `title` (string)
  * `due_date` (date: YYYY-MM-DD)
  * `priority` (enum: low, medium, high)
  * `status` (enum: pending, done, cancelled)

### B. Recurring Bills (Tagihan Rutin)
* **Web UI Route**: `GET /bills`
* **API Endpoints**:
  * `GET /api/bills` (Ambil data tagihan aktif/jatuh tempo)
* **Parameter JSON Response**:
  * `name`, `category`, `amount`, `billing_date` (1-31), `repeat` (monthly, yearly).

### C. Budget Monitoring (Pagu Anggaran)
* **Web UI Route**: `GET /budgets`
* **API Endpoints**:
  * `GET /api/budget/summary` (Otomatis menghitung total transaksi di kategori tersebut vs batas pagu bulanan)
* **Parameter JSON Response**:
  * Menghasilkan array: `category`, `amount`, `spent`, `remaining`, `percentage`, `status_color`.

### D. Saving Goals (Target Tabungan)
* **Web UI Route**: `GET /saving-goals`
* **API Endpoints**:
  * `GET /api/saving-goals` (Menampilkan daftar impian dan tabungan masa depan, beserta margin presentase).

### E. AI Insights (Analisis Cerdas)
* **Web UI Route**: `GET /ai-insights`
* **API Endpoints**:
  * `GET /api/insights`
* **Cara kerja**: Saat _event scheduler_ jalan di N8n memanggil AI Gemini, N8N akan mem-_push_ hasilnya (via webhook kita atau DB injection) ke tabel ini, lalu Control Center Laravel menampilkannya.

### F. Notifications (Pusat Pemberitahuan)
* **Web UI Route**: `GET /notifications`
* **API Endpoints**:
  * `GET /api/notifications`
* **Cara kerja**: Menampung pemberitahuan dari Telegram "Bot sudah melakukan sinkronisasi X" untuk keperluan pantauan web master.

### G. Telegram Sync & Webhook
* **Web UI Route**: `GET /telegram` (Panel Web UI untuk lihat status bot).
* **API Endpoints**:
  * `POST /api/bot/execute` (Webhook lama. Intensi AI parser bot).
  * `GET /api/telegram/status` (Mendapatkan konfigurasi dummy real-time engine).

---

## 🛠️ 3. Daftar Fitur Lama (Masih Dipertahankan)

Tidak ada satupun fitur atau endpoints terdahulu yang kami hilangkan, sehingga tidak mengganggu fungsionalitas n8n bot yang sudah berjalan:
1. **Transactions CRUD** (`GET/POST/PUT/DELETE /api/transactions` & web `/transactions`). Pengecualian pada struktur database terbaru yang kini fieldnya `category` berbentuk string utuh (bukan *id* foreign key).
2. **Dashboard Overview** (`GET /` & API `GET /api/dashboard`).
3. **Kategori & Laporan Keuangan** (`GET /reports`).

---

## 🎨 4. Penyesuaian UX/UI
Dashboard dan Menu Navigasi disulap menggunakan palet model `Emerald, Slate, White` untuk mencapai impresi desain yang modern, minimalis, dan futuristik; sesuai standar AI tools modern. Setiap Modul Web telah dilengkapi dengan:
- **Card grid layout** dengan radius besar (3xl) dan sentuhan _subtle shadow_.
- **Sidebar Khusus** untuk bernavigasi ke ke-6 layout Control Center.
- **Badge Indikasi "Active/Listening"** guna menegaskan kontrol terintegrasi.
