<?php
/**
 * JAT functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package JAT
 */

if ( ! defined( '_S_VERSION' ) ) {
    // Replace the version number of the theme on each release.
    define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'jat_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function jat_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on JAT, use a find and replace
         * to change 'jat' to the name of your theme in all the template files.
         */
        load_theme_textdomain( 'jat', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support( 'post-thumbnails' );

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(
            array(
                'menu-1' => esc_html__( 'Primary', 'jat' ),
            )
        );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            )
        );

        // Set up the WordPress core custom background feature.
        add_theme_support(
            'custom-background',
            apply_filters(
                'jat_custom_background_args',
                array(
                    'default-color' => 'ffffff',
                    'default-image' => '',
                )
            )
        );

        // Add theme support for selective refresh for widgets.
        add_theme_support( 'customize-selective-refresh-widgets' );

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support(
            'custom-logo',
            array(
                'height'      => 250,
                'width'       => 250,
                'flex-width'  => true,
                'flex-height' => true,
            )
        );
    }
endif;
add_action( 'after_setup_theme', 'jat_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function jat_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'jat_content_width', 640 );
}
add_action( 'after_setup_theme', 'jat_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function jat_widgets_init() {
    register_sidebar(
        array(
            'name'          => esc_html__( 'Sidebar', 'jat' ),
            'id'            => 'sidebar-1',
            'description'   => esc_html__( 'Add widgets here.', 'jat' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action( 'widgets_init', 'jat_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function jat_scripts() {
    wp_enqueue_style( 'jat-style', get_stylesheet_uri(), array(), _S_VERSION );
    wp_enqueue_style( 'jat-theme-style', get_template_directory_uri() . '/css/theme.css', array(), _S_VERSION );
    // wp_enqueue_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@4.1.0/dist/css/bootstrap.min.css', array(), _S_VERSION );
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap/bootstrap.css', array(), _S_VERSION );
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), _S_VERSION );
    wp_enqueue_style( 'selectpicker', 'https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css', array(), _S_VERSION );
    wp_style_add_data( 'jat-style', 'rtl', 'replace' );
    
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'jat-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
    // wp_enqueue_script( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@4.1.0/dist/js/bootstrap.bundle.min.js', array(), _S_VERSION, true );
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap/bootstrap.bundle.min.js', array(), _S_VERSION, true );
    wp_enqueue_script( 'selectpicker', 'https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js', array(), _S_VERSION, true );
    wp_enqueue_script( 'jat-scripts', get_template_directory_uri() . '/js/scripts.js', array(), _S_VERSION, true );
    
    $script_data = array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'view_match_info' ),
    );
    
    wp_localize_script( 'jat-scripts', 'jat_ajax_object', $script_data );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'jat_scripts' );

/**
 * Custom Sidebars
 */
function register_theme_sidebars(){
    register_sidebar([
      'name'           => 'JAT Sidebar 1',
      'id'             => 'jat-sidebar-1',
      'description'    => 'Sidebar 1',
      'before_widget'  => '<aside>',
      'after_widget'   => '</aside>',
      'before_title'   => '<h3>',
      'after_title'    => '</h3>'
    ]);
    register_sidebar([
      'name'           => 'JAT Sidebar 2',
      'id'             => 'jat-sidebar-2',
      'description'    => 'Sidebar 2',
      'before_widget'  => '<aside>',
      'after_widget'   => '</aside>',
      'before_title'   => '<h3>',
      'after_title'    => '</h3>'
    ]);
    register_sidebar([
      'name'           => 'JAT Sidebar 3',
      'id'             => 'jat-sidebar-3',
      'description'    => 'Sidebar 3',
      'before_widget'  => '<aside>',
      'after_widget'   => '</aside>',
      'before_title'   => '<h3>',
      'after_title'    => '</h3>'
    ]);
    register_sidebar([
      'name'           => 'JAT Sidebar 4',
      'id'             => 'jat-sidebar-4',
      'description'    => 'Sidebar 4',
      'before_widget'  => '<aside>',
      'after_widget'   => '</aside>',
      'before_title'   => '<h3>',
      'after_title'    => '</h3>'
    ]);
}
add_action('widgets_init', 'register_theme_sidebars');

/**
 * Custom Post Types
 */
