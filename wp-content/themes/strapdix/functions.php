<?php
if( !function_exists('devdmbootstrap3_main_content_width') ){
function devdmbootstrap3_main_content_width(){
	
}
}

////////////////////////////////////////////////////////////////////
// Theme Information
////////////////////////////////////////////////////////////////////

    $themename = "DevDmBootstrap3";
    $developer_uri = "http://devdm.com";
    $shortname = "dm";
    $version = '1.50';
    load_theme_textdomain( 'devdmbootstrap3', get_template_directory() . '/languages' );
    $copyright_text = '..';


////////////////////////////////////////////////////////////////////
// include Theme-options.php for Admin Theme settings
////////////////////////////////////////////////////////////////////

   include 'theme-options.php';


////////////////////////////////////////////////////////////////////
// Enqueue Styles (normal style.css and bootstrap.css)
////////////////////////////////////////////////////////////////////
    function devdmbootstrap3_theme_stylesheets()
    {
        wp_register_style('bootstrap.css', get_template_directory_uri() . '/css/bootstrap.css', array(), '1', 'all' );
        wp_enqueue_style( 'bootstrap.css');
        wp_enqueue_style( 'stylesheet', get_stylesheet_uri(), array(), '1', 'all' );
    }
    add_action('wp_enqueue_scripts', 'devdmbootstrap3_theme_stylesheets');

//Editor Style
add_editor_style('css/editor-style.css');

////////////////////////////////////////////////////////////////////
// Register Bootstrap JS with jquery
////////////////////////////////////////////////////////////////////
    function devdmbootstrap3_theme_js()
    {
        global $version;
        wp_enqueue_script('theme-js', get_template_directory_uri() . '/js/bootstrap.js',array( 'jquery' ),$version,true );
    }
    add_action('wp_enqueue_scripts', 'devdmbootstrap3_theme_js');

////////////////////////////////////////////////////////////////////
// Add Title Parameters
////////////////////////////////////////////////////////////////////

if(!function_exists('devdmbootstrap3_wp_title')) {

    function devdmbootstrap3_wp_title( $title, $sep ) { // Taken from Twenty Twelve 1.0
        global $paged, $page;

        if ( is_feed() )
            return $title;

        // Add the site name.
        $title .= get_bloginfo( 'name' );

        // Add the site description for the home/front page.
        $site_description = get_bloginfo( 'description', 'display' );
        if ( $site_description && ( is_home() || is_front_page() ) )
            $title = "$title $sep $site_description";

        // Add a page number if necessary.
        if ( $paged >= 2 || $page >= 2 )
            $title = "$title $sep " . sprintf( __( 'Page %s', 'devdmbootstrap3' ), max( $paged, $page ) );

        return $title;
    }
    add_filter( 'wp_title', 'devdmbootstrap3_wp_title', 10, 2 );

}


////////////////////////////////////////////////////////////////////
// Register Custom Navigation Walker include custom menu widget to use walkerclass
////////////////////////////////////////////////////////////////////

    require_once('lib/wp_bootstrap_navwalker.php');
    require_once('lib/bootstrap-custom-menu-widget.php');

////////////////////////////////////////////////////////////////////
// Register Menus
////////////////////////////////////////////////////////////////////

        register_nav_menus(
            array(
                'main_menu' => 'Menu Topo 1',
                'main2_menu' => 'Menu Topo 2',
                'footer_menu' => 'Footer Menu',               
                'sobre_menu' => 'Sobre Menu'

            )
        );
        

