<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
            
            <header class="page-header">
                <h1 class="page-title">
                    <?php
                    /* translators: %s: search query. */
                    if ( get_search_query() )
                        printf( esc_html__( 'Resultados da busca por: %s', 'jat' ), '<span>' . wp_trim_words( get_search_query(), 10, '...' ) . '</span>' );
                    else
                        printf( esc_html__( 'JAT - Notícias', 'jat' ) );
                    ?>
                </h1>
            </header><!-- .page-header -->

            <?php get_template_part('inc/searchform'); ?>
            
            <div class="row">

                <div class="col-md-9">

                    <?php if ( have_posts() ) : ?>

                        <?php
                        /* Start the Loop */
                        while ( have_posts() ) :
                            the_post();

                            /**
                             * Run the loop for the search to output the results.
                             * If you want to overload this in a child theme then include a file
                             * called content-search.php and that will be used instead.
                             */
                            get_template_part( 'template-parts/content', 'search' );

                        endwhile;

                    else :

                        get_template_part( 'template-parts/content', 'none' );

                    endif;

                    ?>

                </div>
                
                <div class="col-md-3 search-sidebar">
                    <div class="list-group panel">
                        <h5 class="list-group-item filter-list strong text-center" data-toggle="collapse">FILTROS</h5>
                        <?php $categories = get_categories(array('hide_empty' => true)); ?>
                        <?php if ( $categories ) : ?>
                            <a href="#filter1" class="list-group-header list-group-item list-group-item-success strong" data-toggle="collapse" aria-expanded="false">CATEGORIAS <i class="fas fa-caret-down pull-right"></i></a>
                            <div class="list-group-submenu collapse" id="filter1">
                                <?php foreach ( $categories as $category ) : ?>
                                    <a href="<?php echo get_category_link($category->term_id); ?>" class="list-group-item"><?php echo $category->name; ?></a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <?php $tags = get_tags(array('hide_empty' => true)); ?>
                        <?php if ( $tags ) : ?>
                            <a href="#filter2" class="list-group-header list-group-item list-group-item-success strong" data-toggle="collapse" aria-expanded="false">TAGS <i class="fas fa-caret-down"></i></a>
                            <div class="list-group-submenu collapse" id="filter2">
                                <?php foreach ( $tags as $tag ) : ?>
                                    <a href="<?php echo get_tag_link($tag->term_id); ?>" class="list-group-item"><?php echo $tag->name; ?></a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
            </div>

            <?php if ( have_posts() ) : ?>
                <div class="jat-pagination"><?php wp_pagenavi(); ?></div>
            <?php endif; ?>

        </div><!-- .container -->

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
