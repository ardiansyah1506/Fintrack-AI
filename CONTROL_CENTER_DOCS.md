# Dokumentasi API & Fitur FinTrack AI Control Center

Update ini mendokumentasikan keseluruhan fitur dan _routes_ (Web & REST API) pada sistem **FinTrack AI** yang baru saja dirombak menjadi **Control Center** untuk sinkronisasi otomatis dengan AI Telegram Assistant (via n8n).

---

## 🏗️ 1. Arsitektur & Teknologi

- **Frontend Dashboard/UI**: Laravel Blade, Tailwind CSS (CDN), Alpine.js (CDN), Chart.js (CDN).
- **Backend Source of Truth**: Laravel 12 (Service Pattern + Form Request Validation).
- **AI Orchestrator Target**: N8N Automation & webhook Telegram Bot.

Semua pengolahan logic AI (pengingat jatuh tempo, generasi _insight_, parsing struk dari chat telegram) dieksekusi di ranah **n8n**. Laravel hanya menyediakan API JSON dan UI Control Center berbasis Web untuk memonitor data.

---

## 🗂️ 2. Daftar Modul & Endpoint API Baru

> **Catatan:** Seluruh Endpoint API di-prefix dengan `/api/` dan membutuhkan/mengembalikan format `application/json`. Header wajib disertakan: `Accept: application/json` & `Content-Type: application/json`.

### A. Reminders (Pengingat Tugas & Chat)

- **Web UI Route**: `GET /reminders`
- **API Endpoints**:
    - `GET /api/reminders` (Daftar semua tasks)
    - `POST /api/reminders` (Membuat task baru)
    - `PUT /api/reminders/{id}` (Update status task)
    - `DELETE /api/reminders/{id}` (Hapus task)

**Contoh Parameter Payload JSON Request (POST/PUT):**

```json
{
    "name": "Membayar cicilan asuransi motor",
    "description": "Auto debit dari rekening utama BCA",
    "due_date": "2026-08-01",
    "due_time": "09:00:00",
    "repeat": "monthly",
    "priority": "high",
    "status": "pending",
    "telegram_notification": true
}
```

_(Catatan Enum: `repeat` = none, daily, weekly, monthly, yearly. `priority` = low, medium, high. `status` = pending, done, cancelled. Payload menerima `name` maupun legacy `title` secara otomatis)._

### B. Recurring Bills (Tagihan Rutin)

- **Web UI Route**: `GET /bills`
- **API Endpoints**:
    - `GET /api/bills` (Ambil data tagihan rutinan)

**Contoh Response JSON (GET):**

```json
{
    "data": [
        {
            "id": 1,
            "name": "Langganan N8n Cloud",
            "category": "Software",
            "amount": 350000.0,
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

- **Web UI Route**: `GET /budgets`
- **API Endpoints**:
    - `GET /api/budget/summary` (Mengalkulasi progres transaksi terhadap pagu)

**Contoh Response JSON (GET):**

```json
{
    "data": [
        {
            "id": 1,
            "category": "Makanan",
            "amount": 2000000.0,
            "spent": 1500000.0,
            "remaining": 500000.0,
            "percentage": 75,
            "status_color": "yellow"
        }
    ]
}
```

### D. Saving Goals (Target Tabungan)

- **Web UI Route**: `GET /saving-goals`
- **API Endpoints**:
    - `GET /api/saving-goals`

**Contoh Response JSON (GET):**

```json
{
    "data": [
        {
            "id": 1,
            "name": "Beli MacBook Pro M4",
            "target_amount": 35000000.0,
            "current_amount": 10000000.0,
            "deadline": "2026-12-31",
            "icon": "fa-solid fa-laptop",
            "status": "active"
        }
    ]
}
```

### E. AI Insights (Analisis Cerdas)

- **Web UI Route**: `GET /ai-insights`
- **API Endpoints**:
    - `GET /api/insights`
- **Cara kerja**: Saat _event scheduler_ jalan di N8n memanggil AI Gemini, N8N akan mem-_push_ hasilnya (via webhook kita atau DB injection) ke tabel ini, lalu Control Center Laravel menampilkannya.

**Contoh Response JSON (GET):**

```json
{
    "data": [
        {
            "id": 5,
            "name": "Lonjakan Pengeluaran Hiburan",
            "period": "Minggu 3 Juli 2026",
            "content": "Analisis AI menunjukkan anomali pengeluaran hiburan...",
            "generated_at": "2026-07-31T09:00:00.000000Z",
            "type": "weekly"
        }
    ]
}
```

### F. Notifications (Pusat Pemberitahuan)

- **Web UI Route**: `GET /notifications`
- **API Endpoints**:
    - `GET /api/notifications`

**Contoh Response JSON (GET):**

```json
{
    "data": [
        {
            "id": 9,
            "name": "Transaksi Berhasil Dicatat Bot",
            "message": "Transaksi 50.000 kategori Transport berhasil dibuat",
            "type": "success",
            "read_at": null,
            "created_at": "2026-07-31T08:00:00.000000Z"
        }
    ]
}
```

### G. Telegram Sync & Webhook (N8N Unified API)

Satu-satunya endpoint webhook terpadu untuk mengeksekusi segala jenis intent _Natural Language_ dari chat Telegram yang telah di-_parse_ oleh AI n8n.

- **API Endpoints**:
    - `POST /api/bot/execute` (Webhook N8N intent-handler utama).

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
    "name": "Bayar cicilan motor",
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
    "name": "Liburan Jepang",
    "target_amount": 20000000,
    "deadline": "2027-12-31"
}
```

