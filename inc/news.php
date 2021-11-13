<?php
    $args = array('numberposts' => 3);
    $posts = get_posts($args);
    // echo "<pre>"; print_r($posts); echo "</pre>"; die();
?>

<?php if ( $posts ) : $count = $posts->found_posts; ?>
<div class="container jat-news">
    <br />
    <br />
    <h2 class="jat-header">ÚLTIMAS NOTÍCIAS</h2>
    <hr class="h-row" />
    <br />
    <div class="card-deck">
        <?php
            foreach ( $posts as $post ) : setup_postdata( $post );
                // $title = get_sub_field('title');
                ?>
                <div class="card" onclick="location='<?php the_permalink(); ?>'">
                    <div class="hover-zoom">
                        <a href="<?php the_permalink(); ?>">
                            <img class="card-img-top" src="<?php the_post_thumbnail_url(); ?>" alt="<?php echo esc_html( get_the_title() ); ?>" >
                        </a>
                    </div>
                    <div class="card-body" align="center" style="border-bottom: 8px solid green;">
                        <h5 class="card-title" align="center"><?php echo wp_trim_words( get_the_title(), 10, '...' ); ?></h5>
                        <p class="card-text" align="center"><?php the_excerpt(); ?></p>
                    </div>
                </div>
                <?php
            endforeach; 
            wp_reset_postdata();
        ?>
    </div>
    <br />
    <div class="col-sm-12" align="center">
        <a href="<?php echo home_url('/') . '?s='; ?>" class="btn btn-success btn-player" role="button" style="color: #fff;">ver todas as notícias</a>
    </div>
</div>
<?php endif; ?>