<?php

$match_id = $_POST['match_id'];
$match = get_field('fields', $match_id);
$post = get_post($match_id);

// Find connected matches
$connected = new WP_Query( array(
    'connected_type' => 'matches_to_players',
    'connected_items' => $match_id,
    'nopaging' => true,
    // 'suppress_filters' => false
) );

if ( $connected->have_posts() ) :
    $player_goals   = array();
    $player_assists = array();
    $player_blocks  = array();

    while( $connected->have_posts() ) : $connected->the_post();
        $fields = get_field('fields');
        $title = get_the_title();
        $player = ( strlen($title) > 20 ) ? $fields['nickname'] : $title;

        $goals   = p2p_get_meta( get_post()->p2p_id, 'goals', true );
        $assists = p2p_get_meta( get_post()->p2p_id, 'assists', true );
        $blocks  = p2p_get_meta( get_post()->p2p_id, 'blocks', true );

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

        if ( $blocks ) {
            $player_blocks[] = array(
                'player' => $player,
                'total'  => $blocks
            );
        }
        usort($player_blocks, function ($item1, $item2) {
            return $item1['player'] <=> $item2['player'];
        });
    endwhile;
endif;

// echo "<pre>"; print_r($player_goals); echo "</pre>"; die();
// echo "<pre>"; print_r($player_assists); echo "</pre>"; die();
// echo "<pre>"; print_r($player_blocks); echo "</pre>"; die();

?>
<div class="container">
<!--
    <div class="tab">
        <button id="tab-stats" class="tablinks active" onclick="openStats(event, 'stats')">Estatísticas</button>
        <button id="tab-details" class="tablinks" onclick="openStats(event, 'details')">Detalhes</button>
        <button id="tab-medias" class="tablinks" onclick="openStats(event, 'medias')">Mídias</button>
    </div>
