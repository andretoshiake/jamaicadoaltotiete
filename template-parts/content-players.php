<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package JAT
 */

global $wpdb;
$obj = $post;
$player = get_field('fields');

$p_ids = get_posts(array(
    'fields' => 'ids', // Only get post IDs
    'post_type' => 'players',
    'posts_per_page' => -1
));

/*
$p2p_goals   = $wpdb->get_var( "SELECT sum(meta_value) FROM ".$wpdb->prefix."p2pmeta WHERE meta_key = 'goals'" );
$p2p_assists = $wpdb->get_var( "SELECT sum(meta_value) FROM ".$wpdb->prefix."p2pmeta WHERE meta_key = 'assists'" );
$p2p_blocks  = $wpdb->get_var( "SELECT sum(meta_value) FROM ".$wpdb->prefix."p2pmeta WHERE meta_key = 'blocks'" );
$total_goals   = ( $p2p_goals ) ? $p2p_goals : 0;
$total_assists = ( $p2p_assists ) ? $p2p_assists : 0;
$total_blocks  = ( $p2p_blocks ) ? $p2p_blocks : 0;
*/

/********** Start: Stats Jogos Oficiais **********/
$total_goals_oficial   = 0;
$total_assists_oficial = 0;
$total_blocks_oficial  = 0;
$player_total_goals_oficial   = 0;
$player_total_assists_oficial = 0;
$player_total_blocks_oficial  = 0;
$player_total_clean_sheets_oficial = 0;

$args = array(
    'post_type' => 'matches',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'meta_query' => array(
        array(
            'key' => 'fields_context',
            'value' => 'oficial',
            'compare' => 'LIKE'
        )
    )
);
$result = new WP_Query($args);
$total_matches_oficial = $result->found_posts;

