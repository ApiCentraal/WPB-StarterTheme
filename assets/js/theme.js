/**
 * WP Bootstrap Starter - Theme JavaScript
 * 
 * Vanilla JavaScript (geen jQuery nodig voor Bootstrap 5)
 * Wordt geladen in de footer na Bootstrap Bundle
 *
 * @package WP_Bootstrap_Starter
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
        var navLinks = document.querySelectorAll('.navbar-nav a.nav-link');
        
        navLinks.forEach(function (link) {
            var linkPath = new URL(link.href, window.location.origin).pathname;
            
            // Exacte match of home page
            if (linkPath === currentPath || 
                (currentPath === '/' && linkPath === '/')) {
                link.classList.add('active');
                link.setAttribute('aria-current', 'page');
                
                // Also mark parent dropdown as active if exists
                var parentDropdown = link.closest('.dropdown');
                if (parentDropdown) {
                    var dropdownToggle = parentDropdown.querySelector('.dropdown-toggle');
                    if (dropdownToggle) {
                        dropdownToggle.classList.add('active');
                    }
                }
            }
        });
    })();
    
    // =========================================================================
    // SMOOTH SCROLL
    // =========================================================================
    
    /**
     * Smooth scroll naar anker links
     */
    (function initSmoothScroll() {
        var anchorLinks = document.querySelectorAll('a[href^="#"]:not([href="#"]):not([data-bs-toggle])');
        
        anchorLinks.forEach(function (link) {
            link.addEventListener('click', function (e) {
                var targetId = this.getAttribute('href').substring(1);
                var targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    e.preventDefault();
                    
                    // Account for fixed header
                    var header = document.querySelector('.site-header');
                    var headerHeight = header ? header.offsetHeight : 0;
                    
                    var targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                    
                    // Set focus for accessibility
                    targetElement.setAttribute('tabindex', '-1');
                    targetElement.focus();
                }
            });
        });
    })();
    
    // =========================================================================
    // SKIP LINK FOCUS FIX
    // =========================================================================
    
    /**
     * Zorgt dat skip link focus correct werkt in alle browsers
     */
    (function initSkipLinkFocusFix() {
        var skipLink = document.querySelector('.skip-link');
        
        if (skipLink) {
            skipLink.addEventListener('click', function (e) {
                var targetId = this.getAttribute('href').substring(1);
                var targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    e.preventDefault();
                    targetElement.setAttribute('tabindex', '-1');
                    targetElement.focus();
                }
            });
        }
    })();
    
    // =========================================================================
    // SEARCH FORM TOGGLE
    // =========================================================================
    
    /**
     * Toggle zoekformulier in header (optioneel)
     */
    (function initSearchToggle() {
        var searchToggle = document.querySelector('.search-toggle');
        var searchForm = document.querySelector('.header-search-form');
        
        if (searchToggle && searchForm) {
            searchToggle.addEventListener('click', function (e) {
                e.preventDefault();
                searchForm.classList.toggle('show');
                
                if (searchForm.classList.contains('show')) {
                    var searchInput = searchForm.querySelector('.search-field');
                    if (searchInput) {
                        searchInput.focus();
                    }
                }
            });
            
            // Close on escape
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && searchForm.classList.contains('show')) {
                    searchForm.classList.remove('show');
                    searchToggle.focus();
                }
            });
        }
    })();
    
    // =========================================================================
    // BACK TO TOP BUTTON
    // =========================================================================
    
    /**
     * Toont/verbergt "terug naar boven" knop
     */
    (function initBackToTop() {
        var backToTop = document.querySelector('.back-to-top');
        
        if (backToTop) {
            // Show/hide based on scroll position
            window.addEventListener('scroll', function () {
                if (window.pageYOffset > 300) {
                    backToTop.classList.add('show');
                } else {
                    backToTop.classList.remove('show');
                }
            });
            
            // Scroll to top on click
            backToTop.addEventListener('click', function (e) {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
    })();
    
    // =========================================================================
    // RESPONSIVE EMBEDS
    // =========================================================================
    
    /**
     * Maakt embedded videos responsive
     */
    (function initResponsiveEmbeds() {
        var embeds = document.querySelectorAll('.entry-content iframe[src*="youtube"], .entry-content iframe[src*="vimeo"]');
        
        embeds.forEach(function (embed) {
            // Skip if already wrapped
            if (embed.parentElement.classList.contains('ratio')) {
                return;
            }
            
            var wrapper = document.createElement('div');
            wrapper.classList.add('ratio', 'ratio-16x9', 'mb-3');
            embed.parentNode.insertBefore(wrapper, embed);
            wrapper.appendChild(embed);
        });
    })();
    
    // =========================================================================
    // TABLE RESPONSIVE WRAPPER
    // =========================================================================
    
    /**
     * Wrap tabellen in content met responsive container
     */
    (function initResponsiveTables() {
        var tables = document.querySelectorAll('.entry-content table:not(.table)');
        
        tables.forEach(function (table) {
            // Skip if already wrapped
            if (table.parentElement.classList.contains('table-responsive')) {
                return;
            }
            
            table.classList.add('table', 'table-striped', 'table-hover');
            
            var wrapper = document.createElement('div');
            wrapper.classList.add('table-responsive', 'mb-3');
            table.parentNode.insertBefore(wrapper, table);
            wrapper.appendChild(table);
        });
    })();
    
});
