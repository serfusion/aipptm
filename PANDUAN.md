# Panduan Website AIPPTM

Website utama **www.aipptm.org** (WordPress) dan jurnal **journal.aipptm.org** (OJS 3.5),
keduanya di satu server Google Cloud, dengan email dan login Google untuk domain `aipptm.org`.

> Tata letak beranda meniru *struktur* helixsociety.org (menu dropdown, banner, kartu
> informasi, tiga blok gambar-teks, pengurus, sambutan ketua, logo anggota, footer berwarna),
> tetapi teks, gambar, logo, warna (putih + merah, footer merah), dan font semuanya baru.
> Semua gambar di tema hanyalah **placeholder** buatan sendiri yang bisa diganti dari editor.

## Isi paket

| File | Kegunaan |
|---|---|
| `aipptm-tema.zip` | Tema WordPress AIPPTM (diunggah lewat Tampilan → Tema, atau dipasang otomatis oleh skrip) |
| `tema/aipptm/` | Isi tema yang sama dalam bentuk folder |
| `server/setup-server.sh` | Skrip pemasang server: Apache, PHP 8.3, MariaDB, WordPress, OJS 3.5.0-5, HTTPS, backup |
| `pratinjau-beranda.png` | Tampilan beranda hasil uji di WordPress 7.1.3 |
| `tutorial-media-sosial.html` + `panduan-gambar/` | Tutorial bergambar mengubah ikon media sosial |

## Gambaran sistem

```
Pengunjung ──► DNS aipptm.org ──► 1 VM Google Compute Engine (Jakarta, Ubuntu 24.04)
                                   ├─ Apache + PHP 8.3
                                   ├─ www.aipptm.org      → WordPress  ┐
                                   ├─ journal.aipptm.org  → OJS 3.5    ├─ MariaDB (di VM yang sama)
                                   └─ backup DB harian + snapshot disk ┘
Google Workspace ──► email @aipptm.org + "Masuk dengan Google" di WordPress dan OJS
```

---

## 1. Perkiraan biaya bulanan

Google Cloud *pay-as-you-go* menagih **VM per detik selama menyala, disk per GB, IP statis,
dan lalu lintas keluar** — bukan "per pemakaian database". Database sengaja dipasang di dalam VM
(bukan Cloud SQL) supaya tidak ada biaya database terpisah.

| Komponen | Perkiraan |
|---|---|
| VM **e2-medium** (2 vCPU, 4 GB RAM) di Jakarta — disarankan | ± US$33/bulan |
| atau VM **e2-small** (2 GB RAM) untuk mulai hemat | ± setengahnya |
| Disk 30 GB *balanced* + IP statis + snapshot | ± US$5–8/bulan |
| Google Workspace Business Starter | ± US$7–8,4 per pengguna/bulan |

