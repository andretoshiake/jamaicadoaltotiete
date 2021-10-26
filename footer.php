<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package JAT
 */

?>
    
    <!--Start: Patrocínios-->
    <?php get_template_part('inc/sponsors'); ?>
    <!--End: Patrocínios-->

    <!--Start: Redes Sociais-->
    <?php get_template_part('inc/social-media'); ?>    
    <!--End: Redes Sociais-->

    <footer class="footer">
		<div class="container" align="center">
            <br />
            <p style="color: #ddd;"> ©2020 Jamaica do Alto Tietê. Todos os direitos reservados </p>
			<br />
		</div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
