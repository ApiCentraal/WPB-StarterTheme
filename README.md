# WPB-StarterTheme
Wordpress Template als starter voor wordpress + bootstrap thema ontwikkeling.

# WP-Bootstrap-Starter — WordPress starter theme with Bootstrap 5.3 (CDN)

**Beschrijving**
Kleine, productieklare starter-theme boilerplate voor WordPress. Bootstrap wordt geladen via CDN (versie 5.3.x). Geen externe PHP-libraries. Schone, makkelijk uitbreidbare structuur — perfect als basis voor een thema of MVP.

---

## Bestandstructuur
```
wp-bootstrap-starter/
├─ style.css
├─ functions.php
├─ index.php
├─ header.php
├─ footer.php
├─ sidebar.php
├─ page.php
├─ single.php
├─ 404.php
├─ assets/
│  ├─ css/
│  │  └─ custom.css
│  └─ js/
│     └─ theme.js
└─ template-parts/
   └─ content.php
```

---

## style.css (thema header)
```php
/*
Theme Name: WP Bootstrap Starter
Theme URI:  https://fectionlabs.com/wp-bootstrap-starter
Author:      Your Name
Author URI:  https://fectionlabs.com
Description: Minimal WordPress starter theme with Bootstrap 5.3 (CDN)
Version:     0.1.0
License:     GNU General Public License v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wp-bootstrap-starter
Tags:        responsive, bootstrap, starter, accessibility
*/

/* Optional: import custom css (kept empty; use assets/css/custom.css) */
```

---

## functions.php
```php
<?php
// Theme setup and enqueue assets
if (!function_exists('wpbs_setup')) {
    function wpbs_setup() {
        // Basic theme supports
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('html5', array('search-form','comment-form','comment-list','gallery','caption'));
        register_nav_menus(array(
            'primary' => __('Primary Menu', 'wp-bootstrap-starter'),
        ));
    }
    add_action('after_setup_theme', 'wpbs_setup');
}

// Enqueue Bootstrap (CDN) + theme assets. Use proper dependencies and defer where relevant.
if (!function_exists('wpbs_enqueue_assets')) {
    function wpbs_enqueue_assets() {
        // Bootstrap CSS (jsDelivr recommended)
        wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css', array(), null);

        // Theme CSS (load after bootstrap)
        wp_enqueue_style('wpbs-style', get_stylesheet_uri(), array('bootstrap-css'), filemtime(get_template_directory() . '/style.css'));
        wp_enqueue_style('wpbs-custom', get_template_directory_uri() . '/assets/css/custom.css', array('wpbs-style'), filemtime(get_template_directory() . '/assets/css/custom.css'));

        // Bootstrap Bundle JS (includes Popper)
        wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);

        // Theme JS
        wp_enqueue_script('wpbs-theme', get_template_directory_uri() . '/assets/js/theme.js', array('bootstrap-js'), filemtime(get_template_directory() . '/assets/js/theme.js'), true);

        // Remove jQuery dependency if you don't need it. Currently Bootstrap 5 doesn't require jQuery; included here only if theme scripts use it.
    }
    add_action('wp_enqueue_scripts', 'wpbs_enqueue_assets');
}

// Security: remove WP version from head
remove_action('wp_head', 'wp_generator');

// Clean up head (optional hardening)
function wpbs_cleanup_head() {
    // Remove wp-emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
}
add_action('init', 'wpbs_cleanup_head');
```

**Opmerking:** CDN-versies hierboven gebruiken 5.3.4 — update naar de laatste 5.3.x versie indien gewenst. Voor sterke SRI-controles kun je integriteits-hashes toevoegen; voeg die toe in een custom enqueue wrapper als je hashes hebt.

---

## header.php
```php
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="site-header">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#primaryMenu" aria-controls="primaryMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="primaryMenu">
        <?php
          wp_nav_menu(array(
            'theme_location' => 'primary',
            'container' => false,
            'menu_class' => 'navbar-nav ms-auto mb-2 mb-lg-0',
            'fallback_cb' => 'wp_page_menu',
            'walker' => null
          ));
        ?>
      </div>
    </div>
  </nav>
</header>

<main class="container mt-4" id="main" role="main">
```

---

