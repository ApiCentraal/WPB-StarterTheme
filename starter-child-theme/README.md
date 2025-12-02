# WP Bootstrap Starter Child Theme

Dit is een starter child theme voor WP Bootstrap Starter.

## Installatie

1. Zorg dat het parent theme `wp-bootstrap-starter` geïnstalleerd is
2. Kopieer deze `starter-child-theme` map naar `wp-content/themes/`
3. Hernoem de map naar je gewenste thema naam
4. Activeer het child theme via **Weergave → Thema's**

## Aanpassingen

### CSS
Voeg custom styles toe aan `style.css`.

### PHP
Voeg custom functies toe aan `functions.php`.

### Templates
Kopieer template bestanden van het parent theme naar dit child theme om ze te overschrijven:
- `header.php` - Custom header
- `footer.php` - Custom footer
- `single.php` - Enkel bericht template
- `page.php` - Pagina template
- etc.

## Bootstrap

Bootstrap 5.3 is al geladen via het parent theme. Je kunt alle Bootstrap utility classes gebruiken.

### CSS Variabelen
```css
:root {
    --bs-primary: #0d6efd;
    --bs-secondary: #6c757d;
    --bs-success: #198754;
    /* etc. */
}
```

## Support

- Parent Theme: [WPB-StarterTheme](https://github.com/ApiCentraal/WPB-StarterTheme)
- Bootstrap: [getbootstrap.com](https://getbootstrap.com)
