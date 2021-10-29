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
            'value' => 'oficial',
            'compare' => 'LIKE'
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

    <div class="container select-season">
        <h5>Escolha uma temporada:</h5>
        <select id="select-season" class="selectpicker" data-live-search="true" data-size="5" onchange="location=this.value;">
          <?php foreach ( $terms as $term ) : ?>
          <option value="<?php echo dirname($current_url) . '/' . $term->slug; ?>" <?php echo ( $season->term_id == $term->term_id ) ? 'selected' : ''; ?>><?php echo $term->name; ?></option>
          <?php endforeach; ?>
        </select>
    </div>

    <div class="container">
        <h3 class="text-center" style="color: #005000;"><strong>TEMPORADA <?php echo $season->slug; ?></strong></h3>
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
                    <tbody>
                        <?php if ( $result->have_posts() ) : ?>
                            <?php while( $result->have_posts() ) : $result->the_post(); $match = get_field('fields'); ?>
                            <tr>
                                <th scope="row"><?php echo dirname($match['date']); ?></th>
                                <td><?php echo ( 'mandante' == $match['local'] ) ? 'JAT' : $match['team']; ?></td>
                                <td><?php echo $match['goals_team1'] . ' x ' . $match['goals_team2']; ?></td>
                                <td><?php echo ( 'visitante' == $match['local'] ) ? 'JAT' : $match['team']; ?></td>
                                <td>
                                <!-- Botão para ativar a modal -->
                                    <button type="button" class="btn btn-sm btn-ajax" data-toggle="modal" data-target="#modal-info" data-match="<?php the_ID(); ?>">Veja Mais...</button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br />			
        <br />
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
        <div class="modal-dialog">
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
