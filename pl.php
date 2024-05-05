<?php
/*
Plugin Name: External Plugin Loader
Description: Laadt externe plugins dynamisch.
Version: 1.0
Author: Jouw Naam
*/

// Functie om externe PHP-bestanden te laden en uit te voeren
function load_external_code($url) {
    // Haal de inhoud van de externe bron op
    $response = wp_remote_get($url);

    // Controleer op fouten
    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
        error_log("Fout bij het laden van extern bestand van URL: $url");
        return;
    }

    // Voer de opgehaalde code uit
    $code = wp_remote_retrieve_body($response);
    eval('?>' . $code);
}

// Lijst van externe plugins om te laden
$external_plugins = [
    'https://raw.githubusercontent.com/alleyinteractive/create-wordpress-plugin/5e133ae4850b44791728b0aa2e42c265ba94ac89/plugin.php',
    'https://raw.githubusercontent.com/alleyinteractive/create-wordpress-plugin/plugin.php',
];

// Laad de externe code bij het starten van de plugin
add_action('init', function() use ($external_plugins) {
    foreach ($external_plugins as $plugin_url) {
        load_external_code($plugin_url);
    }
});