function jat_register_custom_post_types() {
  // Banners
  $descBanner = array(
    'name'               => 'Banners',
    'singular_name'      => 'Banner',
    'add_new'            => 'Adicionar novo',
    'add_new_item'       => 'Adicionar banner',
    'edit_item'          => 'Editar banner',
    'new_item'           => 'Novo banner',
    'view_item'          => 'Visualizar banner',
    'search_items'       => 'Pesquisar banner',
    'not_found'          => 'Nenhum banner encontrado',
    'not_found_in_trash' => 'Nenhum banner na lixeira',
    'parent_item_colon'  => '',
    'menu_name'          => 'Banners',
    'all_items'          => 'Todos os banners'
  );
  $argsBanner = array(
    'labels'            => $descBanner,
    'public'            => true,
    'hierarchical'      => false,
    'menu_position'     => 11,
    'supports'          => array('title'),
    'menu_icon'         => 'dashicons-format-gallery'
  );
  register_post_type( 'banners' , $argsBanner );
    
  // Players
  $descPlayer = array(
    'name'               => 'Jogadores',
    'singular_name'      => 'Jogador',
    'add_new'            => 'Adicionar novo',
    'add_new_item'       => 'Adicionar jogador',
    'edit_item'          => 'Editar jogador',
    'new_item'           => 'Novo jogador',
    'view_item'          => 'Visualizar jogador',
    'search_items'       => 'Pesquisar jogador',
    'not_found'          => 'Nenhum jogador encontrado',
    'not_found_in_trash' => 'Nenhum jogador na lixeira',
    'parent_item_colon'  => '',
    'menu_name'          => 'Jogadores',
    'all_items'          => 'Todos os banners'
  );
  $argsPlayer = array(
    'labels'            => $descPlayer,
    'public'            => true,
    'hierarchical'      => false,
    'has_archive'       => true,
    'menu_position'     => 12,
    'supports'          => array('title'),
    'menu_icon'         => 'dashicons-groups'
  );
  register_post_type( 'players' , $argsPlayer );
    
  // Matches
  $descMatch = array(
    'name'               => 'Jogos',
    'singular_name'      => 'Jogo',
    'add_new'            => 'Adicionar novo',
    'add_new_item'       => 'Adicionar jogo',
    'edit_item'          => 'Editar jogo',
    'new_item'           => 'Novo jogo',
    'view_item'          => 'Visualizar jogo',
    'search_items'       => 'Pesquisar jogo',
    'not_found'          => 'Nenhum jogo encontrado',
    'not_found_in_trash' => 'Nenhum jogo na lixeira',
    'parent_item_colon'  => '',
    'menu_name'          => 'Jogos',
    'all_items'          => 'Todos os jogos'
  );
  $argsMatch = array(
    'labels'            => $descMatch,
    'public'            => true,
    'hierarchical'      => false,
    'menu_position'     => 13,
    'supports'          => array('title'),
    'menu_icon'         => 'dashicons-awards'
  );
  register_post_type( 'matches' , $argsMatch );
    
  // Skills
  $descSkill = array(
    'name'               => 'Atributos',
    'singular_name'      => 'Atributos',
    'add_new'            => 'Adicionar atributos',
    'add_new_item'       => 'Adicionar atributos',
    'edit_item'          => 'Editar atributos',
    'new_item'           => 'Novo atributo',
    'view_item'          => 'Visualizar atributos',
    'search_items'       => 'Pesquisar atributos',
    'not_found'          => 'Nenhum atributo encontrado',
    'not_found_in_trash' => 'Nenhum atributo na lixeira',
    'parent_item_colon'  => '',
    'menu_name'          => 'Atributos',
    'all_items'          => 'Todos os atributos'
  );
  $argsSkill = array(
    'labels'            => $descSkill,
    'public'            => true,
    'hierarchical'      => false,
    'menu_position'     => 13,
    'supports'          => array('title'),
    'menu_icon'         => 'dashicons-star-filled'
  );
  register_post_type( 'skills' , $argsSkill );
    
  flush_rewrite_rules();
}
add_action('init', 'jat_register_custom_post_types');

