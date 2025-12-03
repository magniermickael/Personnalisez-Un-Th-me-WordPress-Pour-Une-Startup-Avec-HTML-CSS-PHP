<?php
/**
 * Footer du thème enfant Planty
 * Remplace le footer Twenty Twenty par un footer minimal.
 */
?>

<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // sécurité : on empêche l'accès direct au fichier
}
?>

<footer id="site-footer" class="header-footer-group planty-footer"> <!-- Pied de page du site -->

	<div class="section-inner planty-footer-inner"> <!-- Conteneur interne du footer -->

		<a class="planty-footer-link" href="http://localhost/Planty/politique-de-confidentialite/"><!-- Lien vers la page des mentions légales -->
			Mentions légales</a> <!-- Texte du lien -->


	</div><!-- .planty-footer-inner -->

</footer><!-- #site-footer -->

<?php wp_footer(); ?> <!-- Appel obligatoire pour charger les scripts et autres éléments avant la fermeture de la balise body ?>	-->

</body>

</html>