**Contoh 6: Payload `list_categories` (Ambil Semua Kategori / Filter Type)**

```json
{
    "intent": "list_categories",
    "parameters": {
        "type": "expense" // Opsional: Kosongkan untuk mengambil seluruh kategori
    }
}
```

- **API Endpoints**:
    - `GET /api/telegram/status` (Mendapatkan indikator bot real-time).

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

## 5. Web Interface CRUD Integration

Seluruh entitas operasi AI (seperti Tagihan Rutin, Target Tabungan, Pagu Anggaran, dan Pengingat) kini memiliki Web Interface _Create, Read, Update, Delete_ penuh di Control Center Dashboard.

Secara teknis:

- **UI Responsif**: Diimplementasi menggunakan kombinasi Blade Components, Tailwind CSS, dan Alpine.js Modal (x-show).
- **Synchronized Data**: Data yang ditambah/diupdate melalui form di website akan secara instan mengubah _knowledge scope_ dan _trigger-rules_ yang akan dibaca oleh N8n melalui REST API.
- **Controller Terpadu**: Di-handle pada level App\Http\Controllers\BudgetController, RecurringBillController, SavingGoalController, dan ReminderController.

## 🧠 6. Dokumentasi Modul AI Center Tersinkronisasi N8N

Keseluruhan **8 Modul AI Center** terbaru telah dipetakan menjadi endpoints mandiri, terikat dengan `FormRequest` validation dan `REST API Resources`. Parameter input sifatnya statis berdasarkan nama tabel. N8N dapat me-record JSON secara leluasa.

### Endpoints REST API Utama (AI Center)

Semua route mendukung skema: `GET` (List all search & paginate), `POST` (Create/Inject data dari bot), `GET /{id}` (Detail), `PUT /{id}` (Update Data), `DELETE /{id}`.

1. **AI Insights**
    - **Route:** `/api/ai-insights`
    - **Asumsi Parameter POST:** json `{ "title": "Insight keuangan 1", "content": "Rasio tabungan 30%" }`
2. **AI Predictions**
    - **Route:** `/api/predictions`
    - **Asumsi Parameter POST:** json `{ "type": "cashflow", "prediction_value": "Minus 200k lusa", "confidence_score": 85 }`

3. **AI Recommendations**
    - **Route:** `/api/recommendations`
    - **Asumsi Parameter POST:** json `{ "context": "Budget makanan", "advice": "Kurangi gofood" }`

4. **AI Warnings**
    - **Route:** `/api/warnings`
    - **Asumsi Parameter POST:** json `{ "severity": "high", "message": "Resiko gagal bayar asuransi bulan ini" }`

5. **AI Achievements**
    - **Route:** `/api/achievements`
    - **Asumsi Parameter POST:** json `{ "badge": "Gold Saver", "description": "Tercapai simpanan 10 Juta!" }`

