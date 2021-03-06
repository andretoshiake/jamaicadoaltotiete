<?php

$match_id = $_POST['match_id'];
$post = get_post($match_id);

// Find connected matches
$connected = new WP_Query( array(
    'connected_type' => 'matches_to_players',
    'connected_items' => $match_id,
    'nopaging' => true,
    // 'suppress_filters' => false
) );

if ( $connected->have_posts() ) :
    $player_goals = array();
    $player_assists = array();

    while( $connected->have_posts() ) : $connected->the_post();
        $fields = get_field('fields');
        $title = get_the_title();
        $player = ( strlen($title) > 20 ) ? $fields['nickname'] : $title;

        if ( 'goleiro' != $fields['position'] ) :
            $goals   = p2p_get_meta( get_post()->p2p_id, 'goals', true );
            $assists = p2p_get_meta( get_post()->p2p_id, 'assists', true );

            if ( $goals ) {
                $player_goals[] = array(
                    'player' => $player,
                    'total'  => $goals
                );
            }
            usort($player_goals, function ($item1, $item2) {
                return $item1['player'] <=> $item2['player'];
            });

            if ( $assists ) {
                $player_assists[] = array(
                    'player' => $player,
                    'total'  => $assists
                );
            }
            usort($player_assists, function ($item1, $item2) {
                return $item1['player'] <=> $item2['player'];
            });
        endif;
    endwhile;
endif;

// echo "<pre>"; print_r($player_goals); echo "</pre>"; die();
// echo "<pre>"; print_r($player_assists); echo "</pre>"; die();

?>
<div class="container">
    <?php if ( $player_goals ) : ?>
    <table>
        <tr>
            <th>Gols</th>
        </tr>
        <?php foreach ( $player_goals as $pg ) : ?>
        <tr>
            <td><?php echo ( $pg['total'] == 1 ) ? $pg['player'] : $pg['player'] . ' (' . $pg['total'] . ') ' ; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    <?php if ( $player_assists ) : ?>
    <table>
        <tr>
            <th>Assist??ncias</th>
        </tr>
        <?php foreach ( $player_assists as $pa ) : ?>
        <tr>
            <td><?php echo ( $pa['total'] == 1 ) ? $pa['player'] : $pa['player'] . ' (' . $pa['total'] . ') ' ; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
</div>
<?php

wp_reset_postdata();

?>