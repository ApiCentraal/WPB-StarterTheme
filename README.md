# WPB-StarterTheme

Minimalistisch WordPress starter thema met Bootstrap 5.3 via CDN. Geen build tools of externe PHP-libraries - puur WordPress thema-ontwikkeling.

## ✨ Kenmerken

- **Bootstrap 5.3.4** via jsDelivr CDN
- **Bootstrap Nav Walker** voor dropdown menu's
- **Bootstrap Gutenberg Blocks** (Container, Row, Column, Button, Alert, Card)
- **Bootstrap Shortcodes** (12+ componenten voor classic editor)
- **Theme Customizer** met layout opties
- **Gutenberg/Block Editor** ondersteuning met theme.json
- **5 Widget areas** (sidebar, 3× footer, hero)
- **Custom Widgets** (Social Links, Recent Posts met thumbnails)
- **Responsive** navbar (collapse of offcanvas)
- **Author Box** & **Related Posts** onder artikelen
- **WooCommerce** ondersteuning met Bootstrap styling
- **Jetpack** compatibility (infinite scroll, social menu)
- **Contact Form 7** Bootstrap form styling
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
├─ single.php                        # Enkel bericht + author box + related posts
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
│  ├─ customizer.php                 # Theme Customizer instellingen
│  ├─ shortcodes.php                 # Bootstrap 5.3 shortcodes
│  ├─ blocks.php                     # Bootstrap Gutenberg blocks
│  ├─ woocommerce.php                # WooCommerce integratie
│  ├─ jetpack.php                    # Jetpack compatibility
│  ├─ contact-form-7.php             # CF7 Bootstrap styling
│  ├─ user-profile.php               # Extra social media velden
│  └─ widgets/
│     ├─ class-wpbs-social-widget.php    # Social Links widget
│     └─ class-wpbs-recent-posts-widget.php  # Recent Posts widget
├─ assets/
│  ├─ css/
│  │  ├─ custom.css                  # Custom style overrides
│  │  ├─ editor-style.css            # Gutenberg editor styles
│  │  ├─ blocks-editor.css           # Block editor styles
│  │  ├─ woocommerce.css             # WooCommerce Bootstrap styles
│  │  └─ cf7-bootstrap.css           # Contact Form 7 styles
│  └─ js/
│     ├─ theme.js                    # Active nav, smooth scroll, utilities
│     └─ blocks-editor.js            # Gutenberg blocks JavaScript
├─ template-parts/
│  ├─ content.php                    # Post excerpt partial
│  ├─ content-search.php             # Zoekresultaat item
│  ├─ author-box.php                 # Auteur info box
│  └─ related-posts.php              # Gerelateerde berichten
├─ languages/
│  └─ wp-bootstrap-starter.pot       # Translation template
└─ starter-child-theme/              # Starter child theme
   ├─ functions.php
   ├─ style.css
   └─ README.md
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
| `wpbs_woocommerce_header_cart()` | Mini cart voor navbar (WooCommerce) |
| `wpbs_jetpack_social_menu()` | Social menu (Jetpack) |

## 📦 Bootstrap Gutenberg Blocks

Beschikbaar in de Gutenberg editor onder "Design":

| Block | Beschrijving |
|-------|--------------|
| **Container** | Bootstrap container met fluid/breakpoint opties |
| **Row** | Row met template keuze en gutter controls |
| **Column** | Responsive kolommen (xs-xxl breakpoints, offsets, order) |
| **Button** | Alle Bootstrap button stijlen en maten |
| **Alert** | Alert meldingen met dismiss optie |
| **Card** | Card component met header, footer, image |

## 📝 Bootstrap Shortcodes

Voor de classic editor zijn de volgende shortcodes beschikbaar:

| Shortcode | Voorbeeld |
|-----------|-----------|
| `[container]` | `[container fluid="true"]...[/container]` |
| `[row]` | `[row gutter="3"]...[/row]` |
| `[column]` | `[column md="6" lg="4"]...[/column]` |
| `[button]` | `[button type="primary" link="#"]Klik[/button]` |
| `[alert]` | `[alert type="success" dismissible="true"]...[/alert]` |
| `[badge]` | `[badge type="danger" pill="true"]5[/badge]` |
| `[card]` | `[card title="Titel"]...[/card]` |
| `[tabs]` + `[tab]` | `[tabs][tab title="Tab 1"]...[/tab][/tabs]` |
| `[accordion]` + `[collapse]` | `[accordion][collapse title="Item"]...[/collapse][/accordion]` |
| `[modal]` | `[modal title="Titel" btn_text="Open"]...[/modal]` |
| `[carousel]` + `[carousel-item]` | `[carousel][carousel-item]...[/carousel-item][/carousel]` |
| `[icon]` | `[icon name="house" prefix="bi"]` |

## 🛒 WooCommerce

Volledige Bootstrap 5 integratie:
- Product grid met card styling
- Cart en checkout met Bootstrap forms
- Mini cart dropdown voor navbar
- Star ratings met Bootstrap Icons

## 📝 Code Conventies

- **Functie prefix**: `wpbs_`
- **Text domain**: `wp-bootstrap-starter`
- **Escaping**: Altijd `esc_*` functies gebruiken
- **Vertalingen**: `__()` of `_e()` met text domain
- **CSS**: Bootstrap utilities waar mogelijk

## 🌐 Vertalingen

Het thema is translation-ready met een `.pot` bestand in `/languages/`.

## 👶 Child Theme

Een starter child theme is beschikbaar in `/starter-child-theme/`:
1. Kopieer de map naar `wp-content/themes/`
2. Hernoem naar je gewenste naam
3. Activeer het child theme

## 🔒 Beveiliging

- WordPress versie verborgen in `<head>`
- Emoji scripts/styles verwijderd
- Escape alle output met `esc_*` functies

## 📄 Licentie

GPL v2 of later — [https://www.gnu.org/licenses/gpl-2.0.html](https://www.gnu.org/licenses/gpl-2.0.html)

## 👤 Auteur

**FectionLabs** — [https://fectionlabs.com](https://fectionlabs.com)
