# WPB-StarterTheme - Copilot Instructies

## Project Overzicht
Minimalistisch WordPress starter thema met Bootstrap 5.3 via CDN. Geen build tools of externe PHP-libraries - puur WordPress thema-ontwikkeling.

---

## Architectuur

### Bestandsstructuur
```
wp-bootstrap-starter/
├─ style.css                    # Thema header + optionele imports
├─ functions.php                # Thema setup, assets, beveiliging
├─ header.php                   # DOCTYPE, <head>, navbar
├─ footer.php                   # Footer, wp_footer() hook
├─ index.php                    # Hoofdloop met Bootstrap grid
├─ page.php                     # Volledige breedte pagina template
├─ single.php                   # Enkel bericht template met sidebar
├─ 404.php                      # Foutpagina
├─ sidebar.php                  # Widget gebied
├─ assets/css/custom.css        # Custom style overrides
├─ assets/js/theme.js           # Thema JavaScript (vanilla JS)
└─ template-parts/content.php   # Herbruikbaar post excerpt partial
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
    ├─→ add_theme_support('title-tag')      → <title> tag in <head>
    ├─→ add_theme_support('post-thumbnails') → Uitgelichte afbeeldingen
    ├─→ add_theme_support('html5', [...])    → HTML5 markup voor formulieren
    └─→ register_nav_menus(['primary'])      → Menu locatie voor navbar
```

**Koppeling**: Wordt aangeroepen via `add_action('after_setup_theme', 'wpbs_setup')`

**Voorbeeld implementatie**:
```php
if (!function_exists('wpbs_setup')) {
    function wpbs_setup() {
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
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
| index.php   | `col-md-8`    | `col-md-4` | 12 |
| single.php  | `col-md-8`    | `col-md-4` | 12 |
| page.php    | `col-md-12`   | —       | 12 |
| 404.php     | `col-md-8`    | `col-md-4` | 12 |

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

## Takenlijst voor Implementatie

### Fase 1: Basis Thema Bestanden
- [ ] `style.css` — Thema header metadata aanmaken
- [ ] `functions.php` — Alle functies implementeren
- [ ] `header.php` — DOCTYPE, head, navbar
- [ ] `footer.php` — Footer met wp_footer()

### Fase 2: Templates
- [ ] `index.php` — Hoofdloop met grid
- [ ] `single.php` — Enkel bericht template
- [ ] `page.php` — Pagina template (full-width)
- [ ] `404.php` — Foutpagina
- [ ] `sidebar.php` — Widget gebied
- [ ] `template-parts/content.php` — Post excerpt partial

### Fase 3: Assets
- [ ] `assets/css/custom.css` — Lege custom stylesheet
- [ ] `assets/js/theme.js` — Active nav link script

### Fase 4: Uitbreidingen (Optioneel)
- [ ] Widget registratie in `functions.php`
- [ ] Bootstrap Nav Walker class
- [ ] `theme.json` voor Gutenberg
- [ ] SRI hashes voor CDN assets

---

## Beveiliging
- WP versie verborgen (`remove_action('wp_head', 'wp_generator')`)
- Emoji scripts/styles verwijderd voor performance
- Overweeg SRI hashes voor CDN resources in productie

## Contribution Guidelines
- Fork the repo and create feature branches
- Follow coding conventions strictly
- Submit pull requests with clear descriptions of changes
          'fallback_cb' => false,
          'depth' => 2,
          'walker' => new WP_Bootstrap_Navwalker(), // Optional: if using a custom walker for Bootstrap
          ));
        ?>
      </div>
    </div>
  </nav>
</header>
```