function jat_register_custom_taxonomies() {
    $labels = array(
        'name'              => 'Temporadas',
        'singular_name'     => 'Temporada',
        'search_items'      => 'Pesquisar temporadas',
        'all_items'         => 'Todas as temporadas',
        'parent_item'       => 'Temporada - Nível Superior',
        'parent_item_colon' => 'Temporada - Nível Superior:',
        'edit_item'         => 'Editar temporada',
        'update_item'       => 'Atualizar temporada',
        'add_new_item'      => 'Adicionar temporada',
        'new_item_name'     => 'Novo nome da temporada',
        'menu_name'         => 'Temporadas',
    );
    $args   = array(
        'hierarchical'      => true, // make it hierarchical (like categories)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => [ 'slug' => 'season' ],
     );
     register_taxonomy( 'season', [ 'matches' ], $args );
}
add_action( 'init', 'jat_register_custom_taxonomies' );

function jat_save_post( $post_id ) {

    // Get newly saved values.
    $values = get_fields( $post_id );

    // Check the new value of a specific field.
    $hero_image = get_field('hero_image', $post_id);
    if( $hero_image ) {
        // Do something...
    }
}
// add_action('acf/save_post', 'jat_save_post');

/**
 * Custom Admin Columns
 */
function jat_filter_posts_columns( $columns ) {
    $columns = array(
      'cb'    => $columns['cb'],
      'title' => __( 'Title' ),
      'level'  => __( 'Highlight Level', 'jat' ),
      'date' => __( 'Date' ),
    );
    return $columns;
}
add_filter( 'manage_banners_posts_columns', 'jat_filter_posts_columns', );

function jat_banners_column( $column, $post_id ) {
    // Highlight Level column
    if ( 'level' === $column ) {
        $level = get_post_meta( $post_id, 'level', true );
        if ( ! $level ) {
            _e( 'n/a' );  
        } else {
            echo $level;
        }
    }
}
add_action( 'manage_banners_posts_custom_column', 'jat_banners_column', 10, 2);

function jat_banners_sortable_columns( $columns ) {
    $columns['level'] = 'level;';
    return $columns;
}
add_filter( 'manage_edit-banners_sortable_columns', 'jat_banners_sortable_columns');

function jat_posts_orderby( $query ) {
  if( ! is_admin() || ! $query->is_main_query() ) {
    return;
  }

  if ( 'level' === $query->get( 'orderby') ) {
    $query->set( 'orderby', 'meta_value' );
    $query->set( 'meta_key', 'level' );
  }
}
add_action( 'pre_get_posts', 'jat_posts_orderby' );

function filter_posts_by_level() {
    global $typenow;
    $level = $_GET['level'];

    if ($typenow !== 'banners'){
        return;
    }

    ?>
    <select name="level">
        <option value="">All highlight levels</option>
        <option <?php echo $level == 1 ? 'selected' : '' ?> value="1">Level 1</option>
        <option <?php echo $level == 2 ? 'selected' : '' ?> value="2">Level 2</option>
        <option <?php echo $level == 3 ? 'selected' : '' ?> value="3">Level 3</option>
    </select>
    <?php
}
add_action( 'restrict_manage_posts',  'filter_posts_by_level' );

function parse_query_filter_level($query) {
    global $pagenow;
    $post_type = 'banners';
    $q_vars    = &$query->query_vars;
    $level     = $_GET['level'];
    
    if (
        $pagenow == 'edit.php' &&
        isset($q_vars['post_type']) &&
        $q_vars['post_type'] == $post_type
    ) {
        $q_vars['meta_key'] = 'level';
        $q_vars['meta_value'] = $level;
    }
}
add_filter('parse_query', 'parse_query_filter_level');

/**
 * Register Custom Navigation Walker
 */
function register_navwalker(){
    require get_template_directory() . '/class-wp-bootstrap-navwalker.php';
}
add_action( 'after_setup_theme', 'register_navwalker' );

