<?php
/**
 * VÍDEOS
 * 
 * 
 * 
 */



/**
 * CSS de vídeos
 * 
 */
add_action('wp_enqueue_scripts', 'devint_enqueue_video_styles');
function devint_enqueue_video_styles(){
	wp_enqueue_style('video-styles', DEVINT_URL. 'css/video-styles.css');
}

/**
 * Scripts de vídeos
 * 
 */
add_action('wp_enqueue_scripts', 'devint_enqueue_video_scripts');
function devint_enqueue_video_scripts(){
	wp_enqueue_script('video-scripts', DEVINT_URL. 'js/video-scripts.js', null, 'jquery', true);
}

/**
 * Image sizes
 * 
 */
add_image_size( 'video_thumbnail', 500, 281, true ); // proporção 1:1.78

/**
 * Classe para exibição dos vídeos
 * 
 */
class Canal_Videos {
	
	var $videos = array();
	
	var $video_categories;
	
	function __construct(){
		
	}
	
	function get_video_categories(){
		if( empty($this->video_categories) ){
			$this->video_categories = get_terms('video_categoria', array('hide_empty' => false));
		}
		return $this->video_categories;
	}
	
	function get_tabs(){
		$cats = $this->get_video_categories();
		?>
		<ul class="row nav nav-tabs" role="tablist" id="video-tabs">
			<?php
			$i = 1;
			foreach( $cats as $c ){
				$class = ($i == 1) ? 'col-md-2 active' : 'col-md-2';
				echo "<li class='{$class}'><a href='#tab{$i}' role='tab' data-toggle='tab'>{$c->name} <span class='triangle'></span></a></li>";
				$i++;
			}
			?>
		</ul>
		<?php
	}
	
	function get_panels(){
		$this->get_panel_videos();
		?>
		<div class="tab-content" id="video-tabs-contents">
			<?php foreach( $this->videos as $panel_id => $panel ){ ?>
			
			<div role="tabpanel" class="<?php echo $panel['class']; ?>" id="tab<?php echo $panel['id']; ?>">
				<?php foreach( $panel['itens'] as $row => $videos ){ ?>
				
				<div class="row">
					<?php foreach( $videos as $video ){ ?>
					
					<div class="<?php echo $video['class']; ?>" data-video-src="<?php echo $video['video']; ?>" data-video-category="<?php echo $panel['categoria']; ?>">
						<div class="video-thumb video-action">
							<div class="overlay">ASSISTINDO AGORA</div>
							<img src="<?php echo $video['thumb']; ?>" class="img-responsive" alt="" />
						</div>
						<h3 class="video-action"><?php echo $video['title']; ?></h3>
						<div class="video-date"><?php echo $video['date']; ?></div>
						<div class="video-desc"><?php echo apply_filters('the_content', $video['desc']); ?></div>
					</div>
					
					<?php } ?>
				</div>
				
				<?php } ?>
			</div>
			
			<?php } ?>
		</div>
		<?php
	}
	
	function get_panel_videos(){
		require_once( ABSPATH . WPINC . '/class-oembed.php' );
		$oembed = _wp_oembed_get_object();
		
		
		global $post;
		$cats = $this->get_video_categories();
		$i = 1;
		foreach( $cats as $c ){
			$this->videos[$c->term_id] = array();
			$this->videos[$c->term_id]['id'] = $i;
			$this->videos[$c->term_id]['categoria'] = $c->name;
			$this->videos[$c->term_id]['class'] = ($i == 1) ? 'tab-pane active' : 'tab-pane fade';
			
			$query = array(
				'post_type' => 'video',
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'tax_query' => array(
					array(
						'taxonomy' => 'video_categoria',
						'field' => 'term_id',
						'terms' => $c->term_id,
					)
				),
			);
			$videos = new WP_Query();
			$videos->query($query);
			if( $videos->posts ){
				$cat_videos = array();
				$u = 1;
				foreach( $videos->posts as $post ){
					setup_postdata( $post );
					$thumb = DEVINT_URL . 'images/video-thumb-placeholder.png';
					//$_thumbnail_id = get_post_meta($post->ID, '_thumbnail_id', true);
					//if( !empty($_thumbnail_id) ){
					//	$thumb_src = wp_get_attachment_image_src($_thumbnail_id, 'video_thumbnail');
					//	$thumb = $thumb_src[0];
					//}
					
					$v = get_post_meta($post->ID, 'video_url', true);
					if( !empty($v) ){
						$provider = $oembed->get_provider($v);
						$video_oembed = $oembed->fetch($provider, $v);
						$video_iframe = $video_oembed->html;
						$thumb = $video_oembed->thumbnail_url;
						$doc = new DOMDocument();
						$doc->loadHTML($video_iframe);
						$iframes = $doc->getElementsByTagName('iframe');
						foreach($iframes as $tag) {
							$v = $tag->getAttribute('src');
						}
					}
					
					$video = array(
						'title' => get_the_title(),
						'thumb' => $thumb,
						'video' => $v,
						'date' => get_the_time('j \d\e F \d\e Y'),
						'desc' => boros_excerpt_letters($post->post_content, 230),
						'class' => 'col-md-3 video-item',
					);
					if( $i == 1 && $u == 1 ){
						$video['class'] = 'col-md-3 video-item playing';
					}
					$cat_videos[] = $video;
					$u++;
				}
				$this->videos[$c->term_id]['itens'] = array_chunk($cat_videos, 4);
			}
			wp_reset_postdata();
			$i++;
		}
		//pre($this->videos, 'videos', false);
	}
	
	function output_featured_video(){
		$cats = $this->get_video_categories();
		$query = array(
			'post_type' => 'video',
			'post_status' => 'publish',
			'posts_per_page' => 1,
			'tax_query' => array(
				array(
					'taxonomy' => 'video_categoria',
					'field' => 'term_id',
					'terms' => $cats[0]->term_id,
				)
			),
		);
		$last_video = new WP_Query();
		$last_video->query($query);
		
		$cats = wp_get_post_terms($last_video->posts[0]->ID, 'video_categoria');
		?>
		<div class="row">
			<div class="col-md-7" id="column-video-large">
				<div id="video-large-embed">
					<div id="video-large-embed-inner">
						<?php
						$video_url = get_post_meta($last_video->posts[0]->ID, 'video_url', true);
						echo apply_filters('the_content', $video_url);
						?>
					</div>
				</div>
			</div>
			<div class="col-md-5">
				<h3 id="video-large-title"><?php echo apply_filters('the_title', $last_video->posts[0]->post_title); ?></h3>
				<p id="video-large-date" class="video-date">Postado em 25 de novembro de 2014</p>
				<p id="video-large-category" class="video-category"><?php echo $cats[0]->name; ?></p>
				<div id="video-large-desc"><?php echo apply_filters('the_content', boros_excerpt_letters($last_video->posts[0]->post_content, 230)); ?></div>
				<div class="share"></div>
			</div>
		</div>
		<?php
	}
	
	function output_video_grid(){
		$cats = $this->get_video_categories();
		?>
		<div class="row" id="video-grid">
			<div class="col-md-4">BANNERS</div>
			<div class="col-md-8">
				<div class="col-md-12">
					<div role="tabpanel">
						<?php $this->get_tabs(); ?>
						<?php $this->get_panels(); ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	
}














