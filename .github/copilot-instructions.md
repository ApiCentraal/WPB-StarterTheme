# WPB-StarterTheme - Copilot Instructies

## Project Overzicht
Minimalistisch WordPress starter thema met Bootstrap 5.3 via CDN. Geen build tools of externe PHP-libraries - puur WordPress thema-ontwikkeling.

---

## Architectuur

### Bestandsstructuur
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
├─ searchform.php                    # Custom zoekformulier (Bootstrap)
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

---

## Functies & Pipeline Documentatie

### 1. `wpbs_setup()` — Thema Initialisatie

**Doel**: Initialiseert basisfunctionaliteit van het thema bij WordPress activatie.

**Pipeline**:
```
WordPress Init
    ↓
after_setup_theme hook
    ↓
wpbs_setup()
    ├─→ add_theme_support('title-tag')       → <title> tag in <head>
    ├─→ add_theme_support('post-thumbnails') → Uitgelichte afbeeldingen
    ├─→ add_theme_support('html5', [...])    → HTML5 markup voor formulieren
    ├─→ add_theme_support('custom-logo')     → Custom logo ondersteuning
    ├─→ add_theme_support('custom-header')   → Custom header afbeelding
    ├─→ add_theme_support('custom-background') → Custom achtergrond
    ├─→ add_theme_support('editor-styles')   → Gutenberg editor styling
    ├─→ add_theme_support('align-wide')      → Wide/full alignment blocks
    ├─→ add_theme_support('responsive-embeds') → Responsive video embeds
    ├─→ add_theme_support('post-formats')    → Post formaten (aside, video, etc.)
    └─→ register_nav_menus(['primary', 'footer']) → Menu locaties
```

**Koppeling**: Wordt aangeroepen via `add_action('after_setup_theme', 'wpbs_setup')`

**Voorbeeld implementatie**:
```php
if (!function_exists('wpbs_setup')) {
    function wpbs_setup() {
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('custom-logo', array('height' => 100, 'width' => 350, 'flex-height' => true));
        add_theme_support('editor-styles');
        add_editor_style('assets/css/editor-style.css');
        register_nav_menus(['primary' => __('Hoofdmenu', 'wp-bootstrap-starter')]);
    }
    add_action('after_setup_theme', 'wpbs_setup');
}
```

---

### 2. `wpbs_enqueue_assets()` — Asset Loading

**Doel**: Laadt alle CSS en JavaScript bestanden in de juiste volgorde.

**Pipeline**:
```
Pagina Request
    ↓
wp_enqueue_scripts hook
    ↓
wpbs_enqueue_assets()
    ↓
CSS Keten (afhankelijkheden):
    bootstrap-css (CDN)
        ↓
    wpbs-style (style.css)
        ↓
    wpbs-custom (assets/css/custom.css)

JS Keten (afhankelijkheden):
    jquery (WP core, optioneel)
        ↓
    bootstrap-js (CDN Bundle + Popper)
        ↓
    wpbs-theme (assets/js/theme.js)
        ↓
    wp_footer() → Scripts in footer
```

**Koppeling**: `add_action('wp_enqueue_scripts', 'wpbs_enqueue_assets')`

**Voorbeeld implementatie**:
```php
function wpbs_enqueue_assets() {
    // CSS: Bootstrap → Theme → Custom
    wp_enqueue_style('bootstrap-css', 
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css');
    wp_enqueue_style('wpbs-style', get_stylesheet_uri(), ['bootstrap-css']);
    wp_enqueue_style('wpbs-custom', 
        get_template_directory_uri() . '/assets/css/custom.css', 
        ['wpbs-style'], 
        filemtime(get_template_directory() . '/assets/css/custom.css'));
    
    // JS: Bootstrap Bundle (incl. Popper) → Theme
    wp_enqueue_script('bootstrap-js', 
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/js/bootstrap.bundle.min.js',
        [], null, true);
    wp_enqueue_script('wpbs-theme', 
        get_template_directory_uri() . '/assets/js/theme.js',
        ['bootstrap-js'], 
        filemtime(get_template_directory() . '/assets/js/theme.js'), true);
}
add_action('wp_enqueue_scripts', 'wpbs_enqueue_assets');
```

---

### 3. `wpbs_cleanup_head()` — Security & Performance

**Doel**: Verwijdert onnodige meta tags en scripts voor betere performance en veiligheid.

**Pipeline**:
```
WordPress Init
    ↓
init hook
    ↓
wpbs_cleanup_head()
    ├─→ remove_action('wp_head', 'wp_generator')     → Verbergt WP versie
    ├─→ remove_action('wp_head', 'print_emoji_...')  → Geen emoji scripts
    └─→ remove_action('wp_print_styles', '...')      → Geen emoji styles
        ↓
    Schonere <head> output
```

**Koppeling**: `add_action('init', 'wpbs_cleanup_head')`

---

### 4. Template Rendering Pipeline

**Doel**: Toont hoe WordPress templates samenwerken.

