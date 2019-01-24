<?php
/**
 * Enqueues application's CSS and JS
 */

use App\WebRadio\WebRadio;

add_action('wp_enqueue_scripts', function() use ($assets)
{
    /**
    *   CSS
    *   Files should be in public/css
    */
    $assets->enqueueStyle('app.css');

    /**
    *   JavaScript
    *   Files should be in public/js
    */
    $assets->enqueueJavascript('vendor.min.js');

    wp_register_script('app-js', MWW_URL . '/public/js/app.js', ['jquery'], filemtime(MWW_PATH . '/public/js/app.js'), true);

    wp_localize_script('app-js', 'appData', [
        'rest' => [
            'endpoint' => esc_url_raw(rest_url('/lucas/v1/session')),
            'nonce' => wp_create_nonce('wp_rest')
        ],
        'site_url' => get_site_url(),
        'is_webradio_active' => WebRadio::hasSelectedWebRadio(),
        'lucasGif' => [
            'normal' => wp_get_attachment_url(6),
            'sticky' => wp_get_attachment_url(7),
        ],
    ]);
    wp_enqueue_script('app-js');
});

add_action('wp_print_styles', function() {
    wp_deregister_style('dashicons');
    wp_deregister_style('wp-block-library');
});