# Panduan Website AIPPTM

Website utama **www.aipptm.org** memakai WordPress, jurnal **journal.aipptm.org** memakai OJS 3.5.
Keduanya berjalan di satu server Google Cloud, dengan email dan login Google untuk domain `aipptm.org`.

Tampilan website berwarna dasar putih dengan aksen merah dan footer merah. Susunan beranda:
banner utama, angka statistik, mozaik Sorotan (agenda, publikasi, layanan), sambutan Ketua Umum
dengan visi dan misi, direktori anggota PTM, divisi dan program kerja, publikasi, lalu berita.
Gambar bawaan tema hanyalah contoh dan bisa diganti langsung dari editor.

## Isi paket

| File | Kegunaan |
|---|---|
| `aipptm-tema.zip` | Tema WordPress AIPPTM, diunggah lewat Tampilan › Tema atau dipasang otomatis oleh skrip |
| `tema/aipptm/` | Isi tema yang sama dalam bentuk folder |
| `server/setup-server.sh` | Skrip pemasang server: Apache, PHP 8.3, MariaDB, WordPress, OJS 3.5, HTTPS, backup |
| `pratinjau-beranda.png` | Tampilan beranda hasil uji di WordPress 7.1.3 |
| `tutorial-media-sosial.html` dan `panduan-gambar/` | Tutorial bergambar mengubah ikon media sosial |

## Gambaran sistem

| Bagian | Isi |
|---|---|
| Server | 1 VM Google Compute Engine di Jakarta, Ubuntu 24.04, Apache dan PHP 8.3 |
| www.aipptm.org | WordPress |
| journal.aipptm.org | OJS 3.5 |
| Database | MariaDB di VM yang sama, dipakai WordPress dan OJS |
| Cadangan | Dump database harian di VM dan snapshot disk harian di Google Cloud |
| Email dan login | Google Workspace untuk email @aipptm.org dan tombol "Masuk dengan Google" |

---

## 1. Perkiraan biaya bulanan

Google Cloud *pay as you go* menagih VM per detik selama menyala, disk per GB, IP statis, dan
lalu lintas keluar. Tidak ada tagihan "per pemakaian database", karena database sengaja dipasang
di dalam VM (bukan Cloud SQL).

| Komponen | Perkiraan |
|---|---|
| VM **e2-medium** (2 vCPU, 4 GB RAM) di Jakarta, disarankan | sekitar US$33 per bulan |
| atau VM **e2-small** (2 GB RAM) untuk mulai hemat | sekitar separuhnya |
| Disk 30 GB *balanced*, IP statis, dan snapshot | sekitar US$5 sampai 8 per bulan |
| Google Workspace Business Starter | sekitar US$7 sampai 8,4 per pengguna per bulan |

