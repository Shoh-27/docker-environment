# 🚀 Multi-Project Docker Environment

Bu repository bir nechta loyihalar uchun yagona **Docker muhiti**ni yaratish maqsadida ishlab chiqilgan.  
Hozirda quyidagi loyhalar uchun konteynerlar tayyorlangan:

---

## 🧩 Mavjud loyihalar

| Loyiha nomi | Tavsif | Holat |
|--------------|---------|--------|
| **Trello Clone** | Laravel + React asosida Trello funksiyalarini o‘rganish va real-time task management tizimini yaratish uchun muhit. | ✅ Docker muhiti tayyor |
| **DataSyncHub** | Laravel + PostgreSQL + MongoDB integratsiyasi orqali multi-database konseptni o‘rganish loyihasi. | ✅ Docker muhiti tayyor |
| **DevMonitoring** | Laravel asosida tizim monitoring va developer faoliyatini kuzatish uchun backend struktura. | ✅ Docker muhiti tayyor |
| **EnvHive** | Docker’ga o‘xshash virtual muhit boshqaruv tizimi. | 🔜 Rejalashtirilgan |
| **Hosting Platform** | DigitalOcean’ga o‘xshash bulutli hosting platforma (SaaS shaklida). | 🔜 Rejalashtirilgan |
| **Freelancing Platform** | Ish topish va loyiha joylash tizimi (Upwork/Freelancer kloni). | 🔜 Rejalashtirilgan |

---

## ⚙️ Texnologiyalar

- **Backend:** Laravel 11 (PHP 8.3)  
- **Frontend:** React.js / Vite  
- **Database:** MySQL, PostgreSQL, MongoDB  
- **Tools:** Redis, phpMyAdmin, pgAdmin, Nginx  
- **Orchestration:** Docker & Docker Compose  

---

## 🧠 Maqsad

Ushbu repository orqali bir nechta real startup loyihalarning **Docker muhitlarini yagona joyda boshqarish**, izolyatsiya qilish va **dasturlash jarayonini avtomatlashtirish** maqsad qilingan.  
Har bir loyiha alohida konteynerda ishga tushadi, lekin umumiy `docker-network` orqali bog‘langan.

---

## 🔧 Ishga tushirish

```bash
# Muhitni ishga tushirish
docker compose up -d --build

# Konteynerlarni ko‘rish
docker ps

# Konteynerlarni to‘xtatish
docker compose down
```

##  📁 Tuzilma

docker-environment/
│
├── trello-clone/
│   ├── docker-compose.yml
│   ├── backend/ (Laravel)
│   └── frontend/ (React)
│
├── datasycnhub/│   
│   ├── docker-compose.yml
│   ├── backend/ (Laravel)
│   └── frontend/ (React)
│
├── devmonitoring/│
│   ├── docker-compose.yml
│   ├── backend/ (Laravel)
│   └── frontend/ (React)
│
└── README.md


