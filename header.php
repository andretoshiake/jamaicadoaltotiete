<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package JAT
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo get_template_directory_uri() . '/img/favicon.ico'; ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'jat' ); ?></a>
	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$jat_description = get_bloginfo( 'description', 'display' );
			if ( $jat_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $jat_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->
        
        <nav class="site-navigation navbar navbar-expand-lg navbar-light" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <a class="navbar-brand" href="<?php echo home_url(); ?>">
                    <img src="<?php echo get_template_directory_uri() . '/img/jamaica.png'; ?>" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar" aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <?php
                    wp_nav_menu( array(
                        'theme_location' => 'menu-1',
                        'depth' => 2,
                        'container' => 'div',
                        'container_class' => 'collapse navbar-collapse justify-content-md-center',
                        'container_id' => 'main-navbar',
                        'menu_id' => 'primary-menu',
                        'menu_class' => 'nav navbar-nav',
                        'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
                        'walker' => new WP_Bootstrap_Navwalker())
                    );
                ?>
            </div>
        </nav><!-- #site-navigation -->
	</header><!-- #masthead -->
