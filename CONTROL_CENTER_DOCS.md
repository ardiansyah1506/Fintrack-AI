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

> **Catatan:** Seluruh Endpoint API di-prefix dengan `/api/` dan membutuhkan/mengembalikan format `application/json`. Header wajib disertakan: `Accept: application/json` & `Content-Type: application/json`.

### A. Reminders (Pengingat Tugas & Chat)
* **Web UI Route**: `GET /reminders`
* **API Endpoints**:
  * `GET /api/reminders` (Daftar semua tasks)
  * `POST /api/reminders` (Membuat task baru)
  * `PUT /api/reminders/{id}` (Update status task)
  * `DELETE /api/reminders/{id}` (Hapus task)

**Contoh Parameter Payload JSON Request (POST/PUT):**
```json
{
  "title": "Membayar cicilan asuransi motor",
  "description": "Auto debit dari rekening utama BCA",
  "due_date": "2026-08-01",
  "due_time": "09:00:00",
  "repeat": "monthly", 
  "priority": "high",
  "status": "pending",
  "telegram_notification": true
}
```
*(Catatan Enum: `repeat` = none, daily, weekly, monthly, yearly. `priority` = low, medium, high. `status` = pending, done, cancelled).*

### B. Recurring Bills (Tagihan Rutin)
* **Web UI Route**: `GET /bills`
* **API Endpoints**:
  * `GET /api/bills` (Ambil data tagihan rutinan)

**Contoh Response JSON (GET):**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Langganan N8n Cloud",
      "category": "Software",
      "amount": 350000.00,
      "billing_date": 25,
      "repeat": "monthly",
      "auto_create_transaction": true,
      "reminder_before": 3,
      "status": "active"
    }
  ]
}
```

### C. Budget Monitoring (Pagu Anggaran)
* **Web UI Route**: `GET /budgets`
* **API Endpoints**:
  * `GET /api/budget/summary` (Mengalkulasi progres transaksi terhadap pagu)

**Contoh Response JSON (GET):**
```json
{
  "data": [
    {
       "id": 1,
       "category": "Makanan",
       "amount": 2000000.00,
       "spent": 1500000.00,
       "remaining": 500000.00,
       "percentage": 75,
       "status_color": "yellow"
    }
  ]
}
```

### D. Saving Goals (Target Tabungan)
* **Web UI Route**: `GET /saving-goals`
* **API Endpoints**:
  * `GET /api/saving-goals` 

**Contoh Response JSON (GET):**
```json
{
  "data": [
    {
      "id": 1,
      "title": "Beli MacBook Pro M4",
      "target_amount": 35000000.00,
      "current_amount": 10000000.00,
      "deadline": "2026-12-31",
      "icon": "fa-solid fa-laptop",
      "status": "active"
    }
  ]
}
```

### E. AI Insights (Analisis Cerdas)
* **Web UI Route**: `GET /ai-insights`
* **API Endpoints**:
  * `GET /api/insights`
* **Cara kerja**: Saat _event scheduler_ jalan di N8n memanggil AI Gemini, N8N akan mem-_push_ hasilnya (via webhook kita atau DB injection) ke tabel ini, lalu Control Center Laravel menampilkannya.

**Contoh Response JSON (GET):**
```json
{
  "data": [
    {
      "id": 5,
      "title": "Lonjakan Pengeluaran Hiburan",
      "period": "Minggu 3 Juli 2026",
      "content": "Analisis AI menunjukkan anomali pengeluaran hiburan...",
      "generated_at": "2026-07-31T09:00:00.000000Z",
      "type": "weekly"
    }
  ]
}
```

### F. Notifications (Pusat Pemberitahuan)
* **Web UI Route**: `GET /notifications`
* **API Endpoints**:
  * `GET /api/notifications`

**Contoh Response JSON (GET):**
```json
{
  "data": [
    {
      "id": 9,
      "title": "Transaksi Berhasil Dicatat Bot",
      "message": "Transaksi 50.000 kategori Transport berhasil dibuat",
      "type": "success",
      "read_at": null,
      "created_at": "2026-07-31T08:00:00.000000Z"
    }
  ]
}
```

### G. Telegram Sync & Webhook (N8N Unified API)
Satu-satunya endpoint webhook terpadu untuk mengeksekusi segala jenis intent *Natural Language* dari chat Telegram yang telah di-_parse_ oleh AI n8n.
* **API Endpoints**:
  * `POST /api/bot/execute` (Webhook N8N intent-handler utama).

**Contoh 1: Payload `create_transaction`**
```json
{
  "intent": "create_transaction",
  "amount": 25000,
  "category": "Makan Siang",
  "description": "Nasi uduk depan kampus",
  "type": "expense",
  "date": "2026-07-31"
}
```

**Contoh 2: Payload `create_reminder`**
```json
{
  "intent": "create_reminder",
  "title": "Bayar cicilan motor",
  "due_date": "2026-08-01",
  "due_time": "09:00",
  "priority": "high",
  "status": "pending"
}
```

**Contoh 3: Payload `create_bill`**
```json
{
  "intent": "create_bill",
  "name": "Netflix Premium",
  "category": "Hiburan",
  "amount": 185000,
  "repeat": "monthly"
}
```

**Contoh 4: Payload `create_budget`**
```json
{
  "intent": "create_budget",
  "category": "Makanan",
  "amount": 2000000
}
```

**Contoh 5: Payload `create_saving_goal`**
```json
{
  "intent": "create_saving_goal",
  "title": "Liburan Jepang",
  "target_amount": 20000000,
  "deadline": "2027-12-31"
}
```

* **API Endpoints**:
  * `GET /api/telegram/status` (Mendapatkan indikator bot real-time).

**Contoh Response JSON (GET):**
```json
{
  "bot_status": "online",
  "last_sync": "2026-07-31 16:30:00",
  "last_message": "Tolong catat pengeluaran makan 50k",
  "webhook_status": "active",
  "workflow_status": "listening",
  "connection_status": "connected"
}
```

---

## 🛠️ 3. Daftar Fitur Lama (Masih Dipertahankan)
1. **Transactions CRUD** (`POST /api/transactions` menggunakan body JSON standard `{ "amount": ..., "category": "String", "type": "income/expense" }`).
2. **Dashboard Overview** (`GET /` & API `GET /api/dashboard`).
3. **Kategori Master** (`GET /categories`).
4. **Laporan Keuangan** (`GET /reports`).
