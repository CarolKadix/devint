<?php
/**
 * FORNECEDORES
 * Funções para os fornecedores
 * 
 * 
 */



/**
 * CSS de fornecedores
 * 
 */
add_action('wp_enqueue_scripts', 'devint_enqueue_fornecedores_styles');
function devint_enqueue_fornecedores_styles(){
	wp_enqueue_style('fornecedores-styles', DEVINT_URL. 'css/fornecedores-styles.css');
}

/**
 * Scripts de fornecedores: frontend
 * 
 */
add_action('wp_enqueue_scripts', 'devint_enqueue_fornecedores_scripts');
function devint_enqueue_fornecedores_scripts(){
	wp_enqueue_script('fornecedores-scripts', DEVINT_URL. 'js/fornecedores-scripts.js', null, 'jquery', true);
}

/**
 * Scripts de fornecedores: admin
 * 
 */
add_action('admin_enqueue_scripts', 'devint_enqueue_admin_fornecedores_scripts');
function devint_enqueue_admin_fornecedores_scripts( $hook ){
	wp_enqueue_script( 'fornecedores-admin-scripts', DEVINT_URL . 'js/fornecedores-admin-scripts.js' );
}

/**
 * Sempre puxar todos os itens da categoria
 * 
 */
add_filter( 'pre_get_posts', 'filter_pre_get_posts' );
function filter_pre_get_posts( $query ){
	
	if( !is_admin() && is_tax('fornecedor_categoria') && $query->is_main_query() ){
		$query->query_vars['posts_per_page'] = -1;
		$query->query_vars['orderby'] = 'title';
		$query->query_vars['order'] = 'ASC';
	}
	
	return $query;
}

function devint_fornecedores_list(){
	$fornecedores = new Fornecedores_List();
}

class Fornecedores_List {
	
	var $current_category = 0;
	
	var $items = array(
		'estados' => array(),
		'sem_estados' => array(),
	);
	
	function __construct(){
		if( is_tax('fornecedor_categoria') ){
			$this->lista_fornecedores();
		}
		else{
			$this->home();
		}
	}
	
	function home(){
		global $post;
		?>
		<div class="row">
			<div class="col-md-4">
				<?php $this->sidebar_categorias(); ?>
			</div>
			<div class="col-md-8">
				<div id="fornecedores-home">
					<h1>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio enim, molestie non, pretium ut</h1>
					<?php echo apply_filters('the_content', $post->post_content); ?>
					
					<div class="well">
						Sua empresa ainda não faz parte do nosso guia? <button type="button" class="btn btn-lg btn-info" data-toggle="modal" data-target="#myModal">CLIQUE AQUI</button>
					</div>
				</div>
			</div>
		</div>
		<?php
		$success = '<div class="alert-message message success alert alert-success" rel="success">Cadastro enviado com sucesso!</div>';

		$this->fornecedores_form();
	}
	
	function lista_fornecedores(){
		?>
		<div class="row">
			<div class="col-md-4">
				<?php $this->sidebar_categorias(); ?>
			</div>
			<div class="col-md-8">
				<?php $this->lista_fornecedores_destacados(); ?>
				<?php $this->lista_fornecedores_comuns(); ?>
			</div>
		</div>
		<?php
	}
	
	function sidebar_categorias(){
		$terms = get_terms('fornecedor_categoria', array('hide_empty' => false));
		?>
		<div class="row">
			<div class="col-md-10">
				<div id="sidebar-fornecedores-categorias">
					<h4>Selecione uma Categoria</h4>
					<ul>
						<?php
						foreach( $terms as $t ){
							$link = get_term_link($t, 'fornecedor_categoria');
							echo "<li><a href='{$link}'>{$t->name}</a></li>";
						}
						?>
					</ul>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
		<?php
	}
	
	function lista_fornecedores_destacados(){
		global $wp_query;
		$query = array(
			'post_type' => 'supplier',
			'post_status' => 'publish',
			'posts_per_page' => 6,
			'meta_key' => 'fornecedor_tipo',
			'meta_value' => 'destacado',
			'tax_query' => array(
				array(
					'taxonomy' => 'fornecedor_categoria',
					'field' => 'term_id',
					'terms' => $wp_query->queried_object->term_id,
				),
			),
			'orderby' => 'title',
			'order' => 'ASC',
		);
		$destacados = new WP_Query();
		$destacados->query($query);
		if( $destacados->posts ){
		?>
		<div id="fornecedores-lista-destacados">
			<h3>Veja as condições exclusivas</h3>
			<div class="row">
				<?php
				$two = 1;
				$three = 1;
				foreach( $destacados->posts as $post ){
					$metas = get_post_custom($post->ID);
					$post->metas = $this->set_metas($metas);
					$thumb = wp_get_attachment_image_src($post->metas['fornecedor_imagem'], 'full');
				?>
				<div class="col-md-4 col-sm-4 col-xs-6">
					<div class="fornecedor-destaque">
						<div class="fornecedor-destaque-header"><?php echo $post->metas['fornecedor_texto']; ?> <span class='triangle'></span></div>
						<div class="fornecedor-destaque-logo">
							<img src="<?php echo $thumb[0]; ?>" alt="" class="img-responsive" />
						</div>
						<div class="fornecedor-destaque-contato">
							<a href="<?php echo $post->metas['fornecedor_url']; ?>" target="_blank">Entre em contato</a>
						</div>
					</div>
				</div>
				<?php
					// Divisores para responsivo. Inclui um cleanner a cada X itens conforme o breakpoint
					if( $two == 2 ){ echo '<div class="destacados-divisor cleanner col-xs-12 visible-xs"></div>';$two = 1; } else { $two++; }
					if( $three == 3 ){ echo '<div class="destacados-divisor2 cleanner col-md-12 col-sm-12 hidden-xs"></div>';$three = 1; } else { $three++; }
				}
				?>
			</div>
		</div>
		<?php
		}
	}
	
