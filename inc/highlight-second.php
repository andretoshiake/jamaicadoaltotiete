<?php
    $args = array(
        'post_type' => 'banners',
        'post_status' => 'publish',
        'posts_per_page' => 3,
        'meta_query' => array(
            array(
                'key' => 'fields_level',
                'value' => 2,
            ),
        ),
    );
    $h_second = new WP_Query( $args );
    // echo "<pre>"; print_r($h_second); echo "</pre>";
?>

<?php if ( $h_second ) : $count = $h_second->found_posts; ?>
<br />
<br />
<div class="highlight-second" style="background-image: linear-gradient(to bottom, rgba(247, 217, 2), rgba(255, 255, 204, 0.73))">
    <div class="container h-second">
        <h2 class="jat-header">JAT - JAMAICA DO ALTO TIETÊ</h2>
        <hr class="h-row" />
        <br />
        <div class="card-deck">
            <?php
                $i = 0;
                while($h_second->have_posts()) : $h_second->the_post();
                    $itens = get_field('fields');
                    while( have_rows('fields') ): the_row();
                        $image = get_sub_field('image'); 
                        $title = get_sub_field('title'); 
                        $text = get_sub_field('text'); 
                        $link = get_sub_field('link');
                        $window = get_sub_field('window');
                        ?>
                        <div class="card" onclick="location='<?php echo $link; ?>'">
                            <a href="<?php echo $link; ?>">
                                <img class="card-img-top" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo $image['alt'] ?>" >
                            </a>
                            <div class="card-body" style="border-bottom: 8px solid green;">
                                <h5 class="card-title" align="center"><?php echo $title; ?></h5>
                                <p class="card-text" align="center"><?php echo $text; ?></p>
                            </div>
                        </div>
                        <?php
                        $i++;
                    endwhile;
                endwhile; 
            ?>
        </div>
    </div>
</div>
<?php endif; ?>