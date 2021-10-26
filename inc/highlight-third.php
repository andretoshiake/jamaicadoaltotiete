<?php
    $args = array(
        'post_type' => 'banners',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'meta_query' => array(
            array(
                'key' => 'fields_level',
                'value' => 3,
            ),
        ),
    );
    $h_third = new WP_Query( $args );
    // echo "<pre>"; print_r($h_third); echo "</pre>";
?>

<?php if ( $h_third ) : $count = $h_third->found_posts; ?>
<div class="hl-third">
    <br />
    <br />
    <?php
        $i = 0;
        while($h_third->have_posts()) : $h_third->the_post();
            $itens = get_field('fields');
            while( have_rows('fields') ): the_row();
                $image = get_sub_field('image'); 
                $title = get_sub_field('title'); 
                $text = get_sub_field('text'); 
                $link = get_sub_field('link');
                $window = get_sub_field('window');
                ?>
                <div>
                    <img src="<?php echo esc_url($image['url']); ?>" class="img-fluid" alt="<?php echo $image['alt'] ?>">
                </div>
                <?php
                $i++;
            endwhile;
        endwhile; 
    ?>
</div>
<?php endif; ?>