<?php
/**
 * User Profile Extensions
 *
 * Voegt extra social media velden toe aan gebruikersprofielen.
 *
 * @package WP_Bootstrap_Starter
 * @since 0.2.0
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Voegt extra contactmethodes toe aan gebruikersprofielen
 *
 * @param array $methods Bestaande contact methodes.
 * @return array Uitgebreide contact methodes.
 */
function wpbs_user_contact_methods($methods) {
    // Social Media
    $methods['twitter']   = __('X (Twitter) gebruikersnaam', 'wp-bootstrap-starter');
    $methods['facebook']  = __('Facebook URL', 'wp-bootstrap-starter');
    $methods['instagram'] = __('Instagram gebruikersnaam', 'wp-bootstrap-starter');
    $methods['linkedin']  = __('LinkedIn URL', 'wp-bootstrap-starter');
    $methods['github']    = __('GitHub gebruikersnaam', 'wp-bootstrap-starter');
    $methods['youtube']   = __('YouTube kanaal URL', 'wp-bootstrap-starter');

    return $methods;
}
add_filter('user_contactmethods', 'wpbs_user_contact_methods');
