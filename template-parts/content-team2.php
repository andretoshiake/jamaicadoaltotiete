<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package JAT
 */

global $wp;

$current_url = home_url( add_query_arg( array(), $wp->request ) );
$current_slug = add_query_arg( array(), $wp->request );

$args = array(
    'post_type' => 'players',
    'post_status' => 'publish',
    'posts_per_page' => 4,
    'meta_key' => 'fields_number',
    'orderby' => 'meta_value_num',
    'order'	 => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'fields_vip_rachao',
            'value' => true,
            'compare' => '='
        )
    )
);

$vip_players_result = new WP_Query($args);

// echo "<pre>"; print_r($vip_players_result); echo "</pre>"; die();

$args = array(
    'post_type' => 'players',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order'	 => 'ASC'
);

$result = new WP_Query($args);

// echo "<pre>"; print_r($result); echo "</pre>"; die();

get_header();
?>

<main id="primary" class="site-main team-page">

    <div class="jumbotron" style="background-image: linear-gradient(to bottom, rgba(247, 217, 2), rgba(255, 255, 204, 0.73)), url('<?php echo get_template_directory_uri() . '/img/rachao_fundo.jpg'; ?>')">
        <div class="container">
            <img src="<?php echo get_template_directory_uri() . '/img/rachao_titulo.png'; ?>" style="width: 100%;"/>
        </div>
    </div>
    
    <br />

    <div class="container">
        <h4>O Rachão do JAT acontece todo sábado, às 7h, no campo 1 da Ibar, e é de suma importância para o time. Além de ser o entretenimento da galera no fim de semana, também ajuda na formação do time que disputa os amistosos e mantém nossos jogadores em atividade. Veja abaixo alguns destaques e as estatísticas dos nossos rachões:</h4>

        <br />
        <br />

        <h3 style="color: #005000; text-align: center;"><strong>DESTAQUES</strong></h3>
            <hr style="border: 1px solid #005000; width: 50%;">
        <br />

        <div class="row player-cards">
            <?php if ( $vip_players_result->have_posts() ) : ?>
                <?php while( $vip_players_result->have_posts() ) : $vip_players_result->the_post(); $fields = get_field('fields'); ?>
                    <div class="col-md-3">
                        <div class="card" >
                            <a href="<?php echo get_permalink(); ?>">
                                <div class="fotoJogador" style="background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0), rgba(20, 20, 20, 0.70)), url('<?php echo ( $fields['image'] ) ? esc_url($fields['image']['url']) : get_template_directory_uri() . '/img/nopicture.png'; ?>')"></div>
                                <div class="fundo">
                                    <span><?php echo $fields['number']; ?></span>
                                </div>
                                <div class="nomeJogador" style="">
                                    <span><b><?php echo the_title(); ?></b></span>
                                </div>
                            </a>
                        </div>
                        <br />
                        <br />
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>

        <br />
        <br />

        <h3 style="color: #005000; text-align: center;"><strong>ESTATÍSTICAS</strong></h3>
        <hr style="border: 1px solid #005000; width: 50%;">
        <br />
        <div class="row">
            <div class="table-responsive">				
                <table class="table" style="text-align: center; background-color: white;";>
                  <thead>
                    <tr>
                      <th scope="col"></th>
                      <th scope="col">Nome</th>
                      <th scope="col">Posição</th>
                      <th scope="col">Jogos</th>
                      <th scope="col">Gols</th>
                      <th scope="col">Assistências</th>
                      <th scope="col">Defesas</th>
                      <th scope="col">Clean Sheets</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php if ( $result->have_posts() ) : ?>
                      <?php while( $result->have_posts() ) : $result->the_post(); $obj = $post; ?>
                        <?php
                            $player = get_field('fields');
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
                                        'key' => 'fields_context',
                                        'value' => 'rachao',
                                        'compare' => 'LIKE'
                                    )
                                )
                            );

                            $query = new WP_Query($args);
                            $player_total_matches = $query->found_posts;

                            // Find connected players
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
                                    $player_total_goals   = $player_total_goals + (int)$goals;
                                    $player_total_assists = $player_total_assists + (int)$assists;
                                    $player_total_blocks  = $player_total_blocks + (int)$blocks;
                                    $player_total_clean_sheets = $player_total_clean_sheets + (int)$clean_sheets;
                                endwhile;
                            endif;
                      
                            $title = get_the_title($obj->ID);
                        ?>
                        <?php if ( $player_total_matches > 0 ) : ?>
                        <tr>
                          <td><a href="<?php echo get_permalink($obj->ID); ?>" data-toggle="popover" data-placement="top" data-content="Ver perfil do jogador" data-trigger="hover" style="color: limegreen; outline: 0;"><i class="far fa-address-card fa-lg"></i></a></td>
                          <td><?php echo ( strlen($title) > 20 ) ? $player['nickname'] : $title; ?></td>
                          <td><?php echo get_player_position($player['position']); ?></td>
                          <td><?php echo $player_total_matches; ?></td>
                          <td><?php echo $player_total_goals; ?></td>
                          <td><?php echo $player_total_assists; ?></td>
                          <td><?php echo $player_total_blocks; ?></td>
                          <td><?php echo $player_total_clean_sheets; ?></td>
                        </tr>
                        <?php endif; ?>
                      <?php endwhile; ?>
                    <?php endif; ?>
                  </tbody>
                </table>
            </div>
        </div>
        <br />
	</div>
</main>

<?php
get_sidebar();
get_footer();
