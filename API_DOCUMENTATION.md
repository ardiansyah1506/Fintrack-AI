# FinTrack AI - REST API & Telegram Bot Integration Documentation

Selamat datang di Dokumentasi Resmi REST API dan Integrasi Telegram Bot (n8n Engine) untuk **FinTrack AI**.

Dokumen ini menjelaskan spesifikasi lengkap endpoint REST API, format respon standar, serta skema payload Webhook yang digunakan untuk menghubungkan **n8n Automation Engine**, **Gemini AI**, dan **Telegram Bot** dengan Laravel sebagai *Single Source of Truth*.

---

## 📋 Daftar Isi
1. [Arsitektur Sistem & Alur Bisnis](#1-arsitektur-sistem--alur-bisnis)
2. [Base URL & Standard Response](#2-base-url--standard-response)
3. [Spesifikasi REST API Endpoint](#3-spesifikasi-rest-api-endpoint)
   - [Dashboard & Statistik](#dashboard--statistik)
   - [Manajemen Kategori](#manajemen-kategori)
   - [Manajemen Transaksi](#manajemen-transaksi)
   - [Laporan Keuangan](#laporan-keuangan)
4. [n8n Webhook & Telegram Bot Engine (`/api/bot/execute`)](#4-n8n-webhook--telegram-bot-engine-apibotexecute)
   - [Skema Request Webhook](#skema-request-webhook)
   - [Spesifikasi Intent & Contoh Payload](#spesifikasi-intent--contoh-payload)
5. [Panduan Integrasi n8n Workflow](#5-panduan-integrasi-n8n-workflow)

---

## 1. Arsitektur Sistem & Alur Bisnis

Laravel Monolith bertindak sebagai **Single Source of Truth**. Seluruh data disimpan dan dikelola hanya melalui MySQL via Laravel Service Layer.

```
┌─────────────────┐       ┌────────────────────┐       ┌────────────────────┐
│  User Telegram  │ ────► │  Telegram Bot API  │ ────► │    n8n Workflow    │
└─────────────────┘       └────────────────────┘       └─────────┬──────────┘
                                                                 │ (Parse NLP / AI)
                                                                 ▼
┌─────────────────┐       ┌────────────────────┐       ┌────────────────────┐
│ MySQL Database  │ ◄──── │   Service Layer    │ ◄──── │ Laravel REST API   │
│  (fintrack_ai)  │       │ (TransactionService│       │ (/api/bot/execute) │
└─────────────────┘       └────────────────────┘       └────────────────────┘
```

---

## 2. Base URL & Standard Response

- **Base URL Local**: `http://127.0.0.1:8000/api`
- **Header**:
  - `Accept: application/json`
  - `Content-Type: application/json`

### Standard Response Format (Success - 200 OK / 201 Created)
```json
{
  "success": true,
  "message": "Pesan deskripsi status sukses",
  "data": { ... }
}
```

### Standard Response Format (Error - 400 Bad Request / 422 Unprocessable / 500)
```json
{
  "success": false,
  "message": "Pesan deskripsi kesalahan",
  "errors": {
    "field_name": [
      "Pesan error spesifik validasi"
    ]
  }
}
```

---

## 3. Spesifikasi REST API Endpoint

### Dashboard & Statistik

#### 1. Get Dashboard Summary
- **Endpoint**: `GET /api/dashboard`
- **Deskripsi**: Mengambil 5 metrik summary saldo, income/expense bulan ini, net balance, & 5 transaksi terbaru.
- **Sample Response**:
  ```json
  {
    "success": true,
    "message": "Berhasil mengambil data dashboard",
    "data": {
      "summary": {
        "current_balance": 10080000,
        "monthly_income": 18500000,
        "monthly_expense": 8420000,
        "monthly_balance": 10080000,
        "total_transactions": 16
      },
      "recent_transactions": [ ... ]
    }
  }
  ```

#### 2. Get Analytics Statistics
- **Endpoint**: `GET /api/statistics`
- **Deskripsi**: Mengambil data struktur Chart (Income vs Expense 6 Bulan, Breakdown Kategori, & Trend Transaksi).

---

### Manajemen Kategori

#### 1. List All Categories
- **Endpoint**: `GET /api/categories?type=expense`
- **Query Parameters**:
  - `type` *(optional)*: `income` | `expense`

#### 2. Create Category
- **Endpoint**: `POST /api/categories`
- **Payload**:
  ```json
  {
    "name": "Investasi & Saham",
    "type": "expense",
    "color": "#8B5CF6",
    "icon": "chart-bar"
  }
  ```

#### 3. Update Category
- **Endpoint**: `PUT /api/categories/{id}`

#### 4. Delete Category
- **Endpoint**: `DELETE /api/categories/{id}`

---

### Manajemen Transaksi

#### 1. List Transactions (With Search & Pagination)
- **Endpoint**: `GET /api/transactions`
- **Query Parameters**:
  - `search` *(optional)*: String pencarian deskripsi/catatan.
  - `type` *(optional)*: `income` | `expense`
  - `category_id` *(optional)*: Integer ID kategori.
  - `date_start` *(optional)*: `YYYY-MM-DD`
  - `date_end` *(optional)*: `YYYY-MM-DD`
  - `page` *(optional)*: Integer nomor halaman (default: 1).

#### 2. Create Transaction
- **Endpoint**: `POST /api/transactions`
- **Payload**:
  ```json
  {
    "transaction_date": "2026-07-30",
    "type": "expense",
    "category_id": 1,
    "amount": 45000,
    "description": "Makan Siang Resto Padang",
    "notes": "Dibayar via QRIS"
  }
  ```

#### 3. Update Transaction
- **Endpoint**: `PUT /api/transactions/{id}`

#### 4. Delete Transaction
- **Endpoint**: `DELETE /api/transactions/{id}`

---

### Laporan Keuangan

- **Daily Report**: `GET /api/report/daily?date=2026-07-30`
- **Weekly Report**: `GET /api/report/weekly?start_date=2026-07-24&end_date=2026-07-30`
- **Monthly Report**: `GET /api/report/monthly?year=2026&month=07`

---

## 4. n8n Webhook & Telegram Bot Engine (`/api/bot/execute`)

Endpoint ini merupakan webhook utama yang menerima instruksi *intent* yang diekstrak oleh n8n (menggunakan AI/NLP) untuk dibalas kembali ke Telegram Bot.

- **Endpoint**: `POST /api/bot/execute`

### Skema Request Webhook
```json
{
  "intent": "NAMA_INTENT",
  "parameters": {
    ...
  }
}
```

---

### Spesifikasi Intent & Contoh Payload

#### A. Intent: `create_transaction`
Mencatat transaksi baru dari pesan natural user Telegram.

**Request:**
```json
{
  "intent": "create_transaction",
  "parameters": {
    "type": "expense",
    "category_name": "Makanan & Minuman",
    "amount": 45000,
    "description": "Makan Siang Resto Padang",
    "transaction_date": "2026-07-30",
    "notes": "Catatan tambahan opsional"
  }
}
```

**Response:**
```json
{
  "success": true,
  "message": "Intent 'create_transaction' berhasil diproses.",
  "data": {
    "intent": "create_transaction",
    "reply_text": "✅ Transaksi Pengeluaran berhasil dicatat!\n💰 Nominal: Rp 45.000\n🏷️ Kategori: Makanan & Minuman\n📝 Deskripsi: Makan Siang Resto Padang\n📅 Tanggal: 30 Juli 2026",
    "transaction": {
      "id": 16,
      "transaction_date": "2026-07-30",
      "type": "expense",
      "amount": 45000,
      "description": "Makan Siang Resto Padang"
    }
  }
}
```

---

#### B. Intent: `statistics`
Mengambil ringkasan statistik keuangan bulanan.

**Request:**
```json
{
  "intent": "statistics"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Intent 'statistics' berhasil diproses.",
  "data": {
    "intent": "statistics",
    "reply_text": "📊 **Statistik Keuangan Bulan Ini:**\n\n📥 Pemasukan: Rp 18.500.000\n📤 Pengeluaran: Rp 8.420.000\n⚖️ Cashflow Net: Rp 10.080.000"
  }
}
```

---

#### C. Intent: `daily_report` / `weekly_report` / `monthly_report`

**Request (Monthly):**
```json
{
  "intent": "monthly_report",
  "parameters": {
    "year": 2026,
    "month": 7
  }
}
```

**Response:**
```json
{
  "success": true,
  "message": "Intent 'monthly_report' berhasil diproses.",
  "data": {
    "intent": "monthly_report",
    "reply_text": "📅 **Laporan Bulanan (Juli 2026):**\n\n📥 Total Pemasukan: Rp 18.500.000\n📤 Total Pengeluaran: Rp 8.420.000\n💰 Net Cashflow: Rp 10.080.000\n📊 Total Transaksi: 16 data"
  }
}
```

---

#### D. Intent: `update_transaction` & `delete_transaction`

- **Update:**
  ```json
  {
    "intent": "update_transaction",
    "parameters": {
      "id": 16,
      "amount": 50000,
      "description": "Makan Siang Rendang Daging"
    }
  }
  ```

- **Delete:**
  ```json
  {
    "intent": "delete_transaction",
    "parameters": {
      "id": 16
    }
  }
  ```

---

#### E. Intent: `help`
```json
{
  "intent": "help"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Intent 'help' berhasil diproses.",
  "data": {
    "intent": "help",
    "reply_text": "🤖 **Panduan Penggunaan FinTrack AI Bot:**\n\n- *Mencatat pengeluaran/pemasukan*: Ketik 'Catat pengeluaran 50rb untuk makan'\n- *Lihat statistik*: Ketik 'Statistik bulan ini'\n- *Lihat laporan*: Ketik 'Laporan harian' / 'Laporan bulanan'\n- *Edit/Hapus*: Ketik 'Hapus transaksi ID 15'"
  }
}
```

---

## 5. Panduan Integrasi n8n Workflow

1. **Node 1: Telegram Trigger** -> Menerima pesan teks dari user Telegram.
2. **Node 2: OpenAI / Gemini AI Node (NLP Parser)** -> Memproses pesan teks pengguna dan mengonversinya menjadi JSON format intent (`create_transaction`, `statistics`, dll).
3. **Node 3: HTTP Request Node** ->
   - **Method**: `POST`
   - **URL**: `http://127.0.0.1:8000/api/bot/execute`
   - **Body Spec**: JSON (berisi output intent & parameters dari Node 2).
4. **Node 4: Telegram Send Message Node** -> Mengirimkan kembali string `data.reply_text` yang diterima dari API ke user Telegram.
