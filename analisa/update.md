# IBGK Sumsel — Deploy Production (Hostinger)

> **PHP:** `/opt/alt/php84/usr/bin/php` (wajib ≥ 8.4, jangan pakai php83)  
> **Composer:** `/opt/alt/php84/usr/bin/php /usr/local/bin/composer` atau `composer2`

## Login admin (local / setelah seed)

- Email: `admin@ibgk.test`
- Password: `password`

---

## Deploy pertama kali

Masuk ke folder project di server (contoh: `~/domains/ibgksumsel.or.id/` atau `public_html/..`).

```bash
# 1. Environment
cp .env-production .env
# Edit .env: DB_*, APP_KEY, MAIL_PASSWORD

/opt/alt/php84/usr/bin/php artisan key:generate

# 2. Dependencies
/opt/alt/php84/usr/bin/php /usr/local/bin/composer install --no-dev --optimize-autoloader

# 3. Database
/opt/alt/php84/usr/bin/php artisan migrate --force

# 4. Filament Shield (roles & permissions)
/opt/alt/php84/usr/bin/php artisan shield:install admin --no-interaction
/opt/alt/php84/usr/bin/php artisan shield:generate --all --panel=admin --no-interaction
/opt/alt/php84/usr/bin/php artisan shield:super-admin --user=1 --panel=admin --no-interaction

# 5. Seed (opsional — data awal)
/opt/alt/php84/usr/bin/php artisan db:seed --force

# 6. Storage & assets
/opt/alt/php84/usr/bin/php artisan storage:link
npm ci && npm run build   # jalankan di local/CI jika server tanpa Node

# 7. Cache production
/opt/alt/php84/usr/bin/php artisan optimize:clear
/opt/alt/php84/usr/bin/php artisan config:cache
/opt/alt/php84/usr/bin/php artisan route:cache
/opt/alt/php84/usr/bin/php artisan view:cache
/opt/alt/php84/usr/bin/php artisan filament:optimize
/opt/alt/php84/usr/bin/php artisan permission:cache-reset
```

**Document Root** di hPanel → arahkan ke folder `public/`.

---

## Update / redeploy (setelah git pull)

```bash
/opt/alt/php84/usr/bin/php /usr/local/bin/composer install --no-dev --optimize-autoloader
/opt/alt/php84/usr/bin/php artisan migrate --force
/opt/alt/php84/usr/bin/php artisan shield:generate --all --panel=admin --no-interaction
/opt/alt/php84/usr/bin/php artisan optimize:clear
/opt/alt/php84/usr/bin/php artisan config:cache
/opt/alt/php84/usr/bin/php artisan route:cache
/opt/alt/php84/usr/bin/php artisan view:cache
/opt/alt/php84/usr/bin/php artisan filament:optimize
```

---

## Cek cepat

```bash
/opt/alt/php84/usr/bin/php -v
/opt/alt/php84/usr/bin/php artisan migrate:status
/opt/alt/php84/usr/bin/php artisan about
```

---

## Cron (jika pakai scheduler / queue)

```bash
* * * * * /opt/alt/php84/usr/bin/php /home/u380354370/domains/ibgksumsel.or.id/artisan schedule:run >> /dev/null 2>&1
```

Sesuaikan path `artisan` dengan lokasi project di server.

---

## Troubleshooting

| Masalah | Solusi |
|--------|--------|
| `Table elections doesn't exist` saat artisan | Pastikan `AppServiceProvider` versi terbaru sudah di-deploy, lalu `migrate --force` |
| 403 / 500 setelah upload | Cek `.htaccess` root + `public/`, permission folder `storage` & `bootstrap/cache` (775) |
| Logo/upload tidak muncul | `storage:link` + pastikan `public/storage` ada |
| Shield: user tidak bisa login admin | `shield:super-admin --user=ID --panel=admin` |
| `shield:generate` prohibited | Deploy ulang `AppServiceProvider` terbaru, lalu `optimize:clear` |
