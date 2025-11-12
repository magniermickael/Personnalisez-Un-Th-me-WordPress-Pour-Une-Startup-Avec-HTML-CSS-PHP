<?php
/**
 * Planty Child Theme functions and definitions
 *
 * @package Planty_Child
 */

if ( ! function_exists( 'planty_child_enqueue_styles' ) ) {
    /**
     * Charger les feuilles de style du thème parent et du thème enfant.
     */
    function planty_child_enqueue_styles() {
        // Enregistrer et charger la feuille de style du parent (Twenty Twenty)
        wp_enqueue_style( 'twentytwenty-style', get_template_directory_uri() . '/style.css' );// URL de la feuille de style du thème parent

        // Enregistrer et charger la feuille de style du thème enfant
        // Elle dépend de celle du parent, garantissant un chargement dans le bon ordre.
        wp_enqueue_style( 'planty-child-style', // Gérer le style du thème enfant
            get_stylesheet_directory_uri() . '/style.css', // URL de la feuille de style du thème enfant
            array( 'twentytwenty-style' ), // Dépendance du style parent
            wp_get_theme()->get('Version') // Utiliser la version du thème enfant pour le cache busting
        );
    }
}
add_action( 'wp_enqueue_scripts', 'planty_child_enqueue_styles' ); // Hook pour charger les styles correctement