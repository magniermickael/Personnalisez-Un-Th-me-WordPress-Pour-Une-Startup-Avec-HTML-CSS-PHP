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



/** Masque le lien de menu "Admin" pour les visiteurs non connectés   (ajout de la classe menu-item-admin sur l'item Admin dans le menu) */
add_filter( 'wp_nav_menu_objects', function( $items, $args ) {             // Filtre les éléments du menu de navigation

    // Emplacements sur lesquels on veut filtrer (Twenty Twenty : primary, mobile, expanded)
    $locations_to_filter = array( 'primary', 'mobile', 'expanded' );

    //Vérifie si l'emplacement du menu est défini et s'il fait partie des emplacements à filtrer    
    if ( empty( $args->theme_location ) || ! in_array( $args->theme_location, $locations_to_filter, true ) ) {
        return $items;                                                     // on ne touche pas aux autres menus (footer, social, etc.)
    }

    // Si l'utilisateur est connecté, on ne cache rien
    if ( is_user_logged_in() ) {
        return $items;                                                      // retourne les éléments du menu sans modification
    }

    foreach ( $items as $k => $item ) {// Parcourt chaque élément du menu

        $classes = is_array( $item->classes ) ? $item->classes : array();   // Récupère les classes CSS de l'élément
        $url     = rtrim( (string) $item->url, '/' );                       // Récupère l'URL de l'élément en supprimant le slash final

        $is_admin =                                                         // Vérifie si l'élément correspond au lien "Admin"
            in_array( 'menu-item-admin', $classes, true ) ||                // Vérifie si l'élément a la classe menu-item-admin
            $url === rtrim( admin_url(), '/' ) ||                           // Vérifie si l'URL est exactement l'URL d'administration
            ( function_exists( 'str_contains' )
                ? str_contains( $url, rtrim( admin_url(), '/' ) )           // Vérifie si l'URL contient l'URL d'administration
                : strpos( $url, rtrim( admin_url(), '/' ) ) !== false       // Pour les versions de PHP sans str_contains
            );                                                              // Fin de la vérification

        if ( $is_admin ) {                                                  // Si le lien correspond à "Admin" et que le visiteur n'est pas connecté    
            unset( $items[ $k ] );                                          // on supprime cet élément du menu
        }                                                                   // Fin de la condition
    }                                                                       // Fin de la boucle foreach

    return $items;                                                          // Retourne les éléments modifiés du menu
}, 10, 2 );                                                                 // Priorité 10, 2 arguments (éléments du menu et arguments du menu)



/**
 * Désactive les "auto sizes" et le CSS `contain-intrinsic-size`
 * ajouté par WordPress (évite l'erreur W3C sur contain-intrinsic-size).
 */
add_filter( 'wp_img_tag_add_auto_sizes', '__return_false' );



// Désactive complètement le chargement spéculatif (script type="speculationrules")
add_filter( 'wp_speculation_rules_configuration', '__return_null' );

/**
 * Nettoie les slashs de fermeture XHTML sur les éléments vides
 * (meta, link, img, input, br, hr, etc.) pour éviter les messages
 * "Trailing slash on void elements" du validateur W3C.
 */
function planty_clean_void_elements_trailing_slash( $html ) {

    $pattern = '#<\s*(meta|link|img|br|hr|input|area|base|col|embed|param|source|track|wbr)([^>]*?)\s*/\s*>#i';
    $replacement = '<$1$2>';

    return preg_replace( $pattern, $replacement, $html );
}

function planty_start_output_buffer() {
    // On évite d’embêter l’admin WP.
    if ( is_admin() ) {
        return;
    }

    ob_start( 'planty_clean_void_elements_trailing_slash' );
}
add_action( 'template_redirect', 'planty_start_output_buffer' );