## footer.php
```php
</main>

<footer class="site-footer bg-light mt-5 py-4">
  <div class="container text-center">
    <p class="mb-0">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
```

---

## index.php
```php
<?php get_header(); ?>

<div class="row">
  <div class="col-md-8">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <?php get_template_part('template-parts/content', get_post_type()); ?>
    <?php endwhile; else : ?>
      <p><?php esc_html_e('Geen berichten gevonden.', 'wp-bootstrap-starter'); ?></p>
    <?php endif; ?>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
      <?php
        echo paginate_links(array(
          'prev_text' => __('&laquo; Vorige', 'wp-bootstrap-starter'),
          'next_text' => __('Volgende &raquo;', 'wp-bootstrap-starter'),
        ));
      ?>
    </nav>
  </div>

  <aside class="col-md-4">
    <?php get_sidebar(); ?>
  </aside>
</div>

<?php get_footer(); ?>
```

---

## template-parts/content.php
```php
<article id="post-<?php the_ID(); ?>" <?php post_class('mb-4'); ?>>
  <header>
    <h2 class="h4"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <p class="text-muted small mb-2"><?php echo get_the_date(); ?> · <?php the_author(); ?></p>
  </header>
  <div class="entry-content">
    <?php the_excerpt(); ?>
  </div>
  <footer>
    <a class="btn btn-sm btn-primary" href="<?php the_permalink(); ?>"><?php _e('Lees meer', 'wp-bootstrap-starter'); ?></a>
  </footer>
</article>
```

---

## single.php
```php
<?php get_header(); ?>
<div class="row">
  <div class="col-md-8">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
        <h1><?php the_title(); ?></h1>
        <p class="text-muted small"><?php echo get_the_date(); ?> · <?php the_author(); ?></p>
        <div class="entry-content"><?php the_content(); ?></div>
      </article>
    <?php endwhile; endif; ?>
  </div>
  <aside class="col-md-4"><?php get_sidebar(); ?></aside>
</div>
<?php get_footer(); ?>
```

---

## page.php
```php
<?php get_header(); ?>
<div class="row">
  <div class="col-md-12">
    <?php while (have_posts()) : the_post(); ?>
      <article <?php post_class(); ?>>
        <h1><?php the_title(); ?></h1>
        <div class="entry-content"><?php the_content(); ?></div>
      </article>
    <?php endwhile; ?>
  </div>
</div>
<?php get_footer(); ?>
```

---

## sidebar.php
```php
<aside class="widget-area">
  <?php if (is_active_sidebar('primary-sidebar')) : ?>
    <?php dynamic_sidebar('primary-sidebar'); ?>
  <?php else : ?>
    <div class="card mb-3">
      <div class="card-body">
        <p><?php _e('Voeg widgets toe via Weergave → Widgets', 'wp-bootstrap-starter'); ?></p>
      </div>
    </div>
  <?php endif; ?>
</aside>
```

---

## 404.php
```php
<?php get_header(); ?>
<div class="row">
  <div class="col-md-8">
    <h1>404 — Niet gevonden</h1>
    <p>De opgevraagde pagina kon niet worden gevonden.</p>
  </div>
  <aside class="col-md-4"><?php get_sidebar(); ?></aside>
</div>
<?php get_footer(); ?>
```

---

## assets/css/custom.css
```css
/* Plaats hier je custom overrides. Houd selectors specifiek en lichtgewicht. */
```

## assets/js/theme.js
```js
// Kleine helper: active nav link
document.addEventListener('DOMContentLoaded', function () {
  var path = window.location.pathname;
  var links = document.querySelectorAll('.navbar-nav a');
  links.forEach(function (a) {
    if (a.getAttribute('href') === path) a.classList.add('active');
  });
});
```

---

## Aanbevelingen & vervolgstappen
- Voeg SRI (integrity) hashes toe aan CDN-links voor extra supply-chain veiligheid.
- Overweeg lokale bundling (npm + build) voor offline betrouwbaarheid en pinning.
- Voeg `theme.json` en block-styles toe om Gutenberg-compatibiliteit te verbeteren.
- Wil je een npm/Sass pipeline (Dart Sass + PostCSS + Autoprefixer + source maps)? Ik kan meteen een minimal `package.json` + `webpack`/`vite` config genereren.

---
