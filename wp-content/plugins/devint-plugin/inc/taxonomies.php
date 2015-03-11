<?php
/**
 * ==================================================
 * REGISTER TAXONOMIES ==============================
 * ==================================================
 * 
 * 
 */
add_action('init', 'register_taxonomies');
function register_taxonomies(){
	/**
	MODELOS DE LABELS ================================
	
	GERAL
	$labels = array(
		'name' => 'Categorias',
		'singular_name' => 'Categoria',
		'search_items' => 'Buscar Categoria',
		'popular_items' => 'Categorias Populares',
		'all_items' => 'Todas as Categorias',
		'edit_item' => 'Editar Categoria',
		'update_item' => 'Atualizar Categoria',
		'add_new_item' => 'Adicionar nova Categoria',
		'new_item_name' => 'Nome da nova Categoria',
	);
	
	HIERARCHICAL
	$labels = array(
		// >>> hierarchical labels
		'parent_item' => 'Categoria Mãe',
		'parent_item_colon' => 'Categoria Mãe:',
	);
	NON-HIERARCHICAL
	$labels = array(
		// >>> NON hierarchical labels
		'separate_items_with_commas' => 'Separar Categorias com vírgulas',
		'add_or_remove_items' => 'Adicionar ou remover Categorias',
		'choose_from_most_used' => 'Selecionar das Categorias mais usadas',
	);
	 ==================================================
	*/



	/**
	 * CATEGORIAS DE EVENTO
	 * 
	 */
	$labels = array(
		'name' => 'Categorias de Evento',
		'singular_name' => 'Categoria de Evento',
		'search_items' => 'Buscar Categoria de Evento',
		'popular_items' => 'Categorias de Evento Populares',
		'all_items' => 'Todas as Categorias',
		'edit_item' => 'Editar Categoria de Evento',
		'update_item' => 'Atualizar Categoria de Evento',
		'add_new_item' => 'Adicionar nova Categoria de Evento',
		'new_item_name' => 'Nome da nova Categoria de Evento',
		// >>> hierarchical labels
		'parent_item' => 'Categoria de Evento Mãe',
		'parent_item_colon' => 'Categoria de Evento Mãe:',
	); 
	register_taxonomy('evento_categoria', array('evento'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'public' => true,
		'query_var' => 'evento_categoria',
		'capabilities' => array(
			'manage_terms' => 'manage_categories',
			'edit_terms'   => 'manage_categories',
			'delete_terms' => 'manage_categories',
			'assign_terms' => 'edit_posts',
		),
		'rewrite' => array(
			'slug' => 'categoria-eventos',
			'hierarchical' => true
		),
	));
	
	/**
	 * CATEGORIAS DE VÍDEO
	 * 
	 */
	$labels = array(
		'name' => 'Categorias de Vídeo',
		'singular_name' => 'Categoria de Vídeo',
		'search_items' => 'Buscar Categoria de Vídeo',
		'popular_items' => 'Categorias de Vídeo Populares',
		'all_items' => 'Todas as Categorias',
		'edit_item' => 'Editar Categoria de Vídeo',
		'update_item' => 'Atualizar Categoria de Vídeo',
		'add_new_item' => 'Adicionar nova Categoria de Vídeo',
		'new_item_name' => 'Nome da nova Categoria de Vídeo',
		// >>> hierarchical labels
		'parent_item' => 'Categoria de Vídeo Mãe',
		'parent_item_colon' => 'Categoria de Vídeo Mãe:',
	); 
	register_taxonomy('video_categoria', array('video'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'public' => true,
		'query_var' => 'video_categoria',
		'capabilities' => array(
			'manage_terms' => 'manage_categories',
			'edit_terms'   => 'manage_categories',
			'delete_terms' => 'manage_categories',
			'assign_terms' => 'edit_posts',
		),
		'rewrite' => array(
			'slug' => 'categoria-videos',
			'hierarchical' => true
		),
	));
	
	/**
	 * CATEGORIAS DE FORNECEDOR
	 * 
	 */
	$labels = array(
		'name' => 'Categorias de Fornecedor',
		'singular_name' => 'Categoria de Fornecedor',
		'search_items' => 'Buscar Categoria de Fornecedor',
		'popular_items' => 'Categorias de Fornecedor Populares',
		'all_items' => 'Todas as Categorias',
		'edit_item' => 'Editar Categoria de Fornecedor',
		'update_item' => 'Atualizar Categoria de Fornecedor',
		'add_new_item' => 'Adicionar nova Categoria de Fornecedor',
		'new_item_name' => 'Nome da nova Categoria de Fornecedor',
		// >>> hierarchical labels
		'parent_item' => 'Categoria de Fornecedor Mãe',
		'parent_item_colon' => 'Categoria de Fornecedor Mãe:',
	); 
	register_taxonomy('fornecedor_categoria', array('supplier'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'public' => true,
		'query_var' => 'fornecedor_categoria',
		'capabilities' => array(
			'manage_terms' => 'manage_categories',
			'edit_terms'   => 'manage_categories',
			'delete_terms' => 'manage_categories',
			'assign_terms' => 'edit_posts',
		),
		'rewrite' => array(
			'slug' => 'categoria-fornecedores',
			'hierarchical' => true
		),
	));
	
	/**
	 * ESTADOS DO FORNECEDOR
	 * 
	 */
	$labels = array(
		'name' => 'Estados',
		'singular_name' => 'Estado',
		'search_items' => 'Buscar Estado',
		'popular_items' => 'Estados Populares',
		'all_items' => 'Todos os Estados',
		'edit_item' => 'Editar Estado',
		'update_item' => 'Atualizar Estado',
		'add_new_item' => 'Adicionar novo Estado',
		'new_item_name' => 'Nome da novo Estado',
		// >>> hierarchical labels
		'parent_item' => 'Estado relacionado',
		'parent_item_colon' => 'Estado relacionado:',
	); 
	register_taxonomy('estado_fornecedor', array('supplier'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'public' => true,
		'query_var' => 'estado_fornecedor',
		'capabilities' => array(
			'manage_terms' => 'manage_categories',
			'edit_terms'   => 'manage_categories',
			'delete_terms' => 'manage_categories',
			'assign_terms' => 'edit_posts',
		),
		'rewrite' => array(
			'slug' => 'estados-fornecedores',
			'hierarchical' => true
		),
	));
}



