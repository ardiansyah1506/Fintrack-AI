# 🌟 FinTrack AI — Personal Finance Operating System

**FinTrack AI** adalah sistem manajemen keuangan pribadi berbasis AI yang mengintegrasikan **Laravel 12**, **n8n**, **Groq AI**, dan **Telegram Bot** dalam satu ekosistem terpadu.

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php)](https://php.net)
[![n8n](https://img.shields.io/badge/n8n-Workflow-EA4B71?style=flat)](https://n8n.io)
[![Groq](https://img.shields.io/badge/Groq-LLaMA_3.3-F55036?style=flat)](https://groq.com)

---

## 📐 Arsitektur Sistem

```
┌──────────────┐     ┌──────────────┐     ┌──────────────┐     ┌──────────────┐
│   Telegram   │ ──► │     n8n      │ ──► │  Groq AI     │ ──► │   Laravel    │
│  (Chat UI)   │ ◄── │  (Workflow)  │ ◄── │ (LLaMA 3.3)  │ ◄── │(Control Ctr) │
└──────────────┘     └──────────────┘     └──────────────┘     └──────────────┘
```

| Komponen | Peran |
|----------|-------|
| **Laravel 12** | Control Center, REST API, Business Logic, Database, Web UI |
| **n8n** | Orchestration Layer, Workflow Engine, Scheduler |
| **Groq AI** | NLP Intent Extraction, Response Generation |
| **Telegram** | Antarmuka percakapan natural language |

---

## 📁 Struktur Dokumentasi

| File | Deskripsi |
|------|-----------|
| [`API_DOCUMENTATION.md`](API_DOCUMENTATION.md) | Dokumentasi lengkap REST API & semua endpoint |
| [`CONTROL_CENTER_DOCS.md`](CONTROL_CENTER_DOCS.md) | Dokumentasi Control Center, arsitektur, & modul |
| [`API_ROUTES_DOCS.md`](API_ROUTES_DOCS.md) | Ringkasan routes web & API |
| [`N8N_WORKFLOW_DOCS.md`](N8N_WORKFLOW_DOCS.md) | **Dokumentasi n8n Telegram Bot Workflow** |
| [`fintrack_ai_telegram_bot_workflow.json`](fintrack_ai_telegram_bot_workflow.json) | File workflow n8n siap import |

---

## 🚀 Quick Start

### Prerequisites

- PHP 8.2+, Composer, MySQL
- Node.js (untuk Vite assets)
- n8n (cloud/self-hosted)
- Groq API Key
- Telegram Bot Token

### Installation

```bash
# 1. Clone & install dependencies
git clone <repo-url> fintrack-ai
cd fintrack-ai
composer install

# 2. Environment setup
cp .env.example .env
php artisan key:generate

# 3. Database
php artisan migrate --seed

# 4. Assets (development)
npm install && npm run dev

# 5. Run server
php artisan serve
```

### Konfigurasi `.env` Penting

```env
APP_NAME="FinTrack AI"
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_DATABASE=fintrack_ai

# n8n Integration
N8N_WEBHOOK_URL=https://n8n.your-domain.com/webhook/fintrack
TELEGRAM_BOT_TOKEN=your_telegram_bot_token
GROQ_API_KEY=gsk_...
```

---

## 🏗️ Stack Teknologi

| Layer | Teknologi |
|-------|-----------|
| Framework | Laravel 12 |
| Database | MySQL 8.x |
| Frontend | Blade, Tailwind CSS (CDN), Alpine.js (CDN), Chart.js |
| AI Model | Groq — LLaMA 3.3 70B Versatile |
| Workflow | n8n (self-hosted/cloud) |
| Bot | Telegram Bot API |
| Pattern | Clean Architecture, Repository Pattern, Service Layer |

---

## 📡 API Overview

Base URL: `https://your-domain.com/api`

| Resource | Endpoint |
|----------|----------|
| Bot Execute (n8n webhook) | `POST /api/bot/execute` |
| Transactions | `GET\|POST\|PUT\|DELETE /api/transactions` |
| Categories | `GET\|POST\|PUT\|DELETE /api/categories` |
| Budgets | `GET\|POST\|PUT\|DELETE /api/budgets` |
| Reminders | `GET\|POST\|PUT\|DELETE /api/reminders` |
| Bills | `GET\|POST\|PUT\|DELETE /api/bills` |
| Saving Goals | `GET\|POST\|PUT\|DELETE /api/saving-goals` |
| Reports | `GET /api/report/daily\|weekly\|monthly` |
| Dashboard | `GET /api/dashboard` |
| Statistics | `GET /api/statistics` |
| AI Memories | `GET\|POST /api/memories` |
| Prompts | `GET\|POST /api/prompts` |
| Combined Data | `GET /api/combined-data` |

**Format Response Standar:**
```json
{
    "success": true,
    "intent": "create_transaction",
    "resource": "transaction",
    "status": "success",
    "message": "Transaksi berhasil dicatat.",
    "data": { ... }
}
```

Lihat [`API_DOCUMENTATION.md`](API_DOCUMENTATION.md) untuk dokumentasi lengkap.

---

## 🤖 Telegram Bot

Bot mendukung 38+ intent dalam 8 modul:

| Modul | Contoh Perintah |
|-------|----------------|
| Transaksi | "catat pengeluaran makan 25rb" |
| Laporan | "laporan bulan ini", "laporan hari ini" |
| Budget | "buat budget makan 1jt per bulan" |
| Pengingat | "ingatkan saya bayar listrik tgl 5" |
| Tabungan | "buat target liburan 5jt" |
| AI Insight | "analisis keuangan saya" |
| Prediksi | "prediksi pengeluaran bulan depan" |
| Rekomendasi | "tips hemat untuk saya" |

Import `fintrack_ai_telegram_bot_workflow.json` ke n8n untuk memulai.
Lihat [`N8N_WORKFLOW_DOCS.md`](N8N_WORKFLOW_DOCS.md) untuk panduan setup lengkap.

---

## 🔐 Lisensi

FinTrack AI — Personal Finance Operating System.
Dibangun dengan ❤️ menggunakan Laravel 12.
