# Gebze Personel Portalı — Tasarım Mantığı Referansı

Bu belge, projedeki **görsel dil**, **layout iskeleti** ve **bileşen kalıplarını** özetler. Yeni bir projede benzer kurumsal portal + admin paneli sıfırdan yazarken referans olarak kullanılabilir.

---

## 1. Genel mimari: İki yüzey

| Yüzey | Amaç | Ana CSS | Font |
|--------|------|---------|------|
| **Kamu sitesi** (personel portalı) | İçerik okuma, arama, liste/kart grid | `navbar.css`, `footer.css`, sayfa CSS | Inter |
| **Yönetim paneli** (admin) | CRUD, tablolar, formlar | `admin.css` (tek dosya) | Segoe UI |

**Teknoloji yığını (UI):**
- Bootstrap 5.3 (grid, form, utility)
- Font Awesome 6.4 (ikonlar)
- Vanilla JS (navbar, filtre, pagination — framework yok)
- PHP include ile parçalı layout (header, footer, breadcrumb)

---

## 2. Renk paleti

### Kamu sitesi (kurumsal lacivert)

| Rol | Hex | Kullanım |
|-----|-----|----------|
| Primary / Navbar / Footer | `#022842` | Üst menü, footer, başlıklar, CTA gradient |
| Primary açık | `#1e4a6b` | Gradient ikinci ton, hover |
| İkincil başlık | `#344e75` | Bölüm başlıkları, alt çizgi |
| Arka plan | `#f8f9fa` | `body`, breadcrumb şeridi |
| Metin muted | `#6c757d` | Breadcrumb, alt metin, sayaç |
| Hover vurgu | `orange` | Nav link hover (turuncu) |
| Kart beyaz | `#ffffff` | Kartlar, arama kutusu, page-header |
| Border | `#e9ecef` | Ayırıcılar |

### Admin paneli (mor-lacivert tema)

CSS değişkenleri (`:root`):

```css
--admin-primary: #6368a3;
--admin-primary-dark: #363958;
--admin-sidebar: #2c2e48;
--admin-sidebar-hover: #3d4066;
--admin-bg: #f4f6fb;
--admin-card: #ffffff;
--admin-border: #e5e8f0;
--admin-text: #1f2430;
--admin-muted: #6b7280;
--admin-success: #198754;
--admin-danger: #dc3545;
--admin-warning: #f59e0b;
```

Sidebar: `linear-gradient(180deg, --admin-sidebar → --admin-primary-dark)`

---

## 3. Layout ve hizalama

### Ortak kural: “Logo ↔ Profil hizası”

Tüm yatay içerik **aynı genişlikte** hizalanır:

```css
width: 90%;
max-width: 1600px;  /* kamu sitesi içerik */
margin: 0 auto;
```

- Navbar: `.nav-container`
- Breadcrumb: `.breadcrumb-container`
- İçerik: `.content-area > .nav-container` veya `.container`
- Footer içi: `max-width: 1200px` (biraz daha dar)

**Mantık:** Logo solda, profil sağda; aradaki breadcrumb ve sayfa içeriği aynı dikey eksende başlar/biter.

### Kamu sayfa iskeleti (sıra önemli)

```html
<body>
  <?php include "includes/header-nav.php"; ?>   <!-- sticky navbar -->
  <?php include "includes/breadcrumb.php"; ?>   <!-- opsiyonel: $pageTitle -->
  <div class="page-header">...</div>            <!-- bazı sayfalarda -->
  <div class="content-area">
    <div class="nav-container">...</div>
  </div>
  <?php include "includes/footer.php"; ?>
  <script src="navbar.js"></script>
</body>
```

### CSS yükleme sırası (`site-styles.php`)

1. Sayfaya özel CSS (`$pageCss = "etkinlik.style.css"`)
2. `navbar.css` (global)
3. `footer.css` (global)
4. Detay sayfaları: `detail_shared.css` (`$useDetailLayout = true`)

---

## 4. Navbar (kamu sitesi)

**Yapı:**
- `.navbar` — sticky, `z-index: 999`, arka plan `#022842`
- `.nav-container` — flex, space-between
- Sol: logo + mobil hamburger
- Orta: `.nav-links` — dropdown mega menüler (Etkinlikler, Kaynaklar, Diğer)
- Sağ: profil dropdown (yuvarlak foto, menü listesi)