Angka di atas perkiraan; cek harga terbaru di
[Kalkulator Harga Google Cloud](https://cloud.google.com/products/calculator) dan
[harga Google Workspace](https://workspace.google.com/pricing). VM bisa dinaik/turunkan
kapan saja (Stop VM → Edit → ubah *machine type* → Start).

## 2. Google Workspace (email @aipptm.org)

1. Daftar di [workspace.google.com](https://workspace.google.com), pilih **Business Starter**,
   masukkan domain `aipptm.org`.
2. Ikuti verifikasi domain (menambah record **TXT** di pengelola DNS domain).
3. Tambahkan record email yang diminta Google (biasanya **MX** `smtp.google.com`).
4. Agar email website tidak masuk spam, tambahkan juga:
   - **SPF** (TXT di `@`): `v=spf1 include:_spf.google.com ~all`
   - **DKIM**: Admin Console → Aplikasi → Google Workspace → Gmail → *Autentikasi email* →
     buat kunci → salin record TXT `google._domainkey`.
   - **DMARC** (TXT di `_dmarc`): `v=DMARC1; p=none; rua=mailto:admin@aipptm.org`
5. Buat akun, mis. `admin@aipptm.org`, dan grup gratis `info@aipptm.org` serta
   `noreply@aipptm.org` (untuk email otomatis website dan jurnal).

## 3. Google Cloud: project, anggaran, VM

> Login ke Google Cloud **dengan akun `admin@aipptm.org`**, supaya project berada di bawah
> organisasi aipptm.org.

1. Buka [console.cloud.google.com](https://console.cloud.google.com) → buat project
   `aipptm-web` → hubungkan **Billing**.
2. **Billing → Budgets & alerts** → buat anggaran (mis. US$60/bulan) dengan peringatan email
   50%, 90%, 100%. Ini mencegah tagihan kaget.
3. **Compute Engine → VM instances → Create instance**:
   - Name: `aipptm-server`, Region: `asia-southeast2 (Jakarta)`
   - Machine type: `e2-medium` (atau `e2-small`)
   - Boot disk → *Change*: **Ubuntu 24.04 LTS (x86/64)**, *Balanced persistent disk*, **30 GB**
   - Networking/Firewall: centang **Allow HTTP traffic** dan **Allow HTTPS traffic**
   - Klik **Create**.
4. **VPC network → IP addresses** → pada IP eksternal VM pilih **Promote to static IP**
   (agar IP tidak berubah). Catat IP ini.
5. **Compute Engine → Snapshots → Create snapshot schedule**: harian, simpan 14 hari, lalu
   pasang jadwal itu ke disk VM (**Disks → aipptm-server → Edit → Snapshot schedule**).

Catatan: Google Cloud memblokir port email 25 dari VM. Email website dikirim lewat
SMTP Google Workspace di port 587 (langkah 7).

## 4. DNS domain

Di pengelola DNS domain `aipptm.org`, tambahkan (ganti `IP_VM` dengan IP statis tadi):

| Tipe | Nama | Nilai |
|---|---|---|
| A | `@` | IP_VM |
| A | `www` | IP_VM |
| A | `journal` | IP_VM |
| A | `www.journal` | IP_VM |

Record MX/TXT dari Google Workspace tetap dibiarkan. Tunggu 5–60 menit sampai aktif.
Alamat jurnal resmi adalah `journal.aipptm.org`; `www.journal.aipptm.org` otomatis dialihkan ke sana.

## 5. Pasang server (sekali jalan)

1. Di daftar VM, klik tombol **SSH** → jendela terminal terbuka di browser.
2. Klik ikon **Upload file** (kanan atas) → unggah `setup-server.sh` dan `aipptm-tema.zip`.
3. Jalankan:

   ```bash
   sudo bash setup-server.sh --email admin@aipptm.org
   ```

   Proses ±5–10 menit. Skrip memasang Apache, PHP 8.3, MariaDB, WordPress terbaru (dicek
   checksum-nya), OJS 3.5.0-5 LTS, tema AIPPTM, HTTPS Let's Encrypt, backup database harian
   (`/var/backups/aipptm`, 14 hari), dan update keamanan otomatis.
4. Kata sandi database tersimpan di `/root/aipptm-kredensial.txt`
   (lihat dengan `sudo cat /root/aipptm-kredensial.txt`). Simpan salinannya di tempat aman.

Jika DNS belum aktif saat skrip dijalankan, HTTPS dilewati dengan peringatan. Setelah DNS aktif:
`sudo bash setup-server.sh --email admin@aipptm.org --ssl-only`.
Skrip aman dijalankan ulang.

## 6. WordPress (www.aipptm.org)

1. Buka `https://www.aipptm.org/wp-admin/install.php` → pilih **Bahasa Indonesia**.
2. Judul situs `AIPPTM`, nama pengguna (jangan `admin`), kata sandi kuat, email `admin@aipptm.org`.
3. **Pengaturan → Umum**: isi *Slogan* dengan nama lengkap AIPPTM (tampil di bawah logo),
   zona waktu *Jakarta*.
4. **Tampilan → Tema** → aktifkan **AIPPTM**. (Jika belum ada: **Tambahkan Tema → Unggah Tema** →
   pilih `aipptm-tema.zip`.)

Saat tema diaktifkan pertama kali, otomatis dibuat halaman Beranda, Tentang Kami, Pengurus,
Kegiatan, Keanggotaan, Kontak, Kebijakan Privasi, dan Berita; Beranda dijadikan halaman depan;
logo sementara dipasang. Halaman atau pengaturan yang sudah ada tidak ditimpa.

### Cara mengedit (tanpa koding)

| Ingin mengubah | Caranya |
|---|---|
| Teks/gambar beranda | **Laman → Semua Laman → Beranda → Sunting**. Klik teks lalu ketik. Klik gambar → **Ganti** → unggah foto. |
| Laman lain | **Laman → Semua Laman → (nama laman) → Sunting** |
| Berita | **Pos → Tambah Pos**; klik **Tetapkan gambar unggulan** agar tampil di beranda, lalu **Terbitkan** |
| Menu, header, footer, logo | **Tampilan → Editor → Pola** → *Header* / *Footer* (kelompok *Komponen Template*), atau **Tampilan → Editor → Navigasi** |
| Link LinkedIn/Instagram/Facebook/Email/YouTube | Lihat **Tutorial media sosial** di bawah (bergambar) |
| Warna merah | **Tampilan → Editor → Gaya → Warna → Palet** → ubah warna *Merah* |
| Tambah bagian siap pakai | Tombol **+** → tab **Pola** → kategori **AIPPTM** |

Gambar placeholder (ilustrasi, foto siluet, “LOGO Institusi”) sebaiknya diganti dengan foto
dan logo asli. Untuk logo resmi: klik logo di Header → **Ganti**.

### Tutorial media sosial (header & footer)

Versi bergambar lengkap ada di **`tutorial-media-sosial.html`** (buka dengan browser). Ringkasnya:

1. **Tampilan → Editor** → **Pola** → **Header** (kelompok *Komponen Template*) → klik gambar Header.
2. Klik ikon (mis. LinkedIn) **2 kali** → hapus isi lama → tempel alamat profil → tekan **Enter**.
3. Menambah ikon (mis. TikTok, WhatsApp): klik deretan ikon → tombol **+** → pilih layanannya.
4. Menghapus ikon: klik ikonnya → **Pilihan** (⋮) → **Hapus**. Mengubah urutan: **Geser ke kiri / kanan**.
5. Ukuran, label teks, dan "buka di jendela baru" ada di panel kanan tab **Pengaturan**;
   bentuk ikon dan **Warna ikon** di tab **Gaya**.
6. Klik **Simpan** (kanan atas). Ulangi untuk **Footer**.

| Layanan | Contoh alamat |
|---|---|
| LinkedIn | `https://www.linkedin.com/company/nama-akun` |
| Instagram | `https://www.instagram.com/namaakun` |
| Facebook | `https://www.facebook.com/namahalaman` |
| YouTube | `https://www.youtube.com/@namakanal` |
| Email | `mailto:info@aipptm.org` |
| WhatsApp | `https://wa.me/628123456789` (kode 62, tanpa 0 di depan) |

![Langkah 2: klik ikon dua kali lalu tempel alamat](panduan-gambar/sosmed-05.png)

Ikon tanpa alamat otomatis tidak ditampilkan. Di HP, ikon header disembunyikan agar rapi
(tetap tampil di footer).

### Login dengan Google (WordPress)

1. Google Cloud Console → **APIs & Services → OAuth consent screen**:
   - User type **External** (dipakai juga oleh OJS agar penulis dari luar bisa login).
   - Nama aplikasi `AIPPTM`, email dukungan `admin@aipptm.org`, domain `aipptm.org`.
   - Scope cukup bawaan (*openid, email, profile*), lalu **Publish app** (status *In production*).
2. **APIs & Services → Credentials → Create credentials → OAuth client ID** → *Web application*.
   *Authorized redirect URIs*: `https://www.aipptm.org/wp-login.php`. Simpan *Client ID* dan *Client secret*.
3. Di WordPress: **Plugin → Tambahkan Plugin** → cari **“Log in with Google”** (pembuat rtCamp) →
   Pasang → Aktifkan.
4. **Pengaturan → WP Google Login**: isi Client ID & Secret. Agar hanya staf AIPPTM yang bisa
   masuk, isi *Whitelisted domains* dengan `aipptm.org` dan aktifkan pendaftaran hanya jika
   memang perlu. Pengguna lama bisa login Google selama email WordPress-nya sama.

### Email dari website (formulir, reset kata sandi)

1. Google Admin Console → **Aplikasi → Google Workspace → Gmail → Perutean →
   SMTP relay service** → *Tambah*: izinkan hanya alamat di domain Anda, autentikasi
   **hanya alamat IP tertentu** = IP_VM, wajib TLS.
2. WordPress: **Plugin → Tambahkan Plugin** → pasang **WP Mail SMTP** → mailer *Other SMTP*:
   host `smtp-relay.gmail.com`, enkripsi TLS, port `587`, autentikasi **mati**,
   *From email* `noreply@aipptm.org`. Kirim email uji dari menu plugin.

## 7. OJS 3.5 (journal.aipptm.org)

1. Pastikan `https://journal.aipptm.org` sudah bergembok (HTTPS aktif), lalu buka alamat itu →
   wizard instalasi:
   - Bahasa: Bahasa Indonesia (+ English bila perlu)
   - Direktori berkas: `/var/www/ojs-files`
   - Database: driver **MariaDB**, host `localhost`, user `ojs_aipptm`, database `ojs_aipptm`,
     kata sandi dari `/root/aipptm-kredensial.txt`
   - Buat akun administrator OJS.
2. Setelah wizard selesai, kembali ke SSH dan jalankan:

   ```bash
   sudo bash setup-server.sh --ojs-finalize
   ```

   (memastikan `allowed_hosts` dan `base_url` https, mengaktifkan `force_ssl`, dan memasang cron
   tugas terjadwal OJS; salinan konfigurasi lama disimpan sebagai `config.inc.php.bak-TANGGAL`).
3. **Email OJS** — edit `/var/www/journal/config.inc.php` (`sudo nano ...`), bagian `[email]`:

   ```ini
   default = smtp
   smtp_server = smtp-relay.gmail.com
   smtp_port = 587
   smtp_auth = tls
   default_envelope_sender = noreply@aipptm.org
   force_default_envelope_sender = On
   force_dmarc_compliant_from = On
   ```

4. Buat jurnal: **Administrasi → Situs Web Hosting → Buat Jurnal** (mis. path `jurnal`).
5. **Login Google di OJS**: di jurnal → **Pengaturan → Website → Plugin → Galeri Plugin** →
   pasang **OpenID Authentication Plugin** (versi 5.1 untuk OJS 3.5) → aktifkan → **Pengaturan**:
   - Pilih provider **Google**, isi Client ID & Secret (boleh memakai OAuth client yang sama,
     tambahkan redirect URI-nya).
   - Salin **Redirect URL** yang ditampilkan plugin ke *Authorized redirect URIs* di Google Cloud.
     Jika Google menampilkan `redirect_uri_mismatch`, buka detail error: Google menunjukkan
     alamat persis yang diminta — tambahkan alamat itu apa adanya.
   - Sebaiknya tetap izinkan login biasa untuk akun admin sebagai cadangan.
6. Tampilan jurnal: **Pengaturan → Website → Tampilan** → tema *Default*, warna utama `#C1121F`
   dan unggah logo agar senada dengan website utama.

## 8. Perawatan rutin

- **Update**: WordPress & plugin dari menu *Dasbor → Pembaruan*. Untuk OJS, ikuti
  [panduan upgrade PKP](https://docs.pkp.sfu.ca/admin-guide/en/maintenance) dan buat snapshot disk dulu.
- **Backup**: snapshot disk harian (Google Cloud) + dump database harian di VM.
  Sesekali unduh salinan backup ke luar VM.
- **Keamanan**: gunakan kata sandi kuat + verifikasi 2 langkah Google; jangan bagikan isi
  `/root/aipptm-kredensial.txt`.