6. **AI Memories (Context Vector Database)**
    - **Route:** `/api/memories`
    - **Asumsi Parameter POST:** json `{ "key": "favorite_food", "value": "Suka nasi padang", "relevance": 9 }`

7. **Prompt Manager**
    - **Route:** `/api/prompts`
    - **Asumsi Parameter POST:** json `{ "ai_role": "analyst", "instruction_template": "Berikan rekomendasi keuangan..." }`

8. **AI Logs (Tracking request duration)**
    - **Route:** `/api/ai-logs`
    - **Asumsi Parameter POST:** json `{ "endpoint": "n8n/gemini", "duration_ms": 1500, "status": "success" }`

> **Note Validasi:** Jika n8n mem-posting data yang salah atau kurang argumen `required`, server secara otomatis mem-bounce request dengan JSON tipe HTTP 422: `{"message": "The given data was invalid", "errors": {"name": ["The name field is required."]}}`.

## ✅ Status Sistem Refactor: STABIL (100% Backward & Forward Ready)

---

## 🏛️ 7. Standar Arsitektur (Master Architecture Guide)

Proyek ini telah ditetapkan sebagai **AI Personal Finance Operating System** dengan arsitektur ketat yang mengadopsi prinsip **SOLID** dan **Clean Architecture**.

### A. Peran Komponen Utama

1. **Laravel**: Berperan mutlak sebagai _Control Center_, Penyedia REST API, _Single Source of Truth_ database, dan mengeksekusi _Business Logic_ beserta fungsi _CRUD Web UI_. **Bukan chatbot** dan **tidak melakukan NLP Parsing**.
2. **n8n**: Bertindak sebagai _Workflow Automation Engine_ dan satu-satunya _Scheduler/Cronrunner_. Seluruh penjadwalan (Reminder, Bills) diatur dari n8n.
3. **Gemini**: Memainkan peran sebagai _AI Brain_ yang membaca _prompt_ serta menganalisis NLP (sistem intent).
4. **Telegram**: Bertindak hanya sebagai antarmuka (_Natural Language Interface_).

### B. Hierarki Clean Architecture Workflow

Alur kerja yang wajib ditaati untuk seluruh integrasi bot & Web:
`Controller → Service → (Intent Dispatcher) → (Intent Class) → Repository → Database`

- **Controller**: Tidak boleh mempunyai business logic, fungsi _Controller_ hanya meneruskan _Request/JSON_ ke _Service_.
- **Intent Dispatcher**: Menggantikan _Switch-Case_. Memetakan _intent string_ ke _Intent Class_ melalui parameter injeksi (_Dependency Injection_ - `app()->make()`).
- **Intent Class**: Merupakan _single responsibility class_ yang fokus me-_return_ command JSON tertentu namun **tidak boleh** melakukan _query_ database. Panggil _Service_!
- **Service Layer**: Mengolah logika bisnis dan memanggil metode pada _Repository_. Komponen ini digunakan bersamaan secara sinkron oleh API Web maupun Telegram.
- **Repository**: Ujung tombak komunikasi Eloquent. Jangan gunakan query mentah `User::where(...)` di Controller atau Service. _Bind_ melalui interface klasikal (Dependency Injection `TransactionRepositoryInterface`).

### C. Standardisasi REST API

Seluruh format pengiriman output harus menggunakan standar absolut:

```json
// Berhasil
{
    "success": true,
    "message": "Success",
    "data": { ... }
}

// Gagal Validasi HTTP 422
{
    "success": false,
    "message": "Validation Error",
    "errors": { ... }
}
```

Untuk mengimplementasikannya, Backend telah difilter melewati layer `FormRequest` untuk validasi otomatis dan dikembalikan melalui `API Resource`. Penulisan script secara ketat telah menggunakan fitur terbarukan _Laravel 12_ seperti _Type Hint_, _PHPDoc_, dan eksplisit _Return Type_.

Seluruh _backward compatibility_ dari fitur dasar transaksi dan laporan dijamin tetap 100% fungsional baik pada interface web Blade (/reports, /categories) maupun API.
