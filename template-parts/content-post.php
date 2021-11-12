<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package JAT
 */

?>

<div class="jumbotron" style="background-image: linear-gradient(to bottom, rgba(247, 217, 2), rgba(255, 255, 204, 0.73)), url('<?php echo get_template_directory_uri() . '/img/jogos_fundo.jpg'; ?>')">
    <div class="container">
        <img src="<?php echo get_template_directory_uri() . '/img/blog_titulo.png'; ?>" style="width: 100%;"/>
    </div>
</div>

<div class="container">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
            <?php
            if ( is_singular() ) :
                the_title( '<h1 class="entry-title">', '</h1>' );
            else :
                the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            endif;

            if ( 'post' === get_post_type() ) :
                ?>
                <div class="entry-meta">
                    <?php
                    jat_custom_posted_on();
                    jat_custom_posted_by();
                    ?>
                </div><!-- .entry-meta -->
            <?php endif; ?>
        </header><!-- .entry-header -->

        <?php jat_post_thumbnail(); ?>

        <div class="container">
            <div class="row">
                <div class="entry-content col-md-9">
                    <?php
                    the_content(
                        sprintf(
                            wp_kses(
                                /* translators: %s: Name of current post. Only visible to screen readers */
                                __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'jat' ),
                                array(
                                    'span' => array(
                                        'class' => array(),
                                    ),
                                )
                            ),
                            wp_kses_post( get_the_title() )
                        )
                    );

                    wp_link_pages(
                        array(
                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'jat' ),
                            'after'  => '</div>',
                        )
                    );
                    ?>

                    <footer class="entry-footer">
                        <?php // jat_entry_footer(); ?>
                        <?php
                            $categories_list = get_the_category_list( esc_html__( ', ', 'jat' ) );
                            if ( $categories_list ) {
                                /* translators: 1: list of categories. */
                                printf( '<span class="cat-links">' . esc_html__( 'Categorias: %1$s', 'jat' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            }
                        ?>
                        <br />
                        <?php
                            $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'jat' ) );
                            if ( $tags_list ) {
                                /* translators: 1: list of tags. */
                                printf( '<span class="tags-links">' . esc_html__( 'Tags: %1$s', 'jat' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            }
                        ?>
                    </footer><!-- .entry-footer -->
                </div><!-- .entry-content -->

                <div class="entry-content entry-sidebar col-md-3">
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
                </div><!-- .entry-sidebar -->
            </div>
        </div><!-- .container -->
    </article><!-- #post-<?php the_ID(); ?> -->
</div>