🌱 Planty – Thème enfant WordPress

Projet développé dans le cadre de ma formation OpenClassrooms.
Objectif : créer un thème enfant WordPress respectant la maquette Planty, versionné proprement via Git, totalement personnalisable et conforme aux bonnes pratiques WordPress.

🔧 1) Mise en place de l’environnement

Installation locale avec XAMPP

Téléchargement de WordPress → déplacement dans htdocs/ → renommé Planty

Activation des services Apache / MySQL

Création de la base de données planty

Installation WordPress via navigateur

Activation du thème parent Twenty Twenty

🌀 2) Versionnement Git & Workflow

git init → initialisation du dépôt local

Création du dépôt GitHub

Ajout du remote

Mise en place du workflow propre Gitflow :

master
develop
feature/... pour chaque fonctionnalité


Ce workflow permet de développer de façon modulaire, propre et contrôlée.

🎨 3) Création du thème enfant Planty
📁 Arborescence
wp-content/
└── themes/
    └── Planty/
        ├── style.css
        ├── functions.php
        └── footer.php


(le fichier screenshot.jpg pourra être ajouté pour personnaliser l’aperçu du thème dans l’admin WordPress)

🎨 style.css – En-tête + styles du thème enfant

Le fichier contient l’en-tête obligatoire WordPress :

Nom du thème

Template : twentytwenty

Version

Auteur

Text Domain

Les styles du thème enfant sont ensuite placés sous cet en-tête.

🔌 4) functions.php – Chargement des styles (sans @import)

J’ai ajouté une fonction sécurisée planty_child_enqueue_styles() pour :

Charger la feuille de style du thème parent

Charger la police Syne (Google Fonts)

Charger la feuille de style du thème enfant

Assurer le bon ordre de priorité

La fonction est encapsulée dans un :

if ( ! function_exists( 'planty_child_enqueue_styles' ) )


pour éviter tout conflit si un plugin utilise une fonction du même nom.

add_action('wp_enqueue_scripts', ...) indique à WordPress quand exécuter la fonction (au moment où il prépare l'affichage des styles et scripts).

C’est la manière moderne et correcte de charger le CSS dans WordPress.

🧩 5) Développement du header (branche feature/header)
5.1) Branche dédiée
git checkout -b feature/header

5.2) Structure héritée du parent

J’ai conservé :

#site-header

.header-inner.section-inner

.primary-menu-wrapper

le système hamburger + modal mobile

→ Cela garantit une compatibilité maximale avec les fonctions WordPress (menus, walker, responsive natif…).

5.3) Refonte visuelle complète via le CSS du thème enfant

Fond blanc

Hauteur fixe : 80px

Menu en flexbox

Items alignés verticalement

Espacement maîtrisé

Style noir propre, fidèle à la maquette

5.4) CTA “Commander”

Création d’une classe .menu-item-cta dans WordPress

Mise en forme CSS dédiée :

fond rose (#DC9F96),

texte blanc,

pleine hauteur du header,

padding latéral

Variable CSS créée pour la couleur principale du CTA

5.5) Version mobile

Menu horizontal désactivé sous 1000px

Hamburger forcé et rendu propre

CTA stylisé dans la modale mobile

Cohérence mobile / desktop maintenue

5.6) Bonne pratique WordPress

Aucune modification du header.php parent.
Tout est surchargé via le CSS du thème enfant → meilleure maintainabilité.

🔐 6) Fonctionnalité : “Lien Admin invisible si non connecté”
6.1) Objectif

Empêcher un visiteur non connecté de voir un lien menant à /wp-admin.

6.2) Hook utilisé : wp_nav_menu_objects

Ce hook me donne accès à tous les items du menu avant l’affichage final.
Je peux donc manipuler proprement les éléments.

6.3) Méthode utilisée

Je détecte l’item grâce à :

une classe dédiée .menu-item-admin,

admin_url() (URL exacte du back-office),

la présence de /wp-admin dans l’URL (compatibilité PHP 7 & 8).

Si l’utilisateur n’est pas connecté, l’item est retiré du tableau :

unset($items[$index]);


→ Le lien n’existe plus dans le HTML final.
→ Impossible de l’inspecter ou de le deviner.

🧩 7) Développement du footer (branche feature/footer)
7.1) Création de la branche
git checkout -b feature/footer

7.2) Remplacement du footer du thème parent

J’ai créé un fichier :

Planty/footer.php


Selon les règles WordPress, ce fichier surchage automatiquement le footer du thème parent.

7.3) Sécurité du fichier
if ( ! defined( 'ABSPATH' ) ) { exit; }


→ Empêche l’accès direct au fichier via l’URL.
→ Bonne pratique WordPress.

7.4) Structure HTML minimaliste

Le HTML ne contient que :

un <footer> propre

un conteneur .planty-footer-inner

un lien “Mentions légales” généré dynamiquement

J’ai utilisé les fonctions WordPress :

get_page_by_path('mentions-legales') :
récupère la page via son slug

get_permalink() :
génère automatiquement son URL

esc_url() :
sécurise l’URL avant affichage

→ Le lien reste valide même si l’ID de la page change.

wp_footer(); est conservé pour permettre au thème parent et aux plugins d’injecter leurs scripts (obligatoire).

🎨 7.5) Surcharge CSS du footer dans style.css

J’ai entièrement recréé le design du footer via le CSS enfant :

Structure

Largeur limitée : 1440px

Hauteur fixe : 60px

Contenu centré (flexbox)

Typographie Syne 16px Regular

Neutralisation du footer parent

suppression de la bordure

suppression de la marge haute

suppression des styles par défaut de Twenty Twenty

Forçage des liens

Le parent impose des liens rouges et soulignés.
J’ai donc forcé :

#site-footer a,
#site-footer a:hover,
#site-footer a:focus,
#site-footer a:active { 
    color: black !important;
    text-decoration: none !important;
}


→ lien noir
→ jamais souligné
→ comportement identique dans tous les états
→ rendu parfaitement conforme à la maquette

🔤 7.6) Chargement de la police Syne dans functions.php

J’ai modifié la fonction d’enqueue pour charger :

le style parent

la police Syne

le style enfant

L’enfant dépend donc de :

array( 'planty-style', 'syne-font' )


Ce qui garantit :
→ une police disponible avant l’application du CSS enfant
→ un rendu cohérent sur tout le site

🔁 7.7) Versionnement Git du footer

Ajout des fichiers modifiés

Commit de la nouvelle fonctionnalité

Push vers GitHub

Merge de feature/footer dans develop

Push de la branche develop

🚧 8) Prochaines étapes

Intégration des pages principales

Responsive complet

Formulaire de contact + précommande

Validation W3C

Export SQL + fichiers


👤 Auteur

Mickaël
Développeur WordPress – formation OpenClassrooms