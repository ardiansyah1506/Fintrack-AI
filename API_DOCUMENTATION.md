# 📘 FinTrack AI - Dedicated REST API Documentation

Selamat datang di Dokumentasi Resmi REST API **FinTrack AI Personal Finance Operating System**.

Aplikasi ini berarsitektur **Clean Architecture** berbasis Laravel 12 yang berfungsi sebagai **Control Center**, **Data Center**, dan **Single Source of Truth** untuk seluruh transaksi keuangan, pengingat, tagihan rutin, serta modul kecerdasan buatan (AI Center).

> 📄 Untuk dokumentasi n8n Telegram Bot Workflow, lihat [`N8N_WORKFLOW_DOCS.md`](N8N_WORKFLOW_DOCS.md)

---

## 📑 Daftar Isi
1. [Arsitektur & Konsep Dasar](#1-arsitektur--konsep-dasar)
2. [Format Respons Standar](#2-format-respons-standar)
3. [Autentikasi & Header](#3-autentikasi--header)
4. [Parameter Global (Pagination & Search)](#4-parameter-global-pagination--search)
5. [Bot Execution Endpoint (n8n / Telegram NLP)](#5-bot-execution-endpoint-n8n--telegram-nlp)
6. [Dashboard & Metrics API](#6-dashboard--metrics-api)
7. [Modul Keuangan Core (CRUD)](#7-modul-keuangan-core-crud)
   - [Categories](#a-categories)
   - [Transactions](#b-transactions)
   - [Financial Reports](#c-financial-reports)
8. [Modul Control Center (CRUD)](#8-modul-control-center-crud)
   - [Reminders](#a-reminders)
   - [Recurring Bills](#b-recurring-bills)
   - [Budgets](#c-budgets)
   - [Saving Goals](#d-saving-goals)
   - [Notifications](#e-notifications)
9. [Modul AI Center (CRUD)](#9-modul-ai-center-crud)
   - [AI Insights](#a-ai-insights)
   - [AI Predictions](#b-ai-predictions)
   - [AI Recommendations](#c-ai-recommendations)
   - [AI Warnings](#d-ai-warnings)
   - [AI Achievements](#e-ai-achievements)
   - [AI Memories (Vector Context)](#f-ai-memories-vector-context)
   - [Chat History](#g-chat-history)
   - [Prompt Manager](#h-prompt-manager)
   - [AI Logs](#i-ai-logs)
10. [Panduan Integrasi n8n & Groq AI](#10-panduan-integrasi-n8n--groq-ai)

---

## 1. Arsitektur & Konsep Dasar

```
┌──────────────┐     ┌──────────────┐     ┌──────────────┐     ┌──────────────┐
│  Telegram    │ ──> │     n8n      │ ──> │   Gemini     │ ──> │   Laravel    │
│  (Chat UI)   │ <── │  (Workflow)  │ <── │  (AI Brain)  │ <── │(Control Ctr) │
└──────────────┘     └──────────────┘     └──────────────┘     └──────────────┘
```

- **Laravel**: Mengelola database MySQL, memproses *business logic*, *Repository Pattern*, REST API Server, dan Dashboard UI.
- **n8n**: Mesin otomasi *workflow* dan satu-satunya *Scheduler/Cronrunner*.
- **Gemini**: AI Engine untuk *Natural Language Processing* (NLP) & ekstraksi intent.
- **Telegram**: Antarmuka interaksi berbasis percakapan (*Chat Interface*).

---

## 2. Format Respons Standar

Seluruh endpoint REST API FinTrack AI mengembalikan format JSON baku dengan **6 field wajib**:

### A. Respon Berhasil (HTTP 200 / 201)
```json
{
    "success": true,
    "intent": "create_transaction",
    "resource": "transaction",
    "status": "success",
    "message": "Transaksi berhasil dicatat.",
    "data": {
        // Object atau Array hasil query
    }
}
```

| Field | Tipe | Deskripsi |
|-------|------|-----------|
| `success` | `boolean` | Status eksekusi: `true` / `false` |
| `intent` | `string` | Nama intent yang dieksekusi (e.g. `create_transaction`) |
| `resource` | `string` | Jenis resource utama (e.g. `transaction`) |
| `status` | `string` | Nilai: `success` \| `error` |
| `message` | `string` | Pesan deskriptif singkat |
| `data` | `object\|array\|null` | Payload data hasil operasi |

### B. Respon Gagal Validasi (HTTP 422)
```json
{
    "success": false,
    "intent": "create_transaction",
    "resource": "transaction",
    "status": "error",
    "message": "Validation Error",
    "errors": {
        "amount": ["The amount field is required."],
        "category": ["The category field is required."]
    }
}
```

### C. Respon Error Sistem / Not Found (HTTP 400 / 404 / 500)
```json
{
    "success": false,
    "intent": "",
    "resource": "",
    "status": "error",
    "message": "Penyebab kesalahan atau data tidak ditemukan",
    "data": null
}
```

---

## 3. Autentikasi & Header

Setiap *HTTP Request* yang dikirimkan oleh client (Web, Mobile, n8n) wajib menyertakan header:

```http
Accept: application/json
Content-Type: application/json
```

*(Catatan: Autentikasi API Key / Bearer Token menyesuaikan konfigurasi environment proyek `API_KEY` atau `BEARER_TOKEN`).*

---

## 4. Parameter Global (Pagination & Search)

Seluruh endpoint berjenis **List/Collection** (`GET`) mendukung parameter URL query berikut:

| Parameter | Tipe | Contoh | Deskripsi |
| :--- | :--- | :--- | :--- |
| `search` | String | `?search=gofood` | Pencarian dinamis pada nama/keterangan/kategori |
| `page` | Integer | `?page=2` | Halaman paginasi yang ingin dibuka (default: `1`) |
| `per_page` | Integer | `?per_page=15` | Jumlah data per halaman (default: `10`) |
| `sort_by` | String | `?sort_by=amount` | Kolom pengurutan data |
| `sort_dir` | String | `?sort_dir=desc` | Arah pengurutan (`asc` atau `desc`) |

---

## 5. Bot Execution Endpoint (n8n / Telegram NLP)

Endpoint tunggal utama yang dipanggil oleh n8n setelah Gemini mengekstrak Intent & Parameter dari pesan Telegram.

### `POST /api/bot/execute`

#### Payload Request Example:
```json
{
    "intent": "create_transaction",
    "parameters": {
        "type": "expense",
        "amount": 75000,
        "category": "Makanan",
        "description": "Makan siang bersama tim",
        "date": "2026-07-31"
    }
}
```

#### Daftar Intent Lengkap yang Diterima Engine (`IntentDispatcherService`):

| Category | Intent String | Deskripsi Parameter (`parameters`) |
| :--- | :--- | :--- |
| **Transaction** | `create_transaction` | `type` (income/expense), `amount`, `category`, `description`, `date` |
| | `update_transaction` | `id`, `amount`, `category`, `description`, `date` |
| | `delete_transaction` | `id` |
| **Category** | `create_category` | `name`, `type` (income/expense) |
| | `update_category` | `id`, `name`, `type` |
| | `delete_category` | `id` |
| | `list_categories` / `categories` | `type` (optional: income/expense. Jika kosong, mengembalikan seluruh kategori) |
| **Statistics** | `statistics` | `period` (today/this_week/this_month) |
| | `report` / `daily_report` | `date` (YYYY-MM-DD) |
| | `weekly_report` | `start_date`, `end_date` |
| | `monthly_report` | `year`, `month` |
| **Reminder** | `create_reminder` | `name` (atau `title`), `due_date`, `notes` |
| | `update_reminder` | `id`, `status` (pending/completed) |
| | `delete_reminder` | `id` |
| | `list_reminders` | `status` (pending/completed) |
| **Bills** | `create_bill` | `name`, `amount`, `due_date`, `frequency` |
| | `update_bill` | `id`, `status` (active/paid) |
| | `delete_bill` | `id` |
| | `list_bills` | - |
| **Budgets** | `create_budget` | `category`, `amount_limit`, `period` |
| | `update_budget` | `id`, `amount_limit` |
| | `delete_budget` | `id` |
| | `budget` / `balance` | - |
| **Saving Goals** | `create_saving_goal` | `name`, `target_amount`, `target_date` |
| | `update_saving_goal` | `id`, `current_amount` |
| | `delete_saving_goal` | `id` |
| | `saving_progress` | - |
| **AI Modules** | `ai_insight` | `topic` |
| | `ai_prediction` | `type` |
| | `ai_recommendation` | `context` |
| **System** | `greeting` | - |
| | `telegram_status` | - |
| | `dashboard` | - |
| | `help` | - |
| | `unknown` | - |

---

## 6. Dashboard & Metrics API

### A. Get Complete Dashboard Data
- **Route:** `GET /api/dashboard`
- **Response Contoh:**
```json
{
    "success": true,
    "message": "Berhasil mengambil data dashboard",
    "data": {
        "summary": {
            "current_balance": 15500000,
            "total_income": 20000000,
            "total_expense": 4500000,
            "monthly_income": 20000000,
            "monthly_expense": 4500000,
            "monthly_balance": 15500000,
            "total_transactions": 48
        },
        "recent_transactions": [ ... ],
        "income_vs_expense_chart": { ... },
        "expense_by_category_chart": { ... }
    }
}
```

### B. Get Statistics Summary
- **Route:** `GET /api/statistics`

### C. Get AI Summary Widget Metrics
- **Route:** `GET /api/dashboard/ai`
- **Response Contoh:**
```json
{
    "success": true,
    "message": "Data AI Summary Berhasil",
    "data": {
        "balance": 15500000,
        "reminders_count": 3,
        "bills_count": 2
    }
}
```

### D. Get Telegram Sync Status
- **Route:** `GET /api/telegram/status`

---

## 7. Modul Keuangan Core (CRUD)

### A. Categories
- `GET /api/categories` : List kategori (Mendukung `?search=` dan `?type=income|expense`. **Jika `?type=` kosong/tidak diisi, sistem mengembalikan seluruh kategori**).
- `POST /api/categories` : Buat kategori baru.
  - Payload: `{ "name": "Gaji", "type": "income" }`
- `GET /api/categories/{id}` : Detail kategori.
- `PUT /api/categories/{id}` : Update kategori.
- `DELETE /api/categories/{id}` : Hapus kategori.

### B. Transactions
- `GET /api/transactions` : List transaksi (Paginated).
  - Query Filters: `?type=expense`, `?category=Makanan`, `?period=this_month`, `?date_start=2026-07-01&date_end=2026-07-31`.
- `POST /api/transactions` : Catat transaksi baru.
  - Payload:
  ```json
  {
      "type": "expense",
      "category": "Transportasi",
      "amount": 25000,
      "description": "Bensin motor",
      "transaction_date": "2026-07-31",
      "source": "Telegram",
      "notes": "Diinput via bot"
  }
  ```
- `GET /api/transactions/{id}` : Detail transaksi.
- `PUT /api/transactions/{id}` : Update transaksi.
- `DELETE /api/transactions/{id}` : Hapus transaksi.

### C. Financial Reports
- `GET /api/report/daily?date=YYYY-MM-DD` : Laporan keuangan harian.
- `GET /api/report/weekly?start_date=YYYY-MM-DD&end_date=YYYY-MM-DD` : Laporan keuangan mingguan.
- `GET /api/report/monthly?year=2026&month=7` : Laporan keuangan bulanan.

---

## 8. Modul Control Center (CRUD)

### A. Reminders (Pengingat)
- `GET /api/reminders` : List pengingat.
- `POST /api/reminders` : Buat pengingat baru.
  - Payload: `{ "name": "Bayar Listrik", "due_date": "2026-08-05 10:00:00", "notes": "Token PLN" }` *(Dukungan field legacy `title` tetap aktif secara otomatis).*
- `GET /api/reminders/{id}` : Detail pengingat.
- `PUT /api/reminders/{id}` : Update pengingat.
- `DELETE /api/reminders/{id}` : Hapus pengingat.

### B. Recurring Bills (Tagihan Rutin)
- `GET /api/bills` : List tagihan rutin.
- `POST /api/bills` : Tambah tagihan rutin baru.
  - Payload: `{ "name": "Wi-Fi Indihome", "amount": 350000, "due_date": "2026-08-10", "frequency": "monthly" }`
- `GET /api/bills/{id}` : Detail tagihan.
- `PUT /api/bills/{id}` : Update tagihan.
- `DELETE /api/bills/{id}` : Hapus tagihan.

### C. Budgets (Anggaran)
- `GET /api/budgets` : List anggaran per kategori.
- `POST /api/budgets` : Buat anggaran baru.
  - Payload: `{ "category": "Makanan", "amount_limit": 2000000, "period": "monthly" }`
- `GET /api/budgets/{id}` : Detail anggaran.
- `PUT /api/budgets/{id}` : Update batas anggaran.
- `DELETE /api/budgets/{id}` : Hapus anggaran.
- `GET /api/budget/summary` : Summary total batas vs pemakaian anggaran.

### D. Saving Goals (Target Tabungan)
- `GET /api/saving-goals` : List target tabungan.
- `POST /api/saving-goals` : Tambah target tabungan.
  - Payload: `{ "name": "Dana Darurat", "target_amount": 50000000, "current_amount": 10000000, "target_date": "2026-12-31" }`
- `GET /api/saving-goals/{id}` : Detail target tabungan.
- `PUT /api/saving-goals/{id}` : Update target/progress.
- `DELETE /api/saving-goals/{id}` : Hapus target tabungan.

### E. Notifications
- `GET /api/notifications` : List notifikasi.
- `POST /api/notifications` : Injeksi notifikasi dari n8n.
  - Payload: `{ "name": "Bayar Tagihan", "message": "Jatuh tempo hari ini", "type": "info" }`
- `GET /api/notifications/{id}` : Detail notifikasi.
- `PUT /api/notifications/{id}` : Tandai dibaca (`is_read: true`).
- `DELETE /api/notifications/{id}` : Hapus notifikasi.

---

## 9. Modul AI Center (CRUD)

Seluruh 8 modul AI Center memiliki endpoint REST API penuh yang memfasilitasi penulisan dan pembacaan memori/log AI oleh n8n.

*(Catatan Migrasi: Kolom `title` telah disatukan secara konsisten menjadi `name` pada seluruh tabel database AI Center dengan backward-compatibility layer pada Eloquent Model Accessor/Mutator & Request Mapper).*

### A. AI Insights
- **Route Utama:** `GET|POST /api/insights` (Alias: `/api/ai-insights`)
- **Payload POST:**
```json
{
    "name": "Analisis Pengeluaran Mingguan",
    "content": "Pengeluaran makanan meningkat 15% dibanding minggu lalu.",
    "type": "weekly"
}
```

### B. AI Predictions
- **Route Utama:** `GET|POST /api/predictions`
- **Payload POST:**
```json
{
    "name": "Cashflow Forecast",
    "prediction_type": "cashflow_forecast",
    "description": "Diperkirakan saldo tersisa Rp 2.500.000 pada akhir bulan.",
    "confidence": 92.5
}
```

### C. AI Recommendations
- **Route Utama:** `GET|POST /api/recommendations`
- **Payload POST:**
```json
{
    "name": "Penghematan Langganan",
    "description": "Batalkan langganan yang jarang dipakai untuk menghemat Rp 150.000/bulan.",
    "priority": "medium"
}
```

### D. AI Warnings
- **Route Utama:** `GET|POST /api/warnings`
- **Payload POST:**
```json
{
    "name": "Batas Anggaran Makanan",
    "severity": "high",
    "description": "Peringatan! Pengeluaran kategori Makanan telah mencapai 90% dari batas anggaran."
}
```

### E. AI Achievements
- **Route Utama:** `GET|POST /api/achievements`
- **Payload POST:**
```json
{
    "name": "Smart Saver",
    "description": "Berhasil mempertahankan rasio tabungan di atas 30% selama 3 bulan berturut-turut!"
}
```

### F. AI Memories (Vector Context)
- **Route Utama:** `GET|POST /api/memories`
- **Payload POST:**
```json
{
    "key": "user_financial_goal",
    "value": "Ingin membeli rumah dalam 5 tahun",
    "relevance": 10
}
```

### G. Chat History
- **Route Utama:** `GET|POST /api/chat-history` (Alias: `/api/chat-histories`)
- **Payload POST:**
```json
{
    "user_message": "Berapa sisa budget makan saya?",
    "bot_response": "Sisa budget makan Anda bulan ini adalah Rp 450.000.",
    "intent": "budget"
}
```

### H. Prompt Manager
- **Route Utama:** `GET|POST /api/prompts`
- **Payload POST:**
```json
{
    "ai_role": "financial_advisor",
    "instruction_template": "Kamu adalah asisten keuangan pribadi yang ramah dan bijak..."
}
```

### I. AI Logs
- **Route Utama:** `GET|POST /api/ai-logs`
- **Payload POST:**
```json
{
    "endpoint": "gemini-1.5-pro",
    "duration_ms": 420,
    "status": "success"
}
```

---

## 10. Panduan Integrasi n8n & Groq AI

FinTrack AI menggunakan **satu workflow n8n terpadu** sebagai orchestration layer. File workflow tersedia di `fintrack_ai_telegram_bot_workflow.json`.

### Alur Integrasi

```
Telegram → n8n Trigger
         → Normalize Message
         → [Parallel] Load Prompt (GET /api/prompts)
                      Load Memory (GET /api/memories)
         → Build AI Request (inject prompt + memory)
         → Groq API (llama-3.3-70b, JSON mode)
         → Parse Intent + Parameters
         → Switch Group (crud/report/system/ai_module)
         → POST /api/bot/execute
         → Format Response
         → Telegram Send Message
```

### Endpoint yang Digunakan Workflow n8n

| Method | Endpoint | Fungsi |
|--------|----------|--------|
| `POST` | `/api/bot/execute` | Eksekusi intent dari Groq AI |
| `GET` | `/api/prompts?per_page=50` | Load system prompt aktif |
| `GET` | `/api/memories?per_page=100` | Load konteks memori AI |
| `GET` | `/api/combined-data` | Load semua data untuk analisis AI Module |

### Format Request ke `/api/bot/execute`

```json
{
    "intent": "create_transaction",
    "parameters": {
        "type": "expense",
        "amount": 75000,
        "category": "Makanan",
        "description": "Makan siang",
        "transaction_date": "2026-08-05"
    }
}
```

### Format Response dari `/api/bot/execute`

```json
{
    "success": true,
    "intent": "create_transaction",
    "resource": "transaction",
    "status": "success",
    "message": "Transaksi berhasil dicatat oleh Bot",
    "data": {
        "id": 42,
        "type": "expense",
        "amount": 75000,
        "category": "Makanan",
        "transaction_date": "2026-08-05"
    }
}
```

### Setup Workflow n8n

Lihat [`N8N_WORKFLOW_DOCS.md`](N8N_WORKFLOW_DOCS.md) untuk panduan setup lengkap, termasuk:
- Environment variables yang diperlukan
- Konfigurasi credentials Telegram & Groq
- Cara import workflow JSON
- Penjelasan per node

---
*Dokumentasi ini dibuat dan dikurasi sesuai standar Laravel 12 Enterprise Clean Architecture FinTrack AI OS.*
