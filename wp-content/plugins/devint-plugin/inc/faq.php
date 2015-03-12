<?php
/**
 * FAQ
 * 
 * 
 */



/**
 * CSS de faq
 * 
 */
add_action('wp_enqueue_scripts', 'devint_enqueue_faq_styles');
function devint_enqueue_faq_styles(){
	wp_enqueue_style('faq-styles', DEVINT_URL. 'css/faq-styles.css');
}

/**
 * Scripts de faq: frontend
 * 
 */
add_action('wp_enqueue_scripts', 'devint_enqueue_faq_scripts');
function devint_enqueue_faq_scripts(){
	wp_enqueue_script('faq-scripts', DEVINT_URL. 'js/faq-scripts.js', null, 'jquery', true);
}

/**
 * Sempre puxar todos os itens da categoria
 * 
 */
add_filter( 'pre_get_posts', 'filter_faq_pre_get_posts' );
function filter_faq_pre_get_posts( $query ){
	
	//if( !is_admin() && is_tax('fornecedor_categoria') && $query->is_main_query() ){
	//	$query->query_vars['posts_per_page'] = -1;
	//	$query->query_vars['orderby'] = 'title';
	//	$query->query_vars['order'] = 'ASC';
	//}
	
	return $query;
}

function devint_faq_sidebar(){
	$faq = Devint_Faq::init();
	$faq->show_sidebar();
}

function devint_faq_form(){
	$faq = Devint_Faq::init();
	$faq->show_form();
}

class Devint_Faq {
	
	var $current_category = 0;
	
	private static $instance;
	
	public static function init(){
		if( empty( self::$instance ) ){
			self::$instance = new Devint_Faq();
		}
		return self::$instance;
	}
	
	function __construct(){
		
	}
	
	function show_sidebar(){
		echo '#sidebar';
	}
	
	function show_form(){
		echo '#form';
	}
	
	
	
	
}















