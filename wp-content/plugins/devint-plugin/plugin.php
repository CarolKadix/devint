<?php
/*
Plugin Name: Devint Plugin
Plugin URI: http://kadix.com.br/
Description: Plugin para personalizado para kadix.com.br
Version: 1.0.0
Author: Alex Koti
Author URI: http://alexkoti.com
License: GPL2
*/



/**
 * Include do plugin base
 * @link https://github.com/alexkoti/boros
 * Atualizações e suporte podem ser feitos pelo site do github.
 * 
 * 
 */
require_once('boros/boros.php');



/**
 * CONSTANTES
 */
define( 'DEVINT_DIR', plugin_dir_path(__FILE__) );
define( 'DEVINT_URL', plugins_url( '/', __FILE__ ) );
define( 'JQUERY_URL', get_bloginfo('template_url') . '/js/libs/jquery-1.9.1.min.js' );



/**
 * Includes
 * 
 */
include_once('inc/post_types.php');
include_once('inc/meta_boxes.php');
include_once('inc/taxonomies.php');
include_once('inc/eventos.php');
include_once('inc/videos.php');
include_once('inc/fornecedores.php');
include_once('inc/faq.php');
include_once('inc/widgets.php');
include_once('inc/frontend-forms.php');







