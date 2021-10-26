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
    'posts_per_page' => -1,
    'meta_key' => 'fields_number',
    'orderby' => 'meta_value',
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

get_header();
?>

<main id="primary" class="site-main">

    <div class="jumbotron" style="background-image: linear-gradient(to bottom, rgba(247, 217, 2), rgba(255, 255, 204, 0.73)), url('<?php echo get_template_directory_uri() . '/img/capa_elencoprincipal.jpg'; ?>')">
        <div class="container">
            <img src="<?php echo get_template_directory_uri() . '/img/elenco-principal_titulo.png'; ?>" style="width: 100%;"/>
        </div>
    </div>

    <div class="container">
        <br />
        <br />
        
        <h3 style="color: #005000; text-align: center;"><strong>GOLEIROS</strong></h3>
            <hr style="border: 1px solid #005000; width: 50%;">
        <br />

        <div class="row">
            <?php if ( $result->have_posts() ) : ?>
                <?php while( $result->have_posts() ) : $result->the_post(); $fields = get_field('fields'); ?>
                    <?php if ( 'goleiro' == $fields['position'] ) : ?>
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
                    <?php endif; ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
        
        <br />
        <br />
        
        <h3 style="color: #005000; text-align: center;"><strong>DEFENSORES</strong></h3>
            <hr style="border: 1px solid #005000; width: 50%;">
        <br />

        <div class="row">
            <?php if ( $result->have_posts() ) : ?>
                <?php while( $result->have_posts() ) : $result->the_post(); $fields = get_field('fields'); ?>
                    <?php if ( in_array($fields['position'], array('lateraldir', 'lateralesq', 'zagueiro')) ) : ?>
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
                    <?php endif; ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
        
        <br />
        <br />
        
        <h3 style="color: #005000; text-align: center;"><strong>MEIO CAMPISTAS</strong></h3>
            <hr style="border: 1px solid #005000; width: 50%;">
        <br />

        <div class="row">
            <?php if ( $result->have_posts() ) : ?>
                <?php while( $result->have_posts() ) : $result->the_post(); $fields = get_field('fields'); ?>
                    <?php if ( in_array($fields['position'], array('volante', 'meiocampo')) ) : ?>
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
                    <?php endif; ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
        
        <br />
        <br />
        
        <h3 style="color: #005000; text-align: center;"><strong>ATACANTES</strong></h3>
            <hr style="border: 1px solid #005000; width: 50%;">
        <br />

        <div class="row">
            <?php if ( $result->have_posts() ) : ?>
                <?php while( $result->have_posts() ) : $result->the_post(); $fields = get_field('fields'); ?>
                    <?php if ( 'atacante' == $fields['position'] ) : ?>
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
                    <?php endif; ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
        
        <br />
        <br />
	</div>
	
	<br />
	<br />

<?php
get_sidebar();
get_footer();
