# 🤖 FinTrack AI — Dokumentasi n8n Workflow

> **File Workflow:** `fintrack_ai_telegram_bot_workflow.json`
> **Versi:** 1.0.0 | **Tanggal:** 2026-08-05
> **AI Engine:** Groq (llama-3.3-70b-versatile)
> **Import ke n8n:** Workflows → Import from File

---

## 📑 Daftar Isi

1. [Gambaran Umum](#1-gambaran-umum)
2. [Arsitektur Workflow](#2-arsitektur-workflow)
3. [Daftar Node](#3-daftar-node)
4. [Alur Data Lengkap](#4-alur-data-lengkap)
5. [Setup & Konfigurasi](#5-setup--konfigurasi)
6. [Penjelasan Node per Node](#6-penjelasan-node-per-node)
7. [Intent Routing Logic](#7-intent-routing-logic)
8. [Format Pesan Telegram](#8-format-pesan-telegram)
9. [Error Handling](#9-error-handling)
10. [Pengembangan Lanjutan](#10-pengembangan-lanjutan)

---

## 1. Gambaran Umum

Workflow ini adalah **orchestration layer** tunggal yang menghubungkan Telegram, Groq AI, dan Laravel API FinTrack AI.

```
Pengguna Telegram
      │ kirim pesan
      ▼
   n8n Workflow
      │
      ├─ Normalize pesan
      ├─ Load Prompt + Memory dari Laravel API
      ├─ Kirim ke Groq → ekstrak intent + parameter
      ├─ Route ke 4 jalur eksekusi
      │   ├─ CRUD → POST /api/bot/execute
      │   ├─ Report → POST /api/bot/execute
      │   ├─ System → POST /api/bot/execute
      │   └─ AI Module → GET /api/combined-data → Groq Analysis
      ├─ Format response menjadi teks Telegram
      └─ Kirim balasan ke Telegram
```

### Prinsip Desain
- **Single workflow** — tidak ada sub-workflow terpisah
- **One endpoint** — semua CRUD diteruskan ke `/api/bot/execute`
- **Stateless** — setiap pesan diproses secara independen
- **Fail-safe** — semua HTTP node menggunakan `continueOnFail: true`

---

## 2. Arsitektur Workflow

```
📩 Telegram Trigger
        │
        ▼
🔧 Normalize Message
        │
   ┌────┴────┐
   ▼         ▼
📚 Load    🧠 Load
  Prompt   Memory
   │         │
   └────┬────┘
        ▼
 ⚙️ Merge Context
        │
        ▼
🛠️ Build AI Request
  (inject prompt + memory)
        │
        ▼
🤖 Groq Intent Router
  (JSON mode, llama-3.3-70b)
        │
        ▼
🔍 Parse Groq Response
  (extract intent, params, group)
        │
        ▼
🔀 Switch Intent Group
  ┌─────┬──────┬──────────┐
  │     │      │          │
  ▼     ▼      ▼          ▼
system report  crud    ai_module
  │     │      │          │
  ▼     ▼      ▼          ▼
🔧    📊    ⚡          📦 Fetch
Execute          Combined Data
  │     │      │          │
  │     │      │          ▼
  │     │      │     ✨ AI Response
  │     │      │       Formatter
  │     │      │          │
  └─────┴──────┴──────────┘
                │
                ▼
        📝 Format Response
                │
                ▼
       📤 Telegram Send Message

※ Error path (parallel):
🚨 Error Trigger → ⚙️ Prepare Error → 🚨 Telegram Send Error
```

---

## 3. Daftar Node

| # | Node Name | Type | Fungsi |
|---|-----------|------|--------|
| 1 | 📩 Telegram Trigger | `telegramTrigger` | Menerima pesan dari Telegram |
| 2 | 🔧 Normalize Message | `code` | Ekstrak chatId, userId, teks dari berbagai tipe update |
| 3 | 📚 Load Prompt dari Laravel | `httpRequest` | GET `/api/prompts` |
| 4 | 🧠 Load Memory dari Laravel | `httpRequest` | GET `/api/memories` |
| 5 | ⚙️ Merge Context | `merge` | Gabungkan output Prompt + Memory |
| 6 | 🛠️ Build AI Request | `code` | Susun system prompt + memory context + user message |
| 7 | 🤖 Groq Intent Router | `httpRequest` | POST ke Groq API (JSON mode) |
| 8 | 🔍 Parse Groq Response | `code` | Parse JSON Groq → intent, parameters, intentGroup |
| 9 | 🔀 Switch Intent Group | `switch` | Route ke 4 jalur: system/report/crud/ai_module |
| 10 | 🔧 Execute System Intent | `httpRequest` | POST `/api/bot/execute` (system intents) |
| 11 | 📊 Execute Report Intent | `httpRequest` | POST `/api/bot/execute` (report intents) |
| 12 | ⚡ Execute CRUD Intent | `httpRequest` | POST `/api/bot/execute` (semua CRUD) |
| 13 | 📦 Fetch AI Combined Data | `httpRequest` | GET `/api/combined-data` |
| 14 | ✨ AI Response Formatter | `httpRequest` | POST ke Groq (analisis narasi AI) |
| 15 | 📝 Format Response | `code` | Konversi hasil API → teks Telegram Markdown |
| 16 | 📤 Telegram Send Message | `telegram` | Kirim balasan ke user |
| 17 | 🚨 Error Trigger | `errorTrigger` | Tangkap error dari node manapun |
| 18 | ⚙️ Prepare Error Message | `code` | Format pesan error |
| 19 | 🚨 Telegram Send Error | `telegram` | Kirim notifikasi error ke admin |

---

## 4. Alur Data Lengkap

### Jalur Normal

```
1. Telegram → [message.text, chat.id, from.id, from.first_name]
2. Normalize → {messageText, chatId, userId, firstName, username}
3. Load Prompt → [{id, name:"system", prompt:"...", active:true}]
4. Load Memory → [{id, key:"...", value:"...", type:"string", active:true}]
5. Merge → {messageText, chatId, aiRequest: {model, messages[system+user]}}
6. Groq → {"intent":"create_transaction","message":"...","parameters":{...}}
7. Parse → {intent, intentGroup, aiMessage, parameters}
8. Switch → route ke jalur yang sesuai
9. Execute → POST /api/bot/execute → {"success":true,"intent":"...","data":{...}}
10. Format → teks Markdown Telegram
11. Send → balasan diterima user
```

### Jalur AI Module

```
8. Switch → jalur ai_module
9. Fetch Combined Data → GET /api/combined-data
   → {budgets:[], transactions:[], saving_goals:[], bills:[]}
10. AI Response Formatter → POST Groq dengan data keuangan lengkap
    → narasi analisis dalam bahasa Indonesia
11. Format → teks final
12. Send → balasan diterima user
```

---

## 5. Setup & Konfigurasi

### 5.1 Environment Variables n8n

Tambahkan di **n8n Settings → Environment Variables** (atau `.env` n8n):

| Variable | Contoh Nilai | Keterangan |
|----------|-------------|------------|
| `LARAVEL_API_URL` | `https://fintrack.domain.com` | Base URL Laravel (tanpa trailing slash) |
| `LARAVEL_API_TOKEN` | `Bearer abc123...` | Token autentikasi API (jika ada) |
| `TELEGRAM_ADMIN_CHAT_ID` | `123456789` | Chat ID admin untuk notif error |

### 5.2 Credentials n8n

#### Telegram Bot
- **Type:** Telegram API
- **Name:** `FinTrack Telegram Bot`
- **Bot Token:** Dapatkan dari [@BotFather](https://t.me/BotFather) → `/newbot`

#### Groq API
- **Type:** HTTP Header Auth
- **Name:** `Groq API Key`
- **Header Name:** `Authorization`
- **Header Value:** `Bearer sk-xxx...` (dari [console.groq.com](https://console.groq.com))

### 5.3 Cara Import Workflow

1. Buka n8n → sidebar kiri → **Workflows**
2. Klik **Import from File**
3. Pilih file `fintrack_ai_telegram_bot_workflow.json`
4. Setelah import, buka setiap node dan **ganti credential ID**:
   - Node `📩 Telegram Trigger` → pilih `FinTrack Telegram Bot`
   - Node `🤖 Groq Intent Router` → pilih `Groq API Key`
   - Node `✨ AI Response Formatter` → pilih `Groq API Key`
   - Node `📤 Telegram Send Message` → pilih `FinTrack Telegram Bot`
   - Node `🚨 Telegram Send Error` → pilih `FinTrack Telegram Bot`
5. **Aktifkan workflow** (toggle di kanan atas)
6. Copy **Webhook URL** dari node Telegram Trigger
7. Set webhook Telegram via API:
   ```
   https://api.telegram.org/bot<TOKEN>/setWebhook?url=<WEBHOOK_URL>
   ```

### 5.4 Setup Prompt di Laravel

Sebelum workflow berjalan, buat minimal satu prompt di database:

```http
POST /api/prompts
Content-Type: application/json

{
    "name": "system",
    "prompt": "Kamu adalah FinTrack AI, asisten keuangan pribadi berbasis Telegram...",
    "active": true,
    "version": 1
}
```

> ⚠️ Jika tidak ada prompt aktif, workflow menggunakan **default system prompt** yang sudah tertanam di node `🛠️ Build AI Request`.

---

## 6. Penjelasan Node per Node

### 📩 Telegram Trigger
- Menerima update dari Telegram via webhook
- Mendukung: `message`, `callback_query`, `edited_message`
- **Tidak memproses** bot commands seperti `/start` secara khusus (diperlakukan sebagai teks biasa)

### 🔧 Normalize Message
- Mengekstrak field yang konsisten dari semua tipe update Telegram
- **Guard:** jika `messageText` kosong atau `chatId` null → return array kosong (stop execution)
- Output: `{messageText, chatId, userId, username, firstName, messageId, updateType}`

### 📚 Load Prompt + 🧠 Load Memory
- Dijalankan **paralel** setelah Normalize Message (split connection)
- Timeout: 10 detik, retry 2x
- `continueOnFail: true` → jika gagal, workflow tetap lanjut dengan prompt/memory kosong
- Memory yang dikembalikan: hanya yang `active: true`

### ⚙️ Merge Context
- Mode: `combineBySingle` → menunggu kedua input selesai sebelum melanjutkan
- Menggabungkan output Prompt (input 0) dan Memory (input 1)

### 🛠️ Build AI Request
- Mencari prompt dengan `name === "system"` dan `active === true`
- Membangun `memory context string` dari entries yang active
- Menyusun `messages[]` untuk Groq: `[{role:system, content:...}, {role:user, content:...}]`
- Menggunakan `response_format: {type: "json_object"}` untuk memaksa output JSON

### 🤖 Groq Intent Router
- Model: `llama-3.3-70b-versatile`
- Temperature: `0.1` (deterministic untuk intent extraction)
- Max tokens: `512`
- Timeout: 30 detik, retry 2x
- **Selalu mengembalikan JSON** berkat `response_format: json_object`

### 🔍 Parse Groq Response
- Parse `choices[0].message.content` sebagai JSON
- Klasifikasi `intentGroup`:
  - `ai_module`: `ai_insight`, `ai_prediction`, `ai_recommendation`
  - `report`: `daily_report`, `weekly_report`, `monthly_report`, `statistics`
  - `system`: `greeting`, `help`, `unknown`, `telegram_status`, `dashboard`
  - `crud`: semua intent lainnya (default/fallback)
- Inject metadata user ke `parameters`: `_user_id`, `_chat_id`, `_first_name`

### 🔀 Switch Intent Group
- 4 output path: `system` (0), `report` (1), `ai_module` (2), `crud` (fallback/extra)
- **Fallback** (output extra) → ke jalur CRUD agar tidak ada pesan yang terbuang

### ⚡ Execute CRUD / 📊 Execute Report / 🔧 Execute System Intent
- Ketiganya memanggil endpoint yang sama: `POST /api/bot/execute`
- Dipisah hanya untuk keterbacaan dan memungkinkan konfigurasi timeout berbeda di masa depan
- Payload:
  ```json
  {
    "intent": "{{ $json.intent }}",
    "parameters": { ... }
  }
  ```
- Semua menggunakan `continueOnFail: true`

### 📦 Fetch AI Combined Data
- GET `/api/combined-data` → returns `{budgets, transactions, saving_goals, bills}`
- Hanya dijalankan untuk `intentGroup === "ai_module"`
- Data ini dikirim ke Groq sebagai konteks analisis keuangan

### ✨ AI Response Formatter
- Groq dipanggil **kedua kali** khusus untuk AI Module
- Temperature: `0.3` (lebih kreatif untuk narasi)
- Max tokens: `800`
- System prompt berbeda: menghasilkan narasi human-readable, **bukan JSON**
- Output langsung dalam format teks yang siap dikirim ke Telegram

### 📝 Format Response
- Menerima input dari 4 jalur berbeda (merge via node, semua terhubung ke node ini)
- Mendeteksi sumber input: Groq response (`choices !== undefined`) vs Laravel response (`success !== undefined`)
- Memilih template teks Telegram berdasarkan `intent`
- Menggunakan **Markdown mode** (bukan MarkdownV2) untuk kemudahan formatting

---

## 7. Intent Routing Logic

### Mapping Intent → Group

```
CRUD (default):
  create_transaction, update_transaction, delete_transaction
  create_budget, update_budget, delete_budget, budget, balance
  create_reminder, update_reminder, delete_reminder, list_reminders
  create_bill, update_bill, delete_bill, list_bills
  create_saving_goal, update_saving_goal, delete_saving_goal, saving_progress
  list_categories, create_category, update_category, delete_category
  list_notifications, read_notification
  save_memory, delete_memory, list_memories
  list_prompts

REPORT:
  statistics, daily_report, weekly_report, monthly_report

SYSTEM:
  greeting, help, unknown, telegram_status, dashboard, dashboard_summary

AI_MODULE:
  ai_insight, ai_prediction, ai_recommendation
```

### Groq Intent Extraction Prompt

Groq diperintahkan untuk **selalu** mengembalikan format:
```json
{
  "intent": "<nama_intent>",
  "message": "<pesan_untuk_user_dalam_bahasa_Indonesia>",
  "parameters": {
    "<key>": "<value>"
  }
}
```

Jika intent tidak dikenali → `"intent": "unknown"`.

---

## 8. Format Pesan Telegram

Workflow menggunakan **Markdown mode** (bukan MarkdownV2). Supported formatting:

| Sintaks | Hasil |
|---------|-------|
| `*teks*` | **bold** |
| `` `teks` `` | `monospace` |
| ` ```kode``` ` | code block |

### Contoh Output per Intent

**create_transaction:**
```
✅ *Transaksi Dicatat*
💰 Pengeluaran: Rp 25.000
📁 Kategori: Makanan
📝 Makan siang
📅 2026-08-05
```

**daily_report:**
```
📅 *Laporan Harian*
💚 Pemasukan: Rp 0
🔴 Pengeluaran: Rp 125.000
📊 Selisih: Rp -125.000
```

**greeting:**
```
👋 Halo, *Ardiansyah*!

Saya FinTrack AI, asisten keuangan pribadi Anda.
Ketik /help untuk melihat yang bisa saya lakukan.
```

**ai_insight:**
```
📊 *Analisis Keuangan Anda*

1. 🔴 Pengeluaran makanan meningkat 20% minggu ini...
2. ✅ Rasio tabungan bulan ini: 35%...
...
```

---

## 9. Error Handling

### Error Trigger
- Menangkap error dari **semua node** dalam workflow secara otomatis
- Mengirim notifikasi ke `TELEGRAM_ADMIN_CHAT_ID`
- Pesan error berisi: nama node, pesan error, execution ID

### continueOnFail
Node-node berikut menggunakan `continueOnFail: true`:
- 📚 Load Prompt dari Laravel
- 🧠 Load Memory dari Laravel
- ⚡ Execute CRUD Intent
- 📊 Execute Report Intent
- 🔧 Execute System Intent
- 📦 Fetch AI Combined Data

### Error pada Groq
Jika Groq gagal parse JSON → fallback ke `intent: "unknown"`, `message: "Maaf..."`.

### Error pada Laravel API
Jika `/api/bot/execute` mengembalikan `success: false` → Format Response menampilkan pesan error yang user-friendly: `❌ *Gagal memproses permintaan*\n<pesan error>`.

---

## 10. Pengembangan Lanjutan

### Menambah Intent Baru

1. **Di Laravel** — daftarkan di `IntentDispatcherService.php`:
   ```php
   'new_intent' => \App\Intents\Module\NewIntent::class,
   ```
2. **Di n8n** — tambahkan case baru di `📝 Format Response`:
   ```javascript
   case 'new_intent':
     replyText = `✅ *Hasil*\n${data?.field || '-'}`;
     break;
   ```
3. **Di system prompt** — tambahkan ke daftar intent yang tersedia di `🛠️ Build AI Request`.

### Menambah Memory Konteks

Push data ke `/api/memories` dari n8n scheduler:
```json
{
  "key": "user_monthly_income",
  "value": "5000000",
  "type": "number",
  "active": true
}
```

### Menambah Scheduled Triggers

Buat workflow terpisah dengan Cron Trigger untuk:
- Pengiriman laporan harian otomatis
- Pengecekan tagihan jatuh tempo
- Generasi AI insight mingguan

Lalu inject hasilnya ke Telegram via bot API atau Notification endpoint `/api/notifications`.

---

## 📊 Referensi Cepat

### Endpoint yang Digunakan Workflow

| Node | Method | Endpoint |
|------|--------|----------|
| Load Prompt | GET | `/api/prompts?per_page=50` |
| Load Memory | GET | `/api/memories?per_page=100` |
| Execute CRUD | POST | `/api/bot/execute` |
| Execute Report | POST | `/api/bot/execute` |
| Execute System | POST | `/api/bot/execute` |
| Fetch AI Data | GET | `/api/combined-data` |

### Groq Model yang Digunakan

| Node | Model | Temperature | Max Tokens |
|------|-------|-------------|------------|
| 🤖 Groq Intent Router | `llama-3.3-70b-versatile` | 0.1 | 512 |
| ✨ AI Response Formatter | `llama-3.3-70b-versatile` | 0.3 | 800 |

---

*Dokumentasi ini merupakan bagian dari FinTrack AI OS — dibangun di atas Laravel 12 + n8n + Groq.*