$args = array(
    'post_type' => 'matches',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order'   => 'ASC',
    'orderby'   => 'meta_value',
    'meta_key'  => 'fields_date',
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
$result = null;
$result = new WP_Query($args);
$player_total_matches_oficial = $result->found_posts;

$args = array(
    'post_type' => 'matches',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'meta_query' => array(
        array(
            'key' => 'fields_context',
            'value' => 'oficial',
            'compare' => 'LIKE'
        )
    )
);
$connected = null;
$connected = new WP_Query($args);

p2p_type( 'matches_to_players' )->each_connected( $connected );

if ( $connected->have_posts() ) :
    while( $connected->have_posts() ) : $connected->the_post();
        foreach ( $post->connected as $post ) : setup_postdata( $post );
            $goals   = p2p_get_meta( get_post()->p2p_id, 'goals', true );
            $assists = p2p_get_meta( get_post()->p2p_id, 'assists', true );
            $blocks  = p2p_get_meta( get_post()->p2p_id, 'blocks', true );
            $total_goals_oficial   = $total_goals_oficial + $goals;
            $total_assists_oficial = $total_assists_oficial + $assists;
            $total_blocks_oficial  = $total_blocks_oficial + $blocks;
        endforeach;
        wp_reset_postdata(); // set $post back to original post
    endwhile;
endif;

// Find connected players
$connected = null;
$connected = new WP_Query( array(
    'connected_type' => 'matches_to_players',
    'connected_items' => $obj,
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
        $clean_sheets = p2p_get_meta( get_post()->p2p_id, 'clean_sheets', true );
        $player_total_goals_oficial   = $player_total_goals_oficial + $goals;
        $player_total_assists_oficial = $player_total_assists_oficial + $assists;
        $player_total_blocks_oficial  = $player_total_blocks_oficial + $blocks;
        $player_total_clean_sheets_oficial = $player_total_clean_sheets_oficial + intval($clean_sheets);
    endwhile;
endif;
/********** End: Stats Jogos Oficiais **********/

/********** Start: Stats Rachão **********/
$total_goals_rachao   = 0;
$total_assists_rachao = 0;
$total_blocks_rachao  = 0;
$player_total_goals_rachao   = 0;
$player_total_assists_rachao = 0;
$player_total_blocks_rachao  = 0;
$player_total_clean_sheets_rachao  = 0;

$args = array(
    'post_type' => 'matches',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'meta_query' => array(
        array(
            'key' => 'fields_context',
            'value' => 'rachao',
            'compare' => 'LIKE'
        )
    )
);
$result = null;
$result = new WP_Query($args);
$total_matches_rachao = $result->found_posts;

$args = array(
    'post_type' => 'matches',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order'   => 'ASC',
    'orderby'   => 'meta_value',
    'meta_key'  => 'fields_date',
    'meta_query' => array(
        array(
            'key' => 'fields_players',
            'value' => serialize(strval($obj->ID)),
            'compare' => 'LIKE'
        ),
        array(
            'key' => 'fields_context',
            'value' => 'rachao',
            'compare' => 'LIKE'
        )
    )
);
$result = null;
$result = new WP_Query($args);
$player_total_matches_rachao = $result->found_posts;

$args = array(
    'post_type' => 'matches',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'meta_query' => array(
        array(
            'key' => 'fields_context',
            'value' => 'rachao',
            'compare' => 'LIKE'
        )
    )
);
$connected = null;
$connected = new WP_Query($args);

p2p_type( 'matches_to_players' )->each_connected( $connected );

if ( $connected->have_posts() ) :
    while( $connected->have_posts() ) : $connected->the_post();
        foreach ( $post->connected as $post ) : setup_postdata( $post );
            $goals   = p2p_get_meta( get_post()->p2p_id, 'goals', true );
            $assists = p2p_get_meta( get_post()->p2p_id, 'assists', true );
            $blocks  = p2p_get_meta( get_post()->p2p_id, 'blocks', true );
            $total_goals_rachao   = $total_goals_rachao + $goals;
            $total_assists_rachao = $total_assists_rachao + $assists;
            $total_blocks_rachao  = $total_blocks_rachao + $blocks;
        endforeach;
        wp_reset_postdata(); // set $post back to original post
    endwhile;
endif;

// Find connected players
$connected = null;
$connected = new WP_Query( array(
    'connected_type' => 'matches_to_players',
    'connected_items' => $obj,
    'nopaging' => true,
    'meta_query' => array(
        array(
            'key' => 'fields_context',
            'value' => 'rachao',
            'compare' => 'LIKE'
        )
    )
) );

if ( $connected->have_posts() ) :
    while( $connected->have_posts() ) : $connected->the_post();
        $goals   = p2p_get_meta( get_post()->p2p_id, 'goals', true );
        $assists = p2p_get_meta( get_post()->p2p_id, 'assists', true );
        $blocks  = p2p_get_meta( get_post()->p2p_id, 'blocks', true );
        $clean_sheets = p2p_get_meta( get_post()->p2p_id, 'clean_sheets', true );
        $player_total_goals_rachao   = $player_total_goals_rachao + $goals;
        $player_total_assists_rachao = $player_total_assists_rachao + $assists;
        $player_total_blocks_rachao  = $player_total_blocks_rachao + $blocks;
        $player_total_clean_sheets_rachao = $player_total_clean_sheets_rachao + intval($clean_sheets);
    endwhile;
endif;
/********** End: Stats Rachão **********/

$terms = get_terms( array(
    'taxonomy' => 'season',
    'order' => 'DESC',
    'hide_empty' => false,
) );

// echo "<pre>"; print_r($terms); echo "</pre>"; die();

?>

<div class="jumbotron" style="background-image: linear-gradient(to bottom, rgba(247, 217, 2), rgba(255, 255, 204, 0.73))">
    <img src="<?php echo esc_url($player['banner']['url']); ?>" />
</div>

<h2 style="font-weight: 700; text-align: center; text-transform: uppercase;"><?php echo get_the_title($obj->ID); ?></h2>
<hr style="width:50%; border: 1px solid #005000;">
<br />

<div class="container jat-player">
    <div class="tab">
      <button id="tab-general" class="tablinks active" onclick="openStats(event, 'general')">Geral</button>
      <button id="tab-stats" class="tablinks" onclick="openStats(event, 'stats')">Estatísticas</button>
      <button id="tab-skills" class="tablinks" onclick="openStats(event, 'skills')">Atributos</button>
    </div>
    
    <!-- Start: Aba Geral -->
    <div id="general" style="background-color: white; display: block;" class="tabcontent">
        <br />
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                <p>Apelido:</p>
                <h2><?php echo $player['nickname']; ?></h2>
                <hr>
                <p>Posição:</p>
                <h2><?php echo get_player_position($player['position']); ?></h2>
                <hr>
                <p>Camisa:</p>
                <h2><?php echo $player['number']; ?></h2>
                <hr>
                <p>Data de Estreia:</p>
                <h2><?php echo $player['debut_date']; ?></h2>
                <br />
                <br />
                </div>
                <div class="col-sm-6">
                    <p style="color: #2D2D2D"><?php echo $player['summary']; ?></p>
                </div>
            </div>
        </div>
    </div>
    <!-- End: Aba Geral -->

    <!-- Start: Aba Estatísticas -->
    <div id="stats" class="tabcontent">
        <br />
        <!-- Start: Jogos Oficiais -->
        <?php if ( $player_total_matches_oficial > 0 ) : ?>
        <div class="container section-stats">
            <h4>JOGOS OFICIAIS</h4>
            <h5>Jogos</h5>
            <div class="progress">
                <?php $percentage = ($player_total_matches_oficial / $total_matches_oficial) * 100; ?>
                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo ceil($percentage); ?>%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"><?php echo ( $player_total_matches_oficial > 0 ) ? $player_total_matches_oficial : ''; ?></div>
            </div>
            <br />
            <?php if ( 'goleiro' == $player['position'] ) : ?>
                <h5>Defesas</h5>
                <div class="progress">
                    <?php $percentage = ($player_total_blocks_oficial / $total_blocks_oficial) * 100; ?>
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo ceil($percentage); ?>%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"><?php echo ( $player_total_blocks_oficial > 0 ) ? $player_total_blocks_oficial : ''; ?></div>
                </div>
                <br />
                <h5>Clean Sheets</h5>
                <div class="progress">
                    <?php $percentage = ($player_total_clean_sheets_oficial / $total_matches_oficial) * 100; ?>
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo ceil($percentage); ?>%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"><?php echo ( $player_total_clean_sheets_oficial > 0 ) ? $player_total_clean_sheets_oficial : ''; ?></div>
                </div>
            <?php else : ?>
                <h5>Gols</h5>
                <div class="progress">
                    <?php $percentage = ($player_total_goals_oficial / $total_goals_oficial) * 100; ?>
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo ceil($percentage); ?>%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"><?php echo ( $player_total_goals_oficial > 0 ) ? $player_total_goals_oficial : ''; ?></div>
                </div>
                <br />
                <h5>Assistências</h5>
                <div class="progress">
                    <?php $percentage = ($player_total_assists_oficial / $total_assists_oficial) * 100; ?>
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo ceil($percentage); ?>%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><?php echo ( $player_total_assists_oficial > 0 ) ? $player_total_assists_oficial : ''; ?></div>
                </div>
            <?php endif; ?>
        </div>
        <br />
        <br />
        <table class="table" style="text-align: center; background-color: white;"; >
          <thead>
            <tr>
              <th scope="col">Temporada</th>
              <th scope="col">Jogos</th>
              <?php if ( 'goleiro' == $player['position'] ) : ?>
                <th scope="col">Defesas</th>
                <th scope="col">Clean Sheets</th>
              <?php else : ?>
                <th scope="col">Gols</th>
                <th scope="col">Assist</th>
              <?php endif; ?>
          </tr>
          </thead>
          <tbody>
            <?php $ptm = $ptg = $pta = $ptb = $ptcs = 0; ?>
            <?php foreach ( $terms as $term ) : ?>
                <?php
                    $player_total_goals   = 0;
                    $player_total_assists = 0;
                    $player_total_blocks  = 0;
                    $player_total_clean_sheets = 0;
              
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
                                'key' => 'fields_season',
                                'value' => $term->term_id,
                                'compare' => '='
                            ),
                            array(
                                'key' => 'fields_context',
                                'value' => 'oficial',
                                'compare' => 'LIKE'
                            )
                        )
                    );

                    $result = new WP_Query($args);
                    $player_total_matches = $result->found_posts;
                    $ptm = $ptm + $player_total_matches;
              
                    $args = array(
                        'connected_type' => 'matches_to_players',
                        'connected_items' => $obj,
                        'nopaging' => true,
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
                                'key' => 'fields_season',
                                'value' => $term->term_id,
                                'compare' => '='
                            ),
                            array(
                                'key' => 'fields_context',
                                'value' => 'oficial',
                                'compare' => 'LIKE'
                            )
                        )
                    );
              
                    $result = null;
                    $result = new WP_Query($args);
                            
                    if ( $result->have_posts() ) :
                        while( $result->have_posts() ) : $result->the_post();
                            $goals   = p2p_get_meta( get_post()->p2p_id, 'goals', true );
                            $assists = p2p_get_meta( get_post()->p2p_id, 'assists', true );
                            $blocks  = p2p_get_meta( get_post()->p2p_id, 'blocks', true );
                            $clean_sheets = p2p_get_meta( get_post()->p2p_id, 'clean_sheets', true );
                            $player_total_goals   = $player_total_goals + $goals;
                            $player_total_assists = $player_total_assists + $assists;
                            $player_total_blocks  = $player_total_blocks + $blocks;
                            $player_total_clean_sheets = $player_total_clean_sheets + intval($clean_sheets);
                        endwhile;
                    endif;
              
                    $ptg  = $ptg + $player_total_goals;
                    $pta  = $pta + $player_total_assists;
                    $ptb  = $ptb + $player_total_blocks;
                    $ptcs = $ptcs + $player_total_clean_sheets;
                ?>
                <tr>
                  <th scope="col"><strong><?php echo $term->name; ?></strong></th>	
                  <td><?php echo ( $player_total_matches == 0 ) ? '-' : $player_total_matches; ?></td>
                  <?php if ( 'goleiro' == $player['position'] ) : ?>
                    <td><?php echo ( $player_total_blocks == 0 ) ? '-' : $player_total_blocks; ?></td>
                    <td><?php echo ( $player_total_clean_sheets == 0 ) ? '-' : $player_total_clean_sheets; ?></td>
                  <?php else : ?>
                    <td><?php echo ( $player_total_goals == 0 ) ? '-' : $player_total_goals; ?></td>
                    <td><?php echo ( $player_total_assists == 0 ) ? '-' : $player_total_assists; ?></td>
                  <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            <tr style="border-top: 2px solid black;">
              <th scope="col"><strong>Total</strong></th>	
              <td><?php echo ( $ptm == 0 ) ? '-' : $ptm; ?></td>
              <?php if ( 'goleiro' == $player['position'] ) : ?>
                <td><?php echo ( $ptb == 0 ) ? '-' : $ptb; ?></td>
                <td><?php echo ( $ptcs == 0 ) ? '-' : $ptcs; ?></td>
              <?php else : ?>
                <td><?php echo ( $ptg == 0 ) ? '-' : $ptg; ?></td>
                <td><?php echo ( $pta == 0 ) ? '-' : $pta; ?></td>
              <?php endif; ?>
            </tr>
        </table>
        <?php endif; ?>
        <!-- End: Jogos Oficiais -->

        <!-- Start: Rachão -->
        <?php if ( $player_total_matches_rachao > 0 ) : ?>
        <div class="container section-stats">
            <h4>RACHÃO</h4>
            <h5>Jogos</h5>
            <div class="progress">
                <?php $percentage = ($player_total_matches_rachao / $total_matches_rachao) * 100; ?>
                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo ceil($percentage); ?>%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"><?php echo ( $player_total_matches_rachao > 0 ) ? $player_total_matches_rachao : ''; ?></div>
            </div>
            <br />
            <?php if ( 'goleiro' == $player['position'] ) : ?>
                <h5>Defesas</h5>
                <div class="progress">
                    <?php $percentage = ($player_total_blocks_rachao / $total_blocks_rachao) * 100; ?>
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo ceil($percentage); ?>%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"><?php echo ( $player_total_blocks_rachao > 0 ) ? $player_total_blocks_rachao : ''; ?></div>
                </div>
                <br />
                <h5>Clean Sheets</h5>
                <div class="progress">
                    <?php $percentage = ($player_total_clean_sheets_rachao / $total_matches_rachao) * 100; ?>
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo ceil($percentage); ?>%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"><?php echo ( $player_total_clean_sheets_rachao > 0 ) ? $player_total_clean_sheets_rachao : ''; ?></div>
                </div>
            <?php else : ?>
                <h5>Gols</h5>
                <div class="progress">
                    <?php $percentage = ($player_total_goals_rachao / $total_goals_rachao) * 100; ?>
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo ceil($percentage); ?>%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"><?php echo ( $player_total_goals_rachao > 0 ) ? $player_total_goals_rachao : ''; ?></div>
                </div>
                <br />
                <h5>Assistências</h5>
                <div class="progress">
                    <?php $percentage = ($player_total_assists_rachao / $total_assists_rachao) * 100; ?>
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo ceil($percentage); ?>%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><?php echo ( $player_total_assists_rachao > 0 ) ? $player_total_assists_rachao : ''; ?></div>
                </div>
            <?php endif; ?>
        </div>
        <br />
        <br />
        <table class="table" style="text-align: center; background-color: white;"; >
          <thead>
            <tr>
              <th scope="col">Temporada</th>
              <th scope="col">Jogos</th>
              <?php if ( 'goleiro' == $player['position'] ) : ?>
                <th scope="col">Defesas</th>
                <th scope="col">Clean Sheets</th>
              <?php else : ?>
                <th scope="col">Gols</th>
                <th scope="col">Assist</th>
              <?php endif; ?>
          </tr>
          </thead>
          <tbody>
            <?php $ptm = $ptg = $pta = $ptb = $ptcs = 0; ?>
            <?php foreach ( $terms as $term ) : ?>
                <?php
                    $player_total_goals = 0;
                    $player_total_assists = 0;
                    $player_total_blocks = 0;
                    $player_total_clean_sheets = 0;
              
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
                                'key' => 'fields_season',
                                'value' => $term->term_id,
                                'compare' => '='
                            ),
                            array(
                                'key' => 'fields_context',
                                'value' => 'rachao',
                                'compare' => 'LIKE'
                            )
                        )
                    );

                    $result = new WP_Query($args);
                    $player_total_matches = $result->found_posts;
                    $ptm = $ptm + $player_total_matches;
              
                    $args = array(
                        'connected_type' => 'matches_to_players',
                        'connected_items' => $obj,
                        'nopaging' => true,
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
                                'key' => 'fields_season',
                                'value' => $term->term_id,
                                'compare' => '='
                            ),
                            array(
                                'key' => 'fields_context',
                                'value' => 'rachao',
                                'compare' => 'LIKE'
                            )
                        )
                    );
              
                    $result = null;
                    $result = new WP_Query($args);
                            
                    if ( $result->have_posts() ) :
                        while( $result->have_posts() ) : $result->the_post();
                            $goals   = p2p_get_meta( get_post()->p2p_id, 'goals', true );
                            $assists = p2p_get_meta( get_post()->p2p_id, 'assists', true );
                            $blocks  = p2p_get_meta( get_post()->p2p_id, 'blocks', true );
                            $clean_sheets = p2p_get_meta( get_post()->p2p_id, 'clean_sheets', true );
                            $player_total_goals   = $player_total_goals + $goals;
                            $player_total_assists = $player_total_assists + $assists;
                            $player_total_blocks  = $player_total_blocks + $blocks;
                            $player_total_clean_sheets = $player_total_clean_sheets + intval($clean_sheets);
                        endwhile;
                    endif;
              
                    $ptg = $ptg + $player_total_goals;
                    $pta = $pta + $player_total_assists;
                    $ptb = $ptb + $player_total_blocks;
                    $ptcs = $ptcs + $player_total_clean_sheets;
                ?>
                <tr>
                  <th scope="col"><strong><?php echo $term->name; ?></strong></th>	
                  <td><?php echo ( $player_total_matches == 0 ) ? '-' : $player_total_matches; ?></td>
                  <?php if ( 'goleiro' == $player['position'] ) : ?>
                    <td><?php echo ( $player_total_blocks == 0 ) ? '-' : $player_total_blocks; ?></td>
                    <td><?php echo ( $player_total_clean_sheets == 0 ) ? '-' : $player_total_clean_sheets; ?></td>
                  <?php else : ?>
                    <td><?php echo ( $player_total_goals == 0 ) ? '-' : $player_total_goals; ?></td>
                    <td><?php echo ( $player_total_assists == 0 ) ? '-' : $player_total_assists; ?></td>
                  <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            <tr style="border-top: 2px solid black;">
              <th scope="col"><strong>Total</strong></th>	
              <td><?php echo ( $ptm == 0 ) ? '-' : $ptm; ?></td>
              <?php if ( 'goleiro' == $player['position'] ) : ?>
                <td><?php echo ( $ptb == 0 ) ? '-' : $ptb; ?></td>
                <td><?php echo ( $ptcs == 0 ) ? '-' : $ptcs; ?></td>
              <?php else : ?>
                <td><?php echo ( $ptg == 0 ) ? '-' : $ptg; ?></td>
                <td><?php echo ( $pta == 0 ) ? '-' : $pta; ?></td>
              <?php endif; ?>
            </tr>
        </table>
        <?php endif; ?>
        <!-- End: Rachão -->
    </div>
    <!-- End: Aba Estatísticas -->

