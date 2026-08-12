# IBGK Sumsel — Deploy Production (Hostinger)

> **Domain:** `bgk-sumsel.com`  
> **PHP:** `/opt/alt/php84/usr/bin/php` (wajib ≥ 8.4, jangan pakai php83)  
> **Composer:** `/opt/alt/php84/usr/bin/php /usr/local/bin/composer` atau `composer2`  
> **SSH:** `ssh -p 65002 u380354370@193.203.173.241`  
> **Path server:** `/home/u380354370/domains/bgk-sumsel.com/public_html`

## Login admin (local / setelah seed)

- Email: `admin@ibgk.test`
- Password: `password`

cd /home/u380354370/domains/bgk-sumsel.com/public_html && \
/opt/alt/php84/usr/bin/php artisan db:seed --class=RoleSeeder --force && \
/opt/alt/php84/usr/bin/php artisan permission:cache-reset
---

## Sebelum push (di Mac / lokal)

Setiap ubah CSS, JS, atau Blade yang pakai Vite:

```bash
cd /Applications/MAMP/htdocs/ibgk
npm run build
git add public/build
git commit -m "Build frontend assets"
git push
```

Folder `public/build/` **ikut di git** — tidak perlu upload manual/rsync ke server.

---

## Deploy pertama kali (server)

```bash
cd /home/u380354370/domains/bgk-sumsel.com/public_html

# 1. Environment
cp .env-production .env
# Edit .env: DB_*, APP_KEY, MAIL_PASSWORD, APP_URL=https://www.bgk-sumsel.com

/opt/alt/php84/usr/bin/php artisan key:generate

# 2. Dependencies
/opt/alt/php84/usr/bin/php /usr/local/bin/composer install --no-dev --optimize-autoloader

# 3. Database
/opt/alt/php84/usr/bin/php artisan migrate --force

# 4. Filament Shield
/opt/alt/php84/usr/bin/php artisan shield:install admin --no-interaction
/opt/alt/php84/usr/bin/php artisan shield:generate --all --panel=admin --no-interaction
/opt/alt/php84/usr/bin/php artisan shield:super-admin --user=1 --panel=admin --no-interaction

# 5. Seed
/opt/alt/php84/usr/bin/php artisan db:seed --force

# 5b. Mitra & logo (wajib jika logo belum ada di server)
/opt/alt/php84/usr/bin/php artisan db:seed --class=MainSponsorSeeder --force
/opt/alt/php84/usr/bin/php artisan db:seed --class=PartnerLogoSeeder --force

# 6. Storage (wajib — symlink public/storage → storage/app/public)
/opt/alt/php84/usr/bin/php artisan storage:link

# 7. Cache production
/opt/alt/php84/usr/bin/php artisan optimize:clear
/opt/alt/php84/usr/bin/php artisan config:cache
/opt/alt/php84/usr/bin/php artisan route:cache
/opt/alt/php84/usr/bin/php artisan view:cache
/opt/alt/php84/usr/bin/php artisan filament:optimize
/opt/alt/php84/usr/bin/php artisan permission:cache-reset
```

**Document Root** di hPanel → arahkan ke folder `public/`.

**Log Viewer:** Admin → Pengaturan → Log Viewer (`/admin/logs`) — hanya `super_admin`.

---

## Update / redeploy (setelah git pull)

```bash
cd /home/u380354370/domains/bgk-sumsel.com/public_html
git pull

/opt/alt/php84/usr/bin/php /usr/local/bin/composer install --no-dev --optimize-autoloader
/opt/alt/php84/usr/bin/php /usr/local/bin/composer dump-autoload -o
/opt/alt/php84/usr/bin/php artisan migrate --force
/opt/alt/php84/usr/bin/php artisan shield:generate --all --panel=admin --no-interaction

# Storage & logo (logo TIDAK ikut git — jalankan jika gambar/upload hilang)
/opt/alt/php84/usr/bin/php artisan storage:link
/opt/alt/php84/usr/bin/php artisan db:seed --class=PartnerLogoSeeder --force

# Mitra showcase / sponsor utama (jika ada migration mitra baru)
/opt/alt/php84/usr/bin/php artisan db:seed --class=MainSponsorSeeder --force

/opt/alt/php84/usr/bin/php artisan optimize:clear
/opt/alt/php84/usr/bin/php artisan config:cache
/opt/alt/php84/usr/bin/php artisan route:cache
/opt/alt/php84/usr/bin/php artisan view:cache
/opt/alt/php84/usr/bin/php artisan filament:optimize
/opt/alt/php84/usr/bin/php artisan permission:cache-reset
```

`public/build/` sudah ikut `git pull` — **tidak perlu** `npm run build` di server.

> **Catatan logo:** file upload & logo seeder ada di `storage/app/public/` dan **tidak di-commit ke git**. Setelah deploy baru atau server kosong, wajib `storage:link` + `PartnerLogoSeeder`. Upload via Admin juga tersimpan di folder yang sama — backup manual jika perlu.

---

## Cek cepat

```bash
/opt/alt/php84/usr/bin/php -v
/opt/alt/php84/usr/bin/php artisan migrate:status
/opt/alt/php84/usr/bin/php artisan about
curl -sI https://bgk-sumsel.com/build/manifest.json | head -1

# Cek storage & logo
ls -la public/storage
ls storage/app/public/partners/logos/ | head
curl -sI https://bgk-sumsel.com/storage/partners/logos/dinas-pendidikan-provinsi-sumsel.svg | head -3
```

Harus dapat **HTTP/2 200** (atau `HTTP/1.1 200`) untuk URL logo. Kalau **404**, jalankan `storage:link` dan `PartnerLogoSeeder`.

---

## Cron (jika pakai scheduler / queue)

```bash
* * * * * /opt/alt/php84/usr/bin/php /home/u380354370/domains/bgk-sumsel.com/public_html/artisan schedule:run >> /dev/null 2>&1
```

---

## Troubleshooting

| Masalah | Solusi |
|--------|--------|
| **Homepage 500, admin/login OK** | `public/build/manifest.json` belum ada — lokal: `npm run build`, commit & push `public/build/`, server: `git pull` |
| Manifest di `public/build/build/` | Salah path — file harus di `public/build/manifest.json`, bukan nested |
| `Table elections doesn't exist` saat artisan | Deploy `AppServiceProvider` terbaru, lalu `migrate --force` |
| 403 / 500 setelah upload | Cek `.htaccess`, permission `storage/` & `bootstrap/cache` (775) |
| **Logo/upload tidak muncul (admin & blade)** | 1) `storage:link` 2) `db:seed --class=PartnerLogoSeeder --force` 3) cek `APP_URL` di `.env` = domain aktif (`https://bgk-sumsel.com`) 4) `config:cache` |
| Logo sebagian rusak, sebagian OK | File hilang di server — jalankan ulang `PartnerLogoSeeder`; upload admin perlu backup `storage/app/public/` |
| `Call to undefined function safe_url()` | Deploy `AppServiceProvider` terbaru + `composer dump-autoload -o` + `optimize:clear` |
| Halaman kemitraan / sponsor tidak tampil | `migrate --force` + `MainSponsorSeeder` + set `SITE_UNDER_DEVELOPMENT=false` jika ingin publik tanpa login |
| Shield: user tidak bisa login admin | `shield:super-admin --user=ID --panel=admin` |
| `shield:generate` prohibited | Deploy `AppServiceProvider` terbaru, lalu `optimize:clear` |