function jat_connection_types() {
    p2p_register_connection_type( array(
        'name' => 'matches_to_players',
        'from' => 'matches',
        'to' => 'players',
        // 'reciprocal' => true,
        // 'duplicate_connections' => true,
        'fields' => array(
            'goals' => array(
                'title' => __( 'Gols', 'jat' ),
                'type' => 'text',
            ),
            'assists' => array(
                'title' => __( 'Assistências', 'jat' ),
                'type' => 'text',
            ),
            'blocks' => array(
                'title' => __( 'Defesas', 'jat' ),
                'type' => 'text',
            ),
            'yellow_cards' => array(
                'title' => __( 'Cartões amarelos', 'jat' ),
                'type' => 'text',
            ),
            'red_cards' => array(
                'title' => __( 'Cartões vermelhos', 'jat' ),
                'type' => 'text',
            ),
            'clean_sheets' => array(
                'title' => __( 'Clean sheets', 'jat' ),
                'type' => 'checkbox',
            ),
        ),
        'admin_box' => array(
            'show' => 'from',
            'context' => 'advanced'
        ),
        'title' => array(
            'from' => __( 'Súmula', 'jat' )
        ),
        'from_labels' => array(
          'create' => __( 'Adicionar item', 'jat' ),
        ),
        'to_labels' => array(
          'create' => __( 'Adicionar item', 'jat' ),
        ),
    ) );
}
add_action( 'p2p_init', 'jat_connection_types' );

function jat_custom_admin_css() {
    global $pagenow;
    $post_type = get_post_type();
      
    if ( in_array($pagenow, array('post.php', 'post-new.php')) && 'matches' == $post_type ) {
        echo '<style>
            .p2p-connections .p2p-col-title {
                width: 30%;
            }
            .p2p-col-meta-clean_sheets {
                text-align: center;
            }
            a.acf-icon.dark {
                color: #555d66;
                background: #FFF;                
                height: 18px;
                width: 18px;
                border-radius: 9px;
                box-shadow: 0 0 3px rgb(0 0 0 / 30%);
                -webkit-transition: none;
                -moz-transition: none;
                -o-transition: none;
                transition: none;
                top: 5px !important;
                right: 5px !important;
            }
            a.acf-icon.dark:hover {
                background: #FFF;
            }
        </style>';
    }
}
add_action('admin_head', 'jat_custom_admin_css');

function jat_archive_template( $template ) {
    if ( 'season' == get_queried_object()->taxonomy ) {
        $template = dirname( __FILE__ ) . '/template-parts/content-season.php';
    }
    return $template;
}
add_filter( 'archive_template', 'jat_archive_template' ) ;

function jat_template_redirect() {
    global $wp;
    $current_url = home_url( add_query_arg( array(), $wp->request ) );
    $current_slug = add_query_arg( array(), $wp->request );

    if ( 'season' == $wp->request ) {
        $terms = get_terms( array(
            'taxonomy' => 'season',
            'order' => 'DESC',
            'number' => 1,
            'hide_empty' => false,
        ) );

        $redirect = $current_url.'/'.$terms[0]->slug;
        wp_redirect($redirect);
        exit();
    }
}
add_filter( 'template_redirect', 'jat_template_redirect' );
 
function jat_template_include( $template ) {
    global $wp;
    $current_url = home_url( add_query_arg( array(), $wp->request ) );
    $current_slug = add_query_arg( array(), $wp->request );
    
    if ( 'players' == $wp->request ) {
        $time = $_GET['time'];

        if ( $time == 1 || $time == 2 ) {
            $template = dirname($template) . '/template-parts/content-team' . $time . '.php';

            if ( $time == 2 ) {
                add_filter( 'document_title_parts', function($title_parts) {
                    $title_parts['title'] = "Rachão";
                    return $title_parts;
                });
            }

            status_header(200); // force status to 200 - OK
        } else {
            $redirect = $current_url.'/?time=1';
            wp_redirect($redirect);
            exit();
        }
    }
    
    return $template;
}
add_filter( 'template_include', 'jat_template_include' );

function jat_title_tag($title_parts) {
    global $template;
    
    if ( 'content-season.php' == basename($template) ) {
        $obj = get_queried_object();
        $title_parts['title'] = "Temporada ".$obj->slug;
    }
    
    return $title_parts;
}
add_filter( 'document_title_parts', 'jat_title_tag' );

function jat_excerpt_length($length){
    return 20;
}
add_filter('excerpt_length', 'jat_excerpt_length');

function load_match_info_ajax_callback() {
    check_ajax_referer('view_match_info', 'nonce');
    
    ob_start();
    $template = dirname(__FILE__) . '/inc/match-info.php';
    include $template;
    $contents = ob_get_contents();
    ob_end_clean();

    if ( $contents ) {
        echo $contents;
    } else {
        echo 0;
    }
     
    wp_die();
}
add_action('wp_ajax_load_match_info_ajax_callback', 'load_match_info_ajax_callback');
add_action('wp_ajax_nopriv_load_match_info_ajax_callback', 'load_match_info_ajax_callback');

