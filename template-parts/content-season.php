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

$terms = get_terms( array(
    'taxonomy' => 'season',
    'order' => 'DESC',
    'hide_empty' => false,
) );

$season = get_queried_object();
if ( !$season ) {
    $season = $terms[0];
}

$time = $_GET['time'];
$context = ( $time && filter_var($time, FILTER_VALIDATE_INT) && $time == 2 ) ? array('rachao') : array('oficial', 'camp');
$context_label = ( $time && filter_var($time, FILTER_VALIDATE_INT) && $time == 2 ) ? 'RACHÃO' : 'JOGOS OFICIAIS';

$args = array(
    'post_type' => 'matches',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order'   => 'DESC',
    'orderby'   => 'meta_value',
    'meta_key'  => 'fields_date',
    'meta_query' => array(
        array(
            'key' => 'fields_season',
            'value' => $season->term_id,
            'compare' => '='
        ),
        array(
            'key' => 'fields_context',
            'value' => $context,
            'compare' => 'IN'
        )
    )
);

$result = new WP_Query($args);

// echo "<pre>"; print_r($result); echo "</pre>"; die();

get_header();
?>

<main id="primary" class="site-main">

    <div class="jumbotron" style="background-image: linear-gradient(to bottom, rgba(247, 217, 2), rgba(255, 255, 204, 0.73)), url('<?php echo get_template_directory_uri() . '/img/jogos_fundo.jpg'; ?>')">
        <div class="container">
            <img src="<?php echo get_template_directory_uri() . '/img/jogos_titulo.png'; ?>" style="width: 100%;"/>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm select-season">
                <h5>Escolha uma temporada:</h5>
                <select id="select-season" class="selectpicker" data-live-search="true" data-size="5" onchange="location=this.value;">
                    <?php foreach ( $terms as $term ) : ?>
                        <?php $team = ( $time && filter_var($time, FILTER_VALIDATE_INT) && $time == 2 ) ? '?time=2' : ''; ?>
                        <?php $redirect = dirname($current_url) . '/' . $term->slug . $team; ?>
                        <option value="<?php echo $redirect; ?>" <?php echo ( $season->term_id == $term->term_id ) ? 'selected' : ''; ?>><?php echo $term->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php if ( in_array('oficial', $context) && in_array('camp', $context) ) : ?>
                <div class="col-sm select-season">
                    <h5>Escolha uma competição:</h5>
                    <select id="select-context" class="selectpicker">
                        <option value="-">Todas as competições</option>
                        <option value="camp">Campeonatos</option>
                        <option value="oficial">Amistosos</option>
                    </select>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="container">
        <h3 class="text-center" style="color: #005000;"><strong>TEMPORADA <?php echo $season->slug . ' - ' . $context_label; ?></strong></h3>
        <hr style="border: 1px solid #005000;">
        <br />
        <div class="row">
            <div class="table-responsive">				
                <table class="table" style="text-align: center; background-color: white;"; >
                    <thead>
                        <tr>
                            <th scope="col">Data</th>
                            <th scope="col">Mandante</th>
                            <th scope="col">Resultado</th>
                            <th scope="col">Visitante</th>
                            <th scope="col">Informações</th>
                        </tr>
                    </thead>
                    <?php if ( in_array('rachao', $context) ) : ?>
                    <tbody>
                        <?php if ( $result->have_posts() ) : ?>
                            <?php while( $result->have_posts() ) : $result->the_post(); $match = get_field('fields'); ?>
                            <tr>
                                <th scope="row"><?php echo dirname($match['date']); ?></th>
                                <td><h5><span class="badge badge-warning">Time 1 - Amarelo</span></h5></td>
                                <td><?php echo $match['goals_team1'] . ' x ' . $match['goals_team2']; ?></td>
                                <td><h5><span class="badge badge-primary">Time 2 - Azul</span></h5></td>
                                <td>
                                    <!-- Botão para ativar a modal -->
                                    <button type="button" class="btn btn-sm btn-ajax" data-toggle="modal" data-target="#modal-info" data-match="<?php the_ID(); ?>">Veja Mais...</button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                    <?php else : ?>
                    <tbody>
                        <?php if ( $result->have_posts() ) : ?>
                            <?php while( $result->have_posts() ) : $result->the_post(); $match = get_field('fields'); ?>
                            <tr class="<?php echo $match['context']; ?>">
                                <th scope="row"><?php echo dirname($match['date']); ?></th>
                                <td><?php echo ( 'mandante' == $match['local'] ) ? 'JAT' : $match['team']; ?></td>
                                <td><?php echo $match['goals_team1'] . ' x ' . $match['goals_team2']; ?></td>
                                <td><?php echo ( 'visitante' == $match['local']  ) ? 'JAT' : $match['team']; ?></td>
                                <td>
                                    <!-- Botão para ativar a modal -->
                                    <button type="button" class="btn btn-sm btn-ajax" data-toggle="modal" data-target="#modal-info" data-match="<?php the_ID(); ?>">Veja Mais...</button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                    <?php endif; ?>
                </table>
            </div>
        </div>
        <br />			
        <br />
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="container">
                        <h2 class="modal-title text-center" id="modal-label">Eventos</h2>
                    </div>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                </div>
                <div class="modal-body text-center">
                    <div class="spinner-border text-success" role="status">
                        <span class="sr-only">...</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

</main><!-- #main -->

<?php
get_sidebar();
get_footer();