	function busca_fornecedores_comuns(){
		global $wp_query, $post;
		if( have_posts() ){
			$estados = array();
			$sem_estados = array();
			while ( have_posts() ){
				the_post();
				$metas = get_post_custom($post->ID);
				$post->metas = $this->set_metas($metas);
				
				$ufs = wp_get_object_terms($post->ID, 'estado_fornecedor');
				if( !empty($ufs) ){
					foreach( $ufs as $uf ){
						$estados[$uf->name][] = $post;
					}
				}
				else{
					$sem_estados[] = $post;
				}
			}
			
			// separar as colunas, fornecedores COM estado
			foreach( $estados as $estado => $fornecedores ){
				$total = count($fornecedores);
				if($total > 3){
					$column_size = ceil(($total / 3));
					$columns = array_chunk($fornecedores, $column_size);
				}
				else{
					$columns = array();
					for( $i = 0; $i <= count($fornecedores) - 1; $i++ ){
						$columns[$i][] = $fornecedores[$i];
					}
				}
				$this->items['estados'][$estado] = $columns;
			}
			
			// separar as colunas, fornecedores SEM estado
			if( !empty($sem_estados) ){
				$total_sem_estados = count($sem_estados);
				if( $total_sem_estados > 3 ){
					$column_size = ceil(($total_sem_estados / 3));
					$columns = array_chunk($sem_estados, $column_size);
				}
				else{
					$columns = array();
					for( $i = 0; $i <= count($sem_estados) - 1; $i++ ){
						$columns[$i][] = $sem_estados[$i];
					}
				}
				$this->items['sem_estados'] = $columns;
			}
		}
		//pre($this->items, 'fornecedores comuns', false);
	}
	
	function exibe_fornecedores_comuns( $fornecedores ){
		foreach( $fornecedores as $fornecedor ){
			$link_text = str_replace('http://', '', $fornecedor->metas['fornecedor_url']);
		 ?>
		<div class="fornecedor-comum">
			<strong class='fornecedor-nome'><?php echo $fornecedor->post_title; ?></strong><br />
			<span class='fornecedor-info'><?php echo $fornecedor->metas['fornecedor_telefone']; ?> | <a href='<?php echo $fornecedor->metas['fornecedor_url']; ?>' target='_blank'><?php echo $link_text; ?></a></span>
		</div>
		<?php
		} 
	}
	
	function lista_fornecedores_comuns(){
		global $wp_query;
		$this->busca_fornecedores_comuns();
		?>
		<div id="fornecedores-lista-comuns">
			<h3>Veja mais fornecedores de <?php echo $wp_query->queried_object->name; ?></h3>
			
			<?php if(!empty($this->items['estados'])){ ?>
			<?php foreach( $this->items['estados'] as $estado => $columns ){ ?>
			<h4><?php echo $estado; ?></h4>
			<div class="row">
				<?php foreach( $columns as $column => $fornecedores ){ ?>
				<div class="col-md-4">
					<?php $this->exibe_fornecedores_comuns($fornecedores); ?>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
			<?php } ?>
			
			<?php if(!empty($this->items['sem_estados'])){ ?>
			<div class="row">
				<?php foreach( $this->items['sem_estados'] as $fornecedores ){ ?>
				<div class="col-md-4">
					<?php $this->exibe_fornecedores_comuns($fornecedores); ?>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
		<?php
	}
	
	function set_metas( $meta_values ){
		$meta_keys = array(
			'fornecedor_imagem',
			'fornecedor_texto',
			'fornecedor_url',
			'fornecedor_telefone',
			'fornecedor_email',
			'fornecedor_cidade',
		);
		$metas = array();
		foreach( $meta_keys as $key ){
			if( isset($meta_values[$key]) ){
				$metas[$key] = maybe_unserialize($meta_values[$key][0]);
			}
			else{
				$metas[$key] = '';
			}
		}
		return $metas;
	}
	
	function fornecedores_form(){
		?>
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<?php boros_frontend_form_output( 'devint_form_cadastro' ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	
}