<?php
$args = array(
    'post_type' => 'skills',
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'meta_query' => array(
        array(
            'key' => 'fields_player',
            'value' => $obj->ID,
            'compare' => '='
        )
    )
);
    
$result = new WP_Query($args);

if ( $result->have_posts() ) :
    while( $result->have_posts() ) : $result->the_post();
        $fields = get_field('fields');
        $skills_media = $fields['skills_media'];

        $skills = $fields['skills'];
        $geral  = ( $skills_media['geral'] ) ? $skills_media['geral'] : round(array_sum($skills) / count($skills));
        $ritmo  = ( $skills_media['ritmo'] ) ? $skills_media['ritmo'] : round(($skills['speed_up'] + $skills['speed']) / 2);
        $shots  = ( $skills_media['shots'] ) ? $skills_media['shots'] : round(($skills['accuracy'] + $skills['kick_power'] + $skills['header']) / 3);
        $passe  = ( $skills_media['passe'] ) ? $skills_media['passe'] : round(($skills['short_pass'] + $skills['long_pass']) / 2);
        $drible = ( $skills_media['drible'] ) ? $skills_media['drible'] : round(($skills['ball_control'] + $skills['ability']) / 2);
        $defesa = ( $skills_media['defesa'] ) ? $skills_media['defesa'] : round(($skills['intercepts'] + $skills['marking'] + $skills['slide']) / 3);
        $fisico = ( $skills_media['fisico'] ) ? $skills_media['fisico'] : round(($skills['stamina'] + $skills['power']) / 2);
    
        $skills_goleiro = $fields['skills_goleiro'];
        $geral_goleiro = ( $skills_goleiro['geral'] ) ? $skills_goleiro['geral'] : round(array_sum($skills_goleiro) / count($skills_goleiro));
    endwhile;
