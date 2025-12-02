# WPB-StarterTheme

Minimalistisch WordPress starter thema met Bootstrap 5.3 via CDN. Geen build tools of externe PHP-libraries - puur WordPress thema-ontwikkeling.

## ✨ Kenmerken

- **Bootstrap 5.3.4** via jsDelivr CDN
- **Responsive** navbar met mobiele toggle
- **Widget-ready** sidebar met Bootstrap card styling
- **Paginatie** voor archieven en zoekresultaten
- **Security hardening** (WP versie verborgen, emoji scripts verwijderd)
- **Nederlandse** vertalingen ingebouwd

## 📁 Bestandsstructuur

```
wp-bootstrap-starter/
├─ style.css                    # Thema header metadata
├─ functions.php                # Setup, assets, widgets, security
├─ header.php                   # DOCTYPE, <head>, Bootstrap navbar
├─ footer.php                   # Footer, wp_footer() hook
├─ index.php                    # Hoofdloop (col-md-8 + sidebar)
├─ single.php                   # Enkel bericht template
├─ page.php                     # Pagina template (full-width)
├─ archive.php                  # Categorie/tag/datum archieven
├─ search.php                   # Zoekresultaten
├─ 404.php                      # Foutpagina
├─ sidebar.php                  # Widget gebied
├─ comments.php                 # Reactie formulier en lijst
├─ assets/
│  ├─ css/custom.css            # Custom style overrides
│  └─ js/theme.js               # Active nav + smooth scroll
└─ template-parts/
   ├─ content.php               # Post excerpt partial
   └─ content-search.php        # Zoekresultaat item
```

## 🚀 Installatie

1. Download of clone deze repository
2. Kopieer naar `wp-content/themes/wp-bootstrap-starter/`
3. Activeer het thema via **Weergave → Thema's**
4. Stel een menu in via **Weergave → Menu's** (locatie: Hoofdmenu)
5. Voeg widgets toe via **Weergave → Widgets**

## 🎨 Bootstrap Grid

| Template | Content | Sidebar | Layout |
|----------|---------|---------|--------|
| `index.php` | `col-md-8` | `col-md-4` | 2 kolommen |
| `single.php` | `col-md-8` | `col-md-4` | 2 kolommen |
| `archive.php` | `col-md-8` | `col-md-4` | 2 kolommen |
| `search.php` | `col-md-8` | `col-md-4` | 2 kolommen |
| `page.php` | `col-md-12` | — | Full-width |

## 🔧 Functies

### `wpbs_setup()`
Thema initialisatie: title-tag, thumbnails, HTML5 support, menu registratie.

### `wpbs_enqueue_assets()`
Laadt CSS/JS in volgorde: Bootstrap CSS → Theme → Custom → Bootstrap JS → Theme JS.

### `wpbs_cleanup_head()`
Security: verbergt WP versie, verwijdert emoji scripts.

### `wpbs_widgets_init()`
Registreert `primary-sidebar` widget gebied met Bootstrap card styling.

## 📝 Code Conventies

- **Functie prefix**: `wpbs_`
- **Text domain**: `wp-bootstrap-starter`
- **Escaping**: Altijd `esc_*` functies gebruiken
- **Vertalingen**: `__()` of `_e()` met text domain

## 🔒 Beveiliging

- WordPress versie verborgen in `<head>`
- Emoji scripts/styles verwijderd
- Overweeg SRI hashes voor CDN assets in productie

## 📋 Roadmap

### Prioriteit 1 — Essentieel
- [ ] **Bootstrap Nav Walker** — Dropdown menu's met Bootstrap 5 classes (`inc/class-wp-bootstrap-navwalker.php`)
- [ ] **Custom Logo support** — `add_theme_support('custom-logo')` in `functions.php`
- [ ] **Skip to content link** — Accessibility verbetering in `header.php`
- [ ] **screenshot.png** — 1200x900 thema preview afbeelding

### Prioriteit 2 — Customizer & Layout
- [ ] **Theme Customizer** — Container type (container/container-fluid) instelling
- [ ] **Sidebar positie** — Links/rechts/geen via Customizer
- [ ] **Container type variabel** — `get_theme_mod('container_type')` in templates
- [ ] **Footer widget area** — Extra widget gebied in footer

### Prioriteit 3 — Gutenberg & Blocks
- [ ] **theme.json** — Block editor kleuren, spacing, fonts
- [ ] **Editor styles** — `add_theme_support('editor-styles')`
- [ ] **Wide alignment** — `add_theme_support('align-wide')`
- [ ] **Block styling** — Bootstrap classes voor Gutenberg blocks

### Prioriteit 4 — Extra Features
- [ ] **Custom header image** — `add_theme_support('custom-header')`
- [ ] **Custom background** — `add_theme_support('custom-background')`
- [ ] **Post formats** — aside, image, video, quote, link
- [ ] **Offcanvas navbar** — Alternatief voor collapse menu (BS5)
- [ ] **Responsive embeds** — `add_theme_support('responsive-embeds')`

### Prioriteit 5 — Plugins & Integraties
- [ ] **WooCommerce support** — `woocommerce.php` met Bootstrap styling
- [ ] **Jetpack compatibility** — Infinite scroll, social menu
- [ ] **Contact Form 7 styling** — Bootstrap form classes

### Prioriteit 6 — Developer Experience
- [ ] **Sass/npm build pipeline** — Vite of Webpack configuratie
- [ ] **Minified CSS/JS** — Productie builds met `.min` bestanden
- [ ] **Translation ready** — `.pot` bestand genereren
- [ ] **Child theme** — Starter child theme template

## 📄 Licentie

GPL v2 of later — [https://www.gnu.org/licenses/gpl-2.0.html](https://www.gnu.org/licenses/gpl-2.0.html)

## 👤 Auteur

**FectionLabs** — [https://fectionlabs.com](https://fectionlabs.com)
