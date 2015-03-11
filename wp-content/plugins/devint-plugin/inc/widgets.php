<?php
/**
 * ==================================================
 * WIDGETS ==========================================
 * ==================================================
 * 
 * 
 */

add_action( 'widgets_init', 'add_custom_widgets' );
function add_custom_widgets(){
	register_widget('Devint_Event_Widget');
	register_widget('Devint_Video_Widget');
}

class Devint_Event_Widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'devint_event_widget',
			'Exibir Evento',
			array( 'description' => 'Mostrar um evento na sidebar', )
		);
	}
	
	public function widget( $args, $instance ) {
		//pre($args);
		echo $args['before_widget'];
		
		$evt = get_post($instance['evt']);
		$metas = get_post_custom($evt->ID);
		$evt->metas = $this->set_metas($metas);
		// categoria
		$terms = wp_get_post_terms( $evt->ID, 'evento_categoria' );
		$evt->evento_categoria = array();
		if( !empty($terms) ){
			foreach( $terms as $t ){
				$evt->evento_categoria[] = $t;
			}
		}
		?>
		<div class="event-widget">
			<div class="event-widget-hat">
				Próximo Evento
				<div class="event-widget-hat-triangle"></div>
			</div>
			<div class="event-widget-head">
				<h4><span><?php echo $evt->evento_categoria[0]->name; ?></span> <?php echo apply_filters('the_content', $evt->post_title); ?></h4>
			</div>
			<div class="widget-event-body">
				<div class="event-widget-item event-widget-date"><?php echo apply_filters('the_content', $evt->metas['event_date_string']) ?></div>
				<div class="event-widget-item event-widget-location">
					<strong><?php echo $evt->metas['event_location_name']; ?></strong><br />
					<?php echo $evt->metas['event_location_address']; ?>
				</div>
				<div class="event-widget-item event-widget-price"><?php echo $evt->metas['event_price']; ?></div>
				<div class="event-widget-item event-widget-ticket"><a href="<?php echo $evt->metas['event_ticket_url']; ?>" target="_blank">Faça sua inscrição</a></div>
			</div>
		</div>
		<?php
		echo $args['after_widget'];
	}
	
	public function form( $instance ) {
		$evt = ! empty( $instance['evt'] ) ? $instance['evt'] : 0;
		
		$query = array(
			'post_type' => 'evento',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'orderby' => 'date',
			'order' => 'ASC',
		);
		$all_events = new WP_Query($query);
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'evt' ); ?>">Evento:</label> 
			<select name="<?php echo $this->get_field_name( 'evt' ); ?>" id="<?php echo $this->get_field_id( 'evt' ); ?>">
				<?php
				foreach( $all_events->posts as $event ){
					$selected = selected($evt, $event->ID);
					echo "<option value='{$event->ID}' {$selected}>{$event->post_title}</option>";
				}
				?>
			</select>
		</p>
		<?php 
	}
	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['evt'] = ( ! empty( $new_instance['evt'] ) ) ? $new_instance['evt'] : 0;
		return $instance;
	}
	
	function set_metas( $meta_values ){
		$meta_keys = array(
			'event_excerpt',
			'event_date_string',
			'event_date',
			'event_start',
			'event_end',
			'event_location_name',
			'event_location_address',
			'event_location_address_excerpt',
			'event_price',
			'event_ticket_url',
		);
		$metas = array();
		foreach( $meta_keys as $key ){
			$metas[$key] = maybe_unserialize($meta_values[$key][0]);
		}
		return $metas;
	}
}

class Devint_Video_Widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'devint_video_widget',
			'Exibir Vídeo',
			array( 'description' => 'Mostrar um vídeo na sidebar', )
		);
	}
	
	public function widget( $args, $instance ) {
		//pre($args);
		echo $args['before_widget'];
		
		require_once( ABSPATH . WPINC . '/class-oembed.php' );
		$oembed = _wp_oembed_get_object();
		
		
		$query = array(
			'post_type' => 'video',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'tax_query' => array(
				array(
					'taxonomy' => 'video_categoria',
					'field' => 'term_id',
					'terms' => $instance['term_id'],
				),
			),
		);
		$video = new WP_Query($query);
		if( $video->posts ){
			$video_url = get_post_meta($video->posts[0]->ID, 'video_url', true);
			if( !empty($video_url) ){
				$video_iframe = $oembed->get_html($video_url);
				$doc = new DOMDocument();
				$doc->loadHTML($video_iframe);
				$iframes = $doc->getElementsByTagName('iframe');
				foreach($iframes as $tag) {
					$v = $tag->getAttribute('src');
					$query_arg = array(
						'autohide' => true,
						'controls' => false,
						'modestbranding' => false,
						'showinfo' => false,
					);
					$v = add_query_arg($query_arg, $v);
					$tag->setAttribute('src', $v);
				}
				?>
				<div class="video-widget">
					<div class="video-widget-hat">
						MeuSite TV
						<div class="video-widget-hat-triangle"></div>
					</div>
					<div class="widget-video-body">
						<div class="video-widget-title">
							<h4><?php echo apply_filters('the_title', $video->posts[0]->post_title); ?></h4>
						</div>
						<div class="videoWrapper">
							<?php echo $doc->saveHTML(); ?>
						</div>
					</div>
				</div>
				<?php
			}
		}
		echo $args['after_widget'];
	}
	
	public function form( $instance ) {
		$term_id = ! empty( $instance['term_id'] ) ? $instance['term_id'] : 0;
		
		$terms = get_terms('video_categoria', array('hide_empty' => false));
		?>
		<p>Será exibido o último vídeo publicado na categoria: <br />
			<label for="<?php echo $this->get_field_id( 'term_id' ); ?>">Categoria:</label> 
			<select name="<?php echo $this->get_field_name( 'term_id' ); ?>" id="<?php echo $this->get_field_id( 'term_id' ); ?>">
				<?php
				foreach( $terms as $t ){
					$selected = selected($term_id, $t->term_id);
					echo "<option value='{$t->term_id}' {$selected}>{$t->name}</option>";
				}
				?>
			</select>
		</p>
		<?php 
	}
	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['term_id'] = ( ! empty( $new_instance['term_id'] ) ) ? $new_instance['term_id'] : 0;
		return $instance;
	}
}