endif;
?>
    
    <!-- Start: Aba Atributos -->
    <?php if ( 'goleiro' == $player['position'] ) : ?>
    <div id="skills" class="tabcontent" style="background-color: white;" >
        <br />
        <div class="container">
            <center>
                <img src="<?php echo esc_url($fields['card']['url']); ?>" style="width: 50%;">    
            </center>
            <br />
            <?php $color = ( $geral_goleiro < 80 ) ? '#E9B925' : 'green'; ?>
            <h3><strong class="rating">GERAL <span style="color: <?php echo $color; ?>;"><?php echo $geral_goleiro; ?></span></strong></h3>
            <hr style="border: 2px solid <?php echo $color; ?>;">
            <br />
            <div class="row">
                <div class="col-sm-6">
                    <table>
                        <tr>
                            <?php $color = ( $skills_goleiro['elasticidade'] < 80 ) ? '#E9B925' : 'green'; ?>
                            <th style="font-weight: normal; font-size: 14px;">Elasticidade</th>
                            <th style="text-align:right; color: <?php echo $color; ?>; font-size: 14px;"><?php echo $skills_goleiro['elasticidade']; ?></th>
                        </tr>
                        <tr>
                            <?php $color = ( $skills_goleiro['manejo'] < 80 ) ? '#E9B925' : 'green'; ?>
                            <th style="font-weight: normal; font-size: 14px;">Manejo</th>
                            <th style="text-align:right; color: <?php echo $color; ?>; font-size: 14px;"><?php echo $skills_goleiro['manejo']; ?></th>
                        </tr>
                        <tr>
                            <?php $color = ( $skills_goleiro['chute'] < 80 ) ? '#E9B925' : 'green'; ?>
                            <th style="font-weight: normal; font-size: 14px;">Chute</th>
                            <th style="text-align:right; color: <?php echo $color; ?>; font-size: 14px;"><?php echo $skills_goleiro['chute']; ?></th>
                        </tr>
                    </table>
                    <br />
                </div>
                <div class="col-sm-6">
                    <table>
                        <tr>
                            <?php $color = ( $skills_goleiro['reflexos'] < 80 ) ? '#E9B925' : 'green'; ?>
                            <th style="font-weight: normal; font-size: 14px;">Reflexos</th>
                            <th style="text-align:right; color: <?php echo $color; ?>; font-size: 14px;"><?php echo $skills_goleiro['reflexos']; ?></th>
                        </tr>
                        <tr>
                            <?php $color = ( $skills_goleiro['velocidade'] < 80 ) ? '#E9B925' : 'green'; ?>
                            <th style="font-weight: normal; font-size: 14px;">Velocidade</th>
                            <th style="text-align:right; color: <?php echo $color; ?>; font-size: 14px;"><?php echo $skills_goleiro['velocidade']; ?></th>
                        </tr>
                        <tr>
                            <?php $color = ( $skills_goleiro['posicionamento'] < 80 ) ? '#E9B925' : 'green'; ?>
                            <th style="font-weight: normal; font-size: 14px;">Posicionamento</th>
                            <th style="text-align:right; color: <?php echo $color; ?>; font-size: 14px;"><?php echo $skills_goleiro['posicionamento']; ?></th>
                        </tr>
                    </table>
                    <br />
                </div>
            </div>
        </div>
    </div>
    <?php else : ?>
    <div id="skills" class="tabcontent" style="background-color: white;" >
        <br />
        <div class="container">
            <center>
                <img src="<?php echo esc_url($fields['card']['url']); ?>" style="width: 50%;">    
            </center>
            <br />
            <?php $color = ( $geral < 80 ) ? '#E9B925' : 'green'; ?>
            <h3><strong class="rating">GERAL <span style="color: <?php echo $color; ?>;"><?php echo $geral; ?></span></strong></h3>
            <hr style="border: 2px solid <?php echo $color; ?>;">
            <br />
            <div class="row">
                <div class="col-sm-6">
                    <?php $color = ( $ritmo < 80 ) ? '#E9B925' : 'green'; ?>
                    <table style="border-bottom: 6px solid <?php echo $color; ?>;">
                        <tr>
                            <th style="font-size: 18px;"><b>RITMO</b></th>
                            <th style="text-align:right; color: <?php echo $color; ?>; font-size: 18px;"><?php echo $ritmo; ?></th>
                        </tr>
                    </table>
                    <br />
                    <table>
                        <tr>
                            <?php $color = ( $skills['speed_up'] < 80 ) ? '#E9B925' : 'green'; ?>
                            <th style="font-weight: normal; font-size: 14px;">Aceleração</th>
                            <th style="text-align:right; color: <?php echo $color; ?>; font-size: 14px;"><?php echo $skills['speed_up']; ?></th>
                        </tr>
                        <tr>
                            <?php $color = ( $skills['speed'] < 80 ) ? '#E9B925' : 'green'; ?>
                            <th style="font-weight: normal; font-size: 14px;">Pique</th>
                            <th style="text-align:right; color: <?php echo $color; ?>; font-size: 14px;"><?php echo $skills['speed']; ?></th>
                        </tr>
                    </table>
                    <br />
                    <?php $color = ( $shots < 80 ) ? '#E9B925' : 'green'; ?>
                    <table style="border-bottom: 6px solid <?php echo $color; ?>;">
                        <tr>
                            <th style="font-size: 18px;"><b>FINALIZAÇÕES</b></th>
                            <th style="text-align:right; color: <?php echo $color; ?>; font-size: 18px;"><?php echo $shots; ?></th>
                        </tr>
                    </table>
                    <br />
                    <table>
                        <tr>
                            <?php $color = ( $skills['accuracy'] < 80 ) ? '#E9B925' : 'green'; ?>
                            <th style="font-weight: normal; font-size: 14px;">Precisão</th>
                            <th style="text-align:right; color: <?php echo $color; ?>; font-size: 14px;"><?php echo $skills['accuracy']; ?></th>
                        </tr>
                        <tr>
                            <?php $color = ( $skills['kick_power'] < 80 ) ? '#E9B925' : 'green'; ?>
                            <th style="font-weight: normal; font-size: 14px;">Força dos Chutes</th>
                            <th style="text-align:right; color: <?php echo $color; ?>; font-size: 14px;"><?php echo $skills['kick_power']; ?></th>
                        </tr>
                        <tr>
                            <?php $color = ( $skills['header'] < 80 ) ? '#E9B925' : 'green'; ?>
                            <th style="font-weight: normal; font-size: 14px;">Cabeceio</th>
                            <th style="text-align:right; color: <?php echo $color; ?>; font-size: 14px;"><?php echo $skills['header']; ?></th>
                        </tr>
                        </table>
                    <br />
                    <?php $color = ( $passe < 80 ) ? '#E9B925' : 'green'; ?>
                    <table style="border-bottom: 6px solid <?php echo $color; ?>;">
                        <tr>
                            <?php $color = ( $passe < 80 ) ? '#E9B925' : 'green'; ?>
                            <th style="font-size: 18px;"><b>PASSE</b></th>
                            <th style="text-align:right; color: <?php echo $color; ?>; font-size: 18px;"><?php echo $passe; ?></th>
                        </tr>
                    </table>
                    <br />
                    <table>
                        <tr>
                            <?php $color = ( $skills['short_pass'] < 80 ) ? '#E9B925' : 'green'; ?>
                            <th style="font-size: 14px; font-weight: normal">Passes Curtos</th>
                            <th style="font-size: 14px; text-align:right; color: <?php echo $color; ?>;"><?php echo $skills['short_pass']; ?></th>
                        </tr>
                        <tr>
                            <?php $color = ( $skills['long_pass'] < 80 ) ? '#E9B925' : 'green'; ?>
                            <th style="font-size: 14px; font-weight: normal">Lançamentos</th>
                            <th style="font-size: 14px; text-align:right; color: <?php echo $color; ?>;"><?php echo $skills['long_pass']; ?></th>
                        </tr>
                    </table>
                    <br />
                </div>
                <div class="col-sm-6">
                    <?php $color = ( $drible < 80 ) ? '#E9B925' : 'green'; ?>
                    <table style="border-bottom: 6px solid <?php echo $color; ?>;">
                        <tr>
                            <th style="font-size: 18px;"><b>DRIBLES</b></th>
                            <th style="text-align:right; color: <?php echo $color; ?>; font-size: 18px;"><?php echo $drible; ?></th>
                        </tr>
                    </table>
                    <br />
                    <table>
                        <tr>
                            <?php $color = ( $skills['ball_control'] < 80 ) ? '#E9B925' : 'green'; ?>
                            <th style="font-weight: normal; font-size: 14px;">Domínio</th>
                            <th style="text-align:right; color: <?php echo $color; ?>; font-size: 14px;"><?php echo $skills['ball_control']; ?></th>
                        </tr>
                        <tr>
                            <?php $color = ( $skills['ability'] < 80 ) ? '#E9B925' : 'green'; ?>
                            <th style="font-weight: normal; font-size: 14px;">Habilidade</th>
                            <th style="text-align:right; color: <?php echo $color; ?>; font-size: 14px;"><?php echo $skills['ability']; ?></th>
                        </tr>
                    </table>
                    <br />
                    <?php $color = ( $defesa < 80 ) ? '#E9B925' : 'green'; ?>
                    <table style="border-bottom: 6px solid <?php echo $color; ?>;">
                        <tr>
                            <th style="font-size: 18px;"><b>DEFESA</b></th>
                            <th style="text-align:right; color: <?php echo $color; ?>; font-size: 18px;"><?php echo $defesa; ?></th>
                        </tr>
                    </table>
                    <br />
                    <table>
                        <tr>
                            <?php $color = ( $skills['intercepts'] < 80 ) ? '#E9B925' : 'green'; ?>
                            <th style="font-weight: normal; font-size: 14px;">Interceptações</th>
                            <th style="text-align:right; color: <?php echo $color; ?>; font-size: 14px;"><?php echo $skills['intercepts']; ?></th>
                        </tr>
                        <tr>
                            <?php $color = ( $skills['marking'] < 80 ) ? '#E9B925' : 'green'; ?>
                            <th style="font-weight: normal; font-size: 14px;">Marcação</th>
                            <th style="text-align:right; color: <?php echo $color; ?>; font-size: 14px;"><?php echo $skills['marking']; ?></th>
                        </tr>
                        <tr>
                            <?php $color = ( $skills['slide'] < 80 ) ? '#E9B925' : 'green'; ?>
                            <th style="font-weight: normal; font-size: 14px;">Carrinho</th>
                            <th style="text-align:right; color: <?php echo $color; ?>; font-size: 14px;"><?php echo $skills['slide']; ?></th>
                        </tr>
                    </table>
                    <br />
                    <?php $color = ( $fisico < 80 ) ? '#E9B925' : 'green'; ?>
                    <table style="border-bottom: 6px solid <?php echo $color; ?>;">
                        <tr>
                            <th style="font-size: 18px;"><b>FÍSICO</b></th>
                            <th style="text-align:right; color: <?php echo $color; ?>; font-size: 18px;"><?php echo $fisico; ?></th>
                        </tr>
                    </table>
                    <br />
                    <table>
                        <tr>
                            <?php $color = ( $skills['stamina'] < 80 ) ? '#E9B925' : 'green'; ?>
                            <th style="font-weight: normal; font-size: 14px;">Fôlego</th>
                            <th style="text-align:right; color: <?php echo $color; ?>; font-size: 14px;"><?php echo $skills['stamina']; ?></th>
                        </tr>
                        <tr>
                            <?php $color = ( $skills['power'] < 80 ) ? '#E9B925' : 'green'; ?>
                            <th style="font-weight: normal; font-size: 14px;">Força</th>
                            <th style="text-align:right; color: <?php echo $color; ?>; font-size: 14px;"><?php echo $skills['power']; ?></th>
                        </tr>
                    </table>
                    <br />
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <!-- End: Aba Atributos -->
</div>

