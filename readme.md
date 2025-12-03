<img alt="Static Badge" src="https://img.shields.io/badge/Projet%20finalis%C3%A9-vert?style=flat&logoColor=vert">
# 🌿 Planty – Personnalisation du thème Twenty Twenty (Projet OpenClassrooms)

> ⚠️ **Note importante sur les branches Git**  
> Je laisse **toutes les branches visibles volontairement** dans ce dépôt.  
> Je **ne nettoie pas** les branches une fois le projet terminé afin de montrer **tout le processus de travail** :  
> création des branches, développements, fusions, corrections, finalisation.  
> Cela permet de visualiser clairement mon utilisation de Git et du workflow Gitflow pendant le projet.

---

## 📖 Contexte du projet

Ce dépôt contient le projet **Planty**, réalisé dans le cadre de ma formation OpenClassrooms :  
**Personnalisez un thème WordPress pour une startup avec HTML, CSS et PHP**.

Objectifs principaux du projet :

- Mettre en place un environnement WordPress en local.
- Créer un **thème enfant** basé sur **Twenty Twenty**.
- Reproduire la maquette fournie (Figma) pour :
  - le **header**,
  - le **footer**,
  - la **page d’accueil**,
  - la page **“Nous rencontrer”**,
  - la page **“Commander”**.
- Gérer le versionnement avec **Git** et **GitHub** en suivant un workflow **Gitflow**.
- Mettre en place des formulaires fonctionnels (Contact Form 7 + WP Mail SMTP).
- Assurer un code propre (validation W3C, structure claire, responsive, etc.).

---

## 🛠️ Stack technique & extensions

- **WordPress** (installation locale via XAMPP)
- **PHP / MySQL**
- **Thème parent** : Twenty Twenty
- **Thème enfant** : Planty

Extensions principales :

- **Elementor** – construction visuelle des pages (Hero, sections, etc.)
- **Contact Form 7** – gestion de tous les formulaires (contact + commande)
- **WP Mail SMTP** – configuration de l’envoi d’e-mails
- **UpdraftPlus** – sauvegardes fichiers + base de données
- (Historiquement : **WPForms** a été utilisé puis remplacé par Contact Form 7 pour harmonisation)

---

## 📂 Structure du dépôt (vue générale)

Le dépôt contient l’installation WordPress avec notamment :

- `wp-content/themes/twentytwenty/` → thème parent
- `wp-content/themes/Planty/` → **thème enfant Planty**
  - `style.css` → en-tête du thème + surcharge CSS (header, footer, pages, responsive…)
  - `functions.php` → chargement des styles, police Syne, logique du lien “Admin” dans les menus
  - `footer.php` → surcharge complète du footer du thème parent
  - éventuellement : `screenshot.jpg` / `screenshot.png` → aperçu du thème dans l’admin WP

Selon la version du dépôt, des fichiers supplémentaires (journal de bord, exports, etc.) peuvent être présents à la racine.

---

## 🚀 Installation en local

### 1. Prérequis

- **XAMPP** (ou équivalent : Apache + MySQL + PHP)
- **Git**
- Navigateur web moderne

### 2. Cloner le dépôt

Dans le dossier de vos projets (par exemple `C:\xampp\htdocs` sous Windows) :

