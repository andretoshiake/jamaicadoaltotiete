<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package JAT
 */

get_header();
?>

	<main id="primary" class="site-main">
        
        <div class="jumbotron" style="background-image: linear-gradient(to bottom, rgba(247, 217, 2), rgba(255, 255, 204, 0.73)), url('<?php echo get_template_directory_uri() . '/img/jogos_fundo.jpg'; ?>')">
            <div class="container">
                <img src="<?php echo get_template_directory_uri() . '/img/blog_titulo.png'; ?>" style="width: 100%;"/>
            </div>
        </div>

        <div class="container">

            <?php if ( have_posts() ) : ?>

                <header class="page-header">
                    <?php
                    the_archive_title( '<h1 class="page-title">', '</h1>' );
                    the_archive_description( '<div class="archive-description">', '</div>' );
                    ?>
                </header><!-- .page-header -->

                <?php get_template_part('inc/searchform'); ?>

                <?php
                /* Start the Loop */
                while ( have_posts() ) :
                    the_post();

                    /*
                     * Include the Post-Type-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                     */
                    if ( is_archive() ) :
                        $template = basename(__FILE__, '.php');
                        get_template_part( 'template-parts/content', $template );
                    else :
                        get_template_part( 'template-parts/content', get_post_type() );
                    endif;

                endwhile;
            
                ?>
                <div class="jat-pagination"><?php wp_pagenavi(); ?></div>
                <?php

            else :

                get_template_part( 'template-parts/content', 'none' );

            endif;
            ?>
            
        </div><!-- .container -->

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