function wiaw_pagenavi_to_bootstrap($html) {
    $out = '';
    $out = str_replace('<div','',$html);
    $out = str_replace('class=\'wp-pagenavi\' role=\'navigation\'>','',$out);
    $out = str_replace('<a','<li class="page-item"><a class="page-link"',$out);
    $out = str_replace('</a>','</a></li>',$out);
    $out = str_replace('<span aria-current=\'page\' class=\'current\'','<li aria-current="page" class="page-item active"><span class="page-link current"',$out);
    $out = str_replace('<span class=\'pages\'','<li class="page-item"><span class="page-link pages"',$out);
    $out = str_replace('<span class=\'extend\'','<li class="page-item"><span class="page-link extend"',$out);  
    $out = str_replace('</span>','</span></li>',$out);
    $out = str_replace('</div>','',$out);
    return '<ul class="pagination" role="navigation">'.$out.'</ul>';
}
add_filter( 'wp_pagenavi', 'wiaw_pagenavi_to_bootstrap', 10, 2 );

function search_filter($query) {
    if ( $query->is_search && !is_admin() ) {
        $query->set('post_type', 'post');
    }
    return $query;
}
add_filter('pre_get_posts','search_filter');

// Change posts per page in category/tag template
function cat_tag_posts_per_page( $query ) {
	if( $query->is_main_query() && (is_category() || is_tag()) && !is_admin() ) {
		$query->set( 'posts_per_page', '10' );
	}
}
// add_action( 'pre_get_posts', 'cat_tag_posts_per_page' );

/**
 * Menu BootStrap 5
 */
class bootstrap_5_wp_nav_menu_walker extends Walker_Nav_menu
{
    private $current_item;
    private $dropdown_menu_alignment_values = [
      'dropdown-menu-start',
      'dropdown-menu-end',
      'dropdown-menu-sm-start',
      'dropdown-menu-sm-end',
      'dropdown-menu-md-start',
      'dropdown-menu-md-end',
      'dropdown-menu-lg-start',
      'dropdown-menu-lg-end',
      'dropdown-menu-xl-start',
      'dropdown-menu-xl-end',
      'dropdown-menu-xxl-start',
      'dropdown-menu-xxl-end'
    ];

    function start_lvl(&$output, $depth = 0, $args = array())
    {
      $dropdown_menu_class[] = '';
      foreach($this->current_item->classes as $class) {
        if(in_array($class, $this->dropdown_menu_alignment_values)) {
          $dropdown_menu_class[] = $class;
        }
      }
      $indent = str_repeat("\t", $depth);
      $submenu = ($depth > 0) ? ' sub-menu' : '';
      $output .= "\n$indent<ul class=\"dropdown-menu$submenu " . esc_attr(implode(" ",$dropdown_menu_class)) . " depth_$depth\">\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
      $this->current_item = $item;
      $indent = ($depth) ? str_repeat("\t", $depth) : '';
      $li_attributes = '';
      $class_names = $value = '';
      $classes = empty($item->classes) ? array() : (array) $item->classes;
      $classes[] = ($args->walker->has_children) ? 'dropdown' : '';
      $classes[] = 'nav-item';
      $classes[] = 'nav-item-' . $item->ID;
      if ($depth && $args->walker->has_children) {
        $classes[] = 'dropdown-menu dropdown-menu-end';
      }
      $class_names =  join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
      $class_names = ' class="' . esc_attr($class_names) . '"';
      $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
      $id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';
      $output .= $indent . '<li ' . $id . $value . $class_names . $li_attributes . '>';
      $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
      $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
      $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
      $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
      $active_class = ($item->current || $item->current_item_ancestor) ? 'active' : '';
      $attributes .= ($args->walker->has_children) ? ' class="nav-link ' . $active_class . ' dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : ' class="nav-link ' . $active_class . '"';
      $item_output = $args->before;
      $item_output .= ($depth > 0) ? '<a class="dropdown-item"' . $attributes . '>' : '<a' . $attributes . '>';
      $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
      $item_output .= '</a>';
      $item_output .= $args->after;
      $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
    require get_template_directory() . '/inc/jetpack.php';
}

