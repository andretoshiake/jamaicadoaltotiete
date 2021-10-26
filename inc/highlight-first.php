<?php
    $args = array(
        'post_type' => 'banners',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
			'key'		=> 'fields_level',
			'value'		=> 1,
		),
        ),
    );
    $h_first = new WP_Query( $args );
    // echo "<pre>"; print_r($h_first); echo "</pre>";
?>

<?php if ( $h_first ) : $count = $h_first->found_posts; ?>
<div id="jat-carousel-indicators" class="carousel slide h-first" data-ride="carousel">
  <ol class="carousel-indicators">
    <?php for ( $i=0; $i<$count; $i++ ) : ?>
    <li data-target="#jat-carousel-indicators" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i == 0) ? 'active' : ''; ?>"></li>
    <?php endfor; ?>
  </ol>
  <div class="carousel-inner">
    <?php
        $i = 0;
        while($h_first->have_posts()) : $h_first->the_post();
            $itens = get_field('fields');
            while( have_rows('fields') ): the_row(); 
                $image = get_sub_field('image'); 
                $title = get_sub_field('title'); 
                $text = get_sub_field('text'); 
                $link = get_sub_field('link');
                $window = get_sub_field('window');
                ?>
                <div class="carousel-item <?php echo ($i == 0) ? 'active' : ''; ?>">
                    <img src="<?php echo esc_url($image['url']); ?>" class="w-100 d-block" alt="<?php echo $image['alt'] ?>">
                </div>
                <?php
                $i++;
            endwhile;
        endwhile; 
    ?>
  </div>
  <a class="carousel-control-prev" href="#jat-carousel-indicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#jat-carousel-indicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<?php endif; ?>