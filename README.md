# WPB-StarterTheme

Minimalistisch WordPress starter thema met Bootstrap 5.3 via CDN. Geen build tools of externe PHP-libraries - puur WordPress thema-ontwikkeling.

## ✨ Kenmerken

- **Bootstrap 5.3.4** via jsDelivr CDN
- **Bootstrap Nav Walker** voor dropdown menu's
- **Theme Customizer** met layout opties
- **Gutenberg/Block Editor** ondersteuning met theme.json
- **5 Widget areas** (sidebar, 3× footer, hero)
- **Responsive** navbar (collapse of offcanvas)
- **Accessibility** skip-link en ARIA attributen
- **Back to Top** knop
- **Security hardening** (WP versie verborgen, emoji scripts verwijderd)
- **Nederlandse** vertalingen ingebouwd

## 📁 Bestandsstructuur

```
wp-bootstrap-starter/
├─ style.css                         # Thema header metadata
├─ functions.php                     # Setup, assets, widgets, security
├─ header.php                        # DOCTYPE, <head>, Bootstrap navbar
├─ footer.php                        # Footer widgets, menu, back-to-top
├─ index.php                         # Hoofdloop met sidebar positie
├─ single.php                        # Enkel bericht template
├─ page.php                          # Pagina template (full-width)
├─ archive.php                       # Categorie/tag/datum archieven
├─ search.php                        # Zoekresultaten
├─ searchform.php                    # Custom zoekformulier
├─ 404.php                           # Foutpagina
├─ sidebar.php                       # Widget gebied
├─ comments.php                      # Reactie formulier en lijst
├─ theme.json                        # Gutenberg/Block Editor configuratie
├─ inc/
│  ├─ class-wp-bootstrap-navwalker.php  # Bootstrap 5 Nav Walker
│  └─ customizer.php                 # Theme Customizer instellingen
├─ assets/
│  ├─ css/
│  │  ├─ custom.css                  # Custom style overrides
│  │  └─ editor-style.css            # Gutenberg editor styles
│  └─ js/
│     └─ theme.js                    # Active nav, smooth scroll, utilities
└─ template-parts/
   ├─ content.php                    # Post excerpt partial
   └─ content-search.php             # Zoekresultaat item
```

## 🚀 Installatie

1. Download of clone deze repository
2. Kopieer naar `wp-content/themes/wp-bootstrap-starter/`
3. Activeer het thema via **Weergave → Thema's**
4. Stel een menu in via **Weergave → Menu's** (locatie: Hoofdmenu, Footer Menu)
5. Voeg widgets toe via **Weergave → Widgets**
6. Pas layout aan via **Weergave → Customizer**

## ⚙️ Customizer Opties

| Instelling | Opties | Standaard |
|------------|--------|-----------|
| Container Type | `container` / `container-fluid` | `container` |
| Sidebar Positie | `left` / `right` / `none` | `right` |
| Navbar Type | `collapse` / `offcanvas` | `collapse` |
| Footer Tekst | Vrij tekstveld | © {year} {site name} |

## 🎨 Widget Areas

| ID | Naam | Locatie |
|----|------|---------|
| `primary-sidebar` | Primaire Sidebar | Naast content |
| `footer-1` | Footer Kolom 1 | Eerste footer kolom |
| `footer-2` | Footer Kolom 2 | Tweede footer kolom |
| `footer-3` | Footer Kolom 3 | Derde footer kolom |
| `hero` | Hero Sectie | Boven content (header) |

## 🔧 Belangrijke Functies

| Functie | Beschrijving |
|---------|--------------|
| `wpbs_setup()` | Thema initialisatie, supports, menu's |
| `wpbs_enqueue_assets()` | CSS/JS laden (Bootstrap CDN) |
| `wpbs_cleanup_head()` | Security hardening |
| `wpbs_widgets_init()` | Widget areas registreren |
| `wpbs_get_container_type()` | Haal container instelling op |
| `wpbs_get_sidebar_position()` | Haal sidebar positie op |
| `wpbs_has_sidebar()` | Check of sidebar actief is |
| `wpbs_the_custom_logo()` | Toon logo of site titel |
| `wpbs_site_info()` | Footer copyright tekst |

## 📝 Code Conventies

- **Functie prefix**: `wpbs_`
- **Text domain**: `wp-bootstrap-starter`
- **Escaping**: Altijd `esc_*` functies gebruiken
- **Vertalingen**: `__()` of `_e()` met text domain
- **CSS**: Bootstrap utilities waar mogelijk

## ✅ Geïmplementeerde Features

### Prioriteit 1 — Essentieel ✓
- [x] **Bootstrap Nav Walker** — Dropdown menu's met Bootstrap 5 classes
- [x] **Custom Logo support** — `add_theme_support('custom-logo')`
- [x] **Skip to content link** — Accessibility verbetering
- [ ] **screenshot.png** — 1200x900 thema preview afbeelding

### Prioriteit 2 — Customizer & Layout ✓
- [x] **Theme Customizer** — Container type instelling
- [x] **Sidebar positie** — Links/rechts/geen via Customizer
- [x] **Container type variabel** — Dynamisch in alle templates
- [x] **Footer widget area** — 3 kolommen footer widgets

### Prioriteit 3 — Gutenberg & Blocks ✓
- [x] **theme.json** — Block editor kleuren, spacing, fonts
- [x] **Editor styles** — `add_editor_style('assets/css/editor-style.css')`
- [x] **Wide alignment** — `add_theme_support('align-wide')`
- [x] **Block styling** — Bootstrap classes voor Gutenberg blocks

### Prioriteit 4 — Extra Features ✓
- [x] **Custom header image** — `add_theme_support('custom-header')`
- [x] **Custom background** — `add_theme_support('custom-background')`
- [x] **Post formats** — aside, image, video, quote, link, gallery
- [x] **Offcanvas navbar** — Via Customizer schakelbaar
- [x] **Responsive embeds** — `add_theme_support('responsive-embeds')`
- [x] **Back to Top** — Scroll-to-top knop

## 📋 Nog Te Implementeren

### Prioriteit 5 — Plugins & Integraties
- [ ] **WooCommerce support** — `woocommerce.php` met Bootstrap styling
- [ ] **Jetpack compatibility** — Infinite scroll, social menu
- [ ] **Contact Form 7 styling** — Bootstrap form classes

### Prioriteit 6 — Developer Experience
- [ ] **Sass/npm build pipeline** — Vite of Webpack configuratie
- [ ] **Minified CSS/JS** — Productie builds met `.min` bestanden
- [ ] **Translation ready** — `.pot` bestand genereren
- [ ] **Child theme** — Starter child theme template
- [ ] **screenshot.png** — 1200x900 thema preview

## 🔒 Beveiliging

- WordPress versie verborgen in `<head>`
- Emoji scripts/styles verwijderd
- Escape alle output met `esc_*` functies
- Overweeg SRI hashes voor CDN assets in productie

## 📄 Licentie

GPL v2 of later — [https://www.gnu.org/licenses/gpl-2.0.html](https://www.gnu.org/licenses/gpl-2.0.html)

## 👤 Auteur

**FectionLabs** — [https://fectionlabs.com](https://fectionlabs.com)
