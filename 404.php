<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package JAT
 */

get_header();
?>

	<main id="primary" class="site-main" style="background: url('<?php echo get_template_directory_uri() . '/img/fundo_jat.jpg'; ?>') no-repeat; background-size: cover;">
        <div class="container">
            <section class="error-404 not-found">
                <div id="notfound">
                    <div class="notfound">
                        <div class="notfound-404">
                            <h1>404</h1>
                        </div>
                        <h2>Página não encontrada</h2>
                        <form class="notfound-search" action="<?php echo home_url('/'); ?>" method="get">
                            <input type="text" name="s" id="search" class="form-control" />
                            <button type="submit" class="btn btn-success">Pesquisar</button>
                        </form>
                        <a href="<?php echo home_url('/'); ?>"><i class="fas fa-angle-double-left"></i> Voltar pra homepage</a>
                    </div>
                </div>
            </section><!-- .error-404 -->
        </div>
	</main><!-- #main -->

<?php
get_footer();