**Pipeline voor een blogpost**:
```
Browser Request: /blog/mijn-artikel
    ↓
WordPress Template Hiërarchie
    ↓
single.php (of index.php als fallback)
    ↓
┌─────────────────────────────────────────────┐
│ get_header()                                │
│   → header.php                              │
│   → wp_head() hook → CSS/meta laden         │
│   → <nav> met wp_nav_menu()                 │
│   → <main class="container">                │
└─────────────────────────────────────────────┘
    ↓
┌─────────────────────────────────────────────┐
│ The Loop: while(have_posts()) : the_post() │
│   → get_template_part('template-parts/      │
│       content', get_post_type())            │
│   → template-parts/content.php              │
│   → the_title(), the_content(), etc.        │
└─────────────────────────────────────────────┘
    ↓
┌─────────────────────────────────────────────┐
│ get_sidebar()                               │
│   → sidebar.php                             │
│   → dynamic_sidebar('primary-sidebar')      │
│   → Widget output                           │
└─────────────────────────────────────────────┘
    ↓
┌─────────────────────────────────────────────┐
│ get_footer()                                │
│   → footer.php                              │
│   → wp_footer() hook → JS laden             │
│   → </body></html>                          │
└─────────────────────────────────────────────┘
```

---

### 5. Navigation Menu Pipeline

**Doel**: Rendert het hoofdmenu met Bootstrap navbar classes.

**Pipeline**:
```
header.php
    ↓
wp_nav_menu(['theme_location' => 'primary'])
    ↓
WordPress haalt menu items op uit database
    ↓
Genereert <ul class="navbar-nav ms-auto">
    ├─→ Menu item 1 → <li><a href="...">
    ├─→ Menu item 2 → <li><a href="...">
    └─→ ...
    ↓
Output in Bootstrap navbar structuur
```

**Voorbeeld**:
```php
wp_nav_menu([
    'theme_location' => 'primary',
    'container'      => false,
    'menu_class'     => 'navbar-nav ms-auto mb-2 mb-lg-0',
    'fallback_cb'    => 'wp_page_menu',
]);
```

---

## Bootstrap Grid Conventies

| Template    | Content kolom | Sidebar | Totaal |
|-------------|---------------|---------|--------|
| index.php   | dynamisch (`col-md-8` / `col-md-12`) | optioneel `col-md-4` | 12 |
| single.php  | dynamisch (`col-md-8` / `col-md-12`) | optioneel `col-md-4` | 12 |
| archive.php | dynamisch (`col-md-8` / `col-md-12`) | optioneel `col-md-4` | 12 |
| search.php  | dynamisch (`col-md-8` / `col-md-12`) | optioneel `col-md-4` | 12 |
| 404.php     | dynamisch (`col-md-8` / `col-md-12`) | optioneel `col-md-4` | 12 |
| page.php    | `col-md-12`   | —       | 12 |

**Let op**: Sidebar positie (links/rechts/geen) wordt bepaald via `wpbs_get_sidebar_position()` uit de Theme Customizer.

---

## Code Conventies

### PHP
- Wrap functies in `if (!function_exists('...'))` checks
- Prefix alle functies met `wpbs_`
- Gebruik `esc_*` functies voor output escaping
- Text domain: `wp-bootstrap-starter`

### CSS
- Custom styles in `assets/css/custom.css`, niet in `style.css`
- Bootstrap 5.3 utility classes hebben voorkeur boven custom CSS

### JavaScript
- Vanilla JS (Bootstrap 5 vereist geen jQuery)
- Scripts laden in footer met `true` parameter

### Vertalingen
- Nederlandse taal voor gebruikersgerichte strings
- Altijd `__()` of `_e()` met text domain
- Voorbeeld: `__('Lees meer', 'wp-bootstrap-starter')`

---

## Helper Functies

| Functie | Return | Beschrijving |
|---------|--------|--------------|
| `wpbs_get_container_type()` | `string` | Haalt `container` of `container-fluid` op uit Customizer |
| `wpbs_get_sidebar_position()` | `string` | Haalt `left`, `right`, of `none` op uit Customizer |
| `wpbs_has_sidebar()` | `bool` | Controleert of sidebar actief is (niet `none` + heeft widgets) |
| `wpbs_get_navbar_type()` | `string` | Haalt `collapse` of `offcanvas` op uit Customizer |
| `wpbs_the_custom_logo()` | `void` | Toont custom logo of site titel als fallback |
| `wpbs_site_info()` | `void` | Toont footer copyright (customizer of default) |

---

## Implementatie Status

### ✅ Geïmplementeerd
- [x] Alle basis thema bestanden
- [x] Bootstrap Nav Walker (`inc/class-wp-bootstrap-navwalker.php`)
- [x] Theme Customizer (`inc/customizer.php`)
- [x] 5 Widget areas (sidebar, 3× footer, hero)
- [x] Gutenberg ondersteuning (`theme.json`, editor-style.css)
- [x] Dynamische sidebar positie in alle templates
- [x] Skip-to-content link
- [x] Back-to-top knop
- [x] Offcanvas navbar optie
- [x] Custom zoekformulier

### 🔲 Nog te implementeren
- [ ] screenshot.png (1200×900)
- [ ] WooCommerce support
- [ ] Translation .pot bestand
- [ ] Child theme template

---

## Beveiliging
- WP versie verborgen (`remove_action('wp_head', 'wp_generator')`)
- Emoji scripts/styles verwijderd voor performance
- Escape alle output met `esc_*` functies
- Overweeg SRI hashes voor CDN resources in productie

## Contribution Guidelines
- Fork the repo and create feature branches
- Follow coding conventions strictly
- Submit pull requests with clear descriptions of changes