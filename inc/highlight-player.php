<?php
    $args = array(
        'post_type' => 'players',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_key' => 'fields_number',
        'orderby' => 'meta_value_num',
        'order'	 => 'ASC',
        'meta_query' => array(
            array(
                'key' => 'fields_main_team',
                'value' => true,
                'compare' => '='
            )
        )
    );

    $result = new WP_Query($args);
    $count = $result->found_posts;

    // echo "<pre>"; print_r($result); echo "</pre>";
?>

<?php if ( $result->have_posts() ) : ?>
<div class="container hl-fourth">
    <br />
    <br />
    <h2 style="font-weight: 700; text-align: center">ELENCO PRINCIPAL</h2>
    <hr style="border: 1px solid #005000; width: 50%;">
    <br />
    <div id="jat-carousel-controls" class="carousel slide h-fourth" data-ride="carousel">
      <div class="carousel-inner">
        <?php
            $i = 0;
            while($result->have_posts()) : $result->the_post(); $obj = $post;
                $player = get_field('fields');
                $player_total_goals = 0;
                $player_total_assists = 0;
                $player_total_blocks = 0;
          
                $args = array(
                    'post_type' => 'matches',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'meta_query' => array(
                        array(
                            'key' => 'fields_players',
                            'value' => serialize(strval($obj->ID)),
                            'compare' => 'LIKE'
                        ),
                        array(
                            'key' => 'fields_context',
                            'value' => 'oficial',
                            'compare' => 'LIKE'
                        )
                    )
                );

                $query = new WP_Query($args);
                $player_total_matches = $query->found_posts;
          
                // Find connected players
                $connected = new WP_Query( array(
                    'connected_type' => 'matches_to_players',
                    'connected_items' => $post,
                    'nopaging' => true,
                    'meta_query' => array(
                        array(
                            'key' => 'fields_context',
                            'value' => 'oficial',
                            'compare' => 'LIKE'
                        )
                    )
                ) );        

                if ( $connected->have_posts() ) :
                    while( $connected->have_posts() ) : $connected->the_post();
                        $goals   = p2p_get_meta( get_post()->p2p_id, 'goals', true );
                        $assists = p2p_get_meta( get_post()->p2p_id, 'assists', true );
                        $blocks  = p2p_get_meta( get_post()->p2p_id, 'blocks', true );
                        $player_total_goals   = $player_total_goals + (int)$goals;
                        $player_total_assists = $player_total_assists + (int)$assists;
                        $player_total_blocks  = $player_total_blocks + (int)$blocks;
                    endwhile;
                endif;
                ?>
                <div class="carousel-item <?php echo ($i == 0) ? 'active' : ''; ?>">
                    <div class="row justify-content-center no-gutters mb-5 mb-lg-0">
                        <div class="col-lg-8" style="background-color: #fff;">
                            <br />
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <p class="numeracao"> <?php echo $player['number']; ?> </p> 
                                    </div>

                                    <div class="col-sm-10">
                                        <p class="nome"> <?php echo get_the_title($obj->ID); ?> </p>
                                    </div>
                                </div>
                            </div>
                            <div class="player-card-resp col-lg-4">
                                <img class="img-fluid" src="<?php echo ( $player['image'] ) ? esc_url($player['image']['url']) : get_template_directory_uri() . '/img/nopicture.png'; ?>">
                            </div>
                            <br /> 
                            <div class="container">
                                <div class="player-stats row" align="center">
                                    <?php if ( 'goleiro' == $player['position'] ) : ?>
                                        <div class="col-sm-6" style="border-right: 2px solid #005000; height: 150px;">
                                            <p class="score"> <?php echo $player_total_matches; ?> </p> 
                                            <p>Jogos</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="score"> <?php echo $player_total_blocks; ?> </p> 
                                            <p>Defesas</p>
                                        </div>
                                    <?php else : ?>
                                        <div class="col-sm-4" style="border-right: 2px solid #005000; height: 150px;">
                                            <p class="score"> <?php echo $player_total_matches; ?> </p> 
                                            <p>Jogos</p>
                                        </div>
                                        <div class="col-sm-4" style="border-right: 2px solid #005000; height: 150px;">
                                            <p class="score"> <?php echo $player_total_goals; ?> </p> 
                                            <p>Gols</p>
                                        </div>
                                        <div class="col-sm-4">
                                            <p class="score"> <?php echo $player_total_assists; ?> </p>
                                            <p>Assistências</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <br />
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12" align="center">
                                        <?php if ( $player['slogan'] ) : ?>
                                        <p class="depoimento">"<?php echo $player['slogan']; ?>"</p>
                                        <?php else : ?>
                                        <p class="depoimento"></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12" align="center">
                                        <a href="<?php echo get_permalink($obj->ID); ?>" class="btn btn-success btn-player" role="button" style="color: #fff;">ver detalhes</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="player-card col-lg-4">
                            <img class="img-fluid" src="<?php echo ( $player['image'] ) ? esc_url($player['image']['url']) : get_template_directory_uri() . '/img/nopicture.png'; ?>">
                        </div>
                    </div>
                </div>
                <?php
                $i++;
            endwhile; 
        ?>
      </div>
      <a class="carousel-control-prev" href="#jat-carousel-controls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#jat-carousel-controls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
    <br />
    <br />
</div>
<?php endif; ?>