////////////////////////////////////////////////////////////////////
// Register the Sidebar(s)
////////////////////////////////////////////////////////////////////

         register_sidebar(
            array(
            'name' => 'Home',
            'id' => 'home-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ));

        register_sidebar(
            array(
            'name' => 'Publicações',
            'id' => 'publicacoes-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        )); 


        register_sidebar(
            array(
            'name' => 'Right',
            'id' => 'right-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ));

        register_sidebar(
            array(
            'name' => 'Left',
            'id' => 'left-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ));

         register_sidebar(
            array(
            'name' => 'Footer',
            'id' => 'footer-sidebar',
            'before_widget' => '<aside id="%1$s" class="col-md-2 widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h5>',
            'after_title' => '</h5>',
        ));

////////////////////////////////////////////////////////////////////
// Add support for a featured image and the size
////////////////////////////////////////////////////////////////////

    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size(276,250, true); /*default*/

        add_image_size( 'single', 778, 360, true);     
        add_image_size( 'default', 276, 250, true);     
        add_image_size( 'destaque-first', 587, 365, true );   
        add_image_size( 'destaques', 588, 180, true ); 
        add_image_size( 'relacionados', 245, 220, true );   

////////////////////////////////////////////////////////////////////
// MAIS VISUALIZADOS
////////////////////////////////////////////////////////////////////
    function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
    }
    function setPostViews($postID) {
        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if($count==''){
            $count = 0;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
        }else{
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }

   
////////////////////////////////////////////////////////////////////
// Adds RSS feed links to for posts and comments.
////////////////////////////////////////////////////////////////////

    add_theme_support( 'automatic-feed-links' );


////////////////////////////////////////////////////////////////////
// Set Content Width
////////////////////////////////////////////////////////////////////

if ( ! isset( $content_width ) ) $content_width = 800;

///////////////////////////////////////////////////////////////////
// Custom Excerpt by Kadix
////////////////////////////////////////////////////////////////////

function excerpt1($limit) {
$excerpt1 = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt1)>=$limit) {
    array_pop($excerpt1);
    $excerpt1 = implode(" ",$excerpt1).'';
    } else {
    $excerpt1 = implode(" ",$excerpt1);
    }
    $excerpt1 = preg_replace('`\[[^\]]*\]`','',$excerpt1);
    return $excerpt1;
}

function excerpt2($limit) {
$excerpt2 = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt2)>=$limit) {
    array_pop($excerpt2);
    $excerpt2 = implode(" ",$excerpt2).'...';
    } else {
    $excerpt2 = implode(" ",$excerpt2);
    }
    $excerpt2 = preg_replace('`\[[^\]]*\]`','',$excerpt2);
    return $excerpt2;
}
function excerpt3($limit) {
    $excerpt3 = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt3)>=$limit) {
    array_pop($excerpt3);
    $excerpt3 = implode(" ",$excerpt3).'<br/><a href="'.get_permalink().'" class="btn btn-default " href="#" role="button">Leia Mais</a>';
    } else {
    $excerpt3 = implode(" ",$excerpt3);
    }
    $excerpt3 = preg_replace('`\[[^\]]*\]`','',$excerpt3);
    return $excerpt3;
    }

///////////////////////////////////////////////////////////////////
// PAGINACAO
////////////////////////////////////////////////////////////////////
 

///////////////////////////////////////////////////////////////////
// COMENTARIOS
////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////
// ADMIN
////////////////////////////////////////////////////////////////////
 

///////////////////////////////////////////////////////////////////
// ACF 
////////////////////////////////////////////////////////////////////
   define( 'ACF_LITE', true );
   include_once('advanced-custom-fields/acf.php');
   
        /* ACF EXPORT FIELDS */
        if(function_exists("register_field_group"))
        {
            register_field_group(array (
                'id' => 'acf_detalhes-do-anunciante',
                'title' => 'detalhes do anunciante',
                'fields' => array (
                    array (
                        'key' => 'field_54f52c366693e',
                        'label' => 'Tipo de fornecedor',
                        'name' => 'tipo',
                        'type' => 'radio',
                        'choices' => array (
                            'destacado' => 'destacado',
                            'comum' => 'comum',
                        ),
                        'other_choice' => 0,
                        'save_other_choice' => 0,
                        'default_value' => 'comum',
                        'layout' => 'horizontal',
                    ),
                    array (
                        'key' => 'field_54f52c056693d',
                        'label' => 'Destacado',
                        'name' => '',
                        'type' => 'tab',
                        'conditional_logic' => array (
                            'status' => 1,
                            'rules' => array (
                                array (
                                    'field' => 'field_54f52c366693e',
                                    'operator' => '==',
                                    'value' => 'destacado',
                                ),
                            ),
                            'allorany' => 'all',
                        ),
                    ),
                    array (
                        'key' => 'field_54f518afcc957',
                        'label' => 'Texto promocional',
                        'name' => 'texto_promocional',
                        'type' => 'textarea',
                        'required' => 1,
                        'default_value' => '',
                        'placeholder' => '',
                        'maxlength' => 45,
                        'rows' => 2,
                        'formatting' => 'br',
                    ),
                    array (
                        'key' => 'field_54f518d5cc958',
                        'label' => 'Logotipo',
                        'name' => 'logo_fornecedor',
                        'type' => 'image',
                        'required' => 1,
                        'save_format' => 'object',
                        'preview_size' => 'thumbnail',
                        'library' => 'all',
                    ),
                    array (
                        'key' => 'field_54f51864cc956',
                        'label' => 'URL',
                        'name' => 'url_fornecedor_destaque',
                        'type' => 'text',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                    ),
                    array (
                        'key' => 'field_54f52c776693f',
                        'label' => 'Comum',
                        'name' => '',
                        'type' => 'tab',
                        'conditional_logic' => array (
                            'status' => 1,
                            'rules' => array (
                                array (
                                    'field' => 'field_54f52c366693e',
                                    'operator' => '==',
                                    'value' => 'comum',
                                ),
                            ),
                            'allorany' => 'all',
                        ),
                    ),
                    array (
                        'key' => 'field_54f52f5bcaa87',
                        'label' => 'URL',
                        'name' => 'url_comum',
                        'type' => 'text',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                    ),
                    array (
                        'key' => 'field_54f52f7acaa88',
                        'label' => 'Telefone',
                        'name' => 'telefone',
                        'type' => 'text',
                        'default_value' => '',
                        'placeholder' => '(11) 9 9999 99999',
                        'prepend' => 20,
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                    ),
                ),
                'location' => array (
                    array (
                        array (
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'fornecedor',
                            'order_no' => 0,
                            'group_no' => 0,
                        ),
                    ),
                ),
                'options' => array (
                    'position' => 'acf_after_title',
                    'layout' => 'default',
                    'hide_on_screen' => array (
                        0 => 'permalink',
                        1 => 'the_content',
                        2 => 'excerpt',
                        3 => 'custom_fields',
                        4 => 'discussion',
                        5 => 'comments',
                        6 => 'revisions',
                        7 => 'slug',
                        8 => 'author',
                        9 => 'format',
                        10 => 'featured_image',
                        11 => 'categories',
                        12 => 'tags',
                        13 => 'send-trackbacks',
                    ),
                ),
                'menu_order' => 0,
            ));
        }

?>