<br />
<br />

<!-- Start: Carrossel -->
<div class="container">
    <?php $slides = array_filter($player['carousel']); ?>
    <?php if ( $slides ) : $count = count($slides); ?>
        <div id="jat-carousel-indicators" class="carousel slide h-first" data-ride="carousel">
          <ol class="carousel-indicators">
            <?php for ( $i=0; $i<$count; $i++ ) : ?>
            <li data-target="#jat-carousel-indicators" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i == 0) ? 'active' : ''; ?>"></li>
            <?php endfor; ?>
          </ol>
          <div class="carousel-inner">
            <?php
                $i = 0;
                foreach ( $slides as $slide ) :
                    ?>
                    <div class="carousel-item <?php echo ($i == 0) ? 'active' : ''; ?>">
                        <img src="<?php echo esc_url($slide['url']); ?>" class="w-100 d-block" alt="<?php echo $slide['alt'] ?>">
                    </div>
                    <?php
                    $i++;
                endforeach;
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
</div>
<!-- End: Carrossel -->

<br />
<br />

<!-- Start: Vídeos -->
<div class="container">
    <?php $videos = array_filter($player['videos']); ?>
    <?php if ( $videos ) : ?>
        <?php foreach ( $videos as $video ) : ?>
        <div class="embed-responsive embed-responsive-16by9">
            <?php echo $video; ?>
        </div>
        <br />
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<!-- End: Vídeos -->

<br />
<br />
