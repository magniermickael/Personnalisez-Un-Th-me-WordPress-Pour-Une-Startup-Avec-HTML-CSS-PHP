🌱 Planty – Thème enfant WordPress










Projet développé dans le cadre de ma formation OpenClassrooms.
Objectif : créer un thème enfant WordPress fidèle à la maquette Planty, versionné proprement et entièrement personnalisable.

🔧 1) Mise en place de l’environnement

Installation locale sous XAMPP

Déplacement de WordPress dans htdocs → renommé Planty

Activation de Apache et MySQL

Création de la base de données Planty

Installation WordPress via navigateur

Activation du thème parent Twenty Twenty

🌀 2) Initialisation Git & Workflow

git init

Dépôt GitHub créé

Ajout du remote

Mise en place du workflow :

master

develop

feature/... pour chaque fonctionnalité

🎨 3) Création du thème enfant Planty

📁 Arborescence
wp-content/
└── themes/
    └── Planty/
        ├── style.css
        ├── functions.php
        └── (screenshot.jpg à venir)

🎨 style.css

Ajout de l’en-tête WordPress obligatoire :

Nom du thème

Template : twentytwenty

Version

Author

Text Domain

🔌 functions.php

Chargement des styles du thème parent puis du thème enfant :

add_action('wp_enqueue_scripts', 'planty_child_enqueue_styles');


→ Sans @import, méthode propre et moderne.

🧩 4) Développement du header (branche feature/header)

4.1) Branche dédiée
git checkout -b feature/header

4.2) Structure héritée

J'ai conservé l’ossature native de Twenty Twenty :

#site-header

.header-inner.section-inner

.primary-menu-wrapper

Gestion hamburger & modal mobile

→ Compatibilité + responsivité native conservées.

4.3) Refonte visuelle du header
✔ Fond blanc
✔ Hauteur fixe 80px
✔ Menu en flexbox
✔ Liens centrés verticalement
✔ Alignement propre, fidèle à la maquette
4.4) CTA “Commander”

Classe .menu-item-cta créée dans WordPress

UI rose Planty

Variable CSS :

:root { --planty-cta: #DC9F96; }


Style adapté desktop/mobile

📱 5) Version mobile

Masquage du menu desktop sous 1000px

Activation forcée du hamburger

Style du CTA dans la modal mobile

Cohérence parfaite avec la version desktop

🔒 6) Bonne pratique WordPress : surcharge CSS uniquement

Je n’ai pas modifié le fichier header.php du thème parent.
Je surcharge uniquement via le thème enfant :

✔ Pas de rupture lors des mises à jour du parent
✔ Compatibilité assurée
✔ Code maintenable
✔ Design 100% maîtrisé

🔐 7) Lien “Admin” caché si utilisateur non connecté

7.1) Objectif

Empêcher les visiteurs non connectés de voir un lien pointant vers /wp-admin.

7.2) Hook utilisé : wp_nav_menu_objects

Ce hook permet :

➜ d’intercepter les items du menu
➜ juste avant qu’ils s’affichent

7.3) Filtrage intelligent

Détection du lien Admin grâce à :

Classe CSS menu-item-admin

URL exacte via admin_url()

Recherche de /wp-admin (compatible PHP 7 & 8)

7.4) Suppression réelle de l’item
unset($items[$index]);


→ Le lien n’est pas caché, il est supprimé du HTML.
→ Impossible à inspecter / à cliquer.

🚧 8) Suite du développement (En cours…)

Les étapes suivantes seront ajoutées prochainement :

🔧 Création du footer (feature/footer)

🖼 Intégration des pages principales

📱 Responsive complet

📨 Formulaires (contact + précommande)

🧪 Validation W3C

📤 Export fichiers + base SQL

🎤 Préparation de la soutenance

(README mis à jour au fur et à mesure du projet)

👤 Auteur

Mickaël – Développeur WordPress en formation