**Dropdown mega menü:**
- `.nav-dropdown` + `.nav-dropdown-menu`
- İçerik: `.dropdown-grid` → `.dropdown-item` (ikon + başlık + kısa açıklama)
- JS ile ok hizalama ve `pull-left` / `pull-right` (ekran ortasına göre)

**Mobil:**
- `.side-menu` slide-in + `.menu-backdrop`
- Hamburger sadece küçük ekranda görünür

**Profil menüsü:**
- Yönetici: Yönetim Paneli, Oturum Bilgileri, Çıkış
- Personel: Email/Şifre değiştir, Oturum Bilgileri, Çıkış

---

## 5. Liste / arama sayfası kalıbı

Örnek: etkinlikler, videolar, duyurular.

```
page-header (başlık + ikon)
  ↓
search-filter-section (yuvarlak arama kutusu, pill shadow)
  ↓
results-header (sayaç + sort dropdown)
  ↓
news-grid (4 sütun desktop → responsive azalır)
  ↓
pagination-custom
```

**Kart (`.news-card`):**
- `border-radius: 20px`
- Görsel üstte, içerik altta
- Hover: `translateY(-8px)`, gölge artışı
- Durum rozeti: `.badge.aktif` / `.badge.pasif`
- Tıklanabilir tüm kart → detay sayfası

**Arama kutusu:**
- `border-radius: 50px` input
- Sağda yuvarlak gradient buton (`.search-btn`)
- Focus: primary border + hafif ring

**Grid:**
```css
.news-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 15px;
}
```

---

## 6. Detay sayfası kalıbı

- `$useDetailLayout = true` → `detail_shared.css`
- Sol: ana içerik (başlık, tarih, görsel, metin)
- Sağ: sidebar “diğer içerikler” listesi
- Ortak: breadcrumb + navbar + footer

---

## 7. Admin panel iskeleti

```html
<body class="admin-body">
  <div class="admin-layout">
    <aside class="admin-sidebar">...</aside>
    <div class="admin-sidebar-backdrop"></div>
    <div class="admin-main">
      <header class="admin-topbar">hamburger + sayfa başlığı + kullanıcı rozeti</header>
      <main class="admin-content">...</main>
    </div>
  </div>
</body>
```

**Sidebar (300px, fixed):**
- Marka alanı (logo tıklanır → dashboard)
- Bölüm başlıkları: `.admin-nav-section` (uppercase, soluk)
- Menü linkleri: ikon + metin, `border-radius: 10px`, active = beyaz %12 arka plan
- Footer linkleri: Siteyi görüntüle, Çıkış

**Mobil (≤992px):**
- Sidebar `translateX(-100%)`, `.open` ile açılır
- Topbar sticky `z-index: 1002`, sidebar altından başlar (`top: 57px`)
- Backdrop + sidebar içi × kapatma
- Hamburger her zaman üstte kalır

**Dashboard:**
- `.admin-stats` — auto-fit grid, renkli ikon kutuları (purple/blue/green/orange)
- `.admin-quick-links` — kısayol kartları
- Son kayıtlar tablosu

**CRUD listesi:**
- Üst: sayaç + “Yeni Ekle” primary buton
- `.admin-card` > `.admin-table`
- Satır işlemleri: `.admin-actions` (düzenle secondary, sil danger)

**Form sayfası:**
- `col-lg-8` ortalanmış tek kart
- `.admin-card-header` (başlık + Geri linki)
- `.admin-form` + Bootstrap `form-control` / `form-select`
- CSRF hidden input zorunlu

---

## 8. Bileşen sözlüğü

### Butonlar (admin)

| Sınıf | Görünüm |
|--------|---------|
| `.admin-btn-primary` | Mor gradient, beyaz yazı |
| `.admin-btn-secondary` | Beyaz, border |
| `.admin-btn-danger` | Kırmızı |
| `.admin-btn-sm` | Küçük padding |

### Kartlar

| Sınıf | Kullanım |
|--------|----------|
| `.admin-card` | Liste/form sarmalayıcı |
| `.admin-stat-card` | Dashboard istatistik |
| `.news-card` | Kamu içerik kartı |
| `.profil-card` | Profil/oturum sayfaları |

### Rozetler

- Admin tablo: `.admin-badge`, `.admin-badge-etkinlikler` vb.
- Kamu kart: `.badge.aktif`, `.badge.pasif`

### Alert (flash mesaj)

- `.admin-alert-success` / `-danger` / `-warning`
- PHP: `adminFlashSet()` + header’da gösterim

