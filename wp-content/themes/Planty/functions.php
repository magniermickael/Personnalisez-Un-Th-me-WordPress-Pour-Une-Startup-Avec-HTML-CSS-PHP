<?php               
/**
 * Planty Child Theme functions and definitions 
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/ // Documentation des fonctions de thème WordPress
 *
 * @package Planty_Child                                                //  Indique le nom du thème
 */

if ( ! function_exists( 'planty_child_enqueue_styles' ) ) { // Vérifie si la fonction n'existe pas déjà
    // Charger les feuilles de style du thème parent et du thème enfant.
     function planty_child_enqueue_styles() {  // Déclare la fonction pour charger les styles
        
        // Enregistrer et charger la feuille de style du parent (Twenty Twenty)
        wp_enqueue_style( 'planty-style', get_template_directory_uri() . '/style.css' );// URL de la feuille de style du thème parent // 
        
        // Charger la police Syne depuis Google Fonts
        wp_enqueue_style(           
            'syne-font',    // Gérer la police Syne
            'https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700&display=swap', // URL de la police Syne
            array(),        // Pas de dépendances
            null            // Pas de version spécifiée
        );
        
        // Enregistrer et charger la feuille de style du thème enfant, elle dépend de celle du parent, garantissant un chargement dans le bon ordre.
        wp_enqueue_style( 'planty-child-style',                  // Gérer le style du thème enfant
            get_stylesheet_directory_uri() . '/style.css',       // URL de la feuille de style du thème enfant
            array( 'planty-style' ),                             // Dépendance : le style du thème parent doit être chargé avant
            wp_get_theme()->get('Version')                       // Utiliser la version du thème enfant pour garantir l'affichage des nouveaux fichiers.
        );
    }
}
add_action( 'wp_enqueue_scripts', 'planty_child_enqueue_styles' );    // Hook pour charger les styles correctement on “accroche” notre fonction à un moment précis du chargement de WordPress.



/** Cacher "Admin" aux visiteurs (ajoute la classe menu-item-admin sur l’item Admin dans Menus) */
add_filter('wp_nav_menu_objects', function( $items, $args ) {        // Filtre les éléments du menu de navigation
    if ( empty($args->theme_location) || 'primary' !== $args->theme_location ) return $items; // Applique uniquement au menu principal
    if ( is_user_logged_in() ) return $items;                        // Ne rien faire si l'utilisateur est connecté (admin ou autre)

    foreach ( $items as $k => $item ) {                             // Parcourt chaque élément du menu
        $classes = is_array($item->classes) ? $item->classes : array(); // Récupère les classes CSS de l'élément
        $url     = rtrim((string) $item->url, '/');                 // Récupère l'URL de l'élément en supprimant le slash final
        $is_admin = 
            in_array('menu-item-admin', $classes, true) ||          // Vérifie si l'élément a la classe menu-item-admin
            $url === rtrim(admin_url(), '/') ||                     
            ( function_exists('str_contains')
                ? str_contains($url, rtrim(admin_url(), '/'))
                : strpos($url, rtrim(admin_url(), '/')) !== false   
            );                                                      // Vérifie si l'URL contient l'URL d'administration
        if ( $is_admin ) unset($items[$k]);                        // Si le lien correspond à “Admin” et que le visiteur n’est pas connecté,on supprime cet élément du menu
    }
    return $items;                                                 // Retourne les éléments modifiés du menu
}, 10, 2);                                                          // Priorité 10, 2 arguments (éléments du menu et arguments du menu)
