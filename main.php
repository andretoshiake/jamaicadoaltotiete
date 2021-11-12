<?php
/**
 * Template Name: Main Page
 */

get_header();
?>

<main id="primary" class="site-main">

    <!--Start: Conteúdo-->
    <?php get_template_part('inc/highlight-first'); ?>

    <?php get_template_part('inc/news'); ?>

    <?php get_template_part('inc/highlight-second'); ?>

    <?php get_template_part('inc/highlight-third'); ?>

    <?php get_template_part('inc/highlight-player'); ?>
    <!--End: Conteúdo-->

</main><!-- #main -->

<?php
get_sidebar();
get_footer();
