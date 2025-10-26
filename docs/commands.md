# Foydali Docker komandalar

| Maqsad | Komanda |
|--------|----------|
| Barcha konteynerlarni ko‘rish | `docker ps -a` |
| Konteynerni to‘xtatish | `docker stop <id>` |
| Konteynerni ishga tushirish | `docker start <id>` |
| Imagedan tozalash | `docker system prune -a` |
| Loglarni ko‘rish | `docker compose logs -f` |
| Artisan ichiga kirish | `docker compose exec app bash` |
| Composer install | `docker compose exec app composer install` |