---

## 9. Giriş sayfaları

**Ortak stil (personel + yönetici):**
- Tam ekran gradient arka plan: `#f4f6fb → #e9ecf5`
- Ortada `.login-box`: beyaz, `border-radius: 20px`, gölge
- Logo üstte, badge (“YÖNETİM PANELİ”), alt başlık
- Input: `#f1f2f6` arka plan, focus’ta beyaz + mor/lacivert border
- Şifre göster/gizle toggle
- Primary buton: gradient (`#6368a3 → #363958` admin, benzer personel)
- AJAX `fetch` + JSON yanıt (`status: success|error`)

---

## 10. Tipografi

| Bağlam | Font | Başlık boyutu |
|--------|------|----------------|
| Kamu | Inter 400–700 | page-header `2rem`, kart başlık `1rem–1.375rem` |
| Admin | Segoe UI | topbar `1.25rem`, card header `1rem` |
| Breadcrumb | 14px | muted → active primary |

---

## 11. İkonografi

- **Font Awesome 6** (`fas`, `far`, `fa-solid`)
- Menülerde her linkin solunda ikon
- Anlamlı eşleme: video→`fa-video`, etkinlik→`fa-calendar-days`, vefat→`fa-ribbon`, personel→`fa-users`

---

## 12. JavaScript kalıpları

| Dosya | Görev |
|--------|--------|
| `navbar.js` | Dropdown, mobil menü, profil menü |
| `etkinlik.script.js` | Arama, filtre, grid render, pagination |
| Admin footer inline | Sidebar toggle, backdrop, ESC kapat |

**Liste sayfası JS:**
- `window.eventData` ← PHP `json_encode(mapX($rows))`
- Client-side filtre + sayfalama (12 kart/sayfa, 4’lü grid)
- Debounce arama (300ms)

---

## 13. PHP layout kalıbı

```
pages/
  includes/
    header-nav.php    # kamu navbar + profil
    breadcrumb.php    # $pageTitle
    footer.php
    site-styles.php   # CSS sırası
  admin/
    includes/
      auth.php        # oturum kontrolü
      header.php
      sidebar.php
      footer.php
    {modul}/
      index.php       # liste
      ekle.php
      duzenle.php
      sil.php         # POST + CSRF
```

**Değişken sözleşmesi (kamu sayfa):**
- `$pageTitle` — breadcrumb
- `$pageCss` — sayfa stili dosya adı

**Değişken sözleşmesi (admin):**
- `$currentPage` — sidebar active id
- `$pageTitle` — topbar başlık
- `$assetBase` — göreceli statik yol (alt klasör derinliğine göre)

---

## 14. Responsive özet

| Breakpoint | Davranış |
|------------|----------|
| Desktop | 4 sütun grid, tam navbar |
| Tablet | 2 sütun grid, dropdown menüler |
| ≤992px admin | Sidebar gizli, hamburger |
| Mobil kamu | Side menu, tek sütun grid |

---

## 15. Yeni projede sıfırdan başlarken önerilen sıra

1. CSS değişkenleri + `navbar.css` + `footer.css`
2. `header-nav.php` + `breadcrumb.php` + `footer.php`
3. Bir örnek liste sayfası (grid + arama + pagination)
4. Bir örnek detay sayfası
5. `admin.css` + sidebar + topbar
6. Dashboard + bir CRUD modülü (liste/ekle/düzenle/sil)
7. Login sayfaları (personel + admin ayrı)
8. `site-styles.php` benzeri merkezi CSS yükleyici

---

## 16. Dosya referansları (bu projede)

| Dosya | Rol |
|--------|-----|
| `CSS/navbar.css` | Kamu navbar, profil, mobil menü |
| `CSS/footer.css` | Footer |
| `CSS/admin.css` | Tüm admin UI |
| `CSS/etkinlik.style.css` | Liste sayfası şablonu (grid, arama) |
| `CSS/ana_sayfa.style.css` | Anasayfa hero + galeri |
| `CSS/profil.style.css` | Profil/oturum formları |
| `CSS/detail_shared.css` | Detay sayfa layout |
| `pages/includes/site-styles.php` | CSS include sırası |
| `pages/admin/includes/` | Admin layout parçaları |

---

*Son güncelleme: Personel Portalı codebase’inden çıkarılmıştır. Yeni projede marka renkleri ve logo değişse bile layout/iskelet aynı kalabilir.*