-->
    <ul class="nav nav-tabs nav-justified jat-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="stats-tab" data-toggle="tab" href="#stats" role="tab" aria-controls="stats" aria-selected="true">Estatísticas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="false">Detalhes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="medias-tab" data-toggle="tab" href="#medias" role="tab" aria-controls="medias" aria-selected="false">Mídias</a>
        </li>
    </ul>

    <div class="tab-content">

        <!-- Start: Stats -->
        <div class="tab-pane fade show active" id="stats" role="tabpanel" aria-labelledby="stats-tab">
            <ul class="nav nav-pills nav-fill jat-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="goals-tab" data-toggle="tab" href="#goals" role="tab" aria-controls="goals" aria-selected="true">Gols</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="assists-tab" data-toggle="tab" href="#assists" role="tab" aria-controls="assists" aria-selected="false">Assistências</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="blocks-tab" data-toggle="tab" href="#blocks" role="tab" aria-controls="blocks" aria-selected="false">Defesas</a>
                </li>
            </ul>

            <div class="tab-content">

                <!-- Start: Goals -->
                <div class="tab-pane fade show active" id="goals" role="tabpanel" aria-labelledby="goals-tab">
                    <?php if ( $player_goals ) : ?>
                    <table>
                        <tr></tr>
                        <?php foreach ( $player_goals as $pg ) : ?>
                        <tr>
                            <td><?php echo ( $pg['total'] == 1 ) ? $pg['player'] : $pg['player'] . ' (' . $pg['total'] . ') ' ; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php else : ?>
                        <i>Sem gols no jogo.</i>
                    <?php endif; ?>
                </div>
                <!-- End: Goals -->

                <!-- Start: Assists -->
                <div class="tab-pane fade" id="assists" role="tabpanel" aria-labelledby="assists-tab">
                    <?php if ( $player_assists ) : ?>
                    <table>
                        <tr></tr>
                        <?php foreach ( $player_assists as $pa ) : ?>
                        <tr>
                            <td><?php echo ( $pa['total'] == 1 ) ? $pa['player'] : $pa['player'] . ' (' . $pa['total'] . ') ' ; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php else : ?>
                        <i>Sem assistências no jogo.</i>
                    <?php endif; ?>
                </div>
                <!-- End: Assists -->

                <!-- Start: Blocks -->
                <div class="tab-pane fade" id="blocks" role="tabpanel" aria-labelledby="blocks-tab">
                    <?php if ( $player_blocks ) : ?>
                    <table>
                        <tr></tr>
                        <?php foreach ( $player_blocks as $pb ) : ?>
                        <tr>
                            <td><?php echo ( $pb['total'] == 1 ) ? $pb['player'] : $pb['player'] . ' (' . $pb['total'] . ') ' ; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php else : ?>
                        <i>Sem defesas do jogo.</i>
                    <?php endif; ?>
                </div>
                <!-- End: Blocks -->

            </div>
        </div>
        <!-- End: Stats -->

        <!-- Start: Details -->
        <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
            <ul class="nav nav-pills nav-fill jat-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="summary-tab" data-toggle="tab" href="#summary" role="tab" aria-controls="summary" aria-selected="true">Resumo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="squad-tab" data-toggle="tab" href="#squad" role="tab" aria-controls="squad" aria-selected="false">Relacionados</a>
                </li>
            </ul>

            <div class="tab-content">

                <!-- Start: Summary -->
                <div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="summary-tab">
                    <table>
                        <tr>
                            <?php if ( $match['summary'] ) : ?>
                            <td class="text-left"><?php echo $match['summary']; ?></td>
                            <?php else : ?>
                            <td><i>Sem resumo do jogo.</i></td>
                            <?php endif; ?>
                        </tr>
                    </table>
                </div>
                <!-- End: Summary -->

                <!-- Start: Squad -->
                <div class="tab-pane fade" id="squad" role="tabpanel" aria-labelledby="squad-tab">
                    <?php
                        usort($match['players'], function ($item1, $item2) {
                            return $item1->post_title <=> $item2->post_title;
                        });
                    ?>
                    <table>
                        <tr></tr>
                        <tr>
                            <td>
                                <ul class="squad">
                                <?php foreach( $match['players'] as $p ) : ?>
                                    <li><?php echo $p->post_title; ?></li>
                                <?php endforeach; ?>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- End: Squad -->

            </div>
        </div>
        <!-- End: Details -->

        <!-- Start: Medias -->
        <div class="tab-pane fade" id="medias" role="tabpanel" aria-labelledby="medias-tab">
            <ul class="nav nav-pills nav-fill jat-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="carousel-tab" data-toggle="tab" href="#carousel" role="tab" aria-controls="carousel" aria-selected="true">Fotos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="video-tab" data-toggle="tab" href="#video" role="tab" aria-controls="video" aria-selected="false">Vídeo</a>
                </li>
            </ul>

            <div class="tab-content">

                <!-- Start: Stats -->
                <div class="tab-pane fade show active" id="carousel" role="tabpanel" aria-labelledby="carousel-tab">
                    <?php $slides = array_filter($match['carousel']); ?>
                    <?php if ( $slides ) : $count = count($slides); ?>
                        <div id="jat-carousel" class="carousel slide" data-ride="carousel">
                          <ol class="carousel-indicators">
                            <?php for ( $i=0; $i<$count; $i++ ) : ?>
                            <li data-target="#jat-carousel" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i == 0) ? 'active' : ''; ?>"></li>
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
                          <a class="carousel-control-prev" href="#jat-carousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                          </a>
                          <a class="carousel-control-next" href="#jat-carousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                          </a>
                        </div>
                    <?php else : ?>
                        <i>Sem fotos do jogo.</i>
                    <?php endif; ?>
                </div>

                <!-- Start: Vídeos -->
                <div class="tab-pane fade" id="video" role="tabpanel" aria-labelledby="video-tab">
                    <?php if ( $match['video'] ) : ?>
                        <div class="embed-responsive embed-responsive-16by9">
                            <?php echo $match['video']; ?>
                        </div>
                    <?php else : ?>
                        <i>Sem vídeo do jogo.</i>
                    <?php endif; ?>
                </div>
                <!-- End: Vídeos -->

            </div>
        </div>
        <!-- End: Medias -->

    </div>

</div>
<?php

wp_reset_postdata();

?>