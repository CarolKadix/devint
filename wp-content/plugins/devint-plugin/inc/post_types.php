<?php
/**
 * POST-TYPES
 * Registro dos post-types do projeto.
 * 
 * 
 */

add_action( 'init', 'register_post_types' );
function register_post_types(){
	/**
	 * Eventos
	 * 
	 */
	$labels = array(
		'name' => 'Eventos',
		'singular_name' => 'Evento',
		'menu_name' => 'Eventos',
		'add_new' => 'Novo Evento',
		'add_new_item' => 'Adicionar Evento',
		'edit_item' => 'Editar Evento',
		'new_item' => 'Novo Evento',
		'view_item' => 'Ver Evento',
		'search_items' => 'Buscar Evento',
		'not_found' =>  'Nenhum encontrado',
		'not_found_in_trash' => 'Nenhum encontrado na lixeira',
		'parent_item_colon' => ''
	);
	$args = array(
		'labels' => $labels,
		'description' => 'Eventos',
		'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'show_in_nav_menus' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'has_archive' => false,
		'menu_icon' => 'dashicons-calendar',
		'supports' => array(
			'title',
			'editor',
		)
	); 
	register_post_type( 'evento' , $args );
	$columns_config = array(
		'post_type' => 'evento',
		'columns' => array(
			'cb' => '<input type="checkbox" />',
			'title' => 'Título',
		)
	);
	new BorosPostTypeColumns( $columns_config );
	
	/**
	 * Vídeos
	 * 
	 */
	$labels = array(
		'name' => 'Vídeos',
		'singular_name' => 'Vídeo',
		'menu_name' => 'Vídeos',
		'add_new' => 'Novo Vídeo',
		'add_new_item' => 'Adicionar Vídeo',
		'edit_item' => 'Editar Vídeo',
		'new_item' => 'Novo Vídeo',
		'view_item' => 'Ver Vídeo',
		'search_items' => 'Buscar Vídeo',
		'not_found' =>  'Nenhum encontrado',
		'not_found_in_trash' => 'Nenhum encontrado na lixeira',
		'parent_item_colon' => ''
	);
	$args = array(
		'labels' => $labels,
		'description' => 'Vídeos',
		'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'show_in_nav_menus' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'has_archive' => false,
		'menu_icon' => 'dashicons-video-alt3',
		'supports' => array(
			'title',
			'editor',
		)
	); 
	register_post_type( 'video' , $args );
	$columns_config = array(
		'post_type' => 'video',
		'columns' => array(
			'cb' => '<input type="checkbox" />',
			'title' => 'Título',
			'terms_video_categoria' => 'Categorias',
			'meta_video_url' => 'Vídeo',
		)
	);
	new BorosPostTypeColumns( $columns_config );
	
	/**
	 * Fornecedores
	 * 
	 */
	$labels = array(
		'name' => 'Fornecedores',
		'singular_name' => 'Fornecedor',
		'menu_name' => 'Fornecedores',
		'add_new' => 'Novo Fornecedor',
		'add_new_item' => 'Adicionar Fornecedor',
		'edit_item' => 'Editar Fornecedor',
		'new_item' => 'Novo Fornecedor',
		'view_item' => 'Ver Fornecedor',
		'search_items' => 'Buscar Fornecedor',
		'not_found' =>  'Nenhum encontrado',
		'not_found_in_trash' => 'Nenhum encontrado na lixeira',
		'parent_item_colon' => ''
	);
	$args = array(
		'labels' => $labels,
		'description' => 'Fornecedores',
		'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'show_in_nav_menus' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'has_archive' => false,
		'menu_icon' => 'dashicons-groups',
		'supports' => array(
			'title',
		)
	); 
	register_post_type( 'supplier' , $args );
	$columns_config = array(
		'post_type' => 'supplier',
		'columns' => array(
			'cb' => '<input type="checkbox" />',
			'title' => 'Título',
			'terms_fornecedor_categoria' => 'Categoria',
			'terms_estado_fornecedor' => 'Estado',
			'function_fornecedor_logo' => 'Logo',
		)
	);
	new BorosPostTypeColumns( $columns_config );
	
}

function fornecedor_logo( $post_type, $post ){
	//pre(func_get_args());
	$thumb = get_post_meta( $post->ID, 'fornecedor_imagem', true );
	if( !empty($thumb) ){
		$thumb_src = wp_get_attachment_image_src($thumb, 'full');
		echo "<img src='{$thumb_src[0]}' alt='' />";
	}
}