```bash
git clone <URL_DU_DEPOT_GITHUB> Planty
Adapter le nom du dossier si besoin.
Sous XAMPP, le répertoire doit se trouver dans htdocs pour être accessible via le navigateur.

3. Base de données
Lancer Apache et MySQL depuis le panneau de contrôle XAMPP.

Aller sur http://localhost/phpmyadmin.

Créer une base de données, par exemple : planty.

Deux possibilités selon le contenu du dépôt :

soit importer un dump SQL fourni,

soit lancer l’installateur WordPress classique à l’adresse http://localhost/Planty et suivre les étapes.

4. Configuration WordPress
Suivre l’installation WordPress (nom du site, identifiants admin…).

Dans l’admin, aller dans Apparence > Thèmes.

Activer le thème enfant Planty.

🎨 Thème enfant Planty
Le thème enfant Planty surcharge le thème parent Twenty Twenty sans le modifier directement, afin :

de garantir la compatibilité avec les mises à jour,

de garder un code propre,

et de centraliser la personnalisation dans le thème enfant.

CSS & chargement des styles
Dans functions.php, je charge :

le style.css du thème parent,

puis le style.css du thème enfant (pour que mes styles écrasent ceux du parent),

ainsi que la police Syne (Google Fonts) utilisée sur l’ensemble du site.

Le fichier style.css gère :

le header : barre blanche, menu horizontal en flexbox, CTA rose “Commander”, comportement desktop/mobile,

le footer : bandeau bas avec lien “Mentions légales”, styles spécifiques,

la page d’accueil (Hero, section “Les goûts”, CTA),

la page “Nous rencontrer”,

la page “Commander” (formulaire avancé),

le responsive (desktop, tablette, mobile).

🧭 Header
Le header repose toujours sur la structure native de Twenty Twenty, mais le rendu visuel est complètement personnalisé via le thème enfant :

Fond blanc, hauteur maîtrisée.

Menu horizontal centré en flexbox.

Liens texte noirs, sobres, conformes à la maquette.

Bouton CTA “Commander” rose avec texte blanc, stylé via une classe dédiée.

Sur mobile :

menu desktop masqué,

burger menu (hamburger) du thème parent conservé,

CTA adapté dans la modale mobile.

Tout cela est fait en CSS uniquement, sans toucher au header.php du parent, pour rester dans les bonnes pratiques WordPress.

📌 Fonctionnalité “Lien Admin invisible si non connecté”
Dans le thème enfant, j’ai ajouté une fonction dans functions.php qui filtre les éléments des menus afin de masquer le lien “Admin” pour les visiteurs non connectés.

Caractéristiques :

Le filtrage s’applique à tous les emplacements de menu :

menu principal (desktop),

menu hamburger (mobile),

menu étendu / latéral (expanded).

Je détecte le lien “Admin” via :

une classe spécifique (menu-item-admin),

l’URL de l’admin (/wp-admin/),

le contexte du menu.

Si l’utilisateur n’est pas connecté, l’item est supprimé du tableau d’items avant rendu.

Résultat :
Le lien “Admin” est visible uniquement pour les utilisateurs authentifiés, et totalement invisible (même dans le HTML) pour les visiteurs.

🦶 Footer personnalisé
J’ai créé un fichier footer.php dans le thème enfant, ce qui surcharge le footer du thème parent.

Principes :

Je garde les identifiants/classes structurants (#site-footer, .header-footer-group, .section-inner) pour rester compatible avec les scripts/styles du parent.

J’ajoute une classe .planty-footer pour cibler facilement le footer dans mon CSS.

Le contenu est recentré dans une zone de largeur max (1440px), hauteur fixe (60px), aligné en flex.

Le lien “Mentions légales” pointe dynamiquement vers la page WordPress du même nom (via get_page_by_path() + get_permalink() + esc_url()).

Tous les styles imposés par Twenty Twenty (bordures, marges, couleurs de liens) sont neutralisés et remplacés par mon design (texte noir, pas de soulignement, etc.).

🏠 Pages développées
1. Page d’accueil
Réalisée avec Elementor + CSS du thème enfant.

Hero :

Titre en deux lignes centré.

Trois images (feuille gauche, canette, feuille droite) composées en un visuel cohérent.

Séparateur incurvé en bas de section pour la signature graphique.

Section “Les goûts” :

4 blocs saveurs (Fraise, Pamplemousse, Framboise, Citron) sous forme de Image Box.

Classe CSS personnalisée pour contrôler mise en page et typographie.

Texte centré dans l’image via flexbox.

Bouton “commander” en CTA secondaire, centré en bas de la section.

Page responsive : desktop, tablette et mobile ont été ajustés finement.

2. Page “Nous rencontrer”
Créée avec Elementor pour respecter la maquette :

Bandeau supérieur avec fond beige et shape divider courbé.

Titre “NOUS RENCONTRER” + texte introductif + image décorative Planty.

Section “L’équipe” :

3 profils présentés via Image Box, noms + rôles, alignement centré.

Élément graphique (feuille verte) pour garder l’identité visuelle.

Bloc “Nous contacter” :

Formulaire de contact géré par Contact Form 7 (Nom, E-mail, Message).

Intégration dans la page via shortcode.

Alignement, marges et styles ajustés via le thème enfant.

Image décorative sous la zone de message.

Page entièrement responsive : mise en page adaptée sur desktop, tablette et mobile.

3. Page “Commander”
Page clé du projet, permettant à l’utilisateur :

de choisir les quantités pour chaque saveur,

de renseigner ses coordonnées,

d’envoyer une demande de commande.

Formulaire (Contact Form 7)
Le formulaire est entièrement construit à la main en mélangeant :

HTML pour la structure (div, label, etc.),

shortcodes CF7 pour les champs ([text], [email], [number], [submit], etc.).

Les champs sont organisés en deux grandes parties :

Sélection des boissons (4 vignettes fruits avec quantité),

Informations & livraison (Nom, prénom, e-mail, adresse, etc.).

Des classes CSS précises sont ajoutées aux shortcodes (ex. class:qty-fraise, class:nom-commande) pour styliser chaque élément dans style.css.

Styles & responsive
.form-commande gère le fond vert, la typographie, la disposition globale.

Les messages de confirmation / erreur CF7 sont stylés selon la charte Planty.

Tablette (769–1024px) :

même logique que le desktop, mais plus resserrée.

Mobile (≤ 768px) :

refonte complète de la mise en page :

chaque fruit sur une ligne, en pleine largeur,

libellé centré, input juste en dessous,

sections “Informations” et “Livraison” en une colonne,

bouton “COMMANDER” centré.

✉️ Envoi d’e-mails & SMTP
WP Mail SMTP
Pour fiabiliser l’envoi des formulaires, j’utilise WP Mail SMTP.

Mode : Other SMTP (configuration manuelle).

En environnement local, j’ai utilisé une adresse Gmail personnelle comme expéditeur pour les tests.

Des tests ont été réalisés depuis les formulaires de contact et de commande pour vérifier que :

les e-mails partent bien,

les données saisies sont correctement incluses,

les messages arrivent bien en boîte de réception.

En production, il suffit d’adapter la configuration SMTP à l’adresse officielle de Planty.

Contact Form 7
Tous les formulaires du site (contact + commande) sont gérés avec Contact Form 7.

Les messages de confirmation ont été configurés pour améliorer l’expérience utilisateur (message sur la même page plutôt que redirection brute).

💾 Sauvegardes
Pour sécuriser le projet, j’ai mis en place UpdraftPlus :

Activation du plugin.

Configuration d’une sauvegarde complète :

fichiers du site (thèmes, plugins, uploads),

base de données.

Lancement d’une sauvegarde manuelle une fois le projet finalisé.

Cette sauvegarde représente un instantané du site Planty à l’état final, utile pour toute restauration ou migration.

✅ Qualité & validation W3C
Les trois pages principales :

Page d’accueil

Page “Nous rencontrer”

Page “Commander”

ont été passées dans le validateur HTML du W3C.

Les erreurs et avertissements ont été corrigés.

Le code est conforme aux standards HTML, ce qui améliore :

la compatibilité multi-navigateurs,

la maintenabilité du projet.

🔀 Workflow Git & branches conservées
J’ai utilisé un workflow inspiré de Gitflow avec :

master → branche de production / version finale livrée.

develop → branche d’intégration, où toutes les fonctionnalités sont fusionnées avant d’être figées dans master.

branches de fonctionnalités (feature branches), par exemple :

feature/header

feature/footer

feature/home-page

feature/nous-rencontrer

feature/commander

feature/finalisation (derniers réglages, formulaires, SMTP, W3C, etc.)

Cycle typique :

Création d’une branche de fonctionnalité depuis develop.

Développement + commits réguliers.

Push de la branche sur GitHub.

Fusion dans develop une fois la fonctionnalité validée.

À la fin du projet :

fusion de la branche de finalisation dans develop,

puis fusion de develop dans master,

push des deux branches sur GitHub.

🔎 Rappel volontaire :
Je ne supprime pas les branches une fois le projet terminé.
C’est un choix pédagogique afin de laisser visible tout l’historique de travail, étape par étape.

📎 Journal de bord détaillé
Ce README donne une vue d’ensemble du projet.
Pour un suivi plus détaillé (captures d’écran, commandes Git, explications techniques pas à pas), je fournis en complément un journal de bord du développement (document PDF) qui retrace :

l’installation de l’environnement,

la création du thème enfant,

les modifications du header/footer,

la construction des pages,

le paramétrage des formulaires,

la mise en place de SMTP et des sauvegardes,

le détail des fusions Git.

📄 Licence / usage
Projet réalisé dans le cadre d’une formation OpenClassrooms.
Ce dépôt a une vocation pédagogique : démontrer ma capacité à :

installer et configurer WordPress,

créer et personnaliser un thème enfant,

intégrer une maquette Figma,

gérer des formulaires avancés,

utiliser Git et GitHub de manière professionnelle.