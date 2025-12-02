/**
 * WP Bootstrap Starter - Theme JavaScript
 * 
 * Vanilla JavaScript (geen jQuery nodig voor Bootstrap 5)
 * Wordt geladen in de footer na Bootstrap Bundle
 */

document.addEventListener('DOMContentLoaded', function () {
    
    // =========================================================================
    // ACTIVE NAV LINK
    // =========================================================================
    
    /**
     * Markeert het huidige menu item als actief
     * 
     * Pipeline:
     * DOMContentLoaded → Loop door nav links → Match met huidige URL → Voeg 'active' class toe
     */
    (function initActiveNavLink() {
        var currentPath = window.location.pathname;
        var navLinks = document.querySelectorAll('.navbar-nav a');
        
        navLinks.forEach(function (link) {
            var linkPath = link.getAttribute('href');
            
            // Exacte match of home page
            if (linkPath === currentPath || 
                (currentPath === '/' && linkPath === window.location.origin + '/')) {
                link.classList.add('active');
                link.setAttribute('aria-current', 'page');
            }
        });
    })();
    
    // =========================================================================
    // SMOOTH SCROLL (optioneel)
    // =========================================================================
    
    /**
     * Smooth scroll naar anker links
     */
    (function initSmoothScroll() {
        var anchorLinks = document.querySelectorAll('a[href^="#"]:not([href="#"])');
        
        anchorLinks.forEach(function (link) {
            link.addEventListener('click', function (e) {
                var targetId = this.getAttribute('href').substring(1);
                var targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    e.preventDefault();
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    })();
    
});