/**
 * ==================================================
 * TAXONOMY COLUMNS =================================
 * ==================================================
 * Configurar as colunas de listagem das taxonomias.
 * 
 * Colunas padrão:
<code>
'tax_name' = array(
	'cb' => <input type="checkbox" />,
	'name' => Nome,
	'description' => Descrição,
	'slug' => Slug,
	'posts' => Posts,
)
</code>
 * 
 * Existem dois modelos dinâmicos de chave pré-configurados:
 * - termmeta_{term_name} - faz a busca do termmeta correspondente e exibe em um span
 * - function_{function_name} - callback, com os parâmetros $taxonomy e $term_id
 * 
 * Lista de chaves customizadas
 * @TODO image, order
 * 
 */
//add_action('admin_init', 'my_taxonomy_columns');
function my_taxonomy_columns(){
	$columns = array(
		'category' => array(
			'cb' => '<input type="checkbox" />',
			'name' => 'Nome da Categoria',
			'term_color' => 'Cor',
			'posts' => 'Posts',
		),
	);
	new BorosTaxonomyColumns( $columns );
}

/**
 * Função callback de renderização de coluna
 * 
 */
//add_action( 'boros_custom_taxonomy_column', 'boros_custom_taxonomy_column', 10, 3 );
function boros_custom_taxonomy_column( $taxonomy, $term_id, $column_name ){
	if( $column_name == 'term_color' ){
		$colors = get_option('colors');
		$term_color = get_metadata( 'term', $term_id, 'term_color', true );
		if( !empty($term_color) ){
			//pal($term_color);
			$term_color = str_replace( 'bg-color-type-', '', $term_color );
			$color_name = $colors[$term_color]['color_name'];
			$color_code = $colors[$term_color]['color_code'];
			echo "<div style='width:25px;height:25px;background:{$color_code}'></div>{$color_name}";
		}
	}
}