Angka di atas perkiraan. Cek harga terbaru di
[Kalkulator Harga Google Cloud](https://cloud.google.com/products/calculator) dan
[harga Google Workspace](https://workspace.google.com/pricing). Ukuran VM bisa dinaikkan atau
diturunkan kapan saja: Stop VM, Edit, ubah *machine type*, lalu Start.

## 2. Google Workspace (email @aipptm.org)

1. Daftar di [workspace.google.com](https://workspace.google.com), pilih **Business Starter**,
   lalu masukkan domain `aipptm.org`.
2. Ikuti verifikasi domain (menambah record **TXT** di pengelola DNS domain).
3. Tambahkan record email yang diminta Google (biasanya **MX** `smtp.google.com`).
4. Agar email dari website tidak masuk spam, tambahkan juga:
   * **SPF** (TXT di `@`): `v=spf1 include:_spf.google.com ~all`
   * **DKIM**: Admin Console › Aplikasi › Google Workspace › Gmail › *Autentikasi email*,
     buat kunci, lalu salin record TXT `google._domainkey`.
   * **DMARC** (TXT di `_dmarc`): `v=DMARC1; p=none; rua=mailto:admin@aipptm.org`
5. Buat akun `admin@aipptm.org`. Buat juga grup gratis `info@aipptm.org` (alamat yang
   tampil di website) dan `noreply@aipptm.org` (pengirim email otomatis website dan jurnal).

## 3. Google Cloud: project, anggaran, VM

Masuk ke Google Cloud **dengan akun `admin@aipptm.org`** supaya project berada di bawah
organisasi aipptm.org.

1. Buka [console.cloud.google.com](https://console.cloud.google.com), buat project
   `aipptm-web`, lalu hubungkan **Billing**.
2. **Billing › Budgets & alerts**: buat anggaran (misalnya US$60 per bulan) dengan peringatan
   email di 50%, 90%, dan 100%. Ini mencegah tagihan kaget.
3. **Compute Engine › VM instances › Create instance**:
   * Name: `aipptm-server`, Region: `asia-southeast2 (Jakarta)`
   * Machine type: `e2-medium` (atau `e2-small`)
   * Boot disk, klik *Change*: **Ubuntu 24.04 LTS (x86/64)**, *Balanced persistent disk*, **30 GB**
   * Networking/Firewall: centang **Allow HTTP traffic** dan **Allow HTTPS traffic**
   * Klik **Create**.
4. **VPC network › IP addresses**: pada IP eksternal VM pilih **Promote to static IP** agar IP
   tidak berubah. Catat IP ini.
5. **Compute Engine › Snapshots › Create snapshot schedule**: harian, simpan 14 hari, lalu
   pasang jadwal itu ke disk VM (**Disks › aipptm-server › Edit › Snapshot schedule**).

Google Cloud memblokir port email 25 dari VM. Karena itu email website dikirim lewat SMTP
Google Workspace di port 587 (lihat bagian 6, *Email dari website*).

## 4. DNS domain

Di pengelola DNS domain `aipptm.org`, tambahkan record berikut (ganti `IP_VM` dengan IP statis tadi):

| Tipe | Nama | Nilai |
|---|---|---|
| A | `@` | IP_VM |
| A | `www` | IP_VM |
| A | `journal` | IP_VM |
| A | `www.journal` | IP_VM |

Record MX dan TXT dari Google Workspace tetap dibiarkan. Biasanya aktif dalam 5 sampai 60 menit.
Alamat jurnal resmi adalah `journal.aipptm.org`; `www.journal.aipptm.org` otomatis dialihkan ke sana.

## 5. Pasang server (sekali jalan)

1. Di daftar VM, klik tombol **SSH**. Jendela terminal terbuka di browser.
2. Klik ikon **Upload file** (kanan atas), lalu unggah `setup-server.sh` dan `aipptm-tema.zip`.
3. Jalankan:

   ```bash
   sudo bash setup-server.sh --email admin@aipptm.org
   ```

   Prosesnya sekitar 5 sampai 10 menit. Skrip memasang Apache, PHP 8.3, MariaDB, WordPress
   terbaru (checksum dicek), OJS 3.5 LTS, tema AIPPTM, HTTPS Let's Encrypt, backup database
   harian (`/var/backups/aipptm`, disimpan 14 hari), dan update keamanan otomatis.
4. Kata sandi database tersimpan di `/root/aipptm-kredensial.txt`
   (lihat dengan `sudo cat /root/aipptm-kredensial.txt`). Simpan salinannya di tempat aman.

Jika DNS belum aktif saat skrip dijalankan, HTTPS dilewati dengan peringatan. Setelah DNS aktif,
jalankan `sudo bash setup-server.sh --email admin@aipptm.org --ssl-only`.
Skrip aman dijalankan ulang.

## 6. WordPress (www.aipptm.org)

1. Buka `https://www.aipptm.org/wp-admin/install.php` dan pilih **Bahasa Indonesia**.
2. Judul situs `AIPPTM`, nama pengguna (jangan `admin`), kata sandi kuat, email `admin@aipptm.org`.
3. **Pengaturan › Umum**: atur zona waktu ke *Jakarta*.
4. **Tampilan › Tema**: aktifkan **AIPPTM**. Jika belum ada, klik **Tambahkan Tema › Unggah Tema**
   lalu pilih `aipptm-tema.zip`.

Saat tema pertama kali diaktifkan, laman berikut dibuat otomatis: Beranda, Profil AIPPTM,
Pengurus, Direktori Anggota PTM, Cara Bergabung, Bidang & Program Kerja, Jurnal & Publikasi AIPPTM,
Agenda Kegiatan, Kontak, Kebijakan Privasi, dan Berita & Agenda. Beranda dijadikan halaman depan,
Slogan diisi "Asosiasi Ilmu Pemerintahan Perguruan Tinggi Muhammadiyah" (tampil di bawah tulisan
AIPPTM di header), dan logo AIPPTM dipasang sebagai logo situs serta ikon tab browser. Laman atau pengaturan yang sudah ada tidak ditimpa.

### Cara mengedit (tanpa koding)

| Ingin mengubah | Caranya |
|---|---|
| Teks di beranda | **Laman › Semua Laman › Beranda › Sunting**. Klik teksnya lalu ketik. Klik **Simpan** setelah selesai. |
| Foto di beranda | Klik fotonya, lalu **Gantikan** di toolbar, pilih **Unggah** (foto baru) atau **Buka Pustaka Media** (foto yang sudah ada). |
| Foto besar di kotak Agenda | Klik teks di kotak itu, lalu klik **Sampul** pada baris jejak di bawah layar, kemudian **Gantikan**. |
| Laman lain | **Laman › Semua Laman ›** pilih lamannya **› Sunting** |
| Berita | **Pos › Tambah Pos**. Klik **Tetapkan gambar unggulan** agar foto tampil di beranda, lalu **Terbitkan**. |
| Menu, header, footer | **Tampilan › Editor › Pola**, lalu **Header** atau **Footer**. Menu diubah dengan mengklik menunya di dalam Header. |
| Ikon media sosial | Lihat **Tutorial media sosial** di bawah (bergambar) |
| Warna merah | **Tampilan › Editor › Gaya › Warna › Palet**, lalu ubah warna *Merah* |
| Menambah bagian siap pakai | Tombol **+** › tab **Pola** › kategori **AIPPTM** |
| Jurnal afiliasi | **Laman › Jurnal & Publikasi AIPPTM › Sunting**. Untuk jurnal baru, pilih salah satu kartu jurnal › **⋮ › Gandakan**, lalu ganti sampul (klik gambar › **Gantikan**), nama, penerbit, ISSN, tautan, dan tulisan **SINTA 1** sampai **SINTA 6**. Warna lencana dan tombol saring mengikuti tulisannya otomatis. |
| Direktori anggota | **Laman › Direktori Anggota PTM › Sunting**, gandakan kartu lalu ganti isinya. Tulis peringkat persis: *Unggul*, *Baik Sekali*, *Baik*, *A*, *B*, *C*, *Terakreditasi*, atau *Dalam Proses*; warnanya menyesuaikan sendiri. |
| Linimasa sejarah | **Laman › Profil AIPPTM › Sunting**, gandakan salah satu tahap lalu ganti tahun, judul, isi, dan fasenya. Nomor 01, 02, dan seterusnya diketik manual. |
| Buku elektronik | Di laman **Jurnal & Publikasi AIPPTM**, di bawah judul *Buku Elektronik Asosiasi*, ketik `/file` lalu pilih PDF dari komputer. |

Menu jangan diubah lewat *Tampilan › Editor › Navigasi*, karena layar itu membuat menu baru yang
tidak dipakai header.

Bagian beranda yang dikunci susunannya (mozaik Sorotan) tetap bisa diubah teks, tautan, dan
fotonya. Kuncinya hanya mencegah kotak bergeser atau terhapus tanpa sengaja.

Jangan menempel kode HTML utuh (berisi `<html>`, `<style>`, atau `<script>`) ke blok *HTML Khusus*.
CSS dari tempelan seperti itu ikut berlaku ke seluruh halaman dan bisa merusak tampilan, misalnya
memunculkan celah putih di bawah header. Pakai pola siap pakai di kategori **AIPPTM**.

### Memperbarui tema

1. Unduh `aipptm-tema.zip` terbaru dari repositori ini.
2. **Tampilan › Tema › Tambahkan Tema › Unggah Tema**, pilih zip, klik **Pasang Sekarang**, lalu
   **Ganti yang terpasang dengan yang diunggah**.

Header, footer, menu, dan isi laman yang sudah diubah lewat editor tetap dipertahankan. Versi 1.9.0
sekali jalan merapikan laman Beranda, Profil, Pengurus, Direktori, Bidang & Program, Publikasi, dan
Kontak di aipptm.org menjadi blok tema (termasuk Jurnal Afiliasi), tetapi hanya untuk laman yang belum
diubah lagi sejak 1 November 2026. Isi lama tiap laman tetap bisa dipulihkan dari **Revisi** di panel
kanan editor laman.

### Logo dan ikon situs

Lambang AIPPTM sudah terpasang di header, footer, dan tab browser. Tulisan AIPPTM dan nama
lengkap di sebelahnya diambil dari *Judul Situs* dan *Slogan* di **Pengaturan › Umum**.

Bila suatu saat lambang perlu diganti:

1. **Tampilan › Editor › Pola › Header**, klik logonya, lalu **Gantikan** di toolbar.
   Pakai PNG berlatar transparan, minimal 512 × 512 piksel. Logo di footer ikut berganti.
2. Klik **Simpan**.
3. Ikon tab browser: **Pengaturan › Umum › Ikon Situs**.

### Tutorial media sosial (header dan footer)

Versi bergambar lengkap ada di **`tutorial-media-sosial.html`** (buka dengan browser). Ringkasnya:

1. **Tampilan › Editor › Pola › Header**, lalu klik gambar Header.
2. Klik ikonnya (misalnya LinkedIn) sampai muncul kotak alamat putih. Bila deretan ikon bergeser
   setelah klik pertama, klik lagi ikon yang sama. Tempel alamat profil, lalu tekan **Enter**.
3. Menambah ikon (misalnya TikTok atau WhatsApp): klik **Ikon Sosial** di baris jejak paling bawah
   layar, klik tombol **+**, ketik nama layanannya, lalu isi alamatnya.
4. Menghapus ikon: klik ikonnya, tombol **Pilihan** (⋮), lalu **Hapus**. Mengubah urutan: tombol
   **Geser ke kiri** atau **Geser ke kanan**.
5. Ukuran ikon, teks label, dan "Buka tautan di jendela baru" ada di panel kanan tab
   **Pengaturan** (roda gigi). Bentuk ikon dan **Warna ikon** ada di tab **Gaya**.
6. Klik **Simpan** (kanan atas). Ulangi langkah yang sama untuk **Footer**.

| Layanan | Contoh alamat |
|---|---|
| LinkedIn | `https://www.linkedin.com/company/nama-akun` |
| Instagram | `https://www.instagram.com/namaakun` |
| Facebook | `https://www.facebook.com/namahalaman` |
| YouTube | `https://www.youtube.com/@namakanal` |
| Email | `mailto:info@aipptm.org` |
| WhatsApp | `https://wa.me/628123456789` (kode negara 62, tanpa 0 di depan) |

![Langkah 5: klik ikon sampai kotak alamat muncul, lalu tempel alamat](panduan-gambar/sosmed-05.png)

Ikon yang alamatnya masih kosong tidak tampil di website. Di layar HP, ikon di header
disembunyikan agar header tetap rapi; ikon tetap tampil di footer.

### Login dengan Google (WordPress)

1. Google Cloud Console › **APIs & Services › OAuth consent screen**:
   * User type **External** (dipakai juga oleh OJS agar penulis dari luar bisa login).
   * Nama aplikasi `AIPPTM`, email dukungan `admin@aipptm.org`, domain `aipptm.org`.
   * Scope cukup bawaan (*openid, email, profile*), lalu **Publish app** (status *In production*).
2. **APIs & Services › Credentials › Create credentials › OAuth client ID**, pilih *Web application*.
   *Authorized redirect URIs*: `https://www.aipptm.org/wp-login.php`. Simpan *Client ID* dan *Client secret*.
3. Di WordPress: **Plugin › Tambahkan Plugin**, cari **"Log in with Google"** (pembuat rtCamp),
   lalu Pasang dan Aktifkan.
4. **Pengaturan › WP Google Login**: isi Client ID dan Secret. Agar hanya staf AIPPTM yang bisa
   masuk, isi *Whitelisted domains* dengan `aipptm.org`, dan aktifkan pendaftaran hanya bila
   memang perlu. Pengguna lama tetap bisa login dengan Google selama email WordPress-nya sama.

### Email dari website (formulir, reset kata sandi)

1. Google Admin Console › **Aplikasi › Google Workspace › Gmail › Perutean ›
   SMTP relay service**, klik *Tambah*: izinkan hanya alamat di domain Anda, autentikasi
   **hanya alamat IP tertentu** (isi IP_VM), dan wajibkan TLS.
2. WordPress: **Plugin › Tambahkan Plugin**, pasang **WP Mail SMTP**, pilih mailer *Other SMTP*:
   host `smtp-relay.gmail.com`, enkripsi TLS, port `587`, autentikasi **mati**,
   *From email* `noreply@aipptm.org`. Kirim email uji dari menu plugin.

## 7. OJS 3.5 (journal.aipptm.org)

1. Pastikan `https://journal.aipptm.org` sudah bergembok (HTTPS aktif), lalu buka alamat itu.
   Wizard instalasi muncul:
   * Bahasa: Bahasa Indonesia (tambah English bila perlu)
   * Direktori berkas: `/var/www/ojs-files`
   * Database: driver **MariaDB**, host `localhost`, user `ojs_aipptm`, database `ojs_aipptm`,
     kata sandi dari `/root/aipptm-kredensial.txt`
   * Buat akun administrator OJS.
2. Setelah wizard selesai, kembali ke SSH dan jalankan:

   ```bash
   sudo bash setup-server.sh --ojs-finalize
   ```

   Perintah ini memastikan `allowed_hosts` dan `base_url` memakai https, menyalakan `force_ssl`,
   dan memasang cron tugas terjadwal OJS. Salinan konfigurasi lama disimpan sebagai
   `config.inc.php.bak-TANGGAL`.
3. **Email OJS**: buka `/var/www/journal/config.inc.php` (`sudo nano ...`), bagian `[email]`:

   ```ini
   default = smtp
   smtp_server = smtp-relay.gmail.com
   smtp_port = 587
   smtp_auth = tls
   default_envelope_sender = noreply@aipptm.org
   force_default_envelope_sender = On
   force_dmarc_compliant_from = On
   ```

4. Buat jurnal: **Administrasi › Situs Web Hosting › Buat Jurnal** (misalnya path `jurnal`).
5. **Login Google di OJS**: di jurnal buka **Pengaturan › Website › Plugin › Galeri Plugin**,
   pasang **OpenID Authentication Plugin** (versi 5.1 untuk OJS 3.5), aktifkan, lalu buka **Pengaturan**:
   * Pilih provider **Google**, isi Client ID dan Secret (boleh memakai OAuth client yang sama,
     cukup tambahkan redirect URI-nya).
   * Salin **Redirect URL** yang ditampilkan plugin ke *Authorized redirect URIs* di Google Cloud.
     Jika Google menampilkan `redirect_uri_mismatch`, buka detail errornya: Google menunjukkan
     alamat persis yang diminta. Tambahkan alamat itu apa adanya.
   * Tetap izinkan login biasa untuk akun admin sebagai cadangan.
6. Tampilan jurnal: pasang **Tema OJS AIPPTM** (bagian 7a di bawah).

## 7a. Tema OJS AIPPTM dan "semua pengaturan di admin"

![Pratinjau tema OJS AIPPTM](pratinjau-ojs.png)

### Mengapa Site Settings OJS AIPPTM lebih sedikit dari UMT?

Ini perilaku bawaan OJS 3.5, bukan kerusakan. Di **Administration › Site Settings**, OJS hanya
menampilkan tab *Languages, Bulk Emails, Statistics* bila situs berisi **satu jurnal**. Tab
*Appearance, Plugins, Announcements, Information, Navigation, Highlights, ORCID* disembunyikan
karena pengaturan itu dipakai di tingkat jurnal. UMT memuat banyak jurnal, sehingga semua tab
tampil. (Sumber: `lib/pkp/pages/admin/AdminHandler.php`, fungsi `siteSettingsAvailability`.)

Untuk jurnal AIPPTM, semua pengaturan itu ada di **jurnalnya**: masuk sebagai admin, buka jurnal,
lalu **Settings › Website**:

| Yang dicari di UMT (Site Settings) | Tempatnya di AIPPTM |
|---|---|
| Appearance › Theme | Settings › Website › **Appearance › Theme** |
| Appearance › Setup (logo, footer) | Settings › Website › **Appearance › Setup** |
| Style sheet (.css) | Settings › Website › **Appearance › Advanced** |
| Plugins | Settings › Website › **Plugins** |
| Navigation, Announcements, Languages | Settings › Website › **Setup** |
| Information | Settings › Website › Setup › **Information** |
| Journal redirect | Tidak perlu: OJS otomatis membuka satu-satunya jurnal |

Di WordPress, menu baru **Jurnal (OJS)** (sidebar admin dan bar atas) berisi tautan langsung ke
semua halaman di atas. Isi dulu *Alamat OJS* dan *Path jurnal* di halaman itu.

### Mengapa CSS dari jurnal lain dan Footer HTML tidak berfungsi?

* **CSS jurnal lain** ditulis untuk tema jurnal itu (nama class-nya berbeda), jadi tidak cocok
  dengan tema lain. Selain itu, OJS menyimpan CSS hasil kompilasi di cache: setelah mengubah
  tampilan, buka **Administration › Clear Data Caches** dan **Clear Template Cache**.
* **Page Footer** di Appearance › Setup disaring OJS: tag `<script>`, `<iframe>`, `<style>`,
  dan banyak atribut dibuang. Itu sebabnya kode penghitung pengunjung atau lencana tidak muncul.
* Tema AIPPTM menambah kolom **Footer HTML (tanpa saringan)**, **Kode tambahan di head**, dan
  **CSS tambahan** di Appearance › Theme. Isinya ditampilkan apa adanya, jadi kode apa pun berfungsi.

### Memasang tema OJS AIPPTM

1. Unduh `aipptm-ojs-tema.tar.gz` dari repositori ini.
2. Di jurnal: **Settings › Website › Plugins › Upload A New Plugin** › pilih berkas › **Save**.
   Muncul pesan *Successfully installed version 1.0.0.0*.
3. Masih di **Installed Plugins**, cari bagian **Theme Plugins**, centang **AIPPTM Theme**.
4. **Settings › Website › Appearance › Theme** › pilih **AIPPTM Theme** › **Save**.
5. Opsi tema muncul di halaman yang sama:
   * Warna utama (merah `#C1121F`) dan warna bar atas/footer (hitam `#141416`)
   * Bar atas: email, lokasi, tautan *Website AIPPTM*
   * Logo AIPPTM di samping judul (otomatis hilang bila logo jurnal diunggah di Appearance › Setup)
   * Footer: deskripsi singkat, alamat, **Footer HTML**, kredit OJS/PKP
   * **Kode tambahan di head** (Google Analytics, meta verifikasi) dan **CSS tambahan**

   Menyimpan opsi tema otomatis membersihkan cache CSS, jadi perubahan langsung terlihat.

Server yang dipasang dengan `setup-server.sh` sudah menyalin tema ini ke
`/var/www/journal/plugins/themes/aipptm`; cukup lakukan langkah 3 dan 4. Untuk memperbarui tema,
unggah ulang berkas `.tar.gz` yang baru lewat **Upload A New Plugin**, atau jalankan ulang
`sudo bash setup-server.sh` dari folder yang berisi berkas itu.

### Tema tidak berubah atau tidak bisa masuk sebagai admin? Jalankan perbaikan otomatis

Gejala yang sering muncul: tema sudah diunggah tetapi jurnal tetap memakai tampilan *Default*,
atau login berhasil tetapi menu **Administrasi** tidak ada. Menu itu hanya muncul untuk akun
**Administrator Situs**, yaitu akun yang dibuat di wizard instalasi OJS, bukan akun Manajer Jurnal.

Masuk SSH ke VM, buka folder yang berisi `setup-server.sh` dan `aipptm-ojs-tema.tar.gz`, lalu:

```bash
sudo bash setup-server.sh --ojs-perbaiki
```

Perintah ini memasang ulang tema AIPPTM, mengaktifkan dan memilihnya di semua jurnal dan
halaman situs, membersihkan cache, lalu menampilkan **daftar akun Administrator Situs**. Login
di `https://journal.aipptm.org/index.php/index/login` memakai salah satu akun itu.

Untuk menjadikan akun Anda sendiri Administrator Situs (isi nama pengguna atau email OJS):

```bash
sudo bash setup-server.sh --ojs-perbaiki --admin admin@aipptm.org
```

Jika kata sandinya lupa, tambahkan sandi baru (akun juga diaktifkan kembali):

```bash
sudo bash setup-server.sh --ojs-perbaiki --admin admin@aipptm.org --sandi 'SandiBaruYangKuat'
```

Setelah itu muat ulang jurnal dengan Ctrl+F5. Menu **Administrasi** ada di menu akun (pojok
kanan atas) atau di `https://journal.aipptm.org/index.php/index/admin`.

### Mengapa menu Pengaturan Situs OJS tampak lebih sedikit dari OJS lain?

Ini perilaku bawaan OJS, bukan kerusakan. Selama server hanya punya **satu jurnal** (atau belum
ada jurnal sama sekali), **Administrasi › Pengaturan Situs** hanya menampilkan *Bahasa, Email Massal,
Statistik*. Tab *Settings, Information, Navigation, Highlights, Appearance, Announcements, Plugins*
baru muncul jika ada dua jurnal atau lebih (seperti di UMT). Pada satu jurnal, semuanya diatur dari
dalam jurnal itu sendiri, dan hasilnya sama lengkapnya:

| Yang dicari | Letaknya di jurnal |
|---|---|
| Tema, warna, logo, favicon | **Pengaturan › Website › Tampilan › Tema / Pengaturan** |
| Footer HTML | **Pengaturan › Website › Tampilan › Pengaturan › Footer Halaman** (klik ikon `<>` *Source code* dulu, baru tempel HTML) |
| CSS kustom | **Pengaturan › Website › Tampilan › Lanjutan › Lembar gaya jurnal** (unggah berkas `.css`) |
| Plugin, galeri plugin | **Pengaturan › Website › Plugin** |
| Menu navigasi | **Pengaturan › Website › Pengaturan › Menu Navigasi** |
| Pengumuman, informasi | **Pengaturan › Website › Pengaturan** |

Jika CSS atau footer dari jurnal lain "tidak berfungsi":

1. **CSS menyasar tema lain.** CSS UMT ditulis untuk tema dan class di jurnal UMT. Pakai tema yang sama
   (mis. *Default*, *Manuscript*, *Bootstrap3*) atau sesuaikan selektornya.
2. **Unggah sebagai berkas `.css`**, bukan ditempel di kolom teks. Tag `<style>` di footer dibuang OJS.
3. **Tag `<script>`, `<style>`, `<iframe>` dan atribut `style` dihapus** oleh penyaring HTML OJS
   (`allowed_html` di `config.inc.php`, bagian `[security]`). Pakai class dan taruh gayanya di berkas CSS.
4. **Bersihkan cache** setelah mengubah tampilan: **Administrasi › Hapus Cache Data** dan
   **Hapus Cache Template**, lalu muat ulang browser dengan Ctrl+F5.
5. Pastikan tombol **Simpan** ditekan di tiap tab (Tema, Pengaturan, Lanjutan disimpan terpisah).

## 8. Perawatan rutin

* **Update**: WordPress dan plugin dari menu *Dasbor › Pembaruan*. Untuk OJS, ikuti
  [panduan upgrade PKP](https://docs.pkp.sfu.ca/admin-guide/en/maintenance) dan buat snapshot disk dulu.
* **Backup**: snapshot disk harian (Google Cloud) dan dump database harian di VM.
  Sesekali unduh salinan backup ke luar VM.
* **Keamanan**: pakai kata sandi kuat dan verifikasi 2 langkah Google. Jangan bagikan isi
  `/root/aipptm-kredensial.txt`.
