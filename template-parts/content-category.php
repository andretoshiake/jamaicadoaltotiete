<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package JAT
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="card-deck">
        <?php
            // $title = get_sub_field('title');
            ?>
            <div class="card" onclick="location='<?php the_permalink(); ?>'">
                <div class="jat-thumb">
                    <img class="card-img-top" src="<?php the_post_thumbnail_url(); ?>" alt="<?php echo esc_html( get_the_title() ); ?>" >
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo wp_trim_words( get_the_title(), 10, '...' ); ?></h5>
                    <?php the_excerpt(); ?>
                    <hr />
                    <p class="card-text">Publicado em: <?php jat_custom_posted_on(); ?></p>
                </div>
            </div>
            <?php
        ?>
    </div>
</article><!-- #post-<?php the_ID(); ?> -->
