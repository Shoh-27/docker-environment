# 🐳 Docker Environment Setup

Bu repositoryda Shohrux tomonidan yaratilayotgan **6 ta asosiy loyiha** uchun yagona Docker muhit mavjud.  
Har bir loyiha **alohida branch**da joylashgan va o‘zining `docker-compose.yml`, `Dockerfile`, va `.env` konfiguratsiyasiga ega.

---

## 🚀 Loyihalar va branchlar

| Loyiha nomi | Branch nomi | Texnologiyalar |
|--------------|--------------|----------------|
| Trello Clone | `trello` | Laravel 11, PostgreSQL, Nginx, pgAdmin, React |
| Multi DB Laravel | `multi-db` | Laravel, MySQL + PostgreSQL |
| DevMonitoring | `devmonitoring` | Node.js, Prometheus, Grafana |
| Freelancing Platform | `freelance` | Laravel + React + Redis |
| Hosting Platform | `hosting` | Laravel + Docker-in-Docker |
| EnvHive | `envhive` | Full-stack env manager (Laravel + React + Nginx) |

---

## ⚙️ Ishga tushirish

1. Kerakli branchni tanla:
   ```bash
   git checkout trello
